<?php
	/*
		Este feed foi feito no padrão Atom (e não por RSS que é proprietário)
		FONTE: https://pt.wikipedia.org/wiki/Atom
	*/
	
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ALL | E_STRICT);
	error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	//ini_set('default_charset','utf-8');
	
	date_default_timezone_set("America/Recife"); //-0300
	
	require_once "libs/libGeral.php";
	
	$format = Propriedade("format");
	if($format=="txt" || $format=="text"){
		header('Content-type: text/plain; charset=utf-8');
	}elseif($format=="xml"){
		header('Content-Type: text/xml; charset=utf-8');
	}else{
		header('Content-Type: application/atom+xml; charset=utf-8');
	}
	
	$thisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	$base=str_replace("atom.php", "", $thisURL);
	//$urlLibretube = 'http://'.$_SERVER['HTTP_HOST'].str_replace("index.php","",$_SERVER['SCRIPT_NAME']);

	require_once "libs/libMySQL2.php";
	
	$LunoMySQL = new LunoMySQL;
	if($LunoMySQL->ifAllOk()){
		$order = Propriedade("order");
		if($order=="mostviews"){
			$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL" , "views DESC", null, 0, 29);
			$Order = "MAIS VISTOS";
		}else{
			$Videos=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL" , "timeUpdate DESC", null, 0, 29);
			$Order = "RECENTES";
		}

		$Configs=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."config");
		if(count($Configs)>=1){$Config= $Configs[0];}
	}
	$txtTitleFeed = ((isset($Config['ChannelName']) && $Config['ChannelName']!="")?$Config['ChannelName']." ($Order) - ":"($Order) - ")."LIBRETUBE";
	$imgBanner = (isset($Config['urlBanner']) && $Config['urlBanner']!="")?$Config['urlBanner']:$base.'imgs/banners/banner_libretube.png';
	$imgIcon = $base.'imgs/icons/sbl_libretube.ico';
	$imgDateTime = date("Y-m-d\TH:i:s\Z"); //2003-12-13T18:30:02Z
	//print_r($Videos);
?>

<feed xmlns="http://www.w3.org/2005/Atom">

	<title><![CDATA[<?=$txtTitleFeed;?>]]></title>
	<subtitle><![CDATA[A sua TV Open Source]]></subtitle>
	<category term="libretube"/>
	<rights>AGPL - </rights>
	<link href="<?=$base;?>" />
	<id><?=$thisURL."?update=".$imgDateTime;?></id>
	<updated><?=$imgDateTime;?></updated>
	<icon><?=$imgIcon;?></icon>
	<logo><?=$imgBanner;?></logo>
	
	<?php
		for($V=0; $V<count($Videos); $V++){ 
			$urlVideoLink=($Videos[$V]['videoTypeLink']=="redirect")?$Videos[$V]['urlVideo']:$base.'?video='.$Videos[$V]['ID'];
			$urlPoster=$Videos[$V]['urlPoster'];
			//$txtDescription=utf8_encode((isset($Videos[$V]['Description']) && $Videos[$V]['Description']!="")?$Videos[$V]['Description']:"");
			$txtDescription=(isset($Videos[$V]['Description']) && $Videos[$V]['Description']!="")?$Videos[$V]['Description']:"";
		
			?>
			<entry>
				<title><![CDATA[<?=($Videos[$V]['Title']);?>]]></title>
				<link href="<?=$urlVideoLink;?>" />
				<id><?=$base.'?video='.$Videos[$V]['ID'];?></id>
				<updated><?=date("Y-m-d\TH:i:s\Z",strtotime($Videos[$V]['timeUpdate']));?></updated>
				<summary type="html"><![CDATA[
					
					<a target="_blank" href="<?=$urlVideoLink;?>">
						<img src="<?=$urlPoster;?>" width="600px" />
					</a><br/>
					<?php echo $txtDescription; ?>
					
				]]></summary>
				<?php
					//<link rel="enclosure" type="video/ogg" href="<?=$Videos[$V]['urlVideo'];?\\\\\\\\\\\\\\\\\\>" />
				?>
			</entry><?php 
		}
		/**/	
	?>

</feed>
