<?php 
//------------------------------------------------------------------------------------------------
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ALL | E_STRICT);
	error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	//ini_set('default_charset','utf-8');
	
	date_default_timezone_set("America/Recife"); //-0300
	
	require_once "libs/libGeral.php";
	require_once "libs/libMySQL2.php";

//------------------------------------------------------------------------------------------------
	//if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
	$LunoMySQL = new LunoMySQL;
	if($LunoMySQL->ifAllOk()){
		$UserID = Propriedade("u");
		$Token = Propriedade("t");
		$VideoID = Propriedade("v");
		$Comment=Propriedade("c");
		$Comment=str_replace("\n", "", $Comment);
		$Comment=str_replace("'", "&#039;", $Comment);
		//echo $Comment."\n\n";

		if($UserID!=""){
			$Users=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."users", "ID='$UserID'");
			if(count($Users)>=1){
				$Auth=getAuth($Users[0]['Email'], md5($Users[0]['Senha']), $Users[0]['NivelDeAcesso']);
				if($Token!=""){
					if($Token==$Auth){
						if($VideoID>=0){
							if($Comment!=""){
								$Consulta="INSERT INTO libretube_comments ("
									."VideoID, UserID, Comment"
								.") VALUES ("
									."'$VideoID', '$UserID', '$Comment'"
								.");";
								echo $Consulta."\n\n";
								$LunoMySQL->getResult($Consulta); 
							}else{
								echo "[ERRO:comment_add.php] Comentário não Declarado!";
							}
						}else{
							echo "[ERRO:comment_add.php] Vídeo não Declarado!";
						}
					}else{
						echo "[ERRO:comment_add.php] Token inválido!";
					}
				}else{
					echo "[ERRO:comment_add.php] Token não Declarado!";
				}
			}else{
				echo "[ERRO:comment_add.php] Usuário '$UserID' não registrado!";
			}
		}else{
			echo "[ERRO:comment_add.php] Usuário não Declarado!";
		}
	}else{
		echo "[ERRO:comment_add.php] \$LunoMySQL->ifAllOk() retornou 'false'!";
	}
?>
