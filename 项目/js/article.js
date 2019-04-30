//這里面用的JS就是在html哪里没有登录的时候隐藏了代码,這里的JS要进行调节,让他等于null时,该怎么办,进行修改,不让他出错
window.onload=function (){
    //這个是发消息的部分
  var message=document.getElementsByName('message');
   for(var i=0;i<message.length;i++){
    message[i].onclick=function (){
    	centerWindows('message.php?id='+this.title,'message',250,400);
    }
   }
  //這个是添加好友的部分
  var friend=document.getElementsByName('friend');
  for(var i=0;i<friend.length;i++){
    friend[i].onclick=function (){
    	centerWindows('friend.php?id='+this.title,'friend',250,400);
    }
   }

  //這个是发送花朵的部分
  var flower=document.getElementsByName('flower');
  for(var i=0;i<flower.length;i++){
    flower[i].onclick=function (){
      centerWindows('flower.php?id='+this.title,'flower',250,400);
    }
    }
   //這个是回复几楼的部分
    var re=document.getElementsByName('re');
  for(var i=0;i<re.length;i++){
    re[i].onclick=function (){
  //這个是對几楼的标题内容进行修改
  document.getElementsByTagName('form')[0].title.value=this.title;    
    }
    }

//這个是验证码的部分;
	code();
		//這个是textarea哪里的ubb界面
	var ubb=document.getElementById('ubb');
	//這个是添加内容用的
    var fm=document.getElementsByTagName('form')[0];
    var font=document.getElementById('font');
    var color=document.getElementById('color');
    //這个是点击页面的时候,就会消失
    var html=document.getElementsByTagName('html')[0];
    //這个是onmouseup這个是,点击其他的地方這个就隐藏
     if(font!=null){
     html.onmouseup=function(){
     font.style.display='none';
     color.style.display='none';	
     }
    }
   //這个是QQ贴图的部分
    var q=document.getElementById('q');
    if(q!=null){
    var qa=q.getElementsByTagName('a');
    qa[0].onclick=function(){
    window.open('q.php?num=20&path=qpic/1/','q','width=400,height=200,scrollbars=1');
    }
    }
     if(ubb!=null){
    //這个是获取ubb下面的img图片
    var ubbimg=ubb.getElementsByTagName('img');
    ubbimg[0].onclick=function (){
     font.style.display='block';
    }
    ubbimg[2].onclick=function (){
     content('[b][/b]');
    }

    ubbimg[3].onclick=function (){
     content('[i][/i]');
    }

    ubbimg[4].onclick=function (){
     content('[u][/u]');
    }

    ubbimg[5].onclick=function (){
     content('[s][/s]');
    }

    ubbimg[6].onclick=function (){
      color.style.display='block';
      //這个是点击的时候让他聚焦在上面
      fm.t.focus();
    }
    ubbimg[7].onclick=function (){
     var url=prompt('请输入网址:','http://'); 
     if(url){
      if(/^https?:\/\/(\w+\.)?[\w\.\-]+(\.\w+)+/.test(url)){
        content('[url]'+url+'[/url]');	
    }else {
    	alert('输入的网址不合法');
    }
     }
    }
    ubbimg[8].onclick=function (){
     //注意這个在CSS里面不好获取到高度,所以就在html的页面上写rows来获取
      if(fm.content.rows < 25){
        fm.content.rows +=2;	
      }else {
         fm.content.rows=25;
         alert('不能再增加了,已经到底了');
      }
      }
     ubbimg[9].onclick=function (){
     //注意這个在CSS里面不好获取到高度,所以就在html的页面上写rows来获取
      fm.content.rows -=2;
      }
      }
     function content(string){
     //记住這里的content是要在textarea哪里定义了name的值才可以取的到,要注意
     fm.content.value += string;
    }
      if(fm!=undefined){
   //這个自己写的时候,点击就在textarea显示
     fm.t.onclick=function(){
     showcolor(this.value);
      } 
       }
       if(fm!=undefined){
       //這个是进行的JS验证
      fm.onsubmit=function (){
         //内容的验证
       if(fm.content.value.length< 2){
        alert('内容的长度不能小于2位');
        fm.content.value='';  //這个是清空刚才写的内容
        fm.content.focus();   //這个是让他聚焦到那个地方
        //return false 是防止服务器提交,然后他的信息填错就没有了 
        return false;
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


}

//這个是打开的窗口居中

function centerWindows(url,name,width,height){
 var left=(screen.width- width)/2;
 var top=(screen.height- height)/2;
 window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);

}
 //因为這个是html里面的onclick所以要放在onload的外面
function font(size){
	//這个是防止闭包的问题,就把fm替换出来就是了
	//fm=document.getElementsByTagName('form')[0]
   document.getElementsByTagName('form')[0].content.value+='[size='+size+'][/size]';
}
function showcolor(value){
  document.getElementsByTagName('form')[0].content.value+='[color='+value+'][/color]';
}




















