<?php
#|------====[paginate]====------|#
//if(!class_exists('pagination')){
require_once 'lib'.DS.'pagination.class.php';
//global $item_pre_page;
$item_pre_page = 10;
$btn_pre_page = 10;
$paginate = new pagination();
//}
#|------====[paginate]====------|#


include 'config'.DS.'language.php';
//========================================================================================================================

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

$placeholder_align = (DEFAULT_LANGUAGE=='fa')? 'right' : 'left';
$css = '
#search_section{ width: 900px; float: left; min-height: 600px; margin-left: 50px; }
#head_search{ width: 900px; height: 110px; border-bottom: 1px solid #CCC; }
#head_search_text_box{ width: 750px; height: 100px; border-right: 1px solid #ccc; float: left; }
#head_search_logo{ width: 149px; height: 104px; float: left; background: url('.BASE_PATH.'/assets/img/research.png) center no-repeat; }
#head_search_text{ position: absolute; width: 650px; height: 7px; border-width: 0px 1px 1px 1px; border-style: solid; border-color: #ddd; margin-left: 70px; margin-top: 80px; }
#head_search_button{ position: absolute; width: 50px; height: 40px; background: url('.BASE_PATH.'/assets/img/search_btn.png) center no-repeat; margin-left: -360px;  margin-top: 50px; border: 0px; outline: none; cursor: pointer; }
#head_search_text input{ position: relative; width: 645px; height: 50px; border: 0px; background: none; margin-top: -43px; outline: none; font-size: 24px; top: -20px; }
#head_search_text:hover{ border-color: #ccc; }

#head_search_text input[type="text"]:-ms-input-placeholder {
    text-align: '.$placeholder_align.';
}
#head_search_text input[type="text"]::-webkit-input-placeholder {
    text-align: '.$placeholder_align.';
}
#head_search_text input::-moz-placeholder {
 text-align: '.$placeholder_align.';
}


