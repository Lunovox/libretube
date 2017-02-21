window.onload=function(){
	var $myQuery = getUrlVar("q");
	if($myQuery!=undefined && $myQuery!=""){
		mnuBuscar.style.display='none'; 
		mnuBuscador.style.display='block'; 
		txtQuery.value=$myQuery;
	}
}
