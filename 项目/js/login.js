window.onload=function(){
	//這个是验证码的函数
	code();
	//這个是判断表单的提交
	fm=document.getElementsByTagName('form')[0];
	fm.onsubmit=function(){
		//用户名的验证
	   if(fm.username.value.length< 2 || fm.username.value.length > 14){
        alert('用户名的长度不能小于2位或大于14位');
        fm.username.value='';  //這个是清空刚才写的内容
        fm.username.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }
       if(/[<>《》{}\'\"\ ]/.test(fm.username.value)){
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
        
        //验证码的部分,在這里就是测试它是否4位就可以了
       if(fm.yzm.value.length!=6){
       	alert('验证码输入不正确');
        fm.yzm.value='';  //這个是清空刚才写的内容
        fm.yzm.focus();   //這个是让他聚焦到那个地方
        return false;
       }

	}
}