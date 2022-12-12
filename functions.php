<?php

$themedata = wp_get_theme();$themeversion = $themedata['Version'];
define('THEME_VERSION', $themeversion);
define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/module/theme_panel_set/' );
require_once dirname( __FILE__ ) . '/module/theme_panel_set/options-framework.php';
require_once dirname( __FILE__ ) . '/module/theme_panel_set/panel-js.php';
$optionsfile = locate_template( 'options.php' );load_template( $optionsfile );
require_once get_stylesheet_directory() . '/module/config/fun-navwalker.php';
require_once get_stylesheet_directory() . '/module/config/fun-optimize.php';
require_once get_stylesheet_directory() . '/module/config/fun-global.php';
require_once get_stylesheet_directory() . '/module/config/fun-mail.php';
require_once get_stylesheet_directory() . '/module/config/fun-user.php';
require_once get_stylesheet_directory() . '/module/config/fun-seo.php';
require_once get_stylesheet_directory() . '/module/config/fun-comments.php';
require_once get_stylesheet_directory() . '/module/config/fun-admin.php';
require_once get_stylesheet_directory() . '/module/config/fun-article.php';
require_once get_stylesheet_directory() . '/module/config/fun-shortcode.php';
require_once get_stylesheet_directory() . '/module/config/fun-bot.php';
if( get_boxmoe('no_categoty') ) require_once get_stylesheet_directory() . '/module//config/fun-no-category.php';

//自定义代码写在下方，主题更新注意自行备份自定义代码
//评论框今日诗词
function dr_show_jinrishici(){
	if( is_single() || is_page() ){
    	echo '<script src="https://sdk.jinrishici.com/v2/browser/jinrishici.js" charset="utf-8"></script> <script type="text/javascript"> jinrishici.load(function(result) { var id = "comment", c = result.data.content+" ---- "+result.data.origin.dynasty+"·"+result.data.origin.author+"《"+result.data.origin.title+"》"; if (document.getElementById(id)){ document.getElementById(id).placeholder=c; } }); </script>';
	}
}
add_action( 'wp_footer', 'dr_show_jinrishici' );

//wp-login.php添加相关参数
add_action('login_enqueue_scripts','login_protection');  
function login_protection(){  
    if($_GET['name'] != 'qinzhi')header('Location: https://qinzhi.cc/888');  
}


/** 图自动加alt和title标签属性 */
function image_alt_tag($content){
    global $post;preg_match_all('/<img (.*?)\/>/', $content, $images);
    if(!is_null($images)) {foreach($images[1] as $index => $value)
    {$new_img = str_replace('<img', '<img alt="'.get_the_title().'-'.get_bloginfo('name').'" title="'.get_the_title().'-'.get_bloginfo('name').'"', $images[0][$index]);
    $content = str_replace($images[0][$index], $new_img, $content);}}
    return $content;
}
add_filter('the_content', 'image_alt_tag', 99999);
/** 自动给图片添加alt和title标签www.qfya.com */




