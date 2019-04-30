<?php
  session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','manage_job');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断只有管理员才能登陆
  _login_manage();
  //這个是添加管理员的部分
  if($_GET['action']=='add'){
   $_clean=array();
   $_clean['username']=$_POST['manage'];
   //這个是将普通成员提升为管理员
   _query("UPDATE 
                      tg_user 
                  SET tg_level=1 
                WHERE tg_username='{$_clean['username']}'");
   //這个是修改成功的部分
    if(_affected_rows()==1){
     _close();
     _location('恭喜你,管理员添加成功','manage_job.php');
    }else {
     _close();
     _alert_back('很遗憾,管理员添加失败,原因:不存在此用户'); 
    }
  }
  //這个是管理员辞职的部分
  if($_GET['action']=='job' && isset($_GET['id'])){
    //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
     //辞职开始
     _query("UPDATE tg_user 
                SET tg_level=0 
              WHERE tg_username='{$_COOKIE['username']}'
              AND   tg_id='{$_GET['id']}'"); 
     //数据库影响的部分
     if(_affected_rows()==1){
     _close();
     _session_destroy();
     _location('辞职成功','index.php');
     }else {
     _close();
     _alert_back('辞职失败');
     }
  }else {
    _alert_back('唯一标识符错误');
  }
  }
  //这个是点击删除的部分
   global $_pagenum,$_pagesize;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_user",10);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT       tg_id,
                                tg_username,
                                tg_email,
                                tg_reg_time
                        FROM    tg_user
                        WHERE   tg_level=1
                      ORDER BY  tg_reg_time 
                    DESC LIMIT  $_pagenum,$_pagesize");

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
 <!--這个 header-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>
 <!--這个是写短信的界面-->
 <div id="menber">
 <?php 
  require ROOT_PATH.'includes/manage.inc.php';
 ?>
  <div id="menber_main">
  	<h2>会员列表中心</h2>
  	<table>
  	<tr>
  	 <th>ID号</th>
  	 <th>管理员</th>	
  	 <th>邮件</th>
     <th>注册时间</th>  	
  	 <th>操作</th>		
  	</tr>
    <?php 
    $_html=array();
    while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['username']=$_rows['tg_username'];
     $_html['reg_time']=$_rows['tg_reg_time'];
     $_html['email']=$_rows['tg_email'];
     $_html=_html($_html);
     //這个是辞职的部分
     if($_COOKIE['username']==$_html['username']){
    $_html['job_html']='<a href="?action=job&id='.$_html['id'].'">辞职</a>';
      }else {
      $_html['job_html']='无权操作';
     }
  	?>
  	<tr>
  	 <td><?php echo $_html['id'];?></td>
  	 <td title="<?php $_html['username'];?>">
     <?php echo $_html['username'];?></td>	
  	 <td><?php echo $_html['email'];?></td>
     <td><?php echo $_html['reg_time'];?></td>  	
  	 <td>
     <?php echo $_html['job_html'];?>
     </td>
     </tr>
  	<?php
  	};
  	?>	
  	</table>
   <form method="post" action="?action=add">
    <input type="text" name="manage" class="text" />
    <input type="submit" value="添加管理员" /> 
   </form>
    <?php
       //进行结果集的销毁,节省资源
     _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
     _paging(2);
    ?>
  </div>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>








