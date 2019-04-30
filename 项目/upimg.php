<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','blog');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //這个是会员才能登陆
 if(!$_COOKIE['username']){
  _alert_back('非法登录');
 }
//這个是上传的部分
 if($_GET['action']=='upimg'){
   //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
   //设置上传图片的类型
    $_file=array('image/jpeg','image/pjpeg',
      'image/png','image/x-png','image/gif');
    //判断是否是数组类型中的一种
    if(is_array($_file)){
      //$_FILES['username']['type']這个是上传图片的类型
      if(!in_array($_FILES['userfile']['type'],$_file)){
       _alert_back('上传的图片格式必须是jpg,gif,png');
      }
    }
    //這个是判断文件上传的类型
    if($_FILES['userfile']['error']>0){
      switch($_FILES['userfile']['error']){
    case 1:_alert_back("上传文件约定值1");  
      break;
    case 2:_alert_back("上传文件约定值2");  
      break;
    case 3:_alert_back("部分文件被上传");  
      break;
    case 4:_alert_back("没有文件被上传");  
      break;
    }
    exit();
    }
    //设置配置文件大小
    if($_FILES['userfile']['size']>1000000){
    _alert_back('上传的文件大小不能超过1兆');
    }
    //获取文件的扩展名
    $_n=explode('.',$_FILES['userfile']['name']);
    //這个是$_name是要赋值给他的父窗口定义的id用来获取值的
    $_name='photo/'.$_POST['dir'].'/'.time().'.'.$_n[1];
    //這个是移动文件的上传的部分
    if(is_uploaded_file($_FILES['userfile']['tmp_name'])){
    //這个是移动文件的部分
    if(!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)){
      _alert_back('上传文件失败');
    }else {
      //這个是将路径显示在父窗口上
      echo "<script>alert('上传成功!');
            window.opener.document.getElementById('url').value='$_name';
            window.close();
            </script>";
       //這个是关闭了后退出,下面就不会出现history()的错误了
            exit();
    }
    }else {
      _alert_back('上传的临时文件不存在');
    }
 }else {
  _alert_back('唯一标识符不正确');
 }
 }
 //dir的取值
 if(!isset($_GET['dir'])){
  _alert_back('非法操作');
 }
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
<body style="overflow-x:hidden;">

 <!--這个是上传的界面-->
 <div id="upimg" style="padding:30px 30px 30px 70px;">
 <form enctype="multipart/form-data" action="upimg.php?action=upimg" 
   method="post">
 <input type="hidden" name="MAX_FILE_SIZE" value="1000000" />
 <input type="hidden" name="dir" value="<?php echo $_GET['dir'];?>" />
 <input type="file" name="userfile" />
 <input type="submit" value="上传" />
 </form>
 </div>

</body>
</html>






