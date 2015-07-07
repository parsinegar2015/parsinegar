<?php
if(!isset($_SESSION['login']) || $_SESSION['permission'] != 'admin'){
redirect(BASE_PATH.'/',1);
}

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

function formatbytes($file, $type){
     switch($type){
      case "KB":
         $filesize = filesize($file) * .0009765625; // bytes to KB
      break;
      case "MB":
         $filesize = (filesize($file) * .0009765625) * .0009765625; // bytes to MB
      break;
      case "GB":
         $filesize = ((filesize($file) * .0009765625) * .0009765625) * .0009765625; // bytes to GB
      break;
   }
   if($filesize <= 0){
      return $filesize = 'unknown file size';}
   else{return round($filesize, 2).' '.$type;}
  }
  
		  
function upload($pdo){
$error = true;
if(validRequest()){
if(isset($_GET['token'],$_SESSION['token']) && $_GET['token'] == $_SESSION['token']){
if(isset($_FILES["file"]) && isset($_POST['title']) && !empty($_POST['title'])){
$upload_dir = "files/";
$target_file = $upload_dir . basename($_FILES["file"]["name"]);
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$file_name = rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9);
$target_file = $upload_dir.$file_name.'.'.$fileType;
if($_FILES["file"]["size"] <= 4000000) {
if(in_array($fileType,array('pdf','jpg','gif','png','bmp','doc','docx','ppt','mp3','mp4','xls','xlsx','zip','rar','gz','txt'))){
if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
$file = array('name'=>$target_file,'size'=>formatbytes($target_file,"KB"),'type'=>strtoupper($fileType));
$sql = "insert into cmsfiles(`uId`,`file`,`title`,`size`,`type`) value(:uId,:file,:title,:size,:type)";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':uId',$_SESSION['userId'],PDO::PARAM_INT);
$stmt->bindValue(':file',$file['name'],PDO::PARAM_STR);
$stmt->bindValue(':size',$file['size'],PDO::PARAM_STR);
$stmt->bindValue(':type',$file['type'],PDO::PARAM_STR);
$stmt->bindValue(':title',filter_var($_POST['title'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->execute();
$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
$last_id = $stmt->fetchColumn(0);
$error = false;
}
}
}
}
}
}
if($error){
_log('error_upload','Avoid incorrect information','user id='.(isset($_SESSION['userId']))? $_SESSION['userId'] : 'null');
echo 'Error';
exit();
}else{
_log('info_upload','1 file(s) successfully added to the cms file manager');
if(ajax()){
echo json_encode(array("error"=>"0","title"=>$_POST['title'],"size"=>$file['size'],"type"=>$file['type'],"name"=>$file['name'],"id"=>$last_id));
exit();
}else{
redirect(BASE_PATH.'/filemanage/',1);
}
}
}





//===================================================================

$css = '
#upload_box{ width: 900px; height: 100px; border: 1px solid #CCC; float: left; margin-left: 50px; }
#files_type{ width: 900px; height: 60px; float: left; margin-top: 10px; margin-bottom: 10px; background: url('.BASE_PATH.'/assets/img/files.png) center center no-repeat; }
#del_title{ width: 900px; height: 40px; background: #fafafa; border: 1px solid #fafafa; margin-top: 20px; float: left; margin-left: 50px; text-align: left; }
#grid_title{ width: 900px; height: 40px; background: #ddd; border: 1px solid #ddd; margin-top: 10px; float: left; margin-left: 50px; }
#upload_box form a{ float: right; margin-right: 15px; margin-left: 25px; margin-top: 2px; }
#upload_box form input{ float: right;  /*margin-top: 25px; margin-right: 15px;*/ }
#upload_box form input[type=file]{ display: none; /*margin-top: 40px; width: 250px;*/ }
#upload_box form input[type=text]{ width: 400px; height: 36px; direction: rtl; font-family: tahoma; font-size: 14px; font-weight: bold; margin-top: 30px; outline: none; border-radius: 0px 5px 5px 0px; border: 1px solid #ccc; }
#upload_box form input[type=submit]{ width: 100px; height: 36px; border-radius: 5px 0px 0px 5px; background: url('.BASE_PATH.'/assets/img/upload.png) left center no-repeat #78d5e5; border: 1px solid #78d5e5; margin-top: 30px; margin-right: 0px; cursor: pointer; font-weight: bold; }
#grid_title div{ width: 175px; height: 40px; float: left; font-weight: bold; margin: 0px; }
#file_grid{ width: 900px; height: auto; margin-top: 10px; float: left; margin-left: 50px; }
#file_grid div.row{ float: left; }
#file_grid div.row:hover{ background: #fafafa; }
#file_grid div.row div{ width: 180px; height: 40px; float: left; font-weight: bold; }
#del_title input{ width: 100px; height: 30px; margin-top: 5px; margin-left: 50px; border: 1px solid #FF00FF; border-radius: 5px; background: none; font-family: tahoma; font-size: 14px; color: #FF00FF; cursor: pointer; }
#del_title input[disabled]{ 
     cursor: default;
     pointer-events: none;

     /*Input disabled - CSS color class*/
     color: #c0c0c0;
     border: 1px solid #c0c0c0; 
	 }
