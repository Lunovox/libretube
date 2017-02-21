<?php
	$Aviso = Propriedade("Aviso");
	
	if(Propriedade("txtServer")!=""){
		if(Propriedade("txtUser")!=""){
			if(Propriedade("txtPassword")!=""){
				if(Propriedade("txtDatabase")!=""){
					$Conteudo = "<?php\n".
						"\t\$mySQL['server']='".Propriedade("txtServer")."';\n".
						"\t\$mySQL['user']='".Propriedade("txtUser")."';\n".
						"\t\$mySQL['password']='".Propriedade("txtPassword")."';\n".
						"\t\$mySQL['database']='".Propriedade("txtDatabase")."';\n".
						"\t\$mySQL['prefix']='".Propriedade("txtPrefix")."';\n".
					"?>";
					
					// Abre ou cria o arquivo bloco1.txt
					// "a" representa que o arquivo é aberto para ser escrito
					// "w+" Abre o arquivo para leitura e escrita; coloca o ponteiro do arquivo no começo e diminui (trunca) o tamanho do arquivo para zero. 
					//		Se o arquivo não existe, tenta criá-lo.
					$Handler = fopen("config.php", "w+");
					if ($Handler == false) die("[ERRO:subs/install.php] Não foi possível criar o arquivo 'config.php'!!!");
					// Escreve "exemplo de escrita" no bloco1.txt
					$escreve = fwrite($Handler, $Conteudo);
					 
					// Fecha o arquivo
					fclose($Handler); //-> OK
				}
			}
		}
	}
	
	if($LunoMySQL->ifAllOk()){
		/*
		
			Aqui deve ser os comandos para instalar as tabelas se elas não existirem
		
		*/
	
		echo "<script>window.location='?sub=profile';</script>";
	}else{ ?>
		<center>
			<form method="POST" enctype="application/x-www-form-urlencoded" >
				<div id="FormSession" align="left">
					<div id="TitleSession">
						<h2>CONFIGURAÇÃO MYSQL</h2>
					</div>
					<img_ src="imgs/backgrounds/pass_key.png" /><br/>

					<?php if($Aviso!=""){ echo "<div style='background:#FFFF00; padding:5px; border-width:1px; border-style:dashed; border-color:#000000; font-size:18px;' >$Aviso</div>"; } ?>
					<b>Servidor:</b><br/>
					<input id="txtServer" name="txtServer" type="text" required="true" autocomplete="true" value="<?=Propriedade("txtServer")!=""?Propriedade("txtServer"):"localhost";?>"/><br/>
					<b>Usuário:</b><br/>
					<input id="txtUser" name="txtUser" type="text" required="true" autocomplete="true" value="<?=Propriedade("txtUser")!=""?Propriedade("txtUser"):"root";?>"/><br/>
					<b>Senha:</b><br/>
					<input id="txtPassword" name="txtPassword" type="password" required="true" autocomplete="true" value="<?=Propriedade("txtPassword")!=""?Propriedade("txtPassword"):"";?>"/><br/>
					<b>Banco de Dados:</b><br/>
					<input id="txtDatabase" name="txtDatabase" type="text" required="true" autocomplete="true" value="<?=Propriedade("txtDatabase")!=""?Propriedade("txtDatabase"):"libretube";?>"/><br/>
					<b>Prefixo de tabelas:</b><br/>
					<input id="txtPrefix" name="txtPrefix" type="text" required="true" autocomplete="true" value="<?=Propriedade("txtPrefix")!=""?Propriedade("txtPrefix"):"libretube_";?>"/><br/>
					<input type="submit" formaction="?sub=install" value="Configurar"/> 
				</div>
			</form>
		<center>	
	<?php }
	
?>


