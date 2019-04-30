<?php
global $_system;
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

   /*
    這个是唯一性权限,就是防止别人的伪战攻击
     $_first_uniqid 是input哪里的value值
     $_end_uniqid 這个是$_SESSION权限的值
    */
   function _check_uniqid($_first_uniqid,$_end_uniqid){
   	if(strlen($_first_uniqid)!=40 || ($_first_uniqid!=$_end_uniqid)){
           _alert_back('唯一标识符不正确');
   	}
   	return $_first_uniqid;
   }
  /*
  检查用户名的函数,
  這里传的$_min是最少的长度,$_max 是最大的长度,还设置了默认值,还可以设置其他的值
  这样写的灵活度就会很高,這样字写默认是,当写入其他的时候就会冲突
  這个是用户名的函数
   */
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

   //限制敏感用户名的输入
  
   $_mg[0]='胡林';
   $_mg[1]='何尧';
   $_mg[2]='何磊';
   $_mg[3]='彭宇';
   $_mg[4]='刘松源';
   $_mg[5]='王栋钢';
    /*
    $_mg=explode('|',$_system['string']);
    foreach($_mg as $value){
    $_mg_string.='['.$value.']'.'/n';
    }
    */
   //這里的in_array()是采用的绝对匹配,要注意這里的in_array()這里是$_string在前面
   if(in_array($_string,$_mg)){
   	_alert_back($_mg_string.'管理员用户名不能注册');
   }
     //這个是通过数据库来进行转义
    return $_string;
  }

  /*
  *這个是密码的部分
  *$_first_pass 這个是那边传入过来的密码
  *$_end_pass  這个是那边传入过来的密码确认
   */
   function _check_password($_first_pass,$_end_pass,$_min_num){
   	if(strlen($_first_pass) < $_min_num){
          _alert_back('密码输入不能小于'.$_min_num.'位');
   	}

   	//這个是密码和密码确认的部分
    if($_first_pass!=$_end_pass){
    	_alert_back('密码两次输入不一致');
    }
   	//将密码的返回,还要进行加密,就可以放到数据库里
   	return sha1($_first_pass);
   }
   /*
   *這个是密码提示的部分
   $_string 是在那边传入过来的字符串
    */
   function _check_question($_string,$_min_num=4,$_max_num=20){
    if(mb_strlen($_string,'utf-8')<$_min_num || mb_strlen($_string,'utf-8')>$_max_num){
    	_alert_back('密码提示不能小于'.$_min_num.'位和不能大于'.$_max_num.'位');
    }

    //返回密码的提示,还可以进行转义,保存在数据库里,返回还可以在前面调用,用来保存在数据库里
   return $_string;
  
   }

   /*這个是密码回答的部分
   * $_question是对应的qq提示的问题
   * $_answer 這个是对应的回答
   */

   function _check_answer($_question,$_answer,$_min_num=4,$_max_num=20){
    //這个是判断密码回答的长度
    if(mb_strlen($_answer,'utf-8') < $_min_num || mb_strlen($_answer,'utf-8') >$_max_num){
     _alert_back('密码回答的长度不能小于'.$_min_num.'位和不能大于'.$_max_num.'位');
   }
    //并且输入密码和密码提示不能一样
    if($_question == $_answer){
    	_alert_back('密码提示与密码回答不能一致');
    }
     //這个是用来返回输入的密码回答,还需要加密保存在数据库中
    
    return sha1($_answer);
    }

   /*
   *_check_email是邮箱的验证
   *$_string 是哪里传过来的邮件($_POST['email']);
    */

   function _check_email($_string){
   	 //這个empty()函数是判断当邮件是空的能提交,当写入不正确就不能提交了
   	 // if(empty($_string)){
   	   //這个是当里面写入为空邮件时,就会返回为null
   	  //	return null;
   	 // }else{
   	  //這里是用正则表达式来判断preg_match()则是正则表达式
   	 //当正则表达式是要写一个例子,便于好改和操作如：/^(bnbns)(@)(163)\.(com)$/
   	 //切记在正则前面还要加单引号用()代表的是一个整体(\w\.+)代表的是可以多个.com什么之类的
   	 //一定要记住在该有的小部分写上+ 代表是一个或则多个,否则会出错
   	  if(!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/',$_string)){
        _alert_back('邮件格式不正确！');
      }	
   	 // }
   	 
   //返回结果集
   return $_string;
   }

   /*
    *這个是QQ的验证
    *_check_qq()
   */
    function _check_qq($_string){
    	if(empty($_string)){
         return null;
    	}else {
    	//這个是qq的验证,记住要强制开头和结尾
    if(!preg_match('/^[1-9]{1}[0-9]{4,9}$/',$_string)){
        _alert_back('QQ号码不正确!');
          }
        }
     //返回的qq的结果
    return $_string;
    }

  /*
  
   *网址的验证
   $_string 這个是那边传入过来的值
  */

  function _check_url($_string){
  if(empty($_string) || ($_string=='http://')){
  	//這个是当输入为空时,就让他返回值为null
  return null;
  }else {
  	//這个是验证网址的部分
  	//?代表的是他的前导字符的一次或者0次 
  	//http://www.yc60.com ,并且/是要进行转义的
  	//切记当特别是网站地址是要先写转移的\ 再写/否则会错,切记写反是,正则不会出现有颜色的字
  	//切记当在[]中括号里面是\w后面是不能添加+,[]中括号代表的是整体是一个字符,否则会出错,而在()小括号里面的\w后面就后面添加+
  	//并要要注意\.写在\w的前面还是后面都有规则的,在最后面\.就要写在\w的后面,记住
  	if(!preg_match('/^http(s)?:\/\/(\w+\.)?[\w\.\-]+(\.\w+)+$/',$_string)){
  		_alert_back('你输入的网址不正确!');
  	}
  }

    //用来返回结果集
   return $_string;
  }

 /*
 這个是将密码部分的返回
  */
  function _check_modify_password($_string,$_min_num=6){
   if(!empty($_string)){
     if(strlen($_string)< $_min_num){
      _alert_back('密码的长度不能小于'.$_min_num.'位');
     }
   }else {
    $_string=null;
   }
    return sha1($_string);
  }

  /*這个是检查发送短信的多少*/
  function _check_content($_string){
  if(mb_strlen($_string,'utf-8')< 10 || mb_strlen($_string,'utf-8')> 200){
    _alert_back('发送短信的内容不能小于10位或者大于200位！');
  }
    return $_string;
  }

  /*這个是个性签名不能大于200位*/
   function _check_autograph($_string,$_num=200){
  if(mb_strlen($_string,'utf-8')>$_num){
    _alert_back('发送短信的内容不能大于'.$_num.'位！');
  }
    return $_string;
  }


?>