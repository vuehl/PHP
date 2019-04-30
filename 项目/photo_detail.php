<?php
session_start();
 //在這里设置权限,让index可以调用哪里的header.inc.php
 define('IN_TG',true);
 //這个是调用的title的常量
 define('SCRIPT','photo_detail');
 //引入硬路径常量,加载速度更快
 require dirname(__FILE__).'/includes/common.inc.php';
 //注意:当你全部写对的时候,页面一直在弹出回帖成功,就是你的忘记写双等号了
 //写入数据库
 if($_GET['action']=='rephoto'){
    //验证码判断还需要用到這个
  include ROOT_PATH.'includes/check.func.php';
 _check_code($_POST['yzm'],$_SESSION['code']); 
 //這个是唯一标识符的验证
     if(!!$_rows=_fetch_array("SELECT 
                                      tg_uniqid
                               FROM   tg_user 
                               WHERE  tg_username='{$_COOKIE['username']}'
                               LIMIT 1")){
    //防止伪造的COOKIE登录,這个是更加的保证安全性
     _uniqid($_rows['tg_uniqid'],$_COOKIE['uniqid']);
      //接收数据
    $_clean=array();
    $_clean['sid']=$_POST['sid'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    $_clean['username']=$_COOKIE['username'];
    $_clean=_mysql_string($_clean);
     //写入数据库表
     _query("INSERT INTO tg_photo_commend(
                                  tg_sid,
                                  tg_username,
                                  tg_title,
                                  tg_content,
                                  tg_date
                                  ) 
               VALUES             (
                                  '{$_clean['sid']}',
                                  '{$_clean['username']}',
                                  '{$_clean['title']}',
                                  '{$_clean['content']}',
                                  NOW()
                                  )");
         //這个回帖写入数据库成功,影响了几行
   if(_affected_rows()==1){
     //這个是用来显示评论的条数
   _query("UPDATE tg_photo
              SET tg_commendcount=tg_commendcount+1
            WHERE tg_id='{$_clean['sid']}'
                  ");
   //关闭数据库
   //关闭数据库
     _close(); 
   //跳转到的页面,這个是注册成功之后,发送到激活的界面然后进行操作
    _location('恭喜你回帖成功','photo_detail.php?id='.$_clean['sid']);
      }else {
     //关闭数据库
     _close();
   //返回到本页面
    _alert_back('回帖失败');
     } 
 }else {
  _alert_back('唯一标识符不正确');
 }
 }
 //取值
  if($_GET['id']){
  if($_rows=_fetch_array("SELECT 
                                 tg_id,
                                 tg_sid,
                                 tg_name,
                                 tg_username,
                                 tg_url,
                                 tg_readcount,
                                 tg_commendcount,
                                 tg_date,
                                 tg_content
                            FROM tg_photo 
                           WHERE tg_id='{$_GET['id']}'")){
    //這个是防止加密相册交叉访问
    //可以先获得他的sid,也就是他的目录
    //然后在判断這个目录是否加密的
    //如果是加密的就判断他的是否有对应的cookie存在,并且对应相应的值
    //管理员不受這个限制,這个是管理员存在的时候不执行這个操作
    if(!isset($_SESSION['admin'])){
    if(!!$_dirs==_fetch_array("SELECT 
                                      tg_type,
                                      tg_id,
                                      tg_name 
                                 FROM 
                                      tg_dir 
                                WHERE 
                                      tg_id='{$_rows['sid']}'")){
    //這个是判断它的COOKIE是否加密
     if(!empty($_dirs['type']) && $_COOKIE['photo'.$_dirs['tg_id']]!=$_dirs['tg_name']){
      _alert_back('非法操作');
     } 
    }else {
      _alert_back('相册目录表出错了');
    }
    }
    //這个是执行到這里进行数据库的修改,页面刷新加一
    _query("UPDATE tg_photo 
            SET    tg_readcount=tg_readcount+1 
          WHERE    tg_id='{$_GET['id']}'");
    $_html=array();
    $_html['id']=$_rows['tg_id'];
    $_html['sid']=$_rows['tg_sid'];
    $_html['name']=$_rows['tg_name'];
    $_html['url']=$_rows['tg_url'];
    $_html['username']=$_rows['tg_username'];
    $_html['readcount']=$_rows['tg_readcount'];
    $_html['commendcount']=$_rows['tg_commendcount'];
    $_html['date']=$_rows['tg_date'];
    $_html['content']=$_rows['tg_content'];
    $_html=_html($_html);
    //显示评论回帖的部分
    //创建一个全局变量,用来获取分页的id
    global $_id;
    $_id='id='.$_html['id'].'&';
    //这个部分是读取回帖的部分
    global $_pagenum,$_pagesize,$_page;
    //显示分页的效果,第一个是执行查询的语句,第二个是每一页显示的个数
    _page("SELECT tg_id 
             FROM tg_photo_commend 
            WHERE tg_sid='{$_html['id']}'",10);
     //从数据库中提取结果集到页面调用,用来显示
     $_result=mysql_query("SELECT 
                                 tg_username,
                                 tg_title,
                                 tg_content,
                                 tg_date
                            FROM tg_photo_commend
                          WHERE  tg_sid='{$_html['id']}'
                        ORDER BY tg_date 
                       ASC LIMIT $_pagenum,$_pagesize");
    //這个是显示上一页的部分获取比自己id大的,中的最小一个,             這个还是要分是那个目录下的,min(tg_id)這个是查找结果的部分最小的那个
    //AS 這个是命名的id结果,如果没有這个,答案就是min(tg_id)=15,
    //有了AS的结果就是id=15
     $_html['preid']=_fetch_array("SELECT 
                                   min(tg_id) 
                              AS    id 
                             FROM   tg_photo
                             WHERE  tg_sid='{$_html['sid']}'
                             AND    tg_id>'{$_html['id']}'
                             LIMIT  1
                           ");

  //這个是显示上一页的部分
  if(!empty($_html['preid']['id'])){
$_html['pre']='<a href="photo_detail.php?id='.$_html['preid']['id'].'#pre">上一页</a>';
  }else {
   $_html['pre']='<span>到顶了</span>';
  }  
  //這个是显示下一页的部分
     $_html['nextid']=_fetch_array("SELECT 
                                   max(tg_id) 
                              AS    id 
                             FROM   tg_photo
                             WHERE  tg_sid='{$_html['sid']}'
                             AND    tg_id < '{$_html['id']}'
                             LIMIt  1
                           ");
     //這个是下一页的部分的显示
    if(!empty($_html['nextid']['id'])){
$_html['next']='<a href="photo_detail.php?id='.$_html['nextid']['id'].'#next">下一页</a>';
  }else {
   $_html['next']='<span>到低了</span>';
  }  

  }else {
    _alert_back('不存在此图片!');
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
 <div id="photo">
 	<h2>图片详情</h2>
  <a name="#pre"></a><a name="#next"></a> 
  <dl class="detail">
  <dd class="name"><?php echo $_html['name'];?></dd>
  <dt>
  <?php echo $_html['pre'];?>
  <img src="<?php echo $_html['url'];?>" />
  <?php echo $_html['next'];?>
  </dt>
  <dd>浏览量(<strong><?php echo $_html['readcount'];?></strong>) 
      评论量(<strong><?php echo $_html['commendcount'];?></strong>)
      上传者:<?php echo $_html['username'];?>
      上传时间:<?php echo $_html['date'];?>
  </dd>
  <dd>简介:<?php echo $_html['content'];?></dd>
   <dd>
  [<a href="photo_show.php?id=<?php echo $_html['sid']?>">
  返回列表
  </a>]
  </dd>
  </dl>
  <!--這个是显示回复的部分内容开始-->
  <?php
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

  ?>
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
     <span></span> <?php echo $_html['username']?> | 
     <?php echo $_html['date'];?> 
     </div> 
         <h3>主题: <?php echo $_html['retitle'];?></h3>
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
   <?php };
      //进行结果集的销毁,节省资源
   _free_result($_result);
    //_paging()這个函数是分页,1是数字分页,2是文本分页,但是默认是文本分页
   _paging(2);
   ?>
  <!--這个是显示回复的部分内容结束-->
   <?php if(isset($_COOKIE['username'])){ ?>
     <p class="line"></p>
   <!--這个是评论回帖子的部分-->
   <form method="post" action="?action=rephoto">
     <input type="hidden" name="sid" value="<?php echo $_html['id'];?>" />
    <dl class="rephoto">
      <dd>标  题:<input type="text" name="title" class="text" 
      value="RE:<?php echo $_html['name'];?>" readonly="readonly" />
      </dd>
      <dd id="q">贴  图:<a href="###">QQ贴图</a></dd>
      <dd>
      <!--這个是调用ubb的php界面-->
      <?php include ROOT_PATH.'includes/ubb.inc.php'; ?>
      <textarea name="content" rows="16"></textarea>
      </dd>
      <dd>
      验&ensp;证&ensp;码:<input type="text" name="yzm" class="text yzm" maxlength="6" />
      <img src="code.php" id="code"  />
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






