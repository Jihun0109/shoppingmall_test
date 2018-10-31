<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"vipcard")) {
	echo "您没有权限访问此页";
	exit;
}
$user_phone = $_POST["user_phone"];
$vipitem = $_POST["vipitem"];

$query = "SELECT * FROM teacher_list where tl_id = '{$vipitem}'";
if ($result = mysqli_query($mysqli, $query))
	{
		$row = mysqli_fetch_assoc($result);
        $tl_id = $row['tl_id'];
        $tl_name = $row['tl_name'];
        $tl_price = $row['tl_price'];
        $tl_phone = $row['tl_phone'];
        $vip_point = $row['vip_point'];
        $jiontime = date("Y-m-d H:i:s",time());
    
        $sql_vip = mysqli_query($mysqli,"INSERT INTO vip_card (item_id, item_name, item_pay, user_phone, item_phone, surplus_num, jion_time) VALUES ('{$tl_id}', '{$tl_name}', '{$tl_price}', '{$user_phone}', '{$tl_phone}', '{$vip_point}', '{$jiontime}')");
        mysqli_query($mysqli,"INSERT INTO item_limit (item_id, user_id) VALUES ('{$tl_id}', '{$user_phone}', '1')");
		
		if ($sql_vip) {
			echo 1;
		} else {
			echo 0;
		}
	}
?>