window.onload=function(){
	code();
 //這个是表单部分的验证
  var fm=document.getElementsByTagName('form')[0];
   fm.onsubmit=function (){
   	//這个是密码验证的部分
   	if(fm.password.value!=''){
   	if(fm.password.value.length <6){
         alert('密码长度不能小于6位');
        fm.password.value='';  //這个是清空刚才写的内容
        fm.password.focus();   //這个是让他聚焦到那个地方
        return false;	
        }	
   	}
    //這个是电子邮件验证的部分 
     //邮箱验证的部分 bnbbns@qq.com 
       if(!/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(fm.email.value)){
        alert('邮箱格式输入不正确');
        fm.email.value='';  //這个是清空刚才写的内容
        fm.email.focus();   //這个是让他聚焦到那个地方
        return false;	
       }
    
       //這个是验证qq的部分,這个是qq为空也可以提交,所以要在前面加上一个判断
       if(fm.qq.value!=''){
       	if(!/[1-9]{1}[0-9]{4,9}/.test(fm.qq.value)){
       	alert('QQ号码输入不正确');
        fm.qq.value='';  //這个是清空刚才写的内容
        fm.qq.focus();   //這个是让他聚焦到那个地方
        return false;
       }
       }
      
       //這个是验证网址的部分 https:www.15yc.com,写正则表达式,最好的方法就是写一个正确的格式,然后自己去慢慢写进去 
      if(fm.url.value!=''){
       if(!/^https?:\/\/(\w+\.)?[\w\.\-]+(\.\w+)+$/.test(fm.url.value) || fm.url.value.length > 40){
        alert('网址输入不正确或网址过长');
        fm.url.value='';  //這个是清空刚才写的内容
        fm.url.focus();   //這个是让他聚焦到那个地方
        return false;
       }
      }
     
      //验证码的部分,在這里就是测试它是否4位就可以了
       if(fm.yzm.value.length!=6){
       	alert('验证码输入不正确');
        fm.yzm.value='';  //這个是清空刚才写的内容
        fm.yzm.focus();   //這个是让他聚焦到那个地方
        return false;
       } 
       return true;
}       




}