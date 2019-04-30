<?php
 session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','menber_message_detail');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断是否登录了
  if(!isset($_COOKIE['username'])){
   _alert_back('请先登录');
  }
  //這个是删除短息的部分,用来获取信息
   if($_GET['action']=='delete' && isset($_GET['id'])){
    if(!!$_rows=_fetch_array("SELECT 
 	 	                       tg_id
 	 	                       FROM tg_message
 	 	                       WHERE 
 	 	                       tg_id='{$_GET['id']}' LIMIT 1")){
    //当进行危险操作是,都要进行标识符进行验证
     if(!!$_rows=_fetch_array("SELECT tg_uniqid 
     	                       FROM tg_user 
     	                       WHERE tg_username='{$_COOKIE['username']}'
     	                       LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
    //删除单个短信
     _query("DELETE FROM tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1");
     //這个是删除成功后,数据库发生了影响,然后进行跳转
      if(_affected_rows()==1){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('短信删除成功','menber_message.php');
    //這个是验证码的清除
    //_session_destroy();  
    }else {
   //关闭数据库
     _close();
   //這个是验证码的用完之后的清除
    //_session_destroy();
   //跳转到的页面
    _alert_back('短信删除失败');
   
    }
     }
    }else {
     _alert_back('此短信不存在');
    }
    exit();
   }


 //来获取的数据
 if(isset($_GET['id'])){
 	 $_rows=_fetch_array("SELECT 
 	 	                       tg_id,tg_fromuser,tg_content,tg_date
 	 	                       FROM tg_message
 	 	                       WHERE 
 	 	                       tg_id='{$_GET['id']}' LIMIT 1");
   
  //显示数据
  if($_rows){
  //這个是state的状态,這个是到了這个界面就默认为已读的状态
  if(empty($_rows['tg_state'])){
     _query("UPDATE 
                    tg_message 
             SET    tg_state=1 
             WHERE  tg_id='{$_GET['id']}' 
             LIMIT 1");
     //這个是没有修改成功,弹窗
     if(!_affected_rows()){
     _alert_back('异常');
     }
  }
   $_html=array();
   $_html['id']=$_rows['tg_id'];
   $_html['fromuser']=$_rows['tg_fromuser'];
   $_html['content']=$_rows['tg_content'];
   $_html['date']=$_rows['tg_date'];
   $_html=_html($_html);
  }else {
  _alert_back('此短信不存在');	
  }
 }else {
 	_alert_back('非法登录');
 }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/menber_message_detail.js"></script>
</head>
<body>
 <!--這个 header-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
 <!--這个是写短信的界面-->
 <div id="menber">
 <?php 
  require ROOT_PATH.'includes/menber.inc.php';
 ?>
  <div id="menber_main">
  	<h2>短信详情中心</h2>
     <dl>
      	<dd>发信人:<?php echo $_html['fromuser'];?></dd>
      	<dd>发信内容:<strong><?php echo $_html['content'];?></strong></dd>
      	<dd>发送时间:<?php echo $_html['date'];?></dd>
      	<dd class="button">
      <input type="button" value="返回列表" id="return" /> 
      <input type="button" value="删除短信" 
      name="<?php echo $_html[id]?>" id="delete"  />  
      </dd>
      </dl> 
  	</div>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
