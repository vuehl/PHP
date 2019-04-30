<?php
global $_system;
 //在這里写上session_start() 這个是代表开始了SESSION超级权限
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','article_modify');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //验证码判断还需要用到這个
  include ROOT_PATH.'includes/check.func.php';
 //這个是登录状态才能发帖子
 if(!isset($_COOKIE['username'])){
  _location('发帖前,请先登录','login.php');
 }
//修改帖子
if($_GET['action']=='modify'){
  if(!empty($_system['code'])){}
   //先用验证码进行验证
     _check_code($_POST['yzm'],$_SESSION['code']);
  }
  //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid 
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
   //开始接收数据
    $_clean=array();
    $_clean['id']=$_POST['id'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    $_clean=_mysql_string($_clean);
   //进行修改,楼主帖子的修改SQL语句
    _query("UPDATE tg_arcticle 
               SET tg_title='{$_clean['title']}',
                   tg_content='{$_clean['content']}',
                   tg_last_modify_date=NOW()
            WHERE  tg_id='{$_clean['id']}'");
    //這个是修改成功的时候,进行影响
    if(_affected_rows()==1){
   //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你修改成功','article.php?id='.$_clean['id']);
    //這个是验证码的清除
    //_session_destroy();  
    }else {
     //关闭数据库
     _close();
   //返回到本页面
    _alert_back('修改帖子失败');
    //這个是验证码的用完之后的清除
    //_session_destroy();
    }
  }else {
    _alert_back('唯一标识符不正确');
  }
}
//读取数据
 if(isset($_GET['id'])){
  if(!!$_rows=_fetch_array("SELECT tg_id,
                                   tg_title,
                                   tg_content,
                                   tg_username
                              FROM tg_arcticle
                             WHERE tg_reid=0
                             AND   tg_id='{$_GET['id']}'
                              ")){
    //這个是显示帖子的部分
    $_html=array();
    //這个是从数据库获取的id,然后传到页面的隐藏字段里,用来接收时候的调用
    $_html['id']=$_rows['tg_id']; 
    $_html['title']=$_rows['tg_title'];
    $_html['username']=$_rows['tg_username'];
    $_html['content']=$_rows['tg_content'];
    $_html=_html($_html);
    //判断权限,就是在上面的id修改时,就不能修改了
    if($_COOKIE['username']!=$_html['username']){
    _alert_back('你没有权限修改');
    }
   }else {
  _alert_back('该帖子已经被删除');
   }
   }else {
  _alert_back('非法操作');
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
  	<h2>修改帖子</h2>
  	<form method="post" action="?action=modify" name="post">
    <!--這个是防止别人网站攻击,唯一性的东西,记住這里的值要跟$_SESSION的值在一起,否则会一直都不对-->
    <input type="hidden" name="uniqid" value="<?php echo $_uniqid;?>" />
    <!--這个input是隐藏字段-->
    <input type="hidden" name="action" value="register" />
    <!--這个是获取网页传过来的ID-->
    <input type="hidden" name="id" value="<?php echo $_html['id'];?>" />
  	<dl>
  		<dt>请认真修改以下信息</dt>
  		<dd>标  题:<input type="text" name="title" 
      value="<?php echo $_html['title']?>" class="text" maxlength="40" />
  		(*必填,2-40位)
  		</dd>
      <dd id="q">贴  图:<a href="###">QQ贴图</a></dd>
      <dd>
      <!--這个是调用ubb的php界面-->
      <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
      <textarea name="content" rows="16">
      <?php echo $_html['content'];?>
      </textarea>
      </dd>
  		<dd>
      <?php if(!empty($_system['code'])){?>
      验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
      <?php };?>
      <input type="submit" class="submit" value="修改帖子" />
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