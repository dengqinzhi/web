使用教程：
1、后台主题设置—>自定义代码—>自定义 CSS 样式代码把下面的代码添加到里面

自定义 CSS 代码：

/*左边联系站长 css 开始*/
.contact-help{position: fixed; z-index: 101; left: 0; top: calc(50% - 30px); margin-top: -36px; width: 28px; height: 72px; transition: all .3s; font-size: 12px;background: var(--main-bg-color);border-radius: 0 5px 5px 0; padding: 8px 7px; line-height: 14px;}@media screen and (max-width: 768px){.contact-help{display:none;}}
/*左边联系站长 css 开始*/
2、在主题目录下 themes/zibll/footer.php 下，添加下面的 PHP 代码：

PHP 代码：

<!--左侧联系站长-->
<a href="http://wpa.qq.com/msgrd?v=3&uin=24427467&site=qq&menu=yes" target="_blank" class="contact-help main-shadow" style="font-weight:700;" />联系站长</a>
3、将第二步链接中的uin=1732765629，替换下填写你自己的qq账号即可。
