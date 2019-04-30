<?php
   //防止外部文件调用
  if(!defined('IN_TG')){
  	exit('Access Defined');
  }

  //這个是验证相册名的部分
  function _check_username($_string,$_min=2,$_max=14){
   $_string=trim($_string);
    if(mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max ){
     _alert_back('相册名的长度不能小于'.$_min.'位和不能大于'.$_max.'位');
    }
   return $_string;
  }
   //這个是验证密码名的部分
     function _check_password($_string,$_min=6){
   $_string=trim($_string);
    if(mb_strlen($_string,'utf-8') < $_min){
     _alert_back('相册名的长度不能小于'.$_min.'位');
    }
   return sha1($_string);
  }

  //這个是上传图片的名称
  function _check_photo_name($_string,$_min=2,$_max=20){
  if(mb_strlen($_string,'utf-8') < $_min || mb_strlen($_string,'utf-8') > $_max){
   _alert_back('上传的图片名称不能小于'.$_min.'位和大于'.$_max.'位');
  }
  return $_string;
  }
  //这个是上传图片的路径
 

?>