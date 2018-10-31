<?php 
include("include/data_base.php");
//ini_set('display_errors',1);
$item = 0;
if (isset($_GET['reset'])) {
    setcookie("item_id", "", time()-3600);
    echo "<script type=\"text/javascript\">window.location.href=\"business_payment_1.php\"</script>";
    exit();
}
if (isset($_COOKIE['item_id'])) {
    $item = $_COOKIE['item_id'];
}
if (isset($_GET['item_id'])) {
    $item = $_GET['item_id'];
    setcookie("item_id", $item, time()+3600*24*365);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title>商家版收款</title>
<link rel="apple-touch-icon" href="http://test.shengtai114.com/ico/touch-icon-iphone.png"/>
<link rel="apple-touch-icon" sizes="72x72" href="http://test.shengtai114.com/ico/touch-icon-ipad.png"/>
<link rel="apple-touch-icon" sizes="114x114" href="http://test.shengtai114.com/ico/touch-icon-iphone4.png"/>
<link rel="stylesheet" type="text/css" href="http://test.shengtai114.com/css/style.css"/>
<script type="text/javascript" src="http://test.shengtai114.com/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="http://test.shengtai114.com/js/jquery.qrcode.min.js"></script>
    <style type="text/css">
        body {
            margin: 0px auto;
        }
        input, input:focus, input:active {
            user-select: text;
             -webkit-appearance: none; 
        }
        
        .business_content {
            clear: both;
        }
        .business_title {
            height: 60px;
            line-height: 60px;
            margin-bottom: 5px;
            font-size: 1.4em;
            font-weight: bold;
            color: #FF5722;
        }
        .business_code {
            width: 100%;
            text-align: center;
            max-width: 640px;
            margin: 0 auto;
        }
        .business_code a {
            color: #607D8B;
            text-decoration: none;
            height: 42px;
            line-height: 42px;
        }
        .business_code input {
            width: 92%;
            display: block;
            border: 0px;
            padding: 0px;
            font-size: 1em;
            height: 36px;
            margin: 0 auto;
            margin-bottom: 12px;
        }
        .business_code input[name=price] {
            background-color: #ffffff;
            color: #607D8B;
            padding-left: 1%;
            padding-right: 1%;
            width: 90%;
            border: 1px solid #9E9E9E;
            text-align: center;
            margin: 0 auto;
            margin-bottom: 12px;
        }
        .business_code input[name=item_id] {
            background-color: #ffffff;
            color: #607D8B;
            padding-left: 1%;
            padding-right: 1%;
            width: 90%;
            margin: 0 auto;
            margin-bottom: 12px;
            border: 1px solid #9E9E9E;
            text-align: center;
        }
        .business_code input[name=item_login] {
            margin: 0 auto;
            margin-top: 10px;
            background-color: #8BC34A;
            color: #fff;
        }
        .business_code input[name=createqrcode] {
            color: #ffffff;
            background-color: #FF5722;
        }
        .business_code input[name=paychek] {
            display: none;
            margin: 0 auto;
            margin-top: 20px;
            background-color: #8BC34A;
            color: #fff;
        }
        .viewqrcode {
            display: none;
            width: 100%;
            height: 300px;
            margin: 0 auto;
        }
        .viewqrcode canvas {
            width: 300px;
            height: 300px;
        }
        .business_phone {
            width: 100%;
            height: 36px;
            line-height: 36px;
            float: left;
            text-align: center;
        }
        .business_payment_list {
            float: left;
            width: 100%;
        }
        .business_payment_list ul {
            float: left;
            width: 100%;
        }
        .business_payment_list li {
            float: left;
            width: 100%;
            background-color: #FFFFFF;
            margin-bottom: 2px;
        }
        .business_payment_list span {
            width: 33.33%;
            float: left;
            height: 46px;
            margin-top: 10px;
            font-size: 0.8em;
        }
        .business_payment_list .title {
            height: 36px;
        }
    </style>
</head>

<body>
    <div class="business_code">
        <?php
        if ($item) {
            $query_item = "SELECT tl_id,tl_name,tl_phone FROM teacher_list where tl_id = '{$item}'";
            if ($result_item = mysqli_query($mysqli, $query_item))
            {
                $row_item = mysqli_fetch_assoc($result_item);
                $item_ids = $row_item['tl_id'];
                $item_name = $row_item['tl_name'];
                $item_phone = $row_item['tl_phone'];
            }
        ?>
        <div class="business_content">
        <div class="business_title"><?php echo $item_name;?></div>
        <input type="number" step="0.01" name="price" value="" placeholder="请输入收款金额">
        <input type="button" name="createqrcode" value="生成收款码">
        <span class="viewqrcode"></span>
        <span class="business_phone">收款账号: <?php echo $item_phone;?></span>
        <input type="button" name="paychek" value="等待客户确认">
        <a href="business_payment_1.php?reset=1" target="_self">切换收款账号</a>
        </div>
        <div class="business_payment_list">
            <ul>
                <li class="title">
                    <span>账号</span>
                    <span>金额</span>
                    <span>时间</span>
                </li>
                <?php 
                $query_payment = "SELECT pay_member,pay_price,pay_real,pay_time FROM payment_list where pay_shop = '{$item}' and pay_status > '0' order by pay_id desc limit 50";
                if ($result_payment = mysqli_query($mysqli, $query_payment))
                {
                    while($row_payment = mysqli_fetch_assoc($result_payment)){
                        $phone_user = substr($row_payment['pay_member'],-4);
                ?>
                <li>
                    <span>尾号: <?php echo $phone_user;?></span>
                    <span>
                        <p><?php echo $row_payment['pay_price'];?></p>
                        <p><?php echo $row_payment['pay_real'];?></p>
                    </span>
                    <span>
                        <p><?php echo date("Y-m-d",strtotime($row_payment['pay_time']));?></p>
                        <p><?php echo date("H:i:s",strtotime($row_payment['pay_time']));?></p>
                    </span>
                </li>
                <?php 
                    }
                }
                ?>
            </ul>
        </div>
        <?php 
        } else {
        ?>
        <div class="business_content">
        <div class="business_title">福源泉商家收款</div>
        <form action="business_payment_1.php" method="get">
            <input type="number" name="item_id" value="" placeholder="请输入商家ID">
            <input type="submit" name="item_login" value="确认">
        </form>
        </div>
        <?php 
        }
        ?>
    </div>
    
    <script type="text/javascript">
        $("[name=createqrcode]").click(function(){
            var price = $("[name=price]").val();
            if (price<0.01) {
                alert("请输入收款金额");
                return false;
            }
            var data_content = {'business_price':price,'business_id':<?php echo $item_ids;?>};
            $.ajax({
                url:'post/business_payment_post.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){
                    $('.viewqrcode').qrcode({
                        text: "http://test.shengtai114.com/user_payment.php?trade_num="+data
                    })
                    payment_chek(data);
                    $(".business_code [name=paychek], .viewqrcode").css("display","block");
                },
                beforeSend:function(XMLHttpRequest){ 
                    $(".viewqrcode").html("");
                },
                complete:function(XMLHttpRequest,status){
                    if(status=='timeout'){
                        alert("当前订单已超时请重试");
                    } else if (status=='error') {
                        alert("当前订单掉线了请重新生成收款码");
                    }
                }
            });  
        })
        
        function payment_chek(out_trade_no)
        {
            var data_content = {'out_trade_no':out_trade_no};
            $.ajax({
                url:'post/business_payment_chek.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){
                    if (data == '3') {
                        $("[name=paychek]").val("已确认, 等待付款");
                        setTimeout(function(){
                            payment_chek(out_trade_no);
                        },800);
                    } else if (data == '2') {
                        $("[name=paychek]").val("已付款成功,等待处理");
                        setTimeout(function(){
                            payment_chek(out_trade_no);
                        },800);
                    } else if (data == '1') {
                        alert("订单已处理完成");
                        window.location.reload();
                    } else {
                        setTimeout(function(){
                            payment_chek(out_trade_no);
                        },800);
                    }
                    console.log(data);
                },
                beforeSend:function(XMLHttpRequest){ 
                    
                },
                complete:function(XMLHttpRequest,status){
                    if(status=='timeout'){
                        alert("当前订单你已超时!");
                    } else if (status=='error') {
                        alert("当前订单掉线了请重新生成收款码!");
                    }
                }
            });
        }
    </script>
</body>
</html>