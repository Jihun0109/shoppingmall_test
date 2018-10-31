<?php 
include("db_config.php");
if (!$member_login) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$head_title = "余额充值";
include("include/head_.php");
$top_title = "余额充值";
$return_url = "..";
include("include/top_navigate.php");
?>
	<div class="charge_content">
		<div class="charge_allgold">
			<font color="#959595">当前金额：</font>
			<font color="#f86342"><?php echo Number_format($row_member['mb_not_gold'],2);?></font>
		</div>
		<div class="charge_overgold"><input type="number" name="charge_overage" value="" placeholder="请输入充值金额"></div>
		<div class="charge_button"><input type="button" id="charge_button" value="确认"></div>
	</div>
<script type="text/javascript">
$("#charge_button").click(function(){
	var charge_overage = $( "[name='charge_overage']" ).val();
	if (charge_overage<1) {
        alert("充值余额不能效果1元");
        return false;
    }
	$.post( "post/payment_.php", {
		sid: "pay",
		sclass: "charge",
		smember: "<?php echo $member_login;?>",
		squantity: 1,
		sprice: charge_overage
	},
	function ( data, status ) {
		if ( data ) {
			location.href = "payment.php?tradeno=" + data;
		}
	} );
})	
</script>
<?php 
include("include/foot_.php");
?>