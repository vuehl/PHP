<?php
  session_start();
  //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','menber_friend');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //判断是否登录了
  if(!isset($_COOKIE['username'])){
   _alert_back('请先登录');
  }
 //添加好友的部分
 if($_GET['action']=='check' && isset($_GET['id'])){
    //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid 
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
   //這个是添加好友的部分
   _query("UPDATE tg_friend SET tg_state=1 WHERE tg_id='{$_GET['id']}'");
   //這个是影响的数据
     if(_affected_rows()==1){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
     _location('好友添加成功','menber_friend.php');
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
     _alert_back('好友添加失败');
    }
   }else {
    _alert_back('非法登录!');
   }
  }
 //這个是点击删除的部分,就是批删除好友的部分
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
     _query("DELETE FROM tg_friend WHERE tg_id IN ({$_clean['ids']})");
     //這个是影响的数据
       //因为是多条数据的删除,所以就不能等位一了,就是有数据就行了
     if(_affected_rows()){
     //关闭数据库
     _close();
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
     _location('数据删除成功','menber_friend.php');
    }else {
       //关闭数据库
     _close();
   //跳转到的页面
     _alert_back('数据删除失败');
    }
   }else {
    _alert_back('非法登录');
   }
   }
   global $_pagenum,$_pagesize;
 //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
     _page("SELECT 
                   tg_id
            FROM   tg_friend
            WHERE  tg_touser='{$_COOKIE['username']}'
            OR     tg_fromuser='{$_COOKIE['username']}'
            ",10);
 //从数据库中提取结果集到页面调用,用来显示
  $_result=mysql_query("SELECT 
                                tg_id,
                                tg_state,
                                tg_touser,
                                tg_fromuser,
                                tg_content,
                                tg_date 
                        FROM    tg_friend 
                        WHERE   tg_touser='{$_COOKIE['username']}'
                        OR      tg_fromuser='{$_COOKIE['username']}'
                      ORDER BY  tg_date 
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
  	<h2>好友设置中心</h2>
    <form method="post" action="?action=delete">
  	<table>
  	<tr>
  	 <th>好友请求</th>
  	 <th>请求内容</th>	
  	 <th>时间</th>
     <th>状态</th>  	
  	 <th>操作</th>		
  	</tr>
    <?php 
     $_html=array();
    while(!!$_rows=_fetch_array_list($_result)){
     $_html['id']=$_rows['tg_id'];
     $_html['touser']=$_rows['tg_touser'];
     $_html['fromuser']=$_rows['tg_fromuser'];
     $_html['content']=$_rows['tg_content'];
     $_html['state']=$_rows['tg_state'];
     $_html['date']=$_rows['tg_date'];
     //這个是别人请求的,就是你自己请求别人的不显示
     if($_html['touser']==$_COOKIE['username']){
       $_html['friend']=$_html['fromuser'];
       //這个是别人添加你,在判断你是否来添加
       if(empty($_html['state'])){
       $_html['state_html']='<a href="?action=check&id='.$_html['id'].'" style="color:red;">你未添加</a>';
       }else {
       $_html['state_html']='<span style="color:green;">通过</span>'; 
       }
     }else if($_html['fromuser']==$_COOKIE['username']){
       $_html['friend']=$_html['touser'];
       //這个是你添加别人的,还在来判断是否同意添加
       if(empty($_html['state'])){
       $_html['state_html']='<span style="color:blue;">对方未添加</span>';
       }else {
       $_html['state_html']='<span style="color:green;">通过</span>'; 
       }
     }
  	?>
  	<tr>
  	 <td><?php echo $_html['friend'];?></td>
  	 <td title="<?php $_html['content'];?>">
     <?php echo _title($_html['content']);?>
     </td>	
  	 <td><?php echo $_html['date'];?></td>
     <td><?php echo $_html['state_html'];?></td>  	
                                 <!--在ids[]后面添加[]是代表数组的意思,可以选中删除多个-->
  	 <td>
     <input type="checkbox" name="ids[]" value="<?php echo $_html['id']?>" /></td>		
  	</tr>
  	<?php
  	}
    //进行结果集的销毁,节省资源
 	 _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
 	 _paging(2);
  	?>	
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








