<?php
//---------------------------------------------------------------------------------------------------------------------
	function nomeParaBytes($val){

		$val  = trim($val);
		$last = strtolower($val[strlen($val)-1]);
		$val  = substr($val, 0, -1); // necessary since PHP 7.1; otherwise optional
		switch($last) {
			// The 'G' modifier is available since PHP 5.1.0
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}
		return $val;
	}
//---------------------------------------------------------------------------------------------------------------------
	function InteiroParaTestoDeMoeda($Valor=0){
    $Valor=(int)$Valor;
	  if(strlen($Valor)==1){
	    return "0,0".$Valor;
	  }elseif(strlen($Valor)==2){
	    return "0,".$Valor;
	  }elseif(strlen($Valor)>=3){
	    $Real=substr($Valor,0,strlen($Valor)-2);
	    $Centavos=substr($Valor,strlen($Real),2);
	    if(strlen($Real)>3 and strlen($Real)<=6){
				$Real=substr($Real,0,strlen($Real)-3).".".substr($Real,strlen($Real)-3,3);
			}elseif(strlen($Real)>6 and strlen($Real)<=9){
				$Real=substr($Real,0,strlen($Real)-6).".".substr($Real,strlen($Real)-6,3).".".substr($Real,strlen($Real)-10,3);
			}/**/
	    return $Real.",".$Centavos;
		}
	}
//---------------------------------------------------------------------------------------------------------------------
	function TestoDeMoedaParaInteiro($Moeda=""){
		if($Moeda!=""){
		  $Moeda=str_replace(",","",trim($Moeda));
		  $Moeda=str_replace(".","",trim($Moeda));
		  $Moeda=str_replace(" ","",trim($Moeda));
		  $Moeda=(int)$Moeda;
		}else{$Moeda=0;}
		return $Moeda;
	}
//---------------------------------------------------------------------------------------------------------------------
	function InteiroPHPparaDataBR($Valor=""){
	  if($Valor!=""){
		  $Valor=(int)trim($Valor);
			return date("d/m/Y",$Valor);
		}
	}
