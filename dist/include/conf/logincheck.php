<?php
require_once $_SERVER["DOCUMENT_ROOT"] ."/include/class/clsDbCon.php";

session_start();
$sessionAdminId = (!empty($_SESSION['AdminId'])) ? $_SESSION['AdminId'] : "";
$sessionAdminPw = (!empty($_SESSION['AdminPw'])) ? $_SESSION['AdminPw'] : "";

if( $sessionAdminId == "" ){
	header("Location: /admin/index.php");
	exit;
}else{

	//db connection
	$db = new clsDbCon();

	$sqler = "insert into admin_history(AdminId, AccessIp, AccessPerform, Regdate) ";
	$sqler = $sqler."values('".($sessionAdminId)."', '".($_SERVER["REMOTE_ADDR"])."','".($_SERVER['REQUEST_URI'])."',now())";

	$resultYn = $db->execute($sqler);
	
	//db close
	$db->close();

}
?>