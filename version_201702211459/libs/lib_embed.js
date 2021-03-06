/*
	@licstart The following is the entire license notice for the
	JavaScript code in this page.

	Copyright (C) 2015 Lunovox

	The JavaScript code in this page is free software: you can
	redistribute it and/or modify it under the terms of the GNU
	General Public License (GNU GPL) as published by the Free Software
	Foundation. The code is distributed WITHOUT ANY WARRANTY;
	without even the implied warranty of MERCHANTABILITY or FITNESS
	FOR A PARTICULAR PURPOSE. See the GNU GPL for more details.

	As additional permission under GNU GPL version 3 section 7, you
	may distribute non-source (e.g., minimized or compacted) forms of
	that code without the copy of the GNU GPL normally required by
	section 4, provided you include this license notice and a URL
	through which recipients can access the Corresponding Source.

	@licend The above is the entire license notice
	for the JavaScript code in this page.
*/

	/**************************************************************************
	* Código inspirado no tutorial https://youtu.be/mUW3IqpAtH0
	* de Jeterson Lordano
	****************************************************************************/


var videoControls, playerVideo, view, timer, videoPreloader;
var btnPlay, btnVol, btnEndEvent, full;
var intervalTimer;
var barProgress, videoLoader, progress;
var pctSeek;
var slider,sliderVol, drag=false, debugMode=false;
var tela, palco;
var timeShowControls, maxTimeToHide=3;
var typePlay="next";
var icon_playpause = [
	"imgs/icons/sbl_embed_play.png",
	"imgs/icons/sbl_embed_pause.png"
];
var icon_volume = [
	"imgs/icons/sbl_embed_volume_mute.png",
	"imgs/icons/sbl_embed_volume_low.png",
	"imgs/icons/sbl_embed_volume_medium.png",
	"imgs/icons/sbl_embed_volume_high.png",
];

/*
window.addEventListener('load', function() {
	playerVideo = document.querySelector(".player-video");
	view = playerVideo.querySelector(".video-view");
	prepare(playerVideo);
	onLoadTypePlay();
}, true);
/**/