/*Wordpress文章关键词自动添加内链链接代码
*/
//连接数量
 $match_num_from = 1; //一个关键字少于多少不替换
 $match_num_to = 1; //一个关键字最多替换次数
 //连接到WordPress的模块
 add_filter('the_content','tag_link',1);
 //按长度排序
 function tag_sort($a, $b){
 if ( $a->name == $b->name ) return 0;
 return ( strlen($a->name) > strlen($b->name) ) ? -1 : 1;
 }
 //改变标签关键字
 function tag_link($content){
 global $match_num_from,$match_num_to;
 $posttags = get_the_tags();
 if ($posttags) {
 usort($posttags, "tag_sort");
 foreach($posttags as $tag) {
 $link = get_tag_link($tag->term_id);
 $keyword = $tag->name;
 //连接代码
 $cleankeyword = stripslashes($keyword);
 $url = "<a href=\"$link\" title=\"".str_replace('%s',addcslashes($cleankeyword, '$'),__('查看所有文章关于 %s'))."\"";
 $url .= 'target="_blank"';
 $url .= ">".addcslashes($cleankeyword, '$')."</a>";
 $limit = rand($match_num_from,$match_num_to);
 //不连接的代码
 $content = preg_replace( '|(<a[^>]+>)(.*)('.$ex_word.')(.*)(</a[^>]*>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
 $content = preg_replace( '|(<img)(.*?)('.$ex_word.')(.*?)(>)|U'.$case, '$1$2%&&&&&%$4$5', $content);
 $cleankeyword = preg_quote($cleankeyword,'\'');
 $regEx = '\'(?!((<.*?)|(<a.*?)))('. $cleankeyword . ')(?!(([^<>]*?)>)|([^>]*?</a>))\'s' . $case;
 $content = preg_replace($regEx,$url,$content,$limit);
 $content = str_replace( '%&&&&&%', stripslashes($ex_word), $content);
 }
 }
 return $content; 
 }
/*Wordpress文章关键词自动添加内链链接代码
*/



/*鼠标跟踪开始*/
// 加载jquery开始，如果主题已加载不加这段。
function zm_jquery_script() {
	wp_enqueue_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'zm_jquery_script' );
// 加载jquery结束
function zm_mouse_cursor() { ?>
<!-- 必须的DIV -->
<div class="mouse-cursor cursor-outer"></div>
<div class="mouse-cursor cursor-inner"></div>
<!-- JS脚本 -->
<script>
jQuery(document).ready(function($){
	var myCursor = jQuery('.mouse-cursor');
	if (myCursor.length) {
		if ($('body')) {
			const e = document.querySelector('.cursor-inner'),
			t = document.querySelector('.cursor-outer');
			let n,
			i = 0,
			o = !1;
			window.onmousemove = function(s) {
				o || (t.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)"),
				e.style.transform = "translate(" + s.clientX + "px, " + s.clientY + "px)",
				n = s.clientY,
				i = s.clientX
			},
			$('body').on("mouseenter", "a, .cursor-pointer",
			function() {
				e.classList.add('cursor-hover'),
				t.classList.add('cursor-hover')
			}),
			$('body').on("mouseleave", "a, .cursor-pointer",
			function() {
				$(this).is("a") && $(this).closest(".cursor-pointer").length || (e.classList.remove('cursor-hover'), t.classList.remove('cursor-hover'))
			}),
			e.style.visibility = "visible",
			t.style.visibility = "visible"
		}
	}
})
 
</script>
<!-- 样式 -->
<style>
.mouse-cursor {
	position: fixed;
	left: 0;
	top: 0;
	pointer-events: none;
	border-radius: 50%;
	-webkit-transform: translateZ(0);
	transform: translateZ(0);
	visibility: hidden
	}
 
.cursor-inner {
	margin-left: -3px;
	margin-top: -3px;
	width: 6px;
	height: 6px;
	z-index: 10000001;
	background: #ffa9a4;
	-webkit-transition: width .3s ease-in-out,height .3s ease-in-out,margin .3s ease-in-out,opacity .3s ease-in-out;
	transition: width .3s ease-in-out,height .3s ease-in-out,margin .3s ease-in-out,opacity .3s ease-in-out
}
 
.cursor-inner.cursor-hover {
	margin-left: -18px;
	margin-top: -18px;
	width: 36px;
	height: 36px;
	background: #ffa9a4;
	opacity: .3
}
 
.cursor-outer {
	margin-left: -15px;
	margin-top: -15px;
	width: 30px;
	height: 30px;
	border: 2px solid #ffa9a4;
	-webkit-box-sizing: border-box;
	box-sizing: border-box;
	z-index: 10000000;
	opacity: .5;
	-webkit-transition: all .08s ease-out;
	transition: all .08s ease-out
}
 
.cursor-outer.cursor-hover {
	opacity: 0
}
 
.main-wrapper[data-magic-cursor=hide] .mouse-cursor {
	display: none;
	opacity: 0;
	visibility: hidden;
	position: absolute;
	z-index: -1111
}
	
</style>
<?php }
add_action( 'wp_footer', 'zm_mouse_cursor' );
//鼠标跟踪结束


// 文章字数统计
function zm_count_words ($text) {
	global $post;
	if ( '' == $text ) {
		$text = $post->post_content;
		if (mb_strlen($output, 'UTF-8') < mb_strlen($text, 'UTF-8')) $output .= '<span class="word-count">本文共' . mb_strlen(preg_replace('/\s/','',html_entity_decode(strip_tags($post->post_content))),'UTF-8') .'字</span>';
		return $output;
	}
}

// 阅读时间
function zm_get_reading_time($content) {
	$zm_format = '<span class="reading-time">预估阅读时间%min%分%sec%秒</span>';
	$zm_chars_per_minute = 300; // 估算1分种阅读字数
 
	$zm_format = str_replace('%num%', $zm_chars_per_minute, $zm_format);
	$words = mb_strlen(preg_replace('/\s/','',html_entity_decode(strip_tags($content))),'UTF-8');
 
	$minutes = floor($words / $zm_chars_per_minute);
	$seconds = floor($words % $zm_chars_per_minute / ($zm_chars_per_minute / 60));
	return str_replace('%sec%', $seconds, str_replace('%min%', $minutes, $zm_format));
}
 
function zm_reading_time() {
	echo zm_get_reading_time(get_the_content());
}



// 添加随便看看（BY www.98dou.cn）
function random_postlite() {
global $wpdb;
$query = "SELECT ID FROM $wpdb->posts WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
if ( isset( $_GET['random_cat_id'] ) ) {
$random_cat_id = (int) $_GET['random_cat_id'];
$query = "SELECT DISTINCT ID FROM $wpdb->posts AS p INNER JOIN $wpdb->term_relationships AS tr ON (p.ID = tr.object_id AND tr.term_taxonomy_id = $random_cat_id) INNER JOIN $wpdb->term_taxonomy AS tt ON(tr.term_taxonomy_id = tt.term_taxonomy_id AND taxonomy = 'category') WHERE post_type = 'post' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
}
if ( isset( $_GET['random_post_type'] ) ) {
$post_type = preg_replace( '|[^a-z]|i', '', $_GET['random_post_type'] );
$query = "SELECT ID FROM $wpdb->posts WHERE post_type = '$post_type' AND post_password = '' AND post_status = 'publish' ORDER BY RAND() LIMIT 1";
}
$random_id = $wpdb->get_var( $query );
wp_redirect( get_permalink( $random_id ) );
exit;
}
if ( isset( $_GET['random'] ) )
add_action( 'template_redirect', 'random_postlite' );
// 随便看看结束（BY www.98dou.cn）


//WordPress 百度主动推送功能

if(!function_exists('Baidu_Submit')){
 function Baidu_Submit($post_ID) {
 $WEB_TOKEN = 'C9T7wdBML99PdW6I'; //这里请换成你的网站的百度主动推送的token值
 $WEB_DOMAIN = get_option('home');
 //已成功推送的文章不再推送
 if(get_post_meta($post_ID,'Baidusubmit',true) == 1) return;
 $url = get_permalink($post_ID);
 $api = 'http://data.zz.baidu.com/urls?site='.$WEB_DOMAIN.'&token='.$WEB_TOKEN;
 $request = new WP_Http;
 $result = $request->request( $api , array( 'method' => 'POST', 'body' => $url , 'headers' => 'Content-Type: text/plain') );
 $result = json_decode($result['body'],true);
 //如果推送成功则在文章新增自定义栏目Baidusubmit，值为1
 if (array_key_exists('success',$result)) {
 add_post_meta($post_ID, 'Baidusubmit', 1, true);
 }
 }
 add_action('publish_post', 'Baidu_Submit', 0);
}
//WordPress 百度主动推送功能





//说说功能
function my_custom_shuoshuo_init() {
$labels = array(
'name' => '说说',
'singular_name' => '说说',
'all_items' => '所有说说',
'add_new' => '发表说说',
'add_new_item' => '撰写新说说',
'edit_item' => '编辑说说',
'new_item' => '新说说',
'view_item' => '查看说说',
'search_items' => '搜索说说',
'not_found' => '暂无说说',
'not_found_in_trash' => '没有已遗弃的说说',
'parent_item_colon' => '',
'menu_name' => '说说'
);
$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'show_in_menu' => true,
'query_var' => true,
'rewrite' => true,
'capability_type' => 'post',
'has_archive' => true,
'hierarchical' => false,
'menu_position' => null,
'supports' => array('title','editor','author')
);
register_post_type('shuoshuo',$args);
}
add_action('init', 'my_custom_shuoshuo_init');


