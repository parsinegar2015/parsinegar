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
#user_list_panel{ width: 900px; min-height: 400px; }
#user_list_panel #cp_menu{ width: 900px; float: left; height: 110px; }
#user_list_panel #user_list{ width: 900px; float: left; min-height: 400px; }
#user_list_panel #user_list .hrow{ width: 100%; height: 30px; float: left; border-bottom: 2px solid #FAFAFA; }
#user_list_panel #user_list .row{ width: 100%; height: 80px; float: left; border-bottom: 2px solid #FAFAFA; }
#user_list_panel #user_list .hrow .hcol{ width: 110px; height: 30px; border-right: 2px solid #FAFAFA; float: left; background: #FFFFEB; font-family: tahoma; font-size: 12px; font-weight: bold; line-height: 30px; text-align: center; }
#user_list_panel #user_list .row .col{ width: 110px; height: 80px; border-right: 2px solid #FAFAFA; float: left;  font-family: tahoma; font-size: 12px; word-wrap: break-word; font-weight: bold; padding-top: 30px; text-align: center; }
#user_list_panel #user_list .hrow .hcol:first-child{ border-left: 2px solid #FAFAFA; width: 112px; }
#user_list_panel #user_list .row .col:first-child{ border-left: 2px solid #FAFAFA; width: 112px; }
#user_list_panel #user_list .deactivate{ background: #FF6666; }
#user_search{ width: 420px; height: 25px; direction: rtl; font-weight: bold; outline: none; }

.not_found_user{ width: 100%; float: left; height: 300px; display: none; }

