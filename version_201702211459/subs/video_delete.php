<script language="JavaScript">
<?php 
	$aviso="";
	$ID=Propriedade("id");
	$Redirect = Propriedade("redirect");
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		if($ID!=""){
			$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
			if(count($Video)==1){
				if($Video[0]['videoTypeLink']=="local"){
					@unlink($Video[0]['urlVideo']);
				}
				if($Video[0]['posterTypeLink']=="auto" || $Video[0]['posterTypeLink']=="local"){
					@unlink($Video[0]['urlPoster']);
				}
				if($Video[0]['subtitleTypeLink']=="local"){
					@unlink($Video[0]['urlSubtitle']);
				}
				
				$LunoMySQL->getResult("DELETE FROM ".$LunoMySQL->getConectedPrefix()."videos WHERE ID = $ID"); 
				echo "window.location='?".($Redirect!=""?$Redirect:("sub=video_list&order=recents"))."';";
				//exit(1);
			}else{$aviso="Não existe nenhum vídeo nº '$ID!' no banco de dados!";}
		}else{$aviso="Favor declare o número de identificação do vídeo!";}
	}else{$aviso="Você necessita de privilégio 'moderator' ou 'proprietário' para apagar vídeos!";}
	
	if($aviso!=""){
		echo "window.location='"
		.($Redirect!=""?("&redirect=".$Redirect):("?sub=video&id=".$ID))
		."&aviso=".urlencode($aviso)."';";
	}
?>
</script>		

