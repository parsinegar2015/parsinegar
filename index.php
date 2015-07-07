<?php
ob_start();
include 'bootstrap.php';
$layout = true;
$css_arr = array();
$js_arr = array();
$js_nojQuery_arr = array();
$page_display_title = '';
//if(!function_exists('tpl')){
function tpl($file){
global $app,$layout,$css_arr,$js_arr,$js_nojQuery_arr,$page_display_title;
$css = '';
$js_script = '';
$js_nojQuery = '';
ob_start(); 
include($file);
$output = ob_get_contents();
ob_end_clean();
$css_arr[] = $css;
$js_arr[] = $js_script;
$js_nojQuery_arr[] = $js_nojQuery;
return $output;
}
//}
/*$_SESSION['login'] = true;
$_SESSION['permission'] = 'admin';
$_SESSION['fname'] = 'علی';
$_SESSION['lname'] = 'زحمتکش';
$_SESSION['username'] = 'admin';
$_SESSION['userId'] = 1;
$_SESSION['token'] = '';*/

function layout($layout,$html){
$layout = tpl($layout);
return str_replace('{content}',$html,$layout);
}

$output = '';

$layout_file = 'layout1.php';
if(isset($_SESSION['login'])){
$layout_file = 'layout2.php';
}
$http_request_black_list = array('layout1','layout2','cpanel');
$query = $_SERVER['QUERY_STRING'].'&';
$queries = array_filter(explode('&',$query));
$file = '';
$file_name = '';
if(!empty($queries)){
$file = trim(strtolower($queries[0]));
$file = str_replace('/','',$file);  
$file_name = trim(strtolower(str_replace('.php','',$file)));
if($file == 'me'){
if(isset($_SESSION['login'])){
$file = 'cpanel.php';
}else{
redirect(BASE_PATH,1);
}
}
if($file == 'home' || $file == 'home.php'){
$file = 'news.php';
$file_name = 'news';
}
if(!strstr($file,'.php')){
$file = $file.'.php';
}
}
if(file_exists($file) && is_readable($file) && !in_array($file_name,$http_request_black_list)){
if($file == 'cpanel.php'){
$file_name = 'cpanel';
}
/*ob_start(); 
include($file);
$output = ob_get_contents();
ob_end_clean();*/
$output = tpl($file);
if($layout){
$output = layout($layout_file,$output);
}
}else if(!empty($file)){
$output = '<center><br/><br/><br/><br/><br/><br/><img src="'.BASE_PATH.'/assets/img/404.png"/></center>';
}

if(empty($output)){
$output = layout($layout_file,tpl('news.php'));
$file_name = 'news';
}

