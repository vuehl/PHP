<?php
  //防止页面被其他的人调用
  if(!defined('IN_TG')){
  exit('Access Defined');
  }
?>

<div id="ubb">
       <img src="image/ubb1.jpg" title="字体大小" alt="字体大小" />
       <img src="image/ubb2.jpg" title="线条"     alt="线条"     />
       <img src="image/ubb3.jpg" title="字体加粗" alt="字体加粗" />
       <img src="image/ubb4.jpg" title="字体倾斜" alt="字体倾斜" />
       <img src="image/ubb5.jpg"  />
       <img src="image/ubb6.jpg"  />
       <img src="image/ubb7.jpg"  />
       <img src="image/ubb8.jpg" title="友情链接" alt="友情链接"  />
       <img src="image/ubb9.jpg" title="文本栏增加" alt="文本栏增加" />
       <img src="image/ubb10.jpg" title="文本栏减少" alt="文本栏减少"  />
      </div>
      <div id="font">
        <strong onclick="font(10)">10px</strong>
        <strong onclick="font(12)">12px</strong>
        <strong onclick="font(14)">14px</strong>
        <strong onclick="font(16)">16px</strong>
        <strong onclick="font(18)">18px</strong>
        <strong onclick="font(20)">20px</strong>
        <strong onclick="font(22)">22px</strong>
        <strong onclick="font(24)">24px</strong>    
      </div>
      <div id="color">
       <!--记住這个showcolor()這个里面的字符要加上字符串才正确,否则会出错哦-->
        <strong title="黑色" style="background:#000;" onclick="showcolor('#000')"></strong>
        <strong title="褐色" style="background:#930;" onclick="showcolor('#930')"></strong>
        <strong title="橄榄树" style="background:#330;" onclick="showcolor('#330')"></strong>
        <strong title="深绿" style="background:#000;" onclick="showcolor('#030')"></strong>
        <strong title="深青" style="background:#036;" onclick="showcolor('#036')"></strong>
        <strong title="亮蓝" style="background:#339;" onclick="showcolor('#339')"></strong>
        <strong title="灰色" style="background:#333;" onclick="showcolor('#333')"></strong>
        <strong title="深红" style="background:#800000;" onclick="showcolor('#800000')"></strong>
        <strong title="橙红" style="background:#f60;" onclick="showcolor('#f60')"></strong>      
        <em><input type="text" name="t" value="#000"></em>
      </div>