
define([],function(){

$(function(){
alert('test');
$('.btn').click(function(){
$('body').append('<button class="t">test</button>');
});
$('.t').live('click',function(){
alert($(this).attr('class'));
});
});

});