<?php 
include( "../db_config.php" );
$phone_num = @$_POST['phone_num'];
$follow_ico = @$_POST['follow_ico'];
$shop_id = @$_POST['shop_id'];
if (!$phone_num) {
	echo 0;
	exit;
}
$query_teac = "SELECT * FROM teacher_list where tl_id = {$shop_id}";
if ($result_teac = mysqli_query($mysqli, $query_teac))
{
	$row_teac = mysqli_fetch_assoc($result_teac);
	$tlclass = $row_teac['tl_class'];
}
if ($follow_ico == "img/off_ok.png" || $follow_ico == "svg/follow_off.svg") {
	$sql_follow = mysqli_query($mysqli,"INSERT INTO follow_list (fl_phone, fl_tid) VALUES ('{$phone_num}', '{$shop_id}')");
	if ($sql_follow) {
		echo 1;
		$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allfollow = cl_allfollow+1 WHERE cl_id = '{$tlclass}'");
	}
}
if ($follow_ico == "img/on_ok.png" || $follow_ico == "svg/follow_on.svg") {
	$sql_follow = mysqli_query($mysqli,"DELETE FROM follow_list WHERE fl_phone = '{$phone_num}' and fl_tid = '{$shop_id}'");
	if ($sql_follow) {
		echo 2;
		$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allfollow = cl_allfollow-1 WHERE cl_id = '{$tlclass}'");
	}
}

?>