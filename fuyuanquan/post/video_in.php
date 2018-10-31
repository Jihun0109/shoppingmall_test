<?php 
include ("../../db_config.php");
include( "../admin_login.php" );
if (!strstr($admin_purview,"video_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
$vd_title = $_POST["vd_title"];
$vd_link = $_POST["vd_link"];
$vd_price = $_POST["vd_price"];
$vd_mainimg = $_POST["vd_mainimg"];

$sql_video = mysqli_query($mysqli,"INSERT INTO video_list (v_title, v_link, v_payment, v_img) VALUES ('{$vd_title}', '{$vd_link}', '{$vd_price}', '{$vd_mainimg}')");	
if ($sql_video) {
	echo 1;
} else {
	echo 0;
}

?>