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
	//require_once "libs/libGeral.php";

	function getAtomLink($format='xml', $order='recents'){
		if(!isset($order) || $order=="mostviews"){
			return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."atom.php?order=$order".($format=='xml'?"":"&format=$format");
		}else{
			return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."atom.php".($format=='xml'?"":"?format=$format");
		}
	}

	class DownLoadLink{
		var $id=0; //Id do vídeo do banco de dados MySQL
		var $video; //Informações sobre link de arquivos, como: video, poster, subtitle(legendas)
		var $config; //Informações sobre o Canal, como: Titulo, Logotipo
		
		function DownLoadLink($VideoID){
			$resp = $this->doConfig();
			if($resp==true){
				$resp = $this->setID($VideoID);
				if($resp==true){
					$resp = $this->setVídeo($VideoID);
					if($resp!=true){echo("$resp");}
				}else{echo("$resp");}
			}else{echo("$resp");}
		}
// ########### FUNÇÕES INTERNAS ########################################################################################################
		function setID($VideoID){
			if(isset($VideoID) && $VideoID>=1){
				$this->id = $VideoID;
				return true;
			}
			return "[ERRO] DownLoadLink->setID()] Format of var '\$VideoID' no is valid with value '$VideoID'!";
		}
		function getID(){
			return $this->id;
		}
		function setVídeo($VideoID){
			$LunoMySQL = new LunoMySQL;
			if($LunoMySQL->ifAllOk()){
				$V=null;
				/*
				if(getLogedType()=="owner" || getLogedType()=="moderator"){
					$V = $LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $VideoID");
				}else{
					$V = $LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $VideoID AND timePublish IS NOT NULL");
				}
				/**/
				$V = $LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $VideoID");
				if(count($V)==1){
					$this->video = $V[0];
					return true;
				}else{
					return "[ERRO:DownLoadLink->setVídeo()] Não existe vídeo com ID='$VideoID'!";
				}
			}else{
				return "[ERRO:DownLoadLink->setVídeo()] \$LunoMySQL->ifAllOk() == false;";
			}
			return false;
		}
		function getVídeo(){
			return $this->video;
		}
		function doConfig(){
			$LunoMySQL = new LunoMySQL;
			if($LunoMySQL->ifAllOk()){
				$Configs=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."config");
				if(count($Configs)==1){
					$this->config= $Configs[0];
					return true;
				}else{
					return "[ERRO:DownLoadLink->doConfig()] Não foi possivel abrir o arquivo de configurações!";
				}
			}else{
				return "[ERRO:DownLoadLink->doConfig()] \$LunoMySQL->ifAllOk() == false;";
			}
			return false;
		}
// ########### RESULTADO FINAL ########################################################################################################
		function getVídeoLink(){
			$V = $this->getVídeo();
			if($V['videoTypeLink']=="remote"){
				return $V['urlVideo'];
			}elseif($V['videoTypeLink']=="local"){
				return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."download.php?type=video&id=".$V['ID'];
			}
		}
		function getRedirectShortLink(){
			return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."?video=".$this->getID();
		}
		function getEmbedLink(){
			return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."embed.php?video=".$this->getID();
		}
		function getVídeoBase(){
			$V = $this->getVídeo();
			if($V['videoTypeLink']=="remote"){
				return basename($V['urlVideo']);
			}elseif($V['videoTypeLink']=="local"){
				$file = $V['urlVideo'];
				//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
				//print_r(pathinfo($file));
				$extension = @pathinfo($file)['extension'];
				//$txtNameVideo = basename($file).".".$extension;
				return basename(str_replace(" ", "_", $V['Title'])).".".($extension!=""?$extension:"vid");
			}
		}
		function getVídeoMimetype(){
			$V = $this->getVídeo();
			if($V['videoTypeLink']=="remote"){
				return "video/ogg";
			}elseif($V['videoTypeLink']=="local"){
				$file = $V['urlVideo'];
				//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
				//print_r(pathinfo($file));
				$extension = @pathinfo($file)['extension'];
				return "video/".($extension!=""?$extension:"ogg");
			}
		}
		function getPosterLink(){
			$V = $this->getVídeo();
			if($V['posterTypeLink']=="remote"){
				return $V['urlPoster'];
			}elseif($V['posterTypeLink']=="auto" || $V['posterTypeLink']=="local"){
				return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."download.php?type=poster&id=".$V['ID'];
			}
		}
		function getPosterBase(){
			$V = $this->getVídeo();
			if($V['videoTypeLink']=="remote"){
				return basename($V['urlPoster']);
			}elseif($V['videoTypeLink']=="auto" || $V['videoTypeLink']=="local"){
				$file = $V['urlPoster'];
				//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
				$extension = @pathinfo($file)['extension'];
				//$txtNameVideo = basename($file).".".$extension;
				return basename(str_replace(" ", "_", $V['Title'])).".".($extension!=""?$extension:"img");
			}
		}
		function getSubtitleLink(){
			$V = $this->getVídeo();
			if($V['subtitleTypeLink']=="remote"){
				return $V['urlSubtitle'];
			}elseif($V['subtitleTypeLink']=="local"){
				return 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."download.php?type=subtitle&id=".$V['ID'];
			}else{ // $V['subtitleTypeLink']=="none"
				return "";
			}
		}
		function getSubtitleBase(){
			$V = $this->getVídeo();
			if($V['videoTypeLink']=="remote"){
				return basename($V['urlSubtitle']);
			}elseif($V['videoTypeLink']=="local"){
				$file = $V['urlSubtitle'];
				//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
				$extension = @pathinfo($file)['extension'];
				//$txtNameVideo = basename($file).".".$extension;
				return basename(str_replace(" ", "_", $V['Title'])).".".($extension!=""?$extension:"vtt");
			}else{ // $V['subtitleTypeLink']=="none"
				return "";
			}
		}
		function getDiasporaLink(){
			$V = $this->getVídeo();
			$LinkDispora = "http://sharetodiaspora.github.io/?title=".
			rawurlencode(
				"![](".$this->getPosterLink().")\n\n".
				"## [".(utf8_encode($V['Title']))."](".$this->getRedirectShortLink().")\n\n"
				.(utf8_encode($V['Description']))."\n_____\n\n Hashtags: ".
				(@$this->config['ChannelName']!=''?'#'.str_replace(" ","",@$this->config['ChannelName']).' ':'')
				." #Libretube"
			)."&markdown=true&jump=doclose"; 
			return $LinkDispora;
		}
		function getVideoTitle(){
			$V = $this->getVídeo();
			return $V['Title'];
		}
		function getVideoDescription(){
			$V = $this->getVídeo();
			return $V['Description'];
		}
		function getVideoTypeLink(){
			$V = $this->getVídeo();
			return $V['videoTypeLink'];
		}
		function getPosterTypeLink(){
			$V = $this->getVídeo();
			return $V['posterTypeLink'];
		}
		function getSubtitleTypeLink(){
			$V = $this->getVídeo();
			return $V['subtitleTypeLink'];
		}
		function getVideoViews(){
			$V = $this->getVídeo();
			return $V['views'];
		}
		function getVideoTimeRegistration(){
			$V = $this->getVídeo();
			return $V['timeRegistration'];
		}
		function getVideoTimePublish(){
			$V = $this->getVídeo();
			return $V['timePublish'];
		}
		function getVideoTimeUpdate(){
			$V = $this->getVídeo();
			return $V['timeUpdate'];
		}
	}

?>
