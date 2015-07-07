<?php
if(isset($_SESSION['login']) && $_SESSION['login'] == true){

$css = '
.help_menu{ float: left; width: 100%; height: 30px; background: url('.BASE_PATH.'/assets/img/menu-h.jpg); cursor: pointer; text-align: right; padding: 5px; color: #FFF; font-weight: bold; font-size: 16px; overflow: hidden; }
.help_menu a:link{ float: right; width: 50%; height: 30px; color: #FFF; margin-top: 15px; }
.help_menu a:visited{ color: #fff; }
.help_menu a:hover{ color: #ccc; }
.help-item{ display: none; float: left; width: 100%; height: 300px; text-align: right; padding: 5px; font-size: 14px; color: #000; direction: rtl; }
';
$js_script = '
$(".help_menu").click(function(){
$(this).animate({"height":"146px"},"slow");
});
$(".help_menu a").click(function(){
$class = $(this).attr("href").replace("#","");
$(".display-item").fadeOut("slow",function(){
$(this).removeClass("display-item");
$("."+$class).fadeIn("slow").addClass("display-item");
});
});
if(window.location.hash) {
$class = window.location.hash.replace("#","");
if($class == "add-article" || $class == "cpanel" || $class == "file-manager"){
$(".display-item").fadeOut("slow",function(){
$(this).removeClass("display-item");
$("."+$class).fadeIn("slow").addClass("display-item");
});
}
}
';
echo '<div class="help_menu">
فهرست
<br/>
<a href="#add-article">درج مقاله</a>
<a href="#cpanel">پنل کاربری</a>
<a href="#file-manager">مدیریت فایل ها</a>
</div>
<div class="help-item add-article display-item">
<b>درج مقاله</b>
<br/>
<p>مقالات به دو بخش تقسیم می شوند، مقالاتی که در نشریات ارائه شده اند و مقالاتی که در همایش ها ارائه شده اند. در ثبت مقالات باید به قوانین مربوط به هر ورودی توجه نمود، هر نوع ارائه ورودی های مختلفی دارند.</p>
<p>مقالات ثبت شده در ابتدا فقط برای شما به نمایش در می آیند و پس از تایید شدن مقاله امکان جستجو و نمایش آن برای دیگر کاربران سیستم نیز به وجود می آید، همچنین تا زمانی که مقاله تایید نشده است امکان ویرایش آن وجود دارد.</p>
</div>
<div class="help-item cpanel">
<b>پنل کاربری</b>
<br/>
<p>از طریق پنل کاربری که اولین مکانی هستش که پس از ورود به سامانه به آن انتقال داده می شوید می توانید کارهای زیادی انجام دهید. تعریف و یا تغییر ایمیل، تغییر کلمه عبور، مدیریت مقالات ارسالی از قبیل بازبینی، ویرایش و یا حذف آن و همچنین نمایش وضعیت پایان نامه ثبت شده در کنار امکانات کنترلی ذکر شده، باعث می شود تا به راحتی بتوانید برروی مقالات و پایان نامه های خود مدیریت داشته باشید.</p>
<p>همچنین امکان جستجو در مقالات و پایان نامه ها به طور مستقیم از طریق پنل کاربری نیز امکان پذیر می باشد.</p>
</div>
<div class="help-item file-manager">
<b>مدیریت فایل ها</b>
<br/>
<p>این بخش که جزء مهمترین بخش های کاربری هستش این امکان را به کاربران می دهد که فایل های مربوط به مقاله خود را در سامانه آپلود کنند تا امکان درج مقاله برای آنان فراهم شود و همچنین دیگر کاربران بتوانند فایل آن مقاله را دانلود نمایند.</p>
<p>روش کار این بخش بسیار ساده می باشد و نیاز به بارگذاری دوباره صفحه وب نمی باشد، بلکه کافی است با انتخاب فایل از طریق آیکن فولدر و نوشتن عنوان فایل در فیلد عنوان اقدام به آپلود فایل مقاله نمایید و سپس با اتمام فرآیند آپلود پیغامی مربوط به موفقیت آمیز بودن و یا بروز مشکل در ارسال فایل برای شما به نمایش در می آید.</p>
<p>اطلاعات فایل های آپلود شده در فهرست زیرین کنترلر آپلود وجود دارند، زمانی که اقدام به آپلود فایل می کنید به آن فهرست اضافه میگردد در زمان درج یک مقاله جدید می توانید از بخش انتخاب فایل مقاله بر اساس عنوان فایل های آپلود شده یک فایل را نیز انتخاب نمایید</p>
</div>
<div class="help-item"></div>
';
}else{
redirect(BASE_PATH.'/index.php',1);
}

