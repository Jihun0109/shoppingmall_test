<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
ini_set('date.timezone','Asia/Shanghai');
if (strstr($_SERVER['HTTP_HOST'],"app.shengtai114.com")) {
    if (!strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
        exit();
    }
}
//$db_host = "192.168.2.107";
//$db_user = "fuyuanquan_db";
//$db_psw = "fuyuanquan20170820!@#";
$db_host = "localhost";
$db_user = "root";
$db_psw = "";//rhksflwk@ng
$db_name = "study_media_db";//"fuyuanquan_db";//"study_media_db";
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

function AgentInfo($money,$phone,$fornow,$before_money,$after_money)
{
	global $mysqli;
	mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_phone, t_caption, t_description, t_fornow, t_point, t_before_money, t_after_money, t_service_point, t_trade_no, t_trade_no_alipay, t_payment_id) VALUES ('{$money}', 'revenue', '1', '{$phone}', 'agent_money', '{$fornow}','0', '0', '{$before_money}', '{$after_money}','0','','','0')");//记录详细信息
	
	mysqli_query($mysqli,"UPDATE fyq_member SET mb_commission_all = mb_commission_all+$money, mb_commission_not_gold = mb_commission_not_gold+$money WHERE mb_phone = '{$phone}'");//修改代理原金额			
}

function getAgent_Insert_sql($money,$phone,$fornow,$before_money,$after_money)
{
	return "INSERT INTO balance_details (t_money, t_way, t_status, t_phone, t_caption, t_description, t_fornow, t_point, t_before_money, t_after_money, t_service_point, t_trade_no, t_trade_no_alipay, t_payment_id) VALUES ('{$money}', 'revenue', '1', '{$phone}', 'agent_money', '{$fornow}','0', '0', '{$before_money}', '{$after_money}','0','','','0')";
}

function getAgent_Up_sql($money,$phone)
{
	return "UPDATE fyq_member SET mb_commission_all = mb_commission_all+$money, mb_commission_not_gold = mb_commission_not_gold+$money WHERE mb_phone = '{$phone}'";
}

function getAgentList($ml,$province,$city,$area)//取商户所在地区代理
{
	global $mysqli;
	$wh = "";
	switch($ml)
	{
		case '5':
			$wh = " and mb_province='{$province}' and mb_city='{$city}' and mb_area='{$area}'";
			break;
		case '6':
			$wh = " and mb_province='{$province}' and mb_city='{$city}'";
			break;
		case '7':
			$wh = " and mb_province='{$province}'";
			break;
	}
	$query_ml = "SELECT * FROM fyq_member where mb_level = '{$ml}'".$wh;
	$result_ml = mysqli_query($mysqli, $query_ml);
	return $result_ml;
}
?>