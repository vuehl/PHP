<?php 
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //定义一个常量用来调用這个路径
 define('SCRIPT','index');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';

 $_skinurl=$_SERVER["HTTP_REFERER"];
 //必须从上一页点击进来,而且有ID
 if(empty($_skinurl) || !isset($_GET['id'])){
  _alert_back('非法操作');
 }else {
 //生成一个COOKIE用来保存皮肤的种类
 //最好判断皮肤是1,2,3中的其中一个
 setcookie('skin',$_GET['id']);
 _location(null,$_skinurl);
 }
?>