<?php

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }
 
$css = '
#news_control{ width: 900px; height: 100px; float: left; margin-bottom: 20px; }
#news_control a{ float: right; margin-right: 10px; text-decoration: none; width: 200px; }
#news_cover{ width: 900px; float: left; margin-left: 50px; }
#news_cover .source_side{ width: 200px; float: left; min-height: 600px; }
#news_cover .source_side a div{ float: right; width: 200px; word-wrap: break-word; height: 30px; text-align: right; color: #999; border-radius: 5px; padding-right: 10px; padding-top: 5px; }
#news_cover .source_side a div:hover{ float: right; width: 200px; word-wrap: break-word; height: 30px; background: #333; text-shadow: 0px 2px 5px #666; }
#news_cover .news_list{ width: 700px; min-height: 600px; float: left; }
#news_cover .news_list .news_post{ width: 600px; min-height: 200px; background: #fbfbfb; border-radius: 4px; box-shadow: 0px 0px 15px #ccc; margin-bottom: 50px; float: left; margin-left: 50px; }
#news_cover .news_list .news_post .title{ width: 550px; height: 40px; float: left; margin-left: 25px; text-align: right; }
#news_cover .news_list .news_post .content{ width: 550px; min-height: 100px; float: left; margin-left: 25px; text-align: right; }
#news_cover .news_list .news_post .media{ width: 550px; height: 50px; float: left; background: #fff; margin-left: 25px; }
#news_cover .news_list .news_post .media img{ float: left; width: 66px; height: 49px; margin-left: 5px; }
#news_cover .news_list .news_post .meta{ width: 550px; height: 40px; float: left; margin-left: 25px; text-align: left; }

