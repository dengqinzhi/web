<!-- 


很多站长的站点底部版权都要每年手动更换一次，

如果页面没有统一引用foot的话，要改起来就比较麻烦了。

今天教大家怎么实现自动获取当前年份并更新。

复制下面代码在网站全局foot下或者在需要显示的地方加入以下代码即可！

 -->

<script type="text/javascript">
<!-- Begin
copyright=new Date(); //取得当前的日期
update=copyright.getFullYear(); //取得当前的年份
document.write("&copy; Copyright 2019-"+ update + " All rights reserved. 资源宝版权所有");//update为自动更新的年份
// End -->
</script>
