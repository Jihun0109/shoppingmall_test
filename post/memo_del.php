<?php 
include("../db_config.php");
if (!$member_login) {
	exit;
}
$me_id = $_POST['me_id'];
$sql_memo = mysqli_query($mysqli,"DELETE FROM memo_list WHERE me_id = '{$me_id}'");
?>