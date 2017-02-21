function include($file){
	include($file,false,false);
}
function include($file,$protect){
	include($file,$protect,false);
}
function include($file,$protect,$Assincronismo){
	try{
		var xmlhttp;
		if (window.XMLHttpRequest){ //code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}else{ //code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
				$resp=xmlhttp.responseText;
				if($resp!=""){
					var $j = document.createElement("script"); //criando um elemento script: </script><script></script> 
					$j.type = "text/javascript"; //informando o type como text/javacript: <script type="text/javascript"></script>
					//$j.src = $file; //Inserindo um src com o valor do parâmetro file_path: <script type="javascript" src="+file_path+"></script>
					$j.text = $resp;
					document.body.appendChild($j); //Inserindo o seu elemento(no caso o j) como filho(child) do  BODY: <html><body><script type="javascript" src="+file_path+"></script></body></html>
				}
			}
		}
		if($protect==false){
			xmlhttp.open("GET",$file,$Assincronismo); //Assincronismo = false (Espera resposta)
			xmlhttp.send();
		}else{
			xmlhttp.open("POST","protectJS.php",$Assincronismo); //Assincronismo = false (Espera resposta)
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("file="+$file);
		}
	}catch(e){ 
		alert(e);
	}
}
function sessionClose(){
	include("sessionclose.php",false);
}