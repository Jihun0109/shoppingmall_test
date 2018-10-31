<?php
include("include/data_base.php");
$head_title = "订单详情";
$top_title = "订单详情";
include( "include/head_.php" );
include( "include/top_navigate.php" );
?>
<style type="text/css">
    .order_details {
        margin-top: 48px;
        color: #8C8C8C;
        font-size: 1.2em;
    }
    .order_details ul {
        float: left;
        background-color: #FFFFFF;
        padding-bottom: 16px;
        padding-top: 16px;
    }
    .order_details li {
        padding-left: 2%;
        padding-right: 2%;
        float: left;
        width: 96%;
        height: 46px;
        line-height: 46px;
    }
    .order_details span:nth-child(1) {
        float: left;
    }
    .order_details span:nth-child(2) {
        float: right;
    }
    .order_details_gold {
        font-size: 1.4em;
        font-weight: bold;
        color: #000000;
    }
    .order_details_gold i {
        font-size: 0.6em;
        color: #9E9E9E;
    }
    .order_details_all a {
        display: block;
        height: 46px;
        line-height: 46px;
        color: #8C8C8C;
        font-size: 1.2em;
        text-align: center;
    }
    .orderitem_list ul {
        float: left;
        width: 100%;
        margin-top: 48px;
        padding-top: 20px;
        background-color: #fff;
    }
    .orderitem_list li {
        float: left;
        width: 96%;
        background-color: #fff;
        height: 56px;
        padding-left: 2%;
        padding-right: 2%;
        border-bottom: 1px solid #eaeaea;
        margin-bottom: 10px;
    }
    .orderitem_list p {
        padding: 0px;
        margin: 0px;
        width: 100%;
        font-size: 1em;
    }
    .orderitem_list p:nth-child(1) {
        font-size: 1.2em;
    }
    .orderitem_list p:nth-child(2) {
        font-size: 0.8em;
    }
    .orderitem_list a {
        color: #4e6773;
    }
</style>
<?php 
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = '';
}
if (isset($_GET['list'])) {
    $list = $_GET['list'];
} else {
    $list = '';
}

if (!$list && $id) {
$query = "SELECT * FROM payment_list where pay_id = '{$id}'";
if ($result = mysqli_query($mysqli, $query))
{
	$row = mysqli_fetch_assoc($result);
    $pay_shop = $row['pay_shop'];
}

$query_item = "SELECT tl_name FROM teacher_list where tl_id = '{$pay_shop}'";
if ($result_item = mysqli_query($mysqli, $query_item))
{
	$row_item = mysqli_fetch_assoc($result_item);
}
?>
<div class="order_details">
    <ul>
        <li><span>付款金额</span><span class="order_details_gold">￥<?php echo $row['pay_price'];?><i>(￥<?php echo $row['pay_real'];?>)</i></span></li>
        <li><span>当前状态</span><span><?php if ($row['pay_status'] == 1) {echo "已支付";} else {echo "未完成";}?></span></li>
        <li><span>收款方</span><span><?php echo $row_item['tl_name'];?></span></li>
        <li><span>付款方</span><span><?php echo substr_replace($row['pay_member'],'****',3,4)?></span></li>
        <li><span>支付时间</span><span><?php echo $row['pay_time'];?></span></li>
        <li><span>支付方式</span><span><?php if ($row['payment_method'] == "wechat") {echo "微信支付";} else if ($row['payment_method'] == "alipay") {echo "支付宝支付";} else {echo "其他";}?></span></li>
        <li><span>订单号</span><span><?php echo $row['pay_trade_no'];?></span></li>
        <li class="order_details_all"><a href="order_details.php?list=<?php echo $pay_shop;?>" target="_self">查看所有订单</a></li>
    </ul>
</div>
<?php 
} else {
$query = "SELECT * FROM payment_list where pay_shop = '{$list}' and pay_status = '1' order by pay_id desc limit 50";
    if ($result = mysqli_query($mysqli, $query))
    {
?>
    <div class="orderitem_list">
        <ul>
            <?php 
            for ($i=0;$row = mysqli_fetch_assoc($result);$i++) {
            ?>
            <li>
                <p><a href="order_details.php?id=<?php echo $row['pay_id'];?>" target="_self">尾号<?php echo substr_replace($row['pay_member'],'****',3,4)?> - 支付 ￥<?php echo $row['pay_price'];?></a></p>
                <p><a href="order_details.php?id=<?php echo $row['pay_id'];?>" target="_self">支付时间 <?php echo $row['pay_time'];?></a></p>
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
<?php
include( "include/foot_.php" );
?>