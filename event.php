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
.event_cover{ width: 900px; height: 500px; float: left; margin-left: 50px; }
.event_cover .panel{ width: 450px; float: left; height: 350px; text-align: center; }

.row{ width: 898px; min-height: 100px; float: left; margin-left: 50px; background: #ccc; border: 1px solid #999; margin-bottom: 25px; text-align: right; direction: rtl; }
.row div{ float: left; width: 110px; height: 50px; border-right: 1px solid #999; margin: 0px; line-height: 50px; }
.row div.title{ width: 630px; height: 50px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.row div.num{ width: 40px; border: 0px; }
.row div.control{ float: left; width: 898px; background: #999; border-top: 1px solid #666; height: 49px; }
.row div.control div{ float: left; width: 299px; height: 48px; border: 0px; }
.row div.control div input[type=button]{ width: 97px; float: left; margin-left: 2px; margin-top: 10px; height: 30px; background: none; border: none; cursor: pointer; outline: none; font-weight: bold; line-height: 10px; }
.row div.control div input[type=button]:hover{ width: 98px; float: left; margin-right: 1px; height: 30px; border: 1px solid #666; }
.row div.control div input[type=button]:active{ border: 1px solid #00FFFF; }
.row div.control div input[type=button].active{ background: url('.BASE_PATH.'/assets/img/check.png) no-repeat right center; }
.row div.control div A{ line-height: 50px; }
.fullname{ line-height: 50px; direction: rtl; }
.row .point{ float: left; width: 898px; height: 10px; background: #444; border-top: 1px solid #666; transition-duration: 0.3s; }
.row .point:hover{ height: 40px; background: #000; }
';




function info($pdo){
global $page_display_title;
$page_display_title = "رویدادها";
$html = '
<div class="event_cover">
<div class="panel">
<br/><br/><br/>
<img src="'.BASE_PATH.'/assets/img/thesis_info.png"/>
<br/>
<input type="button" value="نمایش تایم لاین پایان نامه ها" onclick=\'window.location="'.BASE_PATH.'/event/?do=thesis&token='.$_SESSION['token'].'"\' />
<br/><br/>
تعداد پایان نامه های تایید نشده : {thesis_count_new}
<br/>
تعداد پایان نامه های تایید شده : {thesis_count_old}
<br/>
تعداد پایان نامه های بسته شده : {thesis_count_closed}
<br/>
تعداد کل پایان نامه های ثبت شده : {thesis_count}
</div>
<div class="panel">
<br/><br/><br/>
<img src="'.BASE_PATH.'/assets/img/article_info.png"/>
<br/>
<input type="button" value="نمایش تایم لاین مقالات" onclick=\'window.location="'.BASE_PATH.'/event/?do=article&token='.$_SESSION['token'].'"\' />
<br/><br/>
تعداد مقالات تایید نشده : {article_count_new}
<br/>
تعداد مقالات تایید شده : {article_count_old}
<br/>
تعداد مقالات بسته شده : {article_count_closed}
<br/>
تعداد کل مقالات ثبت شده : {article_count}
</div>
</div>
';
$sql = "select count(*) as 'thesis_new', null as 'thesis_old', null as 'article_new', null as 'article_old', null as 'thesis_closed', null as 'article_closed' from thesis as `tn` where status = 0
union
select null,count(*),null,null,null,null from thesis as `to` where status = 1
union
select null,null,count(*),null,null,null from article as `an` where status = 0
union
select null,null,null,count(*),null,null from article as `ao` where status = 1
union
select null,null,null,null,count(*),null from thesis as `tc` where status = 2
union
select null,null,null,null,null,count(*) from article as `ac` where status = 2";
$stmt = $pdo->query($sql);
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$html = str_replace("{thesis_count_new}",$rows[0]['thesis_new'],$html);
$html = str_replace("{thesis_count_old}",$rows[1]['thesis_old'],$html);
$html = str_replace("{article_count_new}",$rows[2]['article_new'],$html);
$html = str_replace("{article_count_old}",$rows[3]['article_old'],$html);
$html = str_replace("{thesis_count}",$rows[0]['thesis_new']+$rows[1]['thesis_old'],$html);
$html = str_replace("{article_count}",$rows[2]['article_new']+$rows[3]['article_old'],$html);
$html = str_replace("{thesis_count_closed}",$rows[4]['thesis_closed'],$html);
$html = str_replace("{article_count_closed}",$rows[5]['article_closed'],$html);
return $html;

}



function thesis($pdo){
global $paginate,$item_pre_page,$btn_pre_page,$page_display_title;
$page_display_title = "مدیریت پایان نامه ها";
$html = array();
$template = '
<div class="row">
<a name="{id}"/>
<div>{date}</div>
<div>{user}</div>
<div class="title">{title}</div>
<div class="num">{num}</div>
<div class="point"><a href="'.BASE_PATH.'/thesis/?do=grade&thesis={id}&token='.$_SESSION['token'].'">نمره: {grade}</a></div>
<div class="control">
<div>
<input type="button" value="بسته" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/thesis/?do=closed&token='.$_SESSION['token'].'&thesis={id}" }else{ return false; }\' {closed}/>
<input type="button" value="تایید" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/thesis/?do=accept&token='.$_SESSION['token'].'&thesis={id}" }else{ return false; }\' {accept}/>
<input type="button" value="در انتظار" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/thesis/?do=wait&token='.$_SESSION['token'].'&thesis={id}" }else{ return false; }\' {wait}/>
</div>
<div>
<a href="javascript:void(0)" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/thesis/?do=delete&token='.$_SESSION['token'].'&thesis={id}" }else{ return false; }\'>[حذف]</a>
<a href="'.BASE_PATH.'/thesis/?do=edit&thesis={id}&token='.$_SESSION['token'].'">[ویرایش]</a>
<a href="'.BASE_PATH.'/thesis/{link}.html">[نمایش]</a>
</div>
<div class="fullname">{fullname}</div>
</div>
</div>
';

$page = 1;
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
$page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));
}
$start = abs(($page-1) * $item_pre_page);

$sql = "select thesis.id,title,date,grade,uid,status,concat_ws(' ',u.fname,u.lname) as 'fullname', u.username as 'user' from thesis 
join user as u
on u.id = thesis.uid
order by thesis.id DESC
limit ".$start.", ".$item_pre_page;

$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$thesis = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i = 0;

$sum = 0;
if($page > 1){
$sum = $item_pre_page;
}
$sum = ($sum * ($page - 1));

foreach($thesis as $row){
$active = 'class="active"';
++$i;
$i = $i + $sum;
$link  = $row['id'].'/'.str_replace(' ','-',$row['title']);
$tpl = $template;
$tpl = str_replace('{date}',$row['date'],$tpl);
$tpl = str_replace('{user}',$row['user'],$tpl);
$tpl = str_replace('{title}',$row['title'],$tpl);
$tpl = str_replace('{num}',$i,$tpl);
$tpl = str_replace('{fullname}',$row['fullname'],$tpl);
$tpl = str_replace('{link}',$link,$tpl);
$tpl = str_replace('{id}',$row['id'],$tpl);
$tpl = str_replace('{grade}',(is_null($row['grade']))? '' : $row['grade'],$tpl);
if($row['status'] == 0){
$tpl = str_replace('{wait}',$active,$tpl);
$tpl = str_replace('{accept}','',$tpl);
$tpl = str_replace('{closed}','',$tpl);
}else if($row['status'] == 1){
$tpl = str_replace('{accept}',$active,$tpl);
$tpl = str_replace('{wait}','',$tpl);
$tpl = str_replace('{closed}','',$tpl);
}else if($row['status'] == 2){
$tpl = str_replace('{closed}',$active,$tpl);
$tpl = str_replace('{accept}','',$tpl);
$tpl = str_replace('{wait}','',$tpl);
}
$html[] = $tpl;
}
//$link  = str_replace(' ','-',$title);





#======================
$sql = "select count(*) from thesis";
$stmt = $pdo->query($sql);
$count = $stmt->fetchColumn(0);
##SET OUTPUT##
$paginate->init($count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/event/',
'urlParameters' => 'do=thesis&token='.$_SESSION['token'],
'separator' => "\n"
			
));
$pageLink = $paginate->displayLink();

#======================


#OUTPUT
echo implode("\n",$html);
echo "\n<br/>\n";
echo $pageLink;
}
}




function article($pdo){
global $paginate,$item_pre_page,$btn_pre_page,$page_display_title;
$page_display_title = "مدیریت مقالات";
$html = array();
$template = '
<div class="row">
<div>{date}</div>
<div>{user}</div>
<div class="title">{title}</div>
<div class="num">{num}</div>
<div class="control">
<div>
<input type="button" value="بسته" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/article/?do=closed&token='.$_SESSION['token'].'&article={id}" }else{ return false; }\' {closed}/>
<input type="button" value="تایید" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/article/?do=accept&token='.$_SESSION['token'].'&article={id}" }else{ return false; }\' {accept}/>
<input type="button" value="در انتظار" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/article/?do=wait&token='.$_SESSION['token'].'&article={id}" }else{ return false; }\' {wait}/>
</div>
<div>
<a href="javascript:void(0)" onClick=\'if(confirm(&#039;Are you sure?&#039;)) {window.location="'.BASE_PATH.'/article/?do=delete&token='.$_SESSION['token'].'&article={id}" }else{ return false; }\'>[حذف]</a>
<a href="'.BASE_PATH.'/article/?do=edit&article={id}&token='.$_SESSION['token'].'">[ویرایش]</a>
<a href="'.BASE_PATH.'/article/{link}.html">[نمایش]</a>
</div>
<div class="fullname">{fullname}</div>
</div>
</div>
';

$page = 1;
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
$page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));;
}
$start = abs(($page-1) * $item_pre_page);

$sql = "select article.id,title,title_en,date,uid,lang,status,concat_ws(' ',u.fname,u.lname) as 'fullname', u.username as 'user' from article 
join user as u
on u.id = article.uid
order by article.id DESC
limit ".$start.", ".$item_pre_page;

$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i = 0;

$sum = 0;
if($page > 1){
$sum = $item_pre_page;
}
$sum = ($sum * ($page - 1));

foreach($articles as $row){
$active = 'class="active"';
++$i;
$i = $i + $sum;
$ar_title = $row['title'];
if($row['lang'] == 'en'){
$ar_title = $row['title_en'];
}
$link  = $row['id'].'/'.str_replace(' ','-',$ar_title);
$tpl = $template;
$tpl = str_replace('{date}',$row['date'],$tpl);
$tpl = str_replace('{user}',$row['user'],$tpl);
$tpl = str_replace('{title}',$ar_title,$tpl);
$tpl = str_replace('{num}',$i,$tpl);
$tpl = str_replace('{fullname}',$row['fullname'],$tpl);
$tpl = str_replace('{link}',$link,$tpl);
$tpl = str_replace('{id}',$row['id'],$tpl);
if($row['status'] == 0){
$tpl = str_replace('{wait}',$active,$tpl);
$tpl = str_replace('{accept}','',$tpl);
$tpl = str_replace('{closed}','',$tpl);
}else if($row['status'] == 1){
$tpl = str_replace('{accept}',$active,$tpl);
$tpl = str_replace('{wait}','',$tpl);
$tpl = str_replace('{closed}','',$tpl);
}else if($row['status'] == 2){
$tpl = str_replace('{closed}',$active,$tpl);
$tpl = str_replace('{accept}','',$tpl);
$tpl = str_replace('{wait}','',$tpl);
}
$html[] = $tpl;
}
//$link  = str_replace(' ','-',$title);





#======================
$sql = "select count(*) from article";
$stmt = $pdo->query($sql);
$count = $stmt->fetchColumn(0);
##SET OUTPUT##
$paginate->init($count,$item_pre_page,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/event/',
'urlParameters' => 'do=article&token='.$_SESSION['token'],
'separator' => "\n"
			
));
$pageLink = $paginate->displayLink();

#======================


#OUTPUT
echo implode("\n",$html);
echo "\n<br/>\n";
echo $pageLink;
}
}

$error = true;

if(validRequest()){
if(isset($_SESSION['login']) && $_SESSION['permission'] == 'admin'){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
$error = false;
$do = 'info';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower($_GET['do']));
}
switch($do){
case 'info':
echo info($pdo);
break;
case 'article':
article($pdo);
break;
case 'thesis':
thesis($pdo);
break;
}
 }
}
}

if($error){
redirect(BASE_PATH.'/index.php',1);
}

?>