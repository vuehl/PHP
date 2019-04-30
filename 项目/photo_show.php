<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo_show');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //删除相片
 if($_GET['action']=='delete' && isset($_GET['id'])){
     //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
     //這个是获取身份的部分,获取用户名
      if(!!$_rows=_fetch_array("SELECT 
                                      tg_username,
                                      tg_url,
                                      tg_id,
                                      tg_sid
                               FROM   tg_photo 
                               WHERE  tg_id='{$_GET['id']}'
                               LIMIT 1")){
        //這个是我们用数组来装
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['sid']=$_rows['tg_sid'];
        $_html['url']=$_rows['tg_url'];
        $_html['username']=$_rows['tg_username'];
       //這个是判断身份的部分
       if($_html['username']==$_COOKIE['username'] || isset($_SESSION['admin'])){
        //這个是首先在数据库里面删除
        _query("DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'");
     
        //這个是数据库连的影像数据
        if(_affected_rows()==1){
          //這个是删除成功时执行
          //這个是删除他的物理地址,就是从他的磁盘里面删除的
        if(file_exists($_html['url'])){
        //這个unlink()是删除他的物理地址
        unlink($_html['url']);
        }else {
          _alert_back('不存在此图片');
        }
        
        _close();
        _location('图片删除成功','photo_show.php?id='.$_html['sid']);
        }else {
          _close();
          _alert_back('图片删除失败');
        }
       }
      }else {
        _alert_back('非法登录');
      }
      
 }else {
  _alert_back('唯一标识符不正确');
 }
 }
 //取值
  if($_GET['id']){
  if($_rows=_fetch_array("SELECT 
                                 tg_id,
                                 tg_name,
                                 tg_type
                            FROM tg_dir 
                           WHERE tg_id='{$_GET['id']}'")){
    $_dirhtml=array();
    $_dirhtml['id']=$_rows['tg_id'];
    $_dirhtml['name']=$_rows['tg_name'];
    $_dirhtml['type']=$_rows['tg_type'];
    $_dirhtml=_html($_dirhtml);
    //這个是判断密码的部分
    if($_POST['password']){
     if($_rows=_fetch_array("SELECT 
                                 tg_id
                            FROM 
                                 tg_dir 
                           WHERE 
                                 tg_password='".sha1($_POST['password'])."'
                           LIMIT 
                                  1")){
    //這个是密码正确的部分的操作,生成cookies(),来进行比对
    //這个在后面加上id得到部分是为了,让他点击其他的不覆盖,让他不再一直输入密码
     setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
    //因为生成的cookie要慢一拍,所以要重新加载下,就可以了
    _location(null,'photo_show.php?id='.$_dirhtml['id']);
     }else {
       _alert_back('密码不正确,请重新输入');
     }
    }
   //這个是判断密码的部分结束
  }else {
    _alert_back('不存在此目录!');
  }
 }else {
  _alert_back('非法操作');
 }
 $_filename='photo/1495431982/1495517182.jpg';
 $_percent=0.7;

  global $_pagenum,$_pagesize,$_system,$_id;
  //這个$_id是让他可以分页,有id的时候
  $_id='id='.$_dirhtml['id'].'&';
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id
          FROM tg_photo 
         WHERE tg_sid='{$_dirhtml['id']}'",$_system['photo']);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT 
                              tg_id,
                              tg_username,
                              tg_name,
                              tg_url,
                              tg_readcount,
                              tg_commendcount 
                         FROM tg_photo 
                        WHERE tg_sid='{$_dirhtml['id']}' 
                     ORDER BY tg_date 
                   DESC LIMIT $_pagenum,$_pagesize");
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
 	<h2><?php echo $_dirhtml['name'];?></h2> 
   <!--這个是私密的部分,公开就不要密码了,而且生成的cookie都可以-->
   <?php if(empty($_dirhtml['type']) || $_COOKIE['photo'.$_dirhtml['id']]==$_dirhtml['name']){?>

    <?php 
     $_html=array();  
  while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['username']=$_rows['tg_username'];
     $_html['name']=$_rows['tg_name'];
     $_html['url']=$_rows['tg_url'];
     $_html['readcount']=$_rows['tg_readcount'];
     $_html['commendcount']=$_rows['tg_commendcount'];
     $_html=_html($_html);
    ?>
  <dl>
    <dt>
     <!--注意当时用&這个符号时不能分开否则会出错,一定要注意-->
     <a href="photo_detail.php?id=<?php echo $_html['id']?>">
 <img src="thumb.php?filename=<?php echo $_html['url']?>&percent=<?php echo $_percent;?>" />
     </a>
    </dt>
    <dd>
    <a href="photo_detail.php?id=<?php echo $_html['id']?>">
    <?php echo $_html['name'];?>
    </a>
    </dd>
    <dd>阅(<strong><?php echo $_html['readcount'];?></strong>)
        评(<strong><?php echo $_html['commendcount'];?></strong>) 
        上传者:<?php echo $_html['username'];?></dd>
    <?php if($_html['username']==$_COOKIE['username'] || isset($_SESSION['admin'])){?>
    <dd>[<a href="photo_show.php?action=delete&id=<?php echo $_html['id']?>">删除</a>]</dd>
    <?php };?>
  </dl>
   <?php
   };
     //进行结果集的销毁,节省资源
   _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
   _paging(2);
   ?>
<p><a href="photo_add_img.php?id=<?php echo $_dirhtml['id'];?>">上传照片</a></p>
 
<?php 
  }else {
echo '<form method="post" action="?id='.$_dirhtml['id'].'">';
echo '<p><input type="password" name="password" /><input type="submit" value="提交" /></p>';
echo '</form>';
  };?>
<!--這个是私密的部分,公开就不要密码了结束了-->
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






