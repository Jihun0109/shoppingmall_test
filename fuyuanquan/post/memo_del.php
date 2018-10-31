<?php 
include ("../../db_config.php");
$dids = $_POST["dids"];
$sql_memo = mysqli_query($mysqli,"DELETE FROM memo_list WHERE me_id = '{$dids}'");

if ($sql_memo) {
	echo 1;
} else {
	echo 0;
}
?>