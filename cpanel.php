<?php
if(!isset($_SESSION['login'])){
redirect(BASE_PATH.'/',1);
}

include 'config'.DS.'language.php';

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

$css = '
#search_me{ width: 100%; height: 100px; }
#search_me form{ width: 605px; height: 100px; box-sizing: border-box; }
#search_me_text_box{ width: 500px; height: 40px; float: left; border-width: 1px 0px 1px 1px; border-style: solid; border-color: #000; border-radius: 5px 0px 0px 5px; }
#search_me_menu_box{ width: 100px; height: 40px; float: left; border-width: 1px 1px 1px 0px; border-style: solid; border-color: #000; border-left: 1px solid #ccc; border-radius: 0px 5px 5px 0px; }
#search_me_menu{ width: 100px; height: 100px; position: absolute; display: none; border-left: 1px solid #CCC; border-bottom: 1px solid #CCC; border-right: 1px solid #CCC; top: 85px; margin-left: -6px; box-shadow: 0px 5px 25px #ddd; border-radius: 0px 0px 5px 5px; }
.down_caret{ width: 14px; height: 40px; background: url(assets/img/down_caret.png) 0 15px no-repeat; float: left; margin-left: 5px;  cursor: pointer; }
.down_caret:hover #search_me_menu{ display: block; }

#cp{ width: 900px; }
#cp #info{ width: 100%; height: 130px; border: 1px solid #ccc; }
#cp #info .row{ width: 50%; height: 44px; float: left; text-align: right; font-weight: bold; padding-top: 20px; direction: rtl; color: #000; }
#cp .chpassword{ width: 100%; height: 100px; border: 1px solid #ccc; margin-top: 20px; }
#cp .chpassword .title{ width: 100%; height: 25px; background: #666; text-align: right; direction: rtl; color: #ccc; font-weight: bold; }
#cp .chpassword .content{ width: 100%; height: 75px; }
#cp .chpassword .content form{ border: 0px; margin: 0px; margin-top: 20px; }
#cp .chpassword .content form div{ float: left; width: 199px; direction: rtl; }
#cp .chpassword .content form div:first-child{ width: 100px; float: left; }
#cp .chpassword .content form div input[type=submit]{ width: 80px; }
#cp #menu_panel{ width: 900px; height: 100px; margin-top: 20px; }
#cp #menu_panel div{ width: 100px; float: left; height: 100px; text-align: right; }
#cp #menu_panel div:first-child{ text-align: left; }
#cp #menu_panel div input{ width: 95px; height: 100px; font-weight: bold; background: #fff; border: 1px solid #ccc; cursor: pointer; text-align: center; outline: none; }
#cp #menu_panel div input:hover{ border: 1px solid #666; background: #fbfbfb; }
#cp #atCaption{ float: right; direction: rtl; }
#cp #tbl_title{ width: 900px; height: 25px; border: 1px solid #000; float: left; }
#cp #tbl_title div{ width: 100px; float: left; border-right: 1px solid #000; height: 25px; font-weight: bold; }
#cp #tbl_title div:last-child{ width: 698px; border: 0px; }

#cp .tbl_row{ width: 900px; min-height: 60px; border-bottom: 1px solid #ccc; float: left; }
#cp .tbl_row:hover{ background: #CCFFCC; }
#cp .tbl_row div{ width: 100px; float: left; min-height: 60px; font-weight: bold; }
#cp .tbl_row div:last-child{ width: 698px; direction: rtl; float: left; }

#search_box{ width: 100%; height: 30px; background: #ddd; border-radius: 5px; border: 1px solid #eee; outline: none; text-indent: 30px;
background-image: url('.BASE_PATH.'/assets/img/icon-search.png);
    background-position: 10px center;
    background-repeat: no-repeat;
	-webkit-transition: all 0.2s;
    -moz-transition: all 2s;
    transition: all 0.2s;
 }
#search_box:focus{ border: 0px; text-align: right; background-position: -20px center; }
';

$alert = '';

if(isset($_SESSION['success_add_article'])){
$alert = 'alert("'.$_SESSION['success_add_article'].'");';
unset($_SESSION['success_add_article']);
}

if(isset($_SESSION['success_add_thesis'])){
$alert = 'alert("'.$_SESSION['success_add_thesis'].'");';
unset($_SESSION['success_add_thesis']);
}

