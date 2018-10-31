<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_updates")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["mb_province1"])) {
    $mb_province1 = $_POST["mb_province1"];
} else {
    $mb_province1 = '';
}
if (isset($_POST["mb_city1"])) {
    $mb_city1 = $_POST["mb_city1"];
} else {
    $mb_city1 = '';
}
if (isset($_POST["mb_district1"])) {
    $mb_district1 = $_POST["mb_district1"];
} else {
    $mb_district1 = '';
}
if (isset($_POST["mb_level"])) {
    $mb_level = $_POST["mb_level"]; 
} else {
    $mb_level = '';
}
if (isset($_POST["mb_gold"])) {
    $mb_gold = $_POST["mb_gold"];
} else {
    $mb_gold = 0;
}
if (isset($_POST["mb_commission"])) {
    $mb_commission = $_POST["mb_commission"];
} else {
    $mb_commission = 0;
}
if (isset($_POST["mb_recommend"])) {
    $mb_recommend = $_POST["mb_recommend"];
} else {
    $mb_recommend = '';
}
if (isset($_POST["mb_distribution"])) {
    $mb_distribution = $_POST["mb_distribution"];
} else {
    $mb_distribution = '';
}
if (isset($_POST["mb_id"])) {
    $mb_id = $_POST["mb_id"];
} else {
    $mb_id = '';
}

if (!$mb_gold) {
	$mb_gold = 0;
}
if (!$mb_commission) {
	$mb_commission = 0;
}

$query_log = "SELECT * FROM fyq_member where mb_id = '{$mb_id}'";
if ($result_log = mysqli_query($mysqli, $query_log))
{
    $row_log = mysqli_fetch_assoc($result_log);
    $mb_phone_log = $row_log['mb_phone'];
    $mb_province_before = $row_log['mb_province'];
    $mb_city_before = $row_log['mb_city'];
    $mb_area_before = $row_log['mb_area'];
    $mb_level_before = $row_log['mb_level'];
    $mb_not_gold_before = $row_log['mb_not_gold'];
    $mb_total_gold_before = $row_log['mb_total_gold'];
    $mb_distribution_before = $row_log['mb_distribution'];
    $mb_recommend_before = $row_log['mb_recommend'];
    $_before_content = "mb_phone->".$mb_phone_log." mb_province->".$mb_province_before." mb_city->".$mb_city_before." mb_area->".$mb_area_before." mb_level->".$mb_level_before." mb_not_gold->".$mb_not_gold_before." mb_total_gold->".$mb_total_gold_before." mb_distribution->".$mb_distribution_before." mb_recommend->".$mb_recommend_before;
    
    $_after_content = "mb_phone->".$mb_phone_log." mb_province->".$mb_province1." mb_city->".$mb_city1." mb_area->".$mb_district1." mb_level->".$mb_level." mb_not_gold->".$mb_not_gold_before."+".$mb_gold." mb_total_gold->".$mb_total_gold_before."+".$mb_gold." mb_distribution->".$mb_distribution." mb_recommend->".$mb_recommend;
    
    $sql_member = mysqli_query($mysqli,"INSERT INTO admin_log (log_cate, log_phone, log_content_before, log_content_after) VALUES ('member_up', '{$admin_login}', '{$_before_content}', '{$_after_content}')");
}

$sql_members = mysqli_query($mysqli,"UPDATE fyq_member SET mb_province = '{$mb_province1}', mb_city = '{$mb_city1}', mb_area = '{$mb_district1}', mb_level = '{$mb_level}', mb_not_gold = mb_not_gold+$mb_gold, mb_total_gold = mb_total_gold+$mb_gold, mb_distribution = '{$mb_distribution}', mb_recommend = '{$mb_recommend}', mb_commission_not_gold = mb_commission_not_gold+$mb_commission WHERE mb_id = '{$mb_id}'");
if ($sql_members) {
	echo 1;
} else {
	echo 0;
}
?>