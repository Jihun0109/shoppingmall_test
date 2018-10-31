<?php 
include ("../db_config.php");
$receipt_name = @$_POST["receipt_name"];
$receipt_alipay = @$_POST["receipt_alipay"];
$alipay_account = @$_POST['alipay_account'];
$receipt_wechat = @$_POST["receipt_wechat"];
$receipt_card = @$_POST["receipt_card"];
$receipt_open_bank = @$_POST["receipt_open_bank"];
$member_id = $member_login;
if (strstr($receipt_alipay,"zhifubao.jpg")) {
	$receipt_alipay = "";
}
if (strstr($receipt_wechat,"weixin.jpg")) {
	$receipt_wechat = "";
}
$sql_bank = mysqli_query($mysqli,"UPDATE fyq_member SET mb_name_receipt = '{$receipt_name}', mb_alipay_receipt = '{$receipt_alipay}', mb_alipay_account = '{$alipay_account}', mb_wechat_receipt = '{$receipt_wechat}', mb_open_bank = '{$receipt_open_bank}', mb_bankcardnumber = '{$receipt_card}' WHERE mb_phone = '{$member_id}'");
if ($sql_bank) {
	echo 1;
} else {
	echo 0;
}
?>