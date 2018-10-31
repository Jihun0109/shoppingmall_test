<?php
include( "db_config.php" );
$member_id = $member_login;
$trade_no = @$_GET['tradeno'];
if (!$trade_no) {
	exit;
}
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$query = "SELECT * FROM payment_list where pay_member = '{$member_id}' and pay_status = '0' and pay_trade_no = '{$trade_no}' order by pay_id desc limit 1";
$result = mysqli_query( $mysqli, $query );
$row = mysqli_fetch_assoc( $result );
$tc_id = $row['pay_shop'];

$query_tc = "SELECT * FROM teacher_list where tl_id = '{$tc_id}' limit 1";
$result_tc = mysqli_query( $mysqli, $query_tc );
$row_tc = mysqli_fetch_assoc( $result_tc );

if ($row['pay_shop'] == "pay") {
    $WIDsubject = "福源泉 - 余额充值";
} else {
    $WIDsubject = "福源泉 - ".$row_tc['tl_name'];
}

$head_title = "在线支付";
include("include/head_.php");
$top_title = "在线支付";
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="swiper-container swiper3" style="margin-top: 48px;">
	<div class="swiper-wrapper">
		<div class="swiper-slide"><img src="img/tc_pf_baner.jpg" alt=""></div>
	</div>
</div>
	<div class="payment_list">
		<ul>
		<?php 
		if ($row_tc['tl_point_type'] == 1) {
		?>
			<li><span><img src="img/point_ico.png" alt="积分"></span><span>积分兑换</span>
				  <span><input name="payment_cart" type="radio" value="point" checked></span>
			</li>
		<?php 
		} else {
		?>
			<?php 
			if (strstr($HTTP_USER_AGENT, "MicroMessenger")) {
			?>
			<li><span><img src="img/weixin.png" alt="微信"></span><span>微信支付</span>
				  <span><input name="payment_cart" type="radio" value="weixin"></span>
			</li>
			<?php 
				}
			?>
			<?php 
			if (strstr($HTTP_USER_AGENT, "fuyuanquan.net")) {
			?>
			<li><span><img src="img/weixin.png" alt="微信"></span><span>微信支付</span>
				  <span><input name="payment_cart" type="radio" value="weixin_app"></span>
			</li>
			<?php 
			}
			?>
			<?php 
			if (!strstr($HTTP_USER_AGENT, "MicroMessenger")) {
			?>
			<li><span><img src="img/zhifubao.png" alt="支付宝"></span><span>支付宝支付</span>
				<span><input type="radio" name="payment_cart" value="zhifubao"></span>
			</li>
			<?php 
			}
			?>
		<?php 
		}
		?>
		</ul>
	</div>
	<div class="payment_button">
		<?php 
		if ($row_tc['tl_point_type'] == 1) {
		?>
		<form action="../pay_point/point_end.php" method="post" id="myFormId">
			<input type="hidden" name="member_phone" value="<?php echo $row['pay_member'];?>">
			<input type="hidden" name="WIDout_trade_no" value="<?php echo $row['pay_trade_no'];?>">
			<input type="hidden" name="WIDsubject" value="<?php echo $WIDsubject;?>">
			<input type="hidden" name="WIDtotal_amount" value="<?php echo $row['pay_point_commodity'];?>">
			<input type="hidden" name="WIDbody" value="">
			<input type="submit" value="确认兑换 ￥<?php echo $row['pay_point_commodity'];?>">
		</form>
		<?php 
		} else {
			if ($row_tc['tl_point_type'] == 3) {
				$WIDtotal_amount = ($row['pay_price']*$row_tc['tl_price'])/100;
			} else {
				$WIDtotal_amount = $row['pay_price'];
			}
		?>
		<form action="" method="post" id="myFormId">
			<input type="hidden" name="member_phone" value="<?php echo $row['pay_member'];?>">
			<input type="hidden" name="WIDout_trade_no" value="<?php echo $row['pay_trade_no'];?>">
			<input type="hidden" name="WIDsubject" value="<?php echo $WIDsubject;?>">
			<input type="hidden" name="WIDtotal_amount" value="<?php echo $WIDtotal_amount;?>">
			<input type="hidden" name="WIDbody" value="">
			<input type="submit" value="确认支付 ￥<?php echo Number_format($WIDtotal_amount, 2);?>">
		</form>
		<?php 
		}
		?>
	</div>
	<script type="text/javascript">
		$("[name='payment_cart']").click(function(){
			var payment_cart = $("input[name='payment_cart']:checked").val();
			if (payment_cart == "zhifubao") {
				$("#myFormId").attr("action", "../alipay/wappay/pay.php").removeAttr("onsubmit");
			}
			if (payment_cart == "weixin") {
				$("#myFormId").attr("action", "../wxpay/jsapi/wxpay.php").removeAttr("onsubmit");
			}
			if (payment_cart == "weixin_app") {
				$("#myFormId").attr("onsubmit", "return paywxapp_check()");
			}
		})
        
        function paywxapp_check(){
            YDB.SetWxpayInfo("<?php echo $WIDsubject;?>", "", "<?php echo $WIDtotal_amount;?>", "<?php echo $row['pay_trade_no'];?>", "<?php echo $row['pay_member'];?>");
            return false;
        }
	</script>
<?php 
include("include/foot_.php");
?>