window.onload=function (){
  //這个是上传图片的部分
  var up=document.getElementById('up');
  up.onclick=function (){
  centerWindows('upimg.php?dir='+this.title,'upimg','400','100');
  };
  //這个是上传图片的部分
  var form=document.getElementsByTagName('form')[0];
  form.onsubmit=function (){
  	//這个是图片名的部分
  	if(form.name.value.length <2 || form.name.value.length >20){
     alert('图片名称不的小于2位和大于20位');
     form.name.focus();
    return false;
  	}
  	//這个是图片地址的部分
  	if(form.url.value==''){
     alert('图片的路径不能为空');
     form.url.focus();
    return false;
  	}
  	return true;
  }


}


//這个是打开的窗口居中

function centerWindows(url,name,width,height){
 var left=(screen.width- width)/2;
 var top=(screen.height- height)/2;
 window.open(url,name,'width='+width+',height='+height+',top='+top+',left='+left);

}