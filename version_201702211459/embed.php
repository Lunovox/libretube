<?php
	/**************************************************************************
	* Código inspirado no tutorial https://www.youtube.com/watch?v=mUW3IqpAtH0
	* de Jeterson Lordano
	****************************************************************************/
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ALL | E_STRICT);
	error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	//ini_set('default_charset','utf-8');
	
	date_default_timezone_set("America/Recife"); //-0300
	
	require_once "libs/libGeral.php";
	require_once "libs/libDownloadLink.php";
	
	$id = Propriedade("video");
	$autoplay = Propriedade("autoplay")=="true";
	
	$myLinks = new DownLoadLink($id); 
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
						<?php } ?>
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
					<?=$myLinks->getVideoDescription();?><br/>
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
					<b>Barra de Espaço</b> → Play ou Pause. <br/>
					<b>Ctrl + Esqueda</b> → Volta 10 segundos. <br/>
					<b>Ctrl + Direita</b> → Avança 10 segundos. <br/>
					<b>Ctrl + Shift + Esqueda</b> → Volta 30 segundos. <br/>
					<b>Ctrl + Shift + Direita</b> → Avança 30 segundos. <br/>
					<b>[ + ]</b> → Uncrementa o volume. <br/>
					<b>[ &ndash; ]</b> → Decrementa o volume. <br/>
					<br/>
					
					<b>F1</b> → Tela de Atalhos (Essa que você está vendo!). <br/>
					<b>F2</b> → Tela de Compartilhamento. <br/>
					<b>F8</b> → Tela de Anexar Vídeo Externamente. <br/>
					<b>Ctrl + F1</b> → Informações sobre o arquivo de vídeo. <br/>
					<b>Ctrl + F2</b> → Descrição sobre o conteudo exibido vídeo. <br/>
					<b>Ctrl + F3</b> → Tela de Assinatura do Canal. <br/>
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
				<p align="justify">
					Copie e cole este código abaixo em seu site/blog para exibir este vídeo gratuitamente em seu site/blog:<br/>
					<br/>
					<div class="video-code">
						&lt;iframe allowtransparency=&quot;true&quot; allowfullscreen=&quot;true&quot; src=&quot;<?=$myLinks->getEmbedLink();?>&quot; style=&quot;width:760px; height:427px; border:0px;&quot;&gt;&lt;/iframe&gt;
					</div><br/>
				</p>
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
				<div class="video-embed-btn float-right video-btn"></div>
				<div class="video_share-btn float-right video-btn"></div>
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