/*****************************************************
 函数名称：wp_login_notify v1.0 by DH.huahua. 
 函数作用：有登录wp后台就会email通知博主
******************************************************/
function wp_login_notify()
{
    date_default_timezone_set('PRC');
    $admin_email = get_bloginfo ('admin_email');
    $to = $admin_email;
  $subject = '你的博客空间登录提醒';
  $message = '<p>你好！你的博客空间(' . get_option("blogname") . ')有登录！</p>' . 
  '<p>请确定是您自己的登录，以防别人攻击！登录信息如下：</p>' . 
  '<p>登录名：' . $_POST['log'] . '<p>' .
  '<p>登录密码：' . $_POST['pwd'] .  '<p>' .
  '<p>登录时间：' . date("Y-m-d H:i:s") .  '<p>' .
  '<p>登录IP：' . $_SERVER['REMOTE_ADDR'] . '<p>';  
  $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
  $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
  $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
  wp_mail( $to, $subject, $message, $headers );
}
add_action('wp_login', 'wp_login_notify');

/*****************************************************
 函数名称：wp_login_failed_notify v1.0 by DH.huahua. 
 函数作用：有错误登录wp后台就会email通知博主
******************************************************/
function wp_login_failed_notify()
{
    date_default_timezone_set('PRC');
    $admin_email = get_bloginfo ('admin_email');
    $to = $admin_email;
  $subject = '你的博客空间登录错误警告';
  $message = '<p>你好！你的博客空间(' . get_option("blogname") . ')有登录错误！</p>' . 
  '<p>请确定是您自己的登录失误，以防别人攻击！登录信息如下：</p>' . 
  '<p>登录名：' . $_POST['log'] . '<p>' .
  '<p>登录密码：' . $_POST['pwd'] .  '<p>' .
  '<p>登录时间：' . date("Y-m-d H:i:s") .  '<p>' .
  '<p>登录IP：' . $_SERVER['REMOTE_ADDR'] . '<p>';  
  $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
  $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
  $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
  wp_mail( $to, $subject, $message, $headers );
}
add_action('wp_login_failed', 'wp_login_failed_notify');


