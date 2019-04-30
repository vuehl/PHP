<?php
  session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','manage_menber');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断只有管理员才能登陆
  _login_manage();
  //这个是点击删除的部分
   global $_pagenum,$_pagesize;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_user WHERE tg_level=0",10);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT       tg_id,
                                tg_username,
                                tg_email,
                                tg_reg_time
                        FROM    tg_user
                        WHERE   tg_level=0
                      ORDER BY  tg_reg_time 
                    DESC LIMIT  $_pagenum,$_pagesize");
  //删除会员的部分
  if($_GET['action']=='del' && isset($_GET['id'])){
   $_clean=array();
   $_clean['id']=$_GET['id'];
   //這个是删除的部分
   _query("DELETE FROM tg_user WHERE tg_id IN ({$_clean['id']})");
   //這个是影响到数据库的部分
   if(_affected_rows()==1){
    _close();
    _location('恭喜你删除成功','manage_menber.php');
   }else {
     _close();
    _location('很遗憾你删除失败','manage_menber.php');
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
    <form method="post" action="?action=delete">
  	<table>
  	<tr>
  	 <th>ID号</th>
  	 <th>会员名</th>	
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
  	?>
  	<tr>
  	 <td><?php echo $_html['id'];?></td>
  	 <td title="<?php $_html['username'];?>">
     <?php echo $_html['username'];?></td>	
  	 <td><?php echo $_html['email'];?></td>
     <td><?php echo $_html['reg_time'];?></td>  	
  	 <td>
     [<a href="?action=del&id=<?php echo $_html['id']?>" 
     id="id" onclick="id()">删</a>]
     </td>
     </tr>
  	<?php
  	};
  	?>	
  	</table>
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








