<?php
/********************************************************************************
# DB SQLInjecect 처리
********************************************************************************/
function dbStr($prmStr) {
	$fromStr = array("\'"	,"'");
	$toStr   = array("`"	,"`");
	return str_replace($fromStr,$toStr,$prmStr);
}
function inpStr($prmStr) {
	$fromStr = array("&"    ,"\""    );
	$toStr   = array("&amp;","&quot;");
	return str_replace($fromStr,$toStr,$prmStr);
}
function ntagStr($prmStr) {
	$fromStr = array("&"    ,"<"   ,">"   ,"\r\n");
	$toStr   = array("&amp;","&lt;","&gt;","<br>");
	return str_replace($fromStr,$toStr,$prmStr);
}
function textareaStr($prmStr) {
	$fromStr = array("&"    ,"<"   ,">"   );
	$toStr   = array("&amp;","&lt;","&gt;");
	return str_replace($fromStr,$toStr,$prmStr);
}
function injecStr($prmStr) {
	$fromStr = array("\'"	,"'"	,"&"    ,"<"   ,">"   );
	$toStr   = array("`"	,"`"	,"&amp;","&lt;","&gt;");
	return str_replace($fromStr,$toStr,$prmStr);
}
function injecStrBack($prmStr) {
	$fromStr = array("\'"	,"'"	,"&"    ,"<"   ,">"   );
	$toStr   = array("`"	,"`"	,"&amp;","&lt;","&gt;");
	return str_replace($toStr,$fromStr,$prmStr);
}
function injecTag($prmStr) {
	//$fromStr = array("\'"	,"<"   ,">"   );
	$fromStr = array("\'"	,"'"	,"<"	,">"   );
	$toStr   = array("`"	,"`"	,"&lt;"	,"&gt;");
	return str_replace($fromStr,$toStr,$prmStr);
}
/********************************************************************************
# number format
********************************************************************************/
function numStr($Str) {
	return number_format($Str);
}

/********************************************************************************
# date format
********************************************************************************/
function dateStr($str, $format) {
	$date = strtotime($str);
	return date($format, $date);
}

/********************************************************************************
# paging
Paging($pg, $pagingSize, $totalCount, $listNum, $parmSearch)?>

********************************************************************************/
function getPaging($pg, $pagingSize, $totalCount, $listNum, $parmSearch){
	$totalPage = ceil($totalCount / $listNum);
	$pageGroup= ceil($pg / $pagingSize);
	$totalpageGroup = ceil($totalPage / $pagingSize);
	$prevJumper = $pagingSize * ($pageGroup-1);
	$link = is_array($parmSearch) ? "&" . parseParameter($parmSearch) : $parmSearch;

	/*
		<a href="#" class="direct"><img src="images/paging_first.gif" alt="처음으로" /></a>
		<a href="#" class="prev"><img src="images/paging_prev.gif" alt="이전으로" /></a>
		<em>1</em>
		<a href="#">2</a>
		<a href="#">3</a>
		<a href="#">4</a>
		<a href="#">5</a>
		<a href="#" class="next"><img src="images/paging_next.gif" alt="다음으로" /></a>
		<a href="#" class="direct"><img src="images/paging_end.gif" alt="마지막으로" /></a>
	*/


	$r .=  "<a href=\"".$PHP_SELF."?pg=1".$link."\" class=\"direct\"><img src=\"/images/adm_btn_first.png\" alt=\"처음으로\" /></a>";

	if($pageGroup>1) $r .=  "<a href=\"".$PHP_SELF."?pg=".$prevJumper.$link."'\"  class=\"prev\"><img src=\"/images/adm_btn_prev.png\" alt=\"이전으로\" /></a>";
	else $r .=  "<a href=\"#\" class=\"prev\"><img src=\"/images/adm_btn_prev.png\" alt=\"이전으로\" /></a>";
	
	for($i = 1 + $prevJumper ; $i <= ($pagingSize * $pageGroup) && $i <= $totalPage ; $i++) {

		if($i != $pg) {
			$r .=  "<a href={$PHP_SELF}?pg={$i}{$link}>{$i}</a>";
		} else {
			$r .=  "<em>{$i}</em>";
		}			
	}


	if($i <= $totalPage) {
		$r .=  "<a href=\"".$PHP_SELF."?pg=".$i.$link."\"  class=\"next\"><img src=\"/images/adm_btn_next.png\" alt=\"다음으로\" /></a>";
	} else {
		$r .=  "<a href=\"#\" class=\"next\"><img src=\"/images/adm_btn_next.png\" alt=\"다음으로\" /></a>";
	}
	
	$r .=  "<a href=\"".$PHP_SELF."?pg=".$totalPage.$link."\"><img src=\"/images/adm_btn_last.png\" alt=\"마지막으로\" /></a>";

	echo $r;
}

