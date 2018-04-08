/*
	@licstart The following is the entire license notice for the
	JavaScript code in this page.

	Copyright (C) 2015 Lunovox

	The JavaScript code in this page is free software: you can
	redistribute it and/or modify it under the terms of the GNU
	General Public License (GNU GPL) as published by the Free Software
	Foundation. The code is distributed WITHOUT ANY WARRANTY;
	without even the implied warranty of MERCHANTABILITY or FITNESS
	FOR A PARTICULAR PURPOSE. See the GNU GPL for more details.

	As additional permission under GNU GPL version 3 section 7, you
	may distribute non-source (e.g., minimized or compacted) forms of
	that code without the copy of the GNU GPL normally required by
	section 4, provided you include this license notice and a URL
	through which recipients can access the Corresponding Source.

	@licend The above is the entire license notice
	for the JavaScript code in this page.
*/

function getID(ObjetoName){
	return document.getElementById(ObjetoName);
}

function openPopupCenter(url, title, w, h) { //Usado no subs/video.php
	// Fixes dual-screen position                         Most browsers      Firefox
	var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;

	var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;

	var left = ((width / 2) - (w / 2)) + dualScreenLeft;
	var top = ((height / 2) - (h / 2)) + dualScreenTop;
	var newWindow = window.open(url, title, 'scrollbars=yes, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);

	// Puts focus on the newWindow
	if (window.focus) {
		newWindow.focus();
	}
	//fonte: http://stackoverflow.com/questions/4068373/center-a-popup-window-on-screen
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
function getUrlVar($var) {
	return getUrlVars()[$var];
}


function include($jsFilePath, $objID) {
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.status == 200 && xmlhttp.readyState == 4){
			var $conteudo = xmlhttp.responseText;
			document.getElementById($objID).innerHTML = $conteudo;
			//document.getElementById($objID).innerHTML = "aaaaaaaaaaa";
			//alert($conteudo);
		}
	};
	xmlhttp.open("GET",$jsFilePath,true);
	xmlhttp.send();
}

function include2($jsFilePath, $objID) {
	var js = document.createElement("script");

	js.type = "text/javascript";
	js.src = $jsFilePath;

	//document.body.appendChild(js);
	var $obj = document.getElementById($objID);
	$obj.appendChild(js);
}

function isEmailFormat($email) {
	var usuario = $email.substring(0, $email.indexOf("@"));
	var dominio = $email.substring($email.indexOf("@")+ 1, $email.length);

	if ((usuario.length >=1) &&
		(dominio.length >=3) && 
		(usuario.search("@")==-1) && 
		(dominio.search("@")==-1) &&
		(usuario.search(" ")==-1) && 
		(dominio.search(" ")==-1) &&
		(dominio.search(".")!=-1) &&      
		(dominio.indexOf(".") >=1)&& 
		(dominio.lastIndexOf(".") < dominio.length - 1)
	) {
		return true;
	}
	return false;
}
