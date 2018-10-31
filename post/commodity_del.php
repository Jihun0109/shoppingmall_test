<?php 
include( "../db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('ÇëÏÈµÇÂ½ÕÊºÅ');parent.location.href='index.php'; </script>";
	exit;
}
$del_id = $_POST['commoditydel_id'];

$query_teac = "SELECT * FROM teacher_list where tl_id = {$del_id}";
if ($result_teac = mysqli_query($mysqli, $query_teac))
{
	$row_teac = mysqli_fetch_assoc($result_teac);
	$tlclass = $row_teac['tl_class'];
	$sql_commoditydel	= mysqli_query($mysqli,"UPDATE  `teacher_list` SET  `delete_status` =  '0' WHERE  `teacher_list`.`tl_id` = '{$del_id}'");
    $sql_keyword_tydel = mysqli_query($mysqli,"DELETE FROM search_keyword WHERE key_item = '{$del_id}'");
	$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allcount = cl_allcount-1 WHERE cl_id = '{$tlclass}'");
	echo 1;
}
?>