.edit_form_user{ width: 300px; }
.edit_form_user .col{ float: left; width: 200px; height: 40px; }
.edit_form_user .col:nth-child(even){ width: 100px; text-align: right; direction: rtl; font-weight: bold; }
.edit_form_user .col input[type=text]{ width: 100%; height: 25px; border-radius: 4px; border: 1px solid #ccc; background: #fff; direction: rtl; }
.edit_form_user .col select{ width: 100%; height: 25px; border-radius: 4px; border: 1px solid #ccc; background: #fff; direction: rtl; }
';


$js_data = '
define([],function(){
$(function(){
$("#select_all_user").click(function(){
if($("#select_all_user:checked").length){
$(".delusercheck").prop("checked",true).parent().parent().closest("div").css("background","#ccc");
}else{
$(".delusercheck").prop("checked",false).parent().parent().closest("div").css("background","");
}
});

$(".delusercheck").click(function(){
self = $(this);
if(self.is(":checked")){
self.parent().parent().closest("div").css("background","#ccc");
}else{
self.parent().parent().closest("div").css("background","");
$("#select_all_user").prop("checked",false);
}
});
$("#user_search").bind("keyup change",function(){
$(".user_row").fadeOut("fast").removeClass("user_row");
self = $(this);
$("div[id^=u_"+self.val()+"]").addClass("user_row").fadeIn("fast");
if($(".user_row").length == 0){
$(".btn-lg").text($("#user_search").val()+" جستجوی نام کاربری");
$(".btn-lg").click(function(){
window.open("'.BASE_PATH.'/user/?do=search&user="+$("#user_search").val()+"&token='.$_SESSION['token'].'","_blank");
});
$(".not_found_user").fadeIn("slow");
}else{
//alert($("#user_list").children().length);
$(".not_found_user").fadeOut("fast");
}
 });
});
}); 
';


include('lib/js.php');

$js = new \parsinegar\js();
$js->path = 'assets/js/';

if($js->file('user')){
if(!$js->comp('user',\parsinegar\js::min($js_data))){
$js->file('user',\parsinegar\js::min($js_data));
}
}else{
$js->file('user',\parsinegar\js::min($js_data));
}



function farsi_correct($string){
// Reverse the string
$len = mb_strlen($string, 'utf-8');
$result = '';
for ($i = ($len - 1); $i >= 0; $i--) {
$result .= mb_substr($string, $i, 1, 'utf-8');
}
// These chars work as space when a character comes after them, so the next character will not connect to them
$spaces_after = array('', ' ', 'ا', 'آ', 'أ', 'إ', 'د', 'ذ', 'ر', 'ز', 'ژ', 'و', 'ؤ');
// These chars work as space when a character comes before them, so the previous character will not connect to them
$spaces_before = array('', ' ');
// Persian chars with their different styles at different positions:
// Alone, After a non-space char, Before a non-space char, between two non-space chars
$chars = array();
$chars[] = array('آ', 'ﺂ', 'آ', 'ﺂ');
$chars[] = array('أ', 'ﺄ', 'ﺃ', 'ﺄ');
$chars[] = array('إ', 'ﺈ', 'ﺇ', 'ﺈ');
$chars[] = array('ا', 'ﺎ', 'ا', 'ﺎ');
$chars[] = array('ب', 'ﺐ', 'ﺑ', 'ﺒ');
$chars[] = array('پ', 'ﭗ', 'ﭘ', 'ﭙ');
$chars[] = array('ت', 'ﺖ', 'ﺗ', 'ﺘ');
$chars[] = array('ث', 'ﺚ', 'ﺛ', 'ﺜ');
$chars[] = array('ج', 'ﺞ', 'ﺟ', 'ﺠ');
$chars[] = array('چ', 'ﭻ', 'ﭼ', 'ﭽ');
$chars[] = array('ح', 'ﺢ', 'ﺣ', 'ﺤ');
$chars[] = array('خ', 'ﺦ', 'ﺧ', 'ﺨ');
$chars[] = array('د', 'ﺪ', 'ﺩ', 'ﺪ');
$chars[] = array('ذ', 'ﺬ', 'ﺫ', 'ﺬ');
$chars[] = array('ر', 'ﺮ', 'ﺭ', 'ﺮ');
$chars[] = array('ز', 'ﺰ', 'ﺯ', 'ﺰ');
$chars[] = array('ژ', 'ﮋ', 'ﮊ', 'ﮋ');
$chars[] = array('س', 'ﺲ', 'ﺳ', 'ﺴ');
$chars[] = array('ش', 'ﺶ', 'ﺷ', 'ﺸ');
$chars[] = array('ص', 'ﺺ', 'ﺻ', 'ﺼ');
$chars[] = array('ض', 'ﺾ', 'ﺿ', 'ﻀ');
$chars[] = array('ط', 'ﻂ', 'ﻃ', 'ﻄ');
$chars[] = array('ظ', 'ﻆ', 'ﻇ', 'ﻈ');
$chars[] = array('ع', 'ﻊ', 'ﻋ', 'ﻌ');
$chars[] = array('غ', 'ﻎ', 'ﻏ', 'ﻐ');
$chars[] = array('ف', 'ﻒ', 'ﻓ', 'ﻔ');
$chars[] = array('ق', 'ﻖ', 'ﻗ', 'ﻘ');
$chars[] = array('ک', 'ﻚ', 'ﻛ', 'ﻜ');
$chars[] = array('ك', 'ﻚ', 'ﻛ', 'ﻜ');
$chars[] = array('گ', 'ﮓ', 'ﮔ', 'ﮕ');
$chars[] = array('ل', 'ﻞ', 'ﻟ', 'ﻠ');
$chars[] = array('م', 'ﻢ', 'ﻣ', 'ﻤ');
$chars[] = array('ن', 'ﻦ', 'ﻧ', 'ﻨ');
$chars[] = array('و', 'ﻮ', 'ﻭ', 'ﻮ');
$chars[] = array('ؤ', 'ﺆ', 'ﺅ', 'ﺆ');
$chars[] = array('ی', 'ﯽ', 'ﯾ', 'ﯿ');
$chars[] = array('ي', 'ﻲ', 'ﻳ', 'ﻴ');
$chars[] = array('ئ', 'ﺊ', 'ﺋ', 'ﺌ');
$chars[] = array('ه', 'ﻪ', 'ﮬ', 'ﮭ');
$chars[] = array('ۀ', 'ﮥ', 'ﮬ', 'ﮭ');
$chars[] = array('ة', 'ﺔ', 'ﺗ', 'ﺘ');
$chars[] = array(' ', ' ', ' ', ' ');
$chars[] = array('0', '0', '0', '0');
$chars[] = array('1', '1', '1', '1');
$chars[] = array('2', '2', '2', '2');
$chars[] = array('3', '3', '3', '3');
$chars[] = array('4', '4', '4', '4');
$chars[] = array('5', '5', '5', '5');
$chars[] = array('6', '6', '6', '6');
$chars[] = array('7', '7', '7', '7');
$chars[] = array('8', '8', '8', '8');
$chars[] = array('9', '9', '9', '9');

$string = $result;
$len = mb_strlen($string, 'utf-8');
$result = '';
$buffer = array();


for ($i = 0; $i < $len; $i++) {
$previous_char = $i > 0 ? mb_substr($string, $i - 1, 1, 'utf-8') : '';
$current_char = mb_substr($string, $i, 1, 'utf-8');
$next_char = $i < ($len - 1) ? mb_substr($string, $i + 1, 1, 'utf-8') : '';

$in_array = false;
foreach ($chars as $char) {
if (in_array($current_char, $char)) {
$in_array = true;
if (!in_array($next_char, $spaces_after) && !in_array($previous_char, $spaces_before)) {
if ($current_char == ' ') {
if (!in_farsi_array($chars, $next_char) && !in_farsi_array($chars, $previous_char))
$in_array = false;
else
$result .= $char[3];
} else
$result .= $char[3];
} elseif (!in_array($previous_char, $spaces_before)) {
$result .= $char[2];
}
elseif (!in_array($next_char, $spaces_after)) {
$result .= $char[1];
}
else {
$result .= $char[0];
}
continue;
}
}
if (!$in_array) {
$buffer[] = $current_char;
$in_array = false;
} else {
$result .= implode('', array_reverse($buffer));
$buffer = array();
}
}
if (!empty($buffer))
$result .= implode('', array_reverse($buffer));

return $result;
}


	
function in_farsi_array(&$farsi, $text){
     foreach ($farsi as $t) {
      if (in_array($text, $t)){
       return true;
	   }
      }
     return false;
    }
	

function fa_correct_str($str){
      if(strstr($str,'-')){
	    $str = explode('-',$str);
	     foreach($str as $s){
	       $a[] = farsi_correct($s);
         }
	     $a = array_reverse($a);
	       return implode('-',$a);
	     }else{
		   return farsi_correct($str);
	 }
	 
	} 

function fullname($fullname){
		
		$str_arr = explode('-',$fullname);
        if(count($str_arr) == 2){
		return array('fname'=>str_replace('ك', 'ک', str_replace('ي', 'ی', $str_arr[1])),'lname'=>str_replace('ك', 'ک', str_replace('ي', 'ی', $str_arr[0])));
		}
		//$this->ToUnicode($str_arr[1]." ".$str_arr[0]);
		
		}	 


function ToUnicode2($arabic) {
      $arabic = str_replace('ء','',$arabic);
	  return str_replace('ك', 'ک', str_replace('ي', 'ی', $arabic));
	  
    }		



function openExcel($file){

  require_once 'Classes/PHPExcel.php';
  $excel_parser = new PHPExcel_Reader_Excel2007();

        $data = array();
		$objPHPExcel = $excel_parser->load($file);


        $rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
 
        $skip_rows = 0;

        $excell_array_data = array();

        foreach($rowIterator as $row){

         $cellIterator = $row->getCellIterator();

         $cellIterator->setIterateOnlyExistingCells(false);

        if($skip_rows >= $row->getRowIndex ()) continue;
         
		 
				$rowIndex = $row->getRowIndex ();
				
		 
         

         $excell_array_data[$rowIndex] = array();
 

         foreach ($cellIterator as $cell) {

          $data[$rowIndex][$cell->getColumn()] = $cell->getCalculatedValue();

         }

       }
	   
	   if(!empty($data)){
	    return $data;
	   }
	   return false;
	   
	}


function getColumn($data){
	$columns = array();	
	foreach($data[1] as $k => $v){
		$columns[str_replace('_',' ',str_replace('ك', 'ک', str_replace('ي', 'ی',$v)))] = $k;
		}
	return $columns;	
}	
	
	

function hashSSHA($password){

        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
	

	
function checkhashSSHA($salt,$password){

        $hash = base64_encode(sha1($password . $salt, true) . $salt);

        return $hash;
		
		//return sha1(sha1(base64_encode($salt)).sha1($password));
    }	
	

function check_email_address($email) {
        // First, we check that there's one @ symbol, and that the lengths are right
        if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
            // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
            return false;
        }
        // Split it into sections to make life easier
        $email_array = explode("@", $email);
        $local_array = explode(".", $email_array[0]);
        for ($i = 0; $i < sizeof($local_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
                return false;
            }
        }
        if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
            $domain_array = explode(".", $email_array[1]);
            if (sizeof($domain_array) < 2) {
                return false; // Not enough parts to domain
            }
            for ($i = 0; $i < sizeof($domain_array); $i++) {
                if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                    return false;
                }
            }
        }

        return true;
    }	
	
	


