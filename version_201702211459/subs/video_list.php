<?php
	$order = Propriedade("order");
	$QtdPerPage = 12;
	$page = intval(Propriedade("page"));
	$QtdVideos = 0;
	if($order=="mostviews"){
		$QtdVideos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "views DESC", "COUNT(*) AS QTD")[0]['QTD'];
		$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "views DESC", null, $page*$QtdPerPage, $QtdPerPage);
		$TitlePage = "MAIS VISTOS";
	}elseif($order=="privates" && (getLogedType()=="owner" || getLogedType()=="moderator")){
		$QtdVideos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NULL",  "timePublish DESC, timeUpdate DESC", "COUNT(*) AS QTD")[0]['QTD'];
		$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NULL",  "timePublish DESC, timeUpdate DESC", null, $page*$QtdPerPage, $QtdPerPage);
		$TitlePage = "PRIVADOS";
	}else{
		$QtdVideos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "timePublish DESC, timeUpdate DESC", "COUNT(*) AS QTD")[0]['QTD'];
		//$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "timePublish DESC, timeUpdate DESC", null, $page*$QtdPerPage, intval($page*$QtdPerPage)+$QtdPerPage);
		$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "timePublish DESC, timeUpdate DESC", null, $page*$QtdPerPage, $QtdPerPage);
		$order="recents";
		$TitlePage = "RECENTES";
	}
	//print_r($QtdVideos);
	//echo $page;
?>

<div>
	<br/>
	<center>

		<?php if(Propriedade("aviso")!=""){ ?>
			<div align="center" style="background-color:#FFFF00; border-color:#000000; border-width:1px; border-style:dashed;">
				<h2><?php
					$Aviso=strip_tags(Propriedade("aviso"));
					$Aviso=str_replace("[FORBIDDEN]", "<img width='200' src='imgs/modelos/sbl_forbidden.png'/><br/>" , $Aviso);
					echo $Aviso
				?></h2>
			</div>
			<br/>
		<?php } ?>

		<h1>VÍDEOS <?=$TitlePage;?></h1>
		<div style="display:inline-block; padding:3px; background-color:rgba(128,128,128,0.8); border:1px solid #c0c0c0; border-radius:5px;">
			<h2><?php 
				if($page>0){ 
					?><button align="top" style="border-radius:5px;"
					onclick="window.location='?sub=video_list&order=<?=$order;?>&page=0';"
					> << </button><button align="top" style="border-radius:5px;"
					onclick="window.location='?sub=video_list&order=<?=$order;?>&page=<?=$page-1;?>';"
					> < </button><?php 
				} 
				echo " ".($page+1)."/".ceil($QtdVideos/$QtdPerPage)." ";
				if(
					//($page*$QtdPerPage)+$QtdPerPage<$QtdVideos
					$page < ceil($QtdVideos/$QtdPerPage)-1
				){ 
					?><button align="top" style="border-radius:5px;"
					onclick="window.location='?sub=video_list&order=<?=$order;?>&page=<?=$page+1;?>';"
					> > </button><button align="top" style="border-radius:5px;"
					onclick="window.location='?sub=video_list&order=<?=$order;?>&page=<?=(ceil($QtdVideos/$QtdPerPage)-1);?>';"
					> >> </button><?php 
				} 
			?></h2>
		</div>
		<?php if($order!="privates"){?>
			<br/><br/>
			<img src="imgs/icons/sbl_file_rss.gif"
				style="cursor:pointer;" align="absmiddle"
				title="Assine o 'Feed RSS' a lista de vídeos deste canal!"
				onclick="openPopupCenter('https://www.subtome.com/#/subscribe?feeds=<?=rawurlencode(getAtomLink('xml',$order));?>','_blank', 500, 370);"
			/>  
			<?php
				$urlShare = $urlLibretube.'?sub=video_list&order='.$order;
				//$LinkDispora = "https://diasporabrazil.org/bookmarklet?title=".
				$LinkDispora = "http://sharetodiaspora.github.io/?title=".
				rawurlencode(
					"[".
						"![".$txtChannelTitle.' - '.$TitlePage."](".$imgLogotipo.")".
					"](".$urlShare.")".
					"\n## [".
						$txtChannelTitle.' - '.$TitlePage.
					"](".$urlShare.")\n\n".
					"Hashtags: ".(@$Config['ChannelName']!=''?'#'.str_replace(" ","",@$Config['ChannelName']).' ':'')." #Libretube"
				)."&markdown=true&jump=doclose";
			
			;?>
			<img src="imgs/icons/sbl_share_diaspora.png"
				style="cursor:pointer;" align="absmiddle"
				title="Compartilhe em sua Rede Social Diáspora a lista de vídeos mais vistos deste canal!"
				onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 880, 600);"
			/>
		
			<img src="imgs/icons/sbl_share_twitter.png"
				style="cursor:pointer;" align="absmiddle"
				title="Compartilhe em seu Twitter a lista de vídeos mais vistos deste canal!"
				onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($urlShare);?>','_blank', 720, 450);"
			/>

			<img src="imgs/icons/sbl_share_facebook.png"
				style="cursor:pointer;" align="absmiddle"
				title="Compartilhe em seu Facebook a lista de vídeos mais vistos deste canal!"
				onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($urlShare);?>','_blank', 360, 300);"
			/>
			<br/><br/>
		<?php } ?>
	</center>
