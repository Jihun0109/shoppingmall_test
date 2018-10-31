<?php 
include("../db_config.php");
if (!$member_login) {
	exit;
}
$WIDout_trade_no = $_POST['WIDout_trade_no'];
$WIDtotal_amount = $_POST['WIDtotal_amount'];
$head_title = "幸福豆支付";
include("../include/head_.php");
$top_title = "幸福豆支付";
$return_url = "..";
include("../include/top_navigate.php");

if ($row_member['mb_point'] < $WIDtotal_amount) {
	echo "<script> alert('您当前积分不够');parent.location.href='member_center.php'; </script>";
	exit;
}
?>
<div class="pay_end_top">
	<img src="../img/pay_end.png" alt="兑换成功">
</div>
<div class="pay_end_content">
	<img src="../img/point_ico.png" alt="幸福豆" class="pay_end_logo">
	<div class="pay_end_title">
		<img src="../img/pay_ok.png" alt="ICO">
		<span>兑换成功</span>
	</div>
	<div class="pay_end_txt">
		<p><?php echo date("Y-m-d H:i:s");?></p>
		<p>亲，您已兑换成功了！</p>
		<p>订单号: <?php echo $WIDout_trade_no;?></p>
		<p>兑换积分: <?php echo $_POST['WIDtotal_amount'];?>个</p>
		<P>费用类型: 积分兑换</P>
	</div>
</div>
<div class="pay_end_index">
<a href="../" target="_self">知道了</a>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("body").css("background-color","#ffffff");
});
</script>
<?php 
$sql_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point-$WIDtotal_amount WHERE mb_phone = '{$member_login}'");

$query = "SELECT * FROM payment_list where pay_member = '{$member_login}' and pay_status = '0' and pay_trade_no = '{$WIDout_trade_no}' order by pay_id desc limit 1";
$result = mysqli_query( $mysqli, $query );
$row = mysqli_fetch_assoc( $result );
$tc_id = $row['pay_shop'];
$sql_item = mysqli_query($mysqli,"UPDATE teacher_list SET tl_Sales = tl_Sales+1 WHERE tl_id = '{$tc_id}'");

$sql_payment = mysqli_query($mysqli,"UPDATE payment_list SET pay_status = '1', ship_status = '1', payment_method = 'allpoint' WHERE pay_trade_no = '{$WIDout_trade_no}'");
include("../include/foot_.php");
?>