<?php
	/*
		Este feed foi feito no padrão Atom (e não por RSS que é proprietário)
		FONTE: https://pt.wikipedia.org/wiki/Atom
	*/
	
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ALL | E_STRICT);
	error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	//ini_set('default_charset','utf-8');
	
	date_default_timezone_set("America/Recife"); //-0300
	
	require_once "libs/libGeral.php";
	
	header('Content-type: text/plain; charset=utf-8');
	
	
	
	$thisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	
	require_once "libs/libMySQL2.php";
	
	$LunoMySQL = new LunoMySQL;
	
	echo "{\n";
	if($LunoMySQL->ifAllOk()){
		//$q = $_POST['q'];
		$q = urldecode(Propriedade("q"));
		//$Playlists=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_head", "",  "Title ASC", null, 0, 5);
		$Playlists=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_head", "Title LIKE '%$q%'",  "Title ASC");
		
		$sel = 0;
		echo "\t\"query\":\"$q\",\n";
		echo "\t\"datalist\":[\n";
		if(count($Playlists)>=1){
			for($P=0; $P<count($Playlists); $P++){ 
				/**/
				if($sel==0){
					if(strtolower(html_entity_decode($Playlists[$P]['Title']))==strtolower($q)){
						$sel = $P+1;
					}
				}/**/
			
				echo "\t\t\"".html_entity_decode($Playlists[$P]['Title'])."\"";
				if($P+1 < count($Playlists)){
					echo ",\n";
				}else{
					echo "\n";
				}
				//'Lucky Skywalker','Lunovox Heavenfinder'
			}
		}
		echo "\t],\n";

		if($q!=""){
			if(count($Playlists)>0){
				if($sel==0){
					echo "\t\"button\":\"new\"\n";
				}else{
					echo "\t\"button\":\"add\"\n";
				}
			}else{
				echo "\t\"button\":\"new\"\n";
			}
		}else{
			echo "\t\"button\":\"none\"\n";
		}
	}else{
		echo "\t\"datalist\":[]\n";
		echo "\t\"button\":\"none\"\n";
	}
	echo "}\n";
	//print_r($Videos);
	
	/*	
	{
	"button": "none",
	"datalist": [ 
		"Lucky Skywalker",
		"Lunovox Heavenfinder"
	]
	/**/
?>


