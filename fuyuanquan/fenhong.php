<?php 
header("Content-Type: text/html;charset=utf-8"); 
include ("../db_config.php");

$shareall = 60000000;

//$query = "SELECT mb_phone,mb_commission_not_gold,mb_share FROM fyq_member where mb_share > '0'";
$query = "SELECT mb_phone,mb_commission_not_gold,mb_share FROM fyq_member where mb_phone = '13844358055'";
if ($result = mysqli_query($mysqli, $query))
{
    while($row = mysqli_fetch_assoc($result)){
        $mb_share = $row['mb_share'];
        $money = 18168*($mb_share/$shareall);
			//$money = 36.336;
        $fornow = "2018年3月分红".$money."元";
        $phone = $row['mb_phone'];
        $before_money = $row['mb_commission_not_gold'];
        $after_money = $row['mb_commission_not_gold']+$money;
        mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_phone, t_caption, t_description, t_fornow, t_point, t_before_money, t_after_money, t_service_point, t_trade_no, t_trade_no_alipay, t_payment_id) VALUES ('{$money}', 'revenue', '1', '{$phone}', 'partner_money', '{$fornow}','0', '0', '{$before_money}', '{$after_money}','0','','','0')");
        
        mysqli_query($mysqli,"UPDATE fyq_member SET mb_partner_all_gold = mb_partner_all_gold+$money, mb_partner_not_gold = mb_partner_not_gold+$money WHERE mb_phone = '{$phone}'");
    }
}


?>