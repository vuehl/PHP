<?php
 global $_system;
 //在這里写上session_start() 這个是代表开始了SESSION超级权限
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','register');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
   
  // mysql_query("INSERT INTO tg_user(tg_username) VALUES('炎日')") or die('SQL语句错误'.mysql_error());
//include的引入文件跟require引入文件差不多,但是include可以在表达式中引用,而require在头部调用
  include ROOT_PATH.'includes/check.func.php';
  //這个是登陆的状态,防止登录了别人在注册,在导航栏上写
  _login_start();
 //這个是用来发出数据
 if($_POST['action']=='register'){
   if(empty($_system['register'])){
    //这个是防止别人非法操作
    exit('不要非法注册');
   }
   //if(!($_SESSION['code']==$_POST['yzm'])){
  // _alert_back('验证码输入不正确');
  // }
  if(!empty($_system['code'])){
    //先用验证码阻止别人恶意的乱点击提交
  _check_code($_POST['yzm'],$_SESSION['code']);
  }

   /*這里是验证码如果写成功了,就可以获取用户名的信息了,放在外面便于以后的发帖可以不用输入验证码
    這里的$_username是受污染的,不便于后面的操作
    $_username=$_POST['username'];
    echo $_username;
    */
   

   //這里用一个空的数组来接收,用来保存传过来的合法数据
   $_clean=array();
   //這个是必须去掉前后的空格,這个方法是获取了用户名并判断了长度
   $_clean['username']=_check_username($_POST['username'],2,14);
   $_clean['password']=_check_password($_POST['password'],$_POST['notpassword'],6);
   $_clean['question']=_check_question($_POST['question'],2,20);
   $_clean['answer']=_check_answer($_POST['question'],$_POST['answer'],2,20);
   $_clean['sex']=$_POST['sex'];
   $_clean['face']=$_POST['face'];
   $_clean['email']=_check_email($_POST['email']);
   $_clean['qq']=_check_qq($_POST['qq']);
   $_clean['url']=_check_url($_POST['url']);
  // 這个是唯一标识符要存入数据库中,还有一个用处是在登陆时cookie的判断,判断是否伪造的cookie登录
   $_clean['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
  //這个active是用来激活刚登录的用户,防止别人恶意的登录,true是让是否有小数点
   $_clean['active']=sha1(uniqid(rand(),true)); 
     //這个是判断是否有重复的用户名
// $query=_query("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'");
   //MYSQL_ASSOC 這个是不打印出下标
  // if(mysql_fetch_array($query,MYSQL_ASSOC)){
  //  _alert_back('用户名已存在,请重新输入');
  // }
  
  // 這个是包装成函数后,就只有一句话,就可以写完用户名是否存在
  // if(_fetch_array("SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}'")){
  //  _alert_back('用户名已存在,请重新输入');
  // }
  
  //這个是_is_respeat() 函数,用来包装用户名的最好看的方式,LIMIT 1是如果找个一个相同的就返回
    _is_respeat(
     "SELECT tg_username FROM tg_user WHERE tg_username='{$_clean['username']}' LIMIT 1",
     '用户名已存在,请重新输入' 
      );
  

   //這个是用来测试,是否能够添加用户名
     _query("INSERT INTO tg_user(
                        tg_uniqid,
                        tg_active,
                        tg_username,
                        tg_password,
                        tg_question,
                        tg_answer,
                        tg_sex,
                        tg_face,
                        tg_email,
                        tg_qq,
                        tg_url,
                        tg_reg_time,
                        tg_login_time,
                        tg_reg_ip
                       ) 
                       VALUES(
                       '{$_clean['uniqid']}',
                       '{$_clean['active']}',
                       '{$_clean['username']}',
                       '{$_clean['password']}',
                       '{$_clean['question']}',
                       '{$_clean['answer']}',
                       '{$_clean['sex']}',
                       '{$_clean['face']}',
                       '{$_clean['email']}',
                       '{$_clean['qq']}',
                       '{$_clean['url']}',
                        NOW(),
                        NOW(),
                       '{$_SERVER["REMOTE_ADDR"]}'
                       )") or die('SQL语句错误'.mysql_error());

    if(_affected_rows()==1){
      //获取刚刚生成的ID
      $_clean['id']=mysql_insert_id();
     //关闭数据库
     _close();
     //注册成功时,在跳转的时候,生成XML文件,在新进会员哪里出来
     _set_xml('new.xml',$_clean);
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你注册成功','active.php?active='.$_clean['active']);
    //這个是验证码的清除
    //_session_destroy();  
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
    _location('很遗憾你注册失败','register.php');
    //這个是验证码的用完之后的清除
    //_session_destroy();
    }
  
 }else{
  //這个是没有提交的时候生成的唯一性权限,用来防止别人为表单的提交,否则在表单前面的话就不一样
  $_SESSION['uniqid']=$_uniqid=sha1(uniqid(rand(),true));
 }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/register.js"></script>
<script type="text/javascript" src="js/code.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  
  <!--這个是注册界面的部分-->
  <div id="register">
  	<h2>会员注册</h2>
    <?php if(!empty($_system['register'])){?>
  	<form method="post" action="register.php" name="register">
    <!--這个是防止别人网站攻击,唯一性的东西,记住這里的值要跟$_SESSION的值在一起,否则会一直都不对-->
    <input type="hidden" name="uniqid" value="<?php echo $_uniqid;?>" />
    <!--這个input是隐藏字段-->
    <input type="hidden" name="action" value="register" />
  	<dl>
  		<dt>请认真填写以下信息</dt>
  		<dd>用&ensp;户&ensp;名:<input type="text" name="username" class="text" maxlength="12" />
  		(*必填,至少两位)
  		</dd>
  		<dd>密&emsp;&emsp;码:<input type="password" name="password" class="text" maxlength="16" />
  		(*必填,至少六位)
  		</dd>
  		<dd>确认密码:<input type="password" name="notpassword" class="text" maxlength="16" />
        (*必填,同上)
  		</dd>
  		<dd>密码提示:<input type="text" name="question" class="text" />
        (*必填,至少两位)
  		</dd>
  		<dd>密码回答:<input type="text" name="answer" class="text" />
        (*必填,至少两位)
  		</dd>
  		<dd>性&emsp;&emsp;别:
  		<input type="radio" name="sex" value="男" checked="checked" />男
        <input type="radio" name="sex" value="女"  />女
  		</dd>
  		<dd class="face">
      <input type="hidden" name="face" id="face" value="face/m01.jpg" />
      <img src="face/m01.jpg" alt="头像选择" id="faceimg" />
  		</dd>
  		<dd>电子邮件:<input type="text" name="email" class="text" />(必填,激活账户)</dd>
  		<dd>&emsp;Q&ensp;Q&emsp;:<input type="text" name="qq" class="text" /></dd>
  		<dd>主页地址:<input type="text" name="url" value="http://" class="text" />
  		</dd>
      <?php if(!empty($_system['code'])){?>
  		<dd>验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
  		</dd>
      <?php };?>
  		<dd><input type="submit" class="submit" value="注册" /></dd>
  	</dl>
  	</form>
    <?php }else {
      echo '<h4 style="text-align:center;padding:20px;">本站已经关闭了注册的功能</h4>';
      }?>
  </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>