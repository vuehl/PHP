<?php
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //定义一个常量用来调用這个路径
 define('SCRIPT','face');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require ROOT_PATH.'includes/title.inc.php'
?>

<script type="text/javascript" src="js/opener.js"></script>

</head>
<body>
<div id="face">
	<h3>选择头像</h3>
	     <!--第一个循环是输出1到9并赋值给$num,一个一个的来赋值-->
	<dl>
	     <?php foreach(range(1,9) as $num){?>
		<dd>
		<img src="face/m0<?php echo $num;?>.jpg" alt="face/m0<?php echo $num;?>.jpg" titlt='头像<?php echo $num;?>'  />
		</dd>
		<?php } ?>

	</dl>
       <!--第一个循环是输出10到64并赋值给$num,range()的作用是让這里面的值慢慢输出-->
	<dl>
	     <?php foreach(range(10,38) as $num){ ?>
		<dd><img src="face/m<?php echo $num;?>.jpg" alt="face/m<?php echo $num;?>.jpg" title="头像<?php echo $num;?>" />
		</dd>
		<?php } ?>

	</dl>
</div>

</body>
</html>