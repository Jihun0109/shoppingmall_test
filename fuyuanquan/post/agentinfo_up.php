<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"AgentInfo_up")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["ai_id"])) {
    $ai_id = $_POST["ai_id"];
} else {
    $ai_id = '';
}
if (isset($_POST["ai1"])) {
    $ai1 = $_POST["ai1"];
} else {
    $ai1 = '';
}
if (isset($_POST["ai2"])) {
    $ai2 = $_POST["ai2"];
} else {
    $ai2 = '';
}
if (isset($_POST["ai3"])) {
    $ai3 = $_POST["ai3"];
} else {
    $ai3 = '';
}
if (isset($_POST["ai1_cnt"])) {
    $ai1_cnt = $_POST["ai1_cnt"];
} else {
    $ai1_cnt = '';
}
if (isset($_POST["ai2_cnt"])) {
    $ai2_cnt = $_POST["ai2_cnt"];
} else {
    $ai2_cnt = '';
}
if (isset($_POST["ai3_cnt"])) {
    $ai3_cnt = $_POST["ai3_cnt"];
} else {
    $ai3_cnt = '';
}
if (isset($_POST["ai_province"])) {
    $ai_province = $_POST["ai_province"]; 
} else {
    $ai_province = '';
}

$sql_members = mysqli_query($mysqli,"UPDATE agentinfo SET ai1 = '{$ai1}', ai2 = '{$ai2}', ai3 = '{$ai3}', ai1_cnt = '{$ai1_cnt}', ai2_cnt = '{$ai2_cnt}', ai3_cnt = '{$ai3_cnt}', ai_province = '{$ai_province}'  WHERE ai_id = '{$ai_id}'");
if ($sql_members) {
	echo 1;
} else {
	echo 0;
}
?>