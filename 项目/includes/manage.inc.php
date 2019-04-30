<?php
 //防止页面被其他的人调用,defined()這个函数就是为了防止让用户在导航哪里写就出来东西
  if(!defined('IN_TG')){
  exit('Access Defined');
  }

?>

	<div id="menber_sidebar">
   	<h2>管理导航</h2>
   	  <dl>
   		<dt>信息管理</dt>
   		<dd><a href="manage.php">后台首页</a></dd>
   		<dd><a href="manage_set.php">系统设置</a></dd>
   		</dl>
      <dl>
      <dt>用户管理</dt>
      <dd><a href="manage_menber.php">会员列表</a></dd>
      <dd><a href="manage_job.php">职务设置</a></dd>
      </dl>
   	</div>


