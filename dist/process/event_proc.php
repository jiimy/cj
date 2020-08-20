<?php
header("Content-Type: text/html; charset=UTF-8");
require_once $_SERVER["DOCUMENT_ROOT"] ."/include/class/clsDbCon.php";
require_once $_SERVER["DOCUMENT_ROOT"] ."/include/class/clsRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] ."/include/lib/library.php";
require_once $_SERVER["DOCUMENT_ROOT"] ."/include/conf/userAgent.php";

//파라메터
$req = new clsRequest("POST");

$name           = injecStr($req->getString("name", ""));			//이름
$phone          = injecStr($req->getString("phone", ""));			//연락처
$zipcode        = injecStr($req->getString("zipcode", ""));			//우편번호
$address        = injecStr($req->getString("address", ""));			//주소
$address_detail = injecStr($req->getString("address_detail", ""));	//상세주소
$pop_div        = injecStr($req->getString("pop_div", ""));			//정답, 투표 구분
$vote_div       = injecStr($req->getString("vote_div", ""));		//투표시 레시피 구분
$ip             = injecStr($_SERVER["REMOTE_ADDR"]);				//참여자 ip 주소
$agent          = ($browserType == "Web" ? "Web" : "Mob");			//브라우저
$resultCnt      = 0;												//결과 cnt
$resultMsg;															//결과 message

//DB연결
$db = new clsDbCon();

//중복 확인
if($pop_div == "quiz") {
	$sqlers = " select count(*) from quiz_ev where phone = HEX(AES_ENCRYPT('" . dbStr($phone) . "','" . SECURITY_CODE . "')) and delyn = 'N' ";
	$count = $db->getResult($sqlers, 0, 0);

	if($count > 0) {
		$resultMsg = "overlap";
	} else {
		$sqler = " insert into quiz_ev(name, phone, address, address_detail, zipcode, ip, agent, regdate) ";
		$sqler = $sqler." values ('" . dbStr($name) . "', HEX(AES_ENCRYPT('" . dbStr($phone) . "','" . SECURITY_CODE . "')), '" . dbStr($address) . "', '" . dbStr($address_detail) . "', " ;
		$sqler = $sqler." '" . dbStr($zipcode) . "', '" . dbStr($ip) . "', '" . dbStr($agent) . "', now()) ";
		$row = $db->execute($sqler);

		if($row) {
			$resultMsg = "success";
		} else {
			$resultMsg = "fail";
		}
	}
} else {
	$sqlers = " select count(*) from vote_ev where phone = HEX(AES_ENCRYPT('" . dbStr($phone) . "','" . SECURITY_CODE . "')) and delyn = 'N' ";
	$count = $db->getResult($sqlers, 0, 0);

	if($count > 0) {
		$resultMsg = "overlap";
	} else {
		$sqler = " insert into vote_ev(name, phone, address, address_detail, zipcode, division, ip, agent, regdate) ";
		$sqler = $sqler." values ('" . dbStr($name) . "', HEX(AES_ENCRYPT('" . dbStr($phone) . "','" . SECURITY_CODE . "')), '" . dbStr($address) . "', '" . dbStr($address_detail) . "', " ;
		$sqler = $sqler." '" . dbStr($zipcode) . "', '" . dbStr($vote_div) . "', '" . dbStr($ip) . "', '" . dbStr($agent) . "', now()) ";
		$row = $db->execute($sqler);

		if($row) {
			$resultMsg = "success";
		} else {
			$resultMsg = "fail";
		}
	}
}

//DB해제
$db->close();
echo $resultMsg;
exit;
?>