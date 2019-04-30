window.onload=function (){
	var faceimg=document.getElementById('faceimg');
  if(faceimg!=null){
    faceimg.onclick=function (){
    //window.open 是打开一个窗口,而第一个参数是页面,第二个是命名,第三个是CSS样式
    //windows.open(url,name,featrues,replace) url是路径,name是命名的名称,featrues是窗口的参数,replace是否替换历史的窗口
    window.open('face.php','face','width=400,height=400,left=0,top=0,scrollbars=1');
    //alert('');
  };
  }
	var code=document.getElementById('code');
  if(code!=null){
   //這个是code是验证码,当点击的时候,进行验证码进行切换
   code.onclick=function (){
    this.src='code.php?tm='+Math.random();
   } 
  }
	

   //這个是form表单提交的部分,用JS来验证码,记住要在getElementsByTagName()后面写数组才可以调用
   //否则不会实现该内容
    var fm=document.getElementsByTagName('form')[0];
    if(fm==null){
      return;
    }
     fm.onsubmit=function (){
       //用户名的验证
       if(fm.username.value.length< 2 || fm.username.value.length > 14){
        alert('用户名的长度不能小于2位或大于14位');
        fm.username.value='';  //這个是清空刚才写的内容
        fm.username.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }
       if(/[<>{}\'\"\ ]/.test(fm.username.value)){
        alert('用户名不能非法写入字符');
        fm.username.value='';  //這个是清空刚才写的内容
        fm.username.focus();   //這个是让他聚焦到那个地方
        return false;
       }

       //密码判断的部分
        if(fm.password.value.length <6){
         alert('密码长度不能小于6位');
        fm.password.value='';  //這个是清空刚才写的内容
        fm.password.focus();   //這个是让他聚焦到那个地方
        return false;	
        }

       //密码确认的部分
        if(fm.password.value !=fm.notpassword.value){
         alert('密码于密码确定输入的不一致');
        fm.notpassword.value='';  //這个是清空刚才写的内容
        fm.notpassword.focus();   //這个是让他聚焦到那个地方
        return false;	
        }

       //密码提问的部分
       if(fm.question.value.length< 2 || fm.question.value.length > 20){
        alert('密码提问的长度不能小于2位或大于20位');
        fm.question.value='';  //這个是清空刚才写的内容
        fm.question.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }
       
       //密码回答的部分
       if(fm.answer.value.length< 2 || fm.answer.value.length > 20){
        alert('密码回答的长度不能小于2位或大于20位');
        fm.answer.value='';  //這个是清空刚才写的内容
        fm.answer.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }

        if(fm.question.value ==fm.answer.value){
         alert('密码提示和密码回答不能一样');
        fm.answer.value='';  //這个是清空刚才写的内容
        fm.answer.focus();   //這个是让他聚焦到那个地方
        return false;	
        }
       
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

};