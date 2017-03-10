<?php
	$ID=Propriedade("id");
	$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
	//print_r($Video);
	if(count($Video)==1){
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
								onclick="openPopupCenter('//twitter.com/intent/tweet?text=<?=$shortlinkvideo;?>','_blank', 720, 450);"
							></menuitem>
							<menuitem 
								label="Facebook" icon="imgs/icons/sbl_share_facebook.png"
								onclick="openPopupCenter('//facebook.com/sharer/sharer.php?u=<?=$shortlinkvideo;?>','_blank', 360, 300);"
							></menuitem>
						</menu>
						<?php if(isLoged()){ ?>
						<menuitem 
							label="Comentar" icon="imgs/icons/sbl_comentario.gif"
							onclick="doWriteMessage();"
						></menuitem>
						<?php } ?>
					</menu>
					
 					<h2><?php echo $Video[0]['Title']; ?></h2>
					<script>document.getElementsByTagName("title")[0].innerHTML = "<?="Assistindo '" . $Video[0]['Title'] ."' - " . $txtChannelTitle; ?>";</script>
 				</center>
 				
 				<br/>
 				<br/>

				<div>
				<!-- p align="justify" style="margin:10px" -->
					<?php 
						//$Conteudo = CodigoParaHTML(Converter_CodigoCaracter(utf8_encode($Video[0]['Description'])));
						
						
						//$Conteudo = Converter_CodigoCaracter(utf8_encode($Video[0]['Description']));
						//$Conteudo = utf8_encode($Video[0]['Description']);
						$Conteudo = $Video[0]['Description'];
						
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

				<br/><br/><hr/>

				<p align="right">
					<nobr>Visualizações: <?=$Video[0]['views'];?></nobr> |
					<nobr>Upload: <?= date("Y-m-d", strtotime($Video[0]['timeRegistration']));?></nobr> |
					<nobr>Publicação: <?=($Video[0]['timePublish']!=""?date("Y-m-d", strtotime($Video[0]['timePublish'])):"<font color='#FF0000'><b>Vídeo Privado</b></font>");?></nobr> |
					<nobr>Atualizado: <?=$Video[0]['timeUpdate'];?></nobr>
				</p><br/>
				
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
						title="Compartilhe este video em seu Diáspora!"
						onclick="openPopupCenter('<?=$LinkDispora;?>','_blank', 480, 550);"
					>
						<img src="imgs/icons/sbl_share_diaspora.png" align="absmiddle" /> Diáspora
					</button>
					<button title="Baixe este vídeo para seu computador!" onclick="window.location='download.php?id=<?=$ID;?>';">
						<img src="imgs/icons/sbl_download.gif" align="absmiddle"/> 
						Download
					</button>
					
					<script>
						
					</script>
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
	<?php }
?>
