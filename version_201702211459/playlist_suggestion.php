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
	
	header('Content-type: text/plain; charset=utf-8');
	
	
	
	$thisURL = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	
	require_once "libs/libMySQL2.php";
	
	$LunoMySQL = new LunoMySQL;
    echo "{\n";
	if($LunoMySQL->ifAllOk()){
        $v = urldecode(Propriedade("v"));
        $q = urldecode(Propriedade("q"));
        $o = urldecode(Propriedade("o")); //order
		
        if($o=="mostviews"){
            if(getLogedType()=="owner" || getLogedType()=="moderator"){
                $Suggestion=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "",  "Title DESC", null, 0, 5);
            }else
                $Suggestion=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "Title DESC", null, 0, 5);
            }
        }elseif($o=="privates" && (getLogedType()=="owner" || getLogedType()=="moderator")){

        }elseif($o=="search" && $q!=""){
            $Suggestion=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", 
                "timePublish IS NOT NULL AND Title LIKE '%$q%'",  
            "Title ASC", null, 0, 5);
        }else{ //Ordem = Recentes
            if(getLogedType()=="owner" || getLogedType()=="moderator"){
                $Suggestion=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "",  "timeUpdate  DESC", null, 0, 5);
            }else
                $Suggestion=$LunoMySQL->getTable($LunoMySQL->getConectedPrefix()."videos", "timePublish IS NOT NULL",  "timeUpdate  DESC", null, 0, 5);
                $LunoMySQL->getConectedPrefix()."videos"
            }
        }
        for($S=0; $S<count($Suggestion); $S++){ ?>
        
        }
            //window.location='?sub=video_delete&id=<?=$ID;?>';
    }
?>
