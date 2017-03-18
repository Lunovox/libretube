<?php 
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		/*
		http://tuatec.ddns.net/apps/opentube/index.php?sub=video_edit_save
		&id=20
		&txtTitle=Sunya+%28feat.+AZU%29+-+To+You...+Mouichido[%3F%3F%3F%3F+%3D+mais+uma+vez]+%28PV%29
		&mce_0=%3Cp+style%3D%22text-align%3A+center%3B%22%3E%3Cstrong%3Etryrt+yrty+r+trret%3C%2Fstrong%3E%3C%2Fp%3E%0D%0A%3Cp%3Er+tyrty%3Cbr+%2F%3Ertyr%3Cbr+%2F%3Etyr%3C%2Fp%3E%0D%0A%3Cp%3Ertur+tyuty%3C%2Fp%3E
		&chkVideoTypeLink=remote
		&urlVideoRemote=https%3A%2F%2Fcloud.openmailbox.org%2Findex.php%2Fs%2FXtt5eX3dcoI7KYq%2Fdownload
		&urlVideoRedirect=
		&urlVideoLocal=
		&chkPosterTypeLink=remote
		&urlVideoRemote=https%3A%2F%2Fcloud.openmailbox.org%2Findex.php%2Fs%2FlPnZxNogwVMIDeE%2Fdownload
		&urlVideoRedirect=
		&urlVideoLocal=
		*/
		$aviso="";
		$ID=Propriedade("id");
		//$txtTitle=str_replace("'", "&#039;", utf8_decode(Propriedade("txtTitle")));
		//$txtDescription=str_replace("'", "&#039;", utf8_decode(Propriedade("mce_0")));
		$txtTitle=str_replace("'", "&#039;", Propriedade("txtTitle"));
		$txtDescription=str_replace("'", "&#039;", Propriedade("mce_0"));
		
		if($ID!=""){
			if($txtTitle!=""){
				$Consulta="UPDATE ".$LunoMySQL->getConectedPrefix()."videos SET "
					."Title='".$txtTitle."'"
					.", Description='".$txtDescription."'"
					.", timeUpdate='".date("Y-m-d H:i:s")."'"
				." WHERE ID=".$ID.";";
				$LunoMySQL->getResult($Consulta); ?>
				<script language="JavaScript">
					window.location="?sub=video&id=<?=$ID;?>";
				</script><?php
				exit(1);
			}else{$aviso="Digite o Título do vídeo";}
		}else{$aviso="Numeração ID de vídeo inválida!!";} ?>
		<script language="JavaScript">
			window.location="?sub=video_edit"
			+"&id=<?=$ID;?>"
			+"&txtTitle=<?=urlencode($txtTitle);?>"
			+"&txtDescription=<?=urlencode($txtDescription);?>"
			+"&aviso=<?=urlencode($aviso);?>"
			+"";
		</script><?php
	}else{require_once "subs/forbidden.php";}
?>