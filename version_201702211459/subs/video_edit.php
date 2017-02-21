<?php 
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		$ID=Propriedade("id");
		$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
		//$Video=ConteudoDeTabela("opentube_videos", "ID = $ID");
		//print_r($Video);
		if(count($Video)==1){ ?>
			<center>
				<div class="FormSession" align="left">
					<div id="TitleSession">
						<h2>Edição de Informação de Vídeo</h2>
					</div>
					<hr/><br/>
					<form action="index.php" method="post">
						<input type="hidden" name="sub" value="video_edit_save"/>
						<input type="hidden" name="id" value="<?=$ID;?>"/>
						<table style="width:100%">
							<tr><td colspan="2"><b>Título do Vídeo:</b></td></tr>
							<tr>
								<td colspan="2">
									<input name="txtTitle" type="text" style="width:100%" value="<?=str_replace("\"", "&quot;", $Video[0]['Title'] /*utf8_encode($Video[0]['Title'])/**/ );?>" />
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
										//$Conteudo = CodigoParaHTML(Converter_CodigoCaracter(utf8_encode($Video[0]['Description'])));
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
									?></txtdescription>
								</td>
							</tr>
						
							<tr><td colspan="2"><br/></td></tr>
							
							<tr>
								<td><nobr><b>Vídeo (<?=$Video[0]['videoTypeLink'];?>):</b> </nobr></td>
								<td style="width:100%">
									<a target="_blank" href="<?=$Video[0]['urlVideo'];?>"><?=basename($Video[0]['urlVideo']);?></a>
								</td> 
							</tr>
							<tr>
								<td><nobr><b>Poster (<?=$Video[0]['posterTypeLink'];?>):</b> </nobr></td>
								<td style="width:100%">
									<a target="_blank" href="<?=$Video[0]['urlPoster'];?>"><?=basename($Video[0]['urlPoster']); ?></a>
								</td> 
							</tr>
							<tr>
								<td><nobr><b>Legenda (<?=$Video[0]['subtitleTypeLink'];?>):</b> </nobr></td>
								<td style="width:100%">
									<a target="_blank" href="<?=$Video[0]['urlSubtitle'];?>"><?=basename($Video[0]['urlSubtitle']); ?></a>
								</td> 
							</tr>
							
							<tr><td colspan="2"><br/></td></tr>

							<tr style="width:100%">
								<td><nobr><b>Registro do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<spam><?php
										if($Video[0]['timeRegistration']!=null){
											echo $Video[0]['timeRegistration'];
										}else{
											echo "Nenhum";
										}
									;?></spam>
								</td>
							</tr>
							<tr style="width:100%">
								<td><nobr><b>Atualização do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<spam><?php
										if($Video[0]['timeUpdate']!=null){
											echo $Video[0]['timeUpdate'];
										}else{
											echo "Agora";
										}
									;?></spam>
								</td>
							</tr>
							<tr style="width:100%">
								<td><nobr><b>Publicação do Vídeo:</b> </nobr></td>
								<td style="width:100%">
									<spam><?php
										if($Video[0]['timePublish']!=null){
											echo $Video[0]['timePublish'];
										}else{
											echo "Privado";
										}
									;?></spam>
								</td>
							</tr>

							<tr><td colspan="2"><br/></td></tr>
						
							<tr style="width:100%;">
								<td colspan="2">
									<input type="submit" value="Salvar Alteração"/>
									<input type="button" onclick="window.location='?sub=video&id=<?=$ID;?>';" value="Cancelar">
								</td>
							</tr>
						</table>
					</form>
				</div>
			<center>
		<?php } 
	}
?>
