<?php
	/*
		Esse código foi criado para selecionar sugestões de próximos vídeos para assistir.
	*/
	
	ini_set('display_errors', 'On'); 
	//error_reporting(E_ALL | E_STRICT);
	error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	//ini_set('default_charset','utf-8');
	
	date_default_timezone_set("America/Recife"); //-0300
	
	require_once "libs/libGeral.php";
	
	header('Content-type: text/plain; charset=utf-8');
	
	
	
	//$thisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	
	require_once "libs/libMySQL2.php";
	
	$LunoMySQL = new LunoMySQL;
	if($LunoMySQL->ifAllOk()){
        $v = urldecode(Propriedade("v"));
        $q = urldecode(Propriedade("q"));
        $o = urldecode(Propriedade("o")); //order
		$Suggestions={};
		$Suggestion="";
        if($o=="mostviews"){
            if(getLogedType()=="owner" || getLogedType()=="moderator"){
                $Suggestions=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "",  "Title DESC", null, 0, 5);
            }else
                $Suggestions=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "Title DESC", null, 0, 5);
            }
        }elseif($o=="privates" && (getLogedType()=="owner" || getLogedType()=="moderator")){

        }elseif($o=="search" && $q!=""){
			$search="";
			if(strlen(trim($q))>=3){
				$Partes = explode(" ",$query);
				if(getLogedType()!="owner" && getLogedType()!="moderator"){$search.="(";}
				for($P=0; $P<count($Partes); $P++){
					if(strlen(trim($Partes[$P]))>=3){
						$search.="Title LIKE '%".$Partes[$P]."%' OR Description LIKE '%".trim($Partes[$P])."%'";
						if($P!=count($Partes)-1){$search.=" OR ";}
					}
				}
				if(getLogedType()!="owner" && getLogedType()!="moderator"){$search.=") AND timePublish IS NOT NULL";}
			}else{
				if(getLogedType()!="owner" && getLogedType()!="moderator"){$search.="timePublish IS NOT NULL";}
			}
			if(strlen(trim($search))>=3){
				$Suggestions=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", $search,  "timePublish DESC, timeUpdate DESC", null, 0, 5);
			}else{
				
			}
        }else{ //Ordem = Recentes
            if(getLogedType()=="owner" || getLogedType()=="moderator"){
                $Suggestions=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "",  "timeUpdate  DESC", null, 0, 5);
            }else
                $Suggestions=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "timeUpdate  DESC", null, 0, 5);
            }
        }
        for($S=0; $S<count($Suggestions); $S++){
			if($v==""){
				$Suggestion=0;
			}else{
				if($S!=count($Suggestions)-1){
					if($Suggestions[$S]['ID']==$v){
						$Suggestion=$S;
						unset($Suggestions[$S]);
						break;
					}
				}else{
					if($Suggestions[$S]['ID']==$v){
						$Suggestion=$S;
						unset($Suggestions[$S]);
						break;
					}else{
						$Suggestion=0;
					}
				}
			}        
        }
            //window.location='?sub=video_delete&id=0';
    }
?>
