<?php
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','thumb');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //显示缩略图的部分
 if(isset($_GET['filename']) && isset($_GET['percent'])){
  _thumb($_GET['filename'],$_GET['percent']);	
 }

?>