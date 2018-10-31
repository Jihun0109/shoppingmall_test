<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"AgentInfo_in")) {
	echo "您没有权限访问此页";
	exit;
}
$ai1 = $_POST["ai1"];
$ai2 = $_POST["ai2"];
$ai3 = $_POST["ai3"];
$ai1_cnt = $_POST["ai1_cnt"];
$ai2_cnt = $_POST["ai2_cnt"];
$ai3_cnt = $_POST["ai3_cnt"];
$ai_province = $_POST["ai_province"];

$member_count = mysqli_query($mysqli, "SELECT count(*) FROM agentinfo where ai_province = '{$ai_province}'");
$member_rs=mysqli_fetch_array($member_count,MYSQLI_NUM);
$memberNumber=$member_rs[0];
if ($memberNumber) {
	echo 2;
	exit;
} else {
	$sql_member = mysqli_query($mysqli,"INSERT INTO agentinfo (ai1, ai2, ai3, ai1_cnt, ai2_cnt, ai3_cnt, ai_province) VALUES ('{$ai1}', '{$ai2}', '{$ai3}','{$ai1_cnt}', '{$ai2_cnt}', '{$ai3_cnt}', '{$ai_province}')");
	if ($sql_member) {
		echo 1;
	} else {
		echo 0;
		exit;
	}
}
?>