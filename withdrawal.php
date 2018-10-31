<?php 
include("include/data_base.php");
include("include/member_db.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
if (!$member_login) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$member = member_db($_COOKIE["member"],"mb_not_gold,mb_commission_not_gold,mb_partner_not_gold,mb_point","include/data_base.php");
$member = json_decode($member, true);
$top_title = "余额提现";
$head_title = "余额提现";
include("include/head_.php");
include("include/top_navigate.php");
?>
<style type="text/css">
    .withdrawal {
        margin-top: 48px;
        background-color: #FFFFFF;
        width: 100%;
        float: left;
        padding-bottom: 42px;
    }
    .withdrawal_bank {
        float: left;
        width: 100%;
        background-color: #fff;
        margin-top: 10px;
        text-align: center;
    }
    .withdrawal_bank select {
        width: 94%;
        height: 52px;
        padding-left: 5%;
        padding-right: 5%;
        font-size: 1em;
        background-color: #ffffff;
        color: #607D8B;
        border: 1px solid #e3e3e3;
    }
    .withdrawal_cash {
        float: left;
        width: 96%;
        background-color: #fff;
        margin-left: 2%;
        margin-right: 2%;
        margin-bottom: 16px;
        margin-top: 16px;
    }
    .withdrawal_cash span {
        display: block;
        float: left;
        width: 30%;
        height: 46px;
        text-align: center;
        margin-left: 1.33%;
        margin-right: 1.33%;
        border: 1px solid #ddd;
        padding-bottom: 3px;
        padding-top: 3px;
        color: #607D8B;
    }
    .withdrawal_cash p {
        height: 24px;
    }
    .withdrawal_cash i {
        height: 24px;
        display: block;
        font-size: 0.8em;
    }
    .withdrawal_cash .oncash {
        background-color: #FF5722;
        color: #fff;
    }
    .withdrawal_balance {
        float: left;
        width: 100%;
        margin-bottom: 10px;
        text-align: center;
    }
    .withdrawal_balance input {
        width: 90%;
        color: #607D8B;
    }
    .withdrawal_confirm {
        float: left;
        width: 100%;
        text-align: center;
        margin-top: 10px;
    }
    .withdrawal_confirm input {
        width: 94%;
        background-color: #FF5722;
        color: #ffffff;
        border: 0px;
    }
    .withdrawal_service {
        float: left;
        width: 94%;
        padding-left: 3%;
        padding-right: 3%;
        height: 30px;
        line-height: 30px;
        color: #607D8B; 
    }
    .withdrawal_service i {
        margin-left: 5px;
    }
    .withdrawal_service span {
        margin-left: 20px;
    }
    .withdrawal_service_point {
        float: left;
        width: 94%;
        height: 30px;
        line-height: 30px;
        padding-left: 3%;
        padding-right: 3%;
        color: #607D8B;
    }
    .withdrawal_service_point input {
        width: 20px;
        height: 20px;
        vertical-align: middle;
        margin-right: 10px;
    }
    .withdrawal_service_point i {
        margin-left: 5px;
    }
    .withdrawal_record {
        float: left;
        width: 94%;
        padding-left: 3%;
        padding-right: 3%;
        background-color: #fff;
        margin-top: 3px;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    .withdrawal_record>div {
        height: 42px;
        line-height: 42px;
        font-size: 1.2em;
        font-weight: bold;
        color: #607D8B;
    }
    .withdrawal_record li {
        line-height: 32px;
        float: left;
        width: 96%;
        padding-left: 2%;
        padding-right: 2%;
        color: #ffffff;
        background-color: #607D8B;
        border-radius: 0px;
        margin-bottom: 0px;
        border-bottom: 3px solid #678694;
        padding-top: 5px;
        padding-bottom: 5px;
    }
    .withdrawal_record li:nth-child(1) {
        border-radius: 3px 3px 0px 0px;
    }
    .withdrawal_record li:nth-last-child(1) {
        border-radius: 0px 0px 3px 3px;
    }
    .withdrawal_record .left{
        width: 50%;
        float: left;
        text-align: left;
        line-height: 32px;
        height: 32px;
    }
    .withdrawal_record .left b {
        margin-right: 10px;
    }
    .withdrawal_record .right {
        float: right;
        width: 50%;
        text-align: right;
        line-height: 32px;
        height: 32px;
    }
    .withdrawal_record .service_left {
        width: 50%;
        float: left;
        text-align: left;
        line-height: 26px;
        height: 26px;
        font-size: 0.8em;
    }
    .withdrawal_record .service_right {
        float: right;
        width: 50%;
        text-align: right;
        line-height: 26px;
        height: 26px;
        font-size: 0.8em;
    }
    .withdrawal_record p {
        float: left;
        width: 100%;
        font-size: 0.8em;
        height: 26px;
        line-height: 22px;
    }
</style>
<div class="withdrawal">
    <div class="withdrawal_bank">
        <select name="withdrawal_bank_list">
            <option value="bank">收款方式 - 银行卡</option>
            <option value="wechat">收款方式 - 微信</option>
            <option value="alipay">收款方式 - 支付宝</option>
        </select>
    </div>
    <div class="withdrawal_cash">
        <span class="oncash">
            <p>余额</p><i style="margin-top:-15px;"><?php echo Number_format($member['mb_not_gold'],2);?></i>
        </span>
        <span>
            <p>佣金</p><i style="margin-top:-15px;"><?php echo Number_format($member['mb_commission_not_gold'],2);?></i>
        </span>
        <span>
            <p>分红</p><i style="margin-top:-15px;"><?php echo Number_format($member['mb_partner_not_gold'],2);?></i>
        </span>
    </div>
    <div class="withdrawal_balance"><input type="number" name="withdrawal_price" value="" placeholder="请输入提现金额"></div>
    <div class="withdrawal_service">提现手续费<i>0.00 元</i></div>
    <div class="withdrawal_service">可用幸福豆 <b><?php echo $member['mb_point'];?></b></div>
    <div class="withdrawal_service_point"><input type="checkbox" name="withdrawal_point">幸福豆代替手续费<i>0</i></div>
    <div class="withdrawal_confirm"><input type="button" id="withdrawal_button" value="提现"></div>
</div>
<?php 
$query_withdrawal = "SELECT * FROM withdrawal_list where w_phone = '{$member_login}' order by w_id desc limit 100";
	if ($result_withdrawal = mysqli_query($mysqli, $query_withdrawal))
	{
        $withdrawal_rows = mysqli_num_rows($result_withdrawal);
        if ($withdrawal_rows) {
?>
<div class="withdrawal_record">
    <div>提现记录</div>
    <ul>
        <?php 
        while($row_withdrawal = mysqli_fetch_assoc($result_withdrawal)){
            if ($row_withdrawal['w_price_cate'] == '1') {
                $price_cate = '余额';
            }
            if ($row_withdrawal['w_price_cate'] == '2') {
                $price_cate = '佣金';
            }
            if ($row_withdrawal['w_price_cate'] == '3') {
                $price_cate = '分红';
            }
        ?>
        <li>
            <span class="left"><b><?php echo $price_cate;?></b><?php echo $row_withdrawal['w_price'];?> 元</span>
            <span class="right"><?php echo $row_withdrawal['w_time'];?></span>
            <span class="service_left">手续费: <?php if ($row_withdrawal['w_point']) {echo ' 幸福豆 '.$row_withdrawal['w_point']." 个";} else {echo $row_withdrawal['w_service'].'元';}?></span>
            <span class="service_right"><?php if ($row_withdrawal['w_state']) {echo '已处理';} else {echo '等待处理';}?></span>
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
<script type="text/javascript">
    $(document).ready(function(){
        $(".withdrawal_cash span").click(function(){
            $(".withdrawal_cash span").removeAttr("class");
            $(this).addClass("oncash");
        })
        
        $("#withdrawal_button").click(function(){
            $(this).val('处理中请稍后');
            var bank_list = $("[name='withdrawal_bank_list']").val();
            var withdrawal_cash = ($(".withdrawal_cash .oncash").index()+1);
            var withdrawal_price = $("[name='withdrawal_price']").val();
            var withdrawal_point = $("[name='withdrawal_point']").is(':checked');
            if (!withdrawal_price) {
                withdrawal_price = 0;
            }
            if (withdrawal_point) {
                withdrawal_point = 1;
            } else {
                withdrawal_point = 0;
            }
            $.post("post/withdrawal_ajax.php",
            {
                bank_list:bank_list,
                withdrawal_cash:withdrawal_cash,
                withdrawal_price:withdrawal_price,
                withdrawal_point:withdrawal_point
            },
            function(data,status){
                $("#withdrawal_button").val('提交');
                if (data=='12') {
                    alert('佣金分红每月10号可提现');
                }
                if (data=='11') {
                    alert('您提交的频率太短\n请休息一会再试');
                }
                if (data=='10') {
                    alert('提现金额不能小于 100 元');
                }
                if (data=='9') {
                    alert('您输入的余额有误');
                }
                if (data=='8') {
                    alert('您当前幸福豆不够使用');
                }
                if (data=='7') {
                    alert('您的余额小于100元, 无法提现');
                }
                if (data=='6') {
                    alert('您的佣金小于100元, 无法提现');
                }
                if (data=='5') {
                    alert('您的股东余额小于100元, 无法提现');
                }
                if (data=='4') {
                    like=window.confirm("您的收款信息不完善\n点击确认跳转到收款信息");
                    if(like==true) {
                        window.location.href = "../member_bank.php";
                    }
                }
				if (data=='3') {
                    alert('您的申请已提交');
                }
                if (data=='1') {
                    alert('提现申请成功');
                    window.location.href = "../withdrawal.php";
                }
            });
        })
        
        $(".withdrawal_service_point input, .withdrawal_cash span").click(function(){
            var withdrawal_cash = ($(".withdrawal_cash .oncash").index()+1);
            var service = ($(".withdrawal_balance [name='withdrawal_price']").val()*0.06).toFixed(2);
            var all_point = parseInt($(".withdrawal_service span b").text());
            var withdrawal_point = $("[name='withdrawal_point']").is(':checked');
            if (withdrawal_cash==1) {
                $(".withdrawal_service_point i").text(0);
                $(".withdrawal_service i").text('0.00 元');
            } else {
                if (withdrawal_point) {
                    $(".withdrawal_service_point i").text(service*100);
                    $(".withdrawal_service i").text('0.00 元');
                } else {
                    $(".withdrawal_service_point i").text(0);
                    $(".withdrawal_service i").text(service+' 元');
                }
            }
        })
        
        $(".withdrawal_balance [name='withdrawal_price']").keyup(function () {
            var withdrawal_cash = ($(".withdrawal_cash .oncash").index()+1);
            if (withdrawal_cash !== 1) {
                var reg = $(this).val().match(/\d+\.?\d{0,2}/);
                var txt = '';
                if (reg != null) {
                    txt = reg[0];
                }
                $(this).val(txt);
                var service = ($(this).val()*0.06).toFixed(2);
                var withdrawal_point = $("[name='withdrawal_point']").is(':checked');
                if (withdrawal_point) {
                    $(".withdrawal_service_point i").text(service*100);
                    $(".withdrawal_service i").text('0.00 元');
                } else {
                    $(".withdrawal_service_point i").text(0);
                    $(".withdrawal_service i").text(service+' 元');
                }
            }
        }).change(function () {
            $(this).keypress();
            var v = $(this).val();
            if (/\.$/.test(v))
            {
                $(this).val(v.substr(0, v.length - 1));
            }
        });
    });
</script>
<?php 
include("include/foot_.php");
?>