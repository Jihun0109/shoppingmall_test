<?php 
include ("../db_config.php");
include ("../include/recomend_level.php");
$recommend_phone = @$_POST["recommend_phone"];
$recommend_code = @$_POST["recommend_code"];
$recommend_vid = @$_POST["recommend_vid"];
$recommend_openid = @$_POST['recommend_openid'];

$phonecode_count = mysqli_query($mysqli, "SELECT count(pco_id) FROM phone_code where pco_number = '{$recommend_phone}' and pco_code = '{$recommend_code}' and pco_status = '0'");
$phonecode_rs = mysqli_fetch_array($phonecode_count,MYSQLI_NUM);
$phonecode_Number = $phonecode_rs[0];
if (!$phonecode_Number) {
	echo 3;
	exit;
}

$recommend_count = mysqli_query($mysqli, "SELECT count(mb_id) FROM fyq_member where mb_phone = '{$recommend_phone}'");
$recommend_rs = mysqli_fetch_array($recommend_count,MYSQLI_NUM);
$recommend_Number = $recommend_rs[0];

if ($recommend_Number) {
	echo 2;
	$sql_openid_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_openid = '{$recommend_openid}' where mb_phone = '{$recommend_phone}'");
	exit;
} else {
	$query_recommend = "SELECT * FROM fyq_member where mb_id = '{$recommend_vid}'";
	if ($result_recommend = mysqli_query($mysqli, $query_recommend))
	{
		$row_recommend = mysqli_fetch_assoc($result_recommend);
		$mb_phone = $row_recommend['mb_phone'];
		$mb_province = $row_recommend['mb_province'];
		$mb_city = $row_recommend['mb_city'];
		$mb_area = $row_recommend['mb_area'];

		$recommend_nick = substr($recommend_phone,-4);
		$recommend_pass = md5($recommend_nick."fyq");

		$sql_user_recommend = mysqli_query($mysqli,"INSERT INTO fyq_member (mb_phone, mb_nick, mb_pass, mb_recommend, mb_level, mb_province, mb_city, mb_area, mb_point, mb_openid) VALUES ('{$recommend_phone}', '{$recommend_nick}', '{$recommend_pass}', '{$mb_phone}', '1', '{$mb_province}', '{$mb_city}', '{$mb_area}', '100', '{$recommend_openid}')");
		if ($sql_user_recommend) {
			echo 1;
			setcookie("member", $recommend_phone, time()+3600*24*365,"/");
			$sql_phonecode = mysqli_query($mysqli,"UPDATE phone_code SET pco_status = '1' where pco_number = '{$recommend_phone}' and pco_code = '{$recommend_code}' and pco_status = '0'");
			$sql_recommend_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point+300 where mb_phone = '{$mb_phone}'");
            recommend_level($recommend_phone,$mb_phone,"../include/data_base.php");
		}
	}
}
?>