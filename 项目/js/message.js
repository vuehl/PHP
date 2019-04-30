window.onload=function (){
  code();
  fm=document.getElementsByTagName('form')[0];
  fm.onsubmit=function(){
  	   //验证码的部分,在這里就是测试它是否4位就可以了
       if(fm.yzm.value.length!=6){
       	alert('验证码输入不正确');
        fm.yzm.focus();   //這个是让他聚焦到那个地方
        return false;
       }
        //内容的判断的部分
        if(fm.content.value.length<2){
         alert('短信的内容不能小于2位');
        fm.password.value='';  //這个是清空刚才写的内容
        fm.password.focus();   //這个是让他聚焦到那个地方
        return false;	
        }
       return true;
  }
}