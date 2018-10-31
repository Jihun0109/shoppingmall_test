<?php 
include ("../../db_config.php");
include( "../admin_login.php" );
if (!strstr($admin_purview,"video_updates")) {
	echo "您没有权限访问此页";
	exit;
}
$vd_title = $_POST["vd_title"];
$vd_link = $_POST["vd_link"];
$vd_price = $_POST["vd_price"];
$vd_mainimg = $_POST["vd_mainimg"];
$vd_id = $_POST["vd_id"];

$sql_video = mysqli_query($mysqli,"UPDATE video_list SET v_title = '{$vd_title}', v_link = '{$vd_link}', v_payment = '{$vd_price}', v_img = '{$vd_mainimg}' WHERE v_id = '{$vd_id}'");

if ($sql_video) {
	echo 1;
} else {
	echo 0;
}

?>