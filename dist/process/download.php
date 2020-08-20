<?php
	$fileName = $_REQUEST["fileName"];
	if($fileName == "beksulA") {
		$realFileName = "beksul_sesameoil_japchae_recipe.mp4";
	} else if($fileName == "beksulB") {
		$realFileName = "beksul_sesameoil_latte_recipe.mp4";
	}
	$dir = "../assets/video/";
	$fileDir = $dir . $realFileName;

	header('Content-Type: application/x-octetstream');
	//header('Content-type: application/x-msdownload');
	header('Content-Length: ' . filesize($fileDir));
	header('Content-Disposition: attachment; filename=' . $realFileName);
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0'); 

	$fp = fopen($fileDir, 'r');
	fpassthru($fp);
	fclose($fp);
?>