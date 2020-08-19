<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/include/conf/common.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/include/class/clsMysql.php";

require_once $_SERVER["DOCUMENT_ROOT"] ."/include/class/cls3Des.php";
			
class clsDbCon extends clsMysql {
	function clsDbCon() {
		if (DB_TYPE == 'MySQL'){
			parent::clsMysql(DB_HOST, DB_USER, DB_PASSWD, DB_DATABASENAME);	
		}
	}
}
?>