//新增点击量并允许排序
add_filter('manage_posts_columns', function($columns){
$columns['views'] = __('点击量');
return $columns;
});

add_action('manage_posts_custom_column',function($column_name,$id){
if ($column_name != 'views'){
return;
}
if ( get_post_meta($id, "views",true) == '' ){
echo '0';
} else {
echo get_post_meta($id, "views",true);
}
},10,2);

add_filter( 'manage_edit-post_sortable_columns', function ( $columns ) {
    $columns['views'] = 'views';
    return $columns;  
});
add_action( 'load-edit.php', function() {  
    add_filter( 'request', 'qui_sort_views' );  
});
function qui_sort_views( $vars ) {     
  if ( isset( $vars['orderby'] ) && 'views' == $vars['orderby'] ) {  
$vars = array_merge(  
$vars,  
array(  
'meta_key' => 'views',  
'orderby' => 'meta_value_num'  
)  
);  
}   
return $vars;  
}

//从插入的图像中删除宽度和高度属性
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );
 
function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}




//支持WEBP

function webp_filter_mime_types( $array ) {
$array['webp'] = 'image/webp';
return $array;
}
add_filter( 'mime_types', 'webp_filter_mime_types', 10, 1 );
function webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    return $existing_mimes;
}
add_filter('mime_types', 'webp_upload_mimes');


function webp_file_is_displayable_image($result, $path) {
$info = @getimagesize( $path );
if($info['mime'] == 'image/webp') {
$result = true;
}
return $result;
}
add_filter( 'file_is_displayable_image', 'webp_file_is_displayable_image', 10, 2 );
function webp_is_displayable($result, $path) {
if ($result === false) {
$displayable_image_types = array( IMAGETYPE_WEBP );
$info = @getimagesize( $path );
if (empty($info)) {
$result = false;
} elseif (!in_array($info[2], $displayable_image_types)) {
$result = false;
} else {
$result = true;
}
}
return $result;
}
add_filter('file_is_displayable_image', 'webp_is_displayable', 10, 2);



