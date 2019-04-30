window.onload=function (){
 var ret=document.getElementById('return');
 var del=document.getElementById('delete');

 //点击返回的列表的部分
  ret.onclick=function (){
   history.back();
  }
   
  //這个是删除列表的部分
  del.onclick=function (){
  	if(confirm('确定要删除吗?')){
      location.href='?action=delete&id='+this.name;
  	}

  }

}