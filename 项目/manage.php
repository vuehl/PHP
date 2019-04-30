<?php
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','manage');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //這个是管理员才可以登录,在导航栏写入,就错误
 _login_manage();
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  <!--个人中心的部分-->
   <div id="menber">
   <!--這个是左边的部分-->
    <?php 
    require ROOT_PATH.'includes/manage.inc.php';
    ?>
    <!--這个是右边的部分-->
   	<div id="menber_main">
   	 <h2>后台管理中心</h2>
   	 <dl>
   	 <dd>服务器主机名称:<?php echo $_SERVER['SERVER_NAME'];?></dd>
     <dd>通信协议名称:<?php echo $_SERVER['SERVER_PROTOCOL'];?></dd>
     <dd>服务器IP:<?php echo $_SERVER['SERVER_ADDR'];?></dd>
     <dd>客户端IP:<?php echo $_SERVER['REMOTE_ADDR'];?></dd>
     <dd>服务器端口:<?php echo $_SERVER['SERVER_PORT'];?></dd>
     <dd>客服端端口:<?php echo $_SERVER['REMOTE_PORT'];?></dd>
     <dd>管理员邮箱:<?php echo $_SERVER['SERVER_ADMIN'];?></dd>
     <dd>版本执行的绝对路径:<?php echo $_SERVER['SCRIPT_FILENAME'];?></dd>
     <dd>Apache版本及PHP版本:<?php echo $_SERVER['SERVER_SOFTWARE'];?></dd>
   	 </dl>
   	</div>
   </div>

  <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


