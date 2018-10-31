<?php 
include ("../db_config.php");
$member_ico = @$_POST["member_ico"];
$member_sex = @$_POST["member_sex"];
$member_nick = @$_POST["member_nick"];
$member_qq = @$_POST["member_qq"];
$member_receivingaddress = @$_POST["member_receivingaddress"];
$member_postcode = @$_POST["member_postcode"];

$member_id = $member_login;
$sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_ico = '{$member_ico}', mb_sex = '{$member_sex}', mb_nick = '{$member_nick}', mb_qq = '{$member_qq}', mb_receiving_address = '{$member_receivingaddress}', mb_postcode = '{$member_postcode}' WHERE mb_phone = '{$member_id}'");
if ($sql_member) {
	echo 1;
} else {
	echo 0;
}
?>