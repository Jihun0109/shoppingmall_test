<?php 
include("db_config.php");
$head_title = "我的订单";
include("include/head_.php");
$top_title = "我的订单";
$return_url = "..";

$top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
?>

<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
</div>
<div class="my_order_cate" style="margin-top: 48px;">
  <ul style="display: flex;">
    <li><a href="my_orderall.php" target="_self">全部订单</a></li>
	<li><a href="my_order.php" target="_self">待付款</a></li>
	<li><a href="my_ordership.php" target="_self">待发货</a></li>
	<li><a href="my_orderend.php" target="_self">待收货</a></li>
	<li class="my_order_cate_on">待评价</li>
  </ul>
</div>
<div class="my_order_cate_list">
<?php 
$member_id = $member_login;
$query = "SELECT * FROM payment_list where pay_member = '{$member_id}' and pay_status <> '10'";
$query .= " and pay_status = '1' and (ship_status = '3' or ship_status = '4' or pay_cate='scan') and ship_status != '-1' order by pay_id desc;";

include("include/myorder_list.php");
?>
</div>
<script type="text/javascript">
	function order_off(shop_id) {
		$.post("post/order_off.php",
		  {
			shop_id:shop_id
		  },
		  function(data,status){
			if (data == 1) {
				$("#payment_"+shop_id).fadeOut(300,function(){
					$(this).remove();
				});
			}
		  });
	}
	function order_del(shop_id) {
		$.post("post/order_del.php",
		  {
			shop_id:shop_id
		  },
		  function(data,status){
			if (data == 1) {
				$("#payment_"+shop_id).fadeOut(300,function(){
					$(this).remove();
				});
			}
		  });
	}
</script>
<?php 
include("include/foot_.php");
?>
