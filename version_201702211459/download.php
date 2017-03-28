<?php
	
	/*
	@licstart The following is the entire license notice for the
	JavaScript code in this page.

	Copyright (C) 2015 Lunovox ( ͡° ͜ʖ ͡°)

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
					header("Content-type: video/".$extension);
				}elseif($Type=="poster"){
					$file = $Video[0]['urlPoster'];
					$extension = pathinfo($file)['extension'];
					$extension = ($extension!=""?$extension:"img");
					header("Content-type: image/".$extension);
				}elseif($Type=="subtitle"){
					$file = $Video[0]['urlSubtitle'];
					$extension = pathinfo($file)['extension'];
					$extension = ($extension!=""?$extension:"vtt");
					header("Content-type: text/".$extension)."; charset=utf-8";
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
