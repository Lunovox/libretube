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

	class TreatVideo{
		//	Fonte:http://stackoverflow.com/questions/18534835/fastest-way-to-extract-a-specific-frame-from-a-video-php-ffmpeg-anything
	
		var $pathVideo="";
		var $timeThumbnail="00:00:05";
		var $pathThumbnail="./video_thumbnail.png";
		
		function TreatVideo($myPathVideo=""){
			$resp = $this->setPathVideo($myPathVideo);
			if($resp==true){
				$this->setPathThumbnail(
					str_replace($this->getExtension(), "png", $this->getPathVideo())
				);
			}else{
				echo("$resp");
			}
		}
		function setPathVideo($myPathVideo){
			if($myPathVideo!=""){		
				if(file_exists($myPathVideo)){
					$this->pathVideo = $myPathVideo;
					return true;
				}else{
					return "[ERRO=setPathVideo()] File '$myPathVideo' not exist!";
				}
			}else{
				return "[ERRO=setPathVideo()] Please declare the video path!";
			}
		}
		function getPathVideo(){
			return $this->pathVideo;
		}
		function setTimeThumbnail($myTimeThumbnail){
			if($myTimeThumbnail!=""){		
				$this->timeThumbnail = $myTimeThumbnail;
				return true;
			}else{
				return "[ERRO=setTimeThumbnail()] Please declare the Thumbnail Time!";
			}
		}
		function getTimeThumbnail(){
			return $this->timeThumbnail;
		}
		function setPathThumbnail($myPathThumbnail){
			if($myPathThumbnail!=""){		
				$this->pathThumbnail = $myPathThumbnail;
				return true;
			}else{
				return "[ERRO=setPathThumbnail()] Please declare the Thumbnail Path!";
			}
		}
		function getPathThumnail(){
			return $this->pathThumbnail;
		}
		function getMimetype(){
			if($this->pathVideo!=""){		
				if(file_exists($this->pathVideo)){
					//$mimetype = get_headers($this->pathVideo, 1)["Content-Type"];
					$mimetype = mime_content_type($this->pathVideo);
					return $mimetype;
				}
			}
			return false;
		}
		function getExtension(){
			if($this->pathVideo!=""){			
				if(file_exists($this->pathVideo)){
					$mimetype = $this->getMimetype();
					$extension = explode("/", $mimetype)[1];
					return $extension;
				}
			}
			return false;
		}
		function getBasename(){
			if($this->pathVideo!=""){			
				if(file_exists($this->pathVideo)){
					return basename($this->pathVideo);
				}
			}
			return false;
		}
		function getFilesize(){
			if($this->pathVideo!=""){			
				if(file_exists($this->pathVideo)){
					return filesize($this->pathVideo);
				}
			}
			return false;
		}
		function doGenerateThumbnail(
			$timeOffset="", //$timeOffset → tipo: HH:MM:SS
			$pathOutput="" //$pathOutput → tipo .jpg (pequenos) ou .png(médios)
		){
			if($timeOffset=="" || $timeOffset=="00:00:00"){
				$timeOffset=$this->getTimeThumbnail();
			}
			if($pathOutput==""){
				$pathOutput=$this->getPathThumnail();
			}
			
			if($this->pathVideo!=""){			
				if(file_exists($this->pathVideo)){
					$resp=$this->setTimeThumbnail($timeOffset);
					if($resp==true){					
						$resp=$this->setPathThumbnail($pathOutput);
						if($resp==true){
							//ffmpeg -y -ss 00:00:05 -i "./susto_na_gordinha.webm" -vframes 1 "./video_thumbnails.jpg"
							//$comandos="ffmpeg -y -i \"".$this->pathVideo."\" -t \"$timeOffset\" -vframes 1 \"$pathOutput\"";
							$comandos="ffmpeg -y -ss $timeOffset -i \"".$this->pathVideo."\" -vframes 1 \"$pathOutput\"";
							echo($comandos."<br/>\n");
							exec($comandos);
							return true;
						}else{
							return $resp;
						}
					}else{
						return $resp;
					}
				}else{
					return "[ERRO=doGenerateThumbnail()] File '".$this->pathVideo."' not exist!";
				}
			}else{
				return "[ERRO=doGenerateThumbnail()] Please declare the video path!";
			}
		}
	}
?>
