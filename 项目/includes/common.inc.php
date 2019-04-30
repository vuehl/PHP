<?php
  header('COntent-Type:text/html;charset=utf-8');
  //防止外部文件调用
  if(!defined('IN_TG')){
  	exit('Access Defined');
  }
  //防止编码错误
  header('Content-Type:text/html;charset=utf-8');
  //引入公共文件,转化为硬路经常量,加载的速度快,substr是截取字符串
  define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

  //防止PHP版本太低,PHP_VERSION是显示PHP当前的版本
  if(PHP_VERSION < '4.1.0'){
  	exit('PHP is to low!');
  }
  
    //引入 公共数据库
   require ROOT_PATH.'includes/global.func.php';
   //引入mysql链接数据库
    require ROOT_PATH.'includes/mysql.func.php';
  //执行耗时间的操作,這个是 获取开始的时间,然后通过执行完的时间减去开始的时间,就是程序执行的时间
  define('START_TIME',_runtime());

//数据库链接
   
   define('DB_USER','root');
   define('DB_PWD','hl19971115xx');
   define('DB_HOST','localhost');
   define('DB_NAME','textguest');

//链接数据库,在這里要注意,mysql_connect()的位置不能写错,一定要按照DB_HOST,DB_USER,DB_PWD
//来写才正确,否则会报错,一定要注意
 //$_conn=mysql_connect(DB_HOST,DB_USER,DB_PWD) or die('数据库链接失败'.mysql_error());

//链接数据库表
// mysql_select_db(DB_NAME) or die('找不到数据库表'.mysql_error());

//判断字符集
//mysql_query('SET NAMES UTF8') or die('字符集错误'.mysql_error());

//初始化数据库
 _connect();  //选择数据库
 _select_db();  //选择数据库表
 _set_names();  //判断字符集是否错误



//公共短信提醒的部分
//AS后面的count就是命名数组的名字
//COUNT(tg_id)是获取字段就是数组的总和的条数,加判断WHERE是为了方便查找没有读的信息
//$GLOBALS這个是全局数组的,可以进行挂页面操作
$_message=_fetch_array("SELECT 
                               COUNT(tg_id)
                        AS     count
                        FROM   tg_message 
                        WHERE  tg_state=0
                        AND    tg_touser='{$_COOKIE['username']}'
                     ");

if(empty($_message['count'])){
  //這里定义的class="read"在basic.css的页面的写了样式的图片
  $GLOBALS['message']='<strong class="read"><a href="menber_message.php">(0)</a></strong>';
}else {
  $GLOBALS['message']='<strong class="noread"><a href="menber_message.php">('.$_message['count'].')</a></strong>';
}

//這个是后台管理系统的修改
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
 
   $_system=array();
   $_system['webname']=$_rows['tg_webname'];
   $_system['article']=$_rows['tg_article'];
   $_system['photo']=$_rows['tg_photo'];
   $_system['blog']=$_rows['tg_blog'];
   $_system['skin']=$_rows['tg_skin'];
   $_system['string']=$_rows['tg_string'];
   $_system['post']=$_rows['tg_post'];
   $_system['re']=$_rows['tg_re'];
   $_system['code']=$_rows['tg_code'];
   $_system['register']=$_rows['tg_register'];
   $_system=_html($_system);
   //這个是选择的时候skin选择的cookie的数据库的皮肤
   if($_COOKIE['skin']){
    $_system['skin']=$_COOKIE['skin'];
   }
  }else {
    exit('后台数据库表出错,请管理员进行修改');
  }







?>