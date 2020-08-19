<?php
//require_once $_SERVER['DOCUMENT_ROOT'] . "/include/conf/common.php";
//require_once $_SERVER['DOCUMENT_ROOT'] . "/include/lib/library.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/include/class/clsResultSet.php";

class clsMysql {
	var $connection;
	var $lastInsertId;
	var $isDebug;
	
	function clsMysql($host, $id, $pw, $db) {
		$this->connection = null;
		$this->isDebug = false;
		$this->lastInsertedId = null;
		return $this->connect($host, $id, $pw, $db);
	}
	
	function connect($host, $id, $pw, $db) {		
		$this->connection = @mysql_connect($host, $id, $pw) or Die(FatalErrorMsg);
		if ( !is_null($this->connection) ) {				
			@mysql_select_db($db, $this->connection) or $this->PrintError(801); 
			@mysql_query("set names utf8");		//한글깨짐때문에 넣음
		}
	}
	
	function close() {
		@mysql_close($this->connection) or $this->PrintError(802);		
	}
	
	function execute($sql) {
		$this->debug($sql);
		$sql = $this->parseQuery($sql);
		//echo $sql;
		//exit;
		if ( $res = @mysql_query($sql, $this->connection) or $this->PrintError(803) ) {
			$this->lastInsertId = mysql_insert_id($this->connection);
			@mysql_free_result($res);
			return true;
		}
		return false;
	}
	
	function getResultSet($sql) {
		$this->debug($sql);
		$sql = $this->parseQuery($sql);		
		$rs = new clsResultSet();				
		$res = @mysql_query($sql, $this->connection) or $this->PrintError(803);		
		while ( $row = @mysql_fetch_assoc($res) ) {
			$rs->add($row);
		}		
		@mysql_free_result($res);		
		return $rs;
	}
	
	function getArray($sql) {		
		$this->debug($sql);		
		$sql = $this->parseQuery($sql);		
		$rs = array();		
		$res = @mysql_query($sql, $this->connection) or $this->PrintError(803);
		while ( $row = @mysql_fetch_assoc($res) ) {
			array_push($rs, $row);
		}
		@mysql_free_result($res);
		return $rs;
	}
	
	function getResult($sql, $row, $field = 0) {
		$this->debug($sql);
		$sql = $this->parseQuery($sql);
		$res = @mysql_query($sql, $this->connection) or $this->PrintError(803);
		$ret = @mysql_result($res, $row, $field);
		@mysql_free_result($res);		
		return $ret;
	}
	
	function debug($str) {
		if ( $this->isDebug ) {
			echo "Debug/MySQL: " . $str ."\n";
		}
	}
	
	function parseQuery($q) {
		// [d[field]] -> date_format
		//$q = ereg_replace("\[d\[([a-zA-Z0-9_]*)\]\]", "date_format(\\1, '%Y-%m-%d %H:%i:%s') \\1", $q);
		//$q = preg_replace("\[d\[([a-zA-Z0-9_]*)\]\]", "date_format(\\1, '%Y-%m-%d %H:%i:%s') \\1", $q);
		// ....
		return $q;
	}
	
	function PrintError($errorNum) {
		if ( $this->isDebug ) {
			echo '[system]' . mysql_error($this->connection);
		}
		//PrintError($errorNum);
	}
	
}
?>