#news_cover .manage_grid_title{ width: 100%; height: 30px; border: 1px solid #ccc; float: left; }
#news_cover .manage_grid_title div{ width: 112px; height: 30px; float: left; border-right: 1px solid #ccc; text-align: center; line-height: 30px; font-weight: bold; }
#news_cover .manage_grid_title div:last-child{ width: 50px; border: 0px; }
#news_cover .manage_grid_title div:first-child{ width: 60px; }
#news_cover .manage_grid_title div.x202{ width: 202px; }
#news_cover .manage_grid_row{ width: 100%; height: 30px; float: left; border-bottom: 1px solid #ccc; border-left: 1px solid #ccc; border-right: 1px solid #ccc; }
#news_cover .manage_grid_row:hover{ background: #f1f1f1; } 
#news_cover .manage_grid_row input[type=button]{ height: 25px; margin-top: -4px; line-height: 1px; }
#news_cover .manage_grid_row div{ width: 112px; height: 30px; float: left; border-right: 1px solid #ccc; text-align: center; line-height: 30px; font-weight: bold; }
#news_cover .manage_grid_row div:last-child{ width: 50px; border: 0px; }
#news_cover .manage_grid_row div:first-child{ width: 60px; }
#news_cover .manage_grid_row div.x202{ width: 202px; }
.default_marker{ width: 30px; height: 30px; cursor: pointer; }
.default_marker:hover{ width: 30px; height: 30px; background: url('.BASE_PATH.'/assets/img/checked.png) center no-repeat; }
.internal{ display: none; }
.internal input{ width: 500px; height: 30px; border: 1px solid #ccc; box-shadow: 0px 0px 5px #ccc; background: #fff; color: #666; border-radius: 5px; margin: 7px; outline: none; }
.external{ display: none; }
.external input{ width: 500px; height: 30px; border: 1px solid #ccc; box-shadow: 0px 0px 5px #ccc; background: #fff; color: #666; border-radius: 5px; margin: 7px; outline: none; }
#save_btn{ display: none; }

#edit_source{ width: 100%; height: 400px; }
#edit_source .edit_title{ width: 100%; height: 200px; text-align: right; }
#edit_source .edit_title b{ font-family: tahoma; font-size: 24px; }
#edit_source input[type=text]{ width: 500px; height: 30px; border: 1px solid #ccc; box-shadow: 0px 0px 5px #ccc; background: #fff; color: #666; border-radius: 5px; margin: 7px; outline: none; }
#edit_source input[type=submit]{ width: 100px; height: 30px; border-radius: 5px; background: #ccc; border: 1px solid #999; cursor: pointer; font-weight: bold; }
#edit_source input[type=submit]:hover{ color: #0000cc; }

#newsform input[type=text]{ width: 500px; height: 30px; font-family: tahoma; font-size: 15px; font-weight: bold; border: 1px solid #ccc; box-shadow: 0px 0px 5px #ccc; background: #fff; color: #666; border-radius: 5px; margin: 7px; outline: none; direction: rtl; }
#newsform select{ width: 500px; height: 30px; font-family: tahoma; font-size: 15px; font-weight: bold; border: 1px solid #ccc; border-radius: 5px; outline: none; direction: rtl; margin-right: 10px; }
.msg{ min-width: 350px; height: 30px; background: yellow; box-shadow: 0px 0px 15px #ccc; margin-top: 20px; margin-bottom: 20px; text-align: center; }
'; 


$js_data = '
$("input[name=type]").click(function(){
$("#save_btn").fadeIn("slow");
if($(this).val() == 1){
$(".external").fadeOut("slow",function(){
$(".internal").fadeIn("slow");
});
}else{
$(".internal").fadeOut("slow",function(){
$(".external").fadeIn("slow");
});
}
});
$(".msg").delay(2000).fadeOut("slow",function(){
$(this).remove();
});
';
 

include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('news')){
if(!$js->comp('news',\parsinegar\js::min($js_data))){
$js->file('news',\parsinegar\js::min($js_data));
}
}else{
$js->file('news',\parsinegar\js::min($js_data));
} 
 
 
 
function isXmlStructureValid($file) {
    $prev = libxml_use_internal_errors(true);
    $ret = true;
    try {
      new SimpleXMLElement($file, 0, true);
    } catch(Exception $e) {
      $ret = false;
    }
    if(count(libxml_get_errors()) > 0) {
      // There has been XML errors
      $ret = false;
    }
    // Tidy up.
    libxml_clear_errors();
    libxml_use_internal_errors($prev);
    return $ret;
 } 
 
function getFeed($feed_url,$sourceId) {
    global $paginate,$item_pre_page,$btn_pre_page; 
    $content = @file_get_contents($feed_url);
	if(isXmlStructureValid($content)){
    $x = new SimpleXmlElement($content);
	$max_news = 100;
	//$x = simplexml_load_file($feed_url);
	$template = '
	<div class="news_post">
<div class="title">{title}</div>
<div class="content">{content}</div>
<div class="media">{media}</div>
<div class="meta">{date}</div>
</div>
	';
 
/*
 <item> 
      <title>Police attend 'Black Friday' crowds</title>  
      <description>Police are called to more than 10 UK supermarkets amid crowd surges as people hunt for "Black Friday" offers.</description>  
      <link>http://www.bbc.co.uk/news/uk-30241459#sa-ns_mchannel=rss&amp;ns_source=PublicRSS20-sa</link>  
      <guid isPermaLink="false">http://www.bbc.co.uk/news/uk-30241459</guid>  
      <pubDate>Fri, 28 Nov 2014 07:15:35 GMT</pubDate>  
      <media:thumbnail width="66" height="49" url="http://news.bbcimg.co.uk/media/images/79356000/jpg/_79356683_de27.jpg"/>  
      <media:thumbnail width="144" height="81" url="http://news.bbcimg.co.uk/media/images/79356000/jpg/_79356684_de27.jpg"/> 
    </item>  

<item>
         <title>کاهش واردات نفت آسیایی‌ها از ایران</title>
         <link>http://www.tabnak.ir/fa/news/453275/کاهش-واردات-نفت-آسیایی‌ها-از-ایران</link>
         <description>با توجه به نوسانات تقاضا در بازار نفت، واردات نفت کشورهای آسیایی از ایران به زیر یک میلیون بشکه در روز کاهش یافته است.</description>
         <author>info@tabnak.ir</author>
         <pubDate>28 Nov 2014 12:16:41 +0330</pubDate>
      </item>
	  
*/
 $namespace = "http://search.yahoo.com/mrss/";
 
 //echo $x->channel->title."<br/>";
 //echo "<img src=\"".$x->channel->image->url."\" width=\"".$x->channel->image->width."px\" height=\"".$x->channel->image->height."px\" style=\"border: 1px solid #ccc;\" /><br/><hr/><br/>";
 
    //echo "<ul>";
     
	$output = array(); 
	if(count($x->channel->item)){ 
	$news_count = count($x->channel->item);
	if($news_count > $max_news){
	 $news_count = $max_news;
	}
	$page = 1;
	if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
    $page = $_GET['page'];
	}
	$start = abs(($page-1) * $item_pre_page);
	--$start;
	$paginate->init($news_count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/news/',
'urlParameters' => 'source='.$sourceId,
'separator' => "\n"
			
));
    for($i = 1; $i<= $item_pre_page; $i++){
	++$start;
	if(count($x->channel->item) >= $start){
	$entry = $x->channel->item[$start];
	
	//}
	//foreach($x->channel->item as $entry) {
	
	    $tpl = $template;
		$title = '';
		$content = '';
		$media = 'No Media File';
		$date = '';
		if(isset($entry->title) && !empty($entry->title)){
		$clean_title = filter_var($entry->title,FILTER_SANITIZE_STRING);
		$clean_link = filter_var($entry->link,FILTER_SANITIZE_STRING);
		$title = "<a href='$clean_link' title='$clean_title' target='blank'>" . $clean_title . "</a>";
		}
		if(isset($entry->description) && !empty($entry->description)){
		$content = filter_var($entry->description,FILTER_SANITIZE_STRING);
		}
		$media_source = $entry->children($namespace);
		if($media_source->thumbnail){
		$image = $media_source->thumbnail->attributes();
		$media = '<img src="'.$image->url.'" />';
		}
		if(isset($entry->pubDate) && !empty($entry->pubDate)){
		$date = $entry->pubDate;
		}
	   
	    $tpl = str_replace("{title}",$title,$tpl);
		$tpl = str_replace("{content}",$content,$tpl);
		$tpl = str_replace("{media}",$media,$tpl);
		$tpl = str_replace("{date}",$date,$tpl);
	   
	    $output[] = $tpl;
	   
        //echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
		//if(isset($entry->media)){
		//echo "<li><img src=\"".$entry->media['url']."\"/></li>";
		//}
		//print_r($entry);
		//$image = $entry->children($namespace)->thumbnail->attributes();
        //print_r($image);
		//echo $image_link = $image[1];
		//echo "<li><img src=\"".$image->url."\" width=\"".$image['width']."\" height=\"".$image['height']."\"/></li>";
	}	
    }
	}
    //echo "</ul>";
	if(!empty($output)){
	$output = implode("\n",$output);
	return array('news'=>$output, 'paginate'=>$paginate->displayLink());
	}
  }
	return false;
}