</div>

<?php
	function getLinkURL($Video){
		if($Video['videoTypeLink']=="local" || $Video['videoTypeLink']=="remote"){
			return "?sub=video&id=".$Video['ID'];
		}else{ //se for "redirect"
			return $Video['urlVideo'];
		}
	};
	
	function printLink($Video){
		if($Video['videoTypeLink']=="local" || $Video['videoTypeLink']=="remote"){
			echo "window.location='?sub=video&id=".$Video['ID']."';";
		}else{ //se for "redirect"
			echo "window.open('".$Video['urlVideo']."', '_blank');";
		}
	};
?>
<script language="JavaScript">
	function doDelete($ID,$Redirect){
		if(confirm('Deseja realmente apagar este vídeo?')){
			window.location='?sub=video_delete&id='+$ID+'&redirect='+$Redirect;
		}
	}

	function showStatus($Text){
		//var status = instanceOfMozVoicemailEvent.status;
		//status.value = $Text;
		document.getElementsByTagName("title")[0].innerHTML = $Text;
		//window.status = $Text;
		//alert($Text);
	}
	
	var liberate = true;
	function showFront($BackName, $FrontName){
		if(liberate){
			liberate = false;
			
			var objFront = document.getElementById($FrontName);
			var objBack = document.getElementById($BackName);
		
			objBack.style.display = "none";
			objFront.style.display = "inline-block";
		
			liberate = true;
		}
		
	}
	function showFrontAll(){
		<?php for($V=0; $V<count($Videos); $V++){ ?>
		showFront('divBack<?=$Videos[$V]['ID'];?>', 'divFront<?=$Videos[$V]['ID'];?>');
		<?php } ?>
	}
	function showBack($FrontName, $BackName){
		if(liberate){
			showFrontAll();
			liberate = false;
			
			var objFront = document.getElementById($FrontName);
			var objBack = document.getElementById($BackName);
		
			objFront.style.display = "none";
			//objBack.style = objFront.style;
			objBack.style.overflow = "auto";
			//objBack.style.width = objFront.style.width;
			//objBack.style.height = objFront.style.height;
			objBack.style.height = "200px";
			objBack.style.display = "inline-block";
		
			liberate = true;
		}
	}
</script>

