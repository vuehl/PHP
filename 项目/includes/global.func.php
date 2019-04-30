<?php

  //這个是执行的核心数据库
  //這个是删除目录的部分,這个是用百度上炒的
  function remove_Dir($dirName){
   if(!is_dir($dirName)){
    return false;
   }
   $handle=@opendir($dirName);
   while(($file=@readdir($handle))!==false){
   if($file!='.' && $file!='..'){
   $dir=$dirName.'/'.$file;
   is_dir($dir)?remove_Dir($dir):@unlink($dir);
   }
   } 
   closedir($handle);
   return rmdir($dirName);
  }
  /*這个是验证发帖子的时间*/
  function _timed($now_time,$pre_time,$_second=60){
   if($now_time-$pre_time < $_second){
     _alert_back('请阁下休息一下在发帖子吧');
   }
  }
  
  /*這个是管理员登录*/
  function _login_manage(){
    if((!isset($_COOKIE['username'])) || (!isset($_SESSION['admin']))){
     _alert_back('非法登录');
    }
  }
  //explode() 這个函数是将以'空格',记住一定要打空格,否则会出错,进行分组 ,而microtime() 這个函数是执行程序的时间
  //_runtime() 这个函数是获取它程序执行的时间
 function _runtime(){
  $_mtime=explode(' ',microtime());
  return $_mtime[1] + $_mtime[0];
  }

  //這个是验证码的错误了的弹出窗口
  function _alert_back($_info){
  echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
  exit();
  }
  //這个是自动的关闭小窗口
  function _alert_close($_info){
  echo "<script type='text/javascript'>alert('".$_info."');window.close();</script>";
  exit();
  }



  /*
  這个是登录的状态无发在注册的函数
   */
  function _login_start(){
    if(isset($_COOKIE['username'])){
      _alert_back('登录状态无法进行该操作!');
    }
  }
  /*
  唯一标识符的判断
   */
  function _uniqid($_mysql_uniqid,$_cookie_uniqid){
    if($_mysql_uniqid!=$_cookie_uniqid){
     _alert_back('唯一性标识符不正确!');
    }
  }
  /*
  這个是获取的XML的数据
   */
   function _get_xml($_filexml){
    $_html=array();
    //這个file_exists()這个是判断這个XML文件是否正确
   if(file_exists($_filexml)){
   $_xml=file_get_contents($_filexml);
   //preg_match_all()這个是匹配全局字符串,第三个参数是生成一个数组
   //记住這个</vip>里面的/还要进行转义,否则会出错
   //(.*)這个是代表匹配vip里面的俗语内容
   preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
   foreach($_dom[1] as $_value){
    //preg_match_all()這个会打印出两个数组,第一个是有相当于text()含于标签
    //第二个相当于html()不含有标签内容
    preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
    preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
    preg_match_all('/<sex>(.*)<\/sex>/s',$_value,$_sex);
    preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
    preg_match_all('/<email>(.*)<\/email>/s',$_value,$_email);
    preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);
    $_html['id']=$_id[1][0];
    $_html['username']=$_username[1][0];
    $_html['sex']=$_sex[1][0];
    $_html['face']=$_face[1][0];
    $_html['email']=$_email[1][0];
    $_html['url']=$_url[1][0];
   }
 }else {
  echo '文件不存在';
 }
   return $_html;
   }
  /*
  這个是新创建的XML的,用来创建的数据
   */
  function _set_xml($_xmlfile,$_clean){
    //這个是生成XML的页面部分,w带便是可写入的xml
  $_fp=@fopen('new.xml','w');
  if(!$_fp){
   exit('系统错误,文件不存在!');
  }
  //flock()里面的LOCK_EX是锁住
  flock($_fp,LOCK_EX);
  //這个是$_string這个是里面的双引号要进行转义
  $_string="<?xml version=\"1.0\" encoding=\"utf-8\" ?>\r\n";
  //這个fwrite這个是写入的部分
  fwrite($_fp,$_string,strlen($_string));

  $_string="<vip>\r\n";
  fwrite($_fp,$_string,strlen($_string));

  $_string="\t<id>{$_clean['id']}</id>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t<username>{$_clean['username']}</username>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t<sex>{$_clean['sex']}</sex>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t<face>{$_clean['face']}</face>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t<email>{$_clean['email']}</email>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t<url>{$_clean['url']}</url>\r\n";
  fwrite($_fp,$_string,strlen($_string));

   $_string="\t</vip>\r\n";
  fwrite($_fp,$_string,strlen($_string));

  //flock()這个里面的是LOCK_UN這个是解锁的部分
  flock($_fp,LOCK_UN);
  fclose($_fp);
  }

  /*這个是缩略图的部分*/
  function _thumb($_filename,$_percent){
   header('Content-type:image/png');
 //這个是数组来区分扩展名
 $_n=explode('.',$_filename);
 //获取文件信息的长和高
 list($_width,$_height)=getimagesize($_filename);
 
 //生成微缩图的长和高
 $_new_width=$_width*$_percent;
 $_new_height=$_height*$_percent;
 //echo $_new_width.'='.$_new_height;
 //获取新生成的图片
 $_new_image=imagecreatetruecolor($_new_width,$_new_height);

 //按照已经有的图片创建一个画布,相当于用于后面生成的新图有用
 switch($_n[1]){
 case 'jpg':$_image=imagecreatefromjpeg($_filename);
 break;
 case 'png':$_image=imagecreatefrompng($_filename);
 break;
 case 'gif':$_image=imagecreatefromgif($_filename);
 break;
 }
 

 //這个就是生成的畏缩图了
 imagecopyresampled($_new_image, $_image, 0, 0, 0, 0, $_new_width, $_new_height, $_width, $_height);
 //显示生成的图片
 imagepng($_new_image);
 //销毁
 imagedestroy($_new_image);
 imagedestroy($_image);
  }
  /*
  這个是短信内容的部分,多了就隐藏的部分
   */
  function _title($_string,$_length=14){
  if(mb_strlen($_string,'utf-8')>$_length){
    $_string=mb_substr($_string,0,$_length,'utf-8').'...';
  }
  return $_string;
  }
  /*這个发帖子的部分,限制他的title的内容*/
  function _check_post_title($_string,$_min=2,$_max=40){
   if(mb_strlen($_string,'utf-8')<2 || mb_strlen($_string,'utf-8') >40){
    _alert_back('发帖的标题内容不能小于'.$_min.'位和不能大于'.$_max.'位');
   }
   return $_string;
  }
   /*這个发帖子的部分,限制他的content的内容*/
  function _check_post_content($_string,$_num){
   if(mb_strlen($_string,'utf-8')<$_num){
    _alert_back('发帖的内容信息不能小于'.$_num.'位');
   }
   return $_string;
  }

  /*
  _html()這个是将页面HTML进行过滤,
  就是将特殊字符进行过滤,這个是防止别人在注册时写非法字符,這里进行了调用
   */
   function _html($_string){
  //判断這个是不是数组,如果是就用数组的方法执行,如果不是就用這个执行普通的方法
   if(is_array($_string)){
    //遍历函数,一次次执行這个函数
    foreach($_string as $_key => $_value){
    //遍历這里不能用返回return,在最后使用return 返回
     $_string[$_key]=@htmlspecialchars($_value);
    }
   }else {
    $_string =@htmlspecialchars($_string);
   }
   return $_string;
   }
   /*
   這个是存放的时候进行转义
   這个是发送数据的时候进行转义,存放在数据库里面
    */
   function _mysql_string($_string){
    if(!GPC){
   if(is_array($_string)){
    foreach($_string as $_key=>$_value){
      //這个是进行了递归函数
    $_string[$_key]=_mysql_string($_value);
    }
   }else {
    $_string=mysql_real_escape_string($_string);
   }
   }
   return $_string;
   }
  /*
  _ubb()這个函数是发帖子的content内容里面的字符进行转义
   */
   function _ubb($_string){
    //nl2br()是在HTML中插入$_string的字符串插入<br/>的部分,进行换行
    $_string=nl2br($_string);
    //preg_replace()匹配全局的正则表达式,内容进行替换,注意在font-size:后面要加上像素
    //在這里[]這个都是需要尽享转义的
    $_string=preg_replace('/\[size=(.*)\](.*)\[\/size\]/U','<span style="font-size:\1px;">\1</span>',$_string);
    $_string=preg_replace('/\[b\](.*)\[\/b\]/U','<strong>\1</strong>',$_string);
    $_string=preg_replace('/\[i\](.*)\[\/i\]/U','<em>\1</em>',$_string);
    $_string=preg_replace('/\[u\](.*)\[\/u\]/U','<span style="text-decoration:underline;">\1</span>',$_string);
    $_string=preg_replace('/\[s\](.*)\[\/s\]/U','<span style="text-decoration:line-through;">\1</span>',$_string);
    $_string=preg_replace('/\[color=(.*)\](.*)\[\/color\]/U','<span style="color:\1">\2</span>',$_string);
    //当這里用了\1就不能再后面使用\1了,否则图片的路径就会显示出来了,要注意
    $_string=preg_replace('/\[url\](.*)\[\/url\]/U','<a herf="\1" target="_blank">\2</a>',$_string);
    $_string=preg_replace('/\[email\](.*)\[\/email\]/U','<a herf="mailto:\1">\2</a>',$_string);
    $_string=preg_replace('/\[img\](.*)\[\/img\]/U','<img src="\1" alt="图片">\2</img>',$_string);
   return $_string;
   }
  /*
  清除验证码的痕迹
   */
  function _session_destroy(){
    if(session_start()){
    session_destroy();
    }

  }

  /*
  這个是清楚cookie的页面
   */
  function _unsetcookie(){
  setcookie('username','',time()-1);
  setcookie('uniqid','',time()-1);
  _session_destroy();
  _location(null,'index.php');
  }

  /*
  這个是跳转的函数
   */
   function _location($_info,$_url){
    if(!empty($_info)){
     //注意在這里链接的时候不能加.$_url.否则会出错
    echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
     exit();
    }else {
      //注意header這里是跳转的意思,并且首字母还要大写,后面的Location:还要加冒号,否则不会跳转
      header("Location:".$_url);
    }
    
   }
   
   /*
   显示分页的部分,就是前面显示的内容
   $_sql 是执行sql的语句
   $_size就是他的显示的大小
    */
    function _page($_sql,$_size){
    //为了是這个函数可以调用,就要使用全局变量
    global $_pageabsolute,$_pagenum,$_pagesize,$_num,$_page;
   if(isset($_GET['page'])){
   $_page=$_GET['page'];   //這个是从提交哪里获取的分页,$_GET['']這个是从那边提交过来的 
   //is_numeric()這个函数是判断是不是数字
   if(empty($_page) || $_page <= 0 || !is_numeric($_page)){
    $_page=1;
    }else {
  //intval()這个是选择整数,如2.5,就会变成2
    $_page=intval($_page);
    }
   }else {
  //這个是判断$_page是否存在,如果不存在,就赋值为1,就不会出现错误了
   $_page=1;
    }
//mysql_num_rows()這个是计算数据的总和,可以用来看数据库里有多少的数据
   $_pagesize=$_size;    //这个是显示的页数,這个要先赋值,直接删除了话,会出现错误,在前面调用的话
   $_num = mysql_num_rows(_query($_sql));  //這个是数据的总和 
 //這个是防止数据库清空的时候
   if($_num==0){
    $_pageabsolute=1;
    }else{
    $_pageabsolute=ceil($_num/$_pagesize);   //這个是分页的页数
    }
  
 //這个是防止当页码数小于输入的page值时,就让他显示在后一页
  if($_page > $_pageabsolute){
   $_page=$_pageabsolute;
     }
    $_pagenum=($_page -1)*$_pagesize;  //這个是表示从哪个位置开始显示

    }

   /*
   _paging()這个和函数是分页函数
    type=1是数字分页 
    type=2是文本分页
    */
   function _paging($_type=2){
    //使用全局变量在函数里面,在另一个页面就可以调用了,不用赋值那么麻烦
    global $_page,$_pageabsolute,$_num,$_id; 
    if($_type==1){
    echo '<div id="page_num">';
    echo '<ul>';
       for($i=0;$i<$_pageabsolute;$i++){
        if($_page==($i+1)){ 
        //這个是当选中时可以添加的CSS样式
         echo '<li><a href="blog.php?'.$_id.'page='.($i+1).'" class="selected">'.($i+1).'</a></li>';
        }else {
         echo '<li><a href="blog.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>'; 
        }
       }
    echo '</ul>';
    echo '</div>';
    }else if($_type==2){
     //<!--這个是文本的格式的分页-->
    echo '<div id="page_text">';
    echo '<ul>';
    echo '<li>'.$_page.'/'.$_pageabsolute.'页 | </li>';
    echo '<li>共有<strong>'.$_num.'</strong>个数据 | </li>';
      //這个是判断首页的部分
          if($_page==1){
          echo '<li>首页 | </li>';
          //echo '<li>上一页 | </li>';
          }else {
            //SCRIPT 是在前面调用了的,记住這个是可以在前面定义了的,所以要调用的时候,记住先定义一个常量
            echo '<li><a href="'.(SCRIPT).'.php">首页</a> | </li>';
            echo '<li><a href="'.(SCRIPT).'.php?'.$_id.'page='.($_page-1).'">上一页</a> | </li>';
          }
          //這个是判断尾页的部分
          if($_page==$_pageabsolute){
           echo '<li>下一页 | </li>';
           echo '<li>尾页</li>';
          } else {
           echo '<li><a href="'.(SCRIPT).'.php?'.$_id.'page='.($_page+1).'">下一页</a> | </li>';
           echo '<li><a href="'.(SCRIPT).'.php?'.$_id.'page='.$_pageabsolute.'">尾页</a> | </li>';
          }   
    echo '</ul>'; 
    echo '</div>';
          }
          }


  /*
  _mysql_string 這个是让字符进行转义,如果转义了就不进行转义
   */
  // function _mysql_string($_string){
  // if(!get_magic_quotes_gpc($_string)){
  //  return mysql_real_escape_string($_string);
  // }
   // return $_string;
   //}

  //定义验证码的函数
  /*
  _code() 這个是验证码的函数
  @access public 共用函数
  @param int $_width 這个是验证码的宽度
  @param int $_height 這个是验证的高度
  @param int $_code 這个是验证码的个数
  return void 无返回值
   */
  function _code($_width=75,$_height=25,$_code=4){
   //设置验证码的长度
   //$_code=4;
   for($i=0;$i<$_code;$i++){
  	//dechex() 是将10进制转化为16进制
   $nump.=dechex(mt_rand(0,15));
  }
 

  //保存在$_session[] 超级权限里面,用来跨页面的部分,而且這个必须要写session_start()
  
  $_SESSION['code']=$nump;
  //验证码的长和高
  
  //$_width=75;
  //$_height=25;

  //创建验证码的图片
  $img = imagecreatetruecolor($_width, $_height);

  //创建一个白色的图片
  $_white=imagecolorallocate($img, 255, 255, 255);
  //将图片填充颜色
  imagefill($img, 0, 0, $_white);

  //黑色边框,通过随机也可以让边框也随机
  $_black=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
  //imagerectangle()這个是获取边框的颜色,前面两个是开始的坐标,后面那个是图片的结束位置
  imagerectangle($img,0,0,$_width-1,$_height-1, $_black);
 
  //這个是获取随机的线
  for($i=0;$i<6;$i++){
  	$_rand_color=imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
    imageline($img, mt_rand(0,$_width), mt_rand(0,$_height), mt_rand(0,$_width), mt_rand(0,$_height), $_rand_color);
  }
  //這个是随机生成雪花
  for($i=0;$i<100;$i++){
  	$_rand_color=imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
    //imagestring() 里面的1代表的是字体的大小
    imagestring($img, 1, mt_rand(1,$_width), mt_rand(1,$_height), "*", $_rand_color);
  }
  //输出验证码
  for($i=0;$i<strlen($_SESSION['code']);$i++){
  $_rand_color=imagecolorallocate($img,mt_rand(0,100),mt_rand(0,150),mt_rand(0,200));
  //在$_SESSION['code'][$i]; 這个是在[$i]里面不能加''单引号,否者会出错	
  imagestring($img,mt_rand(4,5),$i*$_width/$_code+rand(1,10),mt_rand(1,$_height/2),$_SESSION['code'][$i],$_rand_color);
  }
  //生成图片
  header('Content-Type:image/png');
  imagepng($img);
  //销毁图片
  imagedestroy($img);

  }


?>