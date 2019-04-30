window.onload=function (){
var pass=document.getElementById('pass');
var form=document.getElementsByTagName('form')[0];
 //這个form[1]代表的是form下面的第几个input标签,form[1]代表的是第二个标签
 form[1].onclick=function (){
  pass.style.display='none';
 }
 
 form[2].onclick=function (){
  pass.style.display='block';
 }
 
 //这个是提交的部分验证
 form.onsubmit=function (){
    //相册名的验证
       if(form.name.value.length< 2 || form.name.value.length > 14){
        alert('相册名的长度不能小于2位或大于14位');
        form.name.value='';  //這个是清空刚才写的内容
        form.name.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }
   //這个是判断私密的部分,因为在类型是radio有两个相同的name,所以通过這个来选取
      if(form[2].checked){
      	if(form.password.value.length< 6){
         alert('密码的长度不能小于6位');
        form.password.value='';  //這个是清空刚才写的内容
        form.password.focus();   //這个是让他聚焦到那个地方
      	//return false 是防止服务器提交,然后他的信息填错就没有了 
       	return false;
       }
       }
      return true;
       }

}