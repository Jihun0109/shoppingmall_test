<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_list")) {
	echo "您没有权限访问此页";
	exit;
}
$ps_id = $_POST["ps_id"];

$delete_query = "DELETE FROM profit_setting WHERE ps_id = {$ps_id}";
$result = mysqli_query($mysqli, $delete_query);

if ($result)
	echo 1;
else
	echo 0;
?>