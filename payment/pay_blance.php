<?php 
header("Content-Type: text/html;charset=utf-8"); 
include("../db_config.php");
include("../include/send_post.php");
$member_id = $member_login;
if (!$member_id) {
	echo "您还没有登陆操作失败！";
	exit;
}
$_WIDout_trade_no = $_POST['WIDout_trade_no'];
$WIDsubject = $_POST['WIDsubject'];
$WIDtotal_amount = $_POST['WIDtotal_amount'];

$query_payment = mysqli_query($mysqli,"SELECT count(*) FROM payment_list where pay_trade_no = '{$_WIDout_trade_no}' and pay_member = '{$member_id}' and pay_status = '0'");
$payment_rs = mysqli_fetch_array($query_payment,MYSQLI_NUM);
$payment_Number = $payment_rs[0];

$query_pay_balance = mysqli_query($mysqli,"SELECT count(*) FROM fyq_member where mb_not_gold >= '{$WIDtotal_amount}' and mb_phone = '{$member_id}'");
$province_rs = mysqli_fetch_array($query_pay_balance,MYSQLI_NUM);
$province_totalNumber = $province_rs[0];

$out_trade_no = htmlspecialchars($_WIDout_trade_no);
$total_amount = htmlspecialchars($WIDtotal_amount);
$trade_no = htmlspecialchars($_WIDout_trade_no);
$payment_method = "balance";
if ($payment_Number) {
	if($province_totalNumber) {
        $sql_member_balance = mysqli_query($mysqli,"UPDATE fyq_member SET mb_not_gold = mb_not_gold-$total_amount WHERE mb_phone = '{$member_id}'");
        $post_data = array(
            'out_trade_no' => $out_trade_no,
            'total_amount' => $total_amount,
            'trade_no' => $trade_no
        );
        $pay_finish = send_post('http://fyq.shengtai114.com/payment/notify_url.php', $post_data);
        if (!strstr($pay_finish,"complete")) {
            echo "<script> alert('支付响应有点慢请 重新提交支付');parent.location.href='../member_center.php'; </script>";
            exit;
        }
		
	} else {
		echo "<script> alert('余额不足');parent.location.href='../member_center.php'; </script>";
        exit;
	}
}
$head_title = "余额支付";
include("../include/head_.php");
$top_title = "余额支付";
$return_url = "http://fyq.shengtai114.com";
include("../include/top_navigate.php");
?>		
<div class="pay_end_top">
	<img src="../img/pay_end.png" alt="支付成功">
</div>
<div class="pay_end_content">
	<img src="../img/zhifubao.png" alt="余额支付" class="pay_end_logo">
	<div class="pay_end_title">
		<img src="../img/pay_ok.png" alt="ICO">
		<span>支付成功</span>
	</div>
	<div class="pay_end_txt">
		<p><?php echo date("Y-m-d H:i:s");?></p>
		<p>亲，您已支付成功了！</p>
		<p>订单号: <?php echo $out_trade_no;?></p>
		<p>支付金额: ￥<?php echo $total_amount;?></p>
		<P>费用类型: 余额支付</P>
	</div>
</div>
<div class="pay_end_index">
<a href="http://fyq.shengtai114.com/" target="_self">知道了</a>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("body").css("background-color","#ffffff");
});
</script>
<?php 
include("../include/foot_.php");
?>