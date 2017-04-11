<?php 
	//session_cache_limiter('private'); 	/* Define o limitador de cache para 'private' */
	session_cache_expire(360); /* Define o limite de tempo do cache em 6 horas (360 minutos) */
	// Allow script to work long enough to upload big files (in seconds, 2 days by default)
	@set_time_limit(172800);
	session_start("tuatec-home");

	ini_set('display_errors', 'On'); 
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	error_reporting(E_ALL | E_STRICT);

	
	//ini_set('default_charset',"ISO-8859-15");
	ini_set('default_charset',"UTF-8");
	ini_set('upload_max_filesize',"2G");
	ini_set('post_max_size',"2G");
	ini_set('max_input_time',"86400");
	//ini_set('log_errors', false); 
	//ini_set('error_log', 'php_debug.txt'); 
	
	/*	FONTE dos atributos alteráveis por ini_set(): 
			* http://php.net/manual/en/ini.list.php
			* http://php.net/manual/en/configuration.changes.modes.php
	/**/
	
	//http://wbruno.com.br/php/imprimir-data-atual-em-portugues-php/
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); //<== Só funciona para formatação por "strftime()" e não por "date()"
	date_default_timezone_set('America/Recife');
	header("content-type: text/html");


	require_once "libs/libMySQL2.php";
	require_once "libs/libConversao.php";
	require_once "libs/libGeral.php";
	require_once "libs/libDownloadLink.php";

	
	
	$txtChannelName = "";
	$txtChannelTitle = "LIBRETUBE";
	//$imgLogotipo="imgs/banners/banner_libretube.png";
	$imgLogotipo = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).'imgs/banners/banner_libretube.png';
	
	$LunoMySQL = new LunoMySQL;

	if($LunoMySQL->ifAllOk()){
		$Configs=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."config");
		if(count($Configs)==1){
			$Config= $Configs[0];
		}

		$txtChannelName = isset($Config['ChannelName'])?$Config['ChannelName']:'';
		$txtChannelTitle=$txtChannelName!=""?$txtChannelName." - LIBRETUBE":"LIBRETUBE";
		//$urlLibretube=str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
		$urlLibretube = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
		//$imgLogotipo=(isset($Config['urlBanner']) && $Config['urlBanner']!="")?$Config['urlBanner']:($urlLibretube.'imgs/banners/banner_libretube.png');
		$imgLogotipo=(isset($Config['urlBanner']) && $Config['urlBanner']!="")?$Config['urlBanner']:$imgLogotipo;
		
	}/**/
	
if(Propriedade("video")!=""){
	echo "<script>window.location='?sub=video&id=".Propriedade("video")."';</script>";
}else{ ?>

<!DOCTYPE HTML>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8"/>
		<title><?=$txtChannelTitle;?></title>
		<LINK REL="shortcut icon" HREF="imgs/icons/sbl_libretube.png"/>
		<link 
			href="atom.php?order=recents" 
			type="application/atom+xml" 
			rel="alternate" 
			title="<?=$txtChannelTitle;?> - Vídeos Recentes" 
		/>
		<link 
			href="atom.php?order=mostviews" 
			type="application/atom+xml" 
			rel="alternate" 
			title="<?=$txtChannelTitle;?> - Vídeos Mais Vistos" 
		/>
		
		<link rel="search" type="application/opensearchdescription+xml" title="<?=$txtChannelTitle;?>" href="<?php
			echo 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", $_SERVER['SCRIPT_NAME']).'search_engine.php?update='.uniqid("SearchEngine_");
		?>">

		<link rel='shortlink' href="<?=$urlLibretube;?>" />
		
		<meta name="viewport" content="width=300"/>
		<!-- link_ rel="stylesheet" href="estilo_mobile.css?update=<?=date('Y-m-d H:i:s');?>" media="(max-width:380px)" -->
		<link rel="stylesheet" href="estilo_geral.css?update=<?=date('Y-m-d H:i:s');?>" media="screen"/>
		
		<script>
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
		</script>
		<script language="JavaScript" src_="libs/libDebug.js"></script>
		<script language="JavaScript" src="libs/functions.js"></script>
		<script language="JavaScript" src="libs/libSearch.js"></script>
	</head>
	<body>

		<header>
			<!--a href="?sub=home"-->
				<img src="<?=$imgLogotipo;?>" style="margin:10px"/>
			<!--/a-->
		</header>
		
		<?php if($LunoMySQL->ifAllOk()){ ?>
			<center>
				<?php require_once "menu.php";?>
			</center>
		<?php } ?>
		
		<session id="frmCorpo">
			<?php 
				if(!$LunoMySQL->ifAllOk()){
					//echo "[index.php] Falha de banco de dados! => !\$LunoMySQL->ifAllOk()";
					require_once "subs/install.php";
				}else{
					echo "<!-- sub=".Propriedade("sub")." -->";
					$sub=Propriedade("sub")!=""?Propriedade("sub"):"home";
					$url="subs/$sub.php";
					$url=file_exists($url)?$url:"subs/erro.php";
					require_once $url;
				}/**/
			?>
		</session>
		
		<br/><br/><!-- é necessário um espaço entre o session e o footer-->
		
		<footer>
			<a href="?sub=about" rel="jslicense">Sobre</a> | 
			<?php if(!isLoged()){ ?>
				<a href="?sub=log" >Entrar</a>
			<?php }else{ ?>
				<a href="?sub=log-out" >Sair</a>
			<?php } ?>
		</footer>
	</body>
</html>
<?php } ?>
