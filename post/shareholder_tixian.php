<?php 
include ("../db_config.php");
include("../include/send_post.php");
$tixian_m = intval(@$_POST["tixian_m"]);
$tixian_commission = $tixian_m;
$tixian_m_shui = $tixian_m*0.06;
$tixian_cate = @$_POST["tixian_cate"];
$commission_point_fee = @$_POST['commission_point_fee'];
$com_point_sui = $tixian_m_shui*100;
$member_id = $member_login;
$mb_not_gold = $row_member['mb_partner_not_gold'];
if ($mb_not_gold < $tixian_m) {
	echo 2;
	exit;
}
$query_receipt = "SELECT * FROM fyq_member where mb_phone = {$member_id}";
if ($result_receipt = mysqli_query($mysqli, $query_receipt))
{
	$row_receipt = mysqli_fetch_assoc($result_receipt);
	$name_receipt = $row_receipt['mb_name_receipt'];
	$alipay_receipt = $row_receipt['mb_alipay_receipt'];
	$alipay_account = $row_receipt['mb_alipay_account'];
	$wechat_receipt = $row_receipt['mb_wechat_receipt'];
	$wechat_account = $row_receipt['mb_wechat_account'];
	$open_bank = $row_receipt['mb_open_bank'];
	$bankcardnumber = $row_receipt['mb_bankcardnumber'];
	$receipt_point = $row_receipt['mb_point'];
	$mb_partner_not_gold = $row_receipt['mb_partner_not_gold'];
	$before_money = $mb_partner_not_gold;
	$after_money = $mb_partner_not_gold - $tixian_commission;
}
if ($commission_point_fee) {
	if ($receipt_point < $com_point_sui) {
		echo 10;
		exit;
	}
} else {
	$tixian_m = $tixian_m - $tixian_m_shui;
	$com_point_sui = 0;
}

if ($tixian_cate == "weixin" && ($wechat_receipt || $wechat_account)) {
	$tixian_wechat = 1;
} else {
	$tixian_wechat = 0;
}
if ($tixian_cate == "bank" && $open_bank && $bankcardnumber) {
	$tixian_bank = 1;
} else {
	$tixian_bank = 0;
}
if ($tixian_cate == "alipay" && ($alipay_receipt || $alipay_account)) {
	$tixian_alipay = 1;
} else {
	$tixian_alipay = 0;
}

if ($name_receipt && ($tixian_wechat || $tixian_bank || $tixian_alipay)) {
	if ($mb_not_gold<100) {
		echo 2;
	} else {
        $query_balance = "SELECT t_time FROM balance_details where t_phone = '{$member_id}'";
        if ($result_balance = mysqli_query($mysqli, $query_balance))
        {
            $row_balance = mysqli_fetch_assoc($result_balance);
            $balance_time1=strtotime($row_balance['t_time']);
            $balance_time2=strtotime(date("Y-m-d H:i:s"));
            $balance_zero = $balance_time2-$balance_time1;
        }
        if ($balance_zero > 5) {
            $sql_tixian = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_phone, t_caption, t_description, t_cate, t_point, t_before_money, t_after_money, t_service_money, t_service_point) VALUES ('{$tixian_m}', '{$tixian_cate}', '0', '{$member_id}', 'partner_money', '股东提现', 'partner_less', '{$com_point_sui}', '{$before_money}', '{$after_money}', '{$tixian_m_shui}', '{$com_point_sui}')");
            if ($sql_tixian) {
                $sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_partner_not_gold = mb_partner_not_gold-'{$tixian_commission}', mb_partner_finish_gold = mb_partner_finish_gold+'{$tixian_m}', mb_point = mb_point-$com_point_sui WHERE mb_phone = '{$member_id}'");
                if ($sql_member) {
                    echo 1;
                    $post_data = array(
                        'phone_num' => $member_id,
                        'phone_type' => 'expre_patner',
                        'phone_price' => $tixian_m,
                    );
                    send_post('http://fyq.shengtai114.com/post/smscode.php', $post_data);
                } else {
                    echo 0;
                }
            } else {
                echo 0;
            }
        }
	}
} else {
	echo 5;
}
?>