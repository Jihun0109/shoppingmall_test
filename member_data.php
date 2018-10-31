<?php
include("include/data_base.php");
include("include/member_db.php");
include("include/member_level.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
    $member_data = member_db($member_login,"mb_level,mb_not_gold,mb_commission_not_gold,mb_partner_not_gold","include/data_base.php");
    $member_data = json_decode($member_data, true);
} else {
    $member_login = '';
}

if (!$member_login) {
    echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>";
    exit;
}
$head_title = "我的数据";
$top_title = "我的数据";
include("include/head_.php");
include("include/top_navigate.php");
?>
<style type="text/css">
    .member_all_price {
        width: 92%;
        padding: 4%;
        float: left;
        border-bottom: 1px solid #eaeaea;
        background-color: #FFFFFF;
        margin-top: 48px;
    }
    .member_all_price div {
        color: #666;
    }
    .member_all_price li {
        font-size: 1.4em;
        letter-spacing:1px;
        float: left;
        width: 100%;
    }
    .member_all_price li span {
        font-size: 0.6em;
        width: 33.33%;
        float: left;
        color: #35515f;
        height: 30px;
        line-height: 30px;
    }
    .member_all_price li i {
        margin-left: 5px;
    }
    .member_data {
        margin-bottom: 3px;
        background-color: #fff;
        padding: 4%;
        color: rgba(0,0,0,.6);
        font-size: 0.9em;
        width: 92%;
        float: left;
    }
    .left_point_data {
        width: 42%;
        float: left;
    }
    .member_data>div {
        height: 42px;
        line-height: 42px;
        font-size: 1.2em;
        color: #000000;
    }
    .member_data ul {
        padding: 0px;
    }
    .member_data li {
        height: 48px;
        line-height: 48px;
        border-bottom: 1px solid #eaeaea;
        padding-left: 20px;
        padding-right: 20px;
    }
    .left_point_data li {
        padding-left: inherit;
        padding-right: inherit;
        line-height: 24px;
        padding-top: 12px;
        padding-bottom: 10px;
    }
    .member_data li:last-child {
        border-bottom: 0px;
    }
    .member_data span {
        float: left;
    }
    .member_data span i {
        font-size: 0.8em;
        margin-left: 3px;
    }
    .member_data span p {
        height: 23.5px;
        font-size: 0.8em;
    }
    .member_data span p:nth-child(1) {
        line-height: 30px;
    }
    .member_data span p:nth-child(2) {
        line-height: 15px;
    }
    .member_data span:nth-child(1) {
        width: 60%;
        text-align: left;
        overflow: hidden;
        text-overflow:ellipsis;
        white-space: nowrap;
    }
    .left_point_data span:nth-child(1) {
        width: 100%;
    }
    .member_data span:nth-child(2) {
        width: 40%;
        text-align: right;
    }
    .left_point_data span:nth-child(2) {
        width: 100%;
        text-align: left;
    }
    #item_payment_more {
        text-align: center;
    }
</style>
<div class="member_all_price">
    <div>总资产(元)</div>
    <ul>
        <li><?php echo Number_format(($member_data['mb_not_gold']+$member_data['mb_commission_not_gold']+$member_data['mb_partner_not_gold']),2)?></li>
        <li>
            <span>余额<i><?php echo Number_format($member_data['mb_not_gold'],2);?></i></span>
            <span>佣金<i><?php echo Number_format($member_data['mb_commission_not_gold'],2);?></i></span>
            <span>股东<i><?php echo Number_format($member_data['mb_partner_not_gold'],2);?></i></span>
        </li>
    </ul>
</div>
<div class="member_data left_point_data">
    <?php 
    $today_time = date('Ymd',time());
    $query_vital_today = "SELECT * FROM vital_day_member_plus where d_phone = '{$member_login}' and d_time = '{$today_time}'";
    if ($result_vital_today = mysqli_query($mysqli, $query_vital_today))
    {
        $row_vital_today = mysqli_fetch_assoc($result_vital_today);
    }
    
    $query_recommend_today = "SELECT mre_id,mre_level FROM member_recommend where mre_phone = '{$member_login}' and mre_time = '{$today_time}'";
    if ($result_recommend_today = mysqli_query($mysqli, $query_recommend_today))
    {
        $recommend_level_all = mysqli_num_rows($result_recommend_today);
        $recommend_level1 = 0;
        $recommend_level2 = 0;
        for($level=0;$row_recommend_today = mysqli_fetch_assoc($result_recommend_today);$level++){
            if ($row_recommend_today['mre_level'] == 1) {
                $recommend_level1 = $recommend_level1+1;
            }
            if ($row_recommend_today['mre_level'] == 2) {
                $recommend_level2 = $recommend_level2+1;
            }
        }
    }
    ?>
    <div>今天收入</div>
    <ul>
        <li>
            <span>余额</span>
            <span><?php echo Number_format($row_vital_today['d_total_gold'],2);?><i>元</i></span>
        </li>
        <li>
            <span>佣金</span>
            <span><?php echo Number_format($row_vital_today['d_commission_all'],2);?><i>元</i></span>
        </li>
        <?php 
        if ($member_data['mb_level']==20) {
        ?>
        <li>
            <span>股东</span>
            <span><?php echo Number_format($row_vital_today['d_partner_all_gold'],2);?><i>元</i></span>
        </li>
        <?php 
        }
        ?>
        <li>
            <span>一级会员</span>
            <span><?php echo $recommend_level1;?><i>名</i></span>
        </li>
        <li>
            <span>二级会员</span>
            <span><?php echo $recommend_level2;?><i>名</i></span>
        </li>
    </ul>