//调用bing美图作为登录页背景图
function custom_login_head(){
    $str=file_get_contents('http://cn.bing.com/HPImageArchive.aspx?format=js&idx=0&n=1');
    if (preg_match("/\/(.+?).jpg/", $str, $matches)) {
        $imgurl='http://s.cn.bing.net'.$matches[0];
    }
    echo'<style type="text/css">body{background: url('.$imgurl.');background-image:url('.$imgurl.');-moz-border-image: url('.$imgurl.');}</style>';
}
add_action('login_head', 'custom_login_head');






// 回复评论发送邮件通知
add_action('phpmailer_init', 'fanly_mail_smtp');
function fanly_mail_smtp( $phpmailer ) {
  $phpmailer->IsSMTP();
  $phpmailer->SMTPAuth = true;
  $phpmailer->Port = 465;
  $phpmailer->SMTPSecure ="ssl";
  $phpmailer->Host = "smtp.126.com";// ★ 邮箱的 SMTP 服务器地址
  $phpmailer->Username = "toneydeng@126.com";// ★ 邮箱账号或者发信邮箱
  $phpmailer->Password ="dyt19830212";// ★ 密码或者授权码
}
add_filter( 'wp_mail_from', 'fanly_wp_mail_from' );
function fanly_wp_mail_from() {
  return 'toneydeng@126.com';// ★ 发件邮箱
}

function fanly_comment_mail_notify($comment_id) {
    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
    $comment = get_comment($comment_id);
    $parent_id = $comment->comment_parent ? $comment->comment_parent : '';
    $spam_confirmed = $comment->comment_approved;
    if (($parent_id != '') && ($spam_confirmed != 'spam')) {
        $wp_email = 'no-reply@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
        $to = trim(get_comment($parent_id)->comment_author_email);
        $subject = trim(get_comment($parent_id)->comment_author) . ',您在 [' . $blogname . '] 中的留言有新的回复啦！';
        $message = '<div style="color:#555;font:12px/1.5 微软雅黑,Tahoma,Helvetica,Arial,sans-serif;max-width:550px;margin:50px auto;border-top: none;" ><table border="0" cellspacing="0" cellpadding="0"><tbody><tr valign="top" height="2"><td valign="top"><div style="background-color:white;border-top:2px solid #00A7EB;box-shadow:0 1px 3px #AAAAAA;12px;max-width:550px;color:#555555;font-family:微软雅黑, Arial;;font-size:12px;">
<h2 style="border-bottom:1px solid #DDD;font-size:14px;font-weight:normal;padding:8px 0 10px 8px;"><span style="color: #00A7EB;font-weight: bold;">> </span>您在 <a style="text-decoration:none; color:#58B5F5;font-weight:600;" href="' . home_url() . '">' . $blogname . '</a> 的留言有回复啦！</h2><div style="padding:0 12px 0 12px;margin-top:18px">
<p>您好, ' . trim(get_comment($parent_id)->comment_author) . '! 您发表在文章 《' . get_the_title($comment->comment_post_ID) . '》 的评论:</p>
<p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">' . nl2br(strip_tags(get_comment($parent_id)->comment_content)) . '</p>
<p>' . trim($comment->comment_author) . ' 给您的回复如下:</p>
<p style="background-color: #EEE;border: 1px solid #DDD;padding: 20px;margin: 15px 0;">' . nl2br(strip_tags($comment->comment_content)) . '</p>
<p>您可以点击 <a style="text-decoration:none; color:#5692BC" href="' . htmlspecialchars(get_comment_link($parent_id)) . '">查看完整的回复內容</a>，也欢迎再次光临 <a style="text-decoration:none; color:#5692BC"
href="' . home_url() . '">' . $blogname . '</a>。祝您生活愉快！</p>
<p style="padding-bottom: 15px;">(此邮件由系统自动发出,请勿直接回复!)</p></div></div></td></tr></tbody></table></div>';
        $from = "From: \"" . get_option('blogname') . "\" <$wp_email>";
        $headers = "$from\nContent-Type: text/html; charset=" . get_option('blog_charset') . "\n";
        wp_mail( $to, $subject, $message, $headers );
    }
}
add_action('comment_post', 'fanly_comment_mail_notify');
