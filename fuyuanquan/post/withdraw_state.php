<?php 
include( "../../db_config.php" );
include("../admin_login.php");
if (!strstr($admin_purview,"withdraw_confirm")) {
	echo "您没有权限访问此页";
	exit;
}
$wid = $_POST["wid"];

$sql_withdraw = mysqli_query($mysqli,"UPDATE withdrawal_list SET w_state = '1' WHERE w_id = '{$wid}'");
if ($sql_withdraw) {
	echo 1;
} else {
	echo 0;
}
?>