function manage($pdo){
global $paginate,$btn_pre_page,$page_display_title;
$page_display_title = 'مدیریت کاربران';
$do = 'manage';
$andParam = '';
$users = array();
$html = '
<form method="post" action="'.BASE_PATH.'/user/?do=delete&token='.$_SESSION['token'].'">
<center>
<div id="user_list_panel">
<div id="cp_menu">
<input type="submit" name="" class="btn btn-danger" value="حذف"/>
<input type="button" name="" class="btn btn-default" value="ترتیب: دانشجو - استاد" onClick=\'window.open("'.BASE_PATH.'/user/?do=sort&type=3&token='.$_SESSION['token'].'","_self")\'/>
<input type="button" name="" class="btn btn-default" value="ترتیب: استاد - دانشجو" onClick=\'window.open("'.BASE_PATH.'/user/?do=sort&type=2&token='.$_SESSION['token'].'","_self")\'/>
<input type="button" name="" class="btn btn-default" value="افزودن استاد" onClick=\'window.open("'.BASE_PATH.'/user/?do=add&type=teacher&token='.$_SESSION['token'].'","_self")\'/>
<input type="button" name="" class="btn btn-default" value="افزودن دانشجو" onClick=\'window.open("'.BASE_PATH.'/user/?do=add&type=student&token='.$_SESSION['token'].'","_self")\'/>
<br/><br/>
<input type="text" id="user_search" value="" placeholder="جستجو کاربران بر اساس نام کاربری" />
</div>
<div id="user_list">
<div class="hrow">
<div class="hcol"><input type="checkbox" value="" id="select_all_user"/></div>
<div class="hcol">ایمیل</div>
<div class="hcol">رشته تحصیلی</div>
<div class="hcol">سمت</div>
<div class="hcol">جنسیت</div>
<div class="hcol">نام خانوادگی</div>
<div class="hcol">نام</div>
<div class="hcol">نام کاربری</div>
</div>
{users}
<div class="not_found_user">
<center>
<br/><br/>
<button class="btn btn-primary btn-lg"></button>
</center>
</div>
</div>
<br/>
{pagination}
</div>
</center>
</form>';

$user_tpl = '
<div class="row user_row {active}" id="u_{username}">
<a name="{username}">
<div class="col"><input type="checkbox" value="{id}" name="userid[]" class="delusercheck"/></div>
<div class="col">{email}</div>
<div class="col">{field}</div>
<div class="col">{type}</div>
<div class="col">{sex}</div>
<div class="col">{lname}</div>
<div class="col">{fname}</div>
<div class="col"><a href="'.BASE_PATH.'/user/?do=edit&token='.$_SESSION['token'].'&username={username}">{username}</a></div>
</div>
';
$where = '';
if(isset($_GET['user'])){
if(intval($_GET['user'])){
$where = " and u.username='".filter_var($_GET['user'],FILTER_SANITIZE_STRING)."'";
}
}
$order = " order by u.`id` DESC ";
if(isset($_GET['type']) && intval($_GET['type']) && in_array(intval($_GET['type']),array(2,3))){
$do = 'sort';
if(intval($_GET['type']) == 2){
$andParam = '&type=2';
$order = " order by u.type ASC";
}else if(intval($_GET['type']) == 3){
$andParam = '&type=3';
$order = " order by u.type DESC";
}
}
$sql = "select u.*,field.title as 'field' from user as u
left join field on u.f_id = field.id
where u.type != 1".$where.$order;
#----------------------
$page = 1;
if(isset($_GET['page']) && !empty($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])){
$page = abs(filter_var($_GET['page'],FILTER_SANITIZE_STRING));
}
$start = abs(($page-1) * 40);
$end = 40;
$sql = $sql.' LIMIT '.$start.', '.$end;
#======================
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i = 1;
foreach($rows as $row){
$tpl = $user_tpl;
$tpl = str_replace('{id}',$row['id'],$tpl);
$tpl = str_replace('{email}',$row['email'],$tpl);
if($row['type']==3){
$tpl = str_replace('{field}',$row['field'],$tpl);
}else{
$tpl = str_replace('{field}',$row['f_id'],$tpl);
}
$type = ($row['type']==2)? 'استاد' : 'دانشجو';
$tpl = str_replace('{type}',$type,$tpl);
$sex = ($row['sex']==1)? 'مرد' : 'زن';
$tpl = str_replace('{sex}',$sex,$tpl);
$tpl = str_replace('{lname}',$row['lname'],$tpl);
$tpl = str_replace('{fname}',$row['fname'],$tpl);
$tpl = str_replace('{username}',$row['username'],$tpl);
if($row['active'] == 0){
$tpl = str_replace('{active}','deactivate',$tpl);
}else{
$tpl = str_replace('{active}','',$tpl);
}
$users[] = $tpl;
$i++;
}
}

