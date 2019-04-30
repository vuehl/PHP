<?php
  session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','menber_flower');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断是否登录了
  if(!isset($_COOKIE['username'])){
   _alert_back('请先登录');
  }
  //這个是点击删除的部分,就是批删除的部分
   if($_GET['action']=='delete' && isset($_POST['ids'])){
    $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
    //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid 
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
     //进行删除的操作,IN()括号里面是数组,删除多个数据
     _query("DELETE FROM tg_flower WHERE tg_id IN ({$_clean['ids']})");
     //這个是影响的数据
       //因为是多条数据的删除,所以就不能等位一了,就是有数据就行了
     if(_affected_rows()){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
     _location('删除花朵成功','menber_flower.php');
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
     _alert_back('删除花朵失败');
    }
   }else {
    _alert_back('非法登录');
   }
   }
   global $_pagenum,$_pagesize;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
 _page("SELECT tg_id FROM tg_flower WHERE tg_touser='{$_COOKIE['username']}'",10);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT 
                                tg_id,
                                tg_fromuser,
                                tg_flower,
                                tg_content,
                                tg_date 
                        FROM    tg_flower 
                        WHERE tg_touser='{$_COOKIE['username']}'
                      ORDER BY tg_date 
                      DESC LIMIT $_pagenum,
                      $_pagesize");

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
 require ROOT_PATH.'includes/title.inc.php';
?>
<script type="text/javascript" src="js/menber_message.js"></script>
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
  	<h2>送花管理中心</h2>
    <form method="post" action="?action=delete">
  	<table>
  	<tr>
  	 <th>送花人</th>
  	 <th>送花数目</th>	
  	 <th>送花内容</th>
     <th>送花时间</th>  	
  	 <th>操作</th>		
  	</tr>
    <?php
    //這个数组要放在外面,否则每次都是重新创建,浪费资源 
    $_html=array();
    while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['fromuser']=$_rows['tg_fromuser'];
     $_html['flower']=$_rows['tg_flower'];
     $_html['content']=$_rows['tg_content'];
     $_html['date']=$_rows['tg_date'];
     $_html['count']+=$_html['flower'];
       //這个是信息的状态
     if(empty($_rows['tg_state'])){
      //這个是没有读的信就让他加粗
     $_html['state']='<img src="image/noread.jpg" alt="未读" title="未读" />';
     $_html['content_html']='<strong>'.$_html['content'].'</strong>';
     }else {
     $_html['state']='<img src="image/read.jpg" alt="已读" title="已读" ';
     $_html['content_html']=$_html['content'];
     }
  	?>
  	<tr>
  	 <td><?php echo $_html['fromuser'];?></td>
  	 <td><?php echo $_html['flower'];?></td>	
  	 <td><?php echo _title($_html['content']);?></td>
     <td><?php echo $_html['date'];?></td>  	
                                 <!--在ids[]后面添加[]是代表数组的意思,可以选中删除多个-->
  	 <td><input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>" /></td>		
  	</tr>
  	<?php
  	}
    //进行结果集的销毁,节省资源
 	 _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
 	 _paging(2);
  	?>	
    <tr>
    <td colspan="5">共<strong><?php echo $_html['count'];?></strong>朵
    </td>
    </tr>
    <tr>
    <td colspan="5">
      <label for="all">全选<input type="checkbox" name="chkall" id="all" /></label>
      <input type="submit" value="批删除" />
    </td>
    </tr>
  	</table>
    </form>
  </div>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>








