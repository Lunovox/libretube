<?php 
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		$ID=Propriedade("id");
		$set=Propriedade("set");
		$aviso="";
		if($ID!=""){
			if($set=="public" || $set=="private"){
				
				$Consulta="UPDATE ".$LunoMySQL->getConectedPrefix()."videos SET "
					."timePublish=".($set=="public"?("'".date("Y-m-d H:i:s")."'"):"NULL")
				." WHERE ID=".$ID.";";
				
				$LunoMySQL->getResult($Consulta); ?>
				<script language="JavaScript">
					window.location="?sub=video&id=<?=$ID;?>";
				</script><?php
				exit(1);
			}else{alert("Configuração de acesso a vídeo inválida!");}
		}else{alert("ID de vídeo inválido!");}
	}	
?>
<script language="JavaScript">
	window.location="?sub=video&id=<?=$ID;?>";
</script>