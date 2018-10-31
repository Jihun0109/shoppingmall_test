<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"memo_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
$me_title = $_POST["me_title"];
$me_cate = $_POST["me_cate"];
$me_content = $_POST["me_content"];
$me_time = time();
if ($me_cate == 20) {
$query = "SELECT * FROM fyq_member order by mb_id desc";
if ($result = mysqli_query($mysqli, $query))
	{
		while( $row = mysqli_fetch_assoc($result) ){
			$mb_phone = $row['mb_phone'];
			$sql_memo = mysqli_query($mysqli,"INSERT INTO memo_list (me_send, me_receive, me_txt, me_time, me_title, me_cate) VALUES ('admin', '{$mb_phone}', '{$me_content}', '{$me_time}', '{$me_title}', '{$me_cate}')");
		}
		if ($sql_memo) {
			echo 1;
		} else {
			echo 0;
		}
	}
}
if ($me_cate == 10) {
	$sql_memo = mysqli_query($mysqli,"INSERT INTO memo_list (me_send, me_receive, me_txt, me_time, me_title, me_cate) VALUES ('admin', 'user', '{$me_content}', '{$me_time}', '{$me_title}', '{$me_cate}')");	
	if ($sql_memo) {
		echo 1;
	} else {
		echo 0;
	}
}
?>