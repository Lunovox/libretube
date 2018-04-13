<?php
	function Propriedade($NomeDaPropriedade=NULL){
		if(isset($NomeDaPropriedade) && $NomeDaPropriedade!=""){
			if(isset($_FILES[$NomeDaPropriedade]) && $_FILES[$NomeDaPropriedade]!=""){
				$Conteudo=$_FILES[$NomeDaPropriedade];
			}elseif(isset($_POST[$NomeDaPropriedade]) && $_POST[$NomeDaPropriedade]!=""){
				$Conteudo=$_POST[$NomeDaPropriedade];
			}elseif(isset($_GET[$NomeDaPropriedade]) && $_GET[$NomeDaPropriedade]!=""){
				$Conteudo=$_GET[$NomeDaPropriedade];
			}
			if(isset($Conteudo)){return $Conteudo;}
		}
	}
	
	function getAdler32($myTexto=""){
		return strtoupper(hash("adler32", $myTexto, FALSE));
	}
	function getHashtags($Texto){
		preg_match_all('/#([^\s]+)/', strip_tags($Texto), $matches);
		$hashtags = @$matches[1];
		if(count($hashtags)>=1){
			return $hashtags;
		}
	}
	function getMakeLinks($Texto){
		$hashtags = getHashtags($Texto);
		for($H=0; $H<count($hashtags); $H++){
			$link='http://'.$_SERVER['HTTP_HOST'].str_replace("index.php", "", str_replace("embed.php", "", $_SERVER['SCRIPT_NAME']))."?sub=video_list&order=search&q=%23".strtolower($hashtags[$H]);
			$Texto = str_replace(
				"#".$hashtags[$H],
				"<a target='_blank' href='$link'>#".$hashtags[$H]."</a>",
				$Texto
			);
		}
		return $Texto;
	}
	function utf16_decode( $str ) {
		if( strlen($str) < 2 ){ return $str; }
		$bom_be = true;
		$c0 = ord($str{0});
		$c1 = ord($str{1});
		if( $c0 == 0xfe && $c1 == 0xff ) { $str = substr($str,2); }
		elseif( $c0 == 0xff && $c1 == 0xfe ) { $str = substr($str,2); $bom_be = false; }
		$len = strlen($str);
		$newstr = '';
		for($i=0;$i<$len;$i+=2) {
			if( $bom_be ) { $val = ord($str{$i})   << 4; $val += ord($str{$i+1}); }
			else {        $val = ord($str{$i+1}) << 4; $val += ord($str{$i}); }
			$newstr .= ($val == 0x228) ? "\n" : chr($val);
		}
		return $newstr;
	}
	function countUsers(){
		$LunoMySQL = new LunoMySQL;
		if($LunoMySQL->ifAllOk()){
			$Users=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."users");
			return count($Users);
		}
	}
	function getAuth($Email, $Pass, $Type){
		if(
			$Email!=null && $Email!="" 
			&& $Type!=null && $Type!="" 
			&& $Pass!=null && $Pass!="" 
		){
			return md5("auth:".$Email.":".$Pass.":".$Type.":".date("yyyy-mm-dd"));
		}
	}
	function setLogin($Email="", $Senha=""){
		$LunoMySQL = new LunoMySQL;
		if($LunoMySQL->ifAllOk()){
			if($Email!="" && $Senha!=""){
				$Users=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."users", "Email='$Email' AND Senha=PASSWORD('$Senha')");
				if(count($Users)>=1){
					$_SESSION["log-email"] = $Email;
					$_SESSION["log-user-id"] = $Users[0]['ID'];
					$_SESSION["log-user-name"] = $Users[0]['Username'];
					$_SESSION["log-type"] = $Users[0]['NivelDeAcesso'];
					$_SESSION["log-pass"] = md5($Users[0]['Senha']);
					//$_SESSION["log-pass"] = md5($Senha);
					//$_SESSION["log-auth"] = md5("auth:".$_SESSION["log-email"].$_SESSION["log-pass"].$_SESSION["log-type"].date("yyyy-mm-dd"));
					//$_SESSION["log-auth"] = md5("auth:".$_SESSION["log-email"].":".$_SESSION["log-pass"].":".$_SESSION["log-type"].":".date("yyyy-mm-dd"));
					$_SESSION["log-auth"]=getAuth($_SESSION["log-email"], $_SESSION["log-pass"], $_SESSION["log-type"]);
 
 					$Comando="UPDATE ".$LunoMySQL->getConectedPrefix()."users SET LastLogin = NOW()	WHERE Email='$Email'";
					//SQL_Consulta($Comando);
					$LunoMySQL->getResult($Comando);
					return true;
				}
			}
		}
		/**/
		return false;
	}
	function setLogout(){
		unset($_SESSION["log-email"]);
		unset($_SESSION["log-user-id"]);
		unset($_SESSION["log-user-name"]);
		unset($_SESSION["log-type"]);
		unset($_SESSION["log-pass"]);
		unset($_SESSION["log-auth"]);
	}
	function isLoged(){
		if(isset($_SESSION["log-email"]) && isset($_SESSION["log-type"]) && isset($_SESSION["log-pass"]) && isset($_SESSION["log-auth"])){
			$Auth = getAuth($_SESSION["log-email"], $_SESSION["log-pass"], $_SESSION["log-type"]);
			//return $_SESSION["log-auth"]==md5("auth:".$_SESSION["log-email"].":".$_SESSION["log-pass"].":".$_SESSION["log-type"].":".date("yyyy-mm-dd"))
			return $_SESSION["log-auth"]==$Auth;
		}
		return false;
	}
	function getLogedType(){
		if(isLoged()){
			return $_SESSION["log-type"];
		}
		return "none";
	}
	function getLogedEmail(){
		if(isLoged()){
			return $_SESSION["log-email"];
		}
		return "";
	}
	function getLogedUsername(){
		if(isLoged()){
			return $_SESSION["log-user-name"];
		}
		return "";
	}
	function getLogedUserID(){
		if(isLoged()){
			return $_SESSION["log-user-id"];
		}
		return "";
	}
	function getLogedAuth(){
		if(isLoged()){
			return $_SESSION["log-auth"];
		}
		return "";
	}
	function isLogedOwner(){
		return getLogedType()=="owner";
	}
	function isLogedUser(){
		return getLogedType()=="user";
	}
	function isLogedModerator(){
		return getLogedType()=="moderator";
	}
?>
