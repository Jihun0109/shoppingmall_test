<?php 
include ("../../db_config.php");
$dids = $_POST["dids"];
$sql_agent = mysqli_query($mysqli,"DELETE FROM admin_agent WHERE ag_phone = '{$dids}'");

if ($sql_agent) {
	echo 1;
} else {
	echo 0;
}
?>