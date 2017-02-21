<?php
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	error_reporting(E_ALL | E_STRICT);

	require_once "libs/libMySQL2.php";
	require_once "libs/libGeral.php";

	$ID=Propriedade("id");
	if($ID!=""){
		$LunoMySQL = new LunoMySQL;
		if($LunoMySQL->ifAllOk()){
			$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
			if(count($Video)==1){
				$urlVideo = $Video[0]['urlVideo'];
				$mimetype = get_headers($urlVideo, 1)["Content-Type"];;
				//$extension = pathinfo($urlVideo)['extension'];
				$extension = explode("/", $mimetype)[1];
				//$txtNameVideo = basename($urlVideo).".".$extension;
				$txtNameVideo = basename(str_replace(" ", "_", $Video[0]['Title'])).".".$extension;
				
				//$mimetype = mime_content_type($urlVideo);
				//$txtTitle = utf8_encode($Video[0]['Title']);
				//$txtTitle = $Video[0]['Title'];
				//$txtTitle = "aaaa";
				//$txtTitle = "opentube_ID.".$ID."_(".date("Y-m-d_H-i-s").")";
				//$txtTitle = $mimetype;
				
				
				
				header("Content-disposition: attachment; filename=".$txtNameVideo);
				//header("Content-type: video/".$extension);
				header("Content-type: ".$mimetype);
				readfile($urlVideo);
				/**/
				
				/*
				header("content-type: text/plain; charset=UTF-8");
				echo $urlVideo."\n\n";
				echo basename($urlVideo)."\n\n";
				echo $extension."\n\n";
				echo get_headers($urlVideo, 1)["Content-Type"];
				/**/

				
				//echo $mimetype;
			}
		}
	}

?>