$js_script = '
//$.removeCookie("tour");
	  if(!jQuery.cookie("tour-'.sha1($_SESSION['userId']).'")){
	  $.cookie("tour-'.sha1($_SESSION['userId']).'", "value", { expires: 20*365 });
        $("#joyRideTipContent").joyride({
          autoStart : true,
          postStepCallback : function (index, tip) {
          
        },
        modal:true,
        expose: true
        });
		}		
		
'.$alert;


$js_data = '
define([],function(){
$(function(){
$("#chpass").submit(function(event){
if(!$("input[name=cpass]").val().match(/^[\s\t\r\n]*\S+/ig) || !$("input[name=npass]").val().match(/^[\s\t\r\n]*\S+/ig)){
event.preventDefault();
}
});

$("#chmail").submit(function(event){
if(!$("input[name=email]").val().match(/^[\s\t\r\n]*\S+/ig)){
event.preventDefault();
}
});
});
});
';

include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('cpanel')){
if(!$js->comp('cpanel',\parsinegar\js::min($js_data))){
$js->file('cpanel',\parsinegar\js::min($js_data));
}
}else{
$js->file('cpanel',\parsinegar\js::min($js_data));
}


$skill = '';
switch($_SESSION['permission']){
case 'admin' :
$skill = 'مدیریت';
break;
case 'teacher':
$skill = 'استاد';
break;
case 'student':
$skill = 'دانشجو';
break;
}

function myemail($pdo){
$sql = "select email from user where id=".$_SESSION['userId'];
$stmt = $pdo->query($sql);
if($stmt->rowCount() == 1){
$email = $stmt->fetchColumn(0);
if($email != null){
return $email;
}
}
return false;
}

function student_article_list($pdo){
global $_LANGUAGE;
$sql = "select * from article where uid=".$_SESSION['userId'];
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$template = '<div class="tbl_row">
<div>{unverified}</div>
<div>{confirmed}</div>
<div align="right" dir="rtl">{title}<br/><div dir="ltr">{status}</div></div>
</div>';
$control_delete = '<a href="javascript:void(0)" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/article/?do=delete&token='.$_SESSION['token'].'&article={id}" }else{ return false; }\'>[حذف]</a>';
$control_edit   = '<a href="'.BASE_PATH.'/article/?do=edit&article={id}&token='.$_SESSION['token'].'">[ویرایش]</a>';
$control_view   = '<a href="'.BASE_PATH.'/article/{id}/{link}.html">[نمایش]</a>';
$html = array();
foreach($articles as $row){
$tpl = $template;
$title = $row['title'];
if($row['lang'] == 'en'){
$title = $row['title_en'];
}
if($row['status'] == 0 || $row['status'] == 2){
$tpl = str_replace('{unverified}','<span style="font-size: 34px;">•</span>',$tpl);
$tpl = str_replace('{confirmed}','',$tpl);
if($row['status'] == 0){
$status_msg = $_LANGUAGE['cpanel_wait'][DEFAULT_LANGUAGE];
$cd = $control_delete;
$cd = str_replace('{id}',$row['id'],$cd);
$ce = $control_edit;
$ce = str_replace('{id}',$row['id'],$ce);
$link  = str_replace(' ','-',$title);
$cv = $control_view;
$cv = str_replace('{link}',$link,$cv);
$cv = str_replace('{id}',$row['id'],$cv);
$tpl = str_replace('{status}',$cd.'&nbsp;'.$ce.'&nbsp;'.$cv.'-'.$status_msg,$tpl);
}else{
$status_msg = $_LANGUAGE['cpanel_closed'][DEFAULT_LANGUAGE];
$link  = str_replace(' ','-',$title);
$cv = $control_view;
$cv = str_replace('{link}',$link,$cv);
$cv = str_replace('{id}',$row['id'],$cv);
$tpl = str_replace('{status}',$cv.'-'.$status_msg,$tpl);
}
}else{
$tpl = str_replace('{unverified}','',$tpl);
$tpl = str_replace('{confirmed}','<span style="font-size: 24px;">•</span>',$tpl);
$status_msg = $_LANGUAGE['cpanel_accept'][DEFAULT_LANGUAGE];
$link  = str_replace(' ','-',$title);
$cv = $control_view;
$cv = str_replace('{link}',$link,$cv);
$cv = str_replace('{id}',$row['id'],$cv);
$tpl = str_replace('{status}',$cv.'-'.$status_msg,$tpl);
}

if($row['status'] == 2){
$title = '<s>'.$title.'</s>';
}
$tpl = str_replace('{title}',$title,$tpl);
$html[] = $tpl;
}
echo implode("\n",$html);
}
}