//---------------------------------------------------------------------------------------------------------------------
	function InteiroPHPparaDataHoraBR($Valor=""){
	  if($Valor!=""){
		  $Valor=(int)trim($Valor);
			return date("d/m/Y H:i:s",$Valor);
		}
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataBRparaMaxInteiroPHP($Data=""){
		if($Data!=""){
		  $Parte=explode("/",$Data);
		  if(count($Parte)==3){
				$DataNumerica=(int)mktime(23, 59, 59, (int)$Parte[1], (int)$Parte[0], (int)$Parte[2]);
			}else{$DataNumerica="ERRO";}
		}else{$DataNumerica="";}
		return $DataNumerica;
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataSQLparaMaxInteiroPHP($Data=""){
		if($Data!=""){
		  $Parte=explode("-",$Data);
		  if(count($Parte)==3){
				$DataNumerica=(int)mktime(23, 59, 59, $Parte[1], $Parte[2], $Parte[0]);
			}else{$DataNumerica="ERRO";}
		}else{$DataNumerica="";}
		return $DataNumerica;
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataSQLparaDataBR($Valor=""){
	  $Partes=explode("-",$Valor);
	  if(count($Partes)==3){
	    return $Partes[2]."/".$Partes[1]."/".$Partes[0];
	  }
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataBRparaDataSQL($Data=""){
	  $Partes=explode("/",$Data);
	  if(count($Partes)==3){
	    return $Partes[2]."-".$Partes[1]."-".$Partes[0];
	  }
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataBRparaMD($Data=""){
	  $Partes=explode("/",$Data);
	  if(count($Partes)==3){
	    return 
			str_pad($Partes[1], 2, "0", STR_PAD_LEFT).
			str_pad($Partes[0], 2, "0", STR_PAD_LEFT);
	  }
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataHoraSQLparaDataHoraBR($Valor=""){
	  $Variaveis=explode(" ",$Valor);
	  if(count($Variaveis)==2){
		  $Partes1=explode("-",$Variaveis[0]);
		  $Partes2=explode(":",$Variaveis[1]);
		  if(count($Partes1)==3 and count($Partes2)==3){
		    return $Partes1[2]."/".$Partes1[1]."/".$Partes1[0]." ".$Partes2[0].":".$Partes2[1].":".$Partes2[2];
		  }
		}
	}
//---------------------------------------------------------------------------------------------------------------------
	function DataHoraSQLparaInteiroPHP($Valor=""){
	  $Variaveis=explode(" ",$Valor);
	  if(count($Variaveis)==2){
		  $Partes1=explode("-",$Variaveis[0]);
		  $Partes2=explode(":",$Variaveis[1]);
		  if(count($Partes1)==3 and count($Partes2)==3){
				$DataNumerica=(int)mktime($Partes2[0], $Partes2[1], $Partes2[2], $Partes1[1], $Partes1[2], $Partes1[0]);
		    return $DataNumerica;
		  }else{return 0;}
		}else{return 0;}
	}
//---------------------------------------------------------------------------------------------------------------------
	function CodigoParaHTML($Testo=""){
		$Testo=nl2br($Testo);
		$Testo=str_replace("[$]","<img align='absmiddle' border=0 src='../imagens/templantes/sbl_sifrao.gif'>",$Testo);
	  $Testo=str_replace("[?]","<img align='absmiddle' border=0 src='../imagens/templantes/sbl_duvida.gif'>",$Testo);
	  $Testo=str_replace("[0]","<img align='absmiddle' border=0 src='../imagens/templantes/sbl_relogio.gif'>",$Testo);
	  $Testo=str_replace("[L]","<img align='absmiddle' border=0 src='../imagens/templantes/sbl_lampada.gif'>",$Testo);
	  $Testo=str_replace("[P]","<img align='absmiddle' border=0 src='../imagens/templantes/sbl_presente.gif'>",$Testo);

	  $Testo=str_replace('<|>',"<br/>",$Testo);
	  $Testo=str_replace('<ENTER>',"<br/>",$Testo);
	  $Testo=str_replace('<NEGRITO>',"<B>",$Testo);
	  $Testo=str_replace('</NEGRITO>',"</B>",$Testo);
	  $Testo=str_replace('<SUBLINHADO>',"<U>",$Testo);
	  $Testo=str_replace('</SUBLINHADO>',"</U>",$Testo);
	  $Testo=str_replace('<RISCADO>',"<S>",$Testo);
	  $Testo=str_replace('</RISCADO>',"</S>",$Testo);
	  $Testo=str_replace('<GRANDE>',"<BIG>",$Testo);
	  $Testo=str_replace('</GRANDE>',"</BIG>",$Testo);
	  $Testo=str_replace('<PEQUENO>',"<SMALL>",$Testo);
	  $Testo=str_replace('</PEQUENO>',"</SMALL>",$Testo);

	  $Testo=str_replace('<PRETO>',"<FONT COLOR=000000>",$Testo);
	  $Testo=str_replace('<+CINZA>',"<FONT COLOR=CCCCCC>",$Testo);
	  $Testo=str_replace('<CINZA>',"<FONT COLOR=999999>",$Testo);
	  $Testo=str_replace('<-CINZA>',"<FONT COLOR=666666>",$Testo);
	  $Testo=str_replace('<BRANCO>',"<FONT COLOR=FFFFFF>",$Testo);
	  $Testo=str_replace('<+VERMELHO>',"<FONT COLOR=FF0000>",$Testo);
	  $Testo=str_replace('<VERMELHO>',"<FONT COLOR=880000>",$Testo);
	  $Testo=str_replace('<-VERMELHO>',"<FONT COLOR=440000>",$Testo);
	  $Testo=str_replace('<+VERDE>',"<FONT COLOR=00FF00>",$Testo);
	  $Testo=str_replace('<VERDE>',"<FONT COLOR=008800>",$Testo);
	  $Testo=str_replace('<-VERDE>',"<FONT COLOR=004400>",$Testo);
	  $Testo=str_replace('<+AZUL>',"<FONT COLOR=0000FF>",$Testo);
	  $Testo=str_replace('<AZUL>',"<FONT COLOR=0000FF>",$Testo);
	  $Testo=str_replace('<-AZUL>',"<FONT COLOR=000088>",$Testo);

	  $Testo=str_replace('<+AMARELO>',"<FONT COLOR=0000FF>",$Testo);
	  $Testo=str_replace('<AMARELO>',"<FONT COLOR=888800>",$Testo);
	  $Testo=str_replace('<-AMARELO>',"<FONT COLOR=444400>",$Testo);

	  $Testo=str_replace('</COR>',"</FONT>",$Testo);


	  $Testo=str_replace('[[]]',"",$Testo);
	  $Testo=str_replace('{{;}}','</a>',$Testo);
	  $Testo=str_replace('{{+','<a target="_blank" href="',$Testo);
	  $Testo=str_replace('{{=','<a href="',$Testo);
	  $Testo=str_replace('{{','<a href="',$Testo);
	  $Testo=str_replace('}}','">',$Testo);
	  $Testo=str_replace(urlencode('\\'),"\\",$Testo);
	  $Testo=str_replace('[[','<img align="absmiddle" border=0 src="',$Testo);
	  $Testo=str_replace(']]','"/>',$Testo);
		return $Testo;
	}
//---------------------------------------------------------------------------------------------------------------------
function Converter_CodigoCaracter($Testo=""){
	$Testo=htmlentities($Testo, ENT_NOQUOTES,"UTF-8");
	$Testo=html_entity_decode($Testo);
	/**/
	return $Testo;
}
//---------------------------------------------------------------------------------------------------------------------

