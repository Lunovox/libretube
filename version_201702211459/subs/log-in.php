<script language="JavaScript"><?php
	$LogEmail = Propriedade("LogEmail");
	$LogPass = Propriedade("LogPass");
	$Redirect = Propriedade("redirect");
	$LogIn = setLogin($LogEmail, $LogPass);
	//echo "//setLogin($LogEmail, $LogPass) == $LogIn\n";
	if($LogIn){
		if($Redirect!=""){
			echo "window.location='?".$Redirect."';";
		}else {
			echo "window.location='?sub=home';";
		}
	}else{
		echo "window.location='?sub=log"
		."&LogEmail=".$LogEmail
		.($Redirect!=""?("&redirect=".urlencode($Redirect)):"")
		."&aviso=".urlencode("Email ou Senha inválidos!")."';";
		//setLogout();
	}
?></script>
