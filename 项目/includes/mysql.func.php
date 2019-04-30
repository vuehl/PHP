<?php
  //這个是数据库的链接

 //防止外部文件调用
  if(!defined('IN_TG')){
  	exit('Access Defined');
   }
  //防止编码错误
  header('Content-Type:text/html;charset=utf-8');

  //数据库的调用
   define('DB_USER','root');
   define('DB_PWD','hl19971115xx');
   define('DB_HOST','localhost');
   define('DB_NAME','textguest');

  //把调用函数包装成函数,以便后面可以调用
  /*
  *_connect()這个是连接数据库

   */
  function _connect(){
  	//global是全局变量,這个可以是在函数里,别人在外部也可以调用,這个就可以获得句柄,然后在外面函数也可以调用到数据库
  	global $_conn;
   if(!$_conn=mysql_connect(DB_HOST,DB_USER,DB_PWD)){
    exit('数据库链接失败');
   }
   }

   /*
   *_select_db() 這个是选择一款数据库

    */
   function _select_db(){
   	if(!mysql_select_db(DB_NAME)){
     exit('数据库选择错误');
   	}
   }

   /*
    set_names() 這个是选择字符集错误
    */
  function _set_names(){
  	if(!mysql_query('SET NAMES UTF8')){
  		exit('选择字符集错误');
  	}
  }

  /*
  _query() 這个是执行函数,包装成函数可以减少代码
   */
  function _query($_sql){
  if(!$_result=mysql_query($_sql)){
   exit('SQL语句执行失败');
  }
  return $_result;
  }

  /*
  
  _fetch_array()這个函数是让返回的结果集,来查看用户名是否被注册
  但這个是只能是一个数组,输出出来
   */

  function _fetch_array($_sql){
  return mysql_fetch_array(_query($_sql),MYSQL_ASSOC);
  }

  /*
   _fetch_array_list 這个是可以输出所有的数组
   */
function _fetch_array_list($_sql){
  return mysql_fetch_array($_sql,MYSQL_ASSOC);
}
 /*
  _num_rows()這个函数是返回数据库中有多少条数据
  $_result 這个参数是从_query("SELECT tg_id FROM tg_user")哪里返回出来的数据结果
  */
 function _num_rows($_result){
 return mysql_num_rows($_result);
 }

  /*
  _is_respeat() 這个函数是更加的封装完美
   $_sql 這个是mysql语句
   $_info 這个是报错的信息
   */

   function _is_respeat($_sql,$_info){
    if(_fetch_array($_sql)){   //這个是如果数据库里有這个用户名,就打印出不能注册
    	_alert_back($_info);
    }
   }

   /*
   _close(); 关闭数据库 
    */
    function _close(){
    	if(!mysql_close()){
    		exit('关闭数据库异常');
    	};
    } 

   /*
   *_fetch_rows() 這个是影响一行,就是当注册成功时,返回1
    */

   function _affected_rows(){
   	return mysql_affected_rows();
   }


   /*
   _free_result 销毁结果集
    */
    function _free_result($_result){
     mysql_free_result($_result);
    }
?>