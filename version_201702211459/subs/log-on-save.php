<?php 
	$aviso="";

	$txtUsername=str_replace("'", "&#039;", Propriedade("txtUsername"));
	$txtEmail=Propriedade("txtEmail");
	$txtSenha=Propriedade("txtSenha");
	
	if($txtUsername!=""){
		if($txtEmail!=""){
			if($txtSenha!=""){
				
				//INSERT INTO `libretube`.`libretube_users` 
				//(`ID`, `Username`, `Email`, `Senha`, `SenhaAuth`, `urlAvatar`, `Created`, `LastLogin`, `NivelDeAcesso`) 
				//VALUES (NULL, 'Lunovox', 'lunovox@openmailbox.org', '123456789', NULL, NULL, CURRENT_TIMESTAMP, NOW(), 'owner');
				$Consulta="INSERT INTO ".$LunoMySQL->getConectedPrefix()."users ("
					."ID, Username, Email, Senha, SenhaAuth, urlAvatar, Created, LastLogin, NivelDeAcesso"
				.") VALUES ("
					."NULL, " //ID
					."'".$txtUsername."', "
					."'".$txtEmail."', "
					."PASSWORD('".$txtSenha."'), "
					."NULL, " //SenhaAuth
					."NULL, " //urlAvatar
					."CURRENT_TIMESTAMP, "  //Created
					."NOW(), " //LastLogin
					."'".(countUsers()==0?"owner":"user")."'" //NivelDeAcesso
				.");";
				$LunoMySQL->getResult($Consulta); 
				setLogin($txtEmail, $txtSenha);?>
				<script language="JavaScript">
					//alert('aaaaaa');
					window.location="?sub=home";
				</script><?php
				 exit(1);

			}else{$aviso="ERRO: 'txtSenha' está vazio!";}
		}else{$aviso="ERRO: 'txtEmail' está vazio!";}
	}else{$aviso="ERRO: 'txtUsername' está vazio!";}	
	
	if($aviso!=""){?>
		<script language="JavaScript">
			window.location="?sub=log-on"
			+"&txtUsername=<?=urlencode($txtUsername);?>"
			+"&txtEmail=<?=urlencode($txtEmail);?>"
			+"&aviso=<?=urlencode($aviso);?>"
			+"";
		</script><?php
	}
?>
