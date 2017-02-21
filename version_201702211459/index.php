<?php 
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	error_reporting(E_ALL | E_STRICT);

	//session_cache_limiter('private'); 	/* Define o limitador de cache para 'private' */
	session_cache_expire(360); /* Define o limite de tempo do cache em 6 horas (360 minutos) */
	session_start("tuatec-home");
	
	//ini_set('default_charset',"ISO-8859-15");
	ini_set('default_charset',"UTF-8");
	ini_set('upload_max_filesize',"2G");
	ini_set('post_max_size',"2G");
	ini_set('max_input_time',"86400");
	
	
	
	header("content-type: text/html");
	date_default_timezone_set("America/Recife"); //-0300

	//ini_set('log_errors', false); 
	//ini_set('error_log', 'php_debug.txt'); 

	require_once "libs/libMySQL2.php";
	require_once "libs/libConversao.php";
	require_once "libs/libGeral.php";
	
	
	$txtChannelName = "";
	$txtChannelTitle = "LIBRETUBE";
	$imgLogotipo="imgs/banners/banner_libretube.png";
	
	$LunoMySQL = new LunoMySQL;

	if($LunoMySQL->ifAllOk()){
		$Configs=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."config");
		if(count($Configs)==1){
			$Config= $Configs[0];
		}

		$txtChannelName = isset($Config['ChannelName'])?$Config['ChannelName']:'';
		$txtChannelTitle=$txtChannelName!=""?$txtChannelName." - LIBRETUBE":"LIBRETUBE";
		$urlLibretube=str_replace("index.php","",$_SERVER['SCRIPT_NAME']);
		$imgLogotipo=(isset($Config['urlBanner']) && $Config['urlBanner']!="")?$Config['urlBanner']:($urlLibretube.'imgs/banners/banner_libretube.png');
		
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
		<link href="atom.php" type="application/atom+xml" rel="alternate" title="<?=$txtChannelTitle;?>" />
		
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
			<a href="?sub=license" rel="jslicense">Licença</a> | <!--a href="?sub=soucecode" >Código Fonte</a--> | 
			<?php if(!isLoged()){ ?>
				<a href="?sub=log" >Entrar</a>
			<?php }else{ ?>
				<a href="?sub=log-out" >Sair</a>
			<?php } ?>
		</footer>
	</body>
</html>
<?php } ?>