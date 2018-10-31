<?php 
if (isset($_REQUEST['qid'])) {
    $qid = $_REQUEST['qid'];
} else {
    $qid = '';
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
if (isset($_REQUEST['view'])) {
    $view = $_REQUEST['view'];
} else {
    $view = '';
}
if (isset($_REQUEST['type'])) {
    $type = $_REQUEST['type'];
} else {
    $type = '';
}

if (isset($_SERVER['HTTP_USER_AGENT'])) {
    $agent_user = $_SERVER['HTTP_USER_AGENT'];
} else {
    $agent_user = '';
}

session_start();
if (!$code) {
	if ($view && $type) {
		$session_rand = $qid.$view.$type;
		$_SESSION[$session_rand]['qid'] = $qid;
		$_SESSION[$session_rand]['view'] = $view;
		$_SESSION[$session_rand]['type'] = $type;
	} else {
		$session_rand = $qid;
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

include ("include/data_base.php");
if ($openids) {
	$openid_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_openid = '{$openids}'");
	$openid_rs = mysqli_fetch_array($openid_count,MYSQLI_NUM);
	$openid_Number = $openid_rs[0];
	if ($openid_Number) {
		$return_url = $_REQUEST['return_url'];
		header("Location: $return_url");
		exit();
	}
}

if (strstr($agent_user,"MicroMessenger")){
	if (!$openids && !$code) {
		header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx95d36b67aa0c30e1&redirect_uri=http%3a%2f%2ffyq.shengtai114.com%2frecommend_reg.php&response_type=code&scope=snsapi_userinfo&state=$session_rand&from=singlemessage&isappinstalled=0#wechat_redirect");
		exit;
	}
	if ($code) {
		$state = @$_REQUEST['state'];
		if (isset($_SESSION[$state]['view'])) {
			$qid = $_SESSION[$state]['qid'];
			$view = $_SESSION[$state]['view'];
			$type = $_SESSION[$state]['type'];
		} else {
			$qid = $state;
		}
		
		$content = curl_file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx95d36b67aa0c30e1&secret=ddda7c309dc665b276238237598471e9&code='.$_REQUEST['code'].'&grant_type=authorization_code','0');
		$json = json_decode($content);
		$openid = $json->{'openid'};
		if ($view) {
			$url_code = urlencode("http://fyq.shengtai114.com/detailed_view.php?qid=$qid&view=$view&type=$type");
		} else {
			$url_code = urlencode("http://fyq.shengtai114.com/");
		}
		header("Location: http://fyq.shengtai114.com/recommend_reg.php?openid=$openid&qid=$qid&return_url=$url_code");
		exit;
	}
}
//if (!$code) {
//	if (!$qid) {
/*//		echo "<script> alert('操作有误');parent.location.href='/'; </script>";*/
//		exit();
//	}
//}

$head_title = "领取积分";
include("include/head_.php");
?>
<style type="text/css">
	.recommend_reg {
		position: relative;
		background-color: #2f2023;
		height: 100%;
	}
	.recommend_reg_bg {
		width: 100%;
	}
	.recommend_reg_bg img {
		width: 100%;
	}
	.recommend_reg_input {
		position:absolute;
		top: 50%;
		margin-top: -8%;
		width: 100%;
		text-align: center;
	}
	.recommend_reg_input input {
		width: 72%;
		height: 42px;
		margin-bottom: 10px;
		border: 0px;
		border-radius: 5px;
		text-align: left;
		padding-left: 5%;
		padding-right: 5%;
	}
	.recommend_code_phone {
		height: 42px;
		position: relative;
		width: 82%;
		left: 0px;
		right: 0px;
		margin: 0 auto;
		margin-bottom: 10px;
	}
	.recommend_reg_input [name=recommend_code] {
		position: absolute;
		top: 0px;
		left: 0px;
		width: 64%;
		border-radius: 5px 0px 0px 5px;
		margin-bottom: 0px;
		padding-left: 6%;
	}
	.recommend_reg_input .recommend_reg_gain {
		position: absolute;
		top: 0px;
		right: 0px;
		width: 36%;
		border-radius: 5px;
		background-color: #fa856b;
		color: #FFFFFF;
		margin-bottom: 0px;
		text-align: center;
		padding-left: 0px;
		padding-right: 0px;
	}
	.recommend_reg_input .recommend_reg_button {
		width: 82%;
		background-color: #f86342;
		text-align: center;
		color: #fff;
		margin-bottom: 0px;
	}
	.recommend_passus {
		color: #f23030;
		height: 50px;
		line-height: 22px;
	}
</style>
<div class="recommend_reg">
	<div class="recommend_reg_bg"><img src="../img/recommend_bg.jpg" alt="领取积分背景"></div>
	<div class="recommend_reg_input">
		<input type="number" name="recommend_phone" pattern="[0-9]*" value="" placeholder="请输入手机号码领取幸福豆">
		<div class="recommend_code_phone">
		<input type="number" name="recommend_code" value="" pattern="[0-9]*" placeholder="请输入短信验证码">
		<input style="top: 0px;" type="button" id="reg_code_send" value="发送验证码" onclick="sendphonecode('points','recommend_phone','reg_code_send')" />
		</div>
		<div class="recommend_passus">您的默认登录密码是手机尾号4位<br>登录后请及时修改密码</div>
		<input type="button" class="recommend_reg_button" value="立即领取">
	</div>
</div>
<script type="text/javascript">	
	$(".recommend_reg_button").click(function(){
		var recommend_phone = $( ".recommend_reg_input [name='recommend_phone']" ).val();
		var recommend_code = $( ".recommend_reg_input [name='recommend_code']" ).val();
		
		$.post("../post/recommend_reg.php",
		  {
			recommend_phone:recommend_phone,
			recommend_code:recommend_code,
			recommend_vid:"<?php echo $qid;?>",
			recommend_openid:"<?php echo $openids;?>"
		  },
		  function(data,status){
			if (data == "1") {
				alert("幸福豆领取成功!");
				window.location.href = "http://www.shengtai114.com/";
			}
			if (data == "2") {
				alert("您的帐号已存在!");
				window.location.href = "index.php";
			}
			if (data == "3") {
				alert("您输入的验证码不正确!");
			}
		  });
	})
</script>
<?php 
include("include/foot_.php");
?>