function get_count($data,$id){
foreach($data as $row){
if($row['source'] == $id){
 return $row['count'];
}
}
return 0;
}


function manage($pdo){
//global $pdo;

$html = array();
$template = '<div class="manage_grid_title">
<div>پیش فرض</div>
<div>حذف</div>
<div>ویرایش</div>
<div>نمایش</div>
<div>تعداد مطالب</div>
<div>نوع</div>
<div class="x202">نام</div>
<div>ردیف</div>
</div>
';
$row_tpl = '
<div class="manage_grid_row">
<div><center>{default}</center></div>
<div><input type="button" class="btn btn-danger" value="حذف" onclick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/news/?do=delete_source&token='.$_SESSION['token'].'&source={id}" }else{ return false; }\'/></div>
<div><input type="button" class="btn btn-primary" value="ویرایش" onclick=\'window.location="'.BASE_PATH.'/news/?do=edit_source&token='.$_SESSION['token'].'&source={id}"\'/></div>
<div><input type="button" class="btn btn-default" value="نمایش" onclick=\'window.location="'.BASE_PATH.'/news/?do=view&source={id}"\'/></div>
<div>{count}</div>
<div>{type}</div>
<div class="x202">{name}</div>
<div>{x}</div>
</div>
';

$sql = "select id,name,type,`default`,null as 'source',null as 'count'  from news_source 
union
select null,null,null,null,source,count(*) from news group by source";

$stmt = $pdo->query($sql);

if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
/*

id | name | type | default | source | count
-------------------------------------------
1   kooshyar 1       1        NULL    NULL
2   sanjesh  2       0        NULL    NULL
NULL NULL  NULL     NULL      1       2
*/
$x = 0;
foreach($rows as $row){
if($row['id'] != null){
++$x;
$tpl = $row_tpl;
$default = ($row['default'] == 1)? '<img src="'.BASE_PATH.'/assets/img/checked.png"/>' : '<div class="default_marker" onClick=\'window.location="'.BASE_PATH.'/news/?do=make_default&token='.$_SESSION['token'].'&source={id}"\'></div>';
$count = get_count($rows,$row['id']);
$type = ($row['type'] == 1)? 'داخلی' : 'خارجی';
$tpl = str_replace('{x}',$x,$tpl);
$tpl = str_replace('{name}',$row['name'],$tpl);
$tpl = str_replace('{type}',$type,$tpl);
$tpl = str_replace('{default}',$default,$tpl);
$tpl = str_replace('{count}',$count,$tpl);
$tpl = str_replace('{id}',$row['id'],$tpl);
$html[] = $tpl;
}
}
}
if(!empty($html)){
return $template.implode("\n",$html);
}
}


