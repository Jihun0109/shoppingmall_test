<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"my_member_list_up")) {
	echo "您没有权限访问此页";
	exit;
}
$mb_agent_phone = $_POST["mb_agent_phone"];
$mb_agent_price = $_POST["mb_agent_price"];
$mb_agent_level = $_POST["mb_agent_level"];
$sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_level = '{$mb_agent_level}' WHERE mb_phone = '{$mb_agent_phone}'");
if ($sql_member) {
	$agent_count = mysqli_query($mysqli, "SELECT count(*) FROM admin_agent where ag_phone = '{$mb_agent_phone}'");
	$agent_rs=mysqli_fetch_array($agent_count,MYSQLI_NUM);
	$agent_Number=$agent_rs[0];
	if ($agent_Number) {
		$sql_member = mysqli_query($mysqli,"UPDATE admin_agent SET ag_balance = ag_balance+$mb_agent_price WHERE ag_phone = '{$mb_agent_phone}'");
		echo 1;
	} else {
		$sql_agent = mysqli_query($mysqli,"INSERT INTO admin_agent (ag_phone, ag_level, ag_pass, ag_angel, ag_balance) VALUES ('{$mb_agent_phone}', '{$mb_agent_level}', '', '0', '{$mb_agent_price}')");
		echo 1;
	}
} else {
	echo 0;
}
?>