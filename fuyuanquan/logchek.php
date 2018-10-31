<?php 
include( "../db_config.php" );

$admin_id = @$_POST[ 'signin_id' ];
$admin_pass = @$_POST[ 'signin_pass' ];

	$admin_member_pass = md5($admin_pass."fyq");
	$admin_member_sql = mysqli_query($mysqli, "SELECT count(mb_phone) FROM fyq_member where mb_phone = '{$admin_id}' and mb_pass = '{$admin_member_pass}'");
	$admin_member_rs=mysqli_fetch_array($admin_member_sql,MYSQLI_NUM);
	$admin_member_Number=$admin_member_rs[0];
	
	$admin_agent_sql = mysqli_query($mysqli, "SELECT count(ag_phone) FROM admin_agent where ag_phone = '{$admin_id}'");
	$admin_agent_rs=mysqli_fetch_array($admin_agent_sql,MYSQLI_NUM);
	$admin_agent_Number=$admin_agent_rs[0];
	
	if ($admin_member_Number && $admin_agent_Number) {
        session_start();
		$_SESSION['agent'] = $admin_id;
		echo "<script> parent.location.href='../admin_agent/member_list.php'; </script>";
	} else {
		echo "<script> alert('登陆失败！');parent.location.href='login.php'; </script>";
	}


?>