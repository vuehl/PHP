//這个是用循环来实现,图片的选择
window.onload=function (){
	var img=document.getElementsByTagName('img');
	for(var i=0;i<img.length;i++){
		img[i].onclick=function (){
			//因为src传递的地址值太长了,所以用alt的值,获取的值少点，方便些
			_opener(this.alt);
		}
	}
};

function _opener(src){
 //opener 是打开父窗口的意思,而這个定义的register里的有faceimg则是父窗口
// var faceimg=opener.document.getElementById('faceimg');
   // faceimg.src=src;   //通过 這个便达到跟换图像的目的
   //這个是获取图片的父窗口的下面的register是form的name命名,face也是name的值
   //opener.document.register.face.value=src;
  opener.document.getElementsByTagName('form')[0].content.value+='[img]'+src+'[/img]';
}