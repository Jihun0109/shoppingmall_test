<?php 
include ("../db_config.php");
$orld_pass = @$_POST["orld_pass"];
$new_pass1 = @$_POST["new_pass1"];
$new_pass2 = @$_POST["new_pass2"];
$member_id = $member_login;
$orld_pass = md5($orld_pass."fyq");
$new_pass1 = md5($new_pass1."fyq");
$new_pass2 = md5($new_pass2."fyq");

if ($new_pass1 == $new_pass2 && $new_pass1 && $new_pass2) {
	$old_pass_sql = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_phone = '{$member_id}' and mb_pass = '{$orld_pass}'");
	$old_pass_rs = mysqli_fetch_array($old_pass_sql,MYSQLI_NUM);
	$old_pass_Number = $old_pass_rs[0];
	if ($old_pass_Number) {
		$sql_newpass = mysqli_query($mysqli,"UPDATE fyq_member SET mb_pass = '{$new_pass2}' WHERE mb_phone = '{$member_id}'");
		if ($sql_newpass) {
			echo 1;
		} else {
			echo 0;
		}
	} else {
		echo 2;
	}
} else {
	echo 3;
}
?>