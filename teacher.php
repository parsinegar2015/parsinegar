<?php
include 'config'.DS.'language.php';
try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

//$layout = true;

$css = '
 #teacher_wrap{ float: left; width: 900px; margin-left: 50px; }
 .row_teacher{ width: 900px; height: 110px; float: left; border-bottom: 1px solid #ccc; color: #000; text-align: right; }
 .row_teacher:hover{ background: #f7f7f7; }
 .row_teacher div{ float: left; height: 109px; width: 100px; text-align: center; color: #000; }
 .row_teacher div:first-child{ width: 800px; text-align: right; }
 .row_teacher img{ margin-top: 7px; }
 .row_teacher_search{ width: 900px; min-height: 110px; float: left; border-bottom: 1px solid #ccc; text-align: right; }
 .row_teacher_search img{ float: right; }
 #teacher_search{ width: 90%; padding: 7px; font-family: tahoma; font-size: 18px; font-weight: bold; color: #666; direction: rtl; }
 .teacher_article{ width: 900px; float: left; height: 180px; box-shadow: 0px 0px 5px #ccc; }
 .teacher_article div{ width: 100%; float: left; min-height: 30px; text-align: right; direction: rtl; font-weight: bold; }
 .teacher_article div input[type=text]{ width: 98%; float: left; margin-left: 1%; height: 30px; border: 1px solid #eee; margin-top: 5px; }
 .teacher_article div.title{ border-bottom: 1px solid #ccc; }
 .teacher_article div.title a{float: left; margin: 5px; font-family: arial; text-decoration: none; color: #bbb; width: 24px; text-align: center; border: 1px solid #bbb; }
 .teacher_article div.title a:hover{ background: #d2d2d2; }
 .jobform input[type=text]{ width: 90%; height: 30px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; direction: rtl; font-size: 17px; }
 .jobform input[type=submit]{ width: 150px; height: 30px; border: 2px solid #ccc; border-radius: 5px; background: red; font-weight: bold; }
 .jobform input[type=submit]:hover{ background: #CC0000; }
'; 
 
$js_data = '
define([],function(){
$(function(){
$("#teacher_search").bind("keyup change",function(){
$(".row_teacher").fadeOut("fast");
self = $(this);
$("div[id^=t_"+self.val()+"]").fadeIn("fast");
 });

$("#save_btn").click(function(event){
save_error = false;
$("#teacher_article_form input").each(function(){
self = $(this);
if(self.hasClass(\'req\')){
if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){
 save_error = true;
}
}
name = self.attr(\'name\');		
if(name == \'link\'){
if(self.val().match(/^[\s\t\r\n]*\S+/ig)){
if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(self.val())){
save_error = true; 
}
}
}
if(name == \'date\'){
if(!/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(self.val())){
save_error = true;
}
}

});
if(save_error){
event.preventDefault();
return false;
}
});
});
}); 
'; 
 
include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('teacher')){
if(!$js->comp('teacher',\parsinegar\js::min($js_data))){
$js->file('teacher',\parsinegar\js::min($js_data));
}
}else{
$js->file('teacher',\parsinegar\js::min($js_data));
} 
 
 
 
function view($pdo){
global $_LANGUAGE;
$html = array();
$add='';
if(isset($_SESSION['login']) && $_SESSION['permission'] == 'teacher'){
$add = '<br/><a href="'.BASE_PATH.'/teacher/?do=job&token='.$_SESSION['token'].'" style="float: left; margin-top: 20px;">'.$_LANGUAGE['teacher_job'][DEFAULT_LANGUAGE].'</a> <a href="'.BASE_PATH.'/teacher/?do=add&token='.$_SESSION['token'].'"><img class="tooltip_add_article" title="'.$_LANGUAGE['tooltip_add_article'][DEFAULT_LANGUAGE].'" src="'.BASE_PATH.'/assets/img/news_add.png"/></a><br/>';
}
$search = '<div class="row_teacher_search"><center><br/><input type="text" value="" id="teacher_search" placeholder="'.$_LANGUAGE['teacher_search'][DEFAULT_LANGUAGE].'"/><center/>{add}</div>';
$search = str_replace('{add}',$add,$search);
$template = '<a href="'.BASE_PATH.'/teacher/?do=article&teacher={id}"><div class="row_teacher" id="t_{fullname}">
<div>
<br/>
<b>{fullname}</b>
<br/>
<i>{job}</i>
<br/>
ایمیل: {email}
</div>
<div><img src="'.BASE_PATH.'/assets/img/{avatar}.png"/></div>
</div></a>';

$sql = "select user.id,user.sex,user.email,concat_ws(' ',user.fname,user.lname) as 'fullname',teacher_job.title as 'job' from user left join teacher_job on teacher_job.uid = user.id where user.type=2";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$tpl = $template;
$tpl = str_replace('{fullname}',$row['fullname'],$tpl);
$tpl = str_replace('{job}',$row['job'],$tpl);
$tpl = str_replace('{email}',$row['email'],$tpl);
$tpl = str_replace('{id}',$row['id'],$tpl);
$avatar = 'woman-user-larg';
if($row['sex'] == 1){
$avatar = 'man-user-larg';
}
$tpl = str_replace('{avatar}',$avatar,$tpl);
$html[] = $tpl;
}
echo $search.implode("\n",$html);
}

}




function job($pdo){
if(isset($_POST['job']) && !empty($_POST['job']) && is_string($_POST['job'])){
$job = filter_var($_POST['job'],FILTER_SANITIZE_STRING);
$sql = "select id from teacher_job where uid=".intval($_SESSION['userId']);
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$id = $stmt->fetchColumn(0);
$sql = "update teacher_job set title=:j where id=".intval($id);
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':j',$job,PDO::PARAM_STR);
$stmt->execute();
}else{
$sql = "insert into teacher_job(`title`,`uid`) values(:j,:u)";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':j',$job,PDO::PARAM_STR);
$stmt->bindvalue(':u',intval($_SESSION['userId']),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BASE_PATH.'/teacher/',1);
}else{
$title = '';
$sql = "select title from teacher_job where uid=".intval($_SESSION['userId']);
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$title = $stmt->fetchColumn(0);
}
$html = '
<center>
<br/><br/><br/>
<form method="post" class="jobform">
<input type="text" name="job" value="'.$title.'" placeholder="'.$_LANGUAGE['job_title'][DEFAULT_LANGUAGE].'"/>
<br/>
<input type="submit" value="'.$_LANGUAGE['save'][DEFAULT_LANGUAGE].'"/>
</form>
</center>';
echo $html;
}
}





function add($pdo){
if(isset($_POST['title'],$_POST['link'],$_POST['place'],$_POST['date']) && (isset($_POST['conference']) || isset($_POST['jurnal']))){

$title_error = true;
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
//$title = preg_replace('/[\@\^\!\#\&\*\(\)\+\=\-\'\$_]/', '', $title);
$title = str_replace('-',' ',$title);
$title = preg_replace('/\s+/',' ',$title);
if($title != ' ' && preg_match('/^[\w\d\x{600}-\x{6FF}\s]+$/u',$title)){
$t = preg_replace('/\s*/','',$title);
if(!empty($t)){
$title_error = false;
}
}
#================================
$place_error = true;
$place = filter_var($_POST['place'],FILTER_SANITIZE_STRING);
//$title = preg_replace('/[\@\^\!\#\&\*\(\)\+\=\-\'\$_]/', '', $title);
$place = str_replace('-',' ',$place);
$place = preg_replace('/\s+/',' ',$place);
if($place != ' ' && preg_match('/^[\w\d\x{600}-\x{6FF}\s\-]+$/u',$place)){
$p = preg_replace('/\s*/','',$place);
if(!empty($p)){
$place_error = false;
$place = filter_var($_POST['place'],FILTER_SANITIZE_STRING);
$place = preg_replace('/\s+/',' ',$place);
}
}
#================================
$date_error = true;
if(preg_match("/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/",$_POST['data'])){
$date_error = false;
}
#================================
$link_error = false;
if(!empty($_POST['link'])){
if(!filter_var($_POST['link'],FILTER_VALIDATE_URL)){
$link_error = true;
}
}
#================================
if(!$title_error && !$place_error && !$date_error && !$link_error){
$conference = 0;
$jurnal     = 0;
if(isset($_POST['conference'])){
$conference = 1;
}
if(isset($_POST['jurnal'])){
$jurnal = 1;
}
$sql = "insert into teacher_article(`uid`,`title`,`link`,`conference`,`jurnal`,`date`,`place`) values(:u,:t,:l,:c,:j,:d,:p)";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':u',intval($_SESSION['userId']),PDO::PARAM_INT);
$stmt->bindvalue(':t',$title,PDO::PARAM_STR);
$stmt->bindvalue(':l',$_POST['link'],PDO::PARAM_STR);
$stmt->bindvalue(':c',$conference,PDO::PARAM_INT);
$stmt->bindvalue(':j',$jurnal,PDO::PARAM_INT);
$stmt->bindvalue(':d',$_POST['date'],PDO::PARAM_STR);
$stmt->bindvalue(':p',$place,PDO::PARAM_STR);
$stmt->execute();
redirect(BASE_PATH.'/teacher/do=article&teacher='.intval($_SESSION['userId']),1);
}
}else{

$html = '
<form method="post" id="teacher_article_form">
<div class="teacher_article">
<div><input type="text" name="title" value="" class="req" placeholder="'.$_LANGUAGE['title'][DEFAULT_LANGUAGE].'" pattern=".{25,80}" title="Minimum value is 25 characters AND Maximum value is 80 characters" /></div>
<div><input type="text" name="date" value="" placeeholder="'.$_LANGUAGE['date'][DEFAULT_LANGUAGE].'" /></div>
<div>&nbsp;<label><input type="checkbox" name="jurnal" value="jurnal"/> مقاله Article</label>&nbsp;&nbsp;&nbsp;<label><input type="checkbox" name="conference" value="conference"/> کنفرانس Conference</label></div>
<div><input type="text" name="place" value="" class="req" placeholder="'.$_LANGUAGE['teacher_article_loc'][DEFAULT_LANGUAGE].'" pattern=".{25,80}" title="Minimum value is 25 characters AND Maximum value is 80 characters" /></div>
<div><input type="text" name="link" value="" placeholder="'.$_LANGUAGE['teacher_article_link'][DEFAULT_LANGUAGE].'"/></div>
<div><center><input type="submit" name="save_btn" id="save_btn" value="'.$_LANGUAGE['save'][DEFAULT_LANGUAGE].'"/></center></div>
</div>
</form>
';
echo $html;
}

}


function article($pdo){
global $_LANGUAGE;
if(isset($_GET['teacher']) && !empty($_GET['teacher']) && intval($_GET['teacher'])){
$html = array();
$id = intval($_GET['teacher']);
$template = '<div class="teacher_article">
<div class="title"><img src="'.BASE_PATH.'/assets/img/article.png" align="absmiddle"/>&nbsp;&nbsp;{title}{remove}</div>
<div>&nbsp;&nbsp'.$_LANGUAGE['teacher_article_info'][DEFAULT_LANGUAGE].':</div>
<div>
&nbsp;&nbsp;'.$_LANGUAGE['date'][DEFAULT_LANGUAGE].': {date}
</div>
<div>&nbsp;&nbsp;'.$_LANGUAGE['teacher_article_loc'][DEFAULT_LANGUAGE].': {place}</div>
<div>&nbsp;&nbsp;'.$_LANGUAGE['teacher_article_presentation'][DEFAULT_LANGUAGE].': {presentation}</div>
<div>&nbsp;&nbsp;'.$_LANGUAGE['teacher_article_link'][DEFAULT_LANGUAGE].': {link}</div>
</div>';
$remove = '<a href="javascript:void(0)" class="tooltip" title="'.$_LANGUAGE['tooltip_remove'][DEFAULT_LANGUAGE].'" onclick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/teacher/?do=delete&article={id}&token='.$_SESSION['token'].'" }else{ return false; }\'>X</a>';
$sql = "select * from teacher_article where uid=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':id',$id,PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$tpl = $template;
if(is_latin($row['title'])){
$tpl = str_replace('{title}','<div align="left">'.$row['title'].'</div>',$tpl);
}else{
$tpl = str_replace('{title}',$row['title'],$tpl);
}
if(isset($_SESSION['login']) && ($_SESSION['permission'] == 'teacher' || $_SESSION['permission'] == 'admin')){
$r = $remove;
$r = str_replace('{id}',$row['id'],$r);
$tpl = str_replace('{remove}',$r,$tpl);
}else{
$tpl = str_replace('{remove}','',$tpl);
}
$tpl = str_replace('{date}',$row['date'],$tpl);
$tpl = str_replace('{presentation}',$row['presentation'],$tpl);
$tpl = str_replace('{link}',$row['link'],$tpl);
$html[] = $tpl;
}
if(!empty($html)){
echo implode("\n",$html);
}
}else{
echo '<center><h3>'.$_LANGUAGE['no_data_display'][DEFAULT_LANGUAGE].'</h3></center>';
}
}
}



function delete($pdo){
if(isset($_GET['article']) && intval($_GET['article'])){
$article = intval($_GET['article']);
if($_SESSION['permission'] == 'teacher'){
$sql = "delete from teacher_article where id=:ar and uid=:uid";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':uid',$_SESSION['userId'],PDO::PARAM_INT);
}else if($_SESSION['permission'] == 'admin'){
$sql = "delete from teacher_article where id=:ar";
$stmt = $pdo->prepare($sql);
}
$stmt->bindvalue(':ar',$article,PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
}



?>
<div id="teacher_wrap">
<?php
$error = true;
$do = 'view';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower($_GET['do']));
}
switch($do){

case 'view':
$error = false;
view($pdo);
break;

case 'article':
$error = false;
article($pdo);
break;

case 'job':
if((isset($_SESSION['login']) && $_SESSION['permission'] == 'teacher') && (isset($_GET['token'],$_SESSION['token']) && $_GET['token'] == $_SESSION['token'])){
if(validRequest()){
$error = false;
job($pdo);
}
}
break;

case 'add':
if((isset($_SESSION['login']) && $_SESSION['permission'] == 'teacher') && (isset($_GET['token'],$_SESSION['token']) && $_GET['token'] == $_SESSION['token'])){
if(validRequest()){
$error = false;
add($pdo);
}
}
break;

case 'delete':
if((isset($_SESSION['login']) && ($_SESSION['permission'] == 'teacher' || $_SESSION['permission'] == 'admin')) && (isset($_GET['token'],$_SESSION['token']) && $_GET['token'] == $_SESSION['token'])){
if(validRequest()){
$error = false;
delete($pdo);
}
}
break;

}

if($error){
redirect(BASE_PATH.'/index.php',1);
}

?>
</div>