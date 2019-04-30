//這个是验证码的函数,以后点用函数就是了

  function code(){
  	var code=document.getElementById('code');
  	//這个是判断,当回复的界面当没有登录的时候就没有,就没有验证码,就看不到,就会报错
  	if(code!=null){
    code.onclick=function (){
    this.src='code.php?tm='+Math.random();
   }	
  	}
  }





