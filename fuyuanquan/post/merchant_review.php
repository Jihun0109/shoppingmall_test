<?php 
include( "../../db_config.php" );
include("../admin_login.php");
if (!strstr($admin_purview,"merchant_updates")) {
	echo "您没有权限访问此页";
	exit;
}
$mid = $_POST["mid"];

$query_college = "SELECT * FROM college_list where me_id = '{$mid}'";
$result_college = mysqli_query($mysqli, $query_college);
//print_r($result_merchant);
if ($result_college->num_rows == 0)
{
	$query_merchant = "SELECT * FROM merchant_entry where me_id = '{$mid}'";
	$result_merchant = mysqli_query($mysqli, $query_merchant);
	$row = mysqli_fetch_assoc( $result_merchant );
	
	$sql_busines = mysqli_query($mysqli,"INSERT INTO college_list (cl_name, cl_province, cl_city, cl_area, cl_cate, cl_logo, cl_bg, cl_class, cl_admin, cl_phone, me_id) VALUES ('{$row['me_shop']}', '{$row['me_province']}', '{$row['me_city']}', '{$row['me_area']}', '10', '{$row['me_logo']}', '{$row['me_bg']}', 'busines', 'admin', '{$row['me_user']}', '{$mid}')");
}
$sql_merchant = mysqli_query($mysqli,"UPDATE merchant_entry SET me_state = '1' WHERE me_id = '{$mid}'");
if ($sql_merchant) {
	echo 1;
} else {
	echo 0;
}
?>