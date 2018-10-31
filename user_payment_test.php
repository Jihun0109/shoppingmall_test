<?php 
$head_title = "粘糕支付";
if (isset($_GET['trade_num'])) {
    $trade_num = $_GET['trade_num'];
} else {
    $trade_num = '';
}
if (isset($_GET['code'])) {
   $code = $_GET['code']; 
} else {
   $code = ''; 
}
if (isset($_GET['openid'])) {
    $openids = $_GET['openid'];
} else {
    $openids = '';
}

$agent_user = $_SERVER['HTTP_USER_AGENT'];

if (!$code) {
	if (!$trade_num) {
		echo "<script> alert('请使用扫一扫打开此页面');parent.location.href='/'; </script>";
		exit();
	}
}
if (strstr($agent_user,"MicroMessenger")){
	if (!$openids && !$code) {
		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx95d36b67aa0c30e1&redirect_uri=http%3a%2f%2ftest.shengtai114.com%2fuser_payment_test.php&response_type=code&scope=snsapi_userinfo&state=$trade_num&from=singlemessage&isappinstalled=0#wechat_redirect");
		exit;
	}
	if ($code) {
        if (isset($_GET['state'])) {
            $state = $_GET['state'];
        } else {
            $state = '';
        }
		$content = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx95d36b67aa0c30e1&secret=ddda7c309dc665b276238237598471e9&code='.$_GET['code'].'&grant_type=authorization_code');
		$json = json_decode($content);
        if (isset($json->{'openid'})) {
            $openid = $json->{'openid'};
        } else {
            $openid = '';
        }
		header("Location: http://test.shengtai114.com/user_payment_test.php?openid=$openid&trade_num=$state");
		exit;
	}
}
include("include/data_base.php");
include("include/head_.php");
	$top_title = "粘糕支付";
	$return_url = "..";
	include("include/top_navigate.php");

$query_payment = "SELECT pay_price,pay_shop,pay_status FROM payment_list where pay_trade_no = '{$trade_num}' order by pay_id desc limit 1";
if ($result_payment = mysqli_query($mysqli, $query_payment))
{
    $row_payment = mysqli_fetch_assoc($result_payment);
    $item_id = $row_payment['pay_shop'];
    if ($row_payment['pay_status'] > 0) {
        echo "<script> alert('此订单号已过期');parent.location.href='http://test.shengtai114.com'; </script>";
        exit();
    }
}

$query_item = "SELECT tl_name,tl_price,tl_point_type,tl_original,tl_phone FROM teacher_list where tl_id = '{$item_id}' limit 1";
if ($result_item = mysqli_query($mysqli, $query_item))
{
    $row_item = mysqli_fetch_assoc($result_item);
}

$query_wxmb = "SELECT mb_id,mb_phone FROM fyq_member where mb_openid = '{$openids}' or mb_phone = '{$mb_wxmember}' limit 1";
if ($result_wxmb = mysqli_query($mysqli, $query_wxmb))
{
	$row_wxmb = mysqli_fetch_assoc($result_wxmb);
	if ($mb_wxmember) {
		$mb_wxmember = $row_wxmb['mb_phone'];
	} else {
		$mb_wxmember = 0;
	}
	$user_id = $row_wxmb['mb_id'];
}
?>
<style type="text/css">
	.scan_pay {
		background-color: #c9ba77;
		position: relative;
	}
	.scan_pay_bg {
		position: absolute;
		top: 0px;
		width: 100%;
	}
	.scan_pay_content {
		background-image: url(img/scan_input_bg.png);
		background-repeat: no-repeat;
		background-size: 100%;
		margin-top: 40%;
		position: absolute;
		text-align: center;
		margin-left: auto;
		margin-right: auto;
		left: 0px;
		right: 0px;
		padding-bottom: 100px;
	}
	.scan_pay_sale {
		color: #313131;
		font-size: 1.4em;
		font-weight: bold;
	}
	.scan_pay_logo {
		margin-top: -8%;
    	width: 50%;
	}
	.scan_pay_content .scan_pay_price {
		margin-bottom: 10px;
		margin-top: 10px;
		text-align: center;
		color: #FF2C30;
		font-size: 1em;
		font-weight: bold;
		float: left;
		width: 100%;
	}
	.scan_pay_content [name=pay_pass] {
		width: 86%;
		height: 48px;
		margin-bottom: 10px;
		text-align: center;
		border: 0px;
	}
	.scan_pay_title {
		
	}
	.scan_pay_title_span1 {
		font-size: 1.6em;
		width: 100%;
		display: block;
		color: #f86342;
		font-weight: bold;
	}
	.scan_pay_title_span2 {
		font-size: 1.2em;
		width: 100%;
		display: block;
		color: #434343;
	}
	.scan_pay_button {
		background-color: #f86342;
		border: 0px;
		color: #fff;
		width: 90%;
		margin-top: 10px;
	}
	.payment_goods_order {
		float: left;
		width: 100%;
	}
	.payment_goods_order ul {
		float: left;
		width: 96%;
		margin-top: 10px;
		margin-bottom: 10px;
		margin-left: 2%;
		margin-right: 2%;
	}
	.payment_goods_order li {
		float: left;
		width: 100%;
		height: 38px;
		line-height: 38px;
		background-color: #fff;
		font-size: 0.8em;
	}
	.payment_goods_order li span {
		float: left;
		width: 25%;
		text-align: center;
	}
	.payment_goods_order
