<?php 
session_start();
if (isset($_SESSION['admin'])) {
    $admin_login = $_SESSION['admin'];
} else {
//    $admin_login = '13634336777';
	$admin_login = '';
}

if ($admin_login) {
	$query_admin = "SELECT * FROM fyq_admin where ad_id = '{$admin_login}'";
	//echo $query_admin;
	if ($result_admin = mysqli_query($mysqli, $query_admin))
	{
		$row_admin = mysqli_fetch_assoc($result_admin);
		$admin_purview = $row_admin['ad_purview'];
        $admin_level = $row_admin['ad_level'];
	}
} else {
	echo "<script> alert('请先登陆管理员账号！');parent.location.href='login.php'; </script>";
	exit;
}
?>