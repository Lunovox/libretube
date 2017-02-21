<?php
	$ID=Propriedade("id");
	$QtdPerPage = 12;
	$page = intval(Propriedade("page"));
	$QtdVideos = 0;
	
	
	//getTable($Tabela=NULL, $Teste=NULL, $Ordem=NULL, $CamposDeRetorno=NULL, $LimiteMinimo=0, $LimiteMaximo=9999)
	$Playlists=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_head", "ID = $ID AND timePublish IS NOT NULL");
	if(count($Playlists)>=1){
		$QtdVideos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_videos", "idPlaylist = ".$Playlists[0]['ID'],  null , "COUNT(*) AS QTD")[0]['QTD'];
		$PlaylistsVideos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."playlist_videos", "idPlaylist = ".$Playlists[0]['ID'],  "idPlaylist ASC, ID ASC", null, $page*$QtdPerPage, $QtdPerPage);
		if(count($PlaylistsVideos)>=1){
			$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = ".$PlaylistsVideos[0]['idVideo'],  "timePublish DESC, timeUpdate DESC");
			if(count($Videos)>=1){
			
				$TitlePage = $Playlists[0]['Title']." <nobr>(".$QtdVideos." vídeos)</nobr>"; 
				//$TitlePage = $Playlists[0]['Title']; 
				$DescriptionPage = $Playlists[0]['Description']; 
			
				$urlPoster = $Videos[0]['urlPoster'];
				?>

				<div>
					<br/>
					<center>

						<div class="FormSession" align="justify">
							<img id="TitleThumbnails" style_="max-width:740px;" src="<?=$urlPoster;?>"/>
							<center><h2><?=$TitlePage;?></h2></center>
							<div><?=$DescriptionPage;?></div>
						</div>
					
						<div style="display:inline-block; padding:3px; background-color:rgba(128,128,128,0.8); border:1px solid #c0c0c0; border-radius:5px;">
							<h2><?php 
								if($page>0){ 
									?><button align="top" style="border-radius:5px;"
									onclick="window.location='?sub=playlist&id=<?=$ID;?>&page=0';"
									> << </button><button align="top" style="border-radius:5px;"
									onclick="window.location='?sub=playlist&id=<?=$ID;?>&page=<?=$page-1;?>';"
									> < </button><?php 
								} 
								echo " ".($page+1)."/".ceil($QtdVideos/$QtdPerPage)." ";
								if(
									//($page*$QtdPerPage)+$QtdPerPage<$QtdVideos
									$page < ceil($QtdVideos/$QtdPerPage)-1
								){ 
									?><button align="top" style="border-radius:5px;"
									onclick="window.location='?sub=playlist&id=<?=$ID;?>&page=<?=$page+1;?>';"
									> > </button><button align="top" style="border-radius:5px;"
									onclick="window.location='?sub=playlist&id=<?=$ID;?>&page=<?=(ceil($QtdVideos/$QtdPerPage)-1);?>';"
									> >> </button><?php 
								} 
							?></h2>
						</div>
						<br/><br/>
						Assine: <a target="_blank" href="atom.php?id=<?=$ID;?>"><img 
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

				<center><?php
				
					function printLink($Video){
						//alert("aaaaaaaaaaaaa");
						$ID=Propriedade("id");
						if($Video['videoTypeLink']=="local" || $Video['videoTypeLink']=="remote"){
							echo "window.location='?sub=video&id=".$Video['ID']."&playlist=".$ID."';";
						}else{ //se for "redirect"
							echo "window.open('".$Video['urlVideo']."', '_blank');";
						}/**/
					}
					
					for($V=0; $V<count($PlaylistsVideos); $V++){ 
						$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = ".$PlaylistsVideos[$V]['idVideo'],  "timePublish DESC, timeUpdate DESC");
						if(count($Videos)>=1){ 
							$Video = $Videos[0];?>
						
							<div class="<?=(($Video['videoTypeLink']!='redirect' && $Video['timePublish']!='')?'VideoList':'VideoListOff');?>"
								onclick="<?php printLink($Video); ?>"
							>
								<div>
									<img style="width:260px; height:168px" src="<?=$Video['urlPoster'];?>"/>
									<b><?php echo $Video['Title'];/**/ /*utf8_encode($Video['Title']); /**/ ?></b>
								</div>

								<div>
									<hr/>
									<small>
										<?php
											if($Video['videoTypeLink']=="local" || $Video['videoTypeLink']=="remote"){
												if($Video['views']<=1){
													echo "Visualização: ".$Video['views'];
												}else{
													echo "Visualizações: ".$Video['views'];
												}
											}else{
												echo "Vídeo Externo";
											}
										?>
									</small>
								</div>
							</div>	<?php 
						}
					} /* fim de FOR /**/ ?>
				</center><?php
			}
		}
	}
?>