@-webkit-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
@-o-keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
@keyframes progress-bar-stripes {
  from {
    background-position: 40px 0;
  }
  to {
    background-position: 0 0;
  }
}
.progress {
  height: 30px;
  width: 502px;
  margin-bottom: 20px;
  <!--overflow: hidden;-->
  background-color: #f5f5f5;
  border-radius: 5px;
  -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
          box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
}
.progress-bar {
  float: left;
  width: 0;
  height: 100%;
  font-size: 12px;
  line-height: 20px;
  color: #fff;
  text-align: center;
  background-color: #000;
  -webkit-box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
          box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .15);
  -webkit-transition: width .6s ease;
       -o-transition: width .6s ease;
          transition: width .6s ease;
}
.progress-striped .progress-bar,
.progress-bar-striped {
  background-image: -webkit-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:      -o-linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  background-image:         linear-gradient(45deg, rgba(255, 255, 255, .15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, .15) 50%, rgba(255, 255, 255, .15) 75%, transparent 75%, transparent);
  -webkit-background-size: 40px 40px;
          background-size: 40px 40px;
}
.progress.active .progress-bar,
.progress-bar.active {
  -webkit-animation: progress-bar-stripes 2s linear infinite;
       -o-animation: progress-bar-stripes 2s linear infinite;
          animation: progress-bar-stripes 2s linear infinite;
}
.progress-bar[aria-valuenow="1"],
.progress-bar[aria-valuenow="2"] {
  min-width: 30px;
}
.progress-bar[aria-valuenow="0"] {
  min-width: 30px;
  color: #777;
  background-color: transparent;
  background-image: none;
  -webkit-box-shadow: none;
          box-shadow: none;
}

#prgtooltip{ float: left; height: 100%; width: 1px; }
#prgtooltip div{ position: relative; top: -50px; left: -44px; height: 40px; width: 70px; background: #333; border: 1px solid #000; float: left; display: none; color: #fff; border-radius: 5px; line-height: 30px; text-align: center; font-size: 20px; box-shadow: 0px 0px 10px #666; }
#prgtooltip div:after {
  content: "";
  display: block; /* reduce the damage in FF3.0 */
  position: absolute;
  bottom: -15px;
  left: 20px;
  width: 0;
  border-width: 15px 15px 0;
  border-style: solid;
  border-color: #333 transparent;
}

#upload_box #ajaxupload{ height: 100%; width: 100%; display: none; }

';

