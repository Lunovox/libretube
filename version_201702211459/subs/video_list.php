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
		<br/><br/>
		Assine: <a target="_blank" href="atom.php?order=<?=$order;?>"><img 
			src="imgs/icons/sbl_file_rss.gif" 
			title="Assine o 'Feed RSS' a lista de vídeos deste canal!"
			align="absmiddle"
		/></a> | 
		<?php
			//$LinkDispora = "https://diasporabrazil.org/bookmarklet?title=".
			$LinkDispora = "http://sharetodiaspora.github.io/?title=".
			rawurlencode(
				"[".
					"![".$txtChannelTitle.' - '.$TitlePage."](".$imgLogotipo.")".
				"](".$urlLibretube.")".
				"\n## [".
					$txtChannelTitle.' - '.$TitlePage.
				"](".$urlLibretube.")\n\n".
				"Hashtags: ".($Config['ChannelName']!=''?'#'.str_replace(" ","",$Config['ChannelName']).' ':'')." #Libretube"
			)."&markdown=true&jump=doclose";
		;?>
		Compartilhe: <img src="imgs/icons/sbl_diaspora.png"
			style="cursor:pointer;" align="absmiddle"
			title="Compartilhe em sua Rede Social Diáspora a lista de vídeos mais vistos deste canal!"
			onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
		/>
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

<script>
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
			<div id="divFront<?=$Videos[$V]['ID'];?>" class="<?=(($Videos[$V]['videoTypeLink']!='redirect' && $Videos[$V]['timePublish']!='')?'VideoList':'VideoListOff');?>"
				onclick="<?php printLink($Videos[$V]); ?>"
				onmouseover="showBack('divFront<?=$Videos[$V]['ID'];?>', 'divBack<?=$Videos[$V]['ID'];?>');"
			>
				<div>
					<div>
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
						<hr/>
						<small>
							<?php
								if($Videos[$V]['videoTypeLink']=="local" || $Videos[$V]['videoTypeLink']=="remote"){
									if($Videos[$V]['views']<=1){
										echo "Visualização: ".$Videos[$V]['views'];
									}else{
										echo "Visualizações: ".$Videos[$V]['views'];
									}
								}else{
									echo "Vídeo Externo";
								}
							?>
							| nº<?=$Videos[$V]['ID'];?>
						</small>
					</div>
				</div>
			</div>
			<div id="divBack<?=$Videos[$V]['ID'];?>"
				class="VideoListDesc" style="display:none; overflow:auto; width:90%; height:200px; max-height:200px; text-align:justify;"
				onmouseout="showFront('divBack<?=$Videos[$V]['ID'];?>', 'divFront<?=$Videos[$V]['ID'];?>');"
			>
				<div onclick="<?php printLink($Videos[$V]); ?>">
					<uppercase>
						<b><?php echo $Videos[$V]['Title'];/**/ /*utf8_encode($Videos[$V]['Title']); /**/ ?></b>
					</uppercase>
				</div><br/>
				<?php if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
					<center>
						<button
							title="Editar este video em seu Diáspora!"
							onclick="window.location='?sub=video_edit&id=<?=$Videos[$V]['ID'];?>';"
						>
							<img 
								src="imgs/icons/sbl_lapis.gif" 
								align="absmiddle"
							/> Editar
						</button>
						<button onclick="if(confirm('Deseja realmente apagar este vídeo?')){window.location='?sub=video_delete&id=<?=$Videos[$V]['ID'];?>';}">
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
								if($Videos[$V]['posterTypeLink']=="local"){
									$urlLongPoster = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).$Videos[$V]['urlPoster'];
								}else if($Videos[$V]['posterTypeLink']=="remote"){
									$urlLongPoster = $Videos[$V]['urlPoster'];
								}
							
								$LinkDispora = "http://sharetodiaspora.github.io/?title=".
								rawurlencode(
									"![](".$urlLongPoster.")\n\n## [".(utf8_encode($Videos[$V]['Title']))."](".$shortlinkvideo.")\n\n"
									.(utf8_encode($Videos[$V]['Description']))."\n_____\n\n Hashtags: ".
									($Config['ChannelName']!=''?'#'.str_replace(" ","",$Config['ChannelName']).' ':'')
									." #Libretube"
								)."&markdown=true&jump=doclose";
							?>
							onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
						>
							<img src="imgs/icons/sbl_diaspora.png" align="absmiddle" /> Diáspora
						</button>
					</center>
					<br/>
				<?php } ?> 
				<hr/>
				<div onclick="<?php printLink($Videos[$V]); ?>">
					<?=$Videos[$V]['Description'];?>
				</div>

			</div>
			
			
		<?php }
	?>
</center>