function prepare(elem){
	if(playerVideo!=elem){
		playerVideo = elem
		
		videoControls = playerVideo.querySelector(".video-controls");
		view = playerVideo.querySelector(".video-view");
		barProgress = playerVideo.querySelector(".video-progress-bar");
		videoLoader = playerVideo.querySelector(".video-loader"); 
		progress = playerVideo.querySelector(".video-progress"); 
		btnPlay = playerVideo.querySelector(".video-play");
		btnEndEvent = playerVideo.querySelector(".video-end-event");
		btnVol = playerVideo.querySelector(".video-volume");
		slider = playerVideo.querySelector(".slider");
		sliderVol = playerVideo.querySelector(".slider-vol");
		timer = playerVideo.querySelector(".video-time");
		videoPreloader = playerVideo.querySelector(".video-preloader");
		full = playerVideo.querySelector(".video-screens");
		btnLibretube = playerVideo.querySelector(".video-libretube_link");
		btnShare = playerVideo.querySelector(".video_share-btn");
		frmShare = playerVideo.querySelector(".video-share");
		btnFeed = playerVideo.querySelector(".video_feed-btn");
		frmFeed = playerVideo.querySelector(".video-feed");
		btnDescription = playerVideo.querySelector(".video-description-btn");
		frmDescription = playerVideo.querySelector(".video-description");
		btnEmbed = playerVideo.querySelector(".video-embed-btn");
		frmEmbed = playerVideo.querySelector(".video-embed");
		frmHelp = playerVideo.querySelector(".video-help");
		
		view.addEventListener("waiting", loader);
		view.addEventListener("playing", loader);
		view.addEventListener('ended',onEnded);
		view.addEventListener("click", doPlay);
		barProgress.addEventListener("click", seeker); 
		btnPlay.addEventListener("click", doPlay);
		btnPlay.addEventListener("click", loader);
		btnEndEvent.addEventListener("click", btnEventEnd);
		btnVol.addEventListener("click", mute);
		slider.addEventListener("mousedown", startDrag);
		slider.addEventListener("mouseup", startDrag);
		slider.addEventListener("mousemove", changeVolume);
		full.addEventListener("click", fullScreen);
		btnLibretube.addEventListener("click", toLibretube);
		btnShare.addEventListener("click", showShares);
		btnFeed.addEventListener("click", showFeeds);
		btnDescription.addEventListener("click", showDescription);
		btnEmbed.addEventListener("click", showEmbed);
		document.body.addEventListener("keyup", onKey);
		parent.document.body.addEventListener("keyup", onKey);

		intervalTimer = setInterval(updateTimer, 100);
		
	}
	onLoadTypePlay();
	showControls();
}
function onEnded(){
	if(typePlay=="next"){
		alert(
			"Desculpe! a função 'Avançar vídeo' ainda não foi implantada.\n"+
			"Selecione manualmente o próximo vídeo para assistir!"
		);
	}else if(view && typePlay=="repeat"){
		view.currentTime = 0;
		view.play();
	}else if(view && typePlay=="stop"){
		view.currentTime = 0;
		//view.stop();
	}else{
		alert(
			"ERRO[onEnded()]: Ocorreu um erro inesperado!"
		);
		return false;
	}
}
function onLoadTypePlay(){
	if(localStorage.length>=1){
		typePlay = localStorage.getItem("typePlay");
	}else{
		typePlay = "next";
	}
	//alert(typePlay);
	changeImgEndEvent();
}
function changeImgEndEvent(){
	if(btnEndEvent){
		if(typePlay=="next"){
			btnEndEvent.style.backgroundImage = "url(imgs/icons/sbl_embed_end_next.png)";
			btnEndEvent.title = "Exibir próxima mídea ao final desta.";
		}else if(typePlay=="repeat"){
			btnEndEvent.style.backgroundImage = "url(imgs/icons/sbl_embed_end_repeat.png)";
			btnEndEvent.title = "Repetir a execução ao final da média.";
		}else if(typePlay=="stop"){
			btnEndEvent.style.backgroundImage = "url(imgs/icons/sbl_embed_end_stop.png)";
			btnEndEvent.title = "Parar de executar ao final da média.";
		}
	}
}
function btnEventEnd(){
	if(typePlay=="next"){
		typePlay="repeat";
	}else if(typePlay=="repeat"){
		typePlay="stop";	
	}else if(typePlay=="stop"){
		typePlay="next";
	}
	localStorage.setItem("typePlay", typePlay);
	changeImgEndEvent();
}
function showControls(){
	if(view){
		timeShowControls = view.currentTime;
		videoControls.style.display = "block";
		printVolume();	
	}
}
function onKey(event){
	playerVideo.focus();
	if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 32){ /* BARRA DE ESPAÇO */
		doPlay();
	}else if(event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 37){ /* CTRL + LEFT */
		var newTime = view.currentTime-10;
		if(newTime<0){newTime=0;}
		view.currentTime =newTime;
		return false;
	}else if(event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 39){ /* CTRL + RIGH */
		var newTime = view.currentTime+10;
		if(newTime>view.duration){newTime=view.duration;}
		view.currentTime =newTime;
		return false;
	}else if(event.ctrlKey && event.shiftKey && !event.altKey && event.keyCode == 37){ /* CTRL + SHIFT + LEFT */
		var newTime = view.currentTime-30;
		if(newTime<0){newTime=0;}
		view.currentTime =newTime;
		return false;
	}else if(event.ctrlKey && event.shiftKey && !event.altKey && event.keyCode == 39){ /* CTRL + SHIFT + RIGH */
		var newTime = view.currentTime+30;
		if(newTime>view.duration){newTime=view.duration;}
		view.currentTime =newTime;
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 112){ /* F1 */
		showAtalhos();
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 113){ /* F2 */
		showDescription();
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 119){ /* F8 */
		showEmbed();
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 120){ /* F9 */
		showControls();
		btnEventEnd();
		return false;
	}else if(event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 112){ /* CRTL + F1 */
		showFeeds();
		return false;
	}else if(event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 113){ /* CRTL + F2 */
		showShares();
		return false;
	}else if(event.ctrlKey && event.shiftKey && !event.altKey && event.keyCode == 70){ /* CTRL + SHIFT + "F" */
		fullScreen();
		return false;
	}else if(event.ctrlKey && event.shiftKey && !event.altKey && event.keyCode == 68){ /* CTRL + SHIFT + "D" */
		tongleDebug();
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 107){ /* Botão de + */
		var newVolume = view.volume+0.1;
		if(newVolume>1){newVolume=1;}
		view.volume =newVolume;
		printVolume();
		showControls();
		return false;
	}else if(!event.ctrlKey && !event.shiftKey && !event.altKey && event.keyCode == 109){ /* Botão de - */
		var newVolume = view.volume-0.1;
		if(newVolume<0){newVolume=0;}
		view.volume =newVolume;
		printVolume();
		showControls();
		return false;
	}
	if(debugMode){
		alert(
			"Botão: " + 
			(event.ctrlKey?"CTRL + ":"") +
			(event.shiftKey?"SHIFT + ":"") + 
			(event.altKey?"ALT + ":"") +
			"CHAR_KEY(" + event.keyCode + ")"
		,"FFF");
		//document.title = event.keyCode;
		//document.title = view.volume;
	}
}
function tongleDebug(){
	var question = false;
	if(!debugMode){
		question = confirm("Deseja Realmente ativar o modo DEBUG para as teclas de atalho?");
		if(question){
			debugMode=!debugMode;
		}
	}else{
		debugMode=!debugMode;
		alert("Modo DEBUG desativado!");
	}
}
function hideAllForms(){
	frmHelp.style.display = "none";
	frmShare.style.display = "none";
	frmFeed.style.display = "none";
	frmDescription.style.display = "none";
	frmEmbed.style.display = "none";
	frmHelp.style.display = "none";
}
function showAtalhos(){
	if(frmHelp.style.display == "block"){
		hideAllForms();
	}else{
		hideAllForms();
		frmHelp.style.display = "block";
		view.pause();
		btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")";
	}
}
function showEmbed(){
	if(frmEmbed.style.display == "block"){
		hideAllForms();
	}else{
		hideAllForms();
		frmEmbed.style.display = "block";
		view.pause();
		btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")";
	}
}
function showDescription(){
	if(frmDescription.style.display == "block"){
		hideAllForms();
	}else{
		hideAllForms();
		frmDescription.style.display = "block";
		view.pause();
		btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")";
	}
}
function showFeeds(){
	if(frmFeed.style.display == "block"){
		hideAllForms();
	}else{
		hideAllForms();
		frmFeed.style.display = "block";
		view.pause();
		btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")";
	}
}
function showShares(){
	if(frmShare.style.display == "block"){
		hideAllForms();
	}else{
		hideAllForms();
		frmShare.style.display = "block";
		view.pause();
		btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")";
	}
}
function toLibretube(){
	open(btnLibretube.getAttribute("href"));
}
function fullScreen(){
	var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
		(document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
		(document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
		(document.msFullscreenElement && document.msFullscreenElement !== null);

	//palco = document.documentElement;
	
	if(!isInFullScreen){
		if (playerVideo.requestFullscreen) {
			playerVideo.requestFullscreen();
		} else if (playerVideo.mozRequestFullScreen) {
			playerVideo.mozRequestFullScreen();
		} else if (playerVideo.webkitRequestFullscreen) {
			playerVideo.webkitRequestFullscreen();
		}else if (playerVideo.msRequestFullscreen) {
			playerVideo.msRequestFullscreen();
		}
	}else{
		if (document.exitFullscreen) {
			document.exitFullscreen();
		} else if (document.webkitExitFullscreen) {
			document.webkitExitFullscreen();
		} else if (document.mozCancelFullScreen) {
			document.mozCancelFullScreen();
		} else if (document.msExitFullscreen) {
			document.msExitFullscreen();
		}
	}
}
function loader(event){
	//document.title = event.type;
	//alert(event.type)	;
	switch(event.type){
		case "waiting":
			videoPreloader.style.display = "block";
			//alert("carregando!");
			break;
		case "playing":
			//alert("playyyyy");
			videoPreloader.style.display = "none";
			//btnPlay.style.backgroundImage = "url("+icon_playpause[1]+")"; //"url(skinPlayer/btn-pause.png)"
			break;
	}
}
function mute(){
	if(!view.muted){
		view.muted = true;
		btnVol.style.backgroundImage = "url("+icon_volume[0]+")";
	}else{
		view.muted = false;
		if(view.volume>0.02 && view.volume<=0.3){
			btnVol.style.backgroundImage = "url("+icon_volume[1]+")";
		}else if(view.volume>0.3 && view.volume<=0.6){
			btnVol.style.backgroundImage = "url("+icon_volume[2]+")";
		}else{
			btnVol.style.backgroundImage = "url("+icon_volume[3]+")";
		}
	}
}
function startDrag(event){
	if(event.type=="mousedown"){
		drag = true;
	}else {
		drag = false;
	}
}
function printVolume(){
	if(videoControls.style.display == "block"){
		var pctVol = view.volume;
		sliderVol.style.width = String(pctVol * (slider.clientWidth - 2))+"px";
		if(!view.muted){
			if(pctVol<=0.02){
				btnVol.style.backgroundImage = "url("+icon_volume[0]+")";
			}else if(pctVol>0.02 && pctVol<=0.3){
				btnVol.style.backgroundImage = "url("+icon_volume[1]+")";
			}else if(pctVol>0.3 && pctVol<=0.6){
				btnVol.style.backgroundImage = "url("+icon_volume[2]+")";
			}else{
				btnVol.style.backgroundImage = "url("+icon_volume[3]+")";
			}
		}
	}
}
function changeVolume(event){
	if(drag){
		var w = slider.clientWidth - 2;
		var x = event.clientX - slider.offsetLeft;
		var pctVol = x/w;
		if(pctVol>=0 && pctVol<=1){
			view.volume = pctVol;
		}
		printVolume();
	}
}

function seeker(event){
	if(event){
		var pctBar = (event.clientX / barProgress.clientWidth);
		view.currentTime = (view.duration * pctBar);
	//}else {
		//barProgress.style.display = "none";
	}
}
function updateTimer(){
	if(view.duration){
		timer.innerHTML = convertTimer(view.currentTime) + " | " + convertTimer(view.duration);

		var bufferedEnd = view.buffered.end(view.buffered.length - 1);
		videoLoader.style.width = String((bufferedEnd/view.duration)*100)+"%";
		/*Mais tarde vou tentar tirar esse pctSeek do global*/
		pctSeek = (view.currentTime / view.duration) * 100;
		progress.style.width = pctSeek+"%";

		if(view.currentTime - timeShowControls > maxTimeToHide){
			videoControls.style.display = "none";
		}
	}	
}
function doPlay(){

	//alert('view.played.length='+view.played.length+"' view.paused='"+view.paused+"'");
	if(view.played.length != 0 && !view.paused){
		//alert("view.played.start(0)='"+view.played.start(0)+"'");
		if(view.paused==false){ //if(view.played.start(0) == 0){
			view.pause();
			btnPlay.style.backgroundImage = "url("+icon_playpause[0]+")"; //"url(skinPlayer/btn-play.png)";
			//alert("convertTimer(view.duration)='"+convertTimer(view.duration)+"'");
		}else{
			playerVideo.focus();
			hideAllForms();
			view.play();
			btnPlay.style.backgroundImage = "url("+icon_playpause[1]+")"; //"url(skinPlayer/btn-pause.png)";
			videoControls.style.display = "none";
		}
	}else{
		hideAllForms();
		view.play();
		btnPlay.style.backgroundImage = "url("+icon_playpause[1]+")"; //"url(skinPlayer/btn-pause.png)";
		videoControls.style.display = "none";
	}
}

function convertTimer(time){
	var horas, minutos, segundos;
	
	horas = Math.floor(time/3600);
	minutos = Math.floor(time/60);
	segundos = Math.floor(((time/60)%1)*60);
	
	if(horas<10 && horas>0){
		horas = "0" + String(horas) + ":";
	}else if(horas==0){
		horas="";
	}
	if(minutos<10){
		minutos = "0" + String(minutos);
	}else if(minutos>59){
		minutos = minutos -(Math.floor(minutos/60)*60);
	}
	if(segundos<10){
		segundos = "0" + String(segundos);
	}
	return String(horas) + String(minutos) + ":" + String(segundos);
}
