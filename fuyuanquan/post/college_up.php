<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"college_updates")) {
	echo "您没有权限访问此页";
	exit;
}
$cs_title = $_POST["cs_title"];
$cs_province1 = $_POST["cs_province1"];
$cs_city1 = $_POST["cs_city1"];
$cs_district1 = $_POST["cs_district1"];
$cs_cate = $_POST["cs_cate"];
$cs_logo = $_POST["cs_logo"];
$cs_bg = $_POST["cs_bg"];
$up_id = $_POST['up_id'];
$sql_college = mysqli_query($mysqli,"UPDATE college_list SET cl_name = '{$cs_title}', cl_province = '{$cs_province1}', cl_city = '{$cs_city1}', cl_area = '{$cs_district1}', cl_cate = '{$cs_cate}', cl_logo = '{$cs_logo}', cl_bg = '{$cs_bg}', cl_class = 'college' WHERE cl_id = '{$up_id}'");
if ($sql_college) {
	echo 1;
} else {
	echo 0;
}
?>