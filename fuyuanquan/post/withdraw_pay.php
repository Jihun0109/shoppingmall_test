<?php 
include( "../../db_config.php" );
include("../admin_login.php");
if (!strstr($admin_purview,"withdraw_confirm")) {
	echo "您没有权限访问此页";
	exit;
}
$wid = $_POST["wid"];
$wphone = $_POST['wphone'];

$sql_withdraw = mysqli_query($mysqli,"UPDATE balance_details SET t_status = '1' WHERE t_phone = '{$wphone}' and t_id = '{$wid}'");
if ($sql_withdraw) {
	echo 1;
} else {
	echo 0;
}
?>