?>
<!doctype html>
<html lang="fa-IR">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Pragma" content="no-cache">
<meta name="description" content="سامانه پژوهشی پارسی نگار - دانشگاه کوشیار" />
<meta property="og:locale" content="fa_IR" />
<meta property="og:type" content="Portal" />
<meta property="og:title" content="سامانه پژوهشی پارسی نگار - دانشگاه کوشیار" />
<meta property="og:url" content="<?php echo BASE_PATH;?>" />
<meta property="og:site_name" content="سامانه پژوهشی پارسی نگار - دانشگاه کوشیار" />
<meta property="og:description" content="سامانه پژوهشی پارسی نگار - دانشگاه کوشیار" />
<title><?php echo $page_display_title; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/bootstrap.min.css">
<style type="text/css">
html,body{ margin: 0px; background: #dde0e0; }
#head{ margin: 0px; width: 100%; height: 110px; background: url(<?php echo BASE_PATH.'/assets/img/header4.jpg'; ?>) #d0d1d1; border-bottom: 1px solid #c7c7c7; text-align: center; /*ebeded*/ position: static; }
#head #menu{ width: 1210px; height: 110px; <?php echo (DEFAULT_LANGUAGE == 'en')? 'margin-left: -11px;' : '' ?> }
#head #menu A .nav-btn{ background: url(<?php echo BASE_PATH;?>/assets/img/mbtn2.jpg); cursor: pointer; width: 120px; height: 40px; float: <?php echo (DEFAULT_LANGUAGE == 'fa')? 'left' : 'right' ?>; margin-top: 70px; border-<?php echo (DEFAULT_LANGUAGE == 'fa')? 'right' : 'left' ?>: 1px solid #333; font-family: tahoma; line-height: 34px; font-size: 14px; color: #999; }
#head #menu A .nav-btn:nth-last-child(1){ border: 0px; }
#head #menu A .nav-btn:hover{ background: url(<?php echo BASE_PATH;?>/assets/img/mbtn3.jpg); }
#head #menu A{ text-decoration: none; }
#head .lang{ position: absolute; left: 20px; top: 0px; width: 100px; height: 30px; border-radius: 0px 0px 5px 5px; background: #999; color: #fff; }
#head .lang form{ float: left; }
#head .lang form:first-child{ margin-left: 22px; }
#head .lang span{ float: left; line-height: 30px; }
#head .lang A{ text-decoration: none; color: #fff; line-height: 30px; font-weight: bold; font-family: Arial; }
#wrap{ width: 1200px; min-height: 400px; background: url(<?php echo BASE_PATH;?>/assets/img/body-top.jpg) repeat-x #FFF; position: relative; float: left; left: 50%; margin-left: -605px;  }
#footer{ width: 100%; height: 190px; float: left; }
#footer #footbg{ width: 1200px; height: 100%; position: relative; left: 50%; margin-left: -605px; background: url(<?php echo BASE_PATH;?>/assets/img/footer4.jpg); background-size: 1200px 190px; float: left; }
#login_form input[type=text],#login_form input[type=password]{ width: 200px; height: 30px; font-weight: bold; font-size: 16px; font-family: Arial; border-radius: 5px; box-shadow: 0px 0px 10px #ccc; border: 1px solid #ccc; outline: none; padding: 5px; margin-top: 15px; }
#login_btn{ width: 120px; height: 40px; background: #ADFF2F; border-radius: 5px; border: 1px solid #DCDCDC; margin-bottom: 25px; margin-top: 20px; color: #000; font-weight: bold; cursor: pointer; outline: none; }
#login_btn:hover{ background: green; color: #fff; }
.pagination{ width: 100%; height: 40px; list-style: none; list-type: none; float: left; }
.pagination a{ text-decoration: none; color: #999; text-align: center; }
.pagination li{ width: 35px; height: 35px; float: left; margin: 5px; background: url(<?php echo BASE_PATH;?>/assets/img/pn.png); list-style: none; list-type: none; line-height: 40px; }
.pagination li:hover{ background: url(<?php echo BASE_PATH;?>/assets/img/pn_hover.png); color: #fff; }
.pagination li.active{ background: url(<?php echo BASE_PATH;?>/assets/img/pn_hover.png); }

.perfect_btn {
	display: inline-block;
	color: #666;
	background-color: #eee;
	text-transform: uppercase;
	letter-spacing: 2px;
	font-size: 12px;
	padding: 10px 30px;
	border-radius: 5px;
	-moz-border-radius: 5px;
	-webkit-border-radius: 5px;
	border: 1px solid rgba(0,0,0,0.3);
	border-bottom-width: 3px;
	margin-bottom: 30px;
}

	.perfect_btn:hover {
		background-color: #e3e3e3;
		border-color: rgba(0,0,0,0.5);
	}
	
	.perfect_btn:active {
		background-color: #CCC;
		border-color: rgba(0,0,0,0.9);
	}


blockquote
{
	font-style: italic;
	font-family: Georgia, Times, "Times New Roman", serif;
	padding: 2px 0;
	border-style: solid;
	border-color: #ccc;
	border-width: 0;
	padding-left: 8px;
	padding-right: 20px;
	border-right-width: 5px;
}

<?php
echo "\r \n".implode("\n",$css_arr)."\r \n";
?>
</style>
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/tooltipster.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/tooltipster-shadow.css" />
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/bootstrap-markdown.min.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/joyride-2.1.css">
<link rel="stylesheet" type="text/css" href="<?php echo BASE_PATH;?>/assets/css/jquery-ui-1.8.14.css">

<?php
if(isset($_SESSION['login'])){
echo '
<script src="'.BASE_PATH.'/ckeditor/ckeditor.js"></script>
';
?>
<script>

CKEDITOR.on( 'instanceCreated', function( event ) {
			var editor = event.editor;
<?php
if(DEFAULT_LANGUAGE == 'en'){
echo "editor.config.language = 'en';";
}else{
echo "editor.config.language = 'fa';";			
}
?>
editor.config.height = 200;

if(editor.name == 'min_ckeditor'){
editor.on( 'configLoaded', function() {

// Remove unnecessary plugins to make the editor simpler.
					editor.config.removePlugins = 'colorbutton,find,flash,font,' +
						'forms,iframe,image,newpage,removeformat,' +
						'smiley,specialchar,stylescombo,templates';

					// Rearrange the layout of the toolbar.
					editor.config.toolbarGroups = [
						{ name: 'editing',		groups: [ 'basicstyles' ] },
						{ name: 'undo' },
						{ name: 'clipboard',	groups: [ 'selection', 'clipboard' ] },
						{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] }
						
					];
				});

}else{

editor.on( 'configLoaded', function() {
editor.config.removePlugins = 'about';
});

}			
});
</script>
<?php
}
?>
<script src="<?php echo BASE_PATH;?>/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>/assets/js/jquery.tooltipster.min.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>/assets/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>/assets/js/jquery.joyride-2.1.js"></script>
<script type="text/javascript" src="<?php echo BASE_PATH;?>/assets/js/jquery.ui.datepicker-cc.all.min.js"></script>

<?php
if(isset($_SESSION['login']) && $_SESSION['permission'] == 'admin'){
echo '<script src="'.BASE_PATH.'/assets/js/jquery.zeroclipboard.js"></script>';
echo "\n";
echo '<script src="'.BASE_PATH.'/assets/js/bootstrap-markdown.js"></script>';
echo "\n";
echo '<script>
$(function(){
$("textarea[name=html]").markdown();
});
</script>';
echo "\n";
}
?>
<script src="<?php echo BASE_PATH;?>/assets/js/require.js"></script>
<?php
$js_arr = implode("\n",$js_arr);
$js_nojQuery_arr = implode("\n",$js_nojQuery_arr);
echo $js_file_data = '
<script>
$(function(){

$("#login_btn").click(function(event){
login_error = false;
$("#login_form input").each(function(){
self = $(this);
if(self.attr("type") == "text" || self.attr("type") == "password"){
if(self.val() == ""){
 self.css("border","1px solid red");
 login_error = true;
}
name = self.attr("name");		
if(name == "captcha"){
if(!/^[\-\+]?\d+$/.test(self.val())){
self.css("border","1px solid red");
login_error = true;
  }
}
}
});
if(login_error){
event.preventDefault();
return false;
}
});


$("#login_form input[type=text],#login_form input[type=password]").live("blur",function(){
	self = $(this);
	if(self.val() == ""){
		self.css("border","1px solid red");
		}else{
		  self.css("border","1px solid #ccc");	
			}
	  name = self.attr("name");		
	  if(name == "captcha"){
		  if(!/^[\-\+]?\d+$/.test(self.val())){
			  self.css("border","1px solid red");
			  }
		  }		
	});
$("#login_form input[type=text],#login_form input[type=password]").live("keyup change click",function(){
	self = $(this);
	if(self.val() != ""){
		self.css("border","1px solid #ccc");
	}
	name = self.attr("name");		
	  if(name == "captcha"){
		  if(!/^[\-\+]?\d+$/.test(self.val())){
			  self.css("border","1px solid red");
			  }
		  }	
	});


$(".tooltip").tooltipster({
    theme: ".tooltipster-shadow"
});

$(".tooltip_add_article").tooltipster({
    theme: ".tooltipster-shadow",
	position: "left",
	animation: "grow"
});




 '.$js_arr.'		
		

$("input[name=date]").datepicker({
onClose: function( selectedDate ) {
	  var date_array = selectedDate.split("/");
	  $("input[name=date]").val(date_array[2]+"/"+date_array[1]+"/"+date_array[0]);
	  }
});		

		
});

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

'.$js_nojQuery_arr.'

</script>
';

$js_name = $file_name;
if($js_name == 'filemanager' && isset($_SESSION['login']) && $_SESSION['permission'] == 'admin'){
$js_name = 'filemanager_cms';
}
if(file_exists('assets/js/'.$js_name.'.js')){
$js_file_data = '
requirejs.config({
    baseUrl: "'.BASE_PATH.'/assets/js/",
    paths: {
		'.$js_name.': "'.$js_name.'"
    }
});




require(["'.$js_name.'"],function(){
//Loaded...
});
';

if(file_exists('min/parsinegar.js')){
unlink('min/parsinegar.js');
}
file_put_contents('min/parsinegar.js',$js_file_data);
//echo '<script src="'.BASE_PATH.'/min/f=min/parsinegar.js"></script>'; ///f=min

echo '
<script language="javascript" type="text/javascript">
    var epoch = (new Date).getTime();
    document.write(\'<script src="'.BASE_PATH.'/min/f=min/parsinegar.js?t=\'+epoch+\'"><\/script>\');
</script>
';
}
?>


<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
 	<![endif]-->

</head>

<body>
<!-- Tip Content -->
    <ol id="joyRideTipContent">
      <li data-id="tip_mainMenu" data-text="Next" data-options="tipLocation:left;tipAnimation:fade">
        <h2>Stop #1</h2>
        <p>You can control all the details for you tour stop. Any valid HTML will work inside of Joyride.</p>
      </li>
      <li data-id="tip_userMenu" data-button="Next" data-options="tipLocation:left;tipAnimation:fade">
        <h2>Stop #2</h2>
        <p>Get the details right by styling Joyride with a custom stylesheet!</p>
      </li>
      <li data-id="menu" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
        <h2>Stop #3</h2>
        <p>It works right aligned.</p>
      </li>
	  <li data-id="menu_panel" data-button="Next" data-options="tipLocation:top;tipAnimation:fade">
        <h2>Stop #4</h2>
        <p>It works right aligned.</p>
      </li>
      <!--<li data-button="Next">
        <h2>Stop #4</h2>
        <p>It works as a modal too!</p>
      </li>
      <li data-class="someclass" data-button="Next" data-options="tipLocation:right">
        <h2>Stop #4.5</h2>
        <p>It works with classes, and only on the first visible element with that class.</p>
      </li>
      <li data-id="numero5" data-button="Close">
        <h2>Stop #5</h2>
        <p>Now what are you waiting for? Add this to your projects and get the most out of your apps!</p>
      </li>-->
    </ol>
<div id="head">
<div class="lang">
<form method="post" action="<?php echo CURRENT_URL; ?>">
<input type="hidden" name="langx" value="en"/>
<a href="javascript:void(0)" onClick='this.parentNode.submit()'>EN&nbsp;</a>
</form>
<span>/</span>
<form method="post" action="<?php echo CURRENT_URL; ?>">
<input type="hidden" name="langx" value="fa"/>
<a href="javascript:void(0)" onClick="this.parentNode.submit()">&nbsp;FA</a>
</form>
</div>
<center>
<div id="menu">
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['contact'][DEFAULT_LANGUAGE]; ?></div></a>
<a href="<?php echo BASE_PATH.'/teacher'; ?>"><div class="nav-btn"><?php echo $_LANGUAGE['professor'][DEFAULT_LANGUAGE]; ?></div></a>
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['chart'][DEFAULT_LANGUAGE]; ?></div></a>
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['regulations'][DEFAULT_LANGUAGE]; ?></div></a>
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['downloads'][DEFAULT_LANGUAGE]; ?></div></a>
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['stages'][DEFAULT_LANGUAGE]; ?></div></a>
<a href=""><div class="nav-btn"><?php echo $_LANGUAGE['notification'][DEFAULT_LANGUAGE]; ?></div></a>
<a href="<?php echo BASE_PATH; ?>/news/"><div class="nav-btn"><?php echo $_LANGUAGE['news'][DEFAULT_LANGUAGE]; ?></div></a>
<?php
if(!isset($_SESSION['login'])){
echo '<a href="'.BASE_PATH.'/login"><div class="nav-btn">'.$_LANGUAGE['login'][DEFAULT_LANGUAGE].'</div></a>';
}else{
echo '<a href="'.BASE_PATH.'/user/?do=logout&token='.$_SESSION['token'].'"><div class="nav-btn">'.$_LANGUAGE['logout'][DEFAULT_LANGUAGE].'</div></a>';
}
?>
<a href="<?php echo BASE_PATH; ?>/index.php"><div class="nav-btn"><?php echo $_LANGUAGE['home'][DEFAULT_LANGUAGE]; ?></div></a>
</div>
</center>
</div>
<!--<center>-->
<div id="wrap">
<?php
echo $output;
?>

</div>
<div id="footer">
<div id="footbg">
<center>
footer
</center>
</div>
</div>
<!--</center>-->
</body>
</html>