function student_thesis_list($pdo){
global $_LANGUAGE;
$sql = "select t.*,concat_ws(' ',u.fname,u.lname) as 'teacher_name' from `thesis` as t 
inner join `user` as u
on u.id = t.teacher
where uid=".$_SESSION['userId'];
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$template = '<div class="tbl_row">
<div>{enddate}</div>
<div>{teacher}</div>
<div align="right" dir="rtl">{title}<br/><div dir="ltr">{status}</div>&nbsp;{grade}</div>
</div>';
$control_delete = '<a href="javascript:void(0)" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/thesis/?do=delete&token='.$_SESSION['token'].'&thesis={id}" }else{ return false; }\'>[حذف]</a>';
$control_edit   = '<a href="'.BASE_PATH.'/thesis/?do=edit&thesis={id}&token='.$_SESSION['token'].'">[ویرایش]</a>';
$control_view   = '<a href="'.BASE_PATH.'/thesis/{id}/{link}.html">[نمایش]</a>';
$template = str_replace('{enddate}',$row['enddate'],$template);
$template = str_replace('{teacher}',$row['teacher_name'],$template);
$title = $row['title'];
if($row['status'] == 2){
$title = '<s>'.$title.'</s>';
}
$template = str_replace('{title}',$title,$template);
if($row['status'] == 0){
$status_msg = $_LANGUAGE['cpanel_wait'][DEFAULT_LANGUAGE];
$cd = $control_delete;
$cd = str_replace('{id}',$row['id'],$cd);
$ce = $control_edit;
$ce = str_replace('{id}',$row['id'],$ce);
$link  = str_replace(' ','-',$row['title']);
$cv = $control_view;
$cv = str_replace('{link}',$link,$cv);
$cv = str_replace('{id}',$row['id'],$cv);
$template = str_replace('{status}',$cd.'&nbsp;'.$ce.'&nbsp;'.$cv.'-'.$status_msg,$template);
}else{
 if($row['status'] == 1){ $status_msg = $_LANGUAGE['cpanel_accept'][DEFAULT_LANGUAGE]; }
 if($row['status'] == 2){ $status_msg = $_LANGUAGE['cpanel_closed'][DEFAULT_LANGUAGE]; }
$link  = str_replace(' ','-',$row['title']);
$cv = $control_view;
$cv = str_replace('{link}',$link,$cv);
$cv = str_replace('{id}',$row['id'],$cv);
$template = str_replace('{status}',$cv.'-'.$status_msg,$template);
}
$template = str_replace('{grade}',$_LANGUAGE['cpanel_grade'][DEFAULT_LANGUAGE].'&nbsp;'.$row['grade'],$template);
echo $template;
 }
}



?>
<center>
<div id="cp">

<div id="search_me">
<center>
<form method="get" action="<?php echo BASE_PATH; ?>/search/" name="sForm">
<!--
onSubmit="document.sForm.action='/search/?q='+document.getElementById('q').value;"
<div id="search_me_text_box"></div>
<div id="search_me_menu_box">
<span class="down_caret">
<div id="search_me_menu">
thesis&nbsp;<img src="assets/img/thesis.png" align="absmiddle"/><br/><br/>
article&nbsp;<img src="assets/img/article.png" align="absmiddle"/>
</div>
</span>
</div>-->
<input type="text" name="q" id="search_box" value="" placeholder="search" />
</form>
</center>
</div>

<div id="info">
<div class="row">نام خانوادگی: <?php echo $_SESSION['lname']; ?></div>
<div class="row">&nbsp;&nbsp;&nbsp;&nbsp;نام: <?php echo $_SESSION['fname']; ?></div>
<div class="row">نوع کاربری: <?php echo $skill; ?></div>
<div class="row">&nbsp;&nbsp;&nbsp;&nbsp;نام کاربری: <?php echo $_SESSION['username']; ?></div>
</div>