</div>
<div class="member_data left_point_data">
    <?php 
    $yesterday_time = date('Ymd',strtotime("-1 day"));
    $query_vital_yesterday = "SELECT * FROM vital_day_member_plus where d_phone = '{$member_login}' and d_time = '{$yesterday_time}'";
    if ($result_vital_yesterday = mysqli_query($mysqli, $query_vital_yesterday))
    {
        $row_vital_yesterday = mysqli_fetch_assoc($result_vital_yesterday);
    }
    
    $query_recommend_yesterday = "SELECT mre_id,mre_level FROM member_recommend where mre_phone = '{$member_login}' and mre_time = '{$yesterday_time}'";
    if ($result_recommend_yesterday = mysqli_query($mysqli, $query_recommend_yesterday))
    {
        $recommend_level_all = mysqli_num_rows($result_recommend_yesterday);
        $recommend_level1 = 0;
        $recommend_level2 = 0;
        for($level=0;$row_recommend_yesterday = mysqli_fetch_assoc($result_recommend_yesterday);$level++){
            if ($row_recommend_yesterday['mre_level'] == 1) {
                $recommend_level1 = $recommend_level1+1;
            }
            if ($row_recommend_yesterday['mre_level'] == 2) {
                $recommend_level2 = $recommend_level2+1;
            }
        }
    }
    ?>
    <div>昨日收入</div>
    <ul>
        <li>
            <span>余额</span>
            <span><?php echo Number_format($row_vital_yesterday['d_total_gold'],2);?><i>元</i></span>
        </li>
        <li>
            <span>佣金</span>
            <span><?php echo Number_format($row_vital_yesterday['d_commission_all'],2);?><i>元</i></span>
        </li>
        <?php 
        if ($member_data['mb_level']==20) {
        ?>
        <li>
            <span>股东</span>
            <span><?php echo Number_format($row_vital_yesterday['d_partner_all_gold'],2);?><i>元</i></span>
        </li>
        <?php 
        }
        ?>
        <li>
            <span>一级会员</span>
            <span><?php echo $recommend_level1;?><i>名</i></span>
        </li>
        <li>
            <span>二级会员</span>
            <span><?php echo $recommend_level2;?><i>名</i></span>
        </li>
    </ul>
</div>
<?php 
if ($member_data['mb_level']==18) {
?>
<div class="member_data" style="margin-top: 0px;">
    <div>商户最近订单</div>
    <ul id="item_payment_list">
        
    </ul>
    <div id="item_payment_more" onClick="item_payment_more('0')">加载更多</div>
</div>
<script type="text/javascript">
item_payment_more(0);
function item_payment_more(pament_page) {
    $("#item_payment_more").html("<div class=\"loader_ajax\"></div>").css("display","block");
    $.post("post/item_payment.php",
      {
        page:pament_page
      },
      function(data,status){
        if (data == 0) {
            $("#item_payment_more").html("已全部加载完毕").removeAttr("onClick");
        } else {
            var json_data = JSON.parse(data);
            $.each(json_data, function(idx, obj) {
                if (obj.user) {
                    $("#item_payment_list").append("<li style=\"padding-left: 10px; padding-right: 10px; padding-top: 8px; padding-bottom: 5px;\"><span style=\"width: 70%;\"><p style=\"font-size: 1em; line-height: 25px;\">尾号 "+obj.user+"用户 已支付<font color=\"#FF797B\">"+obj.price+"</font>元</p><p style=\"line-height: 18px;\">"+obj.item_name+"</p></span><span style=\"width: 30%;\"><p style=\"font-size: 1em; line-height: 25px;\">"+obj.time1+"</p><p style=\"line-height: 18px;\">"+obj.time2+"</p></span></li>");
                }
                if (obj.page) {
                    if (obj.page == '1') {
                        $("#item_payment_more").html("已全部加载完毕").removeAttr("onClick");
                    } else {
                        $("#item_payment_more").html("加载更多").attr("onClick","item_payment_more('"+obj.page+"')");
                    }
                }
            });
        }
      });
}
</script>
<?php 
}
?>
<?php
include( "include/foot_.php" );
?>