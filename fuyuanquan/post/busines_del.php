<?php 
include ("../../db_config.php");
$dids = $_POST["dids"];
$sql_busines = mysqli_query($mysqli,"DELETE FROM college_list WHERE cl_id = '{$dids}'");

if ($sql_busines) {
	echo 1;
} else {
	echo 0;
}
?>