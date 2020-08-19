<?php
function aes_encrypt($str)
{
	$s_key = "menactra123!@#menactra$%";
	$s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

    $en_str = mcrypt_encrypt(MCRYPT_3DES, $s_key, $str, MCRYPT_MODE_ECB, $s_vector_iv);
	
	//암호화된 값은 binary 데이터이므로, ascii로 처리하기 위해서는 별도의 변환이 필요하다
	$en_base64 = base64_encode($en_str);  //base64 encoding을 한 경우 => SVzBe9MN9Htf7zEtp+Rn3g==
	//$en_hex = bin2hex($en_str);  //hex로 변환한 경우 => 495cc17bd30df47b5fef312da7e467de

	return $en_base64;
}

// 위의 함수로 암호화한 문자열을 복호화한다.
// 복호화 과정에서 오류가 발생하거나 위변조가 의심되는 경우 false를 반환한다.

function aes_decrypt($en_base64)
{
	$s_key = "menactra123!@#menactra$%";
	$s_vector_iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB), MCRYPT_RAND);

	$de_str = base64_decode($en_base64); //base64 encoding을 binary로 변환
	//$de_str = pack("H*", $en_hex); //hex로 변환한 ascii를 binary로 변환
	$out_str = mcrypt_decrypt(MCRYPT_3DES, $s_key, $de_str, MCRYPT_MODE_ECB, $s_vector_iv);

	return $out_str;
}
?>