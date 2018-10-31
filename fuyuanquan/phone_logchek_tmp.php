<?php 
include( "../db_config.php" );

$admin_id = @$_POST['signin_id'];
$admin_pass = @$_POST['signin_pass'];
$admin_time = time()-300;
$admin_time = date("YmdHis",$admin_time);

$admin_code_sql = mysqli_query($mysqli, "SELECT count(*) FROM phone_code where pco_number = '{$admin_id}' and pco_code = '{$admin_pass}' and pco_type = 'adminlogin' and pco_status = '0' and date_format(phone_code.pco_time,'%Y%m%d%H%i%s') > '{$admin_time}'");
$admin_code_rs=mysqli_fetch_array($admin_code_sql,MYSQLI_NUM);
$admin_code_Number=$admin_code_rs[0];

$admin_sql = mysqli_query($mysqli, "SELECT count(ad_id) FROM fyq_admin where ad_id = '{$admin_id}'");
$admin_rs=mysqli_fetch_array($admin_sql,MYSQLI_NUM);
$admin_totalNumber=$admin_rs[0];
if (1) {
    session_start();
	$_SESSION['admin'] = $admin_id;
	$sql_busines = mysqli_query($mysqli,"UPDATE phone_code SET pco_status = '1' WHERE pco_number = '{$admin_id}' and pco_code = '{$admin_pass}' and pco_type = 'adminlogin' and pco_status = '0'");
	echo "<script> parent.location.href='index.php'; </script>";	
} else {
	//echo "<script> alert('登陆失败！');parent.location.href='phone_login.php'; </script>";
	echo "<script> alert('登陆失败！');</script>";
}
?>