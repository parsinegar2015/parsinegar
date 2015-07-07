<?php

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
 #article_wrap{ float: left; width: 800px; margin-left: 50px; }
 .entry{ width: 100%; border-radius: 5px; border: 1px solid #DDDDDD; background: #F5F5F5; min-height: 200px; float: left; margin-top: 30px; }
 .entry .fa_title{ width: 100%; height: 40px; background: #FFFFFF; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #DDDDDD; float: left; text-align: right; direction: rtl; }
 .entry .content{ width: 98%; min-height: 100px; margin-left: 1%; float: left; }
 .entry .content .fa_author{ float: right; margin-top: 15px; margin-right: 20px; min-width: 350px; height: 30px; clear: left; margin-left: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-right: 1px solid #666; color: #000; text-align: right; direction: rtl; }
 .entry .content .fa_date{ float: right; margin-top: 3px; margin-right: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-right: 1px solid red; color: #CCC; text-align: right; }
 .entry .content .fa_major{ float: right; margin-top: 3px; margin-right: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-right: 1px solid #283199; color: #CCC; text-align: right; direction: rtl; }
 .entry .content .fa_more{ float: right; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-right: 5%; text-align: right; direction: rtl; }
 .entry .content .fa_more a.keyword_link:link{ float: right; text-decoration: none; padding: 5px; background: #66FFFF; margin-right: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; color: blue; }
 .entry .content .fa_more a.keyword_link:hover{ background: #CCC; }
 .entry .content .fa_file{ float: right; width: 90%; margin-right: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; margin-bottom: 10px; }
 .entry .content .fa_file div{ float: left; width: 500px; height: 100px; text-align: right; direction: rtl; }
 .entry .content .fa_file div.logo{ width: 98px; }
 .print_fa{ float: left; width: 100%; margin-top: 20px; border: 1px double #ccc; background: #fcfcfc; text-align: right; }
 
 .entry .title{ width: 100%; height: 40px; background: #FFFFFF; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #DDDDDD; float: left; }
 .entry .content .en_author{ float: left; margin-top: 15px; margin-left: 20px; min-width: 350px; height: 30px; margin-right: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-left: 1px solid #666; color: #000; text-align: left; direction: ltr; }
 .entry .content .en_date{ float: left; margin-top: 3px; margin-left: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-left: 1px solid red; color: #CCC; text-align: left; }
 .entry .content .en_major{ float: left; margin-top: 3px; margin-left: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-left: 1px solid #283199; color: #CCC; text-align: left; direction: rtl; }
 .entry .content .more{ float: left; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-left: 5%; }
 .entry .content .more a.keyword_link:link{ float: left; text-decoration: none; padding: 5px; background: #66FFFF; margin-left: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; color: blue; }
 .entry .content .more a.keyword_link:hover{ background: #CCC; }
 .entry .content .en_file{ float: left; width: 90%; margin-left: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; }
 .entry .content .en_file div{ float: right; width: 500px; height: 100px; text-align: left; }
 .entry .content .en_file div.logo{ width: 98px; }
 .print_en{ float: left; width: 100%; margin-top: 20px; border: 1px double #ccc; background: #fcfcfc; text-align: left; 100px; }
 
 form[name=add_thesis] input,form[name=add_thesis] select{ outline: none; }
 .fa_article_add{ float: left; width: 800px; margin-left: 50px; margin-top: 20px; }
 .fa_article_add .title{ float: right; width: 100%; height: 50px; font-family: tahoma; font-size: 24px; font-weight: bold; color: #000; text-align: right; }
 .fa_article_add .input_title{ float: right; width: 100%; height: 30px; border-right: 3px solid #ccc; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; text-align: right; direction: rtl; margin-top: 10px; }
 .fa_article_add .input{ float: right; width: 100%; height: 30px; margin-top: 10px; margin-bottom: 10px; }
 .fa_article_add .input input[type=text]{ float: right; width: 99%; height: 28px; border: 1px solid #ccc; border-radius: 5px; background: #fff; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; direction: rtl; }
 .fa_article_add .input select{ float: right; width: 99%; height: 28px; direction: rtl; }
 .fa_article_add .input_desc{ float: right; width: 100%; height: 20px; font-family: tahoma; font-size: 12px; color: #ccc; text-align: right; direction: rtl; }
 .fa_article_add .input_multi{ float: right; width: 100%; min-height: 300px; margin-top: 10px; }
 .fa_article_add .input_multi textarea{ float: right; }
 .fa_article_add .selected_items_box{ float: right; width: 99%; min-height: 100px; border: 1px solid; margin-top: 10px; margin-bottom: 10px; }
 .fa_article_add .input .keyword_typeahead{ position: absolute; width: 788px; margin-top: 35px; height: 150px; background: #eee; border: 1px solid #ccc; border-radius: 5px; padding: 5px; text-align: right; display: none; z-index: 1000; }
 .fa_article_add .input .keyword_typeahead .k_item{ float: right; min-width: 110px; padding: 5px; heigh: 30px; margin-right: 10px; margin-top: 10px; background: #ddd; cursor: pointer; }
 .fa_article_add .input .keyword_typeahead .k_item:hover{ background: #ccc; }
 
 .field-item{ min-width: 100px; margin: 5px; padding: 5px; float: right; border-radius: 5px; min-height: 20px; background: #CCC; cursor: pointer; }
 .field-item:hover{ background: #ddd; }
 .field-item:active{ background: #888; }
 
 .addgrade input[type=text]{ width: 90%; height: 30px; padding: 5px; border: 1px solid #ccc; border-radius: 5px; direction: rtl; font-size: 17px; }
 .addgrade input[type=submit]{ width: 150px; height: 30px; border: 2px solid #ccc; border-radius: 5px; background: red; font-weight: bold; }
 .addgrade input[type=submit]:hover{ background: #CC0000; }
 ';

 
if(isset($_GET['do']) && ($_GET['do'] == 'add' || $_GET['do'] == 'edit')){
$js_script = '
$save = false;
$("#save_thesis_btn").click(function(){
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
 
 
$js_data = '
define([],function(){
$(function(){
$("form[name=add_thesis]").submit(function(event){
$("input:not([type=submit])").each(function(){
if(!$(this).val().match(/^[\s\t\r\n]*\S+/ig)){
self = $(this);
name = self.attr("name");
if(name != "url" && name != "title2"){
self.css("border","1px solid red");
event.preventDefault();
}
}
self = $(this);
name = self.attr("name");
if(name == "date"){
    if(!/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(self.val())){
    self.css("border","1px solid red");
	event.preventDefault();
     }else{
	 self.css("border","1px solid #ccc");
	 }
    }
});
if(!$("textarea[name=min_ckeditor]").val().match(/^[\s\t\r\n]*\S+/ig)){
event.preventDefault();
}
if($("select[name=teacher]").find(":selected").text() == "Choose here"){
$("select[name=teacher]").css("border","1px solid red");
event.preventDefault();
}
});

$("select[name=teacher]").change(function(){
if($(this).find(":selected").text() != "Choose hare"){
$(this).css("border","");
}else{
$(this).css("border","1px solid red");
}
});

$("form[name=add_thesis] input[type=text]").live("blur",function(){
	self = $(this);
	name = self.attr("name");
	if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){
		if(name != "url" && name != "title2"){
		self.css("border","1px solid red");
		}
		}else{
		  self.css("border","1px solid #ccc");	
			}		
	  if(name == "url" && self.val().match(/^[\s\t\r\n]*\S+/ig)){
		  if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(self.val())){
			  self.css("border","1px solid red");
			  }
		  }	
       if(name == "date"){
		if(!/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(self.val())){
	       self.css("border","1px solid red");
	     }
		}		  
	});
$("form[name=add_thesis] input[type=text]").live("keyup change click",function(){
	self = $(this);
	if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){
		self.css("border","1px solid #ccc");
	}
	name = self.attr("name");		
	  if(name == "url" && self.val().match(/^[\s\t\r\n]*\S+/ig)){
		  if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&\'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(self.val())){
			  self.css("border","1px solid red");
			  }
		  }
		if(name == "date"){
		if(!/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(self.val())){
	       self.css("border","1px solid red");
	     }
		}
	});
	

$("input[name=keywords]").on({
 focus : function(){
  $(".keyword_typeahead").fadeIn("slow");
 },
 click : function(){
  return false;
 }
});

$(".keyword_typeahead").click(function(event){
//alert("test");
//event.preventDefault();
//return false;
//$("input[name=keywords]").focus();
});

$(document).click(function(){
$(".keyword_typeahead").fadeOut("slow");
});


var keyword_js_var = '.keywordjs($pdo).';


function findMatches(q, strs) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
    
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp("^"+q, "i");
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push(\'<div class="k_item">\'+str+\'</div>\');
      }
    });
 
    return matches.join("\n");
  };


$(".k_item").live("click",function(){
var $val = $("input[name=keywords]").val();
var arr = $val.split("-");
arr.pop();
$val = arr.join("-");
var xlen = arr.length;
$dash = "";
if(xlen > 0){
$dash = "-";
}
$("input[name=keywords]").val($val+$dash+$(this).html());
});
  
$("input[name=keywords]").on("keyup",function(){
var $val = $(this).val();
if($val != "" && $val.substr(-1) != "-"){
var xarr = $val.split("-");
var xlen = xarr.length;
--xlen;
$(".keyword_typeahead").html(findMatches(xarr[xlen], keyword_js_var));

}
});	
});	
});
';



include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('thesis')){
if(!$js->comp('thesis',\parsinegar\js::min($js_data))){
$js->file('thesis',\parsinegar\js::min($js_data));
}
}else{
$js->file('thesis',\parsinegar\js::min($js_data));
}



$app->getDO('view',['auth_login'=>true],function() use($pdo){
global $paginate,$item_pre_page,$btn_pre_page,$_LANGUAGE,$page_display_title;
$page_display_title = $_LANGUAGE['thesis_list'][DEFAULT_LANGUAGE];
$more_view = false;
$title = '';
$t_arr = '';
$t = '';
$pageLink = '';
if(DEFAULT_LANGUAGE == 'fa'){
$more = '<div class="fa_more">{content}</div>';
$print = '<div class="print_fa">{link}&nbsp;<img src="'.BASE_PATH.'/assets/img/iprint.png"/></div>';
$tpl = '
<div class="entry">
<div class="fa_title"><a href="'.BASE_PATH.'/thesis/{link}" class="thesis_link">{title}</a></div>
<div class="content">
<div class="fa_author">نویسنده: {fullname}</div>
<div class="fa_date">تاریخ: {date}</div>
<div class="fa_major">رشته مرتبط: {major}</div>
{more}
</div>
</div>
{print}
';
}else if(DEFAULT_LANGUAGE == 'en'){
$more = '<div class="more">{content}</div>';
$print = '<div class="print_en"><img src="'.BASE_PATH.'/assets/img/iprint.png"/>&nbsp;{link}</div>';
$tpl = '
<div class="entry">
<div class="title"><a href="'.BASE_PATH.'/thesis/{link}" class="thesis_link">{title}</a></div>
<div class="content">
<div class="en_author">Author: {fullname}</div>
<div class="en_date">Date: {date}</div>
<div class="en_major">Major: {major}</div>
{more}
</div>
</div>
{print}
';
}
#get thesis
$sql = "select t.*,f.title as 'field',concat_ws(' ',u.fname,u.lname) as 'fullname' from thesis as t
inner join `user` as u
on u.id = t.uid
inner join `field` as f
on f.id = t.f_id
";
if(isset($_GET['title']) && !empty($_GET['title'])){
$title = urldecode(filter_var(htmlentities(htmlspecialchars($_GET['title'],ENT_QUOTES),ENT_QUOTES),FILTER_SANITIZE_STRING));
$t = $title;
	$t = preg_replace('/\s*/','',$t);
	$t = preg_replace('/\/*/','',$t);
}

if(!empty($t)){
$title = preg_replace('/\s+/',' ',$title);
$title  = str_replace('-',' ',$title);
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.\(\)\،\,\/]+$/u',$title)){
$t = preg_replace('/\s*/','',$title);
if(empty($t)){
$title = '';
}else{
$more_view = true;
if(strstr($title,'/')){
$t_arr = explode('/',$title);
$sql = $sql." where t.`id`=:i";
}else{
$sql = $sql." where t.title=:t1";
}
}
}else{
$title = '';
}
}else{
$title = '';
}
if($_SESSION['permission'] != 'admin'){
if(empty($title)){
$sql = $sql." where t.`status`=1";
}else{
$sql = $sql." and (t.`status`=1 or t.`uid`=".$_SESSION['userId'].")";
}
}

#======================
if(empty($title)){
$sql = $sql.' order by t.id DESC ';
#----------------------
$page = 1;
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
$page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));
}
$start = abs(($page-1) * $item_pre_page);
$end = $item_pre_page;
$sql = $sql.' LIMIT '.$start.', '.$end;
}
#======================

if(!empty($title)){
$sql = $sql." LIMIT 1";
}

$stmt = $pdo->prepare($sql);
if(!empty($title)){
if(is_array($t_arr)){
if(intval($t_arr[0]) && is_numeric($t_arr[0])){
$stmt->bindvalue(":i",filter_var($t_arr[0],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
}else{
$stmt->bindvalue(":i",0,PDO::PARAM_INT);
}
}else{
$stmt->bindvalue(":t1",$title,PDO::PARAM_STR);
}
}
$stmt->execute();
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$items = array();
foreach($rows as $row){
$title = $row['title'];
$link  = $row['id'].'/'.str_replace(' ','-',$title).'.html';
$atpl = $tpl;
$atpl = str_replace("{title}",$title,$atpl);
$atpl = str_replace("{link}",$link,$atpl);
$atpl = str_replace("{fullname}",$row['fullname'],$atpl);
$atpl = str_replace("{date}",$row['date'],$atpl);
$atpl = str_replace("{major}",$row['field'],$atpl);

#===============================
if($more_view){
$page_display_title = $row['title'];
$keywords = $row['keyword'].'-';
$keywords = explode('-',$keywords);
$keywords = array_filter($keywords);
$key_words = array();
foreach($keywords as $kw){
$key_words[] = '<a href="'.BASE_PATH.'/search/?q='.$kw.'&type=keywords" class="keyword_link">'.$kw.'</a>';
}
$more = str_replace("{content}",$row['content']."<br/>\n".implode("\n",$key_words),$more);
$atpl = str_replace("{more}",$more,$atpl);
#------------------------------
if(DEFAULT_LANGUAGE == 'fa'){
$print_link = '<a href="javascript:void(0);" onClick="window.open(\''.BASE_PATH.'/print.php?type=thesis&print='.$row['id'].'\',\'print\',\'resizable=no,\');">پرینت</a>';
}else{
$print_link = '<a href="javascript:void(0);" onClick="window.open(\''.BASE_PATH.'/print.php?type=thesis&print='.$row['id'].'\',\'print\',\'resizable=no,\');">Print</a>';
}
$print = str_replace('{link}',$print_link,$print);
$atpl = str_replace('{print}',$print,$atpl);
}else{
$atpl = str_replace("{more}",'',$atpl);
$atpl = str_replace('{print}','',$atpl);
}
#===============================

$items[] = $atpl;
}

#======================
if(empty($title)){
$sql = "select count(*) from thesis";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." where status=1";
}
$stmt = $pdo->query($sql);
$count = $stmt->fetchColumn(0);
if($count > 0){
##SET OUTPUT##
$paginate->init($count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/thesis/',
'separator' => "\n"
			
));
$pageLink = $paginate->displayLink();
}else{
$pageLink = '';
}
}
#======================

echo '<div id="article_wrap">'."\n".implode("\n",$items)."\n<br/>".$pageLink."</div>\n";
}else{
echo '<center><b>'.$_LANGUAGE['no_data_display'][DEFAULT_LANGUAGE]."</b><br/></center>";
}
});



$app->getDO('add',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function($options=false) use($pdo){
global $_LANGUAGE,$today,$page_display_title;
$add_thesis = 'null';
$page_display_title = $_LANGUAGE['add_thesis'][DEFAULT_LANGUAGE];
#=========================
$opt = array(
 'title' => '',
 'min_cheditor' => '',
 'keywords' => '',
 'teacher' => '',
 'enddate' => '',
 'edit' => 0
);
if(is_array($options)){
$opt = array_merge($opt,$options);
}
#=========================
$error_duplicate_add_thesis = false;
if($_SESSION['permission'] != 'admin'){
$sql = "select count(*) from thesis where uid=".$_SESSION['userId'];
$stmt = $pdo->query($sql);
if($stmt->fetchColumn(0) > 0){
$error_duplicate_add_thesis = true;
}
}
#=========================
if(isset($_POST['add_thesis']) && !empty($_POST['add_thesis'])){
$add_thesis = 'nope';
$title = '';
$content = '';
$keywords = '';
$teacher = '';
$enddate = '';
if(isset($_POST['title'],$_POST['min_ckeditor'],$_POST['keywords'],$_POST['teacher'],$_POST['date'])){


$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
$content = $_POST['min_ckeditor'];
$keywords = filter_var($_POST['keywords'],FILTER_SANITIZE_STRING);
$teacher = intval($_POST['teacher']);
$enddate = filter_var($_POST['date'],FILTER_SANITIZE_STRING);


#=======Check Title=======#
$title_error = true;
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
//$title = preg_replace('/[\@\^\!\#\&\*\(\)\+\=\-\'\$_]/', '', $title);
$title = preg_replace('/\s+/',' ',$title);
$title = str_replace('-',' ',$title);
if($title != ' ' && preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.\(\)\،\,]+$/u',$title)){
$t = preg_replace('/\s*/','',$title);
if(!empty($t)){
$title_error = false;
}
}
#=======Check Title=======#


#=======Check Content=======#
$content_error = true;
$c = preg_replace('/\s*/','',$content);
$c = preg_replace('/\/*/','',$c);
if(!empty($c)){
$c = preg_replace("/\<script[^>]*\>(.*)\<\s*\/script\s*\>/siU",'',$content);
$c = filter_var($c,FILTER_SANITIZE_STRING);
if(preg_match('/[\w\d\x{600}-\x{6FF}\s\-\=\%\^\(\)\.\&\#\!\?\؟\,\،\n\r\t]+$/u',$c)){
$content = preg_replace("/\<script[^>]*\>(.*)\<\s*\/script\s*\>/siU",'',$content);
$content = strip_tags($content,"<b><i><ol><li><s><p><ul><blockquote><center><br><br/></br><strong><em>");
if(mb_strlen($content, 'UTF-8') >= 50 && mb_strlen($content, 'UTF-8') <= 2000){
$content_error = false;
}
}
}
#=======Check Content=======#


#=======Check Keywords=======#
$keywords_error = true;
$k = preg_replace('/\s*/','',$keywords);
$k = preg_replace('/\/*/','',$k);
if(!empty($k)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.]+$/u',$keywords)){
if(substr_count($keywords,'-') <= 4){
$keywords_error = false;
}
}
}
#=======Check Keywords=======#


#=======Check Teacher=======#
$teacher_error = true;
if(intval($teacher) && is_numeric($teacher)){
$teacher_error = false;
}
#=======Check Teacher=======#


#=======Check ENDDATE=======#
$enddate_error = true;
if(preg_match("/^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/",$enddate)){
$enddate_error = false;
}
#=======Check ENDDATE=======#


//$trace_error = array( 'title_error' => $title_error, 'content_error' => $content_error, 'keywords_error' => $keywords_error, 'teacher_error' => $teacher_error, 'enddate_error' => $enddate_error);
if(!$title_error && !$content_error && !$keywords_error && !$teacher_error && !$enddate_error){
//$add_article = 'nope';


#=Check Valid ID======================================
$invalid_id = true;
if(isset($_POST['edit'])){
if(intval($_POST['edit'])){
$sql = "select id from thesis where id=:edit";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." and uid=:u";
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':edit',filter_var($_POST['edit'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
if($_SESSION['permission'] != 'admin'){
$stmt->bindvalue(':u',$_SESSION['userId'],PDO::PARAM_INT);
}
$stmt->execute();
if($stmt->rowCount()){
$invalid_id = false;
}
}
}else{
$invalid_id = false;
}
#=Check Valid ID======================================


$pdo->query("SELECT GET_LOCK('register-new-thesis',-1)");
$pdo->beginTransaction();
if(!isset($_POST['edit'])){
$sql = "insert into thesis(`uid`,`title`,`content`,`keyword`,`teacher`,`enddate`,`date`,`f_id`,`status`) values (:u,:t,:c,:k,:tr,:ed,:d,:f,0)";
}else{
#update
$sql = "update thesis set `title`=:t,`content`=:c,`keyword`=:k,`teacher`=:tr,`enddate`=:ed,`f_id`=:f where `id`=:edit";
}
if(isset($_POST['edit']) || !$error_duplicate_add_thesis){
if(!$invalid_id){
$stmt = $pdo->prepare($sql);
if(!isset($_POST['edit'])){
$stmt->bindvalue(':u',$_SESSION['userId'],PDO::PARAM_INT);
$stmt->bindvalue(':d',$today,PDO::PARAM_STR);
}else{
$stmt->bindvalue(':edit',$_POST['edit'],PDO::PARAM_INT);
}
$stmt->bindvalue(':t',$title,PDO::PARAM_STR);
$stmt->bindvalue(':c',$content,PDO::PARAM_STR);
$stmt->bindvalue(':k',$keywords,PDO::PARAM_STR);
$stmt->bindvalue(':tr',$teacher,PDO::PARAM_INT);
$stmt->bindvalue(':ed',$enddate,PDO::PARAM_STR);
$stmt->bindvalue(':f',$_SESSION['f_id'],PDO::PARAM_STR);
if($stmt->execute()){
_log('info_add','Thesis module successfully inserted a new record in the table thesis');
$add_thesis = 'ok';
}
$pdo->commit();
$pdo->query("SELECT RELEASE_LOCK('register-new-thesis')");
}else{
_log('critical_edit','Invalid ID was used','id='.$_POST['edit']);
}
}else{
#redirect to cpanel for duplicated error
redirect(BASE_PATH.'/me',1);
}
//if($add_article == 'ok'){

//}
}else{
_log('error_add','Avoid incorrect information');
}


}
}
if($add_thesis != 'ok'){

if($add_thesis == 'nope'){ // wrong data
$opt['title'] = $title;
$opt['min_cheditor'] = $content;
$opt['keywords']     = $keywords;
$opt['teacher']      = $teacher;
$opt['enddate']      = $enddate;
}


$class = 'fa_article_add';
$title = 'ثبت پایان نامه';
$article_title = 'عنوان';
$article_title_desc = '(این فیلد الزامی می باشد، می تواند شامل حروف و عدد و فاصله باشد)';
$abstract = 'چکیده پایان نامه';
$enddate = 'تاریخ ارائه (دفاع)';
$enddate_desc = 'تاریخ باید به شکل 1394/01/01 وارد شود';
$teacher_name = 'استاد راهنما';
$teacher_name_desc = 'این فیلد الزامی می باشد';
$keywords = 'کلمات کلیدی';
$keywords_desc = '(میتوانید کلمات مختلف را با - از هم جدا نمایید، حداکثر پنج کلمه)';
$field = 'رشته';
$teacher_dropdown = '';
$sql = "select u.id,concat_ws(' ',u.fname,u.lname) as 'fullname' from user as u where type=2";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
$teacher_dropdown = dropdown($rows,'teacher','fullname','id',$opt['teacher']);
}

$edit = '';
if($opt['edit'] > 0){
$edit = '<input type="hidden" name="edit" value="'.$opt['edit'].'"/>';
}

if($opt['edit'] > 0 || !$error_duplicate_add_thesis){
echo '
<form name="add_thesis" method="post" action="'.BASE_PATH.'/thesis/?do=add&token='.$_SESSION['token'].'">
<input type="hidden" name="add_thesis" value="true"/>
'.$edit.'
<div class="'.$class.'">
<div class="title">'.$title.'</div>
<div class="input_title">&nbsp;'.$article_title.'&nbsp;</div>
<div class="input"><input type="text" name="title" value="'.$opt['title'].'" pattern=".{25,200}" title="Minimum value is 25 characters AND Maximum value is 80 characters" /></div>
<div class="input_desc">'.$article_title_desc.'</div>

<div class="input_title">&nbsp;'.$abstract.'&nbsp;</div>
<div class="input_multi"><textarea class="ckeditor" name="min_ckeditor">'.$opt['min_cheditor'].'</textarea></div>

<div class="input_title">&nbsp;'.$teacher_name.'&nbsp;</div>
<div class="input">'.$teacher_dropdown.'</div>
<div class="input_desc">'.$teacher_name_desc.'</div>

<div class="input_title">&nbsp;'.$enddate.'&nbsp;</div>
<div class="input"><input type="text" name="date" value="'.$opt['enddate'].'" /></div>
<div class="input_desc">'.$enddate_desc.'</div>

<div class="input_title">&nbsp;'.$keywords.'&nbsp;</div>
<div class="input"><input type="text" autocomplete="off" name="keywords" value="'.$opt['keywords'].'" pattern=".{10,60}" title="Minimum value is 10 characters AND Maximum value is 60 characters" />
<div class="keyword_typeahead"></div>
</div>
<div class="input_desc">'.$keywords_desc.'</div>
<center><div class="input"><input type="submit" class="perfect_btn" id="save_thesis_btn" value="'.$_LANGUAGE['save'][DEFAULT_LANGUAGE].'"/></div></center>
</div>
</form>
';
}else{
redirect(BASE_PATH.'/me',1);
}

}else{
$_SESSION['success_add_thesis'] = $_LANGUAGE['thesis_success_add'][DEFAULT_LANGUAGE];
redirect(BASE_PATH.'/me',1);
}
});



$app->getDO('edit',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
global $_LANGUAGE,$page_display_title;
$page_display_title = $_LANGUAGE['edit_thesis'][DEFAULT_LANGUAGE];
if(isset($_GET['thesis']) && intval($_GET['thesis'])){
$sql = "select * from thesis where id=:tid";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." and status=0 and uid=".$_SESSION['userId'];
}
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':tid',filter_var($_GET['thesis'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row =$stmt->fetch(PDO::FETCH_ASSOC);
$opt = array(
 'title' => '',
 'min_cheditor' => '',
 'keywords' => '',
 'teacher' => '',
 'enddate' => '',
 'edit' => $row['id']
);
//$_POST['add_thesis'] = true;



#SET OPTIONS ARRAY
$opt['title'] = $row['title'];
$opt['min_cheditor'] = $row['content'];
$opt['keywords'] = $row['keyword'];
$opt['teacher'] = $row['teacher'];
$opt['enddate'] = $row['enddate'];


#CALL ADD FUNCTION
app::run(app::$ROUTE_GET,array('do'=>'add'),array($opt));

}
}

});



$app->getDO('delete',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if(isset($_GET['thesis']) && intval($_GET['thesis'])){
$sql = "delete from thesis where id=:id";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." and status=0 and uid=".$_SESSION['userId'];
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':id',filter_var($_GET['thesis'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});



function keywordjs($pdo){
$sql = "select keyword from thesis";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$key = array();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$k    = explode('-',$row['keyword']);
$key = array_merge($key,$k);
$key = array_unique($key);
$key = array_filter($key);
}
return json_encode($key,true);
}else{
return '[]';
}
}



$app->getDO('accept',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use ($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['thesis']) && !empty($_GET['thesis']) && intval($_GET['thesis'])){
$sql = "update thesis set status=1 where id=:t";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':t',$_GET['thesis'],PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});


$app->getDO('wait',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use ($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['thesis']) && !empty($_GET['thesis']) && intval($_GET['thesis'])){
$sql = "update thesis set status=0 where id=:t";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':t',filter_var($_GET['thesis'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});


$app->getDO('closed',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use ($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['thesis']) && !empty($_GET['thesis']) && intval($_GET['thesis'])){
$sql = "update thesis set status=2 where id=:t";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':t',filter_var($_GET['thesis'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});


$app->getDO('grade',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use ($pdo){
global $page_display_title;
$page_display_title = "درج نمره پایان نامه";
if($_SESSION['permission'] == 'admin' && isset($_GET['thesis']) && !empty($_GET['thesis']) && intval($_GET['thesis']) && is_numeric($_GET['thesis'])){
if(isset($_POST['grade']) && is_numeric($_POST['grade'])){
$sql  = "update thesis set grade=:g where id=:t";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':g',filter_var($_POST['grade'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->bindvalue(':t',filter_var($_GET['thesis'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
#=============================
$page = '';
$sql = "select count(*)+1 from thesis where id > :i";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':i',$_GET['thesis'],PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row_number = $stmt->fetchColumn(0);
$page = '&page='.pagination::page($row_number,10);
}
#=============================
redirect(BASE_PATH.'/event/?do=thesis&token='.$_SESSION['token'].$page.'#'.trim($_GET['thesis']),1);
}else{
$msg = '';
if(isset($_POST['grade'])){
$msg = '<br/><b>'.'دوباره سعی کنید و از صحت اطلاعات ورودی اطمینان حاصل نمایید'.'</b><br/>';
}
echo '
<form method="post" class="addgrade">
<center>
'.$msg.'
<input type="text" name="grade" value="" placeholder="ورود نمره" />
<br/><br/>
<input type="submit" value="ذخیره" />
</center>
</form>
';
}
}else{
redirect(BACK_ADDRESS,1);
}
});


$app->defaultRoute(['do'=>'view']);

app::$errorHandler = function(){
redirect(BASE_PATH.'/index.php',1);
};

$app->run();




?>