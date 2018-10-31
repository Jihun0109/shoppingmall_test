<?php
include( "../../db_config.php" );
include( "../admin_login.php" );

$pay_phone = $_POST[ "pay_phone" ];
$bank_way = $_POST[ "bank_way" ];

$query = "SELECT * FROM fyq_member where mb_phone = '{$pay_phone}'";
if ( $result = mysqli_query( $mysqli, $query ) ) {
	$row = mysqli_fetch_assoc( $result );
}
?>
<div class="withdraw_pay_open">
	<div>
	<?php 
		$mb_alipay_receipt = $row['mb_alipay_receipt'];
		$mb_wechat_receipt = $row['mb_wechat_receipt'];
		if ($bank_way == "wechat") {
			echo "<img src=\"$mb_wechat_receipt\" alt=\"\">";
		}
		if ($bank_way == "alipay") {
			echo "<img src=\"$mb_alipay_receipt\" alt=\"\">";
		}
	?>
		<?php 
		if ($bank_way == "bank") {
		?>
		<p style="padding-top: 100px;">开户行：<?php echo $row['mb_open_bank'];?></p>
		<p>卡号： <?php echo $row['mb_bankcardnumber'];?></p>
		<?php 
		}
		?>
		<span onClick="bank_pay_off()">关闭</span>
	</div>
</div>