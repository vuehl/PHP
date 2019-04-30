<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','blog');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //在這里使用过全局变量global是为了让下面的$_result的返回值,不出现警告
 global $_pagenum,$_pagesize,$_system;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_user",$_system['blog']);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT 
  	                          tg_id,
  	                          tg_username,
  	                          tg_sex,
  	                          tg_face 
  	                     FROM tg_user 
  	                 ORDER BY tg_reg_time 
  	               DESC LIMIT $_pagenum,$_pagesize");
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="blog">
 	<h2>博友列表</h2> 
 	                            <!--MYSQL_ASSOC是以字符为下标-->
 	<?php 
     $_html=array();  
 	while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['username']=$_rows['tg_username'];
     $_html['face']=$_rows['tg_face'];
     $_html['sex']=$_rows['tg_sex'];
     $_html=_html($_html);
    ?>
 	<dl>                  <!--_html()這个是进行的过滤-->
 	<dd class="user"><?php echo $_html['username'];?>(<?php echo $_html['sex'];?>)</dd>
 	<dt><img src="<?php echo $_html['face'];?>" /></dt>
 	<!--在发消息這里使用name是获取的数组,可以发送哪一个-->
 	<dd><a href="javascript:;" name="message" title="<?php echo $_html['id'];?>">发消息</a></dd>
 	<dd><a href="javascript:;" name="friend" title="<?php echo $_html['id'];?>">加好友</a></dd>
 	<dd>写留言</dd>
 	<dd><a href="javascript:;" name="flower" title="<?php echo $_html['id'];?>">给她送花</a></dd>
 	</dl>
 	<?php
 	 }
 	 //进行结果集的销毁,节省资源
 	 _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
 	 _paging(2);
 	 ?>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






