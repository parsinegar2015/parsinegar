<?php

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

$layout = false;
$page_display_title = '';
//$js_script = '';
$css = '
.page{ width: 1200px; float: left; min-height: 600px; margin-top: 55px; }
.page .pl{ width: 850px; float: left; min-height: 600px; }
.page .pr{ width: 350px; float: left; min-height: 600px; }
.page .pr div{ float: left; width: 310px; margin-left: 10px; min-height: 450px; background: #fbfbfb; border-radius: 5px 0px 0px 5px; border-left: 1px solid #f2f2f2; border-bottom: 1px solid #f2f2f2; text-align: right; }
.page .pr div ul li{ margin-bottom: 3px; }
.page .page_control{ width: 850px; height: 40px; float: left; text-align: right; }
.page .page_control input{ width: 100px; height: 30px; background: #f2f2f2; border: 1px solid #ccc; border-radius: 0px 5px 5px 0px; cursor: pointer; }
.page .page_control input:hover{ background: #fbfbfb; }
.page .page_control input:first-child{ border-radius: 5px 0px 0px 5px; }
.add_new_page form div{ width: 90%; text-align: right; }
.add_new_page form input[type=text]{ width: 90%; height: 30px; margin-bottom: 30px; font-weight: bold; font-size: 15px; direction: rtl; }
.add_new_page form /*textarea{ width: 90%; height: 500px; margin-bottom: 30px; font-size: 15px; }*/
.save_page_btn{ width: 150px; height: 40px; background: green; cursor: pointer; border: 2px solid #ccc; border-radius: 5px; font-weight: bold; font-size: 15px; }
.save_page_btn:hover{ background: #fbfbfb; }
.add_new_page form input[type=submit]{ font-family: tahoma; }
.center {
  text-align: center;
}
';

if(isset($_GET['do']) && ($_GET['do'] == 'add' || $_GET['do'] == 'edit')){
$js_script = '
$save = false;
$("#save_page_btn").click(function(){
$save = true;
});
$(window).on("beforeunload", function(e){
  if(!$save){
  return "Are you sure you want to leave?";
  }else{
   e=null;
  }
});';
}


function buffer_fetch_tpl($file){
ob_start(); 
include($file);
$output = ob_get_contents();
ob_end_clean();

return $output;
}

function tplcover($pdo,$content='',$page_control=''){
$tpl = '
<div class="page">
{page_control}
<div class="pl">{html}</div>
<div class="pr">
 <div>
  {makepage}
  {links}
 </div>
</div>
</div>
';
$sql = "select id,link from page";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$link = array();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$link[] = '<a href="'.BASE_PATH.'/page/?link='.$row['id'].'">'.$row['link'].'</a>';
 }
$tpl = str_replace('{links}','<ul><li>'.implode("</li><li>",$link).'</li></ul>',$tpl); 
}else{
$tpl = str_replace('{links}','',$tpl); 
}
if(isset($_SESSION['login']) && $_SESSION['permission'] == 'admin'){
$tpl = str_replace('{makepage}','<a href="'.BASE_PATH.'/page/?do=add&token='.$_SESSION['token'].'">ایجاد صفحه+</a><br/>',$tpl); 
}else{
$tpl = str_replace('{makepage}','',$tpl);
}
$tpl = str_replace('{page_control}',$page_control,$tpl);
$tpl = str_replace('{html}',$content,$tpl); 
return $tpl;
}


function add($pdo,$title='',$link='',$text='',$edit=false){
global $page_display_title;
if(isset($_POST['title'],$_POST['html'],$_POST['link']) && !empty($_POST['title']) && !empty($_POST['link']) && is_string($_POST['title']) && is_string($_POST['link'])){
if(!$edit){
#==========
$sql = "select id from page order by id DESC limit 1";
$stmt = $pdo->query($sql);
$id = (int) $stmt->fetchColumn(0);
++$id;
if($id < 1){ $id = 1; }
#==========
file_put_contents('pages/'.$id.'.html',$_POST['html']);
#==========
$sql = "insert into page(`title`,`link`) values(:t,:l)";
}else{
file_put_contents('pages/'.intval($edit).'.html',$_POST['html']);
$sql = "update page set title=:t,link=:l where id=:i";
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':t',filter_var($_POST['title'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->bindvalue(':l',filter_var($_POST['link'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
//$stmt->bindvalue(':h',$_POST['html'],PDO::PARAM_STR);
if($edit){
$stmt->bindvalue(':i',intval($edit),PDO::PARAM_INT);
}
if($stmt->execute()){
sitemap($pdo);
if(!$edit){
$sql = "select id from page order by id DESC limit 1";
$stmt = $pdo->query($sql);
$id = $stmt->fetchColumn(0);
}else{
$id = intval($edit);
}
redirect(BASE_PATH.'/page/?link='.$id,1);
}

}else{
if(isset($_POST['title'],$_POST['html'],$_POST['link'])){
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
$link  = filter_var($_POST['link'],FILTER_SANITIZE_STRING);
$text  = $_POST['html'];
}
$hide = '';
if($edit){
$hide = '<input type="hidden" name="edit" value="'.$edit.'"/>';
}else{
$page_display_title = 'ایجاد صفحه جدید';
}
$html = '
<div class="add_new_page">
<center>
<form method="post">
<div><b>عنوان صفحه</b></div>
<br/>
<input type="text" value="'.$title.'" name="title"/>

<div dir="rtl"><b>محتوی (کد اچ تی ام ال، اسکریپت، سی اس اس)</b>&nbsp<a href="http://daringfireball.net/projects/markdown/basics" target="_blank">آموزش Markdown</a></div>
<br/>
<textarea name="html" rows="15">'.$text.'</textarea>
<br/>
<div><b>عنوان پیوند</b></div>
<div><i>مهم: بهتر است از عبارت کوتاه و با معنی استفاده شود</i></div>
<br/>
<input type="text" value="'.$link.'" name="link"/>
'.$hide.'
<br/><input type="submit" id="save_page_btn" class="btn btn-success" value="ذخیره" />
</form>
</center>
</div>
';
echo tplcover($pdo,$html);
}

}



function view($pdo){
global $page_display_title;
$control = '';
if(isset($_GET['link']) && intval($_GET['link'])){
$id = intval($_GET['link']);
$sql = "select title from page where id=:i";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':i',$id,PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$page_display_title = $row['title'];
if(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['permission'] == 'admin'){
$control = '<div class="page_control"><input type="button" value="ویرایش" onclick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/page/?do=edit&link='.$id.'&token='.$_SESSION['token'].'" }else{ return false; }\'/><input type="button" value="حذف" onclick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/page/?do=delete&link='.$id.'&token='.$_SESSION['token'].'" }else{ return false; }\'/></div>';
}
include('lib/Markdown.inc.php'); //parsedown.php
//$Parsedown = new Parsedown(); $Parsedown->text(file_get_contents('pages/'.$id.'.html'))
return tplcover($pdo,\Michelf\Markdown::defaultTransform(file_get_contents('pages/'.$id.'.html')),$control);
}
return tplcover($pdo);
}
}



function edit($pdo){
global $page_display_title;
if(isset($_GET['link']) && intval($_GET['link']) && isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
$id = intval($_GET['link']);
$sql = "select * from page where id=:i";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':i',$id,PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$page_display_title = $row['title'];
if(file_exists('pages/'.$id.'.html')){
add($pdo,$row['title'],$row['link'],file_get_contents('pages/'.$id.'.html'),$id);
}else{
add($pdo,$row['title'],$row['link'],'File Not Found',$id);
}
}
}else{
 redirect(BASE_PATH.'/page/',1);
}
}




function delete($pdo){
if(isset($_GET['link']) && intval($_GET['link'])){
$id = intval($_GET['link']);
$sql = "delete from page where id=".$id;
$pdo->exec($sql);
unlink('pages/'.$id.'.html');
}
redirect(BASE_PATH.'/page/',1);
}



/**
 * PRIVATE FUNCTION *
 ******SITEMAP*******
 *==================*/
function sitemap($pdo){
$template = '
<?xml version="1.0" encoding="UTF-8"?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
	  xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
	  xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0">
	  
	  <url>
      <loc>'.BASE_PATH.'/index.php</loc>
	  <priority>1</priority>
      </url>
	  
	  {url_block}
	  
</urlset>
	  
';

$url = '
<url>
 <loc>{url}</loc>
</url>
';
$url_block = array();
$sql = "select id from page";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$u = $url;
$url_block[] = str_replace('{url}',BASE_PATH.'/page/?link='.$row['id'],$u);
}
}
if(!empty($url_block)){
$template = str_replace('{url_block}',implode("\n",$url_block),$template);
}else{
$template = str_replace('{url_block}','',$template);
}
file_put_contents('sitemap.xml',$template);
}



$error = false;


$do = 'tplcover';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower($_GET['do']));


switch($do){

case 'tplcover':
$error = false;
echo tplcover($pdo);
break;

case 'add':
if(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['permission'] == 'admin'){
add($pdo);
}else{
$error = true;
}
break;

case 'edit':
if(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['permission'] == 'admin'){
edit($pdo);
}else{
$error = true;
}
break;

case 'delete':
if(isset($_SESSION['login']) && $_SESSION['login'] && $_SESSION['permission'] == 'admin'){
delete($pdo);
}else{
$error = true;
}
break;

}

}else{
if(isset($_GET['link']) && intval($_GET['link'])){
  echo view($pdo);
 }else{
  echo tplcover($pdo);
 }
}


if($error){
redirect(BASE_PATH.'/index.php',1);
}

?>