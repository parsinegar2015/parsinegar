define([],function(){$(function(){$("input.delete").live("click",function(){self=$(this);if(self.is(":checked")){self.parent().parent().css("background","#FF7F50");$("#del_title input").prop("disabled",false);}else{self.parent().parent().css("background","");if(!$("input.delete:checked").length){$("#del_title input").prop("disabled",true);}}});$(".file_frm").submit(function(e){uploadFile(e);});});function sleep(milliseconds){var start=new Date().getTime();for(var i=0;i<1e7;i++){if((new Date().getTime()-start)>milliseconds){break;}}}
function startproccess(){$("form.file_frm").fadeOut("fast",function(){$("#ajaxupload").fadeIn("slow");});$("#prgtooltip div").fadeIn("slow");return true;}
function endproccess(){$("#ajaxupload").fadeOut("fast",function(){$("form.file_frm").fadeIn("slow");$("#prgtooltip div").fadeOut("fast",function(){$("#prgtooltip div").html("");$("#prg2").css("width","0px");});});return true;}
function addrow(data){var $row_tpl='<div class="row"> \
<div><input type="checkbox" name="delete[]" class="delete" value="{id}"/></div> \
<div>{size}</div> \
<div><b>PDF</b></div> \
<div>{title}</div> \
<div class="file_row_id">{row_number}</div> \
</div>';var row_number=1;if($(".file_row_id").length>0){row_number=$(".file_row_id").length;++row_number;}
$row=$row_tpl;$row=$row.replace("{size}",data.size);$row=$row.replace("{title}",data.title);$row=$row.replace("{id}",data.id);$row=$row.replace("{row_number}",row_number);$("#file_grid").append($row);}
function _(el){return document.getElementById(el);}
function uploadFile(event){event.preventDefault();if($("input[name=title]").val().match(/^[\s\t\r\n]*\S+/ig)&&$("#file").val().lastIndexOf("pdf")==$("#file").val().length-3){if(startproccess()){var file=_("file").files[0];var formdata=new FormData();formdata.append("file",file);formdata.append("title",$("input[name=title]").val());var ajax=new XMLHttpRequest();ajax.upload.addEventListener("progress",progressHandler,false);ajax.addEventListener("error",errorHandler,false);ajax.addEventListener("abort",abortHandler,false);ajax.onreadystatechange=function(){if(ajax.readyState==4&&ajax.status==200){setTimeout(function(){endproccess();if(ajax.responseText!="Error"){var j=jQuery.parseJSON(ajax.responseText);if(j.error==0){alert("فایل شما با موفقیت آپلود گردید");addrow(j);}}else{alert("عملیات با خطا مواجه گردید");}},4000);}else{}}
ajax.open("POST","http://localhost/filemanager/?do=upload&token=fabc8973ac13055e4f0610c924d0b9e7c4b7266892275b9337fde46f3ae7ebac",true);ajax.setRequestHeader("X-Requested-With","XMLHttpRequest");ajax.send(formdata);}}}
function progressHandler(event){var percent=(event.loaded/event.total)*100;_("prg2").innerHTML=Math.round(percent)+"%";$("#prgtooltip div").html(Math.round(percent)+"%");prg=Math.round(percent)*5;_("prg2").style.width=prg+"px";}
function completeHandler(event){if(endproccess()){if(isJson(event.target.responseText)){var j=jQuery.parseJSON(event.target.responseText);if(j.error==0){alert("فایل شما با موفقیت آپلود گردید");}}else{alert("عملیات با خطا مواجه گردید");}}}
function errorHandler(event){endproccess()
alert("Error");}
function abortHandler(event){endproccess();alert("Error");}});