function make_default($pdo){
if(isset($_GET['source']) && intval($_GET['source'])){
$source = intval($_GET['source']);
$sql = "update news_source set `default`=0 where `default`=1";
if($pdo->exec($sql)){
$sql = "update news_source set `default`=1 where `id`=".$source;
$pdo->exec($sql);
}
}
redirect(BASE_PATH.'/news/?do=manage&token='.$_SESSION['token'],1);
}


function delete_source($pdo){
if(isset($_GET['source']) && intval($_GET['source'])){
$source = intval($_GET['source']);
$sql = "delete from news_source where id=".$source;
$pdo->exec($sql);
}
redirect(BASE_PATH.'/news/?do=manage&token='.$_SESSION['token'],1);
}


function save_source($pdo){
//global $pdo;
$name = '';
$url = '';
if(isset($_POST['type'])){
if($_POST['type'] == 1){
if(isset($_POST['name1']) && !empty($_POST['name1'])){
$name = filter_var($_POST['name1'],FILTER_SANITIZE_STRING);
}
}else if($_POST['type'] == 2){
if(isset($_POST['name2'],$_POST['url']) && !empty($_POST['name2']) && !empty($_POST['url'])){
$name = filter_var($_POST['name2'],FILTER_SANITIZE_STRING);
$url = filter_var($_POST['url'],FILTER_SANITIZE_STRING);
}
}
if($_POST['type'] == 1 && !empty($name)){
$sql = "insert into news_source(`name`,`type`) values(:n,1)";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(":n",$name,PDO::PARAM_STR);
$stmt->execute();
}else if($_POST['type'] == 2 && !empty($name) && !empty($url)){
$sql = "insert into news_source(`name`,`type`,`url`) values(:n,2,:l)";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(":n",$name,PDO::PARAM_STR);
$stmt->bindvalue(":l",$url,PDO::PARAM_STR);
$stmt->execute();
}
}

redirect(BASE_PATH.'/news/?do=manage&token='.$_SESSION['token'],1);

}


function add_source(){

return $html = '
<form method="post" action="'.BASE_PATH.'/news/?do=save_source&token='.$_SESSION['token'].'">
<center>
<img src="'.BASE_PATH.'/assets/img/news_logo.png"/>
</center>
<div align="right">
<label dir="ltr"><b>داخلی&nbsp;</b><input type="radio" name="type" value="1" zIndex="1"/></label>
<br/>
<i>(از منابع داخلی می توانید برای انتشار مطالب و احبار داخلی خود بدون نیاز به یک منبع خبری تحت وب و راه دور استفاده نمایید)</i>
<div class="internal">
<input type="text" name="name1" value="" placeholder="نام منبع" dir="rtl"/>
</div>
<br/><br/>
<label dir="ltr"><b>خارجی&nbsp;</b><input type="radio" name="type" value="2" zIndex="2"/></label>
<br/>
<i dir="rtl">(با اتصال یک منبع خارجی از طریق فضای وب، می توانید از بروز بودن همیشگی بخش اخبار خود اطمینان حاصل نمایید. این سرویس بر مبنای RSS2 کار می کند)</i>
<div class="external">
<input type="text" name="name2" value="" placeholder="نام منبع" dir="rtl"/>
<br/>
<input type="text" name="url" value="" placeholder="rss url"/>
</div>
</div>
<center>
<br/>
<input type="submit" name="" class="perfect_btn" id="save_btn" value="ذخیره"/>
<br/><br/>
</center>
</form>
<br/><br/><br/>
';

}


