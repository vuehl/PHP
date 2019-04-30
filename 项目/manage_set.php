<?php
 session_start();
//在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','manage_set');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //這个是管理员才可以登录,在导航栏写入,就错误
 _login_manage();
 //這个是修改数据的部分
 if($_GET['action']=='set'){
    //引入注册的那个部分验证
  include ROOT_PATH.'includes/check.func.php';
   if(!!$_rows=_fetch_array("SELECT tg_uniqid 
                              FROM tg_user 
                             WHERE tg_username='{$_COOKIE['username']}'
                             LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
 //写入数据库
 $_clean=array();
 $_clean['webname']=$_POST['webname'];
 $_clean['article']=$_POST['article'];
 $_clean['blog']=$_POST['blog'];
 $_clean['photo']=$_POST['photo'];
 $_clean['skin']=$_POST['skin'];
 $_clean['string']=$_POST['string'];
 $_clean['post']=$_POST['post'];
 $_clean['re']=$_POST['re'];
 $_clean['code']=$_POST['code'];
 $_clean['register']=$_POST['register'];

 //写入数据库表
 _query("UPDATE tg_system 
            SET tg_webname='{$_clean['webname']}',
                tg_article='{$_clean['article']}',
                tg_blog='{$_clean['blog']}',
                tg_photo='{$_clean['photo']}',
                tg_skin='{$_clean['skin']}',
                tg_string='{$_clean['string']}',
                tg_post='{$_clean['post']}',
                tg_re='{$_clean['re']}',
                tg_code='{$_clean['code']}',
                tg_register='{$_clean['register']}'
          WHERE tg_id=1
          LIMIT 1 ");
 //這个是写入数据库中被影响的数据
  //這个是判断是否修改成功
   if(_affected_rows()==1){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你修改成功','manage_set.php');
    //這个是验证码的清除
    //_session_destroy();  
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
    _location('很遗憾,你没有任何修改的信息','manage_set.php');
    //這个是验证码的用完之后的清除
   // _session_destroy();
    }
 }else {
  _alert_back('非法操作');
 }
 }
 //這个是读取后台系统表
  if(!!$_rows=_fetch_array("SELECT 
                                  tg_webname,
                                  tg_article,
                                  tg_blog,
                                  tg_photo,
                                  tg_string,
                                  tg_skin,
                                  tg_post,
                                  tg_re,
                                  tg_register,
                                  tg_code 
                             FROM tg_system 
                            WHERE tg_id=1 
                            LIMIT 1")){
    //這个是提取数据的部分
    $_html=array();
    $_html['webname']=$_rows['tg_webname'];
    $_html['article']=$_rows['tg_article'];
    $_html['blog']=$_rows['tg_blog'];
    $_html['photo']=$_rows['tg_photo'];
    $_html['skin']=$_rows['tg_skin'];
    $_html['string']=$_rows['tg_string'];
    $_html['post']=$_rows['tg_post'];
    $_html['re']=$_rows['tg_re'];
    $_html['code']=$_rows['tg_code'];
    $_html['register']=$_rows['tg_register'];
    $_html=_html($_html);
    //這个是显示文章页数的部分
    if($_html['article']==10){
     $_html['article_html']='<select name="article">
     <option value="10" selected="selected">每篇10页</option>
     <option value="8">每篇8页</option>
     </select>';
    }elseif($_html['article']==8){
    $_html['article_html']='<select name="article">
     <option value="10">每篇10页</option>
     <option value="8" selected="selected">每篇8页</option>
     </select>';
    }
    //這个是显示博友的部分
    if($_html['blog']==10){
     $_html['blog_html']='<select name="blog">
     <option value="10" selected="selected">每篇10人</option>
     <option value="15">每篇15人</option>
     </select>';
    }elseif($_html['blog']==15){
    $_html['blog_html']='<select name="blog">
     <option value="10">每篇10人</option>
     <option value="15" selected="selected">每篇15人</option>
     </select>';
    }
    //這个是显示相册里面个数
      if($_html['photo']==12){
     $_html['photo_html']='<select name="photo">
     <option value="12" selected="selected">每篇12张</option>
     <option value="8">每篇8张</option>
     </select>';
    }elseif($_html['photo']==8){
    $_html['photo_html']='<select name="photo">
     <option value="12">每篇12张</option>
     <option value="8" selected="selected">每篇8张</option>
     </select>';
    }
    //這个是皮肤选择的部分
     if($_html['skin']==1){
     $_html['skin_html']='<select name="skin">
     <option value="1" selected="selected">1号皮肤</option>
     <option value="2">2号皮肤</option>
     <option value="3">3号皮肤</option>
     </select>';
    }elseif($_html['skin']==2){
    $_html['skin_html']='<select name="skin">
     <option value="1">1号皮肤</option>
     <option value="2" selected="selected">2号皮肤</option>
     <option value="3">3号皮肤</option>
     </select>';
    }else if($_html['skin']==3){
     $_html['skin_html']='<select name="skin">
     <option value="1">1号皮肤</option>
     <option value="2">2号皮肤</option>
     <option value="3" selected="selected">3号皮肤</option>
     </select>'; 
    }
    //這个是发帖的时间
    if($_html['post']==30){
    $_html['post_html']='
    <input type="radio" name="post" checked="checked" value="30">30秒
    <input type="radio" name="post" value="60">一分钟
    <input type="radio" name="post" value="180">三分钟
    ';
    }else if($_html['post']==60){
    $_html['post_html']='
    <input type="radio" name="post" value="30">30秒
    <input type="radio" name="post" checked="checked" value="60">一分钟
    <input type="radio" name="post" value="180">三分钟
    ';
    }elseif($_html['post']==180){
    $_html['post_html']='
    <input type="radio" name="post" value="30">30秒
    <input type="radio" name="post" value="60">一分钟
    <input type="radio" name="post" checked="checked" value="180">三分钟
    ';  
    }
    //這个是回复界面的时间
    if($_html['re']==15){
    $_html['re_html']='
    <input type="radio" name="re" checked="checked" value="15">15秒
    <input type="radio" name="re" value="30">30秒
    <input type="radio" name="re" value="45">45秒
    ';
    }else if($_html['re']==30){
    $_html['re_html']='
    <input type="radio" name="re" value="15">15秒
    <input type="radio" name="re" checked="checked" value="30">30秒
    <input type="radio" name="re" value="45">45秒
    ';
    }elseif($_html['re']==45){
    $_html['re_html']='
    <input type="radio" name="re" value="15">15秒
    <input type="radio" name="re" value="30">30秒
    <input type="radio" name="re" checked="checked" value="45">45秒
    ';  
    }
    //是否启用验证码的部分
    if($_html['code']==1){
      $_html['code_html']='
      <input type="radio" value="1" name="code" checked="checked" />启用
      <input type="radio" value="0" name="code" />禁用
      ';
    }elseif($_html['code']==0){
      $_html['code_html']='
      <input type="radio" value="1" name="code" />启用
      <input type="radio" value="0" name="code" checked="checked" />禁用
      ';
    }
    //這个是是否启用会员注册的部分
    if($_html['register']==1){
      $_html['register_html']='
      <input type="radio" value="1" name="register" checked="checked" />启用
      <input type="radio" value="0" name="register" />禁用
      ';
    }elseif($_html['register']==0){
      $_html['register_html']='
      <input type="radio" value="1" name="register" />启用
      <input type="radio" value="0" name="register" checked="checked" />禁用
      ';
    }
    }else {
  _alert_back('后台信息出现错误,请联系后台管理员!');
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
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
  <!--个人中心的部分-->
   <div id="menber">
   <!--這个是左边的部分-->
    <?php 
    require ROOT_PATH.'includes/manage.inc.php';
    ?>
    <!--這个是右边的部分-->
   	<div id="menber_main">
   	 <h2>后台管理中心</h2>
     <form action="?action=set" method="post" name="set">
   	 <dl>
   	 <dd>网站名称:<input type="text" name="webname" 
     class="text" value="<?php echo $_html['webname'];?>"></dd>
     <dd>文章每页列表数:<?php echo $_html['article_html'];?></dd>
     <dd>博客每页列表数:<?php echo $_html['blog_html'];?></dd>
     <dd>相册每页列表数:<?php echo $_html['photo_html'];?></dd>
     <dd>站点　默认皮肤:<?php echo $_html['skin_html'];?></dd>
     <dd>敏感　字符限制:<input type="text" name="string" 
   class="text" value="<?php echo $_html['string'];?>">(*请使用 | 隔开)</dd>
     <dd>发帖　时间限制:<?php echo $_html['post_html'];?></dd>
     <dd>回帖　时间限制:<?php echo $_html['re_html'];?></dd>
     <dd>验证码是否启用:<?php echo $_html['code_html'];?></dd>
     <dd>启用　会员注册:<?php echo $_html['register_html'];?></dd>
     <dd><input type="submit" value="修改系统设置" class="submit"></dd>
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