$js_data = '
define([],function(){
$(function(){
$(".delete").live("click",function(){
self = $(this);
if(self.is(":checked")){
self.parent().parent().css("background","#FF7F50");
$("#del_title input").prop("disabled",false);
}else{
self.parent().parent().css("background","");
if(!$(".delete:checked").length){
$("#del_title input").prop("disabled",true);
}
}
});


$(".copy").on("copy", function(e) {
          e.clipboardData.clearData();
          e.clipboardData.setData("text/plain", $(this).data("url"));
          e.preventDefault(); 
        })
		.on("aftercopy", function(e){
        alert("Copy succeeded");
        });
	document.addEventListener("DOMNodeInserted", function(e) {
      $(".copy").on("copy", function(e) {
          e.clipboardData.clearData();
          e.clipboardData.setData("text/plain", $(this).data("url"));
          e.preventDefault(); 
        })
		.on("aftercopy", function(e){
        alert("Copy succeeded");
        });
    });

$(".file_frm").submit(function(e){
uploadFile(e);
});
});


function in_array(needle, haystack, argStrict) {
  var key = "",
    strict = !! argStrict;

  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}


function startproccess(){
$("form.file_frm").fadeOut("fast",function(){
	$("#ajaxupload").fadeIn("slow");
	});
	
    $("#prgtooltip div").fadeIn("slow");
	
	return true;
}

function endproccess(){


	$("#ajaxupload").fadeOut("fast",function(){
	$("form.file_frm").fadeIn("slow");
	
	$("#prgtooltip div").fadeOut("fast",function(){
	$("#prgtooltip div").html("");
	$("#prg2").css("width","0px");
	});
	
	});

	return true;
}


function addrow(data){
var $row_tpl = \'<div class="row"> \\
<div><input type="checkbox" name="delete[]" class="delete" value="{id}"/></div> \\
<div>{size}</div> \\
<div><b>{type}</b></div> \\
<div><img src="'.BASE_PATH.'/assets/img/link.png" class="copy" data-url="'.BASE_PATH.'/{name}"/>{title}</div> \\
<div class="file_row_id">{row_number}</div> \\
</div>\';


var row_number = 1;
if($(".file_row_id").length > 0){
row_number = $(".file_row_id").length;
++row_number;
}


$row = $row_tpl;
$row = $row.replace("{name}",data.name);
$row = $row.replace("{size}",data.size);
$row = $row.replace("{title}",data.title);
$row = $row.replace("{type}",data.type);
$row = $row.replace("{id}",data.id);
$row = $row.replace("{row_number}",row_number);
$("#file_grid").append($row);
}


function _(el){
	return document.getElementById(el);
}
function uploadFile(event){
	event.preventDefault();
	var ext4 = $("#file").val().substr(-4);
	var ext2 = $("#file").val().substr(-2);
    if($("input[name=title]").val().match(/^[\s\t\r\n]*\S+/ig) && (in_array(ext4, [".pdf",".jpg",".png",".gif",".bmp",".zip",".rar",".doc","docx",".ppt",".xls","xlsx",".txt",".mp3",".mp4"]) || ext2 == "gz")){
	if(startproccess()){
	var file = _("file").files[0];
	// alert(file.name+" | "+file.size+" | "+file.type);
	var formdata = new FormData();
	formdata.append("file", file);
	formdata.append("title", $("input[name=title]").val());
	var ajax = new XMLHttpRequest();
	//ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
	ajax.upload.addEventListener("progress", progressHandler, false);
	//ajax.addEventListener("load", completeHandler, false);
	ajax.addEventListener("error", errorHandler, false);
	ajax.addEventListener("abort", abortHandler, false);
	ajax.onreadystatechange=function(){
    if(ajax.readyState==4 && ajax.status==200){
	setTimeout(function(){
	endproccess();
	if(ajax.responseText != "Error"){ //isJson()
    var j = jQuery.parseJSON(ajax.responseText);
    if(j.error == 0){
    alert("فایل شما با موفقیت آپلود گردید");
	addrow(j);
    }
    }else{
	alert("عملیات با خطا مواجه گردید");
    }
	}, 4000);

    
    
     }
    }
    
	ajax.open("POST", "'.BASE_PATH.'/filemanager/?do=upload&token='.$_SESSION['token'].'",true);
	ajax.setRequestHeader("X-Requested-With","XMLHttpRequest"); //HTTP_X_REQUESTED_WITH
	ajax.send(formdata);
	}
	}
}
function progressHandler(event){
	var percent = (event.loaded / event.total) * 100;
	_("prg2").innerHTML = Math.round(percent)+"%";
	$("#prgtooltip div").html(Math.round(percent)+"%");
	prg = Math.round(percent) * 5;
	_("prg2").style.width = prg+"px";
}
function completeHandler(event){
if(endproccess()){
if(isJson(event.target.responseText)){
var j = jQuery.parseJSON(event.target.responseText);
if(j.error == 0){
alert("فایل شما با موفقیت آپلود گردید");

}
}else{
alert("عملیات با خطا مواجه گردید");
}
}	
	
}
function errorHandler(event){
endproccess()
alert("Error");
}
function abortHandler(event){
	endproccess();
	alert("Error");
}
});
';



