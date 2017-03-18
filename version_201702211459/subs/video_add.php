<?php 
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		$txtTitle=urldecode(Propriedade("txtTitle"));
		$txtDescription=urldecode(Propriedade("txtDescription"));
		
		$chkVideoTypeLink=Propriedade("chkVideoTypeLink")!=""?Propriedade("chkVideoTypeLink"):"local";
		$urlVideoRemote=Propriedade("urlVideoRemote");
		$urlVideoRedirect=Propriedade("urlVideoRedirect");
		$urlVideoLocal=Propriedade("urlVideoLocal");

		$chkPosterTypeLink=Propriedade("chkPosterTypeLink")!=""?Propriedade("chkPosterTypeLink"):"auto";
		$urlPosterRemote=Propriedade("urlPosterRemote");
		$urlPosterLocal=Propriedade("urlPosterLocal");

		$chkSubtitleTypeLink=Propriedade("chkSubtitleTypeLink")!=""?Propriedade("chkSubtitleypeLink"):"none";
		$urlSubtitleRemote=Propriedade("urlSubtitleRemote");
		$urlSubtitleLocal=Propriedade("urlSubtitleLocal");

		?>
			<center>
				<div class="FormSession" align="left">
					<div id="TitleSession">
						<h2>Adicionando Novo Vídeo</h2>
					</div>
					<hr/><br/>
					<script language="JavaScript">

						function doChangeVideoTypeLink(){
							document.getElementById('txtVideoRemote').style.display = 'none';
							document.getElementById('txtVideoRedirect').style.display = 'none';
							document.getElementById('txtVideoLocal').style.display = 'none';

							document.getElementById('urlVideoRemote').required = false;
							document.getElementById('urlVideoRedirect').required = false;
							document.getElementById('urlVideoLocal').required = false;
							
							
							if(document.getElementById('chkVideoTypeLink').value=='remote'){
								document.getElementById('txtVideoRemote').style.display = '';
								document.getElementById('urlVideoRemote').required = true;
							}else if(document.getElementById('chkVideoTypeLink').value=='redirect'){
								document.getElementById('txtVideoRedirect').style.display = '';
								document.getElementById('urlVideoRedirect').required = true;
							}else if(document.getElementById('chkVideoTypeLink').value=='local'){
								document.getElementById('txtVideoLocal').style.display = '';
								document.getElementById('urlVideoLocal').required = true;
							}
						}
						
						function doChangePosterTypeLink(){
							document.getElementById('txtPosterRemote').style.display = 'none';
							document.getElementById('txtPosterLocal').style.display = 'none';

							document.getElementById('urlPosterRemote').required = false;
							document.getElementById('urlPosterLocal').required = false;

							
							if(document.getElementById('chkPosterTypeLink').value=='remote'){
								document.getElementById('txtPosterRemote').style.display = '';
								document.getElementById('urlPosterRemote').required = true;
							}else if(document.getElementById('chkPosterTypeLink').value=='local'){
								document.getElementById('txtPosterLocal').style.display = '';
								document.getElementById('urlPosterLocal').required = true;
							}
						}
						
						function doChangeSubtitleTypeLink(){
							document.getElementById('txtSubtitleRemote').style.display = 'none';
							document.getElementById('txtSubtitleLocal').style.display = 'none';

							document.getElementById('urlSubtitleRemote').required = false;
							document.getElementById('urlSubtitleLocal').required = false;
							
							if(document.getElementById('chkSubtitleTypeLink').value=='remote'){
								document.getElementById('txtSubtitleRemote').style.display = '';
								document.getElementById('urlSubtitleRemote').required = true;
							}else if(document.getElementById('chkSubtitleTypeLink').value=='local'){
								document.getElementById('txtSubtitleLocal').style.display = '';
								document.getElementById('urlSubtitleLocal').required = true;
							}
						}
					</script>
					<form method="POST" enctype="multipart/form-data" action="./?sub=video_add_save">
						<input type="hidden" name="sub" value="video_add_save"/>
						<input type="hidden" name="MAX_FILE_SIZE" value="1073741824"/>
						<table style="width:100%">
							<?php if(Propriedade("aviso")!=""){ ?>
								<tr>
									<td colspan="2" align="center" bgcolor="#FFFF00" 
										style="border-width:1px; border-style:dashed; border-color:#000000"
									>
										<h2><?php
											$Aviso=strip_tags(Propriedade("aviso"));
											$Aviso=str_replace("[FORBIDDEN]", "<img width='200' src='imgs/modelos/sbl_forbidden.png'/><br/>" , $Aviso);
											echo $Aviso
										?></h2>
									</td>
								</tr>
							<?php } ?>
							<tr><td colspan="2"><b>Título do Vídeo:</b></td></tr>
							<tr>
								<td colspan="2">
									<input name="txtTitle" type="text" style="width:100%" required="true" value="<?=$txtTitle;?>" />
								</td>
							</tr>

							<tr><td colspan="2"><br/></td></tr>


							<tr><td colspan="2"><b>Descrição do Vídeo:</b></td></tr>
							<tr>
								<td colspan="2">
									<script src="libs/tinymce_4.3.2/js/tinymce/tinymce.js"></script>
									<script>
										tinymce.init({
											language : 'pt_BR',
											selector: "txtdescription",
											content_css : "estilo_tinymce.css?update=<?=date('Y-m-d H:i:s');?>",    //FONTE: http://www.tinymce.com/wiki.php/Configuration3x:content_css
											element_format : 'html',
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
									</script>
									<txtdescription name="txtDescription" style="width:100%"><?php 
										//$Conteudo = CodigoParaHTML(Converter_CodigoCaracter(utf8_encode($txtDescription)));
										//$Conteudo = utf8_encode($txtDescription);
										$Conteudo = $txtDescription;

									
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
									?></txtdescription>
								</td>
							</tr>
						</table>
						
						<details>
							<summary style="cursor:pointer; color:green;"><b>Informações sobre o servidor...</b></summary>
							<div style="background:rgba(0,128,0,0.1);; border:1px solid rgba(0,0,0,1.0); padding:5px;">
								<table style="width:100%">
									<tr>
										<td align="right"><nobr><b>Espaço em disco:</b></nobr> </td>
										<td style="width:100%; padding-left:10px;">
											<?php 
												echo (
													number_format((disk_free_space("./")/(1024*1024*1024)), 1, ',', '.')." Giga Bytes"
													." (".
														number_format(disk_free_space("./"), 0, ',', '.')." Bytes"
													.")"
												);
											?>
										</td> 
									</tr>
									<tr>
										<td align="right"><nobr><b>Máximo de Upload de Arquivo:</b></nobr> </td>
										<td style="width:100%; padding-left:10px;">
											<?=ini_get('upload_max_filesize'); ?> ('upload_max_filesize' configurado em 'php.ini')
										</td> 
									</tr>
									<tr>
										<td align="right"><nobr><b>Máximo de Upload de Post:</b></nobr> </td>
										<td style="width:100%; padding-left:10px;">
											<?=ini_get('post_max_size'); ?> ('post_max_size' configurado em 'php.ini')
										</td> 
									</tr>
									<tr>
										<td align="right"><nobr><b>Limite de Tempo de Upload:</b></nobr> </td>
										<td style="width:100%; padding-left:10px;">
											<?=ini_get('max_input_time'); ?> segundos ('max_input_time' configurado em 'php.ini')
										</td> 
									</tr>
								</table>
							</div>
						</details> 

						<table style="width:100%">
							<tr><td colspan="2"><br/></td></tr>

							<tr>
								<td><nobr><b>Tipo de Link do Vídeo:</b> </nobr></td>
								<td style="width:100%"
									onChange="doChangeVideoTypeLink();"
								>
									<select id="chkVideoTypeLink" name="chkVideoTypeLink">
										<option value="local" <?php if($chkVideoTypeLink=="local"){echo "selected";} ?>>Local</option>
										<option value="remote" <?php if($chkVideoTypeLink=="remote"){echo "selected";} ?>>Remoto</option>
										<option value="redirect" <?php if($chkVideoTypeLink=="redirect"){echo "selected";} ?>>Redirecionado</option>
									</select>
									<?php if($chkVideoTypeLink=="local"){ ?>
										<b><?=$urlVideoLocal; ?></b>
									<?php } ?>
								</td> 
							</tr>
							<tr id="txtVideoRemote" style="width:100%; <?=$chkVideoTypeLink=="remote"?"":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlVideoRemote" name="urlVideoRemote" type="url" style="width:100%" placeholder="Link Remoto do Vídeo:" 
										value="<?php if($chkVideoTypeLink=='remote'){echo $urlVideoRemote;} ?>"
									/>
								</td>
							</tr>
							<tr id="txtVideoRedirect" style="width:100%; <?=$chkVideoTypeLink=="redirect"?"":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlVideoRedirect" name="urlVideoRedirect" type="url" style="width:100%" placeholder="Redirecionar para Vídeo na URL:" 
										value="<?php if($chkVideoTypeLink=='redirect'){echo $urlVideoRedirect;} ?>"
									/>
								</td>
							</tr>
							<tr id="txtVideoLocal" style="width:100%; <?=$chkVideoTypeLink=="local"?"inline":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlVideoLocal" name="urlVideoLocal" type="file" required="true" placeholder="Arquivo Local de Vídeo:" 
										accept="video/webm,video/ogg,video/mp4,audio/ogg,application/ogg"
										value="<?php if($chkVideoTypeLink=='local'){echo $urlVideoLocal;} ?>"
										onchange="if(this.files[0].size>1073741824){alert('O vídeo está com um tamanho acima do tamanho permitido!');}"
									/>
								</td>
							</tr>
						
							<tr><td colspan="2"><br/></td></tr>
						
							<tr>
								<td><nobr><b>Tipo de Link do Poster:</b> </nobr></td>
								<td style="width:100%"
									onChange="doChangePosterTypeLink();"
								>
									<select id="chkPosterTypeLink" name="chkPosterTypeLink">
										<option value="auto" <?php if($chkPosterTypeLink=="auto"){echo "selected";} ?>>Automático</option>
										<option value="local" <?php if($chkPosterTypeLink=="local"){echo "selected";} ?>>Local</option>
										<option value="remote" <?php if($chkPosterTypeLink=="remote"){echo "selected";} ?>>Remoto</option>
									</select>
									<?php if($chkPosterTypeLink=="local"){ ?>
										<b><?=$urlPosterLocal; ?></b>
									<?php } ?>
								</td> 
							</tr>
							<tr id="txtPosterRemote" style="width:100%; <?=$chkPosterTypeLink=="remote"?"":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlPosterRemote" name="urlPosterRemote" type="url" style="width:100%" placeholder="Link Remoto do Poster:" 
										value="<?php if($chkPosterTypeLink=='remote'){echo $Video[0]['urlPoster'];} ?>"
									/>
								</td>
							</tr>
							<tr id="txtPosterLocal" style="width:100%; <?=$chkPosterTypeLink=="local"?"inline":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlPosterLocal" name="urlPosterLocal" type="file" placeholder="Arquivo Local de Poster:" 
										accept="image/png, image/jpeg, image/gif, image/*"
										value="<?php if($chkPosterTypeLink=='local'){echo $urlPosterLocal;} ?>"
										onchange="if(this.files[0].size>1073741824){alert('O poster está com um tamanho acima do tamanho permitido!');}"
									/>
								</td>
							</tr>
							
							<tr><td colspan="2"><br/></td></tr>
							
							<tr>
								<td><nobr><b>Tipo de Link da Legenda:</b> </nobr></td>
								<td style="width:100%"
									onChange="doChangeSubtitleTypeLink();"
								>
									<select id="chkSubtitleTypeLink" name="chkSubtitleTypeLink">
										<option value="none" <?php if($chkSubtitleTypeLink=="none"){echo "selected";} ?>>Nenhuma</option>
										<option value="local" <?php if($chkSubtitleTypeLink=="local"){echo "selected";} ?>>Local</option>
										<option value="remote" <?php if($chkSubtitleTypeLink=="remote"){echo "selected";} ?>>Remota</option>
									</select>
									<?php if($chkSubtitleTypeLink=="local"){ ?>
										<b><?=$urlSubtitleLocal; ?></b>
									<?php } ?>
								</td> 
							</tr>
							<tr id="txtSubtitleRemote" style="width:100%; <?=$chkSubtitleTypeLink=="remote"?"":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlSubtitleRemote" name="urlSubtitleRemote" type="url" style="width:100%" placeholder="Link Remoto da Legenda WebVTT (.vtt):" 
										value="<?php if($chkSubtitleTypeLink=='remote'){echo $urlSubtitleRemote;} ?>"
									/>
								</td>
							</tr>
							<tr id="txtSubtitleLocal" style="width:100%; <?=$chkSubtitleTypeLink=="local"?"inline":"display:none"; ?>;">
								<td colspan="2">
									<input id="urlSubtitleLocal" name="urlSubtitleLocal" type="file" placeholder="Arquivo Local da Legenda WebVTT (.vtt):" 
										accept="text/vtt, text/webvtt, .vtt, application/ttml+xml, .ttml"
										value="<?php if($chkSubtitleTypeLink=='local'){echo $urlSubtitleLocal;} ?>"
										onchange="if(this.files[0].size>1073741824){alert('A Legenda está com um tamanho acima do tamanho permitido!');}"
									/>
								</td>
							</tr>
						
							<tr><td colspan="2"><br/></td></tr>

							<tr style="width:100%">
								<td><nobr><b>Registro do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<spam>Agora</spam>
								</td>
							</tr>
							<tr style="width:100%">
								<td><nobr><b>Atualização do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<spam>Agora</spam>
								</td>
							</tr>
							<tr style="width:100%">
								<td><nobr><b>Publicação do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<input id="chkPublicarVideo" name="chkPublicarVideo" type="checkbox" valign="top" value="true" />
									<label for="chkPublicarVideo">Publicar após a postagem do vídeo</label>
								</td>
							</tr>

							<tr><td colspan="2"><br/></td></tr>
						
							<tr style="width:100%;">
								<td colspan="2">
									<input size='big' type="submit" value="Subir Vídeo"/>
									<input type="button" onclick_="window.location='./?aviso=aaaaa';" value="Cancelar">
								</td>
							</tr>
						</table>
					</form>
				</div>
			<center>
		<?php 
	}else{require_once "subs/forbidden.php";}
?>
