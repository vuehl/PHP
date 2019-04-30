<?php

  //防止页面被其他的人调用
  if(!defined('IN_TG')){
  exit('Access Defined');
  }
?>
<script type="text/javascript" src="js/skin.js"></script>
<!--這个部分是方便用来前面index来掉用,减少代码-->
<div id="header">
	<h1><a href="index.php">国产115多管理留言系统</a></h1>
	<ul>
		<li><a href="index.php">首页</a></li>
		<?php
         //這个是判断cookie的登录部分,$_COOKIE['username']這个是登录cookie的用户名
         if(isset($_COOKIE['username'])){
         	echo '<li><a href="menber.php">'.$_COOKIE['username'].'-个人中心</a>'.$GLOBALS['message'].'</li>';
            echo "\n";
         }else {
            echo '<li><a href="register.php">注册</a></li>';
            echo "\n";
            echo "\t\t";
            echo '<li><a href="login.php">登录</a></li>';
            echo "\n";
         }
		?>
		<li><a href="blog.php?page=1">博友</a></li>
		<li class="skin" onmouseout="outskin()" onmouseover="inskin()">
    <a href="javascript:;">风格</a>
    <dl id="skin">
    <dd><a href="skin.php?id=1">1.一号皮肤</a></dd>
    <dd><a href="skin.php?id=2">2.二号皮肤</a></dd>
    <dd><a href="skin.php?id=3">3.三号皮肤</a></dd> 
    </dl>
    </li>
    <li><a href="photo.php">相册</a></li>
		<?php
      //這个是管理的部分
      if(isset($_COOKIE['username']) && isset($_SESSION['admin'])){
      echo '<li><a href="manage.php" class="manage">管理</a></li> ';
      }
      //這个是退出的部分
		  if(isset($_COOKIE['username'])){
           echo '<li><a href="logout.php">退出</a></li>';
         }
		?>
	</ul>
</div>