function add_news($pdo){
global $today;
$msg = '';
$edit = '';
$e_title = '';
$e_content = '';
//$date = '';
$e_source = '';
$sql = "select id,name from news_source where type=1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
if($stmt->rowCount()){
$source_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(isset($_POST) && !empty($_POST)){
//save news
if(isset($_POST['source'],$_POST['title'],$_POST['full_ckeditor'])){
$source = intval($_POST['source']);
$title = filter_var($_POST['title'],FILTER_SANITIZE_STRING);
$content = $_POST['full_ckeditor'];
if(!empty($source) && !empty($title) && !empty($content)){
if(!isset($_POST['id'])){
$sql = "insert into news(title,source,content,uid,date) values(:t,:s,:c,:u,:d)";
}else{
$sql = "update news set title=:t,source=:s,content=:c,uid=:u where id=:id";
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(":t",$title,PDO::PARAM_STR);
$stmt->bindvalue(":s",$source,PDO::PARAM_INT);
$stmt->bindvalue(":c",$content,PDO::PARAM_STR);
$stmt->bindvalue(":u",$_SESSION['userId'],PDO::PARAM_INT);
if(!isset($_POST['id'])){
$stmt->bindvalue(":d",$today,PDO::PARAM_STR);
}else{
$stmt->bindvalue(":id",intval($_POST['id']),PDO::PARAM_INT);
}
if($stmt->execute()){
if(!isset($_POST['id'])){
$msg = '<div class="msg">خبر جدید با موفقیت درج شد</div>';
}else{
$msg = '<div class="msg">عملیات ویرایش با موفقیت انجام شد</div>';
}
}
}
}
}else{
if(isset($_GET['news'])){
#get news
$sql = "select * from news where id=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(":id",intval($_GET['news']),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$edit = '<input type="hidden" name="id" value="'.intval($_GET['news']).'"/>';
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$e_title = $row['title'];
$e_content = $row['content'];
//$date = $row['date'];
$e_source = $row['source'];
}

}
}

$options = array();
foreach($source_rows as $row){
$selected = '';
if(!empty($e_source) && $row['id'] == $e_source){
$selected = 'selected="selected"';
}
$options[] = '<option value="'.$row['id'].'" '.$selected.'>'.$row['name'].'</option>';
}
$select = "<select name=\"source\">\n".implode("\n",$options)."\n</select>";
$html = '
<form method="post" id="newsform">
'.$msg.$edit.'
<div align="right">
<input type="text" name="title" value="'.$e_title.'" placeholder="عنوان خبر" />
<br/><br/>
'.$select.'
</div>
<br/><br/>
<textarea class="ckeditor" name="full_ckeditor">'.$e_content.'</textarea>
<br/><br/>
<input type="submit" class="perfect_btn" value="ذخیره" />
<br/><br/>
</form>
';
return $html;

}
redirect(BASE_PATH.'/news/?do=add_source&token='.$_SESSION['token'],1);
}


