<?php
global $_system;
 session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','message');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //這个是判断是否登录了,如果没有登录,点击小窗口发送消息就会关闭窗口
 //引入验证的文件,這个是验证码的函数在里面,所以用的时候要调用下
   require ROOT_PATH.'includes/login.func.php';
 if(!isset($_COOKIE['username'])){
   _alert_close('请登录后在操作!');
 }
//这个是发消息的部分
 if($_GET['action']=='write'){
  if(!empty($_system['code'])){
   //這个是验证验证码的部分
   _check_code($_POST['yzm'],$_SESSION['code']);
  }

   //用這个是匹配唯一标识符,来加强安全性
 if(!!$_rows=_fetch_array("SELECT tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}'LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
     //這个是引入检查发送的文件
   //include ROOT_PATH.'includes/check.func.php';
   $_clean=array();
   $_clean['touser']=$_POST['touser'];
   $_clean['content']=$_POST['content'];
   $_clean['fromuser']=$_COOKIE['username'];
   $_clean=_mysql_string($_clean);
   //写入表的操作
   _query("INSERT INTO tg_message(
   	                    tg_touser,
   	                    tg_fromuser,
   	                    tg_content,
   	                    tg_date
   	                    ) 
   	              VALUES(
   	                    '{$_clean['touser']}',
   	                    '{$_clean['fromuser']}',
   	                    '{$_clean['content']}',
   	                    NOW()
   	                    )");
   //新增成功
     if(_affected_rows()==1){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
     _alert_close('短信发送成功');
    //這个是验证码的清除
    //_session_destroy();  
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
     _alert_back('短信发送失败');
    //這个是验证码的用完之后的清除
    //_session_destroy();
    }
   }else {
   	_alert_close('非法操作!');
   }
 }
//获取数据,就是发消息的给那个人的部分
if(isset($_GET['id'])){
 if(!!$_rows=_fetch_array("SELECT tg_username FROM tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1")){
      $_html=array();
      $_html['touser']=$_rows['tg_username'];
      $_html=_html($_html);
 }else {
 	_alert_close('不存在此用户');
 }

}else {
_alert_close('非法操作');
}

 ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/message.js"></script>
</head>
<body>

 <!--這个是写短信的界面-->
 <div id="message">
 	<h3>写短信</h3>
 	<form method="post" action="?action=write">
 	<input type="hidden" name="touser" value="<?php echo $_html['touser']?>" />
 	<dl>
 	<dd><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser'];?>"  class="text"/></dd>	
 	<dd><textarea name="content"></textarea></dd>
 	<dd>
  <?php if(!empty($_system['code'])){?>
  验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
      <?php };?>
  	<input type="submit" class="submit" value="发送消息" />
  	</dd>
 	</dl>
 	</form>
 </div>


</body>
</html>