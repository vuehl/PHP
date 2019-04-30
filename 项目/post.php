<?php
  global $_system;
 //在這里写上session_start() 這个是代表开始了SESSION超级权限
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','post');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //验证码判断还需要用到這个
  include ROOT_PATH.'includes/check.func.php';
 //這个是登录状态才能发帖子
 if(!isset($_COOKIE['username'])){
  _location('发帖前,请先登录','login.php');
 }
 //這个是写入数据库的部分的部分
 if($_GET['action']=='post'){
  if(!empty($_system['code'])){
    //先用验证码进行验证
  _check_code($_POST['yzm'],$_SESSION['code']); 
  }

  //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_post_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
    //在這里验证下第二次发表的时间相减,不能小于一分钟
    //_timed(time(),$_COOKIE['post_time'],60);這个是用COOKIE的方法
    //這个是用数据库的方法来写
    _timed(time(),$_rows['tg_post_time'],$_system['post']);
    //這个是唯一标识符通过了之后的操作,写入帖子
    $_clean=array();
    $_clean['username']=$_COOKIE['username'];
    $_clean['title']=_check_post_title($_POST['title']);
    $_clean['content']=_check_post_content($_POST['content'],2);
    $_clean=_mysql_string($_clean);
    //写入数据库表的部分
    _query("INSERT INTO tg_arcticle(
                                   tg_username,
                                   tg_title,
                                   tg_content,
                                   tg_date
                                   )
                             VALUES(
                                  '{$_clean['username']}',
                                  '{$_clean['title']}',
                                  '{$_clean['content']}',
                                    NOW()
                                   )");
    //這个是新增成功之后的部分,写入到数据库内
      if(_affected_rows()==1){
      //获取刚刚生成的ID,从数据库获取里面获取的AUTO_INCREMENT里面弄获取的ID
      $_clean['id']=mysql_insert_id();
       //這个是第一次发帖的时间,在上面要用到,用来限制1分钟发表一次
     //setcookie('post_time',time());
     //這个是用数据库的方法来写入数据库
      $_clean['time']=time();
     _query("UPDATE 
     	           tg_user 
     	       SET tg_post_time='{$_clean['time']}' 
     	     WHERE tg_username='{$_COOKIE['username']}'");
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你发帖成功','article.php?id='.$_clean['id']);
    //這个是验证码的清除
    _session_destroy();  
    }else {
       //关闭数据库
     _close();
   //返回到本页面
    _alert_back('发帖失败');
    //這个是验证码的用完之后的清除
   // _session_destroy();
    }
  }
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/post.js"></script>
<script type="text/javascript" src="js/code.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  
  <!--這个是注册界面的部分-->
  <div id="post">
  	<h2>发表帖子</h2>
  	<form method="post" action="?action=post" name="post">
    <!--這个是防止别人网站攻击,唯一性的东西,记住這里的值要跟$_SESSION的值在一起,否则会一直都不对-->
    <input type="hidden" name="uniqid" value="<?php echo $_uniqid;?>" />
    <!--這个input是隐藏字段-->
    <input type="hidden" name="action" value="register" />
  	<dl>
  		<dt>请认真填写以下信息</dt>
  		<dd>标  题:<input type="text" name="title" class="text" maxlength="40" />
  		(*必填,2-40位)
  		</dd>
      <dd id="q">贴  图:<a href="###">QQ贴图</a></dd>
      <dd>
      <!--這个是调用ubb的php界面-->
      <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
      <textarea name="content" rows="16"></textarea>
      </dd>
      <?php if(!empty($_system['code'])){?>
  		<dd>验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
      <?php };?>
      <input type="submit" class="submit" value="发表帖子" />
  		</dd>
  	</dl>
  	</form>
  </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>