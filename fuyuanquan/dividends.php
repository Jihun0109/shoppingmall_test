<?php 
header("Content-Type: text/html;charset=utf-8"); 
include ("../db_config.php");
include("admin_login.php");
if (!strstr($admin_purview,"dividends")) {
	echo "您没有权限访问此页";
	exit;
}
$shareall = 60000000;
function getlastMonthDays($date){
     $timestamp=strtotime($date);
     $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
     $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
     return array($firstday,$lastday);
}
$lastdate = getlastMonthDays(date('Ymd'));
$lastYear = date('Y',strtotime($lastdate[0]));
$lastmonth = date('n',strtotime($lastdate[0]));
$query = "SELECT mb_phone,mb_commission_not_gold,mb_share FROM fyq_member where mb_share > '0'";
//$query = "SELECT mb_phone,mb_commission_not_gold,mb_share FROM fyq_member where mb_phone = '13844358055'";
$cnt = 0;
$moneyall = 0;
$sharetmp = 0;
if ($result = mysqli_query($mysqli, $query))
{
    while($row = mysqli_fetch_assoc($result)){
        $mb_share = $row['mb_share'];
        $money = 20118*($mb_share/$shareall);//18168，20118
			//$money = 36.336;
        $fornow = $lastYear."年".$lastmonth."月分红".$money."元";
        $phone = $row['mb_phone'];
        $before_money = $row['mb_commission_not_gold'];
        $after_money = $row['mb_commission_not_gold']+$money;
		
        //mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_phone, t_caption, t_description, t_fornow, t_point, t_before_money, t_after_money, t_service_point, t_trade_no, t_trade_no_alipay, t_payment_id) VALUES ('{$money}', 'revenue', '1', '{$phone}', 'partner_money', '{$fornow}','0', '0', '{$before_money}', '{$after_money}','0','','','0')");
        
        //mysqli_query($mysqli,"UPDATE fyq_member SET mb_partner_all_gold = mb_partner_all_gold+$money, mb_partner_not_gold = mb_partner_not_gold+$money WHERE mb_phone = '{$phone}'");
		$cnt++;
		$moneyall += $money;
		$sharetmp += $mb_share;
    }
}
?>
<li>
    <span>共 <?php echo $cnt;?>份 <!--<?php echo $sharetmp;?>股--></span>
</li>
<li>
    <span>发放总额 <?php echo $moneyall?>元</span>
</li>