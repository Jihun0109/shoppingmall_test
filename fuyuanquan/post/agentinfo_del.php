<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"AgentInfo_up")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["ai_id"])) {
    $ai_id = $_POST["ai_id"];
} else {
    $ai_id = '';
}

$sql_member_del = mysqli_query($mysqli,"DELETE FROM agentinfo WHERE ai_id = '{$ai_id}'");
if ($sql_member_del) {
	echo 1;
}
else
{
	echo 0;
}
?>