</style>
<div class="scan_pay">
	<img class="scan_pay_bg" src="img/scan_pay_bg.jpg" alt="扫码支付背景">
	<div class="scan_pay_content">
		<img src="img/wechatpay.png" alt="微信支付" class="scan_pay_logo" >
		<div class="scan_pay_title">
			<span class="scan_pay_title_span1"><?php echo $row_item['tl_name'];?></span>
		</div>
        <?php 
        if ($row_item['tl_point_type'] == '3') {
            $pay_price = $row_payment['pay_price'];
            $tl_price = $row_item['tl_price'];
            $Discount = round(($pay_price*$tl_price)/100,2);
            $Original_price = $row_payment['pay_price'];
        } else {
            $Discount = round($row_item['tl_price'],2);
            $Original_price = $row_item['tl_original'];
        }
        ?>
       <?php 
		$all_point = 0;
		$all_price = 0;
		$discount_point = 0;
		$all_realpay = 0;
		$query_goods_order = "SELECT goods_list.goods_name, goods_order.* FROM goods_list LEFT JOIN goods_order ON goods_list.id=goods_order.goods_id where goods_tradeno = '{$trade_num}' ORDER BY goods_list.id";
				if ($result_goods_order = mysqli_query($mysqli, $query_goods_order))
				{
					$rows_goods_order = mysqli_num_rows($result_goods_order);
					if ($rows_goods_order) {
		?>
       <div class="payment_goods_order">
		   <ul>
		   <li>
		   	<span>商品名</span>
		   	<span>积分</span>
		   	<span>原价/应付</span>
		   	<span>数量/优惠</span>
		   </li>
		   <?php 
			$query_card = "SELECT surplus_num FROM vip_card where user_phone = '{$mb_wxmember}' limit 1";
			if ($result_card = mysqli_query($mysqli, $query_card))
			{
				$rows_card = mysqli_num_rows($result_card);
				if ($rows_card) {
					$row_card = mysqli_fetch_assoc($result_card);
					$surplus_num = $row_card['surplus_num'];
				} else {
					$surplus_num = 0;
				}
			}
			?>
			<?php 
			   
						
						$all_surplus = $surplus_num;
						for ($i=0;$row_goods_order = mysqli_fetch_assoc($result_goods_order);$i++) {
							$goods_name = $row_goods_order['goods_name'];
							$point = $row_goods_order['point'];
							$price = $row_goods_order['price'];
							$quantity = $row_goods_order['quantity'];
							$all_point = $all_point+$point*$quantity;
							$all_price = $all_price+$price*$quantity;
							$discount = 0;
							for ($qi=0;$qi<$quantity;$qi++) {
								if ($all_surplus>=$point) {
									$discount = $discount+1;
									$all_surplus = $all_surplus-$point;
									$discount_point = $discount_point+$point;
								}
							}
							$all_realpay = $all_realpay+($quantity-$discount)*$price;
				?>
					<li>
						<span><?php echo $goods_name;?></span>
						<span><?php echo $point;?>P</span>
						<span><?php echo $price;?>/<?php echo ($quantity-$discount)*$price;?>￥</span>
						<span><?php echo $quantity;?>/<?php echo $discount;?>个</span>
					</li>
				<?php 
						}
					
			  ?>
			</ul>
       </div>
		<?php 
		}
				}
		?>
		<span class="scan_pay_price">
           <?php if ($mb_wxmember) {?><p>当前账号<?php echo $mb_wxmember;?></p><?php }?>
           <?php if (isset($surplus_num)){?><p>当前剩余积分 <?php echo $surplus_num;?></p><?php }?>
           <?php if (isset($discount_point)){?><p>本次消费积分 <?php echo $discount_point;?></p><?php }?>
           <?php if (isset($all_realpay)){?><p>本次消费金额 <?php echo $all_realpay;?></p><?php }?>
            <p>原价:￥<?php echo $Original_price;?></p>
            <p>现价:￥<?php echo $Discount;?></p>
            <p>需支付 <?php echo $Discount+$all_realpay;?></p>
      </span>
		<?php if ($mb_wxmember) {?>
		<input type="number" pattern="[0-9]*" name="pay_pass" value="" placeholder="请输入支付密码">
		<?php }?>
		<input type="button" class="scan_pay_button" onClick="scan_pay_button()" value="立即支付">
		
	</div>
</div>
<script type="text/javascript">
	function scan_pay_button(){
		var password = $("[name=pay_pass]").val();
		$.post("post/payment_order_test.php",
		  {
			pay_code: password,
			user_id:'<?php echo $user_id;?>',
			other:'<?php echo $all_realpay;?>',
			recommend_phone:'<?php echo $mb_wxmember;?>',
			recommend_trade:"<?php echo $trade_num;?>",
			recommend_itemphone:"<?php echo $row_item['tl_phone'];?>",
			recommend_openid:"<?php echo $openids;?>"
		  },
		  function(data,status){
			if (data == "10") {
				alert("下单失败，请重试");
			} else if (data == '8') {
				alert("您输入的支付密码有误");
			} else {
				if (isMicroMessenger) {
				   window.location.href="wxpay/jsapi/wxpay_test.php?WIDout_trade_no="+data+"&wxopenid=<?php echo $openids;?>";
				} else {
				   window.location.href="payment.php?tradeno="+data;
				}
			}
		  });
	}
</script>
<?php 
include("include/foot_.php");
?>