function edit_source($pdo){
if(isset($_POST) && !empty($_POST) && isset($_POST['id']) && intval($_POST['id'])){
$param = array();
$sql = '';
if(isset($_POST['url'])){
$name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
$url = filter_var($_POST['url'],FILTER_SANITIZE_STRING);
if(!empty($name) && !empty($url)){
$sql = "update news_source set name=:name, url=:url where id=:id";
$param[] = array(':name',$name);
$param[] = array(':url',$url);
}
}else{
$name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
if(!empty($name)){
$sql = "update news_source set name=:name where id=:id";
$param[] = array(':name',$name);
}
}
if(!empty($sql)){
$stmt = $pdo->prepare($sql);
foreach($param as $p){
$stmt->bindvalue($p[0],$p[1],PDO::PARAM_STR);
}
$stmt->execute();
redirect(BASE_PATH.'/news/?do=manage&token='.$_SESSION['token'],1);
}
}else{
if(isset($_GET['source']) && !empty($_GET['source']) && intval($_GET['source'])){
$sql = "select id,name,type,url from news_source where id=:i";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':i',intval($_GET['source']),PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row['type'] == 1){
$source = '
<div dir="rtl">
<b>نام:</b><br/>
<input type="text" name="name" value="'.$row['name'].'"/>
</div>
';
 }else if($row['type'] == 2){
$source = '
<div dir="rtl">
<b>نام:</b><br/>
<input type="text" name="name" value="'.$row['name'].'"/>
<br/>
<b>آدرس:</b><br/>
<input type="text" name="url" value="'.$row['url'].'"/>
</div>
';
 }
$html= '
<form method="post" id="edit_source">
<div class="edit_title">
<b>ویرایش منبع خبری</b>&nbsp;&nbsp;<img src="'.BASE_PATH.'/assets/img/edit_source.png" align="absmiddle"/>
</div>
<input type="hidden" name="id" value="'.$row['id'].'"/>
'.$source.'
<br/>
<input type="submit" value="ذخیره"/>
</form>
';
 
 return $html;
}
}

}//post else
}



function view($pdo){
global $paginate,$item_pre_page,$btn_pre_page; 
#get source
$sql = "select * from news_source";
$stmt = $pdo->query($sql);
$source_item = array();
$source = '';
$side_tpl = '<div class="source_side">{source}</div>';
$source_item_tpl = '<a href="'.BASE_PATH.'/news/?source={id}"><div>{name}</div></a>';
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
$src_item = $source_item_tpl;
$src_item = str_replace("{id}",$row['id'],$src_item);
$src_item = str_replace("{name}",$row['name'],$src_item);
$source_item[] = $src_item;
}
$side_tpl = str_replace("{source}",implode("\n",$source_item),$side_tpl);
}else{
$side_tpl = str_replace("{source}","",$side_tpl);
}