if(!empty($users)){
$html = str_replace('{users}',implode("\n",$users),$html);
#======================
$sql = "select count(*) from user where type != 1";
$stmt = $pdo->query($sql);
$count = $stmt->fetchColumn(0);
##SET OUTPUT##
$paginate->init($count,40,$btn_pre_page,$page,array(
			
'template' => '<a href="{url}"><li class="tooltip" title="{info}">{number}</li></a>',
'info' => 'page {currentPage} of {totalPages}',
'currentItemTemplate' => '<a href="{url}"><li class="active tooltip" title="{info}">{number}</li></a>',
'url' => '/user/',
'urlParameters' => 'do='.$do.$andParam.'&token='.$_SESSION['token'],
'separator' => "\n"
			
));
$pageLink = $paginate->displayLink();
$html = str_replace('{pagination}',$pageLink,$html);
#======================
}else{
$html = str_replace('{users}','',$html);
$html = str_replace('{pagination}','',$html);
}
return $html;

}
	
	

function add($pdo){
global $page_display_title;
$page_display_title = 'ثبت کاربران';
if(!isset($_FILES['exfile'])){
if(isset($_GET['type']) && !empty($_GET['type'])){
if($_GET['type'] == 'student'){
$hidden = '<input type="hidden" name="type" value="student"/>';
}else if($_GET['type'] == 'teacher'){
$hidden = '<input type="hidden" name="type" value="teacher"/>';
}
#set input style
echo '
<center>
<img src="'.BASE_PATH.'/assets/img/UserGroups.png" />
<form method="post" enctype="multipart/form-data" style="width: 650px; height: 500px; background: url('.BASE_PATH.'/assets/img/adduserbg.jpg) center;">
'.$hidden.'
<div align="right" style="font-size: 34px; font-weight: bold;">
اضافه نمودن کاربران جدید
</div>
<br/>
<div style="font-size: 18px; font-weight: bold;">
<b>روشی آسان برای اضافه نمودن کاربران به برنامه، در این روش شما در ابتدا نوع کاربر مورد نظر خود را مشخص نموده تا وارد بخش ثبت کاربران شده و از طریق فرم زیر اقدام به ارسال فایل اکسل که شامل اسامی کاربران می باشد نمایید</b>
<br/>
<b>همچنین پس از ثبت کاربران، از بخش مدیریت کاربران همه اطلاعات کاربران قابل مدیریت و ویرایش می باشد</b>
</div>
<br/>
<input type="file" name="exfile" id="exfile" accept=".xlsx"/>
<br/><br/>
<input type="submit" class="perfect_btn" value="ثبت کاربران جدید"/>
</form>
<br/><br/>
</center>
';
}
}else{
if(isset($_POST['type']) && in_array($_POST['type'],array('student','teacher'))){
$permission = trim(filter_var($_POST['type'],FILTER_SANITIZE_STRING));
$type = ($permission=='student')? 3 : 2;
$file = $_FILES["exfile"]["tmp_name"];
$fileType = pathinfo(basename($_FILES["exfile"]["name"]),PATHINFO_EXTENSION);
if($fileType == 'xlsx'){
$data = openExcel($file);
if(is_array($data)){

$sql = "select * from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
$fields = array();
foreach($rows as $row){
$fields[trim(ToUnicode2($row['title']))] = $row['id'];
}
$userList = array();
$columns = getColumn($data);

$len = count($data);
 for($i = 2; $i<=$len; $i++){
 $fullname = fullname($data[$i][$columns['نام و نام خانوادگی']]);
 $username = $data[$i][$columns['شماره دانشجویی']];
 $password = hashSSHA($data[$i][$columns['شماره شناسنامه']]);
 $field = trim(ToUnicode2($data[$i][$columns['رشته']]));
 $sex = $data[$i][$columns['جنسیت']];
 if(array_key_exists($field,$fields) || $type == 2){
 $userList[] = array(
  'username'=>$username,
  'password'=>$password['encrypted'],
  'salt'=>$password['salt'],
  'fname'=>trim($fullname['fname']),
  'lname'=>trim($fullname['lname']),
  'sex'=> ($sex=='مرد')? 1 : 0,
  'permission'=>$permission,
  'f_id'=>($type == 3)? $fields[$field] : $field,
  'type'=>$type
 );
 }
 }
 
 if(!empty($userList)){
 $i = 0;
 $values = array();
 for($x=1;$x<=count($userList);$x++){
 
 #-Make Directory
 mkdir("assets/d/".$userList[($x-1)]['username']);
 
 $values[] = "(:p_".($i+1).",:p_".($i+2).",:p_".($i+3).",:p_".($i+4).",:p_".($i+5).",:p_".($i+6).",:p_".($i+7).",:p_".($i+8).",:p_".($i+9).")";
 $i = $i + 9;
 }
 $sql = "insert into `user`(`username`,`password`,`salt`,`fname`,`lname`,`sex`,`permission`,`f_id`,`type`) values".implode(',',$values);
 //echo $sql;
 $stmt = $pdo->prepare($sql);
 $i=1;
 foreach($userList as $user){
  foreach($user as $k => $v){
   $stmt->bindValue(":p_$i",$v,PDO::PARAM_STR);
   $i++;
  }
 }
 $stmt->execute();
 }
 
 }
}//Excel Data
}//Excel File Extension
 }

 #Return To Manage
 redirect(BASE_PATH.'/user/?do=manage&token='.$_SESSION['token'],1);
}

}



