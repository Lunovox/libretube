<?php 
	/*
	print_r($_GET);
	print_r($_POST);
	print_r($_FILES); 
	/**/
?>

<?php 
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
	$upload_dir="./vids/";
	$upload_max_size=1073741824; //1*1024*1024*1024 = 1GB
	if(getLogedType()=="owner" || getLogedType()=="moderator"){ 
		//$txtTitle=str_replace("'", "&#039;", urldecode(Propriedade("txtTitle")));
		//$txtDescription=str_replace("'", "&#039;", urldecode(Propriedade("mce_0")));
		//$txtTitle=str_replace("'", "&#039;", utf8_decode(Propriedade("txtTitle")));
		//$txtDescription=str_replace("'", "&#039;", utf8_decode(Propriedade("mce_0")));
		$txtTitle=str_replace("'", "&#039;", Propriedade("txtTitle"));
		$txtDescription=str_replace("'", "&#039;", Propriedade("mce_0"));
		
		$chkVideoTypeLink=Propriedade("chkVideoTypeLink")!=""?Propriedade("chkVideoTypeLink"):"local";
		$urlVideoRemote=Propriedade("urlVideoRemote");
		$urlVideoRedirect=Propriedade("urlVideoRedirect");
		$urlVideoLocal=Propriedade("urlVideoLocal");
		
		$chkPosterTypeLink=Propriedade("chkPosterTypeLink")!=""?Propriedade("chkPosterTypeLink"):"local";
		$urlPosterRemote=Propriedade("urlPosterRemote");
		$urlPosterLocal=Propriedade("urlPosterLocal");
		
		$chkSubtitleTypeLink=Propriedade("chkSubtitleTypeLink")!=""?Propriedade("chkSubtitleTypeLink"):"none";
		$urlSubtitleRemote=Propriedade("urlSubtitleRemote");
		$urlSubtitleLocal=Propriedade("urlSubtitleLocal");


		$chkPublicarVideo=Propriedade("chkPublicarVideo")=="true"?"NOW()":"NULL";
		
		$aviso="";
		
		if($txtTitle!=""){
			if($chkVideoTypeLink=="remote" || $chkVideoTypeLink=="redirect" || $chkVideoTypeLink=="local"){
				if($chkPosterTypeLink=="remote" || $chkPosterTypeLink=="local"){
					if($chkSubtitleTypeLink=="none" || $chkSubtitleTypeLink=="remote" || $chkSubtitleTypeLink=="local"){
				
						$urlVideo="";
						if($chkVideoTypeLink=="remote" && $urlVideoRemote!=""){
							$urlVideo=$urlVideoRemote;
						}elseif($chkVideoTypeLink=="redirect" && $urlVideoRedirect!=""){
							$urlVideo=$urlVideoRedirect;
						}elseif($chkVideoTypeLink=="local" && $urlVideoLocal!=""){
							$error=@$urlVideoLocal['error'];
							$size=@$urlVideoLocal['size'];
							$type=@$urlVideoLocal['type'];
							//$url=$upload_dir.basename($urlVideoLocal['tmp_name'])."_vid";
							$url=$upload_dir.md5($txtTitle)."_vid"."_".basename($urlVideoLocal['tmp_name']);
							if($error==UPLOAD_ERR_INI_SIZE){
								$aviso="[1] O tamanho o arquivo de vídeo é muito grande!";
							}elseif($error==UPLOAD_ERR_FORM_SIZE){
								$aviso="[2] O tamanho o arquivo de vídeo é muito grande!";
							}elseif($error==UPLOAD_ERR_OK && $size>$upload_max_size){
								$aviso="[3] O tamanho o arquivo de vídeo é muito grande!";
							}elseif($error==UPLOAD_ERR_PARTIAL){
								$aviso="[4] Ocorreu um upload parcial do arquivo de vídeo!";
							}elseif($error==UPLOAD_ERR_NO_FILE){
								$aviso="[5] Nenhum arquivo de vídeo foi selecionado!!!";
							}elseif(!in_array($type, array('video/ogg','video/webm','video/mp4','audio/ogg'))){
								$aviso="[6:".$type."] Favor adicione arquivo de vídeo do tipo 'OGG', 'OGV', 'WEBM', ou 'MP4'!";
								//exit(1);
							}elseif(move_uploaded_file($urlVideoLocal['tmp_name'],$url)){
								$urlVideo=$url;
								//$aviso="Upload feito com sucesso!";
							}else{
								$aviso="Erro desconhecido de upload de vídeo!";
							}
						}
			
						$urlPoster="";
						if($chkPosterTypeLink=="remote" && $urlPosterRemote!=""){
							$urlPoster=$urlPosterRemote;
						}elseif($chkPosterTypeLink=="local" && $urlPosterLocal!=""){
							//$urlPoster="arquivo por upload!!!!";
							$error=@$urlPosterLocal['error'];
							$size=@$urlPosterLocal['size'];
							$type=@$urlPosterLocal['type'];
							//$url=$upload_dir.basename($urlPosterLocal['tmp_name'])."_img";
							$url=$upload_dir.md5($txtTitle)."_img"."_".basename($urlPosterLocal['tmp_name']);
							if($error==UPLOAD_ERR_INI_SIZE){
								$aviso="[1] O tamanho o arquivo de poster é muito grande!";
							}elseif($error==UPLOAD_ERR_FORM_SIZE){
								$aviso="[2] O tamanho o arquivo de poster é muito grande!";
							}elseif($error==UPLOAD_ERR_OK && $size>$upload_max_size){
								$aviso="[3] O tamanho o arquivo de poster é muito grande!";
							}elseif($error==UPLOAD_ERR_PARTIAL){
								$aviso="[4] Ocorreu um upload parcial do arquivo de poster!";
							}elseif($error==UPLOAD_ERR_NO_FILE){
								$aviso="[5] Nenhum arquivo de poster foi selecionado!!!";
							}elseif(!in_array($type, array('image/png','image/jpg','image/jpeg','image/*'))){
								$aviso="[6] Favor adicione arquivo de poster do tipo 'PNG', 'JPG', ou 'JPEG'!";
								//exit(1);
							}elseif(move_uploaded_file($urlPosterLocal['tmp_name'],$url)){
								$urlPoster=$url;
								//$aviso="Upload feito com sucesso!";
							}else{
								$aviso="Erro desconhecido de upload de poster!";
							}
						}
						
						$urlSubtitle="";
						if($chkSubtitleTypeLink=="remote" && $urlSubtitleRemote!=""){
							$urlSubtitle=$urlSubtitleRemote;
						}elseif($chkSubtitleTypeLink=="local" && $urlSubtitleLocal!=""){
							//$urlSubtitle="arquivo por upload!!!!";
							$error=@$urlSubtitleLocal['error'];
							$size=@$urlSubtitleLocal['size'];
							$type=@$urlSubtitleLocal['type'];
							//$url=$upload_dir.basename($urlSubtitleLocal['tmp_name'])."_img";
							$url=$upload_dir.md5($txtTitle)."_sub"."_".basename($urlSubtitleLocal['tmp_name']);
							if($error==UPLOAD_ERR_INI_SIZE){
								$aviso="[1] O tamanho o arquivo de Legenda é muito grande!";
							}elseif($error==UPLOAD_ERR_FORM_SIZE){
								$aviso="[2] O tamanho o arquivo de Legenda é muito grande!";
							}elseif($error==UPLOAD_ERR_OK && $size>$upload_max_size){
								$aviso="[3] O tamanho o arquivo de Legenda é muito grande!";
							}elseif($error==UPLOAD_ERR_PARTIAL){
								$aviso="[4] Ocorreu um upload parcial do arquivo de Legenda!";
							}elseif($error==UPLOAD_ERR_NO_FILE){
								$aviso="[5] Nenhum arquivo de Subtitle foi selecionado!!!";
							}elseif(!in_array($type, array('text/vtt','text/webvtt','text/plain'))){
								$aviso="[6:".$type."] Favor adicione arquivo de Legenda do tipo 'VTT'(WebVTT)!";
								//exit(1);
							}elseif(move_uploaded_file($urlSubtitleLocal['tmp_name'],$url)){
								$urlSubtitle=$url;
								//$aviso="Upload feito com sucesso!";
							}else{
								$aviso="Erro desconhecido de upload de Legenda!";
							}
						}
			
					
						if($aviso==""){
							if($urlVideo!=""){
								if($urlPoster!=""){
									$Consulta="INSERT INTO ".$LunoMySQL->getConectedPrefix()."videos ("
										."ID, urlVideo, videoTypeLink, urlPoster, posterTypeLink, urlSubtitle, subtitleTypeLink, "
										."Title, Description, timeRegistration, timeUpdate, timePublish, "
										."views, shared, shareIDs"
									.") VALUES ("
										."NULL, " //ID
										."'".$urlVideo."', "
										."'".$chkVideoTypeLink."', "
										."'".$urlPoster."', "
										."'".$chkPosterTypeLink."', "
										."'".$urlSubtitle."', "
										."'".$chkSubtitleTypeLink."', "
										."'".$txtTitle."', "
										."'".$txtDescription."', "
										."CURRENT_TIMESTAMP, "
										."NOW(), "
										.$chkPublicarVideo.", "
										."'0', "
										."'0', "
										."''"
									.");";
									$LunoMySQL->getResult($Consulta); ?>
									<script language="JavaScript">
										//alert('aaaaaa');
										window.location="?sub=video_list&order=recents";
									</script><?php
									 exit(1);
								}else{$aviso="Favor adicione o link poster!";}	
							}else{$aviso="Favor adicione o link vídeo!";}	
						}
					}else{$aviso="Tipo de Link de Legenda Inválida!";}	
				}else{$aviso="Tipo de Link de Poster Inválido!";}	
			}else{$aviso="Tipo de Link de Vídeo Inválido!";}
		}else{$aviso="Favor digite o Título do Vídeo!";}
	}else{$aviso="Você necessita de privilégio 'moderator' ou 'proprietário' para registrar novos vídeos!";}	
?>
<script language="JavaScript">
	window.location="?sub=video_add"
	+"&txtTitle=<?=urlencode($txtTitle);?>"
	+"&txtDescription=<?=urlencode($txtDescription);?>"

	+"&chkVideoTypeLink=<?=urlencode($chkVideoTypeLink);?>"
	+"&urlVideoRemote=<?=urlencode($urlVideoRemote);?>"
	+"&urlVideoRedirect=<?=urlencode($urlVideoRedirect);?>"

	+"&chkPosterTypeLink=<?=urlencode($chkPosterTypeLink);?>"
	+"&urlPosterRemote=<?=urlencode($urlPosterRemote);?>"

	+"&chkSubtitleTypeLink=<?=urlencode($chkSubtitleTypeLink);?>"
	+"&urlSubtitleRemote=<?=urlencode($urlSubtitleRemote);?>"

	+"&chkPublicarVideo=<?=($chkPublicarVideo=='NOW()'?'true':'false');?>"

	+"&aviso=<?=urlencode($aviso);?>"
	+"";
</script>