#get news
$news_item = array();
$news_list_tpl = '<div class="news_list">{news}<br/>{paginate}</div>';
$news_tpl = '
<div class="news_post">
<div class="title"><a href="'.BASE_PATH.'/news/?news={id}">{title}</a></div>
<div class="content">{content}</div>
{control}
<div class="meta">{date}</div>
</div>
';
$control = '';
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin'){
$control = '<div class="media"><a href="javascript:void(0)" onclick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/news/?do=delete&news={id}&token='.$_SESSION['token'].'&source={id}" }else{ return false; }\'>Delete</a>&nbsp;|&nbsp;<a href="'.BASE_PATH.'/news/?do=add_news&news={id}&token='.$_SESSION['token'].'">Edit</a></div>';
}
if(isset($_GET['source']) && !empty($_GET['source']) && intval($_GET['source'])){
$sql = "select * from news_source where `id`=:id";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(":id",intval($_GET['source']),PDO::PARAM_INT);
}else{
if(isset($_GET['news']) && !empty($_GET['news']) && intval($_GET['news'])){
$sql = "select * from news where id=".intval($_GET['news']);
}else{
$sql = "select * from news_source where `default`=1";
}
$stmt = $pdo->prepare($sql);
}
$stmt->execute();
if($stmt->rowCount()){
if(!isset($_GET['news'])){
$source = $stmt->fetch(PDO::FETCH_ASSOC);
if($source['type'] == 2){
#RSS Feed
$tpl ='<div class="news_list">';
$html = getFeed($source['url'],$source['id']);
$tpl = $tpl."\n".$html['news'];
$tpl = $tpl."\n".'<br/>';
$tpl = $tpl."\n".$html['paginate'];
$tpl = $tpl."\n".'</div>';
return $side_tpl."\n".$tpl;
}else{
if(!empty($source)){
$sql = "select count(*) as `count` from news where source=".$source['id'];
$stmt = $pdo->query($sql);
$news_count = $stmt->fetchColumn(0);
if($news_count > 0){
    $page = 1;
	if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
    $page = abs($_GET['page']);
	}
	$start = ($page-1) * $item_pre_page;
	
	$paginate->init($news_count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/news/',
'urlParameters' => 'source='.$source['id'],
'separator' => "\n"
			
));

$sql = "select * from news where source=".$source['id']." LIMIT ".$start." , ".$item_pre_page;
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $news){
$nt = $news_tpl;
$c = $control;
$nt = str_replace("{id}",$news['id'],$nt);
$nt = str_replace("{title}",$news['title'],$nt);
$nt = str_replace("{content}",$news['content'],$nt);
$nt = str_replace("{date}",$news['date'],$nt);
$c = str_replace("{id}",$news['id'],$c);
$nt = str_replace("{control}",$c,$nt);
$news_item[] = $nt;
}
$news_list_tpl = str_replace("{news}",implode("\n",$news_item),$news_list_tpl);
$news_list_tpl = str_replace("{paginate}",$paginate->displayLink(),$news_list_tpl);
$output = $side_tpl."\n".$news_list_tpl;
return $output;
}
}//count
$news_list_tpl = str_replace("{news}","",$news_list_tpl);
$news_list_tpl = str_replace("{paginate}","",$news_list_tpl);
$output = $side_tpl."\n".$news_list_tpl;
return $output;
}//source
}
}else{//NOT NEWS ID
$news = $stmt->fetch(PDO::FETCH_ASSOC);
$nt = $news_tpl;
$c = $control;
$nt = str_replace("{id}",$news['id'],$nt);
$nt = str_replace("{title}",$news['title'],$nt);
$nt = str_replace("{content}",$news['content'],$nt);
$nt = str_replace("{date}",$news['date'],$nt);
$c = str_replace("{id}",$news['id'],$c);
$nt = str_replace("{control}",$c,$nt);
$news_list_tpl = str_replace("{news}",$nt,$news_list_tpl);
$news_list_tpl = str_replace("{paginate}","",$news_list_tpl);
$output = $side_tpl."\n".$news_list_tpl;
return $output;
}
}else{
$news_list_tpl = str_replace("{news}","",$news_list_tpl);
$news_list_tpl = str_replace("{paginate}","",$news_list_tpl);
$output = $side_tpl."\n".$news_list_tpl;
return $output;
}
}


function delete($pdo){
if(isset($_GET['news']) && intval($_GET['news'])){
$news = intval($_GET['news']);
$sql = "deleft from news where id=".$news;
$pdo->exec($sql);
}
redirect(BACK_ADDRESS,1);
}


//getFeed('http://www.tabnak.ir/fa/rss/allnews');
?>
<center>
<br/>
<?php
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin'){
echo '
<div id="news_control">
<a href="'.BASE_PATH.'/news/?do=add_source&token='.$_SESSION['token'].'">
اضافه نمودن منبع خبر
&nbsp;<img src="'.BASE_PATH.'/assets/img/news_source_add.png" align="absmiddle" />
</a>
<a href="'.BASE_PATH.'/news/?do=manage&token='.$_SESSION['token'].'">
مدیریت منابع
&nbsp;<img src="'.BASE_PATH.'/assets/img/news_source_manage.png" align="absmiddle" />
</a>
<a href="'.BASE_PATH.'/news/?do=add_news&token='.$_SESSION['token'].'">
درج خبر جدید
&nbsp;<img src="'.BASE_PATH.'/assets/img/news_add.png" align="absmiddle" />
</a>
</div>
';
}
?>
<div id="news_cover">
<?php
$do = 'view';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower(filter_var($_GET['do'],FILTER_SANITIZE_STRING)));
}
switch($do){

case 'view' :
echo view($pdo);
break;

case 'manage':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
echo manage($pdo);
}
}
break;

case 'add_source':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
echo add_source();
}
}
break;

case 'add_news':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
echo add_news($pdo);
}
}
break;

case 'save_source':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
 save_source($pdo);
}
}
break;


case 'edit_source':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
echo edit_source($pdo);
}
}
break;


case 'make_default':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
make_default($pdo);
}
}
break;


case 'delete':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
delete($pdo);
}
}
break;

case 'delete_source':
if(isset($_SESSION['login']) && isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin' && validRequest()){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
delete_source($pdo);
}
}
break;

}
?>
</div>
</center>