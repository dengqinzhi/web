首先，打开你的主题的"functions.php",拉倒较后面，在较后一行的 “?>” 前面添加如下代码：

/**
* 痴痴WordPress 登录界面美化
**/
function custom_login_style() {
    echo '<link rel="stylesheet" id="wp-admin-css" href="'.get_bloginfo('template_directory').'/admin-style.css" type="text/css" />';
}
add_action('login_head', 'custom_login_style');
再新建一个css文件，命名为“admin-style.css”，css内容如下：

body{
    font-family: "Microsoft YaHei", Helvetica, Arial, Lucida Grande, Tahoma, sans-serif;
    width:100%;
    height:100%;
    background: url(http://img.infinitynewtab.com/InfinityWallpaper/2_14.jpg) no-repeat;
    -moz-background-size: cover;    /*背景图片拉伸以铺满全屏*/
    -ms-background-size: cover;
    -webkit-background-size: cover;
    background-size: cover;
}
/*顶部的logo*/
.login h1 a {
    background:url(images/logo.png) no-repeat;
    background-size: 220px 50px;
    width: 220px;
    height: 50px;
    padding: 0;
    margin: 0 auto 1em;
    border: none;
    -webkit-animation: dropIn 1s linear;
    animation: dropIn 1s linear;
}
/*登录框表单*/
.login form, .login .message {
    background: #fff;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
    border: 1px solid #fff;
    border: 1px solid rgba(255, 255, 255, 0.4);
    -webkit-animation: fadeIn 1s linear;
    animation: fadeIn 1s linear;
}
/*登录框输入框*/
.login label {
    color: #000;
}
.login .message {
    color: #000;
}
#user_login{
    font-size: 18px;
    line-height: 32px;
}
/* 返回博客与忘记密码链接 */
#backtoblog a, #nav a {
    color: #fff !important;
    display: inline-block;
    -webkit-animation: rtol 1s linear;
    animation: rtol 1s linear;
}
/*掉落的动画效果*/
@-webkit-keyframes dropIn {
    0% {
        -webkit-transform: translate3d(0, -100px, 0)
    }
    100% {
        -webkit-transform: translate3d(0, 0, 0)
    }
}
@keyframes dropIn {
    0% {
        transform: translate3d(0, -100px, 0)
    }
    100% {
        transform: translate3d(0, 0, 0)
    }
}
/*逐渐出现的动画效果*/
@-webkit-keyframes fadeIn {
    from {
        opacity: 0;
        -webkit-transform: scale(.8) translateY(20px)
    }
    to {
        opacity: 1;
        -webkit-transform: scale(1) translateY(0)
    }
}
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(.8) translateY(20px)
    }
    to {
        opacity: 1;
        transform: scale(1) translateY(0)
    }
}
/*从右往左的动画效果*/
@-webkit-keyframes rtol {
    from {
        -webkit-transform: translate(80px, 0)
    }
    to {
        -webkit-transform: translate(0, 0)
    }
}
@keyframes rtol {
    from {
        transform: translate(80px, 0)
    }
    to {
        transform: translate(0, 0)
    }
}
你可以自由修改第5行的背景图片和第14行的logo图片。修改好后保存，并上传到当前主题的目录即可。

完了，就这么简单……

注：以上CSS样式仿照自知更鸟
