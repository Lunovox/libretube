<?php
	$ID=Propriedade("id");
	$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
	//print_r($Video);
	if(count($Video)==1){
		if($Video[0]['timePublish']!='' || getLogedType()=="owner" || getLogedType()=="moderator"){ 
			$external_ip = @exec('curl http://ipecho.net/plain; echo'); //fonte: http://stackoverflow.com/questions/4420468/php-display-server-ip-address
			if($external_ip!=$_SERVER['REMOTE_ADDR']){
				$LunoMySQL->getResult("UPDATE ".$LunoMySQL->getConectedPrefix()."videos SET views='".(++$Video[0]['views'])."' WHERE ID=$ID");
			}
			
			$longlinkvideo = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$shortlinkvideo = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).'?video='.$ID;
			if($Video[0]['posterTypeLink']=="auto" || $Video[0]['posterTypeLink']=="local"){
				$urlLongPoster = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']).$Video[0]['urlPoster'];
			}else if($Video[0]['posterTypeLink']=="remote"){
				$urlLongPoster = $Video[0]['urlPoster'];
			}
		
			$LinkDispora = "http://sharetodiaspora.github.io/?title=".
			rawurlencode(
				"![](".$urlLongPoster.")\n\n## [".(utf8_encode($Video[0]['Title']))."](".$shortlinkvideo.")\n\n"
				.(utf8_encode($Video[0]['Description']))."\n_____\n\n Hashtags: ".
				(@$Config['ChannelName']!=''?'#'.str_replace(" ","",@$Config['ChannelName']).' ':'')
				." #Libretube"
			)."&markdown=true&jump=doclose";	?>
			<center>
				<div class="FormSession" align="justify">
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
	 					
						<style>
						
							
							/*
							@media (max-width:380px) {
								#divVideoTitle{
									max-width:380px; 
									max-height:213px;  
									width:100%;
								}
							}
							/**/
							
							#divVideoTitle{
								//position:absolute;/**/
								position:relative;/**/
								/*display: inline-block;/**/
								/*display: block;/**/
								/*width:800px;/**/
								width:100%;
								max-width:759px; /**/
								top:85px;

								z-index:1;
								margin:  0px 0px 0px 0px;
								padding: 5px 0px 5px 0px;

								color: rgb(255, 255, 255);
								font-family: arial, helvetica, sans-serif, serif;/**/
								font-size: 14px;
								font-weight: bold;
								line-height: 25px;
								text-align: center;
								/*text-decoration: none;
								text-transform: uppercase;
								/**/
								text-shadow:1px 1px 0 #00000088;

								/*background: linear-gradient(to bottom, #000000CC, #000000CC 80%, #00000033 100%);/**/
								/*background: linear-gradient(to bottom, #FFFF00CC, #FFFF00CC 80%, #FFFF0033 100%);/**/
								/*background: linear-gradient(to bottom, #00FF0033, #00880088 20%, #00880088 80%, #00880033 100%);/**/
								/*background-color: rgba(0,0,0, 0.5);/**/
								background: linear-gradient(to right, #3FA95288, #00000088 30%, #00000088 70%, #3FA95288);

								border: 1px solid #CCCCCE;
								/*
								box-shadow: 0 3px 0 rgba(0, 0, 0, .3),
											0 2px 7px rgba(0, 0, 0, 0.2);
								border-radius: 3px;
								/**/
							
							
							}
							img[rotate="180"]{
								transform: scaleX(-1) scaleY(-1);
							}
							img[onclick]{
								cursor:pointer;
							}
						</style>
						<div id="divVideoTitle">
							<big><b><?php echo $Video[0]['Title']; ?><b></big><br/>
							<small>
									<!--img width="12px" height="12px" src="./sbl_like.png"/> 
									<img width="12px" height="12px" rotate="180" src="./sbl_like.png"/-->
									
									<img 
										title="Compartilhe este vídeo em sua Rede Social Diáspora!"
										src="imgs/icons/sbl_share_diaspora.png"
										onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
									/>
									<img 
										title="Compartilhe este vídeo em seu Twitter!"
										src="imgs/icons/sbl_share_twitter.png"
										onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($shortlinkvideo);?>','_blank', 720, 450);"
									/>
									<img 
										title="Compartilhe este vídeo em seu Facebook!"
										src="imgs/icons/sbl_share_facebook.png"
										onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($shortlinkvideo);?>','_blank', 360, 300);"
									/>
							</small>
						</div>
	 					<video id="VideoPlayer" controls autoplay align="center" poster="<?php echo $Video[0]['urlPoster']; ?>" contextmenu="mnuVideo" oncontextmenu_="return false;">
							<source src="<?=$Video[0]['urlVideo'];?>" type="video/ogg">
							<track src="<?=$Video[0]['urlSubtitle'];?>" kind="subtitles" srclang="pt" label="Português" default />
							Infelizmente seu navegador não suporta a tag "VIDEO".
						</video> 
						
						<script>
							window.addEventListener('load',function(){
								var VideoPlayer = document.getElementById('VideoPlayer');
								var divVideoTitle = document.getElementById('divVideoTitle');

								//divVideoTitle.offsetWidth = VideoPlayer.offsetWidth;
								//divVideoTitle.style.width = VideoPlayer.style.width;
								//divVideoTitle.width = VideoPlayer.width;
								//alert("divVideoTitle.style.display="+divVideoTitle.style.display);
								//alert("VideoPlayer.offsetWidth="+VideoPlayer.offsetWidth);
	
								//divVideoTitle.style.position = "absolute";
								//divVideoTitle.style.display = "inline-block";

								//var customMessageTop = VideoPlayer.offsetHeight / 2 - divVideoTitle.offsetHeight / 2;
								//var customMessageLeft = VideoPlayer.offsetWidth / 2 - divVideoTitle.offsetWidth  / 2;
								var customMessageTop = ((VideoPlayer.offsetHeight-divVideoTitle.offsetHeight)/2) + VideoPlayer.offsetTop;
								var customMessageLeft = ((VideoPlayer.offsetWidth-divVideoTitle.offsetWidth)/2) + VideoPlayer.offsetLeft;
								//alert("customMessageTop="+customMessageTop);
								/*
								divVideoTitle.style.left = customMessageLeft + 'px';
								divVideoTitle.style.top = customMessageTop + 'px';
								divVideoTitle.offsetLeft = customMessageLeft + 'px';
								divVideoTitle.offsetTop = customMessageTop + 'px';
								/**/
				
							},false);
							document.getElementById('divVideoTitle').addEventListener('click',function(){
								var VideoPlayer = document.getElementById('VideoPlayer');
								if(VideoPlayer.ended){
									VideoPlayer.currentTime = 0;
									VideoPlayer.play();
								}
							},false);
				
							document.getElementById('VideoPlayer').addEventListener('ended',function(e){
								if(!e) { e = window.event; }
								var VideoPlayer = document.getElementById('VideoPlayer');
								var divVideoTitle = document.getElementById('divVideoTitle');
								VideoPlayer.currentTime = 0;
								//divVideoTitle.style.display = "inline-block";
								divVideoTitle.style.display = "";
							},false);

							document.getElementById('VideoPlayer').addEventListener('play',function(){
								var divVideoTitle = document.getElementById('divVideoTitle');
								divVideoTitle.style.display = "none";
							},false);

							document.getElementById('VideoPlayer').addEventListener('pause',function(){
								var divVideoTitle = document.getElementById('divVideoTitle');
								//divVideoTitle.style.display = "inline-block";
								divVideoTitle.style.display = "";
							},false);
				
						</script>
						
						<menu type="context" id="mnuVideo">
							<menuitem label="Recarregar" onclick="window.location.reload();" icon="imgs/icons/sbl_reload.png"></menuitem>
							<menu label="Compartilhar com..."  icon="imgs/icons/sbl_share.png">
								<menuitem 
									label="Diáspora" icon="imgs/icons/sbl_share_diaspora.png"
									onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
								></menuitem>
								<menuitem 
									label="Twitter" icon="imgs/icons/sbl_share_twitter.png"
									onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($shortlinkvideo);?>','_blank', 720, 450);"
								></menuitem>
								<menuitem 
									label="Facebook" icon="imgs/icons/sbl_share_facebook.png"
									onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($shortlinkvideo);?>','_blank', 360, 300);"
								></menuitem>
							</menu>
							<?php if(isLoged()){ ?>
							<menuitem 
								label="Comentar" icon="imgs/icons/sbl_comentario.gif"
								onclick="doWriteMessage();"
							></menuitem>
							<?php } ?>
						</menu>
						
						<script>
							document.getElementsByTagName("title")[0].innerHTML = "<?="Assistindo '" . $Video[0]['Title'] ."' - " . $txtChannelTitle; ?>";
						</script>
	 					<h2><?php echo $Video[0]['Title']; ?></h2>
	 					<?php if($Video[0]['timePublish']!=''){?>
							<br/>
							<?php
								$urlShare = $urlLibretube.'?video='.$ID;
								//$LinkDispora = "https://diasporabrazil.org/bookmarklet?title=".
								$LinkDispora = "http://sharetodiaspora.github.io/?title=".
								rawurlencode(
									"[".
										"![".$Video[0]['Title']."](".
											($Video[0]['posterTypeLink']=="remote"?$Video[0]['urlPoster']:$urlLibretube.$Video[0]['urlPoster'])
										.")".
									"](".$urlShare.")".
									"\n## [".
										$Video[0]['Title'].
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
							<br/><br/><hr/>
						<?php } ?>
	 				</center>
	 				
	 				<br/>
	 				<br/>
	
					<div>
					<!-- p align="justify" style="margin:10px" -->
						<?php 
							//$Conteudo = CodigoParaHTML(Converter_CodigoCaracter(utf8_encode($Video[0]['Description'])));
							
							
							//$Conteudo = Converter_CodigoCaracter(utf8_encode($Video[0]['Description']));
							//$Conteudo = utf8_encode($Video[0]['Description']);
							$Conteudo = trim($Video[0]['Description'])!=""?$Video[0]['Description']."<br/><br/><hr/><br/>":"";
							
							
							/*
							require_once 'libs/Michelf/MarkdownInterface.php';
							require_once 'libs/Michelf/Markdown.php';
							$Conteudo = \Michelf\Markdown::defaultTransform($Conteudo);
							/**/
				
							/*
							require_once "libs/jbbcode/Parser.php";
							$parser = new JBBCode\Parser();
							$parser->addCodeDefinitionSet(new JBBCode\DefaultCodeDefinitionSet());
							$parser->addBBCode("quote", '<div class="quote">{param}</div>');
							$parser->addBBCode("code", '<pre class="code">{param}</pre>', false, false, 1);
							$parser->parse($Conteudo);
							//print $parser->getAsText();
							//print $parser->getAsHtml();
							$Conteudo = $parser->getAsHtml();
							/**/
				
							echo $Conteudo;
						?>
					<!-- /p -->
					</div>
					
					<!--
					<img src="resource/smiles/00.gif" width="25px" height="25px" title="Ameaçador"/>
					<img src="resource/smiles/01.gif" width="25px" height="25px" title="Triste"/>
					<img src="resource/smiles/02.png" width="25px" height="25px" title="Decepcionado"/>
					<img src="resource/smiles/03.gif" width="25px" height="25px" title="Inibido"/>
					<img src="resource/smiles/04.gif" width="25px" height="25px" title="Detestador"/>
					<img src="resource/smiles/05.gif" width="25px" height="25px" title="Confuso"/>
					<img src="resource/smiles/06.gif" width="25px" height="25px" title="Aliviado"/>
					<img src="resource/smiles/07.gif" width="25px" height="25px" title="Sugeridor"/>
					<img src="resource/smiles/08.png" width="25px" height="25px" title="Apreciador"/>
					<img src="resource/smiles/09.gif" width="25px" height="25px" title="Tarado"/>
					<img src="resource/smiles/10.gif" width="25px" height="25px" title="lol"/>
					-->
	
					<details>
						<summary style="cursor:pointer; color:green;"><b>Informações sobre o vídeo...</b></summary>
						<table>
							<tr>
								<td align="right"><b><nobr>Visualizações:</nobr></b></td>
								<td style="padding:3px; width:100%">
									<nobr>
										<?=$Video[0]['views'];?> vezes
									</nobr>
								</td>
							</tr>
							<tr>
								<td align="right"><b><nobr>Upload:</nobr></b></td>
								<td style="padding:3px; width:100%">
									<nobr>
										<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timeRegistration']));?>
									</nobr>
								</td>
							</tr>
							<tr>
								<td align="right"><b><nobr>Publicação:</nobr></b></td>
								<td style="padding:3px; width:100%">
									<nobr>
										<?=($Video[0]['timePublish']!=""?strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timePublish'])):"<font color='#FF0000'><b>Vídeo Privado</b></font>");?>
									</nobr>
								</td>
							</tr>
							<tr>
								<td align="right"><b><nobr>Atualizado:</nobr></b></td>
								<td style="padding:3px; width:100%">
									<nobr>
										<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timeUpdate']));?>
									</nobr>
								</td>
							</tr>
							<tr>
								<td align="right"><nobr><b>Vídeo (<?=$Video[0]['videoTypeLink'];?>):</b></nobr></td>
								<td style="padding:3px; width:100%">
									<?php
										function getVideoUrl($V){
											if($V['videoTypeLink']=="remote"){
												return $V['urlVideo'];
											}elseif($V['videoTypeLink']=="local"){
												return "download.php?type=video&id=".$V['ID'];
											}
										};
										function getVideoBase($V){
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
										};
									?>
									<a target="_blank" <?="href='".getVideoUrl($Video[0])."'";?>><?=getVideoBase($Video[0]);?></a>
								</td> 
							</tr>
							<tr>
								<td align="right"><nobr><b>Poster (<?=$Video[0]['posterTypeLink'];?>):</b> </nobr></td>
								<td style="padding:3px; width:100%">
									<?php
										function getPosterDownload($V){
											if($V['posterTypeLink']=="remote"){
												return $V['urlPoster'];
											}elseif($V['posterTypeLink']=="auto" || $V['posterTypeLink']=="local"){
												return "download.php?type=poster&id=".$V['ID'];
											}
										}
										function getPosterBase($V){
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
									?>
									<a target="_blank" href="<?=getPosterDownload($Video[0]);?>"><?=getPosterBase($Video[0]); ?></a>
								</td> 
							</tr>
							<?php if($Video[0]['subtitleTypeLink']!="none"){ ?>
								<tr>
									<td align="right"><nobr><b>Legenda (<?=$Video[0]['subtitleTypeLink'];?>):</b> </nobr></td>
									<td style="padding:3px; width:100%">
										<?php
											function getSubtitleDownload($V){
												if($V['subtitleTypeLink']=="remote"){
													return $V['urlSubtitle'];
												}elseif($V['subtitleTypeLink']=="local"){
													return "download.php?type=subtitle&id=".$V['ID'];
												}
											}
											function getSubtitleBase($V){
												if($V['videoTypeLink']=="remote"){
													return basename($V['urlSubtitle']);
												}elseif($V['videoTypeLink']=="local"){
													$file = $V['urlSubtitle'];
													//$extension = explode("/", get_headers($file, 1)["Content-Type"])[1];
													$extension = @pathinfo($file)['extension'];
													//$txtNameVideo = basename($file).".".$extension;
													return basename(str_replace(" ", "_", $V['Title'])).".".($extension!=""?$extension:"vtt");
												}
											}
										?>
										<a target="_blank" href="<?=getSubtitleDownload($Video[0]);?>"><?=getSubtitleBase($Video[0]); ?></a>
									</td> 
								</tr>
							<?php } ?>
						</table>
					</details>
					<br/>
					
					<center>
						<?php if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
							<button
								title="Compartilhe este video em seu Diáspora!"
								onclick="window.location='?sub=video_edit&id=<?=$ID;?>';"
							>
								<img 
									src="imgs/icons/sbl_lapis.gif" 
									align="absmiddle"
								/> Editar
							</button>
							<button onclick="if(confirm('Deseja realmente apagar este vídeo?')){window.location='?sub=video_delete&id=<?=$ID;?>';}">
								<img src="imgs/icons/sbl_negar.gif" align="absmiddle" /> Apagar
							</button>
							<button
								title="Adicione este vídeo a uma Lista!"
								onclick="openPopupCenter('playlist_form.php?id=<?=$ID;?>','_blank', 330, 330);"
							>
								<img src="imgs/icons/sbl_percevejo.gif" align="absmiddle" /> Adicionar a Lista
							</button>
							<button onclick="if(confirm('Deseja realmente <?=($Video[0]['timePublish']!=''?'privatizar':'publicar');?> este vídeo?')){window.location='?sub=video_access&set=<?=($Video[0]['timePublish']!=''?'private':'public');?>&id=<?=$ID;?>';}">
								<img src="imgs/icons/<?=($Video[0]['timePublish']!=''?'sbl_cadeado_preto.gif':'sbl_planeta.gif');?>" align="absmiddle" />
								<?=($Video[0]['timePublish']!=''?'Privatizar':'Publicar');?>
							</button>
						<?php } ?> 
	
						<!--button
							title="Compartilhe este video em seu Diáspora!"
							onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
						>
							<img src="imgs/icons/sbl_share_diaspora.png" align="absmiddle" /> Diáspora
						</button>
						<button title="Baixe este vídeo para seu computador!" onclick="window.location='download.php?id=<?=$ID;?>';">
							<img src="imgs/icons/sbl_download.gif" align="absmiddle"/> 
							Download
						</button-->
						
						<button 
							<?php if(!isLoged()){ ?>disabled<?php } ?>
							title="Escreva um comentário" 
							onclick="doWriteMessage();"
						>
							<img 
								src="imgs/icons/sbl_comentario.gif" 
								align="absmiddle"
							/> Comentar
						</button>
					</center>
					
					<div id="boxComentario" style="display:none">
						<br/>
						<script src="libs/tinymce_4.3.2/js/tinymce/tinymce.js"></script>
						<script>
							tinymce.init({
								language : 'pt_BR',
								selector: "txtcomentador",
								content_css : "estilo_tinymce.css?update=<?=date('Y-m-d H:i:s');?>",    //FONTE: http://www.tinymce.com/wiki.php/Configuration3x:content_css
								element_format : 'html',
								mode : "textareas",
								forced_root_block : false, //Se false, emvez de fazer quebra de paragrafos em todo fim de linha usa tag <br>
								remove_linebreaks : true,
								height: 200, //Altura da caixa de texto editável
								menubar: '', //Padrão ====> 'file edit insert view format table tools'
								plugins: [
									//'print preview media insertdatetime pagebreak', //<=== Desativado por ser formatação trivial
									//'bbcode', //<=== exporta como bbcode
									'advlist autolink lists link image charmap hr anchor template',
									'searchreplace wordcount visualblocks visualchars code fullscreen',
									'nonbreaking save table contextmenu directionality',
									'emoticons paste textcolor colorpicker textpattern imagetools'
								],
								//toolbar: 'fontselect print preview media | link image table emoticons | code fullscreen ',
								toolbar1: 'styleselect | bold italic underline strikethrough | superscript subscript | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent',
								toolbar2: 'undo redo searchreplace | cut copy paste | hr link anchor charmap nonbreaking | image emoticons table | code fullscreen | sizeselect  fontsize',
								//toolbar3: '',
							});
							
							function doWriteMessage(){
								document.getElementById('boxComentario').style.display = 'inline';
								tinyMCE.activeEditor.focus();
							}
							function doWCancelMessage(){
								if(tinyMCE.activeEditor.getContent()!=""){
									if(!confirm("Deseja realmente descartar esta mensagem?")){return;}
								}
								document.getElementById('boxComentario').style.display = 'none';
								tinyMCE.activeEditor.setContent("");
							}
							function getTxtcomentador(){
								//Essa função é para deixar o comentário com o formato mais enxuto possivel
								return tinyMCE.activeEditor.getContent()
								.replace(/\r\n/g, '') // retira "\n\r"
								.replace(/\n/g, '') // retira "\n"
							}
							
						</script>
						<txtcomentador name="txtcomentador"></txtcomentador>
						<br/>
						<div align="right">
							<input type="button" value="Postar" onclick="alert('Comentário=['+getTxtcomentador()+']');"/>
							<input type="button" value="Cancelar" onclick="doWCancelMessage();"/>
						</div>
					</div>
	
				</div>
			</center>
		<?php
		}else{require_once "subs/forbidden.php";}
	}
?>