<center>
	<?php
		for($V=0; $V<count($Videos); $V++){ ?>
			<div 
				id="divFront<?=$Videos[$V]['ID'];?>" 
				class="<?=(($Videos[$V]['videoTypeLink']!='redirect' && $Videos[$V]['timePublish']!='')?'VideoList':'VideoListOff');?>"
			>
				<div>
					<div onclick="<?php printLink($Videos[$V]); ?>">
						<!--
						<video 
							style="width:260px; height:168px"
							controls-off autoplay-off 
							poster="<?php echo $Videos[$V]['urlPoster']; ?>" 
						><source src="<?=$Videos[$V]['urlVideo'];?>" type="video/ogg"></video>
						-->
						<img style="width:260px; height:168px" src="<?=$Videos[$V]['urlPoster'];?>"/>
						<uppercase>
							<b><?php echo $Videos[$V]['Title'];/**/ /*utf8_encode($Videos[$V]['Title']); /**/ ?></b>
						</uppercase>
	 				</div>

					<div>
						<small>
							<?php
								if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
									<img size='16x16' src='imgs/icons/sbl_filme.gif'  title="Número do Vídeo!" /> nº<?=$Videos[$V]['ID'];?> <?php
								}
								
								if($Videos[$V]['videoTypeLink']=="local" || $Videos[$V]['videoTypeLink']=="remote"){
									if($Videos[$V]['views']>=1){ ?>
										<img size='16x16' src='imgs/icons/sbl_olho.png' title="Número de visualizações!" /> <?php
										echo " x".sprintf("%03d",$Videos[$V]['views']);
									} 
									
									$qtdComments = $LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."comments", "VideoID=".$Videos[$V]['ID'],  "timePublish DESC", "COUNT(*) AS QTD")[0]['QTD'];
									if($qtdComments>=1){ ?>
										<img size='16x16' src='imgs/icons/sbl_comentario.gif' title="Número de Comentários!" /> <?php
										echo $qtdComments;
									}
								}else{ ?>
									<img size='16x16' src='imgs/icons/sbl_olho.png' title="Número de visualizações!" /> <?php
									echo "Vídeo Externo";
								}
							
							?>
							<?php if($Videos[$V]['Description']!=""){ ?>
							<img 
								size='16x16' src='imgs/icons/sbl_lupa.gif' 
								title="Exibir descrição de vídeo!"
								onclick="showBack('divFront<?=$Videos[$V]['ID'];?>', 'divBack<?=$Videos[$V]['ID'];?>');"
							/>
							<?php } ?>
						</small>
					</div>
				</div>
			</div>
			<div id="divBack<?=$Videos[$V]['ID'];?>"
				class="VideoListDesc" style="display:none; overflow:auto; width:90%; height:200px; max-height:200px; text-align:justify;"
				onmouseout_="showFront('divBack<?=$Videos[$V]['ID'];?>', 'divFront<?=$Videos[$V]['ID'];?>');"
			>
				<div onclick="<?php printLink($Videos[$V]); ?>">
					<center>
						<uppercase>
							<b><?php echo $Videos[$V]['Title'];/**/ /*utf8_encode($Videos[$V]['Title']); /**/ ?></b>
						</uppercase>
					</center>
				</div>
				
				
				
				
				<?php if($Videos[$V]['timePublish']!=''){?>
					<?php
						$myLinks = new DownLoadLink($Videos[$V]['ID']); 
					;?>
					<hr/>
					<center>
						<img src="imgs/icons/sbl_share_diaspora.png"
							style="cursor:pointer;" align="absmiddle"
							title="Compartilhe em sua Rede Social Diáspora a lista de vídeos mais vistos deste canal!"
							onclick="openPopupCenter('<?=$myLinks->getDiasporaLink();?>','_blank', 880, 600);"
						/>

						<img src="imgs/icons/sbl_share_twitter.png"
							style="cursor:pointer;" align="absmiddle"
							title="Compartilhe em seu Twitter a lista de vídeos mais vistos deste canal!"
							onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 720, 450);"
						/>

						<img src="imgs/icons/sbl_share_facebook.png"
							style="cursor:pointer;" align="absmiddle"
							title="Compartilhe em seu Facebook a lista de vídeos mais vistos deste canal!"
							onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 360, 300);"
						/>
					</center>
				<?php } ?>
				
				<hr/>
				<div onclick="<?php printLink($Videos[$V]); ?>">
					<?php
						$Conteudo = $Videos[$V]['Description'];
						$Conteudo=str_replace("&#039;", "'", $Conteudo);
						$hashtags = getHashtags($Conteudo);
						for($H=0; $H<count($hashtags); $H++){
							$Conteudo = str_replace(
								"#".$hashtags[$H],
								"<a href='?sub=search&q=%23".strtolower($hashtags[$H])."'>#".$hashtags[$H]."</a>",
								$Conteudo
							);
						}
						echo $Conteudo;
					?>
				</div>
				
				
				<?php if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
					<br/><br/>
					<center>
						<button
							title="Edita este video!"
							onclick="window.location='?sub=video_edit&id=<?=$Videos[$V]['ID'];?>';"
						>
							<img 
								src="imgs/icons/sbl_lapis.gif" 
								align="absmiddle"
							/> Editar
						</button>
						<button onclick="doDelete(<?=$Videos[$V]['ID'];?>,<?="'".urlencode($_SERVER['QUERY_STRING'])."'";?>)">
							<img src="imgs/icons/sbl_negar.gif" align="absmiddle" />
							Apagar
						</button>
						<button
							title="Adicione este vídeo a uma Lista!"
							onclick="openPopupCenter('playlist_form.php?id=<?=$Videos[$V]['ID'];?>','_blank', 330, 330);"
						>
							<img src="imgs/icons/sbl_percevejo.gif" align="absmiddle" /> +Lista
						</button>
						<button onclick="if(confirm('Deseja realmente <?=($Videos[$V]['timePublish']!=''?'privatizar':'publicar');?> este vídeo?')){window.location='?sub=video_access&set=<?=($Videos[$V]['timePublish']!=''?'private':'public');?>&id=<?=$Videos[$V]['ID'];?>';}">
							<img src="imgs/icons/<?=($Videos[$V]['timePublish']!=''?'sbl_cadeado_preto.gif':'sbl_planeta.gif');?>" align="absmiddle" />
							<?=($Videos[$V]['timePublish']!=''?'Privatizar':'Publicar');?>
						</button>
						<button
							title="Compartilhe este video em seu Diáspora!"
							<?php
								$longlinkvideo = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
								$shortlinkvideo = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).'?video='.$Videos[$V]['ID'];
								if($Videos[$V]['posterTypeLink']=="auto" || $Videos[$V]['posterTypeLink']=="local"){
									$urlLongPoster = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).$Videos[$V]['urlPoster'];
								}else if($Videos[$V]['posterTypeLink']=="remote"){
									$urlLongPoster = $Videos[$V]['urlPoster'];
								}
							
								$LinkDispora = "http://sharetodiaspora.github.io/?title=".
								rawurlencode(
									"![](".$urlLongPoster.")\n\n## [".(utf8_encode($Videos[$V]['Title']))."](".$shortlinkvideo.")\n\n"
									.(utf8_encode($Videos[$V]['Description']))."\n_____\n\n Hashtags: ".
									(@$Config['ChannelName']!=''?'#'.str_replace(" ","",@$Config['ChannelName']).' ':'')
									." #Libretube"
								)."&markdown=true&jump=doclose";
							?>
							onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
						>
							<img src="imgs/icons/sbl_share_diaspora.png" align="absmiddle" /> Diáspora
						</button>
					</center>
					<br/>
				<?php } ?> 

			</div>
			
			
		<?php }
	?>
</center>

