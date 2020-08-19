<?php

/* 브라우져 체크 */
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$browserType = "";
$expLowVer = false;

if( strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "ANDROID") !== false ){
	$browserType = "Android";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "IPHONE") !== false Or strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "IPOD") !== false Or strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "IPAD") !== false ){
	$browserType = "iOS";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "SAMSUNG") !== false ){
	$browserType = "Samsung";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "LG") !== false ){
	$browserType = "LG";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "WINDOWS CE") !== false Or strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "WINDOWS PHONE") !== false ){
	$browserType = "Windows CE";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "BLACKBERRY") !== false ){
	$browserType = "Blackberry";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "BADA") !== false ){
	$browserType = "Bada";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "SYMBIAN") !== false Or strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "NOKIA") !== false ){
	$browserType = "Symbian";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "WEBOS") !== false ){
	$browserType = "WebOS";
}else if(strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "OPERA MINI") !== false Or 
	strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "OPERA MOBI") !== false Or 
	strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "POLARIS") !== false Or 
	strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "IEMOBILE") !== false Or 
	strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "LGTELECOM") !== false Or 
	strpos( strtoupper($_SERVER['HTTP_USER_AGENT']), "SONYERICSSON") !== false ){
	$browserType = "ETC";
}else{
	$browserType = "Web";
}

if(preg_match("/MSIE*/", $userAgent)) {
	if(preg_match("/MSIE 6.0[0-9]*/", $userAgent)) {
		$expLowVer = true;
	} else if(preg_match("/MSIE 7.0*/", $userAgent)) {
		$expLowVer = true;
	} else if(preg_match("/MSIE 8.0*/", $userAgent)) {
		$expLowVer = true;
	} else if(preg_match("/MSIE 9.0*/", $userAgent)) {
		$expLowVer = true;
	} else if(preg_match("/MSIE 10.0*/", $userAgent)) {
		$expLowVer = true;
	}
}
?>