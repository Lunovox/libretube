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

function FormataTelefone(Campo, teclapres){
	var tecla = teclapres.keyCode;

	var vr = new String(Campo.value);
	vr = vr.replace("(", "");
	vr = vr.replace(")", "");
	vr = vr.replace("-", "");
	vr = vr.replace(".", "");
	vr = vr.replace(" ", "");

	tam = vr.length + 1;
	if (tecla != 9 && tecla != 8) {
		if (tam >= 1 && tam <= 3) {Campo.value = '('+vr.substr(0, 3) + ')';}
		if (tam >= 4 && tam <= 7) {Campo.value = '('+vr.substr(0, 3)+') '+vr.substr(3,4);}
		if (tam >= 8 && tam <= 11){Campo.value = '('+vr.substr(0, 3)+') '+vr.substr(3,4)+'-'+vr.substr(7,4);}
	}
}
function FormataCPF(Campo, teclapres){
	var tecla = teclapres.keyCode;

	var vr = new String(Campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace(".", "");
	vr = vr.replace("-", "");

	tam = vr.length + 1;

	if (tecla != 9 && tecla != 8){
		if (tam > 3 && tam < 7){Campo.value = vr.substr(0, 3) + '.' + vr.substr(3, tam);}
		if (tam >= 7 && tam <10){Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,tam-6);}
		if (tam >= 10 && tam < 12){Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,3) + '-' + vr.substr(9,tam-9);}
	}

}
function FormataCNPJ(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	vr = vr.replace(".", "");
	vr = vr.replace(".", "");
	vr = vr.replace("/", "");
	vr = vr.replace("-", "");

	tam = vr.length + 1 ;
	if (tecla != 9 && tecla != 8)		{
		if (tam > 2 && tam < 6)   {Campo.value = vr.substr(0, 2) + '.' + vr.substr(2, tam);}
		if (tam >= 6 && tam < 9)  {Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,tam-5);}
		if (tam >= 9 && tam < 13) {Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,tam-8);}
		if (tam >= 13 && tam < 15){Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,4)+ '-' + vr.substr(12,tam-12);}
	}
}