function status($pdo){
$fragment = '';
$page = 1;
if(isset($_SESSION['permission']) && $_SESSION['permission'] == 'admin'){
if(isset($_POST['user'],$_POST['status']) && intval($_POST['user']) && in_array($_POST['status'],[0,1])){
$fragment = '#'.filter_var($_POST['user'],FILTER_SANITIZE_STRING);
$sql = "update user set active=:s where username=:u";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':s',$_POST['status'],PDO::PARAM_INT);
$stmt->bindvalue(':u',filter_var($_POST['user'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->execute();
$sql = "select id from user where username=:u";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':u',filter_var($_POST['user'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount()){
$id = $stmt->fetchColumn();
$sql = "select count(*)+1 from user where id > $id";
$stmt = $pdo->query($sql);
$row_number = $stmt->fetchColumn(0);
$page = pagination::page($row_number,40);
}
}
}
redirect(BASE_PATH.'/user/?do=manage&page='.$page.'&token='.$_SESSION['token'].$fragment,1);
}



function edit($pdo){
global $page_display_title;
$page_display_title = 'ویرایش اطلاعات کاربر';
$page = 1;
$fragment = '';
if($_SESSION['permission'] == 'admin'){
if(isset($_GET['token']) && $_GET['token'] == $_SESSION['token']){
if(!isset($_POST['edit_user'])){
if(isset($_GET['username']) && !empty($_GET['username']) && intval($_GET['username'])){
$sql = "select * from user where username = :u";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':u',trim(filter_var($_GET['username'],FILTER_SANITIZE_STRING)),PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount()){
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$tpl = '
<form method="post" action="'.BASE_PATH.'/user/?do=edit&token='.$_SESSION['token'].'">
<input type="hidden" name="edit_user" value="'.trim($_GET['username']).'"/>
<div class="edit_form_user">
<div class="col"><input type="text" name="fname" value="{fname}"/></div>
<div class="col">نام:</div>
<div class="col"><input type="text" name="lname" value="{lname}"/></div>
<div class="col">نام خانوادگی:</div>
<div class="col"><input type="text" name="email" value="{email}"/></div>
<div class="col">ایمیل:</div>
<div class="col">{fields}</div>
<div class="col">رشته:</div>
<div class="col"><input type="submit" class="perfect_btn" value="ذخیره" /></div>
<div class="col"></div>
</div>
</form>
<br/><br/>
<div class="edit_form_user">
<form method="post" action="'.BASE_PATH.'/user/?do=status&token='.$_SESSION['token'].'">
<input type="hidden" name="status" value="{status}" />
<input type="hidden" name="user" value="'.$_GET['username'].'"/>
<div class="col"></div><div class="col"></div>
<div class="col"><input type="submit" class="perfect_btn" value="{status_caption}" /></div>
<div class="col"></div>
</form>
</div>
<br/><br/>
';
$field_dropdown = '';
if($user['type'] == 3){
$sql = "select id,title from field";
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$rows =$stmt->fetchAll(PDO::FETCH_ASSOC);
$field_dropdown = dropdown($rows,'field','title','id',$user['f_id']);
}
}else if($user['type'] == 2){
$field_dropdown = $user['f_id'].'<input type="hidden" name="field" value="1"/>';
}
$tpl = str_replace('{fields}',$field_dropdown,$tpl);
$tpl = str_replace('{fname}',$user['fname'],$tpl);
$tpl = str_replace('{lname}',$user['lname'],$tpl);
$tpl = str_replace('{email}',$user['email'],$tpl);
$tpl = str_replace('{status}',($user['active'] == 1)? 0 : 1,$tpl);
$tpl = str_replace('{status_caption}',($user['active'] == 1)? 'غیر فعال کردن کاربر' : 'فعال کردن کاربر',$tpl);

echo $tpl;
}
}
}else{
if(isset($_POST['fname']) && isset($_POST['lname']) && isset($_POST['email']) && isset($_POST['field'])){
$email_error = false;
$fname_error = true;
$lname_error = true;
$field_error = true;
$email = $_POST['email'];

if(!empty($_POST['email'])){
if(!check_email_address($_POST['email'])){
$email_error = true;
}
}

#=Fname======================================================
$fn = preg_replace('/\s*/','',$_POST['fname']);
$fn = preg_replace('/\/*/','',$fn);
if(!empty($fn)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-]+$/u',$_POST['fname'])){
$fn = str_replace('-',' ',$_POST['fname']);
$fnx = preg_replace('/\s*/','',$fn);
if(!empty($fnx)){
$fname_error = false;
$fname = $fn;
}
}
}

#=Lname======================================================
$ln = preg_replace('/\s*/','',$_POST['lname']);
$ln = preg_replace('/\/*/','',$ln);
if(!empty($ln)){
if(preg_match('/^[\w\d\x{600}-\x{6FF}\s\-]+$/u',$_POST['lname'])){
$ln = str_replace('-',' ',$_POST['lname']);
$lnx = preg_replace('/\s*/','',$ln);
if(!empty($lnx)){
$lname_error = false;
$lname = $ln;
}
}
}

#=Field======================================================
if(intval($_POST['field'])){
$field_error = false;
$field = intval($_POST['field']);
}

if(!$email_error && !$fname_error && !$lname_error && !$field_error && isset($_POST['edit_user']) && intval($_POST['edit_user'])){
$sql = "select type from user where username=".filter_var($_POST['edit_user'],FILTER_SANITIZE_STRING);
$stmt = $pdo->query($sql);
if($stmt->rowCount()){
$type = $stmt->fetchColumn();
if($type == 3){
$sql = "update user set fname=:fn,lname=:ln,email=:em,f_id=:f where username=:u";
}else if($type == 2){
$sql = "update user set fname=:fn,lname=:ln,email=:em where username=:u";
}
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':fn',$fname,PDO::PARAM_STR);
$stmt->bindvalue(':ln',$lname,PDO::PARAM_STR);
$stmt->bindvalue(':em',$email,PDO::PARAM_STR);
if($type == 3){
$stmt->bindvalue(':f',$field,PDO::PARAM_STR);
}
$stmt->bindvalue(':u',filter_var($_POST['edit_user'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->execute();
$sql = "select id from user where username=:u";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':u',filter_var($_POST['edit_user'],FILTER_SANITIZE_STRING),PDO::PARAM_STR);
$stmt->execute();
if($stmt->rowCount()){
$id = $stmt->fetchColumn();
$sql = "select count(*)+1 from user where id > $id";
$stmt = $pdo->query($sql);
$row_number = $stmt->fetchColumn(0);
$page = pagination::page($row_number,40);
$fragment = '#'.filter_var($_POST['edit_user'],FILTER_SANITIZE_STRING);
}
}
}
}
redirect(BASE_PATH.'/user/?do=manage&page='.$page.'&token='.$_SESSION['token'].$fragment,1);
}
}
}
}


