<?php
  // 這个是验证码的函数包装的部分
   //防止外部文件调用
  if(!defined('IN_TG')){
  	exit('Access Defined');
  }
  //防止编码错误
  header('Content-Type:text/html;charset=utf-8');
  //引入公共文件,转化为硬路经常量,加载的速度快,substr是截取字符串

  //function_exists() 這个函数是判断函数是否存在,這个是多个程序员写的,可以用這个来检查是否有该函数
  if(!function_exists('_alert_back')){
  	exit('_alert_back()函数不存在,请检查!');
  } 
  
  
    /*
    *验证码的部分,
    $_first_code這个是验证码input里面输入的值
    $_end_code 這个是生成验证码的值
    */
   function _check_code($_first_code,$_end_code){
   if($_first_code!=$_end_code){
   	_alert_back('验证码输入不正确');
   }
   }

    function _check_username($_string,$_min=2,$_max=12){
  //去掉用户名两头的空格
   $_string=trim($_string);
   //mb_strlen(,'utf-8')這个判断中文也可以是两个位置,否责不加這个中文就占3个长度
  if(mb_strlen($_string,'utf-8')< $_min || mb_strlen($_string,'utf-8') > $_max){
    _alert_back('用户名长度小于'.$_min.'位或者大于'.$_max.'位');
  }
   //限制敏感字符的输入
   $_char_pattern='/[<>{}\'\"\ ]/';
   //preg_match() 這个是判断输入敏感字符,用户名中
   if(preg_match($_char_pattern,$_string)){
   _alert_back('用户名不能包含敏感字符');
   }

     //這个是通过数据库来进行转义
    return $_string;
  }

  /*
  *這个是密码的部分
  *$_first_pass 這个是那边传入过来的密码
  *$_end_pass  這个是那边传入过来的密码确认
   */
   function _check_password($_string,$_min_num=6){
    if(strlen($_string) < $_min_num){
          _alert_back('密码输入不能小于'.$_min_num.'位');
    }

    //将密码的返回,还要进行加密,就可以放到数据库里
    return sha1($_string);
   }

  function _check_time($_string){
   $_time=array('0','1','2','3');
    if(!in_array($_string,$_time)){
      _alert_back('保留字非法');
    }
    return $_string;
  }

     /*
   生成登录cookie的部分
    */
   function _setcookies($_username,$_uniqid,$_time){
   // setcookie('username',$_username);
   // setcookie('uniqid',$_uniqid);
    switch($_time){
     case 0:  //登录无保留时间
    setcookie('username',$_username);
    setcookie('uniqid',$_uniqid);
    break;
    case 1:   //登录时间为一天
    setcookie('username',$_username,time()+86400);
    setcookie('uniqid',$_uniqid,time()+86400);
    break;
    case 2:   //登录时间为一周
    setcookie('username',$_username,time()+604800);
    setcookie('uniqid',$_uniqid,time()+604800);
    break;
    case 3:   //登录时间为一月
    setcookie('username',$_username,time()+2592000);
    setcookie('uniqid',$_uniqid,time()+2592000);
    break;
    default:
    break;
    }

   } 





   ?>