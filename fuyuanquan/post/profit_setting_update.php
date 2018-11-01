<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_list")) {
	echo "您没有权限访问此页";
	exit;
}
$ps_id = $_POST["ps_id"];
$ps_profit = $_POST["ps_profit"];


$update_query = "UPDATE profit_setting SET ps_profit = {$ps_profit} WHERE ps_id = {$ps_id};";
$result = mysqli_query($mysqli, $update_query);

if ($result)
	echo 1;
else
	echo 0;
?>