/********************************************************************************
# validation check
********************************************************************************/
function email_valid($temp_email) { 
	return ereg("^[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)*@[0-9a-zA-Z_-]+(\.[0-9a-zA-Z_-]+)+$", $temp_email);
}
function num_valid($temp_num) { 
	return ereg("^[0-9]+$", $temp_num);
}

/********************************************************************************
# 중복파일명 처리
********************************************************************************/
function fileRename($uFile) { 
	$orgName = $uFile;
	$img_name_only = substr($orgName,0,strrpos($orgName,"."));
	$img_name_ext = substr($orgName,strrpos($orgName,"."));
	$new_img_name = $img_name_only.$img_name_ext; 
	$i=0;
	while (file_exists($_SERVER["DOCUMENT_ROOT"] . "/upload/event201703/".$new_img_name)){ 
		$i++; 
		$new_img_name = $img_name_only."(".$i.")".$img_name_ext; 
	}
	return $new_img_name;
}

/********************************************************************************
# 참여자 이름 마스킹처리
********************************************************************************/
function maskName($evName) {
	$reMaskName = "";

	$stName = mb_substr($evName, 0, 1, "UTF-8");
	$endName = mb_substr($evName, -1, 1, "UTF-8");
	$len = mb_strlen($evName, "UTF-8");

	if ($len == 2) { $reMaskName = $stName."O"; }
	if ($len == 3) { $reMaskName = $stName."O".$endName; }
	if ($len == 4) { $reMaskName = $stName."OO".$endName; }
	if ($len == 5) { $reMaskName = $stName."OOO".$endName; }
	if ($len == 6) { $reMaskName = $stName."OOOO".$endName; }
	if ($len == 7) { $reMaskName = $stName."OOOOO".$endName; }
	if ($len == 8) { $reMaskName = $stName."OOOOOO".$endName; }
	return $reMaskName;
}

/********************************************************************************
# 시간 -> 초 변환
********************************************************************************/
function getSecond($hms) {
	$tmp = explode(':', $hms);
	$std = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
	$scd = mktime(intval($tmp[0]), intval($tmp[1]), intval($tmp[2]));

	return intval($scd - $std);
}

/********************************************************************************
# 썸네일 생성
********************************************************************************/
function createThumbnail($file, $save_filename) {
	$src_img = ImageCreateFromJPEG($file);	//JPG파일로부터 이미지를 읽어옵니다.

	$img_info = getImageSize($file);	//원본이미지의 정보를 얻어옵니다.
	$img_width = $img_info[0];
	$img_height = $img_info[1];

	$dst_width = '676';
	$dst_height = '210';
	$dst_img = imagecreatetruecolor($dst_width, $dst_height);	//타겟이미지를 생성합니다.

	ImageCopyResized($dst_img, $src_img, 0, 0, 0, 0, $dst_width, $dst_height, $img_width, $img_height);	//타겟이미지에 원하는 사이즈의 이미지를 저장합니다.
	ImageInterlace($dst_img);
	ImageJPEG($dst_img, $save_filename);	//실제로 이미지파일을 생성합니다.
	ImageDestroy($dst_img);
	ImageDestroy($src_img);	//메모리상의 이미지를 삭제합니다.
}

/********************************************************************************
# 이미지 업로드
********************************************************************************/
function uploadImgChk($uFile, $maxsize, $folderName) { 
	if (isset($uFile) && !$uFile["error"]) {
		$arrMinetype = array ("1","2","3","6");				//1:gif, 2:jpg, 3:png, 6:bmp
		$serverName = date("YmdHis");
		$orgName = fileRename($uFile["name"],$folderName);
		$tempName = $uFile["tmp_name"]; //윈도우 임시 템프 파일 경로 지정
		$fileExt = substr(strrchr($orgName, "."), 1);
		$fileSize = $uFile["size"];		
		$fileMine = exif_imagetype($tempName);
		$uploadfile = SERVER_PATH.$folderName."/".basename($orgName);

		$arrayFileInfo;
		if (in_array($fileMine, $arrMinetype)) {			//Minetype 체크

			if($fileSize > $maxsize) {					//용량 체크
				$arrayFileInfo = array("result" => "1", "message" => "업로드 용량이 초과되었습니다.");
			} else {

				if (move_uploaded_file($tempName, $uploadfile)) {
					$arrayFileInfo = array("result" => "0", "serverName" => $serverName.".".$fileExt, "orgName" => $orgName, "fileExt" => $fileExt, "fileSize" => $fileSize, "fileType" => $uFile["type"]);
				} else {
					$arrayFileInfo = array("result" => "2", "message" => "파일업로드 실패하였습니다.");
				}

			}
			
		} else {
			$arrayFileInfo = array("result" => "3", "message" => "허용되지 않은 파일입니다.");
		}

	} else {
		$arrayFileInfo = array("result" => "9", "message" => $uFile['error']);
	}
	return $arrayFileInfo;
}

