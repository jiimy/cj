<?php

class clsResultSet {
	var $jar;
	var $rownum;
	
	function clsResultSet() {
		return $this->init(null);
	}
	
	function init($array) {
		$this->rownum = -1;
		if ( is_null($array) ) {
			$array = array();
		}
		$this->jar = $array;
	}
	
	function add($value) {
		array_push($this->jar, $value);
	}
	
	function remove($value) {}
	
	function next() {
		$this->rownum++;
		if ( is_array($this->jar[$this->rownum])) {
			return true;
		}
		return false;
	}
	
	function size() {
		return count($this->jar);
	}
	
	function count() {
		return $this->size();
	}
	
	function get($name) {
		if ( @array_key_exists($name, $this->jar[$this->rownum]) ) {
			return $this->jar[$this->rownum][$name];	
		} else {
			PrintError(101, 'property [' . $name . '] is not exist.');
		}
	}
}

?>