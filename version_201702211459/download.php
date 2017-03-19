<?php
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	error_reporting(E_ALL | E_STRICT);

	require_once "libs/libMySQL2.php";
	require_once "libs/libGeral.php";

	$ID=Propriedade("id");
	$Type=Propriedade("type");
	if($ID!=""){
		$LunoMySQL = new LunoMySQL;
		if($LunoMySQL->ifAllOk()){
			$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
			if(count($Video)==1){
				$file="";
				$extension="";
				if($Type=="" || $Type=="video"){
					$file = $Video[0]['urlVideo'];
					$extension = pathinfo($file)['extension'];
					$extension = ($extension!=""?$extension:"vid");
				}elseif($Type=="poster"){
					$file = $Video[0]['urlPoster'];
					$extension = pathinfo($file)['extension'];
					$extension = ($extension!=""?$extension:"img");
				}elseif($Type=="subtitle"){
					$file = $Video[0]['urlSubtitle'];
					$extension = pathinfo($file)['extension'];
					$extension = ($extension!=""?$extension:"vtt");
				}
				//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
				//$txtNameVideo = basename($file).".".$extension;

				$title = $Video[0]['Title'];
				$title = html_entity_decode($title);
				$title = str_replace(" ", "_", $title);
				$title = str_replace("'", "_", $title);
				$title = str_replace("\"", "_", $title);
				$txtNameVideo = basename($title).".".$extension;
				
				//$mimetype = mime_content_type($file);
				//$txtTitle = utf8_encode($Video[0]['Title']);
				//$txtTitle = $Video[0]['Title'];
				//$txtTitle = "aaaa";
				//$txtTitle = "opentube_ID.".$ID."_(".date("Y-m-d_H-i-s").")";
				//$txtTitle = $mimetype;
				
				
				/**/
				header("Content-disposition: attachment; filename=".$txtNameVideo);
				header("Content-type: video/".$extension);
				//header("Content-type: ".$mimetype);
				readfile($file);
				/**/
				
				/*
				header("content-type: text/plain; charset=UTF-8");
				echo "Title=".$Video[0]['Title']."\n";
				echo $txtNameVideo."\n\n";
				echo basename($file)."\n\n";
				echo $extension."\n\n";
				echo get_headers($file, 1)["Content-Type"];
				/**/

				
				//echo $mimetype;
			}
		}
	}

?>
