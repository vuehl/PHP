<?php
  //开启权限跨页面就必须用這个,這个是开始$_SESSION[]的必须部分
   session_start();
   
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';

  //调用验证码的函数
   	 //這个是验证码的部分,这个是_code()默认是75*25 4个,通过改变后可以增加了灵活性
   	 //6位验证码最好是125,8位验证码最好是175,一次类推
  _code(125,25,6);
 

?>