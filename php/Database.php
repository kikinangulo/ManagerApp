<?php



class Database{

	var $dbName;
	var $dbHostname;
	var $dbLogon;
	var $dbPassword;
	var $dbLink;
	var $dbResult;
	var $dbRow;

	function Database($inputdbName,$inputdbHostname,$inputdbLogon,$inputdbPassword){

		$this->dbName=$inputdbName;
		$this->dbHostname=$inputdbHostname;
		$this->dbLogon=$inputdbLogon;
		$this->dbPassword=$inputdbPassword;
		$dbLink=0;
	}

	function connect(){
		if(0==$this->dbLink){
			$this->dbLink = mysql_connect($this->dbHostname, $this->dbLogon,$this->dbPassword);
		}

		if (!$this->dbLink) {
			die("Connect failed");
      	}

		if(!mysql_select_db($this->dbName,$this->dbLink)){
			die("cannot select database ".$this->dbName);
		}
	}

	function query($querystring){
		$this->connect();

		$this->dbResult = mysql_query($querystring,$this->dbLink);
	}

	function nextRow(){
		$this->dbRow = mysql_fetch_row($this->dbResult);
		if(is_array($this->dbRow)){
			return true;
		}else{
			return false;
		}
	}
	
	function insertId(){
		return mysql_insert_id($this->dbLink);
	}

	function get_column($num){
		return $this->dbRow[$num];
	}




	function num_rows(){

		return mysql_num_rows($this->dbResult);
	}

	function num_fields(){

		return mysql_num_fields($this->dbResult);
	}


	function affected_rows(){

    	return mysql_affected_rows($this->dbLink);
    }


	function close(){
		mysql_close($this->dbLink);
		$this->dbLink=0;
		$this->dbResult="";
		$this->dbRow=array();
	}

	function escape($str){
		return mysql_real_escape_string($str,$this->dbLink);
	}
}
?>
