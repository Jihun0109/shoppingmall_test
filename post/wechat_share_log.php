<?php
include("../include/config.php");
include("../include/data_base.php");
include("../include/member_db.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

if (!$member_login) {
	echo 0;
	exit;
}
if (isset($_POST['tlid'])) {
    $tlid = $_POST['tlid'];
} else {
    $tlid = '';
}

$smember = $member_login;

mysqli_query($mysqli,"UPDATE teacher_list SET 	share_count = 	share_count+1 WHERE tl_id = '{$tlid}'");

$sql_payment = mysqli_query($mysqli,"INSERT INTO wechat_share_log (	ws_phone, tl_id) VALUES ('{$smember}', '{$tlid}')");
if ($sql_payment) {
	echo $trade_no;
} else {
	echo 10;
}
?>