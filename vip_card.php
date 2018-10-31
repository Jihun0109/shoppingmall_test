<?php 
$head_title = "VIP会员卡";
if (isset($_REQUEST['bid'])) {
    $id = $_REQUEST['bid'];
} else {
    $id = '';
}
if (isset($_REQUEST['code'])) {
   $code = $_REQUEST['code']; 
} else {
   $code = ''; 
}
if (isset($_REQUEST['openid'])) {
    $openids = $_REQUEST['openid'];
} else {
    $openids = '';
}

$agent_user = $_SERVER['HTTP_USER_AGENT'];

if (!$code) {
	if (!$id) {
		echo "<script> alert('请使用扫一扫打开此页面');parent.location.href='/'; </script>";
		exit();
	}
}
if (strstr($agent_user,"MicroMessenger")){
	if (!$openids && !$code) {
		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx95d36b67aa0c30e1&redirect_uri=http%3a%2f%2ffyq.shengtai114.com%2fvip_card.php&response_type=code&scope=snsapi_userinfo&state=$id&from=singlemessage&isappinstalled=0#wechat_redirect");
		exit;
	}
	if ($code) {
        if (isset($_REQUEST['state'])) {
            $state = $_REQUEST['state'];
        } else {
            $state = '';
        }
		$content = curl_file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx95d36b67aa0c30e1&secret=ddda7c309dc665b276238237598471e9&code='.$_REQUEST['code'].'&grant_type=authorization_code','0');
		$json = json_decode($content);
        if (isset($json->{'openid'})) {
            $openid = $json->{'openid'};
        } else {
            $openid = '';
        }
		header("Location: http://fyq.shengtai114.com/vip_card.php?openid=$openid&bid=$state");
		exit;
	}
}

function curl_file_get_contents($durl,$n='0')
{
	if($n == '14' || $n == '22' || $n == "3")
	{
		$r = file_get_contents($durl);	
	}
	else
	{
		//$user_agent = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/4 (iPhone; U; CPU iPhone OS 4_2_1 like Mac OS X; zh-cn) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8C148 Safari/6533.18.5"; 
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $durl);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);		
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,2);		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
	}
	//echo $output."<br>";
	//exit;
	return $output;
}

include("include/data_base.php");
include("include/head_.php");
	$top_title = "VIP会员卡";
	$return_url = "..";
	include("include/top_navigate.php");

$query = "SELECT * FROM teacher_list where tl_id = '{$id}'";
	if ($result = mysqli_query($mysqli, $query))
	{
		$row = mysqli_fetch_assoc($result);
	}
if (isset($_COOKIE["qid"])) {
    $mb_qid = $_COOKIE["qid"];
    $query_qid = "SELECT mb_phone FROM fyq_member where mb_id = '{$mb_qid}'";
    if ($result_qid = mysqli_query($mysqli, $query_qid))
    {
        $row_qid = mysqli_fetch_assoc($result_qid);
        $recommend_vphone = $row_qid['mb_phone'];
    }
} else {
    $recommend_vphone = $row['tl_phone'];
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
	.scan_pay_content [name=pay_price] {
		width: 86%;
		height: 48px;
		margin-bottom: 10px;
		margin-top: 10px;
		text-align: center;
		border: 0px;
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
			<span class="scan_pay_title_span1"><?php echo $row['tl_name'];?></span>
			<span class="scan_pay_title_span2"><?php echo $row['tc_province1'];?> <?php echo $row['tc_city1'];?> <?php echo $row['tl_district1'];?></span>
		</div>
		<input type="number" step="0.01" name="pay_price" value="<?php echo $row['tl_price'];?>" disabled>
		<input type="number" pattern="[0-9]*" name="pay_phone" value="<?php if ($mb_wxmember) {echo $mb_wxmember;}?>" placeholder="请输入手机号码">
		<input type="button" class="scan_pay_button" onClick="scan_pay_button()" value="立即支付">
	</div>
</div>
<script type="text/javascript">
	function scan_pay_button(){ 
		var price = $(".scan_pay_content [name='pay_price']").val();
		var phone = $(".scan_pay_content [name='pay_phone']").val();
        if (price < 1) {
            alert("支付余额不能小于1元");
            return false;
        }
		if(!(/^1[34578]\d{9}$/.test(phone))){
			alert("手机号码有误，请重填");
			return false; 
		} else {
			$.post("post/vip_reg.php",
			  {
				recommend_phone:phone,
				recommend_vid:"<?php echo $row['tl_id'];?>",
				recommend_vphone:"<?php echo $recommend_vphone;?>",
				recommend_price:price,
				recommend_openid:"<?php echo $openids;?>",
				shipping_address: "<?php echo $_GET['shipping_address'] ?>",
			  },
			  function(data,status){
				if (data == "10") {
					alert("下单失败，请重试");
				} else if (data == "20") {
                    alert("此商品购买次数已超越了");
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