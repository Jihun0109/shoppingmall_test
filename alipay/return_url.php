<?php
require_once("config.php");
require_once 'wappay/service/AlipayTradeService.php';
$arr=$_GET;
$alipaySevice = new AlipayTradeService($config); 
$result = $alipaySevice->check($arr);

if($result) {
    $out_trade_no = htmlspecialchars($_GET['out_trade_no']);
    $head_title = "支付宝支付";
    $top_title = "支付宝支付";
    include("../include/head_.php");
    //include("../include/top_navigate.php");
}
else {
    echo "验证失败";
}
?>

<div class="pay_end_top">
	<img src="../img/pay_end.png" alt="支付成功">
</div>
<div class="pay_end_content">
	<img src="../img/zhifubao.png" alt="支付宝支付" class="pay_end_logo">
	<div class="pay_end_title">
		<img src="../img/pay_ok.png" alt="ICO">
		<span class="payment_ok">支付确认中...</span>
	</div>
	<div class="pay_end_txt">
        <p style="font-size: 1.2em;font-weight: bold;color: #f86342;" class="item_name"></p>
		<p class="payment_time"></p>
		<p class="payment_msg"></p>
		<p class="payment_trade_no"></p>
		<p class="payment_amount"></p>
		<P class="payment_method"></P>
	</div>
</div>
<div class="pay_end_index"></div>
<script type="text/javascript"> 
$(function () {
    var iCount = setInterval(GetBack, 1000);
    function GetBack() {
        $.get("http://fyq.shengtai114.com/post/pay_return_chek.php?out_trade_no=<?php echo $out_trade_no;?>",function(data,status){
            var json_data = JSON.parse(data);
            var item_name = json_data[0].item_name;
            var trade_no = json_data[0].trade_no;
            var amount = json_data[0].amount;
            var status = json_data[0].status;
            var complete_time = json_data[0].complete_time;
            if (status == 1) {
                $(".payment_ok").text('支付成功');
                $(".payment_msg").text('亲，您已支付成功了！');
                $(".item_name").text(item_name);
                $(".payment_time").text(complete_time);
                $(".payment_trade_no").text("订单号: "+trade_no);
                $(".payment_amount").text("支付金额: ￥ "+amount);
                $(".payment_method").text("费用类型: 支付宝");
                $(".pay_end_index").html('<a href="http://fyq.shengtai114.com/" target="_self">知道了</a>');
                //$(".pay_end_index").html('<a href="http://test.shengtai114.com/" target="_self">知道了</a>');
                clearInterval(iCount);
            } else if (data == 0) {
                
            } else {

            }
        });
    }
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("body").css("background-color","#ffffff");
});
</script>
<?php 
include("../include/foot_.php");
?>