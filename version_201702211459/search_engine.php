<?php
	header('Content-Type: text/xml; charset=utf-8');
	require_once "libs/libGeral.php";
	//FONTE: https://developer.mozilla.org/en-US/Add-ons/Creating_OpenSearch_plugins_for_Firefox
?>
<OpenSearchDescription xmlns="http://a9.com/-/spec/opensearch/1.1/" xmlns:moz="http://www.mozilla.org/2006/browser/search/">
	<ShortName>LIBRETUBE</ShortName>
	<Description>Pesquise vídeo por tema</Description>
	<InputEncoding>UTF-8</InputEncoding>
	<Image width="16" height="16" type="image/png"><?='http://'.$_SERVER['HTTP_HOST'].str_replace("search_engine.php", "", $_SERVER['SCRIPT_NAME'])."imgs/icons/sbl_libretube.png";?></Image>
	<Url type="text/html" template="<?='http://'.$_SERVER['HTTP_HOST'].str_replace("search_engine.php", "", $_SERVER['SCRIPT_NAME']);?>">
		<Param name="sub" value="video_list"/>
		<Param name="order" value="search"/>
		<Param name="q" value="{searchTerms}"/>
	</Url>
	<Url type="application/x-suggestions+json" template="suggestionURL"/>
	<moz:SearchForm><?='http://'.$_SERVER['HTTP_HOST'].str_replace("search_engine.php", "", $_SERVER['SCRIPT_NAME']);?></moz:SearchForm>
</OpenSearchDescription>