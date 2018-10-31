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
		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx95d36b67aa0c30e1&redirect_uri=http%3a%2f%2ffyq.shengtai114.com%2fuser_payment.php&response_type=code&scope=snsapi_userinfo&state=$trade_num&from=singlemessage&isappinstalled=0#wechat_redirect");
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
		header("Location: http://fyq.shengtai114.com/user_payment.php?openid=$openid&trade_num=$state");
		exit;
	}
}
include("include/data_base.php");
include("include/head_.php");
	$top_title = "粘糕支付";
	$return_url = "..";
	include("include/top_navigate.php");

$query_payment = "SELECT pay_price,pay_shop,pay_status FROM payment_list where pay_trade_no = '{$trade_num}' order by pay_id desc";
if ($result_payment = mysqli_query($mysqli, $query_payment))
{
    $row_payment = mysqli_fetch_assoc($result_payment);
    $item_id = $row_payment['pay_shop'];
    if ($row_payment['pay_status'] > 0) {
        echo "<script> alert('此订单号已过期');parent.location.href='http://fyq.shengtai114.com'; </script>";
        exit();
    }
}

$query_item = "SELECT tl_name,tl_price,tl_point_type,tl_original,tl_phone FROM teacher_list where tl_id = '{$item_id}'";
if ($result_item = mysqli_query($mysqli, $query_item))
{
    $row_item = mysqli_fetch_assoc($result_item);
}

if (strstr($agent_user,"MicroMessenger")){
	$query_wxmb = "SELECT mb_phone FROM fyq_member where mb_openid = '{$openids}'";
		if ($result_wxmb = mysqli_query($mysqli, $query_wxmb))
		{
			$row_wxmb = mysqli_fetch_assoc($result_wxmb);
			$mb_wxmember = $row_wxmb['mb_phone'];
		}
} else {
    if (isset($_COOKIE["member"])) {
        $mb_wxmember = $_COOKIE["member"];
    } else {
        $mb_wxmember = '';
    }
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
		height: 48px;
		margin-bottom: 20px;
		margin-top: 16px;
		text-align: center;
        color: #FF2C30;
        font-size: 2em;
        font-weight: bold;
	}
	.scan_pay_content [name=pay_phone] {
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
		<span class="scan_pay_price">
            <p>原价:￥<?php echo $Original_price;?></p>
            <p>现价:￥<?php echo $Discount;?></p>
            </span>
		<input type="number" pattern="[0-9]*" name="pay_phone" value="<?php if ($mb_wxmember) {echo $mb_wxmember;}?>" placeholder="请输入手机号码">
		<input type="button" class="scan_pay_button" onClick="scan_pay_button()" value="立即支付">
	</div>
</div>
<script type="text/javascript">
	function scan_pay_button(){ 
		var phone = $(".scan_pay_content [name='pay_phone']").val();
		if(!(/^1[34578]\d{9}$/.test(phone))){
			alert("手机号码有误，请重填");
			return false; 
		} else {
			$.post("post/payment_order.php",
			  {
				recommend_phone:phone,
				recommend_trade:"<?php echo $trade_num;?>",
				recommend_itemphone:"<?php echo $row_item['tl_phone'];?>",
				recommend_openid:"<?php echo $openids;?>"
			  },
			  function(data,status){
				if (data == "10") {
					alert("下单失败，请重试");
				} else {
					if (isMicroMessenger) {
					   window.location.href="wxpay/jsapi/wxpay.php?WIDout_trade_no="+data;
                    } else {
					   window.location.href="payment.php?tradeno="+data;
                    }
				}
			  });
		}
	}
</script>
<?php 
include("include/foot_.php");
?>