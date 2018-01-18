// JavaScript Document
$(document).ready(function(){	
	"use strict";
	
//	HANDLE END FORWARD SLASH
	var sitloc = window.location.toString();
	var lastChar = sitloc.slice(-1);
	if(lastChar!=="/")
	{
		sitloc+="/";	
	}	
	$("#mast-header").click(function(){
			var prot = window.location.protocol;
			var host = window.location.host;
			alert(prot+"//"+host);
			//window.location.href=prot+host+"/ohm";
			
		});

	$('.ohmnav').click(function(){
		switch($(this).attr("id"))
		{
			case "home":
				window.location.href=sitloc;
			break;
			default:
				var whereTo = $(this).attr("id");
				window.location.href=sitloc+whereTo;
			break;
		}	
	});
});


