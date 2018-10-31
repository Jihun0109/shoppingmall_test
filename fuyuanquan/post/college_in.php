<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"college_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
if ($admin_level == "admin") {
    $cs_admin = "admin";
} else {
    $cs_admin = $admin_login;
}
$cs_title = $_POST["cs_title"];
$cs_province1 = $_POST["cs_province1"];
$cs_city1 = $_POST["cs_city1"];
$cs_district1 = $_POST["cs_district1"];
$cs_cate = $_POST["cs_cate"];
$cs_logo = $_POST["cs_logo"];
$cs_bg = $_POST["cs_bg"];

$sql_college = mysqli_query($mysqli,"INSERT INTO college_list (cl_name, cl_province, cl_city, cl_area, cl_cate, cl_logo, cl_bg, cl_class, cl_admin) VALUES ('{$cs_title}', '{$cs_province1}', '{$cs_city1}', '{$cs_district1}', '{$cs_cate}', '{$cs_logo}', '{$cs_bg}', 'college', '{$cs_admin}')");
if ($sql_college) {
	echo 1;
} else {
	echo 0;
}
?>