.box_advance_search{ width: 900px; background:#FFF;
	 display: block; position: absolute;
 }
 .box_advance_search .advance{ width: 100%; float: left; height: 240px; display: none; background: #f1f1f1; }
 .box_advance_search .advance div{ width: 300px; height: 30px; float: right; direction: rtl; }
 .box_advance_search .btn{ width: 100%; float: left; height: 20px; display: block; padding: 0px; }
 .box_advance_search .btn input{ width: 200px; height: 20px; border: 0px; border-radius: 0px 0px 5px 5px; outline: none; cursor: pointer; }
 .box_advance_search .btn input:hover{ box-shadow: 0px 0px 10px #ccc; }
 .box_advance_search .btn input:active{ font-weight: bold; }
 
 .clear{ clear: both; }
 
 #article_result{ width: 900px; min-height: 400px; float: left; }
 #article_result .a_side{ width: 200px; min-height: 500px; border-right: 1px solid #ccc; float: left; border-sizing: border-box; }
 #article_result .a_result{ width: 699px; min-height: 500px; float: left; }
 .count{ width: 94%; height: 30px; float: left; margin-left: 3%; border-bottom: 1px solid #ccc; }
 #article_result .a_side .title{ width: 96%; height: 24px; margin-right: 4%; direction: rtl; text-align: right; background: url(); }
 
 .entry{ width: 100%; border-radius: 5px; border: 1px solid #DDDDDD; background: #F5F5F5; min-height: 200px; float: left; margin-top: 30px; margin-left: 5px; }
 .entry .fa_title{ width: 100%; height: 40px; background: #FFFFFF; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #DDDDDD; float: left; text-align: right; direction: rtl; }
 .entry .content{ width: 98%; min-height: 100px; margin-left: 1%; float: left; }
 .entry .content .fa_author{ float: right; margin-top: 15px; margin-right: 20px; min-width: 350px; height: 30px; clear: left; margin-left: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-right: 1px solid #666; color: #000; text-align: right; direction: rtl; }
 .entry .content .fa_date{ float: right; margin-top: 3px; margin-right: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-right: 1px solid red; color: #CCC; text-align: right; }
 .entry .content .fa_major{ float: right; margin-top: 3px; margin-right: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-right: 1px solid #283199; color: #CCC; text-align: right; direction: rtl; }
 .entry .content .fa_more{ float: right; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-right: 5%; }
 .entry .content .fa_file{ float: right; width: 90%; margin-right: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; margin-bottom: 10px; }
 .entry .content .fa_file div{ float: left; width: 500px; height: 100px; text-align: right; direction: rtl; }
 .entry .content .fa_file div.logo{ width: 98px; }
 
 .entry .title{ width: 100%; height: 40px; background: #FFFFFF; border-radius: 5px 5px 0px 0px; border-bottom: 1px solid #DDDDDD; float: left; }
 .entry .content .en_author{ float: left; margin-top: 15px; margin-left: 20px; min-width: 350px; height: 30px; margin-right: 400px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #CCC;*/ border-bottom: 1px solid #666; border-left: 1px solid #666; color: #000; text-align: left; direction: ltr; }
 .entry .content .en_date{ float: left; margin-top: 3px; margin-left: 20px; min-width: 400px; height: 25px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #333;*/ border-bottom: 1px solid red; border-left: 1px solid red; color: #CCC; text-align: left; }
 .entry .content .en_major{ float: left; margin-top: 3px; margin-left: 20px; min-width: 500px; height: 35px; padding: 5px; font-family: tahoma; font-size: 14px; font-weight: bold; /*background: #fbfbfb;*/ border-bottom: 1px solid #283199; border-left: 1px solid #283199; color: #CCC; text-align: left; direction: rtl; }
 .entry .content .more{ float: left; margin-top: 7px; margin-bottom: 7px; font-family: tahoma; font-size: 14px; font-weight: bold; box-shadow: 0px 0px 5px #DDDDDD; min-height: 200px; width: 90%; margin-left: 5%; }
 .entry .content .en_file{ float: left; width: 90%; margin-left: 5%; height: 100px; border: 1px solid #DDDDDD; border-bottom: 2px solid blue; }
 .entry .content .en_file div{ float: right; width: 500px; height: 100px; text-align: left; }
 .entry .content .en_file div.logo{ width: 98px; }
';

$js_data = '
define([],function(){
$(function(){
$("#show_advance").click(function(){
$(".box_advance_search .advance").slideToggle("slow");
});
$("form[name=sForm]").submit(function(event){
if(!$("#q").val().match(/^[\s\t\r\n]*\S+/ig)){
event.preventDefault();
}
});
});
});
';		  


include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('search')){
if(!$js->comp('search',\parsinegar\js::min($js_data))){
$js->file('search',\parsinegar\js::min($js_data));
}
}else{
$js->file('search',\parsinegar\js::min($js_data));
}


		  
function summarize($str, $limit=600, $offset=100, $endlineChars=array('.','!','?',"\n",')',';',',','؟','،')) {  
    if(strlen($str)<=$limit)  
        return $str;  
      
    for($i=$limit; $i>$limit-$offset; $i--) {  
        if(in_array($str{$i}, $endlineChars)) {  
            $length = $i;  
            break;  
        }  
        if(!isset($spaceLength) && $str{$i}==' ')  
            $spaceLength = $i;  
    }  
    if(isset($length))  
        return substr($str, 0, $length+1);  
      
    for($i=$limit; $i<$limit+$offset; $i++) {  
        if(in_array($str{$i}, $endlineChars)) {  
            $length = $i;  
            break;  
        }  
        if(!isset($spaceLength) && $str{$i}==' ')  
            $spaceLength = $i;  
    }  
    if(isset($length))  
        return substr($str, 0, $length+1);  
  
    if(isset($spaceLength))  
        return substr($str, 0, $spaceLength);  
  
    return substr($str, 0, $limit+1);  
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

global $search_params;
$search_params = array();
$p = 1;
$title_lang = "fa";
$q = '';
function tpl_article($pdo,$data,$count,$ret_array=false){
global $title_lang,$_LANGUAGE;
$field = array();
$items = array();
$tpl = '
<div id="article_result">
<div class="a_side">
<div class="title"><b>'.$_LANGUAGE['a_side_type'][DEFAULT_LANGUAGE].'</b></div><br/>
<label>'.$_LANGUAGE['a_side_conference'][DEFAULT_LANGUAGE].'&nbsp;<input type="radio" name="type" value="conference"/></label><br/>
<label>'.$_LANGUAGE['a_side_journal'][DEFAULT_LANGUAGE].'&nbsp;<input type="radio" name="type" value="journal"/></label>
<div class="title"><b>'.$_LANGUAGE['a_side_fields'][DEFAULT_LANGUAGE].'</b></div><br/>
{fields}
<div class="title"><b>'.$_LANGUAGE['a_side_author'][DEFAULT_LANGUAGE].'</b></div><br/>
<input type="text" name="author" value="" />
</div>
<div class="a_result"><br/>
<div class="count">
<b>'.$_LANGUAGE['article_result_count'][DEFAULT_LANGUAGE].'</b>&nbsp;'.$count.'
</div>
{search}
</div>
</div>
';

if(DEFAULT_LANGUAGE == 'fa'){
$search_tpl = '
<div class="entry">
<div class="fa_title">&nbsp;&nbsp;<a href="'.BASE_PATH.'/article/{link}" class="article_link">{title}</a></div>
<div class="content">
<div class="fa_author">نویسنده: {fullname}</div>
<div class="fa_date">تاریخ: {date}</div>
<div class="fa_major">رشته مرتبط: {major}</div>
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
';
}else if(DEFAULT_LANGUAGE == 'en'){
$search_tpl = '
<div class="entry">
<div class="title">&nbsp;&nbsp;<a href="'.BASE_PATH.'/article/{link}" class="article_link">{title}</a></div>
<div class="content">
<div class="en_author">Author: {fullname}</div>
<div class="en_date">Date: {date}</div>
<div class="en_major">Major: {major}</div>
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
';
}

$sql = "select id,title from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($fields as $f){
$field[] = '<label>'.$f['title'].'&nbsp;<input type="checkbox" name="field[]" value="'.$f['id'].'"/></label>';
}
$tpl = str_replace("{fields}",implode("<br/>\n",$field),$tpl);
}
foreach($data as $row){
if($row['article_fullname'] == null){
continue;
}
$title = $row['article_title'];
if($title_lang == 'en' && $row['article_title_en'] != null){
$title = $row['article_title_en'];
}
$sql  = "select title,quantity from files where id=".$row['article_file'];
$stmt = $pdo->query($sql);
$file = $stmt->fetch(PDO::FETCH_ASSOC);
#======================================
$sql  = "select fId from article_field where aId=".$row['article_id'];
$stmt = $pdo->query($sql);
$fields_id = $stmt->fetchAll(PDO::FETCH_ASSOC);
$major = array();
foreach($fields_id as $fid){
if($ftitle = in_multiarray($fid['fId'],$fields,'id','title')){
$major[] = $ftitle;
}
}
if(!empty($major)){
$major = implode('-',$major);
}else{
$major = '';
}
$link  = $row['article_id'].'/'.str_replace(' ','-',$title).'.html';
$stpl = $search_tpl;
$stpl = str_replace("{title}",$title,$stpl);
$stpl = str_replace("{link}",$link,$stpl);
$stpl = str_replace("{fullname}",$row['article_fullname'],$stpl);
$stpl = str_replace("{date}",$row['article_date'],$stpl);
$stpl = str_replace("{major}",$major,$stpl);
$stpl = str_replace("{file_title}",$file['title'],$stpl);
$stpl = str_replace("{quantity}",$file['quantity'],$stpl);
$items[] = $stpl;
}
if(!$ret_array){
$tpl = str_replace("{search}",implode("\n",$items),$tpl);
return $tpl;
}else{
return $items;
}
}


function tpl_thesis($pdo,$data,$count,$ret_array=false){
global $_LANGUAGE;
$field = array();
$items = array();
$tpl = '
<div id="article_result">
<div class="a_side">
<div class="title"><b>'.$_LANGUAGE['a_side_fields'][DEFAULT_LANGUAGE].'</b></div><br/>
{fields}
<div class="title"><b>'.$_LANGUAGE['a_side_author'][DEFAULT_LANGUAGE].'</b></div><br/>
<input type="text" name="author" value="" />
</div>
<div class="a_result"><br/>
<div class="count">
<b>'.$_LANGUAGE['thesis_result_count'][DEFAULT_LANGUAGE].'</b>&nbsp;'.$count.'
</div>
{search}
</div>
</div>
';

if(DEFAULT_LANGUAGE == 'fa'){
$search_tpl = '
<div class="entry">
<div class="fa_title"><a href="'.BASE_PATH.'/thesis/{link}" class="thesis_link">{title}</a></div>
<div class="content">
<div class="fa_author">نویسنده: {fullname}</div>
<div class="fa_date">تاریخ: {date}</div>
<div class="fa_major">رشته مرتبط: {major}</div>
</div>
</div>
';
}else if(DEFAULT_LANGUAGE == 'en'){
$search_tpl = '
<div class="entry">
<div class="title"><a href="'.BASE_PATH.'/thesis/{link}" class="thesis_link">{title}</a></div>
<div class="content">
<div class="en_author">Author: {fullname}</div>
<div class="en_date">Date: {date}</div>
<div class="en_major">Major: {major}</div>
</div>
</div>
';
}

$sql = "select id,title from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$fields = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($fields as $f){
$field[] = '<label>'.$f['title'].'&nbsp;<input type="radio" name="field" value="'.$f['id'].'"/></label>';
}
$tpl = str_replace("{fields}",implode("\n",$field),$tpl);
}
foreach($data as $row){
if($row['thesis_title'] == null){
continue;
}
$major= in_multiarray($row['thesis_fId'],$fields,'id','title');
$title = $row['thesis_title'];
$link  = $row['thesis_id'].'/'.str_replace(' ','-',$title).'.html';
$stpl = $search_tpl;
$stpl = str_replace("{title}",$row['thesis_title'],$stpl);
$stpl = str_replace("{link}",$link,$stpl);
$stpl = str_replace("{fullname}",$row['thesis_fullname'],$stpl);
$stpl = str_replace("{date}",$row['thesis_date'],$stpl);
$stpl = str_replace("{major}",$major,$stpl);
$items[] = $stpl;
}
if(!$ret_array){
$tpl = str_replace("{search}",implode("\n",$items),$tpl);
return $tpl;
}else{
return $items;
}
}


function tpl_search($pdo,$data,$count){
global $_LANGUAGE;
$tpl = '
<div id="article_result">
<div class="a_side">

</div>
<div class="a_result"><br/>
<div class="count">
<b>'.$_LANGUAGE['search_result_count'][DEFAULT_LANGUAGE].'</b>&nbsp;'.$count.'
</div>
{search}
</div>
</div>
';

$article = tpl_article($pdo,$data,$count,true);
$thesis  = tpl_thesis($pdo,$data,$count,true);

$search = implode("\n",$article);
$search = $search.implode("\n",$thesis);

$tpl = str_replace('{search}',$search,$tpl);

return $tpl;
}
function cover($html,$paginate){
global $_LANGUAGE;

$tpl = '
<center>
<div id="search_section">
<form method="post" action="" name="sForm" onSubmit="document.sForm.action=\'?q=\'+document.getElementById(\'q\').value;">
<div id="head_search">
<div id="head_search_text_box">

<!--<div id="head_search_border">-->
<input type="submit" id="head_search_button" value="" tabindex="2"/>
<div id="head_search_text">
<center>
<input type="text" name="s" id="q" value="" dir="auto" placeholder="'.$_LANGUAGE['q_place'][DEFAULT_LANGUAGE].'" tabindex="1"/>
</center>
</div>
<!--</div>-->

</div>
<div id="head_search_logo"></div>
</div>

<div class="box_advance_search">
		<div class="advance">
		<div><b>'.$_LANGUAGE['sscope'][DEFAULT_LANGUAGE].'</b></div>
		<div></div>
		<div></div>
		<div><label><input type="radio" name="ssource" checked="checked" value="all"/>'.$_LANGUAGE['all'][DEFAULT_LANGUAGE].'</label></div>
		<div><label><input type="radio" name="ssource" value="thesis"/>'.$_LANGUAGE['thesis'][DEFAULT_LANGUAGE].'</label></div>
		<div><label><input type="radio" name="ssource" value="article"/>'.$_LANGUAGE['article'][DEFAULT_LANGUAGE].'</label></div>
		<div><b>'.$_LANGUAGE['sitem'][DEFAULT_LANGUAGE].'</b></div>
		<div></div>
		<div></div>
		<div><label><input type="radio" name="starget" checked="checked" value="all"/>'.$_LANGUAGE['all'][DEFAULT_LANGUAGE].'</label></div>
		<div><label><input type="radio" name="starget" value="title"/>'.$_LANGUAGE['stitle'][DEFAULT_LANGUAGE].'</label></div>
		<div><label><input type="radio" name="starget" value="author"/>'.$_LANGUAGE['sauthor'][DEFAULT_LANGUAGE].'</label></div>
		<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input type="radio" name="starget" value="keywords"/>'.$_LANGUAGE['skw'][DEFAULT_LANGUAGE].'</label></div>
		<div></div>
		<div></div>
		<div><b>'.$_LANGUAGE['sdate'][DEFAULT_LANGUAGE].'</b></div>
		<div></div>
		<div></div>
		<div>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="number" name="year" value="" placeholder="'.$_LANGUAGE['place_year'][DEFAULT_LANGUAGE].'"/></div>
		</div>
		<div class="btn"><input type="button" id="show_advance" value="'.$_LANGUAGE['adsearch'][DEFAULT_LANGUAGE].'"/></div>
	</div>	

<!--</form>-->
<br/>
{html}
<br/>
</form>
{pagination}
</div>
</center>
';
$tpl = str_replace('{html}',$html,$tpl);
$tpl = str_replace('{pagination}',$paginate,$tpl);
return $tpl;
}

function filter_thesis($query){
/*if(!strstr($query,'WHERE')){
$query = $query.' WHERE ';
}*/
if(isset($_POST['field']) && !empty($_POST['field'])){
$_SESSION['save_search']['field'] = $_POST['field'];
$query['select'] = substr_replace($query['select'], ' t.f_id='.search_parameter($_POST['field'],false).' AND ', strpos($query['select'],'WHERE')+5, 0);
$query['count'] = substr_replace($query['count'], ' t.f_id='.search_parameter($_POST['field'],false).' AND ', strpos($query['count'],'WHERE')+5, 0);
//$query.' AND t.f_id='.search_parameter($_POST['field']);
}
if(isset($_POST['author']) && !empty($_POST['author'])){
$_SESSION['save_search']['author'] = $_POST['author'];
$query['select'] = substr_replace($query['select'], " concat_ws('',u.fname,u.lname) like ".search_parameter($_POST['author'])." AND ", strpos($query['select'],'WHERE')+5, 0);
$query['count'] = substr_replace($query['count'], " concat_ws('',u.fname,u.lname) like ".search_parameter($_POST['author'])." AND ", strpos($query['count'],'WHERE')+5, 0);
//$query = $query." AND concat_ws('',u.fname,u.lname) like %".search_parameter($_POST['author'])."%";
}
//if(isset($_type['year'])){
//$query = $query.' AND YEAR(t.date)='.search_parameter($_POST['year']);
//}
return $query;
}

function filter_article($query){
/*if(!strstr($query,'WHERE')){
$query = $query.' WHERE ';
}*/
if(isset($_POST['type']) && !empty($_POST['type'])){
$_SESSION['save_search']['type'] = $_POST['type'];
$query['select'] = substr_replace($query['select'], ' a.type='.search_parameter($_POST['type'],false).' AND ', strpos($query['select'],'WHERE')+5, 0);
$query['count'] = substr_replace($query['count'], ' a.type='.search_parameter($_POST['type'],false).' AND ', strpos($query['count'],'WHERE')+5, 0);
//$query = $query.' AND a.type='.search_parameter($_POST['type']);
}
if(isset($_POST['field']) && !empty($_POST['field'])){
$_SESSION['save_search']['field'] = $_POST['field'];
//$query['select'] = substr_replace($query['select'], ' a.f_id='.search_parameter($_POST['field']).' AND ', strpos($query['select'],'WHERE')+5, 0);
//$query['count'] = substr_replace($query['count'], ' a.f_id='.search_parameter($_POST['field']).' AND ', strpos($query['count'],'WHERE')+5, 0);
//$query = $query.' AND a.f_id='.search_parameter($_POST['field']);
}
if(isset($_POST['author']) && !empty($_POST['author'])){
$_SESSION['save_search']['author'] = $_POST['author'];
$query['select'] = substr_replace($query['select'], " concat_ws('',u.fname,u.lname) like ".search_parameter($_POST['author'])." AND ", strpos($query['select'],'WHERE')+5, 0);
$query['count'] = substr_replace($query['count'], " concat_ws('',u.fname,u.lname) like ".search_parameter($_POST['author'])." AND ", strpos($query['count'],'WHERE')+5, 0);
//$query = $query." AND concat_ws('',u.fname,u.lname) like %".search_parameter($_POST['author'])."%";
}
//if(isset($_type['year'])){
//$query = $query.' AND YEAR(a.date)='.search_parameter($_POST['year']);
//}
return $query;
}

function dataType($type){
	if($type == 'int'){
		return PDO::PARAM_INT;
		}else if($type == 'str'){
			return PDO::PARAM_STR;
			}
	}

function search_parameter($value,$like=true){
global $search_params,$p;
//echo $xparam;
$ret = array();
if(!is_array($value)){
$value = array($value);
}
foreach($value as $v){
++$p;
$v = filter_var($v,FILTER_SANITIZE_STRING);
$v = htmlentities($v,ENT_QUOTES,"UTF-8");
$pname = ':param'.$p;
/*if($_QUOTES){
$pname = "':param$p'";
}*/
if($like){
$v = '%'.$v.'%';
}
array_push($search_params,array('name'=>':param'.$p,'value'=>$v,'int'=>(is_int($v))? true : false));
$ret[] = $pname;
}
return implode(",",$ret);
}

function makequery($q,$ssource,$starget,$year){
global $title_lang,$item_pre_page;
$select = array();
$where = "";
//$order = array();

if(is_latin($q)){
$title_lang = 'en';
}



switch($ssource){

case 'all':
$select['select1'] = "(SELECT t.id as 'thesis_id', t.title as 'thesis_title', concat_ws(' ',u.fname,u.lname) as 'thesis_fullname', t.date as 'thesis_date', t.f_id as 'thesis_fId', null as 'article_id', null as 'article_title',null as 'article_title_en', null as 'article_fullname', null as 'article_date', null as 'article_file' from `thesis` as t";
$select['join1'] = '';
$select['where1'] = '';
$select['year1'] = '';
$select[] = "ORDER BY t.id DESC";
$select['limit1'] = ')';
$select[] = 'UNION';
$select['select2'] = "(SELECT null,null,null,null,null,a.id,a.title,a.title_en,concat_ws(' ',u.fname,u.lname),a.date,a.file from `article` as a";
$select['join2'] = '';
$select['where2'] = '';
$select['year2'] = '';
$select[] = "ORDER BY a.id DESC";
$select['limit2'] = ')';
break;

case 'thesis':
$select['select1'] = "(SELECT t.id as 'thesis_id', t.title as 'thesis_title', concat_ws(' ',u.fname,u.lname) as 'thesis_fullname', t.date as 'thesis_date' from `thesis` as t";
$select['join1'] = '';
$select['where1'] = '';
$select['year1'] = '';
$select[] = "ORDER BY t.id DESC";
$select['limit1'] = ')';
break;

case 'article':
$select['select1'] = "(SELECT a.id as 'article_id', a.title as 'article_title', a.title_en as 'article_title_en', concat_ws(' ',u.fname,u.lname) as 'article_fullname', a.date as 'article_date', a.file as 'article_file' from `article` as a";
$select['join1'] = '';
$select['field_join'] = '';
$select['where1'] = '';
$select['year1'] = '';
$select[] = "ORDER BY a.id DESC";
$select['limit1'] = ')';
break;

}



switch($starget){

case 'all':
$where = " WHERE ";
$join1 = "inner join user as u on t.uId = u.id";
$join2 = "inner join user as u on a.uId = u.id";
if($ssource == 'all'){
$select['join1'] = $join1;
$select['join2'] = $join2;
$select['where1'] = "WHERE t.title like ".search_parameter($q)." OR concat_ws(' ',u.fname,u.lname) like ".search_parameter($q)." OR t.keyword like ".search_parameter($q);
$select['where2'] = "WHERE a.title like ".search_parameter($q)." OR concat_ws(' ',u.fname,u.lname) like ".search_parameter($q)." OR a.keyword like ".search_parameter($q)." OR a.keyword_en like ".search_parameter($q)." OR a.title_en like ".search_parameter($q);
}else if($ssource == 'thesis'){
$select['join1'] = $join1;
$select['where1'] = "WHERE t.title like ".search_parameter($q)." OR concat_ws(' ',u.fname,u.lname) like ".search_parameter($q)." OR t.keyword like ".search_parameter($q);
//$where = "t.title like %".search_parameter($q)."%";
}else if($ssource == 'article'){
$select['join1'] = $join2;
$select['where1'] = "WHERE a.title like ".search_parameter($q)." OR concat_ws(' ',u.fname,u.lname) like ".search_parameter($q)." OR a.keyword like ".search_parameter($q)." OR a.keyword_en like ".search_parameter($q)." OR a.title_en like ".search_parameter($q);
//$where = "a.title like %".search_parameter($q)."% OR a.title_en like %".search_parameter($q)."%";
}
break;

case 'title':
if(is_latin($q)){
$title_lang = 'en';
}
$join1 = "inner join user as u on t.uId = u.id";
$join2 = "inner join user as u on a.uId = u.id";
if($ssource == 'all'){
$select['join1'] = $join1;
$select['join2'] = $join2;
$select['where1'] = "WHERE t.title like ".search_parameter($q);
$select['where2'] = "WHERE a.title like ".search_parameter($q)." OR a.title_en like ".search_parameter($q);
//$where = " WHERE t.title like %".search_parameter($q)."% OR a.title like %".search_parameter($q)."% OR a.title_en like %".search_parameter($q)."%";
}else if($ssource == 'thesis'){
$select['join1'] = $join1;
$select['where1'] = "WHERE t.title like ".search_parameter($q);
//$where = " WHERE t.title like %".search_parameter($q)."%";
}else if($ssource == 'article'){
$select['join1'] = $join2;
$select['where1'] = "WHERE a.title like ".search_parameter($q)." OR a.title_en like ".search_parameter($q);
//$where = " WHERE a.title like %".search_parameter($q)."% OR a.title_en like %".search_parameter($q)."%";
}
break;

case 'author':
$join = "inner join user as u on concat_ws(' ',u.fname,u.lname) like ".search_parameter($q);
if($ssource == 'all'){
$select['join1'] = $join;
$select['join2'] = $join;
$select['where1'] = "WHERE t.uId = u.id";
$select['where2'] = "WHERE a.uId = u.id";
}else if($ssource == 'thesis'){
$select['join1'] = $join;
$select['where1'] = "WHERE t.uId = u.id";
//$where = " WHERE concat_ws(' ',t.fname,t.lname) like %".search_parameter($q)."%";
}else if($ssource == 'article'){
$select['join1'] = $join;
$select['where1'] = "WHERE a.uId = u.id";
//$where = " WHERE concat_ws(' ',a.fname,a.lname) like %".search_parameter($q)."%";
}
break;

case 'keywords':
if(is_latin($q)){
$title_lang = 'en';
}
$join1 = "inner join user as u on t.uId = u.id";
$join2 = "inner join user as u on a.uId = u.id";
if($ssource == 'all'){
$select['join1'] = $join1;
$select['join2'] = $join2;
$select['where1'] = "WHERE t.keyword like ".search_parameter($q);
$select['where2'] = "WHERE a.keyword like ".search_parameter($q)." OR a.keyword_en like ".search_parameter($q);
}else if($ssource == 'thesis'){
$select['join1'] = $join1;
$select['where1'] = "WHERE t.keyword like ".search_parameter($q);
//$where = " WHERE t.keyword like %".search_parameter($q)."%";
}else if($ssource == 'article'){
$select['join1'] = $join2;
$select['where1'] = "WHERE a.keyword like ".search_parameter($q)." OR a.keyword_en like ".search_parameter($q);
//$where = " WHERE a.keyword like %".search_parameter($q)."% OR a.keyword_en like %".search_parameter($q)."%";
}
break;
}

if(intval($year) && is_numeric($year)){
if($ssource == 'all'){
$select['year1'] = ' AND YEAR(t.date)='.search_parameter($year,false);
$select['year2'] = ' AND YEAR(a.date)='.search_parameter($year,false);
}else if($ssource == 'thesis'){
$select['year1'] = ' AND YEAR(t.date)='.search_parameter($year,false);
}else if($ssource == 'article'){
$select['year1'] = ' AND YEAR(a.date)='.search_parameter($year,false);
}
}

#SELECT ACTIVE ARTICLE AND THESIS#
if($ssource == 'all'){
$select['where1'] = $select['where1']." AND t.status = 1";
$select['where2'] = $select['where2']." AND a.status = 1";
}else if($ssource == 'thesis'){
$select['where1'] = $select['where1']." AND t.status = 1";
}else if($ssource == 'article'){
$select['where1'] = $select['where1']." AND a.status = 1";
}


#Multi Field Search
if($ssource == 'article' && isset($_POST['field']) && !empty($_POST['field'])){
$select['field_join'] = "inner join article_field as af on a.id = af.aId";
$select['where1'] = $select['where1']." AND af.fId in(".search_parameter($_POST['field'],false).")";
}



$page = 1;
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
$page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));
}
$start = abs(($page-1) * $item_pre_page);
$end = $item_pre_page;
if($ssource == 'all'){
$select['limit1'] = ' LIMIT '.$start.', '.$end.')';
$select['limit2'] = ' LIMIT '.$start.', '.$end.')';
}else if($ssource == 'thesis'){
$select['limit1'] = ' LIMIT '.$start.', '.$end.')';
}else if($ssource == 'article'){
$select['limit1'] = ' LIMIT '.$start.', '.$end.')';
}


$select = array_filter($select);

$count = $select;
if($ssource == 'all'){
$count['select1'] = "(select count(*) as `count` from `thesis` as t";
$count['limit1'] = ')';
$count['select2'] = "(select count(*) from `article` as a";
$count['limit2'] = ')';
}else if($ssource == 'thesis'){
$count['select1'] = "(select count(*) as `count` from `thesis` as t";
$count['limit1'] = ')';
}else if($ssource == 'article'){
$count['select1'] = "(select count(*) as `count` from `article` as a";
$count['limit1'] = ')';
}

$count = array_filter($count);

$select = implode("\n",$select); 
$count = implode("\n",$count);

$query = array('select'=>$select, 'count'=>$count);

return $query;

}

function search($pdo,$query,$param=true){
global $search_params;
//$search_params[] = array('name'=>':param_'.$p,'value'=>$value,'int'=>is_int($value));
//echo $query;
//echo '<br/>';
//$query = preg_replace("/\':param(\d)\'/",":param$1",$query);
$stmt = $pdo->prepare($query);
if($param && !empty($search_params)){
foreach($search_params as $px){
$stmt->bindValue($px['name'],$px['value'],PDO::PARAM_STR); //dataType(($p['int'])? 'int' : 'str')
}
}
$stmt->execute();
//echo $stmt->debugDumpParams();
if($stmt->rowCount()){
return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
return false;
}

if(isset($_SESSION['login'])){

$search_output = '';
$search_year = 'string';
$query = '';
$q = '';
if((isset($_POST) && !empty($_POST)) || isset($_GET['type']) || isset($_GET['q'])){
if(isset($_GET['q'])){
$q = filter_var($_GET['q'],FILTER_SANITIZE_STRING);
if(isset($_POST['ssource'])){
$search_source = trim(strtolower($_POST['ssource']));
}else{
$search_source = 'all';
}
if(isset($_POST['starget'])){
$search_target = trim(strtolower($_POST['starget']));
}else{
if(isset($_GET['type']) && (trim(strtolower($_GET['type'])) == 'keywords' || trim(strtolower($_GET['type'])) == 'keyword')){
$search_target = 'keywords';
}else{
$search_target = 'all';
}
}
if(isset($_POST['year']) && !empty($_POST['year']) && intval($_POST['year']) && is_numeric($_POST['year'])){
$search_year = intval($_POST['year']);
}
#set session
$_SESSION['save_search'] = array(
'ssource' => $search_source,
'starget' => $search_target,
'q' => $q,
'year' => $search_year
);
$query = makequery($q,$search_source,$search_target,$search_year);
if($search_source == 'article'){
$query = filter_article($query);
}else if($search_source == 'thesis'){
$query = filter_thesis($query);
}
//echo $query['select'];
}
}else{
$use_session = false;
if(isset($_SESSION['save_search'])){
if(isset($_GET['q'])){
if($_SESSION['save_search']['q'] == filter_var($_GET['q'],FILTER_SANITIZE_STRING)){
$use_session = true;
}
}else{
$use_session = false; //true
}
if($use_session){
#use session
$search_source = $_SESSION['save_search']['ssource'];
$search_target = $_SESSION['save_search']['starget'];
$search_year = $_SESSION['save_search']['year'];
$q = $_SESSION['save_search']['q'];
#=================
if(isset($_SESSION['save_search']['type'])){
$_POST['type'] = $_SESSION['save_search']['type'];
}
if(isset($_SESSION['save_search']['field'])){
$_POST['field'] = $_SESSION['save_search']['field'];
}
if(isset($_SESSION['save_search']['author'])){
$_POST['author'] = $_SESSION['save_search']['author'];
}
}
}else{
if(isset($_GET['q'])){
$q = filter_var($_GET['q'],FILTER_SANITIZE_STRING);
$search_source = 'all';
$search_target = 'all';
$search_year = '';
}
}
if(!empty($q)){
#search
$query = makequery($q,$search_source,$search_target,$search_year);
if($search_source == 'article'){
$query = filter_article($query);
}else if($search_source == 'thesis'){
$query = filter_thesis($query);
}
}

}

if(is_array($query) && !empty($query)){
#search
$count = search($pdo,$query['count']);
$data_count = 0;
foreach($count as $c){
$data_count = (int) $data_count + $c['count'];
}
//$count && !empty($count) && is_array($count) && $count[0] > 0 && end($count)
if($data_count > 0){
$data = search($pdo,$query['select']);


$page = 1;
	if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
    $page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));
	}
	$start = abs(($page-1) * $item_pre_page);

	
switch($search_source){
case 'thesis':
$search_output = tpl_thesis($pdo,$data,$count[0]['count']);
break;
case 'article':
$search_output = tpl_article($pdo,$data,$count[0]['count']);
break;
case 'all':
$search_output = tpl_search($pdo,$data,(int)$count[0]['count'] + $count[1]['count']);
break;
}

##SET OUTPUT##
$paginate->init($data_count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/search/',
'urlParameters' => 'q='.$q,
'separator' => "\n"
			
));
$search_output = cover($search_output,$paginate->displayLink());
}else{
// NOT FOUND
$search_output = cover('<br/>Your search- <b>'.$_SESSION['save_search']['q'].'</b> -did not match any documents<br/>',''); //.$query['select'].'<br/>'.print_r($search_params,true).'<br/>'.$data_count
}
}else{
#New Search
$search_output = cover('','');
}

echo $search_output;

}else{
redirect(BASE_PATH.'/',1);
}
