<?php

try{
$dsn = 'mysql:dbname='.DATABASE.';host='.HOST.';';
		   $pdo = new PDO($dsn,LOGIN,PASSWORD,array(PDO::ATTR_EMULATE_PREPARES => false, 
                                                                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		   $pdo->exec("set names utf8");
		 }catch(PDOException $e){
	       echo $e->getMessage();
	      }

include 'config'.DS.'language.php';

$css = '#wrap #content{ float: left; width: 1000px; min-height: 400px; }
#wrap #side{ float: left; width: 200px; min-height: 400px; }
#wrap #side .vm1{ width: 200px; height: 250px; background: url('.BASE_PATH.'/assets/img/vmbg.png); }
#wrap #side .vm1 A{ text-decoration: none; }
#wrap #side .vm1 A .vm_title{ float: left; width: 150px; height: 30px; text-align: right; font-weight: bold; margin-left: 10px; font-family: tahoma; font-size: 13px; }
#wrap #side .vm1 A .vm_icon{ float: left; width: 30px; height: 30px; text-align: left; margin-right: 10px; }
#wrap #side .vm1 A .vm_title:hover{ border-top: 1px solid #ddd; border-bottom: 1px solid #ccc; }
.ticker{ width: 99%; height: 30px; overflow: hidden; }
.ticker .roll{ position: relative; width: 100%; height: auto; top: 0px; }
.ticker .roll div{ width: 100%; height: 30px; direction: rtl; text-align: right; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ticker .roll div.articleflag{ float: right; width: 60px; height: 20px; border-radius: 0px 5px 5px 0px; background: #000; color: #fff; font-family: arial; font-size: 14px; text-align: center; font-weight: bold; }
.ticker .roll div.thesisflag{ float: right; width: 60px; height: 20px; border-radius: 0px 5px 5px 0px; background: red; color: #fff; font-family: arial; font-size: 14px; text-align: center; font-weight: bold; }
a.ticker_link{ text-decoration: none; color: black; font-family: tahoma; font-size: 14px; }
a.ticker_link:visited{ text-decoration: none; color: black; font-family: tahoma; font-size: 14px; }
';

$js_script = '
//(function ticker(){
$len = 0;
$len = $(".ticker .roll > div").length;
$i=0;
if($len > 0){
setInterval(function(){
$i++;
if($i==$len){
$i=0;
$(".roll").css("top",(parseFloat($(".roll").css("top")) + (30*$len))+ "px");
}
$(".roll").animate({top:(parseFloat($(".roll").css("top")) - 30)+ "px"},"slow");

//function(i, v) {
    //return (parseFloat(v) - 10) + "px";
//});

},3000);
}

//}());

';

?>
<div id="content">
<?php
$ticker = '
<br/>
<!--<center>-->
<div class="ticker">
<div class="roll">
{content}
</div>
</div>
<!--</center>-->
';
$article_thesis = array();
$row_article = '<div><div class="articleflag">Article</div>&nbsp;{article}</div>';
$row_thesis = '<div><div class="thesisflag">Thesis</div>&nbsp;{thesis}</div>';
$sql  = "select id,title,title_en,lang from article where status=1 order by id DESC limit 0,5";
$sql2 = "select id,title from thesis where status=1 order by id DESC limit 0,5";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$article_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($article_rows as $ar){
if($ar['lang']=='fa'){
$title = $ar['title'];
}else{
$title = $ar['title_en'];
}
$row_a = $row_article;
$article = $title;
if(isset($_SESSION['login'])){
$link  = $ar['id'].'/'.str_replace(' ','-',$title).'.html';
$article = '<a href="'.BASE_PATH.'/article/'.$link.'" class="ticker_link">'.$title.'</a>';
}
$row_a = str_replace('{article}',$article,$row_a);
$article_thesis[] = $row_a;
}
}
$stmt = $pdo->query($sql2);
if($c = $stmt->rowCount()){
$thesis_rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($thesis_rows as $tr){
$title = $tr['title'];
$row_t = $row_thesis;
$thesis = $title;
if(isset($_SESSION['login'])){
$link  = $tr['id'].'/'.str_replace(' ','-',$title).'.html';
$thesis = '<a href="'.BASE_PATH.'/thesis/'.$link.'" class="ticker_link">'.$title.'</a>';
}
$row_t = str_replace('{thesis}',$thesis,$row_t);
$article_thesis[] = $row_t;
}
if(count($article_thesis) > $c){
shuffle($article_thesis);
}
}
if(!empty($article_thesis)){
echo str_replace('{content}',implode("\n",$article_thesis),$ticker);
}
?>
<br/>
{content}
</div>
<div id="side">
<br/>
<div class="vm1" id="tip_mainMenu">
<br/><br/>
<a href="<?php echo BASE_PATH;?>/thesis/">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_thesis'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/thesis.png"/></div>
</a>
<a href="<?php echo BASE_PATH;?>/article/?do=view&type=journal">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_articlepub'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/article.png"/></div>
</a>
<a href="<?php echo BASE_PATH;?>/article/?do=view&type=conference">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_articleconf'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/article.png"/></div>
</a>
<a href="#">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_book'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/book4.png"/></div>
</a>
<a href="<?php echo BASE_PATH.'/page/'; ?>">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_document'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/document.png"/></div>
</a>
<a href="<?php echo BASE_PATH.'/search/'; ?>">
<div class="vm_title"><?php echo $_LANGUAGE['side_menu_search'][DEFAULT_LANGUAGE]; ?>&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="<?php echo BASE_PATH;?>/assets/img/search.png"/></div>
</a>
</div>
<?php
if(isset($_SESSION['login'])){
if(isset($_SESSION['permission'])){
echo '<br/><div class="vm1" id="tip_userMenu"><br/>';
if($_SESSION['permission'] == 'admin'){
echo '
<a href="'.BASE_PATH.'/me">
<div class="vm_title">پنل کاربری&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/cp.png"/></div>
</a>
<a href="'.BASE_PATH.'/user/?do=manage&token='.$_SESSION['token'].'">
<div class="vm_title">مدیریت کاربران&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/um.png"/></div>
</a>
<a href="'.BASE_PATH.'/event/?token='.$_SESSION['token'].'">
<div class="vm_title">رویدادها&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/event.png"/></div>
</a>
<a href="'.BASE_PATH.'/page/?do=add&token='.$_SESSION['token'].'">
<div class="vm_title">ایجاد صفحه&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/page.png"/></div>
</a>
<a href="'.BASE_PATH.'/backup/?token='.$_SESSION['token'].'">
<div class="vm_title">پشتیبان گیری&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/data.png"/></div>
</a>
<a href="'.BASE_PATH.'/filemanager">
<div class="vm_title">آپلود فایل&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/up.png"/></div>
</a>
<a href="'.BASE_PATH.'/help">
<div class="vm_title">راهنما&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/help.png"/></div>
</a>
';
}
if($_SESSION['permission'] == 'student'){
echo '<br/>
<a href="'.BASE_PATH.'/me">
<div class="vm_title">'.$_LANGUAGE['control_panel'][DEFAULT_LANGUAGE].'&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/cp.png"/></div>
</a>
<a href="'.BASE_PATH.'/article/?do=add&token='.$_SESSION['token'].'">
<div class="vm_title">'.$_LANGUAGE['add_article'][DEFAULT_LANGUAGE].'&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/article.png"/></div>
</a>
<a href="'.BASE_PATH.'/thesis/?do=add&token='.$_SESSION['token'].'">
<div class="vm_title">'.$_LANGUAGE['add_thesis'][DEFAULT_LANGUAGE].'&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/thesis.png"/></div>
</a>
<a href="'.BASE_PATH.'/filemanager">
<div class="vm_title">'.$_LANGUAGE['file_upload'][DEFAULT_LANGUAGE].'&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/up.png"/></div>
</a>
<a href="'.BASE_PATH.'/help">
<div class="vm_title">'.$_LANGUAGE['help'][DEFAULT_LANGUAGE].'&nbsp;&nbsp;</div>
<div class="vm_icon"><img src="'.BASE_PATH.'/assets/img/help.png"/></div>
</a>
';
}
echo '</div>';
}
}
?>
<br/>
<a href="<?php echo BASE_PATH; ?>/teacher/"><img src="<?php echo BASE_PATH; ?>/assets/img/teacher_article.png" width="200px" height="200px" style="border: 0px;"/></a>
</div>