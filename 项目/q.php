<?php
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //定义一个常量用来调用這个路径
 define('SCRIPT','q');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //初始化這个Q图界面
 if(isset($_GET['num']) && isset($_GET['path'])){
 //is_dir()是判断它的路径是否正确
 if(!is_dir(ROOT_PATH.$_GET['path'])){
    _alert_back('非法操作');
 }
 }else {
 	_alert_back('非法操作');
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require ROOT_PATH.'includes/title.inc.php'
?>

<script type="text/javascript" src="js/qopener.js"></script>

</head>
<body>
<div id="face">
	<h3>选择Q图</h3>
	     <!--第一个循环是输出1到9并赋值给$num,一个一个的来赋值-->
	<dl>
	     <?php foreach(range(1,$_GET['num']) as $_num){?>
		<dd>
		<img src="<?php echo $_GET['path'].$_num?>.gif" 
		alt="<?php echo $_GET['path'].$_num?>.gif" 
		titlt='头像<?php echo $_num;?>'  />
		</dd>
		<?php } ?>
	</dl>
       <!--第一个循环是输出10到64并赋值给$num,range()的作用是让這里面的值慢慢输出-->
</div>

</body>
</html>