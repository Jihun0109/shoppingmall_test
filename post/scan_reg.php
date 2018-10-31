<?php 
include("../include/data_base.php");
include ("../include/recomend_level.php");
if (isset($_POST["recommend_phone"])) {
    $recommend_phone = $_POST["recommend_phone"]; 
} else {
    $recommend_phone = '';
}
if (isset($_POST["recommend_vid"])) {
    $recommend_vid = $_POST["recommend_vid"];
} else {
    $recommend_vid = '';
}
if (isset($_POST["recommend_vphone"])) {
    $recommend_vphone = $_POST["recommend_vphone"];
} else {
    $recommend_vphone = '';
}
if (isset($_POST["recommend_price"])) {
    $recommend_price = $_POST["recommend_price"];
} else {
    $recommend_price = '';
}
if (isset($_POST["recommend_openid"])) {
    $recommend_openid = $_POST["recommend_openid"];
} else {
    $recommend_openid = '';
}

$trade_no = date("Ymdhis",time()).rand(11111,999999);

$shipping_address = $_POST['shipping_address']?$_POST['shipping_address']:"";

$sql = "INSERT INTO payment_list (pay_member, pay_cate, pay_status, pay_shop, pay_count, pay_price, pay_trade_no, payment_types, mb_receiving_address) VALUES ('{$recommend_phone}', 'scan', '0', '{$recommend_vid}', '1', '{$recommend_price}', '{$trade_no}', '0', '{$shipping_address}')";
$sql_payment = mysqli_query($mysqli,$sql);

$recommend_count = mysqli_query($mysqli, "SELECT count(mb_id) FROM fyq_member where mb_phone = '{$recommend_phone}'");
$recommend_rs = mysqli_fetch_array($recommend_count,MYSQLI_NUM);
$recommend_Number = $recommend_rs[0];

if ($recommend_Number) {
	//echo 2;
	if ($recommend_openid) {
		$sql_openid_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_openid = '{$recommend_openid}' where mb_phone = '{$recommend_phone}'");//更新openid
	}
	setcookie("member", $recommend_phone, time()+3600*24*365,"/");
} else {
	$query_recommend = "SELECT * FROM fyq_member where mb_phone = '{$recommend_vphone}'";
	if ($result_recommend = mysqli_query($mysqli, $query_recommend))
	{
		$row_recommend = mysqli_fetch_assoc($result_recommend);
		$mb_phone = $row_recommend['mb_phone'];
		$mb_province = $row_recommend['mb_province'];
		$mb_city = $row_recommend['mb_city'];
		$mb_area = $row_recommend['mb_area'];

		$recommend_nick = substr($recommend_phone,-4);
		$recommend_pass = md5($recommend_nick."fyq");

		$sql_user_recommend = mysqli_query($mysqli,"INSERT INTO fyq_member (mb_phone, mb_nick, mb_pass, mb_recommend, mb_level, mb_province, mb_city, mb_area, mb_point, mb_openid) VALUES ('{$recommend_phone}', '{$recommend_nick}', '{$recommend_pass}', '{$mb_phone}', '1', '{$mb_province}', '{$mb_city}', '{$mb_area}', '100', '{$recommend_openid}')");
		if ($sql_user_recommend) {
			setcookie("member", $recommend_phone, time()+3600*24*365,"/");
			$sql_recommend_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point+300 where mb_phone = '{$mb_phone}'");
            recommend_level($recommend_phone,$mb_phone,"../include/data_base.php");
		}
	}
}

$payment_count = mysqli_query($mysqli, "SELECT count(pay_trade_no) FROM payment_list where pay_trade_no = '{$trade_no}'");
$payment_rs = mysqli_fetch_array($payment_count,MYSQLI_NUM);
$payment_Number = $payment_rs[0];
if ($payment_Number) {
	echo $trade_no;
} else {
	echo 10;
}
?>