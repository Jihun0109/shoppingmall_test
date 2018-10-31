<?php
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

if (!$member_login) {
    exit;
}
	//商户订单号
	$out_trade_no = $_POST['out_trade_no'];
	$total_amount = $_POST['total_amount'];
	$trade_no = $_POST['trade_no'];
	$payment_method = "balance";
    include("../pay_success.php");
echo "complete";
?>