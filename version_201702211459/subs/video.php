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
			
			$myLinks = new DownLoadLink($ID); 
			//print_r($_SERVER);
			//echo "aaa --> ".$myLinks->getRedirectShortLink();
			//echo "aaa --> ".$myLinks->getID();
			
			?>
			<script> 
				document.getElementsByTagName("title")[0].innerHTML = "<?="Assistindo '" . $Video[0]['Title'] ."' - " . $txtChannelTitle; ?>"; 
			</script>
			<center>
				<div class="FormSession" align="justify">
	 				<center>
	 					<iframe id="VideoPlayer" allowtransparency="true" allowfullscreen="true"
	 						src="embed.php?video=<?=$ID;?>&autoplay=true" 
	 					></iframe>
	 				</center>

 					<h2 class="fixTitle"><?php echo $Video[0]['Title']; ?></h2>
 					
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
						
						if($Conteudo!=""){ ?>
						<br/>
						<details>
							<summary style="cursor:pointer; color:green;"><b>Descrição do vídeo...</b></summary>
							<div><?php
								$Conteudo=str_replace("&#039;", "'", $Conteudo);
								echo getMakeLinks($Conteudo);
							?></div>
						</details>
					<?php } ?>
					
					
					<br/>
					<center>
						<?php if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>
						
						<script>
							function btnEditar(){
								window.location='?sub=video_edit&id=<?=$ID;?>';
							}
							function btnApagar(){
								if(confirm('Deseja realmente apagar este vídeo?')){
									window.location='?sub=video_delete&id=<?=$ID;?>';
								}
							}
							function btnPublicacao(){
								if(confirm('Deseja realmente <?=($Video[0]['timePublish']!=''?'privatizar':'publicar');?> este vídeo?')){
									window.location='?sub=video_access&set=<?=($Video[0]['timePublish']!=''?'private':'public');?>&id=<?=$ID;?>';
								}
							}
						</script>
						<button onclick="btnEditar();" >
							<img src="imgs/icons/sbl_lapis.gif" align="absmiddle"	/> Editar
						</button>
						<button onclick="btnApagar();">
							<img src="imgs/icons/sbl_negar.gif" align="absmiddle" /> Apagar
						</button>
						<!--button
							title="Adicione este vídeo a uma Lista!"
							onclick="openPopupCenter('playlist_form.php?id=<?=$ID;?>','_blank', 330, 330);"
						>
							<img src="imgs/icons/sbl_percevejo.gif" align="absmiddle" /> Adicionar a Lista
						</button-->
						<button onclick="btnPublicacao();">
							<img src="imgs/icons/<?=($Video[0]['timePublish']!=''?'sbl_cadeado_preto.gif':'sbl_planeta.gif');?>" align="absmiddle" />
							<?=($Video[0]['timePublish']!=''?'Privatizar':'Publicar');?>
							
						</button>
					<?php } ?> 
						
					<?php /* ?>
						<button 
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
					<?php /**/ ?>
						
					</center>
					
				</div> <!-- Fim de DIV FormSession -->
			</center>
			
		<?php
		}else{require_once "subs/forbidden.php";}
	}
?>
