<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_deletes")) {
	echo "��û��Ȩ�޷��ʴ�ҳ";
	exit;
}
$member_id = $_POST['member_id'];

$sql_member_del = mysqli_query($mysqli,"DELETE FROM fyq_member WHERE mb_id = '{$member_id}'");
if ($sql_member_del) {
	echo 1;
}
?>