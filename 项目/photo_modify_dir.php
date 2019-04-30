<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo_add_dir');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //在這里使用过全局变量global是为了让下面的$_result的返回值,不出现警告
 //這个是管理员才能登陆的页面
 _login_manage();
 //修改数据
 if($_GET['action']=='modify'){
    include ROOT_PATH.'includes/photo.func.php';
   //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
    //接收数据
    $_clean=array();
    $_clean['id']=$_POST['id'];
    $_clean['name']=_check_username($_POST['name']);
    $_clean['type']=$_POST['type'];
    if(!empty($_clean['type'])){
    $_clean['password']=_check_password($_POST['password']);
    }
    $_clean['face']=$_POST['face'];
    $_clean['content']=$_POST['content'];
    $_clean=_mysql_string($_clean);
    //修改的操作在数据库
    if(empty($_clean['type'])){
     _query("UPDATE tg_dir 
                SET tg_name='{$_clean['name']}',
                    tg_type='{$_clean['type']}',
                    tg_password=NULL,
                    tg_face='{$_clean['face']}',
                    tg_content='{$_clean['content']}'
             WHERE  tg_id='{$_clean['id']}'
             LIMIT   1
                ");
    }else {
        _query("UPDATE tg_dir 
                SET tg_name='{$_clean['name']}',
                    tg_type='{$_clean['type']}',
                    tg_password='{$_clean['password']}',
                    tg_face='{$_clean['face']}',
                    tg_content='{$_clean['content']}'
             WHERE  tg_id='{$_clean['id']}'
             LIMIT   1
                ");
    }
    //這个是修改成功影响的数据库
    if(_affected_rows()==1){
     _close();
     _location('修改目录成功','photo.php');
    }else {
      _close();
     _alert_back('修改目录失败');
    }
   }else {
    _alert_back('唯一标识符错误');
   }
 }
 //读出数据
 if(isset($_GET['id'])){
   if($_rows=_fetch_array("SELECT tg_id,
                                  tg_name,
                                  tg_type,
                                  tg_face,
                                  tg_content
                           FROM   tg_dir
                           WHERE  tg_id='{$_GET['id']}'
                           LIMIT   1")){
   //這个是显示数据
   $_html=array();
   $_html['id']=$_rows['tg_id'];
   $_html['name']=$_rows['tg_name'];
   $_html['type']=$_rows['tg_type'];
   $_html['face']=$_rows['tg_face'];
   $_html['content']=$_rows['tg_content'];
   $_html=_html($_html);
   }else {
    _alert_back('不存在此目录');
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
</head>
<script type="text/javascript" src="js/photo_add_dir.js"></script>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="photo">
 	<h2>相册列表</h2> 
  <p><a href="">修改目录</a></p>
   <form action="?action=modify" method="post">
   <dl>
   	<dd>相册名称:<input type="text" name="name" class="text"
     value="<?php echo $_html['name'];?>"></dd>
   	<dd>相册类型:<input type="radio" name="type" value="0" 
    <?php if($_html['type']==0){ echo 'checked="checked"';}?> />公开
    <input type="radio" name="type" value="1" 
    <?php if($_html['type']==1){ echo 'checked="checked"';}?> />私密
    </dd>
   <dd id="pass" <?php if($_html['type']==1){echo 'style="display:block;"';}?>>相册密码:<input type="password"name="password" class="text">
   	</dd>
    <dd>相册地址:<input type="text" name="face" class="text"
     value="<?php echo $_html['face'];?>"></dd>
   	<dd>相册描述:<textarea name="content">
    <?php echo $_html['content'];?>
    </textarea></dd>
   	<dd><input type="submit" class="submit" value="修改目录" /></dd>
   </dl>
   <input type="hidden" value="<?php echo $_html['id'];?>" name="id" />
   </form>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






