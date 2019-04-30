window.onload=function (){
var all=document.getElementById('all');
var form=document.getElementsByTagName('form')[0];
all.onclick=function (){
  //elements.length這个长度是代表form里面的所有元素
  //checked表示已选
  for(var i=0;i<form.elements.length;i++){
   if(form.elements[i].name!='chkall'){
   	 form.elements[i].checked=form.chkall.checked;
   }
  }
}
  //form是批删除的部分
 form.onsubmit=function (){
 	if(confirm('你确定要删除這批数据吗?')){
     return true;
 	}else {
 	 return false;
 	}
 }


}