<div class="chpassword">
<div class="title">&nbsp;&nbsp;تغییر کلمه عبور :</div>
<div class="content">
<form action="<?php echo BASE_PATH.'/user/?do=chpassword&token='.$_SESSION['token']; ?>" method="post" id="chpass">
<div align="center"><input type="submit" value="انجام"/></div>
<div align="right"><input type="password" dir="ltr" name="npass" value="" pattern=".{8,}" title="Minimum value is 8 characters"/></div>
<div align="center">کلمه عبور جدید :</div>
<div align="right"><input type="password" dir="ltr" name="cpass" value=""/></div>
<div align="center">کلمه عبور فعلی :</div>
</form>
</div>
</div>

<div class="chpassword">
<div class="title">&nbsp;&nbsp;تغییر/تعریف ایمیل :</div>
<div class="content">
<form action="<?php echo BASE_PATH.'/user/?do=chmail&token='.$_SESSION['token']; ?>" method="post" id="chmail">
<div>&nbsp;</div>
<div><?php echo myemail($pdo); ?></div>
<div align="center"><input type="submit" value="انجام"/></div>
<div align="right"><input type="text" name="email" value="" dir="ltr"/></div>
<div align="center">آدرس ایمیل :</div>
</form>
</div>
</div>

<div id="menu_panel">
<?php
if($_SESSION['permission'] == 'admin'){
echo '
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/user/?do=logout&token='.$_SESSION['token'].'\';" value="خروج"/></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/user/?do=manage&token='.$_SESSION['token'].'\';" value="مدیریت کاربران"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/article\';" value="فهرست مقالات"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/thesis\';" value="فهرست پایان نامه"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/event\';" value="رویدادها"/></div>
';
}
if($_SESSION['permission'] == 'student'){
echo '
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/user/?do=logout&token='.$_SESSION['token'].'\';" value="خروج"/></div>
<div></div>
<div></div>
<div></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/thesis\';" value="'.$_LANGUAGE['thesis_list'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/article\';" value="'.$_LANGUAGE['article_list'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/article/?do=add&type=conference&token='.$_SESSION['token'].'\';" value="'.$_LANGUAGE['add_article_c'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/article/?do=add&type=journal&token='.$_SESSION['token'].'\';" value="'.$_LANGUAGE['add_article_j'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/thesis/?do=add&token='.$_SESSION['token'].'\';" value="'.$_LANGUAGE['add_thesis'][DEFAULT_LANGUAGE].'"/></div>
';
}
if($_SESSION['permission'] == 'teacher'){
echo '
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/user/?do=logout&token='.$_SESSION['token'].'\';" value="خروج"/></div>
<div></div>
<div></div>
<div></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/thesis\';" value="'.$_LANGUAGE['thesis_list'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/article\';" value="'.$_LANGUAGE['article_list'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/teacher/?do=job&token='.$_SESSION['token'].'\';" value="'.$_LANGUAGE['teacher_job'][DEFAULT_LANGUAGE].'"/></div>
<div><input type="button" onClick="window.location=\''.BASE_PATH.'/teacher/?do=add&token='.$_SESSION['token'].'\';" value="'.$_LANGUAGE['tooltip_add_article'][DEFAULT_LANGUAGE].'"/></div>
';
}
?>
</div>
<br/>
<?php 
if($_SESSION['permission'] == 'student'){
?>
<div id="atCaption"><b><?php echo $_LANGUAGE['cpanel_article_list'][DEFAULT_LANGUAGE]; ?></b></div>
<br/>
<div id="tbl_title">
<div><?php echo $_LANGUAGE['cpanel_unverified'][DEFAULT_LANGUAGE]; ?></div>
<div><?php echo $_LANGUAGE['cpanel_confirmed'][DEFAULT_LANGUAGE]; ?></div>
<div><?php echo $_LANGUAGE['cpanel_title'][DEFAULT_LANGUAGE]; ?></div>
</div>
<?php student_article_list($pdo); ?>
<br/>
<br/>
<div id="atCaption"><br/><b><?php echo $_LANGUAGE['cpanel_thesis_list'][DEFAULT_LANGUAGE]; ?></b></div>
<br/>
<div id="tbl_title">
<div><?php echo $_LANGUAGE['cpanel_enddate'][DEFAULT_LANGUAGE]; ?></div>
<div><?php echo $_LANGUAGE['cpanel_teacherhelper'][DEFAULT_LANGUAGE]; ?></div>
<div><?php echo $_LANGUAGE['cpanel_title'][DEFAULT_LANGUAGE]; ?></div>
</div>
<?php 
student_thesis_list($pdo); 
}
?>
<br/>
</div>
</center>