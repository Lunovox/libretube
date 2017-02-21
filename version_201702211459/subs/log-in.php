<script language="JavaScript"><?php
	$LogEmail = Propriedade("LogEmail");
	$LogPass = Propriedade("LogPass");
	$LogIn = setLogin($LogEmail, $LogPass);
	echo "//setLogin($LogEmail, $LogPass) == $LogIn\n";
	if($LogIn){
		echo "window.location='?sub=home';";
	}else{
		echo "window.location='?sub=log&LogEmail=".$LogEmail."&Aviso=".urlencode("Email ou Senha inválidos!")."';";
		//setLogout();
	}
?></script>
