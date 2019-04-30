<?php
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','menber');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断是否正常登录
 if(isset($_COOKIE['username'])){
   $_rows=_fetch_array("SELECT tg_username,tg_sex,tg_face,tg_level,tg_email,tg_url,tg_qq,tg_reg_time FROM tg_user WHERE tg_username='{$_COOKIE['username']}'");
   //定义一个数组,用来装数组
   $_html=array();
   $_html['username']=$_rows['tg_username'];
   $_html['sex']=$_rows['tg_sex'];
   $_html['face']=$_rows['tg_face'];
   $_html['email']=$_rows['tg_email'];
   $_html['url']=$_rows['tg_url'];
   $_html['qq']=$_rows['tg_qq'];
   $_html['reg_time']=$_rows['tg_reg_time'];
   switch($_rows['tg_level']){
   case 0:
   $_html['level']='普通会员';
   break;
   case 1:
   $_html['level']='管理员';
   break;
   default:
    $_html['level']='出错了';
   }
   $_html=_html($_html);
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
    require ROOT_PATH.'includes/menber.inc.php';
    ?>
    <!--這个是右边的部分-->
   	<div id="menber_main">
   	 <h2>会员管理中心</h2>
   	 <dl>
   	 <dd>用&ensp;户&ensp;名:<?php echo $_html['username'];?></dd>
   	 <dd>性&emsp;&emsp;别:<?php echo $_html['sex'];?></dd>
   	 <dd>头&emsp;&emsp;像:<?php echo $_html['face'];?></dd>
   	 <dd>电子邮件:<?php echo $_html['email'];?></dd>
     <dd>主&emsp;&emsp;页:<?php echo $_html['url'];?></dd>
   	 <dd>Q &emsp;&emsp; Q:<?php echo $_html['qq'];?></dd>
   	 <dd>注册时间:<?php echo $_html['reg_time'];?></dd>
   	 <dd>身&emsp;&emsp;份:<?php echo $_html['level'];?></dd>
   	 </dl>
   	</div>
   </div>

  <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


