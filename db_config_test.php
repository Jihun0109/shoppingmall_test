<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
if (strstr($_SERVER['HTTP_HOST'],"app.shengtai114.com")) {
    if (!strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
        exit();
    }
}
//$db_host = "127.0.0.1";
//$db_user = "fuyuanquan_db";
//$db_psw = "fuyuanquan20170820!@#";
$db_host = "127.0.0.1";
$db_user = "root";
// $db_psw = "rhksflwk@ng";
$db_psw = "mysql";
$db_name = "fuyuanquan_db";
$mysqli=mysqli_connect($db_host,$db_user,$db_psw,$db_name); //实例化mysqli
mysqli_set_charset($mysqli, "utf8");

if (isset($_COOKIE["member"])) {
	$member_login = $_COOKIE["member"];
	$query = "SELECT * FROM fyq_member where mb_phone = '{$member_login}'";
	if ($result = mysqli_query($mysqli, $query))
	{
		$row_member = mysqli_fetch_assoc($result);
		$row_member_count = mysqli_num_rows($result);
		if (!$row_member_count) {
			$_COOKIE["member"] = "";
			$member_login = 0;
		}
	}
} else {
	$member_login = 0;
}
if (isset($_GET['qid'])) {
    $qid = $_GET['qid']; 
} else {
    $qid = '';
}
if ($qid) {
	setcookie("qid", $qid, time()+3600*24*7,"/");
}
var_dump($mysqli);

function utf8_strcut( $str, $size, $suffix='...' ) {
	$substr = substr( $str, 0, $size * 2 );
	$multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );

	if ( $multi_size > 0 )
		$size = $size + intval( $multi_size / 3 ) - 1;

	if ( strlen( $str ) > $size ) {
		$str = substr( $str, 0, $size );
		$str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
		$str .= $suffix;
	}

	return $str;
}
?>