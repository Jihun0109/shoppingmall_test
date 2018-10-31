<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"partner")) {
	echo "您没有权限访问此页";
	exit;
}
$del_id = $_POST['commoditydel_id'];

$query_teac = "SELECT * FROM teacher_list where tl_id = {$del_id}";
if ($result_teac = mysqli_query($mysqli, $query_teac))
{
	$row_teac = mysqli_fetch_assoc($result_teac);
	$tlclass = $row_teac['tl_class'];
	if ($row_teac['shop_menu'] == "teacher") {
		if (!strstr($admin_purview,"teacher_updates")) {
			echo "您没有权限访问此页";
			exit;
		}
	}
	if ($row_teac['shop_menu'] == "busines") {
		if (!strstr($admin_purview,"busines_updates")) {
			echo "您没有权限访问此页";
			exit;
		}
	}
	if ($row_teac['shop_menu'] == "college") {
		if (!strstr($admin_purview,"college_updates")) {
			echo "您没有权限访问此页";
			exit;
		}
	}
	if ($row_teac['shop_menu'] == "partner") {
		if (!strstr($admin_purview,"partner_updates")) {
			echo "您没有权限访问此页";
			exit;
		}
	}
	$sql_commoditydel = mysqli_query($mysqli,"DELETE FROM teacher_list WHERE tl_id = '{$del_id}'");
    $sql_keyword_tydel = mysqli_query($mysqli,"DELETE FROM search_keyword WHERE key_item = '{$del_id}'");
	$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allcount = cl_allcount-1 WHERE cl_id = '{$tlclass}'");
	echo 1;
}
?>