<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo_add_dir');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //在這里使用过全局变量global是为了让下面的$_result的返回值,不出现警告
  include ROOT_PATH.'includes/photo.func.php';
 //這个是管理员才能登陆的页面
 _login_manage();
 //开始接收数据
 if($_GET['action']=='add_dir'){
   //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
    //接收数据
    $_clean=array();
    $_clean['name']=_check_username($_POST['name']);
    if(!empty($_clean['type'])){
    $_clean['password']=_check_password($_POST['password']);
    }
    $_clean['type']=$_POST['type'];
    $_clean['dir']=time();
    $_clean['content']=$_POST['content'];
    $_clean=_mysql_string($_clean);
    //這个是目录的部分,如果没有photo這个目录就新建一个
    if(!is_dir('photo')){
      mkdir('photo',0777);
    }
    //這个是在photo下面创建一个子目录
    if(!is_dir('photo/'.$_clean['dir'])){
     mkdir('photo/'.$_clean['dir'],'0777');
    }
    //写入数据库的数据开始
    if(empty($_clean['type'])){
    	//這个是公开的
     _query("INSERT INTO tg_dir(
     	                       tg_name,
     	                       tg_type,
     	                       tg_dir,
     	                       tg_content,
     	                       tg_date
     	                       ) 
     	         VALUES        (
     	                       '{$_clean['name']}',
     	                       '{$_clean['type']}',
     	                       '{$_clean['dir']}',
     	                       '{$_clean['content']}',
     	                       NOW()
     	                       )");
    }else {
    //這个是私密的部分
      _query("INSERT INTO tg_dir(
     	                       tg_name,
     	                       tg_type,
     	                       tg_password,
     	                       tg_dir,
     	                       tg_content,
     	                       tg_date
     	                       ) 
     	         VALUES        (
     	                       '{$_clean['name']}',
     	                       '{$_clean['type']}',
     	                       '{$_clean['password']}',
     	                       '{$_clean['dir']}',
     	                       '{$_clean['content']}',
     	                       NOW()
     	                       )");
    }
    //這个是写入数据库受影响的数据
     if(_affected_rows()==1){
     _close();
     _location('目录添加成功','photo.php');
     }else {
      _close();
      _alert_back('目录添加失败');
     }
   }else {
   	_alert_back('唯一标识符错误');
   }
 }
 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<script type="text/javascript" src="js/photo_add_dir.js"></script>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="photo">
 	<h2>相册列表</h2> 
  <p><a href="photo_add_dir.php">添加目录</a></p>
   <form action="?action=add_dir" method="post">
   <dl>
   	<dd>相册名称:<input type="text" name="name" class="text"></dd>
   	<dd>相册类型:<input type="radio" name="type" value="0" checked="checked">公开<input type="radio" name="type" value="1">私密</dd>
   	<dd id="pass">相册密码:<input type="password"
   	 name="password" class="text">
   	</dd>
   	<dd>相册描述:<textarea name="content"></textarea></dd>
   	<dd><input type="submit" class="submit" value="添加目录" /></dd>
   </dl>
   </form>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






