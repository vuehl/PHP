<?php
   //登录的界面
   session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
  global $_system;
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','login');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
  //登录状态的部分,防止在登陆时,别人在登陆栏上写
  _login_start();
  //开始处理登录状态
  if($_GET['action']=='login'){
  //引入验证的文件
   require ROOT_PATH.'includes/login.func.php';
   if(!empty($_system['code'])){
    //先用验证码阻止别人恶意的乱点击提交
  _check_code($_POST['yzm'],$_SESSION['code']);
   }
  //接受函数
   $_clean=array();
   $_clean['username']=_check_username($_POST['username'],2,14);
   $_clean['password']=_check_password($_POST['password']);
   $_clean['time']=_check_time($_POST['time']);
    //到数据库去验证
   if(!!$_rows=_fetch_array("SELECT tg_username,
                                    tg_uniqid,
                                    tg_level 
                               FROM tg_user 
                              WHERE tg_username='{$_clean['username']}' 
                                AND tg_password='{$_clean['password']}' 
                                AND tg_active='' LIMIT 1")){
   //這个是登录成功时,来修改一些信息
   _query("UPDATE tg_user SET 
                            tg_reg_time=NOW(),
                            tg_reg_ip='{$_SERVER['REMOTE_ADDR']}',
                            tg_login_count=tg_login_count+1
                            WHERE 
                            tg_username='{$_rows['tg_username']}'
    ");

   //_session_destroy();
    //這个是cookie的登录界面,這个是从数据库里获得的,這个$_rows['tg_username']不要写错
   _setcookies($_rows['tg_username'],$_rows['tg_uniqid'],$_clean['time']);
   //這个是管理员的登录的部分,就是判断tg_level等于1的部分
   if($_rows['tg_level']==1){
    $_SESSION['admin']=$_rows['tg_username'];
    }
   _close();
   _location(null,'menber.php');
   }else {
   //_session_destroy();
   _close();
   _location('用户名密码错误或账户未被激活！','login.php');
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
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  <!--登录的部分-->
  <div id="login">
  	<h2>登录</h2>
  	<form method="post" action="login.php?action=login" name="login">
  	<dl>
  		<dt> </dt>
  		<dd>用&ensp;户&ensp;名:<input type="text" name="username" class="text" maxlength="12" /></dd>
  		<dd>密&emsp;&emsp;码:<input type="password" name="password" class="text" maxlength="16" /></dd>
        <dd>保&emsp;&emsp;留:<input type="radio" name="time" value="0" checked="checked" /> 不保留 <input type="radio" name="time" value="1" /> 一天 <input type="radio" name="time" value="2" /> 一周 <input type="radio" name="time" value="3" /> 一个月 </dd>
         <!--這个是判断用否启用验证码-->
        <?php if(!empty($_system['code'])){?>
        <dd>验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" /><img src="code.php" alt="" id="code"  /></dd>
        <?php };?>
        <dd><input type="submit" value="提交" class="button" /><input type="button" value="注册" id="location" class="button" /></dd>
        </dl>
     </form>
  </div>

   <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>














