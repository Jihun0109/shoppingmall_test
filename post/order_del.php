<?php 
include("../db_config.php");
$shop_id = @$_POST["shop_id"];

$sql_payment = mysqli_query($mysqli,"UPDATE payment_list SET pay_status = '10' WHERE pay_id = '{$shop_id}'");
if ($sql_payment) {
	echo 1;
} else {
	echo 0;
}
?>