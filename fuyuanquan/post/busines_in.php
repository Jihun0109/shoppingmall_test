<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"busines_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
if ($admin_level == "admin") {
    $bs_admin = "admin";
} else {
    $bs_admin = $admin_login;
}
if (isset($_POST["bs_title"])) {
    $bs_title = $_POST["bs_title"];
} else {
    $bs_title = '';
}
if (isset($_POST["bs_phone"])) {
    $bs_phone = $_POST["bs_phone"];
} else {
    $bs_phone = '';
}
if (isset($_POST["bs_province1"])) {
    $bs_province1 = $_POST["bs_province1"];
} else {
    $bs_province1 = '';
}
if (isset($_POST["bs_city1"])) {
    $bs_city1 = $_POST["bs_city1"];
} else {
    $bs_city1 = '';
}
if (isset($_POST["bs_district1"])) {
    $bs_district1 = $_POST["bs_district1"];
} else {
    $bs_district1 = '';
}
if (isset($_POST["bs_cate"])) {
    $bs_cate = $_POST["bs_cate"];
} else {
    $bs_cate = '';
}
if (isset($_POST["bs_logo"])) {
    $bs_logo = $_POST["bs_logo"]; 
} else {
    $bs_logo = '';
}
if (isset($_POST["bs_bg"])) {
    $bs_bg = $_POST["bs_bg"];
} else {
    $bs_bg = '';
}

$sql_busines = mysqli_query($mysqli,"INSERT INTO college_list (cl_name, cl_province, cl_city, cl_area, cl_cate, cl_logo, cl_bg, cl_class, cl_admin, cl_phone) VALUES ('{$bs_title}', '{$bs_province1}', '{$bs_city1}', '{$bs_district1}', '{$bs_cate}', '{$bs_logo}', '{$bs_bg}', 'busines', '{$bs_admin}', '{$bs_phone}')");
if ($sql_busines) {
	echo 1;
} else {
	echo 0;
}
?>