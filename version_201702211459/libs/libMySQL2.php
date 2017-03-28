<?php
	/*
	@licstart The following is the entire license notice for the
	JavaScript code in this page.

	Copyright (C) 2015 Lunovox ( ͡° ͜ʖ ͡°)

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

	ini_set('display_errors', 'On'); 
	//error_reporting(E_ERROR | E_STRICT | E_WARNING | E_PARSE);
	error_reporting(E_ALL | E_STRICT);

	class LunoMySQL{
		var $mySqlConector;
		var $mySqlDataBase;
		var $mySqlconfig;
		
		function LunoMySQL(){
			if(file_exists('config.php')){
				require('config.php'); // <= não pode ser o comando require_once()!!!
				$this->mySqlconfig = $mySQL; //Salva as informações de conexão para posterior consulta.
				//print_r($this->$mySqlconfig);
				$this->mySqlConector = @mysql_connect($this->mySqlconfig['server'], $this->mySqlconfig['user'], $this->mySqlconfig['password']) or null;  
				$this->mySqlDataBase = @mysql_select_db($this->mySqlconfig['database'], $this->mySqlConector) or null;  
			}
		}
		
		public function getConectedServer(){
			return $this->mySqlconfig['server'];
		}
		public function getConectedDatabase(){
			return $this->mySqlconfig['database'];
		}
		public function getConectedUser(){
			return $this->mySqlconfig['user'];
		}
		public function getConectedPassword(){
			return $this->mySqlconfig['password'];
		}
		public function getConectedPrefix(){
			return $this->mySqlconfig['prefix'];
		}
		
		public function ifConfig(){
			return file_exists('config.php');
		}
		public function ifConected(){
			return $this->mySqlConector!=null;
		}
		public function ifExistDataBase(){
			return $this->mySqlDataBase!=null;
		}
		public function ifAllOk(){
			return  $this->ifConfig() && $this->ifConected() && $this->ifExistDataBase();
		}
		
		public function getResult($Comando=""){
			//echo $Comando;
			if($Comando!=""){
				if($this->ifAllOk()){
					$Consulta=@mysql_query($Comando);
					if(isset($Consulta) && $Consulta!=""){
						return $Consulta;
					}else{
						die("[ERRO: libMySQL.php] SQL_Consulta(\$Comando='$Comando') Falha de consulta!");
					}
				}else{
					die("[ERRO: libMySQL.php] SQL_Consulta(\$Comando='$Comando') \$LunoMySQL->ifAllOk()==false");
				}
			}else{
				die("[ERRO: libMySQL.php] SQL_Consulta() Comando não declarado!");
			}
		}
		function getArray($Consulta=NULL){  #Retorna [<NumeroDosCampos>]<=<ConteudoDosCampos>
			if(isset($Consulta) && $Consulta!=""){
				while($Linha = @mysql_fetch_row($Consulta)){
					$Resultado[]=$Linha;
				}
				if(isset($Resultado) && $Resultado!=""){return $Resultado;}
			}
		}
		
		
		public function getTable($Tabela=NULL, $Teste=NULL, $Ordem=NULL, $CamposDeRetorno=NULL, $LimiteMinimo=0, $LimiteMaximo=9999){
			if(empty($CamposDeRetorno) || $CamposDeRetorno==""){$CamposDeRetorno="*";}
			if(isset($Tabela) && $Tabela!="" && isset($Teste) && $Teste!=""){
				$SQL="SELECT $CamposDeRetorno FROM $Tabela WHERE $Teste";
			}elseif(isset($Tabela) && $Tabela!=""){
				$SQL="SELECT $CamposDeRetorno FROM $Tabela";
			}
			if(isset($SQL) && $SQL!=""){
				if(isset($Ordem) && $Ordem!=""){$SQL.=" ORDER BY ".$Ordem;}
				$SQL.=" LIMIT ".(INT)$LimiteMinimo.", ".(INT)$LimiteMaximo;
				$Consulta=$this->getResult($SQL);
				//print_r($Consulta);
				if(count($Consulta)>=1){$Campos=(int)@mysql_num_fields($Consulta);}else{$Campos=0;}
				$Matriz=$this->getArray($Consulta);

				for ($M=0; $M<count($Matriz); $M++) {
					for ($C=0; $C<$Campos; $C++) {
						$Campo[$C]=mysql_field_name($Consulta,$C);
						if($Matriz[$M][$C]!=NULL){
							$Registros[$M][$Campo[$C]]=$Matriz[$M][$C];
						}else{
							$Registros[$M][$Campo[$C]]="";
						}
					}
				}
				if(count($Matriz)>=1){return $Registros;}
			}
		}
		/**/
		
		
	}
?>
