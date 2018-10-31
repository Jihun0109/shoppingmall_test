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
	<li><a href="my_orderend.php" target="_self">已完成</a></li>
	<li><a href="my_orderend.php" target="_self">已完成</a></li>
    <li class="my_order_cate_on">已取消</li>
  </ul>
</div>
<div class="my_order_cate_list">
<?php 
$member_id = $member_login;
$query = "SELECT * FROM payment_list where pay_member = '{$member_id}' and pay_status = '2' ORDER BY pay_id desc limit 30";
include("include/myorder_list.php");
?>
</div>
<script type="text/javascript">
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
