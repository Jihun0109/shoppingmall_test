<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"teacher")) {
	echo "您没有权限访问此页";
	exit;
}
$tc_title = $_POST["tc_title"];
$tc_province1 = $_POST["tc_province1"];
$tc_city1 = $_POST["tc_city1"];
$tc_district1 = $_POST["tc_district1"];
$tc_price = $_POST["tc_price"];
$tc_phone = $_POST["tc_phone"];
$tc_original = $_POST["tc_original"];
$tc_supplyprice = $_POST["tc_supplyprice"];
$tc_cate = $_POST["tc_cate"];
$tc_class = $_POST["tc_class"];
$tc_summary = $_POST["tc_summary"];
$tc_content = $_POST["tc_content"];
$tc_parentFileBox = $_POST["tc_parentFileBox"];
$tc_parentFileBox = substr($tc_parentFileBox,0,strlen($tc_parentFileBox)-1);
$tc_parentFileBox = str_replace("\\","/",$tc_parentFileBox);
$tc_mainimg = $_POST["tc_mainimg"];
$vip1level1 = $_POST["vip1level1"];
$vip1level2 = $_POST["vip1level2"];
$vip1level3 = $_POST["vip1level3"];
$vip2level1 = $_POST["vip2level1"];
$vip2level2 = $_POST["vip2level2"];
$vip2level3 = $_POST["vip2level3"];
$vip1point1 = $_POST["vip1point1"];
$vip1point2 = $_POST["vip1point2"];
$vip1point3 = $_POST["vip1point3"];
$vip2point1 = $_POST["vip2point1"];
$vip2point2 = $_POST["vip2point2"];
$vip2point3 = $_POST["vip2point3"];
$index_hot = $_POST['index_hot'];

$sql_teacher = mysqli_query($mysqli,"INSERT INTO teacher_list (tl_name, tl_pictures, tl_price, tl_Sales, tc_province1, tc_city1, tl_district1, tl_class, tl_summary, tl_detailed, tc_mainimg, tl_cate, tl_original, tl_supplyprice, tl_phone, level_one_vip1, level_two_vip1, level_three_vip1, level_one_vip2, level_two_vip2, level_three_vip2, shop_menu, index_hot, point_one_vip1, point_two_vip1, point_three_vip1, point_one_vip2, point_two_vip2, point_three_vip2) VALUES ('{$tc_title}', '{$tc_parentFileBox}', '{$tc_price}', '0', '{$tc_province1}', '{$tc_city1}', '{$tc_district1}', '{$tc_class}', '{$tc_summary}', '{$tc_content}', '{$tc_mainimg}', '{$tc_cate}', '{$tc_original}', '{$tc_supplyprice}', '{$tc_phone}', '{$vip1level1}', '{$vip1level2}', '{$vip1level3}', '{$vip2level1}', '{$vip2level2}', '{$vip2level3}', 'teacher', '{$index_hot}', '{$vip1point1}', '{$vip1point2}', '{$vip1point3}', '{$vip2point1}', '{$vip2point2}', '{$vip2point3}')");
if ($sql_teacher) {
	echo 1;
} else {
	echo 0;
}
?>