function chpassword($pdo){
if(!empty($_POST['npass']) && !empty($_POST['cpass'])){
$sql = "select salt,password from user where id=:userId";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':userId',$_SESSION['userId'],PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount()){
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$salt = $user['salt'];
$encPassword = $user['password'];
if(checkhashSSHA($salt,$_POST['cpass']) == $encPassword){
$nps = preg_replace('/\s*/','',$_POST['npass']);
$nps = preg_replace('/\/*/','',$nps);
if(mb_strlen($nps, 'UTF-8') >= 8){
$password = hashSSHA($_POST['npass']);
$sql = "update user set salt=:s,password=:p";
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':s',$password['salt'],PDO::PARAM_STR);
$stmt->bindvalue(':p',$password['encrypted'],PDO::PARAM_STR);
$stmt->execute();
}
}
}
}
redirect(BASE_PATH.'/me',1);
}



function chmail($pdo){
if(isset($_POST['email']) && check_email_address($_POST['email'])){
$sql = "update user set email=:em where id=".$_SESSION['userId'];
$stmt = $pdo->prepare($sql);
$stmt->bindvalue(':em',$_POST['email'],PDO::PARAM_STR);
$stmt->execute();
}
redirect(BASE_PATH.'/me',1);
}



function logout(){
unset($_SESSION['login'],$_SESSION['permission'],$_SESSION['userId'],$_SESSION['name'],$_SESSION['fname'],$_SESSION['lname'],$_SESSION['username'],$_SESSION['token']);
if(isset($_SESSION['f_id'])){
unset($_SESSION['f_id']);
}
session_destroy();

#Return to Index
redirect(BASE_PATH,1);
}