/********************************************************************************
# 파일 업로드
********************************************************************************/
function uploadFileChk($uFile, $maxsize, $folderName) { 
	if (isset($uFile) && !$uFile["error"]) {
		//$imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/bmp', 'image/gif', 'application/pdf','text/plain','application/zip','application/msword','application/vnd.ms-excel','application/vnd.ms-powerpoint');
		$serverName = date("YmdHis");
		$orgName = fileRename($uFile["name"],$folderName);
		$tempName = $uFile["tmp_name"]; //윈도우 임시 템프 파일 경로 지정
		$fileExt = substr(strrchr($orgName, "."), 1);
		$fileSize = $uFile["size"];		
		$fileMine = exif_imagetype($tempName);
		$uploadfile = SERVER_PATH.$folderName."/".basename($orgName);

		$arrayFileInfo;
		//if (in_array($uFile['type'], $imageKind)) {			//Minetype 체크
		if(true) {

			if($fileSize > $maxsize) {					//용량 체크
				$arrayFileInfo = array("result" => "1", "message" => "업로드 용량이 초과되었습니다.");
			} else {

				if (move_uploaded_file($tempName, $uploadfile)) {
					$arrayFileInfo = array("result" => "0", "serverName" => $serverName.".".$fileExt, "orgName" => $orgName, "fileExt" => $fileExt, "fileSize" => $fileSize, "fileType" => $uFile["type"]);
				} else {
					$arrayFileInfo = array("result" => "2", "message" => "파일업로드 실패하였습니다.");
				}

			}
			
		} else {
			$arrayFileInfo = array("result" => "3", "message" => "허용되지 않은 파일입니다.");
		}

	} else {
		$arrayFileInfo = array("result" => "9", "message" => $uFile['error']);
	}
	return $arrayFileInfo;
}

/********************************************************************************
# 파일 업로드
********************************************************************************/
/*
function uploadChk2($uFile) { 
	if (isset($uFile) && !$uFile['error']) {
		$imageKind = array ('image/pjpeg', 'image/jpeg', 'image/JPG', 'image/X-PNG', 'image/PNG', 'image/png', 'image/x-png', 'image/bmp', 'image/gif', 'application/pdf');
		$serverName = date("YmdHis");
		//$orgName = $uFile['name'];
		$orgName = fileRename($uFile['name']);
		$fileExt = substr(strrchr($orgName, '.'), 1);
		$fileSize = $uFile['size'];
		//$uploadfile = SERVER_PATH.basename($serverName.'.'.$fileExt);
		$uploadfile = SERVER_PATH.basename($orgName);
		$arrayFileInfo;

		if (in_array($uFile['type'], $imageKind)) {
			if (move_uploaded_file($uFile['tmp_name'], $uploadfile)) {
				$arrayFileInfo = array("result" => "1", "serverName" => $serverName.'.'.$fileExt, "orgName" => $orgName, "fileExt" => $fileExt, "fileSize" => $fileSize, "fileType" => $uFile['type']);
			} else {
				$arrayFileInfo = array("result" => "2", "message" => "파일업로드 실패하였습니다.");
			}
		} else {
			$arrayFileInfo = array("result" => "3", "message" => "허용되지 않은 파일입니다.");
		}
	} else {
		$arrayFileInfo = array("result" => "4", "message" => codeToMessage($uFile['error']));
	}
	return $arrayFileInfo;
}
*/


/********************************************************************************
# 파일 업로드 에러메시지 출력
********************************************************************************/
function codeToMessage($code)  { 
	switch ($code) { 
		case "1": 
			$message = "upload_max_filesize 초과"; 
			break; 
		case "2": 
			$message = "max_file_size 초과";
			break; 
		case "3":
			$message = "파일이 부분만 업로드됐습니다."; 
			break; 
		case "4":
			$message = "파일을 선택해 주세요."; 
			break; 
		case "5":
			$message = "임시 폴더가 존재하지 않습니다."; 
			break; 
		case "6":
			$message = "임시 폴더에 파일을 쓸 수 없습니다. 퍼미션을 살펴 보세요."; 
			break; 
		case "7":
			$message = "확장에 의해 파일 업로드가 중지되었습니다."; 
			break; 

		default: 
			$message = "파일업로드 실패하였습니다."; 
			break; 
	} 
	return $message; 
} 
?>