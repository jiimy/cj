<?php
define('Language', 'Korean');

//DB
define('DB_TYPE', 'MySQL');
define('DB_HOST', '222.106.92.100');
define('DB_USER', 'tsome');
define('DB_PASSWD', 'tsome!@#');
define('DB_DATABASENAME', 'dbbeksulsesameoil');
define('FatalErrorMsg', 'Critical Error! Please Contact Webmaster.');

//Upload path
define('SERVER_PATH', $_SERVER["DOCUMENT_ROOT"] . '/upload/');
define('SERVER_URL', '/upload/');

//암호화코드
define('SECURITY_CODE', 'beksulsesameoil!@#');

//KAKAO JS KEY
//$MAP_KEY = "f8023428f0c0d84fc7d41152b03c7712";

//Default URL
if((isset($_SERVER['SERVER_ADDR']) && $_SERVER['SERVER_ADDR'] == "222.106.92.100") || (isset($_SERVER['LOCAL_ADDR']) && $_SERVER['LOCAL_ADDR'] == "222.106.92.100")) {
	$HTTP_URL = "http://beksul-sesameoil.tsome.net";
	$SSL_URL = "http://beksul-sesameoil.tsome.net";
} else {
	$HTTP_URL = "http://127.0.0.1";
	$SSL_URL = "http://127.0.0.1";
}

//현재페이지 정보
$PHP_SELF = $_SERVER["PHP_SELF"];

$tmpFrontPath = explode("/",$_SERVER['PHP_SELF']);
//echo count($tmpFrontPath
if(count($tmpFrontPath) == 2) {
	$DEPTH1 = $tmpFrontPath[1];
	$DEPTH2 = "";
	$DEPTH3 = "";
}

if(count($tmpFrontPath) == 3) {
	$DEPTH1 = $tmpFrontPath[1];
	$DEPTH2 = $tmpFrontPath[2];
	$DEPTH3 = "";
}

if(count($tmpFrontPath) == 4) {
	$DEPTH1 = $tmpFrontPath[1];
	$DEPTH2 = $tmpFrontPath[2];
	$DEPTH3 = $tmpFrontPath[3];
}

//echo $DEPTH1;
//echo $DEPTH2;
//echo $DEPTH3;
?>