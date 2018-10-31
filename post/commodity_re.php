<?php 
include( "../db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('ÇëÏÈµÇÂ½ÕÊºÅ');parent.location.href='index.php'; </script>";
	exit;
}
$re_id = $_POST['commodity_id'];
$query_teac = "SELECT * FROM teacher_list where tl_id = {$re_id}";
if ($result_teac = mysqli_query($mysqli, $query_teac))
{
	$row_teac = mysqli_fetch_assoc($result_teac);
	$now_time = date('Y-m-d H:i:s');
	$re_time = $row_teac['tl_time'];
	$minute=floor((strtotime($now_time)-strtotime($re_time))%86400/60);
	if($minute >= 10)
	{
		$sql_college_flow = mysqli_query($mysqli,"UPDATE teacher_list SET tl_time = '".$now_time."' WHERE tl_id = '{$re_id}'");
		echo 1;
	}
	else
	{
		echo 2;
	}
}
?>