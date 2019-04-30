<?php
 //防止页面被其他的人调用
  if(!defined('IN_TG')){
  exit('Access Defined');
  }
  //防止不是HTML的调用
  if(!defined('SCRIPT')){
  	exit('SCRIPT ERROR');
  }
global $_system;
?>
<!--這个title是进行页面的修改,這个是是其他页面也可用就要用全局global-->
<title><?php echo $_system['webname'];?></title>
<link rel="stylesheet" href="style/<?php echo $_system['skin'];?>/basic.css" type="text/css" />
<link rel="stylesheet" href="style/<?php echo $_system['skin'];?>/<?php echo SCRIPT;?>.css" type="text/css" />