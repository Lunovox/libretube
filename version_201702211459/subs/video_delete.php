<?php 
	$aviso="";
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		$ID=Propriedade("id");
		if($ID!=""){
			$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
			if(count($Video)==1){
				if($Video[0]['videoTypeLink']=="local"){@unlink($Video[0]['urlVideo']);}
				if($Video[0]['posterTypeLink']=="auto" || $Video[0]['posterTypeLink']=="local"){
					@unlink($Video[0]['urlPoster']);
				}
				
				$LunoMySQL->getResult("DELETE FROM ".$LunoMySQL->getConectedPrefix()."videos WHERE ID = $ID"); ?>
				<script language="JavaScript">
					window.location="?sub=video_list&order=recents";
				</script><?php
				 exit(1);
			}else{$aviso="Não existe nenhum vídeo com '$ID!' no banco de dados!";}
		}else{$aviso="Favor declare o número de identificação do vídeo!";}
	}else{$aviso="Você não tem permissão de editar este vídeo!";}
?>
<script language="JavaScript">
	window.location="?sub=video"
	+"&id=<?=$ID;?>"
	+"&aviso=<?=urlencode($aviso);?>"
	+"";
</script>		

