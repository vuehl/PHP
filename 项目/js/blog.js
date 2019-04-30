window.onload=function (){
  //這个是发消息的部分
  var message=document.getElementsByName('message');
   for(var i=0;i<message.length;i++){
    message[i].onclick=function (){
    	centerWindows('message.php?id='+this.title,'message','250','400');
    }
   }
  //這个是添加好友的部分
  var friend=document.getElementsByName('friend');
  for(var i=0;i<friend.length;i++){
    friend[i].onclick=function (){
    	centerWindows('friend.php?id='+this.title,'friend','250','400');
    }
   }

  //這个是发送花朵的部分
  var flower=document.getElementsByName('flower');
  for(var i=0;i<flower.length;i++){
    flower[i].onclick=function (){
      centerWindows('flower.php?id='+this.title,'flower','250','400');
    }
   }


}


//這个是打开的窗口居中

function centerWindows(url,name,width,height){
 var left=(screen.width- width)/2;
 var top=(screen.height- height)/2;
 window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);

}







