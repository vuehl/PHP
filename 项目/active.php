<?php

  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','active');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
   
  // mysql_query("INSERT INTO tg_user(tg_username) VALUES('炎日')") or die('SQL语句错误'.mysql_error());
//include的引入文件跟require引入文件差不多,但是include可以在表达式中引用,而require在头部调用
  include ROOT_PATH.'includes/check.func.php';
  //這个是防止别人在上面输入进入
  if(!isset($_GET['active'])){
  	_alert_back('非法操作');
  }
   //這个是不让他在上面的地址写,這样的用户名感觉不好
    if(!isset($_GET['active'])){
     _alert_back('操作不合法');
    }
  //开始激活处理
if(isset($_GET['active']) && isset($_GET['action']) && $_GET['action']=='ok'){
	$_active=$_GET['active'];
	if(_fetch_array("SELECT tg_active FROM tg_user WHERE tg_active='$_active' LIMIT 1")){
     //将数据库的tg_active设置为空
     _query("UPDATE tg_user SET tg_active=NULL WHERE tg_active='$_active' LIMIT 1");
     //這个是当修改成功时,就会影响一个数据,就会用到mysql_affected_rows();
     if(_affected_rows()==1){
      _close();
      _location('激活成功','login.php');
     }else {
     	_close();
     	_location('激活失败','register.php');
     }
     //else這个是_fetch_array()的函数后面
	}else{
	_alert_back('非法操作');
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
<script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  <div id="active">
  	<h2>激活账户</h2>
  	<p>本页面是模拟你的邮箱功能,点击以下链接可以激活你的用户</p>               <!--$_SERVER["HTTP_HOST"]是获取本地的$_SERVER["PHP_SELF"]這个是获取他的文件路径-->
  	<p><a href="active.php?action=ok&amp;active=<?php echo $_GET['active']?>"><?php echo 'http://'.$_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>active.php?action=ok&amp;active=<?php echo $_GET['active']?></a></p>
  </div>
  

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>

























