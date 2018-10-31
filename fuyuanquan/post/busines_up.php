<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"busines_updates")) {
	echo "您没有权限访问此页";
	exit;
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
if (isset($_POST['up_id'])) {
    $up_id = $_POST['up_id'];
} else {
    $up_id = '';
}

$sql_busines = mysqli_query($mysqli,"UPDATE college_list SET cl_name = '{$bs_title}', cl_province = '{$bs_province1}', cl_city = '{$bs_city1}', cl_area = '{$bs_district1}', cl_cate = '{$bs_cate}', cl_logo = '{$bs_logo}', cl_bg = '{$bs_bg}', cl_phone = '{$bs_phone}', cl_class = 'busines' WHERE cl_id = '{$up_id}'");
if ($sql_busines) {
	echo 1;
} else {
	echo 0;
}
?>