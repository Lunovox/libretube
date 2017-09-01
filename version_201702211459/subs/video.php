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
			
			/*
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
			)."&markdown=true&jump=doclose"; 
			/**/

			$myLinks = new DownLoadLink($ID); 
			//print_r($_SERVER);
			//echo "aaa --> ".$myLinks->getRedirectShortLink();
			//echo "aaa --> ".$myLinks->getID();
			
			?>
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
	 					
	 					<video 
	 						id="VideoPlayer" 
	 						controls="controls"
						   autobuffer="autobuffer"
						   preload="metadata"
	 						autoplay 
	 						align="center" 
	 						poster="<?=$myLinks->getPosterLink();?>" 
	 						contextmenu="mnuVideo" 
	 						oncontextmenu_="return false;"
	 					>
							<source src='<?=$myLinks->getVídeoLink();?>' type="<?=$myLinks->getVídeoMimetype();?>">
							<?php 
							/*<track src="<?=$Video[0]['urlSubtitle'];?>" kind="subtitles" srclang="pt" label="Português" default />	/**/
							if($myLinks->getVídeoLink()!=""){ ?>
								<track src="<?=$myLinks->getSubtitleLink();?>#.vtt" kind="subtitles" label="Português" srclang="pt" default />
							<?php } ?>
							Infelizmente seu navegador não suporta a tag "VIDEO".
						</video> 

	 					<script>
	 						function onLoadTypePlay(){
 								var chkTypePlays = document.getElementsByName('chkTypePlay');
	 							if(localStorage.length>=1){
	 								//myKey = localStorage.key(i);
									//myValue = localStorage.getItem(myKey);
	 								chkTypePlays[localStorage.getItem("chkTypePlay")].checked = true;
	 							}else{
	 								 //0 = Repeat; 1 = Foward; 2 = Stop (exibe sugestões)
	 								chkTypePlays[0].checked = true;
	 							}
	 						}
	 						function onChangeTypePlay(){
	 							var chkTypePlays = document.getElementsByName('chkTypePlay');
	 							for (var i = 0; i < chkTypePlays.length; i++) {
	 								if(chkTypePlays[i].checked){
	 									localStorage.setItem("chkTypePlay", i);
	 									break;
	 								}
	 							}
	 						}
							function doHideAllFormsVideo(){
								var divVideoControl = document.getElementById('divVideoControl');
								var divVideoShare = document.getElementById('divVideoShare');
								var divFeedReader = document.getElementById('divFeedReader');
								var divVideoTypePlay = document.getElementById('divVideoTypePlay');
								var divVideoInformation = document.getElementById('divVideoInformation');
								
								divVideoControl.style.display = "none";
								divVideoShare.style.display = "none";
								divFeedReader.style.display = "none";
								divVideoTypePlay.style.display = "none";
								divVideoInformation.style.display = "none";
							}
							function doShowFormVideo($form){
								doHideAllFormsVideo();

								var VideoPlayer = document.getElementById('VideoPlayer');
								var divVideoControl = document.getElementById('divVideoControl');
								if($form=="divVideoShare"){
									var divVideoShare = document.getElementById('divVideoShare');
									divVideoShare.style.display = "block";
								}else if($form=="divFeedReader"){
									var divFeedReader = document.getElementById('divFeedReader');
									divFeedReader.style.display = "block";
								}else if($form=="divVideoTypePlay"){
									var divVideoTypePlay = document.getElementById('divVideoTypePlay');
									divVideoTypePlay.style.display = "block";
								}else if($form=="divVideoInformation"){
									var divVideoInformation = document.getElementById('divVideoInformation');
									divVideoInformation.style.display = "block";
								}
								//divVideoControl.style.position = "absolute";
								//divVideoControl.offsetLeft = (VideoPlayer.offsetWidth / 2 - divVideoControl.offsetWidth  / 2) + 'px';
								//divVideoControl.offsetTop = (VideoPlayer.offsetHeight / 2 - divVideoControl.offsetHeight / 2) + 'px';
								divVideoControl.offsetWidth = VideoPlayer.offsetWidth;
								divVideoControl.style.display = "block";
							}
							window.addEventListener('load',function(){
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
									divVideoControl.style.display = "block";
								},false);

								document.getElementById('VideoPlayer').addEventListener('play',function(){
									doHideAllFormsVideo();
								},false);

								document.getElementById('VideoPlayer').addEventListener('pause',function(){
									document.getElementById('divVideoControl').style.display = "block";
								},false);
								
								onLoadTypePlay();
							},false);
						</script>
	 					
						<div id="divVideoControl">
							<div id="divVideoTitle" 
								title="<?=$myLinks->getRedirectShortLink();?>"
								onclick="window.open('<?=$myLinks->getRedirectShortLink();?>');"
							>
								<big><b><?php echo $Video[0]['Title']; ?></b></big>
							</div>

							<?php if($Video[0]['timePublish']!=''){ ?>
							<img 
								src="imgs/icons/sbl_share.png" size="16x16" 
								title="Compartilhe este Vídeo!" type="button"
								onclick="doShowFormVideo('divVideoShare');"
							/>
							<?php } ?>
							<img 
								src="imgs/icons/sbl_file_rss.gif" size="16x16" 
								title="Assine o Canal!" type="button"
								onclick="doShowFormVideo('divFeedReader');"
							/>
							<img 
								src="imgs/icons/sbl_catraca.png" 
								title="Configurações de Vídeo" type="button"
								onclick="doShowFormVideo('divVideoTypePlay');"
							/>
							<img 
								src="imgs/icons/sbl_informacao.gif" 
								title="Informações sobre este Vídeo" type="button"
								onclick="doShowFormVideo('divVideoInformation');"
							/>
							<br/><br/>
							
							<div id="divVideoShare">
								<h2>
									<img src="imgs/icons/sbl_share.png" size="16x16"/>
									COMPARTILHE ESTE VÍDEO
								</h2>


								<img size="16x16"
									title="Compartilhe este vídeo em sua Rede Social Diáspora!"
									src="imgs/icons/sbl_share_diaspora.png" type="button"
									onclick="openPopupCenter('<?=$myLinks->getDiasporaLink();?>','_blank', 880, 600);"
								/><img size="16x16"
									title="Compartilhe este vídeo em seu Twitter!"
									src="imgs/icons/sbl_share_twitter.png" type="button"
									onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 720, 450);"
								/><img size="16x16"
									title="Compartilhe este vídeo em seu Facebook!"
									src="imgs/icons/sbl_share_facebook.png" type="button"
									onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 360, 300);"
							/></div>
							<div id="divFeedReader">
								<h2>
									<img src="imgs/icons/sbl_file_rss.gif" size="16x16"/>
									ASSINE E RECEBA NOTÍCIAS DESTE CANAL
								</h2>
								<img src="imgs/selos/sbl_add2feedreader_nextcloud.png" type="button"
									title="Assine e Receba notícias periódicas deste canal no NextCloud do Disroot!"
									onclick="window.open('https://cloud.disroot.org/apps/news/?subscribe_to=<?=rawurlencode(getAtomLink('xml'));?>');"
								/>
								<img src="imgs/selos/sbl_add2feedreader_theoldreader.png" type="button"
									title="Assine e Receba notícias periódicas deste canal no TheOldReader!"
									onclick="window.open('http://theoldreader.com/feeds/subscribe?url=<?=rawurlencode(getAtomLink('xml'));?>');"
								/>
								<img src="imgs/selos/sbl_add2feedreader_anybrowser.png"  type="button"
									title="Assine e Receba notícias periódicas deste canal em diversos outros agregadores!"
									onclick="openPopupCenter('https://www.subtome.com/#/subscribe?feeds=<?=rawurlencode(getAtomLink('xml'));?>','_blank', 500, 370);"
								/><br/>

								<code><?=getAtomLink('xml');?></code><br/>

								<img src="imgs/selos/sbl_feed_atom.png" type="button"
									title="Assine e Receba notícias periódicas deste canal no seu Navegador!"
									onclick="window.open('<?=getAtomLink('xml');?>');"
								/>
							</div>
							<div id="divVideoTypePlay">
								<h2>
									<img src="imgs/icons/sbl_catraca.png" />
									QUANDO FINALIZAR ESTE VÍDEO
								</h2><br/>
								<input id="chkVideoRepeat" type="radio" name="chkTypePlay" value="repeat" onclick="onChangeTypePlay()"/> 
								<label for="chkVideoRepeat">Repetir</label> 
								
								<input id="chkVideoForward" type="radio" name="chkTypePlay" value="forward" onclick="onChangeTypePlay()"/> 
								<label for="chkVideoForward">Progredir</label> 
								
								<input id="chkVideoStop" type="radio" name="chkTypePlay" value="stop" onclick="onChangeTypePlay()"/> 
								<label for="chkVideoStop">Parar</label>
							</div>
							<div id="divVideoInformation">
								<center>
									<h2>
										<img src="imgs/icons/sbl_informacao.gif" /> 
										SOBRE ESTE VÍDEO
									</h2>
									
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
												<a target="_blank" <?="href='".$myLinks->getVídeoLink()."'";?>><?=$myLinks->getVídeoBase();?></a>
												
											</td> 
										</tr>
										<tr>
											<td align="right"><nobr><b>Poster (<?=$Video[0]['posterTypeLink'];?>):</b> </nobr></td>
											<td style="padding:0px 3px  0px  3px; text-align:left;">
												<a target="_blank" href="<?=$myLinks->getPosterLink();?>"><?=$myLinks->getPosterBase();?></a>
											</td> 
										</tr>
										<?php if($Video[0]['subtitleTypeLink']!="none"){ ?>
											<tr>
												<td align="right"><nobr><b>Legenda (<?=$Video[0]['subtitleTypeLink'];?>):</b> </nobr></td>
												<td style="padding:0px 3px  0px  3px; text-align:left;">
													<a target="_blank" href="<?=$myLinks->getSubtitleLink();?>"><?=$myLinks->getSubtitleBase();?></a>
												</td> 
											</tr>
										<?php } ?>
									</table>
								</center>
							</div>
							<div id="divVideoEvaluate"> <!-- Para avaliação de vídeo -->
								<img size="16x16" src="./sbl_like.png"/> 
								<img size="16x16" rotate="180" src="./sbl_like.png">
							</div>
						</div><!-- Fim de divVideoControl-->
						
						<menu type="context" id="mnuVideo">
							<menuitem label="Recarregar" onclick="window.location.reload();" icon="imgs/icons/sbl_reload.png"></menuitem><?php 
							if($Video[0]['timePublish']!=''){?>
								<menu label="Compartilhar com..."  icon="imgs/icons/sbl_share.png">
									<menuitem 
										label="Diáspora" icon="imgs/icons/sbl_share_diaspora.png"
										onclick="openPopupCenter('<?=$myLinks->getDiasporaLink();?>','_blank', 880, 600);"
									></menuitem>
									<menuitem 
										label="Twitter" icon="imgs/icons/sbl_share_twitter.png"
										onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 720, 450);"
									></menuitem>
									<menuitem 
										label="Facebook" icon="imgs/icons/sbl_share_facebook.png"
										onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=urlencode($myLinks->getRedirectShortLink());?>','_blank', 360, 300);"
									></menuitem>
								</menu><?php 
							}
							if(isLoged()){ ?>
								<menuitem 
									label="Comentar" icon="imgs/icons/sbl_comentario.gif"
									onclick="doWriteMessage();"
								></menuitem><?php 
							} ?>
						</menu>
	 				</center>

					<script> document.getElementsByTagName("title")[0].innerHTML = "<?="Assistindo '" . $Video[0]['Title'] ."' - " . $txtChannelTitle; ?>"; </script>
 					<h2><?php echo $Video[0]['Title']; ?></h2>


					<?php 
						//$Conteudo = CodigoParaHTML(Converter_CodigoCaracter(utf8_encode($Video[0]['Description'])));
					
					
						//$Conteudo = Converter_CodigoCaracter(utf8_encode($Video[0]['Description']));
						//$Conteudo = utf8_encode($Video[0]['Description']);
						//$Conteudo = trim($Video[0]['Description'])!=""?$Video[0]['Description']."<br/><br/><hr/><br/>":"";
						$Conteudo = trim($Video[0]['Description']);
					
					
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
					?>
					<?php if($Conteudo!=""){ ?>
						<br/>
						<details>
							<summary style="cursor:pointer; color:green;"><b>Descrição do vídeo...</b></summary>
							<div><?php
								$Conteudo=str_replace("&#039;", "'", $Conteudo);
								echo getMakeLinks($Conteudo);
							?></div>
						</details>
					<?php } ?>

					
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
	
						<button 
							<?php /*if(!isLoged()){ ?>disabled<?php }/**/ ?>
							title="Escreva um comentário" 
							onclick='<?php 
								if(isLoged()){ 
									echo "doWriteMessage();"; 
								}else{ 
									echo "if(".
										"confirm(\"Para comentar você precisa se identificar. \\nDeseja entrar com sua identificação?\")"
									."){"
										."window.location=\"?sub=log&redirect=".urlencode("sub=video&id=$ID")."\";"
									."}";
								}
							?>'
						>
							<img 
								src="imgs/icons/sbl_comentario.gif" 
								align="absmiddle"
							/> Comentar
						</button>
					</center>
					
					<div id="divTinyMCE" style="display:none">
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
								document.getElementById('divTinyMCE').style.display = 'inline';
								tinyMCE.activeEditor.focus();
							}
							function doCancelMessage(){
								if(tinyMCE.activeEditor.getContent()!=""){
									if(!confirm("Deseja realmente descartar esta mensagem?")){return;}
								}
								document.getElementById('divTinyMCE').style.display = 'none';
								tinyMCE.activeEditor.setContent("");
							}
							function getTxtComentador(){
								//Essa função é para deixar o comentário com o formato mais enxuto possivel
								var $Comment = tinyMCE.activeEditor.getContent();
								$Comment = $Comment.replace(/\r\n/g, ''); // retira "\n\r"
								$Comment = $Comment.replace(/\n/g, ''); // retira "\n"
								$Comment = $Comment.replace("'", '"'); // retira "\n"
								//alert($Comment);
								return $Comment;
							}
							function sendComment($UserID, $video, $Token, $Comment) {
								if($video!=null && $video>=0){
									if($Comment!=null && $Comment!=""){
										var xhttp = new XMLHttpRequest();
										xhttp.onreadystatechange = function() {
											if (xhttp.readyState == 4 && xhttp.status == 200) {
												console.log(xhttp.responseText);
												//alert(xhttp.responseText);

												var newPost = "";
												
												newPost += "<div class='PostComment'>"
												+"<username><?=getLogedUsername();?></username><br>"
												+"<img size='16x16' src='imgs/icons/sbl_relogio.gif'> "
												+"<timeformat>"+((new Date()).toLocaleFormat('%A, %d de %B de %Y as %H:%H:%S'))+"</timeformat>"
												+"<br><br><code>"+$Comment+"</code>"
												+"</div><br>";
												
												divComments = document.getElementById("divComments");
												divTinyMCE = document.getElementById("divTinyMCE");
												
												divComments.innerHTML = newPost + divComments.innerHTML;
												divTinyMCE.style.display = 'none';
												tinyMCE.activeEditor.setContent("");
												divComments.focus();
											}
										};
		
										xhttp.open("POST", "comment_add.php", true);
										$params="u="+$UserID+"&t="+$Token+"&v="+$video+"&c="+encodeURIComponent($Comment);
										//alert($params);
										
										xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
										//xhttp.setRequestHeader("Content-length", $params.length);
										//xhttp.setRequestHeader("Connection", "close");
										xhttp.send($params);
									}else{
										/*FIM de if($Comment!=null && $Comment!="")*/
									}
								}else{
									/*FIM de if($video!=null && $video>=0)*/
								}
							} 
						</script>
						
						<txtcomentador name="txtcomentador"></txtcomentador>
						<br/>
						<div align="right">
							<!--input type="button" value="Postar" onclick="alert('Comentário=['+getTxtComentador()+']');"/-->
							<input type="button" value="Postar" 
								onclick="sendComment('<?=getLogedUserID();?>', '<?=$Video[0]['ID'];?>', '<?=getLogedAuth();?>', getTxtComentador());"
							/>
							<input type="button" value="Cancelar" onclick="doCancelMessage();"/>
						</div>
					</div> <!-- Fim de divTinyMCE -->
					<br/>
					
					<div id="divComments">
						<?php
							$Comments=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."comments", "VideoID = $ID",  "id DESC", null, 0, 30);
							$NameUsers = [];
							for($C=0; $C<count($Comments); $C++){
								$CommentID = $Comments[$C]['ID'];
								$UserID = $Comments[$C]['UserID'];
								$Quando = $Comments[$C]['timePublish'];
								$Comment = $Comments[$C]['Comment'];
								if(!isset($NameUsers[$UserID])){
									$Users=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."users", "ID = $UserID",  "id DESC", null, 0, 30);
									if(count($Users)>=1){
										$NameUsers[$UserID] = $Users[0]['Username'];
									}
								}?>
								<div class="PostComment" id="PostComment_<?=$CommentID;?>">
									<username>
										<?=$NameUsers[$UserID];?>
									</username><br/>
									<img size="16x16" src="imgs/icons/sbl_relogio.gif" /> 
									<timeformat><?=strftime('%A, %d de %B de %Y as %H:%H:%S', strtotime($Quando	));?></timeformat>
									<?php if(isLoged() && $UserID!=getLogedUserID()){ ?>
										<a href="?sub=pvmessage_send&to==<?=$UserID;?>">
											<img 
												size="16x16" src="imgs/icons/sbl_carta.png" type="button"
												title="Envia uma emnsagem privada para <?=$NameUsers[$UserID];?>!"
											/>
										</a>
									<?php } ?>
									<?php if($UserID==getLogedUserID() || getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
										<a href="?sub=comment_delete&id==<?=$CommentID;?>">
											<img 
												size="16x16" src="imgs/icons/sbl_negar.gif" type="button"
												title="Apage este comentário!"
											/>
										</a>
									<?php } ?>
									<br/><br/>
									<code><?=$Comment;?></code>
								</div><br/>
								<?php
								//print_r($Comments[$C]);
							}
						?>
					</div> <!-- Fim de divComments -->
				</div>
			</center>
		<?php
		}else{require_once "subs/forbidden.php";}
	}
?>
