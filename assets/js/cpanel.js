define([],function(){$(function(){$("#chpass").submit(function(event){if(!$("input[name=cpass]").val().match(/^[\s\t\r\n]*\S+/ig)||!$("input[name=npass]").val().match(/^[\s\t\r\n]*\S+/ig)){event.preventDefault();}});$("#chmail").submit(function(event){if(!$("input[name=email]").val().match(/^[\s\t\r\n]*\S+/ig)){event.preventDefault();}});});});