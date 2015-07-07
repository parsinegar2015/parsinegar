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
 .entry .content .fa_author{ float: right; margin-top: 15px; margin-right: 20px; min-width: 350px; height: 30px; margin-left: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-right: 1px solid #666; color: #000; text-align: right; direction: rtl; }
 .entry .content .fa_date{ float: right; margin-top: 3px; margin-right: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-right: 1px solid red; color: #CCC; text-align: right; }
 .entry .content .fa_major{ float: right; margin-top: 3px; margin-right: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-right: 1px solid #283199; color: #CCC; text-align: right; direction: rtl; }
 .entry .content .fa_more{ float: right; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-right: 5%; text-align: right; }
 .entry .content .fa_more a.keyword_link:link{ float: right; text-decoration: none; padding: 5px; background: #66FFFF; margin-right: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; color: blue; }
 .entry .content .fa_more a.keyword_link:hover{ background: #CCC; }
 .entry .content .fa_file{ float: right; width: 90%; margin-right: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; margin-bottom: 10px; }
 .entry .content .fa_file div{ float: left; width: 500px; height: 100px; text-align: right; direction: rtl; }
 .entry .content .fa_file div.logo{ width: 98px; }
 .print_fa{ float: left; width: 100%; margin-top: 20px; border: 1px double #ccc; background: #fcfcfc; text-align: right; 100px; }
 
 .entry .title{ width: 100%; height: 40px; background: #FFFFFF; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #DDDDDD; float: left; }
 .entry .content .en_author{ float: left; margin-top: 15px; margin-left: 20px; min-width: 350px; height: 30px; margin-right: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-left: 1px solid #666; color: #000; text-align: left; direction: ltr; }
 .entry .content .en_date{ float: left; margin-top: 3px; margin-left: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-left: 1px solid red; color: #CCC; text-align: left; }
 .entry .content .en_major{ float: left; margin-top: 3px; margin-left: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-left: 1px solid #283199; color: #CCC; text-align: left; direction: rtl; }
 .entry .content .more{ float: left; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-left: 5%; text-align: left; }
 .entry .content .more a.keyword_link:link{ float: left; text-decoration: none; padding: 5px; background: #66FFFF; margin-left: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; color: blue; }
 .entry .content .more a.keyword_link:hover{ background: #CCC; }
 .entry .content .en_file{ float: left; width: 90%; margin-left: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; }
 .entry .content .en_file div{ float: right; width: 500px; height: 100px; text-align: left; }
 .entry .content .en_file div.logo{ width: 98px; }
 .print_en{ float: left; width: 100%; margin-top: 20px; border: 1px double #ccc; background: #fcfcfc; text-align: left; 100px; }
 
 form[name=add_article] input,form[name=add_article] select{ outline: none; }
 .fa_article_add{ float: left; width: 800px; margin-left: 50px; margin-top: 20px; }
 .fa_article_add .title{ float: right; width: 100%; height: 50px; font-family: tahoma; font-size: 24px; font-weight: bold; color: #000; text-align: right; }
 .fa_article_add .input_title{ float: right; width: 100%; height: 30px; border-right: 3px solid #ccc; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; text-align: right; margin-top: 10px; }
 .fa_article_add .input{ float: right; width: 100%; height: 30px; margin-top: 10px; margin-bottom: 10px; }
 .fa_article_add .input input[type=text]{ float: right; width: 99%; height: 28px; border: 1px solid #ccc; border-radius: 5px; background: #fff; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; direction: rtl; }
 .fa_article_add .input select{ float: right; width: 99%; height: 28px; direction: rtl; }
 .fa_article_add .input_desc{ float: right; width: 100%; height: 20px; font-family: tahoma; font-size: 12px; color: #ccc; text-align: right; direction: rtl; }
 .fa_article_add .input_multi{ float: right; width: 100%; min-height: 300px; margin-top: 10px; }
 .fa_article_add .input_multi textarea{ float: right; }
 .fa_article_add .selected_items_box{ float: right; width: 99%; min-height: 100px; border: 1px solid; margin-top: 10px; margin-bottom: 10px; }
 .fa_article_add .input .keyword_typeahead{ position: absolute; width: 788px; margin-top: 35px; height: 150px; background: #eee; border: 1px solid #ccc; border-radius: 5px; padding: 5px; text-align: right; display: none; }
 .fa_article_add .input .keyword_typeahead .k_item{ float: right; min-width: 110px; padding: 5px; heigh: 30px; margin-right: 10px; margin-top: 10px; background: #ddd; cursor: pointer; }
 .fa_article_add .input .keyword_typeahead .k_item:hover{ background: #ccc; }
 
 .en_article_add{ float: left; width: 800px; margin-left: 50px; margin-top: 20px; }
 .en_article_add .title{ float: left; width: 100%; height: 50px; font-family: tahoma; font-size: 24px; font-weight: bold; color: #000; text-align: left; }
 .en_article_add .input_title{ float: left; width: 100%; height: 30px; border-left: 3px solid #ccc; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; text-align: left; margin-top: 10px; }
 .en_article_add .input{ float: left; width: 100%; height: 30px; margin-top: 10px; margin-bottom: 10px; }
 .en_article_add .input input[type=text]{ float: left; width: 99%; height: 28px; border: 1px solid #ccc; border-radius: 5px; background: #fff; font-family: tahoma; font-size: 17px; font-weight: bold; color: #000; }
 .en_article_add .input select{ float: left; width: 99%; height: 28px; }
 .en_article_add .input_desc{ float: left; width: 100%; height: 20px; font-family: tahoma; font-size: 12px; color: #ccc; text-align: left; }
 .en_article_add .input_multi{ float: left; width: 100%; min-height: 300px; margin-top: 10px; }
 .en_article_add .input_multi textarea{ float: left; text-align: left; }
 .en_article_add .selected_items_box{ float: left; width: 99%; min-height: 100px; border: 1px solid; margin-top: 10px; margin-bottom: 10px; }
 .en_article_add .input .keyword_typeahead{ position: absolute; width: 783px; margin-top: 35px; height: 150px; background: #eee; border: 1px solid #ccc; border-radius: 5px; padding: 5px; text-align: left; display: none; }
 .en_article_add .input .keyword_typeahead .k_item{ float: left; min-width: 110px; padding: 5px; heigh: 30px; margin-left: 10px; margin-top: 10px; background: #ddd; cursor: pointer; border-radius: 5px; }
 .en_article_add .input .keyword_typeahead .k_item:hover{ background: #ccc; }
 
 .field-item{ min-width: 100px; margin: 5px; padding: 5px; float: right; border-radius: 5px; min-height: 20px; background: #CCC; cursor: pointer; }
 .field-item:hover{ background: #ddd; }
 .field-item:active{ background: #888; }
 
 
 ';

 
if((isset($_GET['do'],$_GET['type'],$_GET['lang']) && $_GET['do'] == 'add') || (isset($_GET['do']) && $_GET['do'] == 'edit')){
$js_script = '
$save = false;
$("#save_article_btn").click(function(){
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
$("form[name=add_article]").submit(function(event){
$("input:not([type=submit])").each(function(){
if(!$(this).val().match(/^[\s\t\r\n]*\S+/ig)){
self = $(this);
name = self.attr("name");
if(name != "url" && name != "title2" && name != "more_authors"){
self.css("border","1px solid red");
event.preventDefault();
}

}
if(!$("input.majors_item").length){
$("select[name=field]").css("border","1px solid red");
event.preventDefault();
}
});
if(!$("textarea[name=min_ckeditor]").val().match(/^[\s\t\r\n]*\S+/ig)){
event.preventDefault();
}

if($("select[name=file]").find(":selected").text() == "Choose here"){
$("select[name=file]").css("border","1px solid red");
event.preventDefault();
}
});

$("select[name=file]").change(function(){
if($(this).find(":selected").text() != "Choose hare"){
$(this).css("border","");
}else{
$(this).css("border","1px solid red");
}
});

$("form[name=add_article] input[type=text]").live("blur",function(){
	self = $(this);
	name = self.attr("name");
	if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){
		if(name != "url" && name != "title2" && name != "more_authors"){
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
	});
$("form[name=add_article] input[type=text]").live("keyup change click",function(){
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
	});

	
$("select[name=field]").change(function(){
$(this).css("border","");
$f = $(this).val();
$txt = $("select[name=field]").find(":selected").text();
if(!$(".selected_items_box").find("input[value="+$f+"]").attr("name")){
$(".selected_items_box").append("<input type=\"hidden\" name=\"majors[]\" class=\"majors_item\" value=\""+$f+"\"/><div class=\"field-item\" name=\""+$f+"\">"+$txt+"</div>");
}
});

$(".field-item").live("click",function(e){
$v = $(this).attr("name");
$(".selected_items_box input[value="+$v+"]").remove();
$(this).remove();
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

if($js->file('article')){
if(!$js->comp('article',\parsinegar\js::min($js_data))){
$js->file('article',\parsinegar\js::min($js_data));
}
}else{
$js->file('article',\parsinegar\js::min($js_data));
}




function in_multiarray($elem,$array,$field,$retkey)
{
    $top = sizeof($array) - 1;
    $bottom = 0;
    while($bottom <= $top)
    {
        if($array[$bottom][$field] == $elem)
            return $array[$bottom][$retkey];
        else 
            if(is_array($array[$bottom][$field]))
                if($ret = in_multiarray($elem, ($array[$bottom][$field]),$field,$retkey))
                    return $ret;

        $bottom++;
    }        
    return false;
}





$app->getDO('view',['auth_login'=>true],function() use($pdo){
global $paginate,$item_pre_page,$btn_pre_page,$_LANGUAGE,$page_display_title; 
$page_display_title = $_LANGUAGE['article_list'][DEFAULT_LANGUAGE];
$title = '';
$t_arr = '';
$t = '';
$pageLink = '';
$more_view = false;
$type = false;
if(DEFAULT_LANGUAGE == 'fa'){
$more = '<div class="fa_more">{content}</div>';
$print = '<div class="print_fa">{link}&nbsp;<img src="'.BASE_PATH.'/assets/img/iprint.png"/></div>';
$tpl = '
<div class="entry">
<div class="fa_title">&nbsp;&nbsp;<a href="'.BASE_PATH.'/article/{link}" class="article_link">{title}</a></div>
<div class="content">
<div class="fa_author">نویسنده: {fullname}</div>
<div class="fa_date">تاریخ: {date}</div>
<div class="fa_major">رشته مرتبط: {major}</div>
{more}
<div class="fa_file">
<div>
{file_title}
<br/>
'.$_LANGUAGE['dl_count_search'][DEFAULT_LANGUAGE].'&nbsp;{quantity}
</div>
<div class="logo">
<center>
<img src="'.BASE_PATH.'/assets/img/pdf.png"/>
</center>
</div>
</div>
</div>
</div>
{print}
';
}else if(DEFAULT_LANGUAGE == 'en'){
$more = '<div class="more">{content}</div>';
$print = '<div class="print_en"><img src="'.BASE_PATH.'/assets/img/iprint.png"/>&nbsp;{link}</div>';
$tpl = '
<div class="entry">
<div class="title">&nbsp;&nbsp;<a href="'.BASE_PATH.'/article/{link}" class="article_link">{title}</a></div>
<div class="content">
<div class="en_author">Author: {fullname}</div>
<div class="en_date">Date: {date}</div>
<div class="en_major">Major: {major}</div>
{more}
<div class="en_file">
<div>
{file_title}
<br/>
'.$_LANGUAGE['dl_count_search'][DEFAULT_LANGUAGE].'&nbsp;{quantity}
</div>
<div class="logo">
<center>
<img src="'.BASE_PATH.'/assets/img/pdf.png"/>
</center>
</div>
</div>
</div>
</div>
{print}
';
}
#get article
$sql = "select a.*,f.file as 'file_link',f.title as 'file_name',f.quantity as 'qty',concat_ws(' ',u.fname,u.lname) as 'fullname' from article as a
inner join `user` as u
on u.id = a.uid
inner join `files` as f
on f.id = a.file";
if(isset($_GET['type']) && in_array($_GET['type'],array('journal','conference'))){
$type = true;
$sql = $sql." where a.type='".filter_var(trim($_GET['type']),FILTER_SANITIZE_STRING)."'";
}
if(isset($_GET['title']) && !empty($_GET['title'])){
$title = trim(urldecode(filter_var(htmlentities(htmlspecialchars($_GET['title'],ENT_QUOTES),ENT_QUOTES),FILTER_SANITIZE_STRING)));
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
$where = " where ";
if($type){
$where = " and ";
}
if(strstr($title,'/')){
$t_arr = explode('/',$title);
$sql = $sql.$where."a.`id`=:i";
}else{
$sql = $sql.$where."(a.`title`=:t1 or a.`title_en`=:t2)";
}
}
}else{
$title = '';
}
}else{
$title = '';
}
if($_SESSION['permission'] != 'admin'){
if(empty($title) && !$type){
$sql = $sql." where a.`status`=1";
}else{
$sql = $sql." and (a.`status`=1 or a.`uid`=".$_SESSION['userId'].")";
}
}

#======================
if(empty($title)){
$sql = $sql.' order by a.id DESC ';
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
$stmt->bindvalue(":t2",$title,PDO::PARAM_STR);
}
}
$stmt->execute();
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($rows);
$items = array();
foreach($rows as $row){
$sql = "select f.title as 'field_title' from article_field as af
join field as f
on af.fId = f.id
where af.aId=".$row['id'];

$stmt = $pdo->prepare($sql);
$stmt->execute();
if($stmt->rowCount()){
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
$ftitle = array();
foreach($fields as $f){
$ftitle[] = $f['field_title'];
}
$field_title = implode(' - ',$ftitle);
$ar_title = $row['title'];
$ar_content = $row['content'];
if($row['lang'] == 'en'){
$ar_title = $row['title_en'];
$ar_content = $row['content_en'];
}
if($row['status'] == 2){
$ar_title = '<s>'.$ar_title.'</s>';
}
$link  = $row['id'].'/'.str_replace(' ','-',$ar_title).'.html';
$atpl = $tpl;
$atpl = str_replace("{title}",$ar_title,$atpl);
$atpl = str_replace("{link}",$link,$atpl);
$atpl = str_replace("{fullname}",$row['fullname'],$atpl);
$atpl = str_replace("{date}",$row['date'],$atpl);
$atpl = str_replace("{major}",$field_title,$atpl);
if(empty($title)){
$atpl = str_replace("{file_title}",$row['file_name'],$atpl);
}else{
$file_link_dl = '<a href="'.BASE_PATH.'/download.php?file='.$row['file_link'].'">'.$row['file_name'].'</a>';
$atpl = str_replace("{file_title}",$file_link_dl,$atpl);
}
$atpl = str_replace("{quantity}",$row['qty'],$atpl);

#===============================
if($more_view){
$page_display_title = $ar_title;
$keywords = $row['keyword'].'-';
$keywords = explode('-',$keywords);
$keywords = array_filter($keywords);
$key_words = array();
foreach($keywords as $kw){
$key_words[] = '<a href="'.BASE_PATH.'/search/?q='.$kw.'&type=keywords" class="keyword_link">'.$kw.'</a>';
}
$more = str_replace("{content}",$ar_content."<br/><br/>{publication}<br/>\n".implode("\n",$key_words),$more);
if($row['type'] == 'journal'){
$more = str_replace("{publication}",$row['journal_name']."<br/>\n".$row['link']."<br/>",$more);
}else{
$more = str_replace("{publication}",'',$more);
}
$atpl = str_replace("{more}",$more,$atpl);
#------------------------------
if(DEFAULT_LANGUAGE == 'fa'){
$print_link = '<a href="javascript:void(0);" onClick="window.open(\''.BASE_PATH.'/print.php?type=article&print='.$row['id'].'\',\'print\',\'resizable=no,\');">پرینت</a>';
}else{
$print_link = '<a href="javascript:void(0);" onClick="window.open(\''.BASE_PATH.'/print.php?type=article&print='.$row['id'].'\',\'print\',\'resizable=no,\');">Print</a>';
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
}

#======================
if(empty($title)){
$sql = "select count(*) from article";
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
'url' => '/article/',
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
echo '<center><b>'.$_LANGUAGE['no_data_display'][DEFAULT_LANGUAGE]."<b><br/></center>";
}
});



$app->getDO('add',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function($options=false) use($pdo){
global $_LANGUAGE,$today,$js,$page_display_title;
$page_display_title = $_LANGUAGE['add_article'][DEFAULT_LANGUAGE];
$add_article = 'null';
$journal = '';
$url = '';
$more_authors = '';
$title2 = '';

#=========================
$opt = array(
 'title' => '',
 'title2' => '',
 'min_ckeditor' => '',
 'keywords' => '',
 'file' => '',
 'majors' => '',
 'journal' => '',
 'link' => '',
 'more_authors' => '',
 'url' => '',
 'edit' => 0,
 'uId' => ''
);
if(is_array($options)){
$opt = array_merge($opt,$options);
}
#=========================
$sql = "select count(*) from files where uid=".$_SESSION['userId'];
$stmt = $pdo->query($sql);
$file_count = $stmt->fetchColumn(0);
if($file_count > 0 || $_SESSION['permission'] == 'admin'){
if(isset($_POST['add_article']) && !empty($_POST['add_article'])){
$add_article = 'nope';
$title = '';
$content = '';
$keywords = '';
$file = '';
$field = '';
if(isset($_POST['title'],$_POST['min_ckeditor'],$_POST['keywords'],$_POST['file'],$_POST['majors'],$_POST['lang']) && in_array(trim($_POST['lang']),array('fa','en'))){
if(isset($_GET['type']) && in_array($_GET['type'],array('conference','journal'))){
$lang = filter_var(trim($_GET['lang']),FILTER_SANITIZE_STRING);
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
$content = $_POST['min_ckeditor'];
$keywords = filter_var($_POST['keywords'],FILTER_SANITIZE_STRING);
$file = intval($_POST['file']);
$field = $_POST['majors'];
$type = filter_var(trim($_GET['type']),FILTER_SANITIZE_STRING);
if($type == 'journal'){
if(isset($_POST['journal']) && !empty($_POST['journal'])){
$journal = filter_var($_POST['journal'],FILTER_SANITIZE_STRING);
}
if(isset($_POST['url']) && !empty($_POST['url']) && filter_var($_POST['url'],FILTER_VALIDATE_URL)){
$url = filter_var($_POST['url'],FILTER_SANITIZE_URL);
}
}
if(isset($_POST['more_authors']) && !empty($_POST['more_authors'])){
$more_authors = filter_var(trim($_POST['more_authors']),FILTER_SANITIZE_STRING);
}
if(isset($_POST['title2']) && !empty($_POST['title2'])){
$title2 = filter_var(trim($_POST['title2']),FILTER_SANITIZE_STRING);
}

#=======Check Title=======#
$title_error = true;
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
//$title = preg_replace('/[\@\^\!\#\&\*\(\)\+\=\-\'\$_]/', '', $title);
$title = str_replace('-',' ',$title);
$title = preg_replace('/\s+/',' ',$title);
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
if(preg_match('/[\w\d\x{600}-\x{6FF}\s\-\=\%\^\(\)\.\&\#\!\?\,\،\n\r\t]+$/u',$c)){
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


#=======Check File=======#
$file_error = true;
if(intval($file) && is_numeric($file)){
$file_error = false;
}
#=======Check File=======#


#=======Check Majors=======#
$majors_error = true;
if(is_array($field) && count($field)){
$majors = array();
foreach($field as $m){
if(intval($m) && is_numeric($m)){
$majors[] = intval($m);
}
}
if(!empty($majors)){
$majors_error = false;
}
}
#=======Check Majors=======#


#=======Check journal=======#
if($type == 'journal'){
$journal_error = true;
if(!empty($journal)){
$j = preg_replace('/\s*/','',$journal);
$j = preg_replace('/\/*/','',$j);
if(!empty($j)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.\(\)]+$/u',$journal)){
$j = str_replace('-',' ',$journal);
$j = preg_replace('/\s*/','',$j);
if(!empty($j)){
$journal_error = false;
}
}
}
}
}
#=======Check journal=======#


#=======Check More_Authors=======#
if(!empty($more_authors)){
$more_authors_error = true;
$ma = preg_replace('/\s*/','',$more_authors);
$ma = preg_replace('/\/*/','',$ma);
if(!empty($ma)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.\,]+$/u',$more_authors)){
$ma = str_replace('-',' ',$more_authors);
$ma = preg_replace('/\s*/','',$ma);
if(!empty($ma)){
$more_authors_error = false;
}
}
}
}
#=======Check More_Authors=======#


#=======Check Title2=======#
if(!empty($title2)){
$title2_error = true;
$t2 = preg_replace('/\s*/','',$title2);
$t2 = preg_replace('/\/*/','',$t2);
if(!empty($t2)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-\.\(\)\،\,]+$/u',$title2)){
$t2 = str_replace('-',' ',$title2);
$t2 = preg_replace('/\s*/','',$t2);
if(!empty($t2)){
$title2_error = false;
}
}
}
}
#=======Check Title2=======#
//$trace_error = array( 'title_error' => $title_error, 'content_error' => $content_error, 'keywords_error' => $keywords_error, 'file_error' => $file_error, 'majors_error' => $majors_error);
if(!$title_error && !$content_error && !$keywords_error && !$file_error && !$majors_error && ($type != 'journal' || ($type == 'journal' && !$journal_error)) && (empty($more_authors) || !$more_authors_error) && (empty($title2) || !$title2_error)){
//$add_article = 'nope';

$title_col = 'title';
$title2_col = 'title_en';
$content_col = 'content';
$keywords_col = 'keyword';
if($lang == 'en'){
$title_col = 'title_en';
$title2_col = 'title';
$content_col = 'content_en';
$keywords_col = 'keyword_en';
}

#=Check Valid ID======================================
$invalid_id = true;
if(isset($_POST['edit'])){
if(intval($_POST['edit'])){
$sql = "select id from article where id=:edit";
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

$pdo->query("SELECT GET_LOCK('register-new-articl',-1)");
$pdo->beginTransaction();
if(!isset($_POST['edit'])){
$sql = "insert into article(uid,$title_col,$title2_col,$content_col,$keywords_col,file,date,type,status,lang,journal_name,link,more_authors) values (:u,:t,:t2,:c,:k,:f,:d,:typ,0,:l,:j,:lnk,:ma)";
}else{
#update
$sql = "update `article` set $title_col=:t,$title2_col=:t2,$content_col=:c,$keywords_col=:k,file=:f,date=:d,type=:typ,lang=:l,journal_name=:j,link=:lnk,more_authors=:ma where `id`=:edit";
}

if(!isset($_POST['edit']) || !$invalid_id){
$stmt = $pdo->prepare($sql);
if(!isset($_POST['edit'])){
$stmt->bindvalue(':u',$_SESSION['userId'],PDO::PARAM_INT);
}else{
$stmt->bindvalue(':edit',filter_var($_POST['edit'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
}
$stmt->bindvalue(':t',$title,PDO::PARAM_STR);
$stmt->bindvalue(':c',$content,PDO::PARAM_STR);
$stmt->bindvalue(':k',$keywords,PDO::PARAM_STR);
$stmt->bindvalue(':f',$file,PDO::PARAM_INT);
$stmt->bindvalue(':d',$today,PDO::PARAM_STR);
$stmt->bindvalue(':typ',$type,PDO::PARAM_STR);
$stmt->bindvalue(':l',$lang,PDO::PARAM_STR);
$stmt->bindvalue(':ma',$more_authors,PDO::PARAM_STR);
if($type == 'journal'){
$stmt->bindvalue(':j',$journal,PDO::PARAM_STR);
}else{
$stmt->bindvalue(':j',null,PDO::PARAM_NULL);
}
if(!empty($url)){
$stmt->bindvalue(':lnk',$url,PDO::PARAM_STR);
}else{
$stmt->bindvalue(':lnk',null,PDO::PARAM_STR);
}
if(empty($title2)){
$stmt->bindvalue(':t2',null,PDO::PARAM_NULL);
}else{
$stmt->bindvalue(':t2',$title2,PDO::PARAM_STR);
}
if($stmt->execute()){
_log('info_add','Article module successfully inserted a new record in the table article');
if(!isset($_POST['edit'])){
$stmt = $pdo->query("SELECT LAST_INSERT_ID()");
$last_id = $stmt->fetchColumn(0);
$sql = "insert into article_field(aId,fId) values ";
foreach($majors as $m){
$values[] = "($last_id,$m)";
}
$sql = $sql.implode(', ',$values);
$pdo->exec($sql);
}else{
$sql = "select fId from article_field where aId=:aid";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':aid',filter_var($_POST['edit'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$afields = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($afields as $af){
if(!in_array($af['fId'],$majors)){
$sql = "delete from article_field where aId=".filter_var($_POST['edit'],FILTER_SANITIZE_STRING)." and fId=".$af['fId'];
$pdo->exec($sql);
}
}
foreach($majors as $m){
if(!in_multiarray($m,$afields,'fId','fId')){
$sql = "insert into article_field(aId,fId) values (".filter_var($_POST['edit'],FILTER_SANITIZE_STRING).",$m)";
$pdo->exec($sql);
}
}
}
}
$add_article = 'ok';
}
}else{
_log('critical_edit','Invalid ID was used','id='.$_POST['edit']);
}
$pdo->commit();
$pdo->query("SELECT RELEASE_LOCK('register-new-articl')");
//if($add_article == 'ok'){

//}
}else{
_log('error_add','Avoid incorrect information');
}

}
}
}
if($add_article != 'ok'){
if(!isset($_GET['type']) || empty($_GET['type']) || !in_array($_GET['type'],array('conference','journal'))){
echo "<center>\n<br/><b>".$_LANGUAGE['choose_article_type'][DEFAULT_LANGUAGE]."</b><br/><br/>\n";
echo '
<a href="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'&type=conference">'.$_LANGUAGE['a_side_conference'][DEFAULT_LANGUAGE].'</a>
<a href="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'&type=journal">'.$_LANGUAGE['a_side_journal'][DEFAULT_LANGUAGE].'</a></center>
';
}else if(!isset($_GET['lang']) || empty($_GET['lang'])){
echo "<center>\n<br/><b>".$_LANGUAGE['choose_article_language'][DEFAULT_LANGUAGE]."</b><br/><br/>\n";
echo '
<a href="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'&type='.$_GET['type'].'&lang=en">English</a>
<a href="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'&type='.$_GET['type'].'&lang=fa">فارسی</a></center>
';
}else if(isset($_GET['type'],$_GET['lang']) && in_array($_GET['type'],array('conference','journal')) && in_array($_GET['lang'],array('fa','en'))){

if($add_article == 'nope'){
$opt['title'] = $title;
$opt['title2'] = $title2;
$opt['min_ckeditor'] = $content;
$opt['file'] = $file;
$opt['more_authors'] = $more_authors;
$opt['keywords'] = $keywords;
$opt['journal'] = $journal;
$opt['link'] = $url;
$opt['majors'] = '';
}
$file_dropdown = '';
$field_dropdown = '';
if($_SESSION['permission'] == 'admin'){
$sql = "select id,title from files where uId=".$opt['uId'];
}else{
$sql = "select id,title from files where uId=".$_SESSION['userId'];
}
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
$file_dropdown = dropdown($rows,'file','title','id',$opt['file']);
}
$sql = "select id,title from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
$field_dropdown = dropdown($rows,'field','title','id');
}
if($_GET['lang'] == 'fa'){
$class = 'fa_article_add';
$title = 'ثبت مقاله جدید';
$article_title = 'عنوان مقاله';
$article_title_desc = '(فقط می تواند شامل حروف و عدد و فاصله باشد)';
$abstract = 'چکیده مقاله';
$more_authors = 'سایر نویسندگان';
$more_authors_desc = '(درصورت گروهی بودن مقاله نام سایر نویسندگان را وارد نمایید)';
$keywords = 'کلمات کلیدی';
$keywords_desc = '(میتوانید کلمات مختلف را با - از هم جدا نمایید، حداکثر پنج کلمه)';
$article_file = 'فایل مقاله';
$article_file_desc = '(فایل مربوط به مقاله را که قبلا آپلود کردید را انتخاب نمایید)';
$field = 'رشته';
$field_desc = '(رشته های مربوط به مقاله خود را انتخاب نمایید)';
$advance = 'بخش تکمیلی';
$journal = 'نام نشریه';
$journal_desc = '(این فیلد الزامی می باشد، می تواند شامل حروف و عدد و فاصله باشد)';
$article_url = 'آدرس اینترنتی مقاله';
$article_url_desc = '(فیلد اختیاری می باشد، با http شروع می شود)';
$article_title2 = 'عنوان مقاله به زبان انگلیسی';
$article_title2_desc = '(فیلد اختیاری می باشد)';
$title2 = 'title2';
$lang = 'fa';
}else if($_GET['lang'] == 'en'){
$class = 'en_article_add';
$title = 'Register new article';
$article_title = '&nbsp;Title';
$article_title_desc = '(Use a mix of letters,numbers and separations)';
$abstract = '&nbsp;Abstract';
$more_authors = '&nbsp;Other authors';
$more_authors_desc = '(For group articles)';
$keywords = '&nbsp;Keywords';
$keywords_desc = '(Use dash for more than one , <b>Max five key</b>)'; //comma
$article_file = '&nbsp;Article file';
$article_file_desc = '(Choose article file from uploaded list)';
$field = '&nbsp;Majors';
$field_desc = '(Choose majors related to your article)'; //Choose related fields to your article
$advance = '&nbsp;Advanced';
$journal = '&nbsp;Publication';
$journal_desc = '(This field is required, Use a mix of letters,numbers and separations)';
$article_url = '&nbsp;Article url';
$article_url_desc = '(This field is optional)';
$article_title2 = '&nbsp;Title in Persian';
$article_title2_desc = '(This field is optional)';
$title2 = 'title2';
$lang = 'en';
}

$edit = '';
if($opt['edit'] > 0){
$edit = '<input type="hidden" name="edit" value="'.$opt['edit'].'"/>';
}

echo '
<form name="add_article" method="post" action="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'&type='.$_GET['type'].'&lang='.$_GET['lang'].'">
<input type="hidden" name="add_article" value="true"/>
'.$edit.'
<input type="hidden" name="lang" value="'.$lang.'"/>
<div class="'.$class.'">
<div class="title">'.$title.'</div>
<div class="input_title">'.$article_title.'&nbsp;</div>
<div class="input"><input type="text" name="title" value="'.$opt['title'].'" pattern=".{25,200}" title="Minimum value is 25 characters AND Maximum value is 80 characters" /></div>
<div class="input_desc">'.$article_title_desc.'</div>

<div class="input_title">'.$abstract.'&nbsp;</div>
<div class="input_multi"><textarea class="ckeditor" name="min_ckeditor">'.$opt['min_ckeditor'].'</textarea></div>

<div class="input_title">'.$more_authors.'&nbsp;</div>
<div class="input"><input type="text" name="more_authors" value="'.$opt['more_authors'].'" pattern=".{8,100}" title="Minimum value is 8 characters AND Maximum value is 100 characters" /></div>
<div class="input_desc">'.$more_authors_desc.'</div>

<div class="input_title">'.$keywords.'&nbsp;</div>
<div class="input"><input type="text" autocomplete="off" name="keywords" value="'.$opt['keywords'].'" pattern=".{10,60}" title="Minimum value is 10 characters AND Maximum value is 60 characters" />
<div class="keyword_typeahead"></div>
</div>
<div class="input_desc">'.$keywords_desc.'</div>

<div class="input_title">'.$article_file.'&nbsp;</div> 
<div class="input">'.$file_dropdown.'</div>
<div class="input_desc">'.$article_file_desc.'</div>

<div class="input_title">'.$field.'&nbsp;</div> 
<div class="input">'.$field_dropdown.'</div>
<div class="input_desc">'.$field_desc.'</div>
<div class="selected_items_box">'.$opt['majors'].'</div>

<div class="input_desc"></div>
<div class="input_desc"><b>'.$advance.'</b></div>
<div class="input_desc"></div>
';
if($_GET['type'] == 'journal'){
echo '
<div class="input_title">'.$journal.'&nbsp;</div>
<div class="input"><input type="text" name="journal" value="'.$opt['journal'].'" pattern=".{10,35}" title="Minimum value is 10 characters AND Maximum value is 35 characters"/></div>
<div class="input_desc">'.$journal_desc.'</div>

<div class="input_title">'.$article_url.'&nbsp;</div>
<div class="input"><input type="text" name="url" value="'.$opt['link'].'" /></div>
<div class="input_desc">'.$article_url_desc.'</div>
';
}
echo '<div class="input_title">'.$article_title2.'&nbsp;</div>
<div class="input"><input type="text" name="'.$title2.'" value="'.$opt['title2'].'" pattern=".{25,80}" title="Minimum value is 25 characters AND Maximum value is 80 characters" /></div>
<div class="input_desc">'.$article_title2_desc.'</div>

<center><div class="input"><input type="submit" class="perfect_btn" id="save_article_btn" value="'.$_LANGUAGE['save'][DEFAULT_LANGUAGE].'"/></div></center>
</div>
</form>
';

}
}else{
$_SESSION['success_add_article'] = $_LANGUAGE['article_success_add'][DEFAULT_LANGUAGE];
redirect(BASE_PATH.'/me',1);
}
}else{
echo '<center><br/><img src="'.BASE_PATH.'/assets/img/cloud.png" /><br/>'.$_LANGUAGE['empty_file_manager'][DEFAULT_LANGUAGE].'</center>';
}
});



$app->getDO('edit',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if(isset($_GET['article']) && intval($_GET['article']) && is_numeric($_GET['article'])){
$sql = "select * from article where id=:aid";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." and status=0 and uid=".$_SESSION['userId'];
}
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':aid',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row =$stmt->fetch(PDO::FETCH_ASSOC);
$opt = array(
 'title' => '',
 'title2' => '',
 'min_cheditor' => '',
 'keywords' => '',
 'file' => '',
 'majors' => '',
 'journal' => '',
 'link' => '',
 'more_authors' => '',
 'edit' => $row['id'],
 'uId' => $row['uid']
);
//$_POST['add_article'] = true;
$_GET['lang'] = $row['lang'];
$_GET['type'] = $row['type'];

$sql = "select id,title from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$fields =$stmt->fetchAll(PDO::FETCH_ASSOC);
}
$m = '<input type="hidden" name="majors[]" class="majors_item" value="{CODE}"/><div class="field-item" name="{CODE}">{NAME}</div>';
$majors = array();
//foreach($rows as $row){
$sql = "select fId from article_field where aId=".$row['id'];
$stmt = $pdo->query($sql);
$fields_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($fields_id as $fid){
foreach($fields as $f){
if($f['id'] == $fid['fId']){
$majors[] = array('code'=>$f['id'],'name'=>$f['title']);
 }
}
}
//}
$majors_html = array();
foreach($majors as $mj){
$mh = $m;
$mh = str_replace('{CODE}',$mj['code'],$mh);
$mh = str_replace('{NAME}',$mj['name'],$mh);
$majors_html[] = $mh;
}

#SET OPTIONS ARRAY
$opt['majors'] = implode("\n",$majors_html);
$opt['title'] = $row['title'];
$opt['title2'] = $row['title_en'];
$opt['min_ckeditor'] = $row['content'];
$opt['keywords'] = $row['keyword'];
$opt['journal'] = $row['journal_name'];
$opt['more_authors'] = $row['more_authors'];
$opt['file'] = $row['file'];
$opt['link'] = $row['link'];
if($row['lang'] == 'en'){
$opt['title'] = $row['title_en'];
$opt['title2'] = $row['title'];
$opt['min_ckeditor'] = $row['content_en'];
$opt['keywords'] = $row['keyword_en'];
}

#CALL ADD FUNCTION
app::run(app::$ROUTE_GET,array('do'=>'add'),array($opt));

}
}

});



$app->getDO('delete',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if(isset($_GET['article']) && intval($_GET['article'])){
$sql = "delete from article where id=:id";
if($_SESSION['permission'] != 'admin'){
$sql = $sql." and status=0 and uid=".$_SESSION['userId'];
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':id',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$affected_rows = $stmt->execute();
_log('info_delete',$affected_rows.' row(s) of records deleted','article='.$_GET['article']);
}
redirect(BACK_ADDRESS,1);
});



function keywordjs($pdo){
$sql = "select keyword,keyword_en from article";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$key = array();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$k    = explode('-',$row['keyword']);
$k_en = explode('-',$row['keyword_en']);
$key = array_merge($key,$k);
$key = array_merge($key,$k_en);
$key = array_unique($key);
$key = array_filter($key);
}
return json_encode($key,true);
}else{
return '[]';
}
}


$app->getDO('accept',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['article']) && !empty($_GET['article']) && intval($_GET['article'])){
$sql = "update article set status=1 where id=:art";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':art',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
if($stmt->execute()){
$sql = "select uid from article where id=:art";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':art',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
$uid = $stmt->fetchColumn(0);
$sql = "select email,concat_ws(' ',fname,lname) as 'fullname' from user where id=".$uid;
$stmt = $pdo->query($sql);
$user = $stmt->fetch(PDO::FETCH_BOTH);
$email = $user[0];
$fullname = $user[1];
if(!empty($email)){
#==================================
require 'phpmailer/PHPMailerAutoload.php';
$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'ssl://smtp.gmail.com';                  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '';        // SMTP username
$mail->Password = '';                  // SMTP password
$mail->SMTPSecure = 'ssl';                         // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; //465 587 26;                  // TCP port to connect to

$mail->From = 'parsinegar2015@gmail.com';
$mail->FromName = 'DO NOT REPLY - Parsinegar2015';
$mail->addAddress($email, $fullname);     // Add a recipient
//$mail->addBCC('parsinegar2015@gmail.com');

$mail->WordWrap = 50;
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Congroulation! Your paper has been Approved';
$mail->Body    = 'Hi!, '.$fullname.'<br/><b>Congratulation!</b> Your paper has been Approved.<br/><br/>This is an automatic email, please do not respond directly to this email.
<br/>
<hr/>
copyright (c) 2015 , all right reserved to Parsinegar co.
<br/>
سامانه هوشمند دانشجویی';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();
#==================================
 }
}
}
redirect(BACK_ADDRESS,1);
});


$app->getDO('wait',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['article']) && !empty($_GET['article']) && intval($_GET['article'])){
$sql = "update article set status=0 where id=:art";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':art',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});


$app->getDO('closed',['auth_login'=>true,'get_token'=>'auth_token',validRequest()=>true],function() use($pdo){
if($_SESSION['permission'] == 'admin' && isset($_GET['article']) && !empty($_GET['article']) && intval($_GET['article'])){
$sql = "update article set status=2 where id=:art";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':art',filter_var($_GET['article'],FILTER_SANITIZE_STRING),PDO::PARAM_INT);
$stmt->execute();
}
redirect(BACK_ADDRESS,1);
});





$app->defaultRoute(['do'=>'view']);

app::$errorHandler = function(){
redirect(BASE_PATH.'/index.php',1);
};

$app->run();





?>