<?php 
include ("../../db_config.php");
include( "../admin_login.php" );
if (!strstr($admin_purview,"video_deletes")) {
	echo "您没有权限访问此页";
	exit;
}
$vd_id = $_POST["vid"];
$sql_video = mysqli_query($mysqli,"DELETE FROM video_list WHERE v_id = '{$vd_id}'");

if ($sql_video) {
	echo 1;
} else {
	echo 0;
}
?>