<?php

  //防止页面被其他的人调用,defined()這个函数就是为了防止让用户在导航哪里写就出来东西
  if(!defined('IN_TG')){
  exit('Access Defined');
  }
?>




<!--這个部分是方便用来前面index来掉用,减少代码,round()是让他显示几位,后面的4是让它显示小数点后四位-->
<div id="footer">
    <p>本程序执行所耗时间是:<?php echo round((_runtime() - START_TIME),4) ?>秒</p>
	<p>版本归国产115所有  翻版必究</p>
	<p>联系方式：电话 135***0729</p>
</div>







