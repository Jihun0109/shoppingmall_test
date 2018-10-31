<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"vipcard")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["vuser"])) {
    $vuser = $_POST["vuser"];
} else {
    $vuser = 0;
}
if (isset($_POST["vpoint"])) {
    $vpoint = $_POST["vpoint"];
} else {
    $vpoint = 0;
}
if ($vpoint<0) {
    echo 0;
    exit();
}
$vtime = date("Y-m-d H:i:s",time());

$query_v = "SELECT surplus_num,item_id FROM vip_card where id = '{$vuser}'";
if ($result_v = mysqli_query($mysqli, $query_v))
{
    $row_v = mysqli_fetch_assoc($result_v);
    if ($row_v['surplus_num']<$vpoint) {
        echo 2;
        exit();
    }
    $item_id = $row_v['item_id'];
}
$sql_vip = mysqli_query($mysqli,"UPDATE vip_card SET surplus_num = surplus_num-$vpoint, up_time = '{$vtime}' WHERE id = '{$vuser}'");
if ($sql_vip) {
    mysqli_query($mysqli,"INSERT INTO vip_card_log (user_id, item_id, surplus_point) VALUES ('{$vuser}', '{$item_id}', '{$vpoint}')");
	echo 1;
} else {
	echo 0;
}
?>