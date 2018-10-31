<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"memo_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
$me_id = $_POST["me_id"];
$me_title = $_POST["me_title"];
$me_cate = $_POST["me_cate"];
$me_content = $_POST["me_content"];

$sql_me = mysqli_query($mysqli,"UPDATE memo_list SET me_title = '{$me_title}', me_txt = '{$me_content}', me_cate = '{$me_cate}' WHERE me_id = '{$me_id}'");
	
if ($sql_me) {
	echo 1;
} else {
	echo 0;
}
?>