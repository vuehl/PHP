<?php
 //防止页面被其他的人调用,defined()這个函数就是为了防止让用户在导航哪里写就出来东西
  if(!defined('IN_TG')){
  exit('Access Defined');
  }

?>

	<div id="menber_sidebar">
   	<h2>中心导航</h2>
   	    <dl>
   		<dt>账号管理</dt>
   		<dd><a href="menber.php">个人中心</a></dd>
   		<dd><a href="menber_modify.php">修改资料</a></dd>
   		</dl>
   		<dl>
   		<dt>其他管理</dt>
   		<dd><a href="menber_message.php">短信查阅</a></dd>
   		<dd><a href="menber_friend.php">好友设置</a></dd>
   		<dd><a href="menber_flower.php">查询花朵</a></dd>
   		<dd><a href="###">个人相册</a></dd>
   	    </dl>	
   	</div>


