<?php
global $_system;
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','menber_modify');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //修改资料,是在点击提交之前的修改,防止页面跳转了
 if($_GET['action']=='modify'){
  //引入注册的那个部分验证
  include ROOT_PATH.'includes/check.func.php';
  if(!empty($_system['code'])){
     //验证码验证,防止网站恶意修改
  _check_code($_POST['yzm'],$_SESSION['code']); 
  }
  //這个是判断有信息的时候才能修改
  if(!!$_rows=_fetch_array("SELECT tg_uniqid 
                              FROM tg_user 
                             WHERE tg_username='{$_COOKIE['username']}'
                             LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
  //创建一个数组
   $_clean=array();
   $_clean['password']=$_POST['password'];
   $_clean['sex']=$_POST['sex'];
   $_clean['face']=$_POST['face'];
   $_clean['email']=_check_email($_POST['email']);
   $_clean['qq']=_check_qq($_POST['qq']);
   $_clean['url']=_check_url($_POST['url']);
   $_clean['switch']=$_POST['switch'];
   $_clean['autograph']=_check_autograph($_POST['autograph'],100);
   //修改密码的部分,修改资料
   if(empty($_clean['password'])){
       _query("UPDATE tg_user 
                   SET
                               tg_sex='{$_clean['sex']}',
                               tg_face='{$_clean['face']}',
                               tg_email='{$_clean['email']}',
                               tg_qq='{$_clean['qq']}',
                               tg_url='{$_clean['url']}',
                               tg_switch='{$_clean['switch']}',
                               tg_autograph='{$_clean['autograph']}'
                         WHERE tg_username='{$_COOKIE['username']}'    
      ");
   }else {
    _query("UPDATE tg_user 
            SET 
                               tg_password='{$_clean['password']}',
                               tg_sex='{$_clean['sex']}',
                               tg_face='{$_clean['face']}',
                               tg_email='{$_clean['email']}',
                               tg_qq='{$_clean['qq']}',
                               tg_url='{$_clean['url']}',
                               tg_switch='{$_clean['switch']}',
                               tg_autograph='{$_clean['autograph']}'
                           WHERE tg_username='{$_COOKIE['username']}'    
      ");
   }
  }
  //這个是判断是否修改成功
   if(_affected_rows()==1){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你修改成功','menber.php');
    //這个是验证码的清除
    //_session_destroy();  
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
    _location('很遗憾,你没有任何修改的信息','menber_modify.php');
    //這个是验证码的用完之后的清除
   // _session_destroy();
    }
 }

 //判断是否正常登录
 if(isset($_COOKIE['username'])){
   $_rows=_fetch_array("SELECT 
                              tg_username,
                              tg_sex,
                              tg_face,
                              tg_email,
                              tg_url,
                              tg_qq,
                              tg_switch,
                              tg_autograph
                        FROM  tg_user 
                        WHERE tg_username='{$_COOKIE['username']}'");
   //定义一个数组,用来装数组
   $_html=array();
   $_html['username']=$_rows['tg_username'];
   $_html['sex']=$_rows['tg_sex'];
   $_html['face']=$_rows['tg_face'];
   $_html['email']=$_rows['tg_email'];
   $_html['url']=$_rows['tg_url'];
   $_html['qq']=$_rows['tg_qq'];
   $_html['switch']=$_rows['tg_switch'];
   $_html['autograph']=$_rows['tg_autograph'];
   $_html=_html($_html);
   //這个是用来修改性别的那个部分
   if($_html['sex']=='男'){
    $_html['sex_html']='<input type="radio" name="sex" value="男" checked="checked" />男<input type="radio" name="sex" value="女" />女';
   }else if($_html['sex']=='女'){
    $_html['sex_html']='<input type="radio" name="sex" value="男" />男<input type="radio" name="sex" value="女" checked="checked"  />女';
   }
  //這个是头像修改的部分
  $_html['face_html']='<select name="face">';
  foreach(range(1,9) as $_num){
    //這个是数据库的值等于选取的值就是让他成为首选
    if($_html['face']=='face/m0'.$_num.'.jpg'){
    $_html['face_html'].='<option value="face/m0'.$_num.'.jpg" selected="selected">face/m0'.$_num.'.jpg</option>';
    }else {
    $_html['face_html'].='<option value="face/m0'.$_num.'.jpg" >face/m0'.$_num.'.jpg</option>';  
    }
  
  }
   foreach(range(10,38) as $_num){
    if($_html['face']=='face/m'.$_num.'.jpg'){
    $_html['face_html'].='<option value="face/m'.$_num.'.jpg" selected="selected">face/m'.$_num.'.jpg</option>';  
    }else {
     $_html['face_html'].='<option value="face/m'.$_num.'.jpg">face/m'.$_num.'.jpg</option>';
    }
  }
  //注意在/select的前面加上‘.’這个是代表显示多个,如果不添加,前面的就覆盖了,就不会显示下拉菜单了
  $_html['face_html'].='</select>';
  //这个是个性签名开关的部分
  if($_html['switch']==1){
   $_html['switch_html']='<input type="radio" name="switch" checked="checked" value="1" />启用<input type="radio" name="switch" value="0"  />禁用';
  }else if($_html['switch']==0){
   $_html['switch_html']='<input type="radio" name="switch" value="1" />启用<input type="radio" name="switch" checked="checked" value="0"  />禁用';
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
 require ROOT_PATH.'includes/title.inc.php';
?>
</head>
<script type="text/javascript" src="js/code.js"></script>
<script type="text/javascript" src="js/menber_modify.js"></script>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  <!--个人中心的部分-->
   <div id="menber">
   <!--這个是左边的部分-->
    <?php 
    require ROOT_PATH.'includes/menber.inc.php';
    ?>
    <!--這个是右边的部分-->
   	<div id="menber_main">
   	 <h2>会员管理中心</h2>
     <form method="post" action="menber_modify.php?action=modify" name="modify">
   	 <dl>
   	 <dd>用&ensp;户&ensp;名:<?php echo $_html['username'];?></dd>
     <dd>密&emsp;&emsp;码:<input type="password" class="text" maxlength="16"
      name="password" value="" />
     (留空则不修改)
     </dd>
   	 <dd>性&emsp;&emsp;别:<?php echo $_html['sex_html'];?></dd>
   	 <dd>头&emsp;&emsp;像:<?php echo $_html['face_html'];?></dd>
   	 <dd>电子邮件:<input type="text" class="text" name="email" value="<?php echo $_html['email'];?>" /></dd>
     <dd>主&emsp;&emsp;页:<input type="type" name="url" class="text" value="<?php echo $_html['url'];?>" /></dd>
   	 <dd>Q &emsp;&emsp; Q:<input type="text" name="qq" class="text" value="<?php echo $_html['qq'];?>" /> </dd>
     <dd>个性签名:<?php echo $_html['switch_html'];?>(可以使用UBB代码)
     <p><textarea name="autograph"><?php echo $_html['autograph'];?></textarea></p>
     </dd>
     <dd>
     <?php if(!empty($_system['code'])){?>
     验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
      <?php };?>
      <input type="submit" class="submit" value="修改资料" />
      </dd>
   	 </dl>
     </form>
   	</div>
   </div>

  <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>


