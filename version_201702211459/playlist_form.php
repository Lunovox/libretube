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

	//session_cache_limiter('private'); 	/* Define o limitador de cache para 'private' */
	session_cache_expire(360); /* Define o limite de tempo do cache em 6 horas (360 minutos) */
	session_start("tuatec-home");

	
	require_once "libs/libGeral.php";
	
	//header('Content-type: text/plain; charset=utf-8');
	
	
	$thisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	
	require_once "libs/libMySQL2.php";
	
	$LunoMySQL = new LunoMySQL;
	if($LunoMySQL->ifAllOk()){ 
		if(getLogedType()=="owner" || getLogedType()=="moderator"){ ?>

			<!DOCTYPE html>
			<html>
				<head>
					<title>ADICIONAR VÍDEO A LISTA</title>
					<link rel="stylesheet" href="estilo_geral.css?update=<?=date('Y-m-d H:i:s');?>" media="screen"/>
					<script>
						window.addEventListener("load", function(){
							var search = document.getElementById("search");
							search.addEventListener("keyup", function(e){
								e = e || window.event;
								var charCode = e.keyCode || e.which;
								//document.getElementsByTagName("title")[0].innerHTML = charCode;
								if(charCode<37 || charCode>40){
									loadDoc(charCode);
								}
							});
							search.addEventListener("click", function(){
								loadDoc();
							});
							search.addEventListener("select", function(){
								loadDoc();
							});
						});
			
			
						function loadDoc(e) {
							var xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (xhttp.readyState == 4 && xhttp.status == 200) {
									var myResp = xhttp.responseText;
						
									if(myResp.length >= 2){
										//alert(myResp);
										var RespJSon = JSON.parse(myResp);
										//alert("resp.datalist.length='"+RespJSon.datalist.length+"'");
							
							
										if(RespJSon.button=="add"){
											document.getElementById("btnAddPlaylist").style.display = "block";
											document.getElementById("btnNewPlaylist").style.display = "none";
										}else if(RespJSon.button=="new"){
											document.getElementById("btnAddPlaylist").style.display = "none";
											document.getElementById("btnNewPlaylist").style.display = "block";
										}else{
											document.getElementById("btnAddPlaylist").style.display = "none";
											document.getElementById("btnNewPlaylist").style.display = "none";
										}
							
										var sugestions = document.getElementById("sugestions");
										sugestions.innerHTML = "";
										if(RespJSon.datalist.length>0){
											for($list=0; $list<RespJSon.datalist.length; $list++){ 
												if(RespJSon.datalist[$list]!=""){
													var option = document.createElement("option");
													option.setAttribute('value', RespJSon.datalist[$list]);
													option.innerHTML = RespJSon.datalist[$list];
													//option.setAttribute('id', "opt_"+($list+1));
													sugestions.appendChild(option);   
												}
											}
											//alert(sugestions.innerHTML);
										}
									}
								}
							};
				
							xhttp.open("POST", "playlist_search.php", true);
							xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
							xhttp.send("q="+document.getElementById("search").value);
						}
			
						function doPlaylistAdd() {
							alert("Função 'doPlaylistAdd()' ainda não implantada!");
							self.close();
						}
						function doPlaylistNew() {
							alert("Função 'doPlaylistNew()' ainda não implantada!");
							self.close();
						}
					</script>
				</head>
				<body>
					<br/>
					<center>
						<div style="width:260px">
							<?php
								/**/
								$ID=Propriedade("id");
								$Video=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "ID = $ID");
								if(count($Video)==1){
							?>
									<img style="width:260px; height:168px" src="<?=$Video[0]['urlPoster'];?>"/><br/>
									<small>
										<b><?php echo ($Video[0]['Title']); ?><b>
									</small>
							<?php 
								} /**/
							?>
						</div>
						<div style="display:inline-block; height_:100px; border-radius:10px; border:1px solid rgba(0,0,0,0.3); margin:10px; padding:5px; background:rgba(255,255,255,1.0);">
							<table>
								<tr>
									<td colspan="2">
										<center>
											<h3>ADICIONAR A LISTA</h3>
										</center>
									</td>
								</tr>
								<tr>
									<td>
										<input id="search" list="sugestions" style="width:200px" placeholder="Digite o nome a lista..." datalist/>
										<datalist id="sugestions"></datalist> 
									</td>
									<td>
										<button id="btnAddPlaylist" type="button" style="display:none" onclick="doPlaylistAdd()" >
											<img src="imgs/icons/sbl_percevejo.gif" align="absmiddle"/>
											Adicionar
										</button>
										<button id="btnNewPlaylist" type="button" style="display:none" onclick="doPlaylistNew()" >
											<img src="imgs/icons/sbl_lampada.gif" align="absmiddle"/>
											Criar
										</button>
									</td>
								</tr>
							</table>
						</div>
					</center>
				</body>
			</html> <?php
		}
	}
?>
