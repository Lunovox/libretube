<?php
	//session_cache_limiter('private'); 	/* Define o limitador de cache para 'private' */
	session_cache_expire(360); /* Define o limite de tempo do cache em 6 horas (360 minutos) */
	// Allow script to work long enough to upload big files (in seconds, 2 days by default)
	@set_time_limit(172800);
	ini_set('display_errors', 'On'); 
	error_reporting(E_ALL | E_STRICT);
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	ini_set('default_charset',"UTF-8");
	//ini_set('default_charset',"ISO-8859-15");
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
	date_default_timezone_set("America/Recife");
	header("content-type: text/html");

	
	require_once "libs/libGeral.php";
	require_once "libs/libDownloadLink.php";
	
	$id = Propriedade("video");
	$autoplay = Propriedade("autoplay")=="true";
	
	$myLinks = new DownLoadLink($id); 

	/**************************************************************************
	* Código inspirado no tutorial https://www.youtube.com/watch?v=mUW3IqpAtH0
	* de Jeterson Lordano
	****************************************************************************/
?>

<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="utf-8"/>
		<title>Embed de Vídeo</title>
		<link rel="stylesheet" href="libs/estilo_embed.css" type="text/css" /> 
		<script src="libs/lib_embed.js"></script>
		<script src="libs/functions.js"></script>
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
	</head>
	<body oncontextmenu="return false;">
		<div id="idVideo" class="player-video" onmousemove="prepare(this)" onload="prepare(this)">
			<video 
				class="video-view" 
				<?=($autoplay?"autoplay":"");?> 
				poster="<?=$myLinks->getPosterLink();?>" 
			>
				<source src='<?=$myLinks->getVídeoLink();?>' type="<?=$myLinks->getVídeoMimetype();?>">
				<?php 
				if(trim($myLinks->getSubtitleLink())!=""){ ?>
					<track src="<?=trim($myLinks->getSubtitleLink());?>#.vtt" kind="subtitles" label="Português" srclang="pt" default />
				<?php } ?>
				Infelizmente seu navegador não suporta a tag "VIDEO".
			</video> 
			
			<div class="video-preloader"></div>

				
			<div class="video-share">
				<center>
					<h2>
						<img src="imgs/icons/sbl_share.png" class="icon-title"/>
						COMPARTILHE ESTE VÍDEO
					</h2>
					<br/>
					<?php 
						if(($myLinks->getVideoTimePublish() !=NULL && $myLinks->getVideoTimePublish()!="") || Propriedade("auth")==$myLinks->getEmbedAuth()){
					?>
						<img class="icon-btn"
							title="Compartilhe este vídeo em sua Rede Social Diáspora!"
							src="imgs/icons/sbl_share_diaspora.png" type="button"
							onclick="openPopupCenter('<?=$myLinks->getDiasporaLink();?>','_blank', 880, 600);"
						/><img class="icon-btn"
							title="Compartilhe este vídeo em seu Twitter!"
							src="imgs/icons/sbl_share_twitter.png" type="button"
							onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 720, 450);"
						/><img class="icon-btn"
							title="Compartilhe este vídeo em seu Facebook!"
							src="imgs/icons/sbl_share_facebook.png" type="button"
							onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 360, 300);"
						/>
					<?php }else{ ?>
						Você não tem permissão para compartilhar publicamente este [<b>Vídeo Privado</b>]!
					<?php } ?>
				<center>
			</div>
			
			<div class="video-feed">
				<center>
					<h2>
						<img src="imgs/icons/sbl_file_rss.gif" class="icon-title"/>
						ASSINE E RECEBA NOTÍCIAS DESTE CANAL
					</h2>
					<img src="imgs/selos/sbl_add2feedreader_nextcloud.png" type="button" class="selo-btn"
						title="Assine e Receba notícias periódicas deste canal no NextCloud do Disroot!"
						onclick="window.open('https://cloud.disroot.org/apps/news/?subscribe_to=<?=rawurlencode(getAtomLink('xml'));?>');"
					/>
					<img src="imgs/selos/sbl_add2feedreader_theoldreader.png" type="button" class="selo-btn"
						title="Assine e Receba notícias periódicas deste canal no TheOldReader!"
						onclick="window.open('http://theoldreader.com/feeds/subscribe?url=<?=rawurlencode(getAtomLink('xml'));?>');"
					/>
					<img src="imgs/selos/sbl_add2feedreader_anybrowser.png"  type="button" class="selo-btn"
						title="Assine e Receba notícias periódicas deste canal em diversos outros agregadores!"
						onclick="openPopupCenter('https://www.subtome.com/#/subscribe?feeds=<?=rawurlencode(getAtomLink('xml'));?>','_blank', 500, 370);"
					/><br/>

					<code><?=getAtomLink('xml');?></code><br/>

					<img src="imgs/selos/sbl_feed_atom.png" type="button" class="selo-btn"
						title="Assine e Receba notícias periódicas deste canal no seu Navegador!"
						onclick="window.open('<?=getAtomLink('xml');?>');"
					/>
				</center>
			</div>
			
			<div class="video-download">
				<center>
					<h2>
						<img src="imgs/icons/sbl_file_download.gif" class="icon-title" /> 
						SOBRE ESTE VÍDEO
					</h2>
					
					<table>
						<tr>
							<td align="right"><b><nobr>Visualizações:</nobr></b></td>
							<td style="padding:0px 3px  0px  3px; text-align:left;">
								<nobr>
									<?=$myLinks->getVideoViews();?> vezes
								</nobr>
							</td>
						</tr>
						<tr>
							<td align="right"><b><nobr>Upload:</nobr></b></td>
							<td style="padding:0px 3px  0px  3px; text-align:left;">
								<nobr>
									<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($myLinks->getVideoTimeRegistration()));?>
								</nobr>
							</td>
						</tr>
						<tr>
							<td align="right"><b><nobr>Publicação:</nobr></b></td>
							<td style="padding:0px 3px  0px  3px; text-align:left;">
								<nobr>
									<?=($myLinks->getVideoTimePublish()!=""?strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($myLinks->getVideoTimePublish())):"<font color='#FF0000'><b>Vídeo Privado</b></font>");?>
								</nobr>
							</td>
						</tr>
						<tr>
							<td align="right"><b><nobr>Atualizado:</nobr></b></td>
							<td style="padding:0px 3px  0px  3px; text-align:left;">
								<nobr>
									<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($myLinks->getVideoTimeUpdate()));?>
								</nobr>
							</td>
						</tr>
						<?php 
							if(($myLinks->getVideoTimePublish() !=NULL && $myLinks->getVideoTimePublish()!="") || Propriedade("auth")==$myLinks->getEmbedAuth()){
						?>
							<tr>
								<td align="right"><nobr><b>Vídeo (<?=$myLinks->getVideoTypeLink();?>):</b></nobr></td>
								<td style="padding:0px 3px  0px  3px; text-align:left;">
									<a target="_blank" <?="href='".$myLinks->getVídeoLink()."'";?>><?=$myLinks->getVídeoBase();?></a>
								
								</td> 
							</tr>
							<tr>
								<td align="right"><nobr><b>Poster (<?=$myLinks->getPosterTypeLink();?>):</b> </nobr></td>
								<td style="padding:0px 3px  0px  3px; text-align:left;">
									<a target="_blank" href="<?=$myLinks->getPosterLink();?>"><?=$myLinks->getPosterBase();?></a>
								</td> 
							</tr>
							<?php if($myLinks->getSubtitleTypeLink()!="none"){ ?>
								<tr>
									<td align="right"><nobr><b>Legenda (<?=$myLinks->getSubtitleTypeLink();?>):</b> </nobr></td>
									<td style="padding:0px 3px  0px  3px; text-align:left;">
										<a target="_blank" href="<?=$myLinks->getSubtitleLink();?>"><?=$myLinks->getSubtitleBase();?></a>
									</td> 
								</tr>
							<?php } 
						} ?>
					</table>
				</center>
			</div> <!-- Fim de div video-download-->
			
			<div class="video-description">
				<center>
					<h2>
						<img src="imgs/icons/sbl_informacao.gif" class="icon-title" /> 
						<?=strtoupper($myLinks->getVideoTitle());?><br/>
					</h2>
				</center>
				<br/>
				<p align="justify">
					<?php
						$Conteudo=$myLinks->getVideoDescription();
						$Conteudo=str_replace("&#039;", "'", $Conteudo);
						echo getMakeLinks($Conteudo);
					?><br/>
					<br/>
				</p>
			</div> <!-- Fim de div video-download-->
			
			<div class="video-help">
				<center>
					<h2>
						<img src="imgs/icons/sbl_about.png" class="icon-title" /> 
						ATALHOS<br/>
					</h2>
				</center>
				<br/>
				<p align="justify">
					<b>F1</b> → Tela de Atalhos (Essa que você está observando!). <br/>
					<b>F2</b> → Descrição sobre o conteudo exibido vídeo. <br/>
					<b>F8</b> → Tela de Anexar Vídeo Externamente. <br/>
					<b>Ctrl + F1</b> → Informações sobre o arquivo de vídeo. <br/>
					<b>Ctrl + F2</b> → Tela de Compartilhamento. <br/>
					<b>Ctrl + F3</b> → Tela de Assinatura do Canal. <br/>
					<br/>

					<b>Barra de Espaço</b> → Play ou Pause. <br/>
					<b>[ + ]</b> → Uncrementa o volume. <br/>
					<b>[ &ndash; ]</b> → Decrementa o volume. <br/>
					<b>Ctrl + Esqueda</b> → Volta 10 segundos. <br/>
					<b>Ctrl + Direita</b> → Avança 10 segundos. <br/>
					<b>Ctrl + Shift + Esqueda</b> → Volta 30 segundos. <br/>
					<b>Ctrl + Shift + Direita</b> → Avança 30 segundos. <br/>
					<br/>					
				</p>
			</div> <!-- Fim de div video-help-->
			
			<div class="video-embed">
				<center>
					<h2>
						<img src="imgs/icons/sbl_embed_code.png" class="icon-title" /> 
						ANEXAR VIDEO EXTERNAMENTE<br/>
					</h2>
				</center>
				<br/>
				<?php 
					if(($myLinks->getVideoTimePublish() !=NULL && $myLinks->getVideoTimePublish()!="") || Propriedade("auth")==$myLinks->getEmbedAuth()){
				?>
					<p align="justify">
						Copie e cole este código abaixo em seu site/blog para exibir este vídeo gratuitamente em seu site/blog:<br/>
						<br/>
						<div class="video-code">
							&lt;iframe allowtransparency=&quot;true&quot; allowfullscreen=&quot;true&quot; src=&quot;<a target="_blank" href="<?=$myLinks->getEmbedLink();?>"><?=$myLinks->getEmbedLink();?></a>&quot; style=&quot;width:760px; height:427px; border:0px;&quot;&gt;&lt;/iframe&gt;
						</div><br/>
					</p>
				<?php }else{ ?>
					<center>
						Você não tem permissão para anexar publicamente este [<b>Vídeo Privado</b>]!
					</center>
				<?php } ?>
			</div> <!-- Fim de div video-embed-->

			<div class="video-controls">
				
				<div class="video-progress-bar float-left">
					<div class="video-loader"></div>
					<div class="video-progress"></div>
				</div>
				
				<div class="video-play float-left video-btn"></div>
				<div class="video-screens float-left video-btn"></div>
				<div class="video-volume float-left video-btn"></div>
				<div class="slider float-left">
					<div class="slider-vol"></div>
				</div>
				<div class="video-time float-left">LIBRETUBE</div>

				<div 
					class="video-libretube_link float-right video-btn"
					<?=$autoplay?"style='display:none;' ":'';?>
					href="<?=$myLinks->getRedirectShortLink();?>"
				></div>
				<div class='video-embed-btn float-right video-btn' <?php 
					echo (
						($myLinks->getVideoTimePublish()==NULL 
						|| $myLinks->getVideoTimePublish()=="")
						&& Propriedade("auth")!=$myLinks->getEmbedAuth()
					)?"style='display:none;' ":"";
				?>></div>
				<div class="video_share-btn float-right video-btn" <?php 
					echo (
						$myLinks->getVideoTimePublish()==NULL 
						|| $myLinks->getVideoTimePublish()==""
						|| Propriedade("auth")!=$myLinks->getEmbedAuth()
					)?"style='display:none;' ":"";
				?>></div>
				<div class="video_feed-btn float-right video-btn"></div>
				<div class="video-download-btn float-right video-btn"></div>
				<div 
					class="video-description-btn float-right video-btn" 
					<?=$autoplay?"style='display:none;' ":'';?>
				></div>
			</div>
			
			<div class="clear"></div>
		</div>
	</body>
</html>
