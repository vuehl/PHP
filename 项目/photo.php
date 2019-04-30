<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //删除目录的部分
 if($_GET['action']=='delete' && isset($_GET['id'])){
     //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
   //這个是判断他的路劲目录
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_dir
                               FROM   tg_dir 
                               WHERE  tg_id='{$_GET['id']}'
                               LIMIT 1")){
      $_html=array();
      $_html['dir']=$_rows['tg_dir'];
    //3.删除磁盘里面的图片
    if(file_exists($_html['dir'])){
      //這个是删除目录的部分
      if(remove_Dir($_html['dir'])){
     //1.先删除目录里数据库的图片
     _query("DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'");
     //2.在删除目录的数据库
     _query("DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'");
      _close();
      _location('删除成功','photo.php');
      }else {
        _alert_back('删除目录失败');
      }
    }else {
      _alert_back('磁盘里不存在该目录');
    }

     }else {
      _alert_back('不存在此目录');
     }
  
 }else {
  _alert_back('非法登录');
 }
 }
 //在這里使用过全局变量global是为了让下面的$_result的返回值,不出现警告
  global $_pagenum,$_pagesize,$_system;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_user",$_system['photo']);
 //這个是显示数据
 $_result=mysql_query("SELECT tg_id,
 	                          tg_name,
 	                          tg_type,
                            tg_face,
 	                          tg_content 
 	                   FROM   tg_dir
 	               ORDER BY   tg_date
 	               LIMIT  $_pagenum,$_pagesize");
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="photo">
 	<h2>相册列表</h2> 
 	<?php 
    $_html=array();
 	while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['name']=$_rows['tg_name'];
     $_html['type']=$_rows['tg_type'];
     $_html['face']=$_rows['tg_face'];
     $_html['content']=$_rows['tg_content'];
     $_html=_html($_html);
     if(empty($_html['type'])){
     $_html['type_html']='(公开)';
     }else {
     $_html['type_html']='(私密)';	
     }

     if(empty($_html['face'])){
      $_html['face_html']='';
     }else {
       $_html['face_html']='<img src="'.$_html['face'].'" alt="'.$_html['name'].'">';
     }
     //這个是统计照片的数量
     $_html['photo']=_fetch_array("SELECT 
                                   COUNT(*) 
                                  AS count 
                                FROM tg_photo 
                               WHERE tg_sid='{$_html['id']}'");
 	?>
 	<dl>
 	<dt><a href="photo_show.php?id=<?php echo $_html['id'];?>"><?php echo $_html['face_html'];?></a></dt>
 	<dd><a href="photo_show.php?id=<?php echo $_html['id'];?>"><?php echo $_html['name'];?><?php echo $_html['type_html'];?></a>(<?php echo $_html['photo']['count'];?>)</dd>
 	<?php if(isset($_SESSION['admin']) && $_COOKIE['username']){?>
 	<dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id'];?>">修改</a>] [<a href="photo.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
 	<?php };?>
 	</dl>
 	<?php };?>
  <?php if(isset($_SESSION['admin']) && $_COOKIE['username']){?>
  <p><a href="photo_add_dir.php">添加目录</a></p>
  <?php };?>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






