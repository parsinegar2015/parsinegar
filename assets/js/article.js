define([],function(){$(function(){$("form[name=add_article]").submit(function(event){$("input:not([type=submit])").each(function(){if(!$(this).val().match(/^[\s\t\r\n]*\S+/ig)){self=$(this);name=self.attr("name");if(name!="url"&&name!="title2"&&name!="more_authors"){self.css("border","1px solid red");event.preventDefault();}}
if(!$("input.majors_item").length){$("select[name=field]").css("border","1px solid red");event.preventDefault();}});if(!$("textarea[name=min_ckeditor]").val().match(/^[\s\t\r\n]*\S+/ig)){event.preventDefault();}
if($("select[name=file]").find(":selected").text()=="Choose here"){$("select[name=file]").css("border","1px solid red");event.preventDefault();}});$("select[name=file]").change(function(){if($(this).find(":selected").text()!="Choose hare"){$(this).css("border","");}else{$(this).css("border","1px solid red");}});$("form[name=add_article] input[type=text]").live("blur",function(){self=$(this);name=self.attr("name");if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){if(name!="url"&&name!="title2"&&name!="more_authors"){self.css("border","1px solid red");}}else{self.css("border","1px solid #ccc");}
if(name=="url"&&self.val().match(/^[\s\t\r\n]*\S+/ig)){if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(self.val())){self.css("border","1px solid red");}}});$("form[name=add_article] input[type=text]").live("keyup change click",function(){self=$(this);if(!self.val().match(/^[\s\t\r\n]*\S+/ig)){self.css("border","1px solid #ccc");}
name=self.attr("name");if(name=="url"&&self.val().match(/^[\s\t\r\n]*\S+/ig)){if(!/^(https?|ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(\#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i.test(self.val())){self.css("border","1px solid red");}}});$("select[name=field]").change(function(){$(this).css("border","");$f=$(this).val();$txt=$("select[name=field]").find(":selected").text();if(!$(".selected_items_box").find("input[value="+$f+"]").attr("name")){$(".selected_items_box").append("<input type=\"hidden\" name=\"majors[]\" class=\"majors_item\" value=\""+$f+"\"/><div class=\"field-item\" name=\""+$f+"\">"+$txt+"</div>");}});$(".field-item").live("click",function(e){$v=$(this).attr("name");$(".selected_items_box input[value="+$v+"]").remove();$(this).remove();});$("input[name=keywords]").on({focus:function(){$(".keyword_typeahead").fadeIn("slow");},click:function(){return false;}});$(".keyword_typeahead").click(function(event){});$(document).click(function(){$(".keyword_typeahead").fadeOut("slow");});var keyword_js_var=["\u0645\u0647\u0646\u062f\u0633\u06cc \u0645\u0627\u0644\u06cc","\u0631\u06cc\u0633\u06a9","\u0627\u0642\u062a\u0635\u0627\u062f","\u0645\u0627\u0644\u06cc","\u0633\u0648\u062f"];function findMatches(q,strs){var matches,substrRegex;matches=[];substrRegex=new RegExp("^"+q,"i");$.each(strs,function(i,str){if(substrRegex.test(str)){matches.push('<div class="k_item">'+str+'</div>');}});return matches.join("\n");};$(".k_item").live("click",function(){var $val=$("input[name=keywords]").val();var arr=$val.split("-");arr.pop();$val=arr.join("-");var xlen=arr.length;$dash="";if(xlen>0){$dash="-";}
$("input[name=keywords]").val($val+$dash+$(this).html());});$("input[name=keywords]").on("keyup",function(){var $val=$(this).val();if($val!=""&&$val.substr(-1)!="-"){var xarr=$val.split("-");var xlen=xarr.length;--xlen;$(".keyword_typeahead").html(findMatches(xarr[xlen],keyword_js_var));}});});});