include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('filemanager_cms')){
if(!$js->comp('filemanager_cms',\parsinegar\js::min($js_data))){
$js->file('filemanager_cms',\parsinegar\js::min($js_data));
}
}else{
$js->file('filemanager_cms',\parsinegar\js::min($js_data));
}



function view($pdo){
global $_LANGUAGE;
$template = '<center>
<div id="upload_box">
<form class="file_frm" method="post" enctype="multipart/form-data" onSubmit="javascript:uploadFile(event)">
<input type="file" name="file" id="file" value="" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.zip,.rar,.gz,.mp3,.png,.jpg,.gif,.txt"/>
<a href="javascript:void(0)" onClick=\'document.getElementById("file").click();\'><img src="'.BASE_PATH.'/assets/img/browse.png"/></a>
<input type="text" name="title" id="title" value="" placeholder="عنوان فایل"/>
<input type="submit" value="Upload"/>
</form>
<div id="ajaxupload">
<center>
<img src="'.BASE_PATH.'/assets/img/upload.png"/>&nbsp;&nbsp;Uploading...
<br/>
<div class="progress">
 <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" id="prg2"></div>
 <div id="prgtooltip" title="" class="prgtooltip"><div></div></div>
</div>
</center>
</div>
</div>
<div id="files_type"></div>
<form method="post" action="'.BASE_PATH.'/filemanager/?do=delete&token='.$_SESSION['token'].'">
<div id="del_title"><input type="submit" id="btn_del_file" disabled="disabled" value="'.$_LANGUAGE['tooltip_remove'][DEFAULT_LANGUAGE].'" /></div>
<div id="grid_title">
<div></div>
<div>حجم فایل</div>
<div>نوع فایل</div>
<div>عنوان</div>
<div>ردیف</div>
</div>
<div id="file_grid">
{files_row}
</div>
</form>
</center>';

if(isset($_SESSION['userId']) && intval($_SESSION['userId'])){
$files_row = array();
$uid = intval($_SESSION['userId']);
$sql = "select * from cmsfiles where uId=".$uid." order by id ASC";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i = 1;

foreach($rows as $row){
$tpl_row = '
<div class="row">
<div><input type="checkbox" name="delete[]" class="delete" value="'.$row['id'].'"/></div>
<div>'.$row['size'].'</div>
<div><b>'.$row['type'].'</b></div>
<div><img src="'.BASE_PATH.'/assets/img/link.png" class="copy" data-url="'.BASE_PATH.'/'.$row['file'].'"/>'.$row['title'].'</div>
<div class="file_row_id">'.$i.'</div>
</div>
'."\n";
$i++;
$files_row[] = $tpl_row;
}
$template = str_replace('{files_row}',implode("\n",$files_row),$template);
}else{
$template = str_replace('{files_row}','',$template);
}
echo $template;
}else{
redirect(BACK_ADDRESS,1);
}

}

function delete($pdo){
$file_dir = "files/";
if(isset($_POST['delete']) && is_array($_POST['delete']) && !empty($_POST['delete']) && intval($_SESSION['userId']) && $_SESSION['permission'] == 'admin'){
foreach($_POST['delete'] as $fid){
$sql = "select file from cmsfiles where id=:i and uId=:u";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':i',intval($fid),PDO::PARAM_INT);
$stmt->bindvalue(':u',$_SESSION['userId'],PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$file_name = $stmt->fetchColumn();
$sql = "delete from cmsfiles where id=".intval($fid);
if($pdo->exec($sql)){
unlink($file_name);
}
}
}
}
redirect(BASE_PATH.'/filemanager/',1);
}




$do = 'view';
if(isset($_GET['do'])){
$do = $_GET['do'];
}

switch($do){

case 'view':
view($pdo);
break;

case 'upload':
upload($pdo);
break;

case 'delete':
delete($pdo);
break;

}

?>
