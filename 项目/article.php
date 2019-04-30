<?php
 session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','article');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
  //验证码判断还需要用到這个
  include ROOT_PATH.'includes/check.func.php';
  //這个是精华帖的部分
  if($_GET['action']=='nice' && isset($_GET['id'])){
    //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
    //这个是设置精华帖和取消精华帖
    _query("UPDATE tg_arcticle SET tg_nice='{$_GET['on']}' WHERE tg_id='{$_GET['id']}'");
    //這个是数据库影响的部分
    if(_affected_rows()==1){
    _close();
    //这个是要注意,写多了就要写后面是那个的id了,不然会出错
    _location('精华帖操作成功','article.php?id='.$_GET['id']);
    }else {
    _close();
    _alert_back('精华帖修改失败');
    }
  }else {
   _alert_back('唯一标识符不正确');
  }
  }
 //处理回帖的部分的内容
 if($_GET['action']=='rearticle'){
   global $_system;
   //先用验证码进行验证
   if(!empty($_system['code'])){
     _check_code($_POST['yzm'],$_SESSION['code']); 
   }

   //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid,
                                      tg_article_time
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']); 
    //這个是限制发送的帖子是15秒,這个是用COOKIE的方法
    // _timed(time(),$_COOKIE['article_time'],15);
    //這个是写入数据库的方法
    global $_system;
    _timed(time(),$_rows['tg_article_time'],$_system['re']);
    //接收数据
    $_clean=array();
    $_clean['reid']=$_POST['reid'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    $_clean['username']=$_COOKIE['username'];
    $_clean=_mysql_string($_clean);
    //写入数据库表
     _query("INSERT INTO tg_arcticle(
     	                            tg_reid,
     	                            tg_username,
     	                            tg_title,
     	                            tg_content,
     	                            tg_date
     	                            ) 
     	         VALUES             (
     	                            '{$_clean['reid']}',
     	                            '{$_clean['username']}',
     	                            '{$_clean['title']}',
     	                            '{$_clean['content']}',
     	                            NOW()
     	                            )");
     //這个回帖写入数据库成功,影响了几行
   if(_affected_rows()==1){
   //這个是发送回帖的部分,限时是15秒,这个是COOKIE的方法
   //setcookie('article_time',time()); 
    //這个是数据库的方法
    $_clean['time']=time();
    _query("UPDATE 
                  tg_user 
              SET tg_article_time='{$_clean['time']}'
            WHERE tg_username='{$_COOKIE['username']}'");
   //這个是用来显示评论的条数
   _query("UPDATE tg_arcticle
              SET tg_commendcount=tg_commendcount+1
            WHERE tg_reid=0 
            AND   tg_id='{$_clean['reid']}'");
   //关闭数据库
     _close(); 
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你回帖成功','article.php?id='.$_clean['reid']);
    //這个是验证码的清除
    //_session_destroy();  
    }else {
     //关闭数据库
     _close();
   //返回到本页面
    _alert_back('回帖失败');
    //這个是验证码的用完之后的清除
    //_session_destroy();
    }
   }else {
   	_alert_back('唯一标识符错误');
   }
 }
 //這个是从数据库里面提去内容出来
 if(isset($_GET['id'])){
 if(!!$_rows=_fetch_array("SELECT 
 	                             tg_id,
 	                             tg_username,
 	                             tg_title,
 	                             tg_content,
 	                             tg_readcount,
 	                             tg_commendcount,
                               tg_nice,
                               tg_last_modify_date,
 	                             tg_date
 	                        FROM tg_arcticle
 	                        WHERE 
                               tg_reid=0 
                            AND
 	                             tg_id='{$_GET['id']}'")){
 	//這个是显示阅读量的部分,就是到這个界面让他显示加一
 	_query("UPDATE
 	               tg_arcticle
 	           SET tg_readcount=tg_readcount+1 
 	        WHERE  tg_id='{$_GET['id']}'");
 	  //這个是判断ID存在的时候写
 	  $_html=array();
 	  $_html['reid']=$_rows['tg_id'];
    //這个是用来回复判断是否楼主
    $_html['username_subject']=$_rows['tg_username'];
    $_html['last_modify_date']=$_rows['tg_last_modify_date'];
    $_html['title']=$_rows['tg_title'];
    $_html['content']=$_rows['tg_content'];
    $_html['readcount']=$_rows['tg_readcount']; 
    $_html['commendcount']=$_rows['tg_commendcount']; 
    $_html['nice']=$_rows['tg_nice'];
    $_html['date']=$_rows['tg_date']; 

    //拿出用户名,去提取用户信息
    if(!!$_rows=_fetch_array("SELECT
                                    tg_id,
                                    tg_sex,
                                    tg_face,
                                    tg_switch,
                                    tg_autograph,
                                    tg_email,
                                    tg_url
                               FROM tg_user 
                               WHERE tg_username='{$_html['username_subject']}'")
    ){
    //這个是提取用户名信息显示的部分
    $_html['userid']=$_rows['tg_id'];  //這个是用户的id号,而不是信息的id号
    $_html['sex']=$_rows['tg_sex'];
    $_html['face']=$_rows['tg_face'];
    $_html['email']=$_rows['tg_email'];
    $_html['url']=$_rows['tg_url'];
    $_html['switch']=$_rows['tg_switch'];
    $_html['autograph']=$_rows['tg_autograph'];
    $_html=_html($_html);

    //创建一个全局变量,用来获取分页的id
    global $_id;
    $_id='id='.$_html['reid'].'&';
    //這个是主题帖进行的修复,如果是楼主的发表,就可以点击右边进行修改
    if($_html['username_subject']==$_COOKIE['username']){
    $_html['subject_modify']='[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
    }
    //這个是最后修改的信息,登录的时候
    if($_html['last_modify_date']!='0000-00-00 00:00:00'){
       $_html['last_modify_date_string']='本帖子已经由['.$_html['username_subject'].']于'.$_html['last_modify_date'].'修改过!';
    }
    //给楼主回复的内容
    if($_COOKIE['username']){
    $_html['re']='<span>[<a href="#ree" name="re" title="回复:楼主'.$_html['username_subject'].'">回复</a>]</span>';
    }
    //這个是显示个性签名的部分
    if($_html['switch']==1){
    $_html['autograph_html']='<p class="autograph">'.$_html['autograph'].'</p>';
    }
    //这个部分是读取回帖的部分
    global $_pagenum,$_pagesize,$_page;
    //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
    _page("SELECT tg_id FROM tg_arcticle WHERE tg_reid='{$_html['reid']}'",10);
     //从数据库中提取结果集到页面调用,用来显示
     $_result=mysql_query("SELECT 
                                 tg_username,
                                 tg_title,
                                 tg_content,
                                 tg_date
                            FROM tg_arcticle 
                          WHERE  tg_reid='{$_html['reid']}'
                        ORDER BY tg_date 
                       ASC LIMIT $_pagenum,$_pagesize");

    }else {
    _alert_back('這个用户已经被删除');
    }
 }else {
 	_alert_back('不存在這个主题');
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
<script type="text/javascript" src="js/article.js"></script>
<script type="text/javascript" src="js/code.js"></script>
</head>
<body>
<!--這个是调用标题-->
 <?php
 require ROOT_PATH.'includes/header.inc.php';
 ?>

 <!--這个是博友的界面-->
 <div id="article">
 	<h2>帖子列表</h2>
  <?php 
   if(!empty($_html['nice'])){?>
  <img src="image/nice.png" alt="精华帖" class="nice" />
  <?php 
   };
   //這个是热帖的部分,阅读量达到400和评论量是达到20
   if($_html['readcount']>=400 && $_html['commendcount']>=20){
  ?>
  <img src="image/hot.png"  alt="热帖"   class="hot"  />
 	<!--這个是主题列表-->
  <?php 
   };
  if($_page==1){?>
 	<div id="subject">
 	<dl>
 	<dd class="user">
 	<?php echo $_html['username_subject'];?>
 	(<?php echo $_html['sex'];?>)[楼主]
 	</dd>
 	<dt>
 	<img src="<?php echo $_html['face'];?>" 
 	alt="<?php echo $_html['username_subject'];?>" />
 	</dt>
 	<dd class="message">
 	<a href="javascript:;" name="message" 
 	title="<?php echo $_html['userid'];?>">发消息</a>
 	</dd>
 	<dd class="friend">
 	<a href="javascript:;" name="friend" 
 	title="<?php echo $_html['userid'];?>">加好友</a>
 	</dd>
 	<dd class="guest">写留言</dd>
 	<dd class="flower"><a href="javascript:;" name="flower" 
 	title="<?php echo $_html['userid'];?>">给她送花</a>
 	</dd>
 	<dd class="email">邮件:
 	<a href="mailto:<?php echo $_html['email'];?>">
 	<?php echo $_html['email'];?></a>
 	</dd>
 	<dd class="url">网址:
 	<a href="<?php echo $_html['url'];?>" target="_blank">
 	<?php echo $_html['url'];?></a>
 	</dd>	
 	</dl>
 	 	
 	 	<div class="content">
 	 	 <!--這个是有右边的内容-->
 	 	 <div class="user">
 	 	 <span>楼主<?php echo $_html['subject_modify'];?></span> <?php echo $_html['username_subject']?> | 
 	 	 <?php echo $_html['date']?>
     <!--這个是设置精华帖的部分-->
     <?php if(empty($_html['nice'])){?>
     [<a href="article.php?action=nice&on=1&id=<?php echo $_html['reid']?>">设置精华帖</a>]	
 	 	 <?php }else {?>
     [<a href="article.php?action=nice&on=0&id=<?php echo $_html['reid']?>">取消精华帖</a>]
     <?php };?> 
     </div>	
         <h3>主题: <?php echo $_html['title']?><?php echo $_html['re'];?></h3>
         <!--這个是标题下面内容的详细部分-->
         <div class="detail">
         	<?php echo _ubb($_html['content']);?>
          <?php echo $_html['autograph_html'];?>
         </div>
         <!--這个是显示评论量和阅读量的部分-->
         <div class="read">
         <p><?php echo $_html['last_modify_date_string'];?></p>
         阅读量(<?php echo $_html['readcount'];?>) 
         评论量(<?php echo $_html['commendcount'];?>)	
         </div>
 	 	</div>
 	 </div>
   <!--這个是如果分页不是第一页就不显示楼主发帖子的第一条了-->
   <?php };?> 
   <!--這个是回复界面的开始-->
 	 <p class="line"></p>
   <?php 
    //$_i;這个是显示的楼层是多少个
    $_i=2;
   while(!!$_rows=_fetch_array_list($_result)){ 
       $_html['username']=$_rows['tg_username'];
       //這个是回复的时候不能用$_html['title']否则每个回复他都会增加RE,這个没有写他就是用楼主的,所以就用楼主的
       //retitle這个是在还h3哪里显示的标题
       $_html['retitle']=$_rows['tg_title'];
       $_html['content']=$_rows['tg_content'];
       $_html['date']=$_rows['tg_date'];
        //拿出用户名,去提取用户信息,在這里循环的时候要拿出来他的id才可以,否则下面不显示
    if(!!$_rows=_fetch_array("SELECT
                                    tg_id,
                                    tg_sex,
                                    tg_face,
                                    tg_switch,
                                    tg_autograph,
                                    tg_email,
                                    tg_url
                               FROM tg_user 
                              WHERE tg_username='{$_html['username']}'")
    ){
    //這个是提取用户名信息显示的部分
    $_html['userid']=$_rows['tg_id'];  //這个是用户的id号,而不是信息的id号
    $_html['sex']=$_rows['tg_sex'];
    $_html['face']=$_rows['tg_face'];
    $_html['email']=$_rows['tg_email'];
    $_html['url']=$_rows['tg_url'];
    $_html['switch']=$_rows['tg_switch'];
    $_html['autograph']=$_rows['tg_autograph'];
    $_html=_html($_html);
    //這个是用来判断回复的帖子,是否是楼主或者是2楼别人发的就是沙发
    if($_i==2){
     if($_html['username']==$_html['username_subject']){
      $_html['username_html']=$_html['username'].'(楼主)';
     }else {
      $_html['username_html']=$_html['username'].'(沙发)';
     }
    }else if($_html['username']==$_html['username_subject']){
     //這个不是二楼,而是其他的楼发表也是楼主
     $_html['username_html']=$_html['username'].'(楼主)';
    }else if($_i!=2 && $_html['username']!=$_html['username_subject']){
     //這个是不是2楼,也不是楼主,就让他不显示
     $_html['username_html']=$_html['username'];
    }
    
    
    }else {
      _alert_back('该用户已被删除');
    }  

    //這个是跟帖回复的界面,要在登录的情况下才有,這个就不再js的部分写了
    if($_COOKIE['username']){
     $_html['re']='<span>[<a href="#ree" name="re" title="回复:'.($_i+(($_page-1)*$_pagesize)).'楼的'.$_html['username'].'">回复</a>]</span>';
    }
    ?>
 	 <!--這个是回复界面的设置-->
 	<div class="re">
 	<dl>
 	<dd class="user">
 	<?php echo $_html['username_html'];?>
 	(<?php echo $_html['sex'];?>)
 	</dd>
 	<dt>
 	<img src="<?php echo $_html['face']?>" 
 	alt="<?php echo $_html['username'];?>" />
 	</dt>
 	<dd class="message">
 	<a href="javascript:;" name="message" 
 	title="<?php echo $_html['userid'];?>">发消息</a>
 	</dd>
 	<dd class="friend">
 	<a href="javascript:;" name="friend" 
 	title="<?php echo $_html['userid'];?>">加好友</a>
 	</dd>
 	<dd class="guest">写留言</dd>
 	<dd class="flower"><a href="javascript:;" name="flower" 
 	title="<?php echo $_html['userid'];?>">给她送花</a>
 	</dd>
 	<dd class="email">邮件:
 	<a href="mailto:<?php echo $_html['email'];?>">
 	<?php echo $_html['email'];?></a>
 	</dd>
 	<dd class="url">网址:
 	<a href="<?php echo $_html['url']?>" target="_blank">
 	<?php echo $_html['url'];?></a>
 	</dd>	
 	</dl>
 	 	
 	 	<div class="content">
 	 	 <!--這个是有右边的内容-->
 	 	 <div class="user">
 	 	 <span><?php echo $_i+(($_page-1)*$_pagesize)?>楼</span> <?php echo $_html['username']?> | 
 	 	 <?php echo $_html['date'];?>	
 	 	 </div>	
         <h3>主题: <?php echo $_html['retitle'];?><?php echo $_html['re'];?></h3>
         <!--這个是标题下面内容的详细部分-->
         <div class="detail">
         	<?php echo _ubb($_html['content']);?>
          <?php 
          //這个是显示个性签名的部分,不能放在循环里面,否则会出错
        if($_html['switch']==1){
            echo '<p class="autograph">'._ubb($_html['autograph']).'</p>';
            }
          ?>
         </div>
 	 	</div>
 	 </div> 
 	 <!--這个是回帖的部分的内容-->
 	 <p class="line"></p>
   <?php 
    $_i++;
    };
     //进行结果集的销毁,节省资源
   _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
   _paging(2);
   ?>
 	 <!--這个回复是当用户登录状态才有,否则不显示-->
 	 <?php if(isset($_COOKIE['username'])){ ?>
 	 <!--這个是评论回帖子的部分-->
   <a name="ree"></a> <!--這个是回复的锚点作用-->
 	 <form method="post" action="?action=rearticle">
 	   <input type="hidden" name="reid" value="<?php echo $_html['reid']?>" />
 	 	<dl>
  		<dd>标  题:<input type="text" name="title" class="text" 
  		value="RE:<?php echo $_html['title'];?>" readonly="readonly" />
  		</dd>
      <dd id="q">贴  图:<a href="###">QQ贴图</a></dd>
      <dd>
      <!--這个是调用ubb的php界面-->
      <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
      <textarea name="content" rows="16"></textarea>
      </dd>
  		<dd>
      <?php if(!empty($_system['code'])){?>
      验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" alt="" id="code"  />
      <?php };?>
      <input type="submit" class="submit" value="发表帖子" />
  		</dd>
  	</dl>
 	 </form>
 	 <?php };?>
 </div>

 <!--這个是调用结尾 footer-->
<?php
 require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>






