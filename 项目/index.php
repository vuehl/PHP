<?php
session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //定义一个常量用来调用這个路径
 define('SCRIPT','index');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //打印出XML文件,_get_xml()函数封装到了global.func.php的函数里面了
  $_html=_get_xml('new.xml');
 //這个是帖子的列表的部分
 //這个是获取全局的变量
 global $_pagenum,$_pagesize,$_system;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_arcticle WHERE tg_reid=0",$_system['article']);
 //這个是从数据库中获取
 $_result=_query("SELECT tg_id,
 	                     tg_title,
 	                     tg_readcount,
 	                     tg_commendcount
 	               FROM  tg_arcticle
 	               WHERE tg_reid=0    /*這个是让他的主题帖位0,否则它会显示,回复的帖子,在写入数据库中的时候要注意*/
 	               ORDER BY tg_date
 	               DESC  LIMIT $_pagenum,$_pagesize");
 //最新照片,必须是最新的时间,而且是类型是公开的
 $_photo=_fetch_array("SELECT 
                              tg_id AS id,
                              tg_name AS name,
                              tg_url AS url 
                         FROM 
                              tg_photo 
                         WHERE 
                              tg_sid in (SELECT tg_id FROM tg_dir WHERE tg_type=0) /*這个是通过in来查找多个,来通过其他的表来查找*/
                     ORDER BY tg_date 
                        DESC 
                              LIMIT 1");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php 
require ROOT_PATH.'includes/title.inc.php'
?>
<script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

<div id="list">
	<h2>帖子列表</h2>
	<a href="post.php" class="post">帖子列表</a>
	<ul class="article">
	   <?php 
         $_htmllist=array();
         while(!!$_rows=_fetch_array_list($_result)){
         $_htmllist['id']=$_rows['tg_id'];
         $_htmllist['title']=$_rows['tg_title'];
         $_htmllist['readcount']=$_rows['tg_readcount'];
         $_htmllist['commendcount']=$_rows['tg_commendcount'];
         echo '<li><a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],18).'</a><em>阅读数(<strong>'.$_htmllist['readcount'].'</strong>)评论数(<strong>'.$_htmllist['commendcount'].'</strong>)</em></li>';
         }
         //這个是关闭结果集
        _free_result($_result);
	   ?>
	</ul>
	<!--這个是显示分页的效果-->
	<?php _paging(2);?>
</div>
<div id="user">
	<h2>新进会员</h2>
    <dl>                
 	<dd class="user"><?php echo $_html['username']?>(<?php echo $_html['sex']?>)</dd>
 	<dt><img src="<?php echo $_html['face']?>" alt="<?php echo $_html['username']?>" /></dt>
 	<dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id']?>">发消息</a></dd>
 	<dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id']?>">加好友</a></dd>
 	<dd class="guest">写留言</dd>
 	<dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id']?>">给她送花</a></dd>
 	<dd class="email">邮件:<a href="mailto:<?php echo $_html['email']?>"><?php echo $_html['email']?></a></dd>
 	<dd class="url">网址:<a href="<?php echo $_html['url']?>" target="_blank"><?php echo $_html['url']?></a></dd>
 	</dl>
</div>
<div id="pic">
	<h2><?php echo $_photo['name'];?></h2>
    <a href="photo_detail.php?id=<?php echo $_photo['id']?>" />
    <img src="thumb.php?filename=<?php echo $_photo['url']?>&percent=0.4" alt="<?php echo $_photo['name']?>" />
    </a>
</div>

<!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>