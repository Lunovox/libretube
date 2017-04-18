/*
	@licstart The following is the entire license notice for the
	JavaScript code in this page.

	Copyright (C) 2015 Lunovox<lunovox@openmailbox.org>

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

isBuscadorVisible = false;

function doToggleBuscador(){
	mnuAssistir = document.getElementById("mnuAssistir");
	mnuBuscador = document.getElementById("mnuBuscador");
	if(isBuscadorVisible==false){
		mnuAssistir.style.display='none'; 
		mnuBuscador.style.display='block';
		isBuscadorVisible = true;
	}else{
		mnuAssistir.style.display='block'; 
		mnuBuscador.style.display='none';
		isBuscadorVisible = false;
	}
}
