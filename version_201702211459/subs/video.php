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
	 					<iframe 
	 						src="embed.php?video=<?=$ID;?>&autoplay=true" 
	 						style="width:720px; height:405px; border:0px;"
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
				</div>
			</center>
		<?php
		}else{require_once "subs/forbidden.php";}
	}
?>
