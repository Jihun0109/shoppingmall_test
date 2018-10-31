<?php 
include ("../../db_config.php");
$agent_id = @$_SESSION['agent'];
if (!$agent_id) {
	exit;
}
$mb_agent_phone = $_POST["mb_agent_phone"];
$mb_agent_level = $_POST["mb_agent_level"];

$query_member_level = "SELECT * FROM fyq_member where mb_phone = '{$mb_agent_phone}'";
if ($result_member_level = mysqli_query($mysqli, $query_member_level))
{
	$row_member_level = mysqli_fetch_assoc($result_member_level);
	$mb_level = $row_member_level['mb_level'];
	$mb_distribution = $row_member_level['mb_distribution'];
}

$query_agent = "SELECT * FROM admin_agent where ag_phone = '{$agent_id}'";
if ($result_agent = mysqli_query($mysqli, $query_agent))
{
	$row_agent = mysqli_fetch_assoc($result_agent);
	$ag_balance = $row_agent['ag_balance'];
	$ag_level = $row_agent['ag_level'];
	if ($ag_level == "5") {
		$balance_1980 = "990";
		$balance_9800 = "5000";
	}
	if ($ag_level == "6") {
		$balance_1980 = "792";
		$balance_9800 = "4000";
	}
	if ($ag_level == "7") {
		$balance_1980 = "594";
		$balance_9800 = "3000";
	}
}

if ($mb_distribution == "0.00" && $mb_agent_level == 3) {
	if ($mb_level < 3) {
		$mb_agent_level_up = 3;
	} else {
		$mb_agent_level_up = $mb_level;
	}
	if ($ag_balance < $balance_1980) {
		echo 5;
		exit;
	}
	$sql_agent_admin = mysqli_query($mysqli,"UPDATE admin_agent SET ag_balance = ag_balance-$balance_1980 WHERE ag_phone = '{$agent_id}'");
	if ($sql_agent_admin) {
		$sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_level = '{$mb_agent_level_up}', mb_distribution = '1980.00' WHERE mb_phone = '{$mb_agent_phone}'");
		echo $sql_agent_admin;
		exit;
	}
} else 
if (($mb_distribution == "1980.00" || $mb_distribution == "0.00") && $mb_agent_level == 4) {
	if ($mb_level < 4) {
		$mb_agent_level_up = 4;
	} else {
		$mb_agent_level_up = $mb_level;
	}
	if ($ag_balance < $balance_9800) {
		echo 5;
		exit;
	}
	$sql_agent_admin = mysqli_query($mysqli,"UPDATE admin_agent SET ag_balance = ag_balance-$balance_9800 WHERE ag_phone = '{$agent_id}'");
	if ($sql_agent_admin) {
		$sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_level = '{$mb_agent_level_up}', mb_distribution = '9800.00' WHERE mb_phone = '{$mb_agent_phone}'");
		echo 1;
	}
} else {
	echo 2;
}
?>