function delete($pdo){
if(isset($_POST['userid']) && is_array($_POST['userid']) && !empty($_POST['userid']) && intval($_SESSION['userId'])){
$sql = array();
foreach($_POST['userid'] as $uid){
if(intval($uid)){
$sql[] = "delete from user where id=".filter_var($uid,FILTER_SANITIZE_STRING);
}
}
if(!empty($sql)){
$sql = implode('; ',$sql);
$pdo->exec($sql);
}
}
redirect(BASE_PATH.'/user/?do=manage&token='.$_SESSION['token'],1);
}



$error = true;
if(isset($_GET['token'],$_SESSION['token']) && $_GET['token'] == $_SESSION['token']){
$do = 'manage';
if(isset($_GET['do']) && !empty($_GET['do'])){
$do = trim(strtolower($_GET['do']));
}
if($do != 'logout' && $do != 'chmail' && $do != 'chpassword'){
if($_SESSION['permission'] == 'admin'){
$error = false;
}
}else{
$error = false;
}
}
if(!$error){
switch($do){
case 'add':
add($pdo);
break;

case 'manage':
echo manage($pdo);
break;

case 'sort':
echo manage($pdo);
break;

case 'search':
echo manage($pdo);
break;

case 'edit':
edit($pdo);
break;

case 'status':
status($pdo);
break;

case 'chmail':
chmail($pdo);
break;

case 'logout':
logout();
break;

case 'chpassword':
chpassword($pdo);
break;

case 'delete':
delete($pdo);
break;
	
}
}else{
redirect(BASE_PATH.'/',1);
}
?>