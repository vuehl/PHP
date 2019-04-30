<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo_add_img');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //在這里使用过全局变量global是为了让下面的$_result的返回值,不出现警告
  include ROOT_PATH.'includes/photo.func.php';
  //接收数据写入数据库
  if($_GET['action']=='add_img'){
   //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    //写入数据库
    $_clean=array();
    $_clean['name']=_check_photo_name($_POST['name'],2,20);
    $_clean['url']=$_POST['url'];
    $_clean['content']=$_POST['content'];
    $_clean['sid']=$_POST['sid'];
    $_clean=_mysql_string($_clean);
    //写入数据库表
    _query("INSERT INTO tg_photo(
                                 tg_name,
                                 tg_url,
                                 tg_content,
                                 tg_sid,
                                 tg_username,
                                 tg_date
                                ) 
            VALUES              (
                                '{$_clean['name']}',
                                '{$_clean['url']}',
                                '{$_clean['content']}',
                                '{$_clean['sid']}',
                                '{$_COOKIE['username']}',
                                NOW()
                                )");
    //写入数据库的影响的数据库
    if(_affected_rows()==1){
    _close();
    _location('上传图片成功','photo_show.php?id='.$_clean['sid']);
    }else {
    _close();
    _alert_back('上传图片失败');
    }
  }else {
    _alert_back('唯一标识符不正确');
  }
  }
  //取值
 if($_GET['id']){
  if($_rows=_fetch_array("SELECT 
                                 tg_id,
                                 tg_dir
                            FROM tg_dir 
                           WHERE tg_id='{$_GET['id']}'")){
    $_html=array();
    $_html['id']=$_rows['tg_id'];
    $_html['dir']=$_rows['tg_dir'];
    $_html=_html($_html);
  }else {
    _alert_back('不存在此目录!');
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
<script type="text/javascript" src="js/photo_add_img.js"></script>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="photo">
 	<h2>相册列表</h2> 
  <p><a href="photo_add_img.php">上传图片</a></p>
   <form action="?action=add_img" method="post">
   <input type="hidden" name="sid" value="<?php echo $_html['id'];?>" />
   <dl>
   	<dd>图片名称:<input type="text" name="name" class="text"></dd>
   	<dd>图片地址:<input type="text" name="url" id="url" readonly="readonly" class="text">
    <a href="javascript:;" id="up" title="<?php echo $_html['dir']?>">(*上传)</a>
  </dd>
   	<dd>图片描述:<textarea name="content"></textarea></dd>
   	<dd><input type="submit" class="submit" value="上传图片" /></dd>
   </dl>
   </form>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






