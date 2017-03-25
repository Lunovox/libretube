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
	 					
	 					<script>
							function doHideAllFormsVideo(){
								var divVideoControl = document.getElementById('divVideoControl');
								var divVideoShare = document.getElementById('divVideoShare');
								var divVideoTypePlay = document.getElementById('divVideoTypePlay');
								var divVideoInformation = document.getElementById('divVideoInformation');

								divVideoControl.style.display = "none";
								divVideoShare.style.display = "none";
								divVideoTypePlay.style.display = "none";
								divVideoInformation.style.display = "none";
							}
							function doShowFormVideo($form){
								doHideAllFormsVideo();

								var VideoPlayer = document.getElementById('VideoPlayer');
								var divVideoControl = document.getElementById('divVideoControl');
								if($form=="divVideoShare"){
									var divVideoShare = document.getElementById('divVideoShare');
									divVideoShare.style.position = "absolute";
									divVideoShare.offsetLeft = (VideoPlayer.offsetWidth / 2 - divVideoShare.offsetWidth  / 2) + 'px';
									divVideoShare.offsetTop = (VideoPlayer.offsetHeight / 2 - divVideoShare.offsetHeight / 2) + 'px';
									divVideoShare.style.display = "block";
								}else if($form=="divVideoTypePlay"){
									var divVideoTypePlay = document.getElementById('divVideoTypePlay');
									divVideoTypePlay.style.position = "absolute";
									divVideoTypePlay.offsetLeft = (VideoPlayer.offsetWidth / 2 - divVideoTypePlay.offsetWidth  / 2) + 'px';
									divVideoTypePlay.offsetTop = (VideoPlayer.offsetHeight / 2 - divVideoTypePlay.offsetHeight / 2) + 'px';
									divVideoTypePlay.style.display = "block";
								}else if($form=="divVideoInformation"){
									var divVideoInformation = document.getElementById('divVideoInformation');
									divVideoInformation.style.position = "absolute";
									divVideoInformation.offsetLeft = (VideoPlayer.offsetWidth / 2 - divVideoInformation.offsetWidth  / 2) + 'px';
									divVideoInformation.offsetTop = (VideoPlayer.offsetHeight / 2 - divVideoInformation.offsetHeight / 2) + 'px';
									divVideoInformation.style.display = "block";
								}
								doAlignTitleVideo();
								divVideoControl.style.display = "block";
							}
							function doAlignTitleVideo(){
								var VideoPlayer = document.getElementById('VideoPlayer');
								var divVideoControl = document.getElementById('divVideoControl');

								//divVideoControl.offsetWidth = VideoPlayer.offsetWidth;
								//divVideoControl.style.width = VideoPlayer.style.width;
								//divVideoControl.width = VideoPlayer.width;
								//alert("divVideoControl.style.display="+divVideoControl.style.display);
								//alert("VideoPlayer.offsetWidth="+VideoPlayer.offsetWidth);

								//divVideoControl.style.position = "absolute";
								//divVideoControl.style.display = "inline-block";

								//var customMessageTop = VideoPlayer.offsetHeight / 2 - divVideoControl.offsetHeight / 2;
								//var customMessageLeft = VideoPlayer.offsetWidth / 2 - divVideoControl.offsetWidth  / 2;
								var customMessageTop = ((VideoPlayer.offsetHeight-divVideoControl.offsetHeight)/2) + VideoPlayer.offsetTop;
								var customMessageLeft = ((VideoPlayer.offsetWidth-divVideoControl.offsetWidth)/2) + VideoPlayer.offsetLeft;
								//alert("customMessageTop="+customMessageTop);
								/*
								divVideoControl.style.left = customMessageLeft + 'px';
								divVideoControl.style.top = customMessageTop + 'px';
								divVideoControl.offsetLeft = customMessageLeft + 'px';
								divVideoControl.offsetTop = customMessageTop + 'px';
								/**/
							}
							window.addEventListener('load',function(){
								doAlignTitleVideo();
								
								/**/
								document.getElementById('divVideoControl').addEventListener('click',function(){
									var VideoPlayer = document.getElementById('VideoPlayer');
									if(VideoPlayer.ended){
										VideoPlayer.currentTime = 0;
										VideoPlayer.play();
										
										document.getElementById('divVideoControl').style.display = "none";
										document.getElementById('divVideoShare').style.display = "none";
										document.getElementById('divVideoTypePlay').style.display = "none";
									}
								},false);
								/**/
	
								document.getElementById('VideoPlayer').addEventListener('ended',function(e){
									if(!e) { e = window.event; }
									doHideAllFormsVideo();
					
									var VideoPlayer = document.getElementById('VideoPlayer');
									var divVideoControl = document.getElementById('divVideoControl');
									var chkTypePlays = document.getElementsByName('chkTypePlay');
					
									for (var i = 0, length = chkTypePlays.length; i < length; i++) {
										//alert(chkTypePlays[i].value+" (="+i+")"); // do whatever you want with the checked radio
										if(chkTypePlays[0].checked) { // 0 = repeat
											VideoPlayer.currentTime = 0;
											VideoPlayer.play();
											break;// only one radio can be logically checked, don't check the rest
										}else if(chkTypePlays[1].checked) { // 1 = forward
											alert("Função avançar vídeo ainda não foi implantada. Desculpe!");
											break;// only one radio can be logically checked, don't check the rest
										}else{
											VideoPlayer.currentTime = 0;
											break;// only one radio can be logically checked, don't check the rest
										}
									}
									//divVideoControl.style.display = "inline-block";
									divVideoControl.style.display = "block";
								},false);

								document.getElementById('VideoPlayer').addEventListener('play',function(){
									doHideAllFormsVideo();
								},false);

								document.getElementById('VideoPlayer').addEventListener('pause',function(){
									document.getElementById('divVideoControl').style.display = "block";
								},false);
								
								doHideAllFormsVideo();
							},false);
						</script>
	 					
						<div id="divVideoControl">
							<div id="divVideoTitle">
								<big><b><?php echo $Video[0]['Title']; ?><b></big>
							</div>
							<img src="imgs/icons/sbl_share.svg" size="16x16" onclick="doShowFormVideo('divVideoShare');"/>
							<img src="imgs/icons/sbl_libretube.png" onclick="doShowFormVideo('divVideoTypePlay');"/>
							<img src="imgs/icons/sbl_lampada.gif" onclick="doShowFormVideo('divVideoInformation');"/>
							
							<div id="divVideoShare">
								Compartilhe: 
								<img size="16x16"
									title="Compartilhe este vídeo em sua Rede Social Diáspora!"
									src="imgs/icons/sbl_share_diaspora.png"
									onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
								/><img size="16x16"
									title="Compartilhe este vídeo em seu Twitter!"
									src="imgs/icons/sbl_share_twitter.png"
									onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($shortlinkvideo);?>','_blank', 720, 450);"
								/><img size="16x16"
									title="Compartilhe este vídeo em seu Facebook!"
									src="imgs/icons/sbl_share_facebook.png"
									onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($shortlinkvideo);?>','_blank', 360, 300);"
							/></div>
							<div id="divVideoTypePlay">
								Quando este vídeo terminar: 
								<input id="chkVideoRepeat" type="radio" name="chkTypePlay" value="repeat" checked/> 
								<label for="chkVideoRepeat">Repetir</label>
								<input id="chkVideoForward" type="radio" name="chkTypePlay" value="forward"/> 
								<label for="chkVideoForward">Progredir</label>
								<input id="chkVideoStop" type="radio" name="chkTypePlay" value="stop"/> 
								<label for="chkVideoStop">Parar</label>
							</div>
							<div id="divVideoInformation">
								<center>
									<table>
										<tr>
											<td align="right"><b><nobr>Visualizações:</nobr></b></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
												<nobr>
													<?=$Video[0]['views'];?> vezes
												</nobr>
											</td>
										</tr>
										<tr>
											<td align="right"><b><nobr>Upload:</nobr></b></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
												<nobr>
													<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timeRegistration']));?>
												</nobr>
											</td>
										</tr>
										<tr>
											<td align="right"><b><nobr>Publicação:</nobr></b></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
												<nobr>
													<?=($Video[0]['timePublish']!=""?strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timePublish'])):"<font color='#FF0000'><b>Vídeo Privado</b></font>");?>
												</nobr>
											</td>
										</tr>
										<tr>
											<td align="right"><b><nobr>Atualizado:</nobr></b></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
												<nobr>
													<?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Video[0]['timeUpdate']));?>
												</nobr>
											</td>
										</tr>
										<tr>
											<td align="right"><nobr><b>Vídeo (<?=$Video[0]['videoTypeLink'];?>):</b></nobr></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
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
											<td style="padding:0px 3px  0px  3px; text-align:left;">
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
												<td style="padding:0px 3px  0px  3px; text-align:left;">
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
								</center>
							</div>
							<div id="divVideoEvaluate">
								<img size="16x16" src="./sbl_like.png"/> 
								<img size="16x16" rotate="180" src="./sbl_like.png">
							</div>
						</div>
	 					<video id="VideoPlayer" controls autoplay align="center" poster="<?php echo $Video[0]['urlPoster']; ?>" contextmenu="mnuVideo" oncontextmenu_="return false;">
							<source src="<?=$Video[0]['urlVideo'];?>" type="video/ogg">
							<track src="<?=$Video[0]['urlSubtitle'];?>" kind="subtitles" srclang="pt" label="Português" default />
							Infelizmente seu navegador não suporta a tag "VIDEO".
						</video> 
						
						
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
						<?php } ?>
	 				</center>


					<details>
						<br/>
						<summary style="cursor:pointer; color:green;"><b>Informações sobre o vídeo...</b></summary>

						<script>
							document.getElementsByTagName("title")[0].innerHTML = "<?="Assistindo '" . $Video[0]['Title'] ."' - " . $txtChannelTitle; ?>";
						</script>

	 					<h2><?php echo $Video[0]['Title']; ?></h2>
	 					
						
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
					</details>

					
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
