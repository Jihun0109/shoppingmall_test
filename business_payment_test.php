<?php 
include("include/data_base.php");
//ini_set('display_errors',1);
$item = 0;
if (isset($_GET['reset'])) {
    setcookie("item_id", "", time()-3600);
    echo "<script type=\"text/javascript\">window.location.href=\"business_payment.php\"</script>";
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
<link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
<link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
<link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
<link rel="stylesheet" type="text/css" href="/css/style.css"/>
<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>
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
        .business_goods {
            float: left;
            width: 92%;
            font-size: 16px;
            padding-left: 4%;
            margin-bottom: 2%;
            padding-right: 4%;
        }
        .business_goods ul {
            float: left;
            width: 100%;
            color: #333333;
            background-color: #FFFFFF;
        }
        .business_goods li {
            float: left;
            width: 94%;
            border-bottom: 1px solid #eaeaea;
            border-radius: 0px;
            height: 42px;
            line-height: 42px;
            padding-left: 3%;
            padding-right: 3%;
        }
        .business_goods .goods_title {
            font-size: 14px;
            float: left;
        }
        .business_goods .goods_price {
            font-size: 14px;
            float: right;
        }
        .business_goods .goods_price .left {
            color: #F44336;
            font-weight: bold;
        }
        .business_goods .goods_price .right {
            color: #FF9800;
            font-weight: bold;
        }
        .business_goods .goods_price b {
            margin-left: 2px;
            margin-right: 2px;
            color: #cecece;
            font-weight: normal;
        }
        .business_goods .goods_plus {
            float: right;
        }
        .add_goods {
            float: left;
            width: 92%;
            margin-left: 4%;
            margin-right: 4%;
        }
        .add_goods ul {
            background-color: #ffffff;
            color: #000;
            width: 100%;
            float: left;
        }
        .add_goods li {
            float: left;
            width: 94%;
            border-bottom: 1px solid #eaeaea;
            padding-left: 3%;
            padding-right: 3%;
            height: 48px;
            line-height: 48px;
        }
        .add_goods .goods_title {
            float: left;
            font-size: 14px;
        }
        .add_goods .goods_count {
            font-size: 14px;
            float: right;
            width: 90px;
        }
        .add_goods .goods_count i img {
            width: 26px;
            vertical-align: middle;
        }
        .add_goods .goods_count .left {
            float: left;
        }
        .add_goods .goods_count .right {
            float: right;
        }
        .bottom_goods {
            background-color: rgba(0,0,0,0.8);
            color: #fff;
            padding: 2%;
            width: 96%;
            position: fixed;
            bottom: 0px;
            max-width: 640px;
        }
        .bottom_goods input[name=price] {
            width: 25%;
            height: 38px;
            padding-left: 2%;
            padding-right: 2%;
            float: left;
        }
        .bottom_goods input[name=user_phone] {
            width: 64%;
            height: 38px;
            padding-left: 2%;
            padding-right: 2%;
            float: right;
        }
        .bottom_goods .chek_goods {
            float: left;
            width: 100%;
            height: 36px;
            line-height: 36px;
        }
        .bottom_goods .chek_goods .all_price {
            margin-left: 5px;
        }
        .bottom_goods .chek_goods .all_point {
            margin-left: 10px;
        }
        .bottom_goods input[name=createqrcode] {
            width: 92%;
            display: block;
            border: 0px;
            padding: 0px;
            font-size: 1em;
            height: 36px;
            margin: 0 auto;
        }
        .bottom_goods input[name=paychek] {
            width: 92%;
            display: block;
            border: 0px;
            padding: 0px;
            font-size: 1em;
            height: 36px;
            margin: 5px auto;
            background-color: #8BC34A;
            color: #fff;
        }
        .viewqrcode {
            display: none;
            width: 260px;
            height: 260px;
            margin: 0 auto;
            left: 0px;
            right: 0px;
            position: fixed;
            top: 10%;
            z-index: 99999;
            border: 10px solid #fff;
        }
        .viewqrcode canvas {
            width: 100%;
        }
        #payment_background {
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0px;
            bottom: 0px;
            left: 0px;
            right: 0px;
            display: none;
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
        <div class="business_goods">
            <ul>
						<?php 
						$query_goods = "SELECT * FROM goods_list where item_id = '{$item_ids}' order by id desc";
						if ($result_item = mysqli_query($mysqli, $query_goods))
						{
							for ($i=0;$row_goods = mysqli_fetch_assoc($result_item);$i++) {
						?>
                <li onClick="add_goods('<?php echo $row_goods['goods_name'];?>','<?php echo $row_goods['id'];?>')">
                    <p class="goods_title"><?php echo $row_goods['goods_name'];?></p>
                    <p class="goods_price"><i class="left"><?php echo $row_goods['goods_price'];?>￥</i><b>|</b><i class="right"><?php echo $row_goods['goods_point'];?>P</i></p>
                </li>
                <?php 
							}
						}
						?>
                
            </ul>
        </div>
        <div class="add_goods">
            <ul>
            </ul>
        </div>
        
        <span class="business_phone">收款账号: <?php echo $item_phone;?></span>
        <a href="business_payment.php?reset=1" target="_self">切换收款账号</a>
        </div>
        <div class="bottom_goods">
            <input type="number" step="0.01" name="price" value="" placeholder="收款金额(必填)">
            <input type="number" name="user_phone" value="" placeholder="客户手机号(选填)">
            <div class="chek_goods">需支付<span class="all_price">120.50￥</span><span class="all_point">160P</span></div>
            <input type="button" name="createqrcode" value="生成收款码">
            <input type="button" name="paychek" value="等待客户确认">
        </div>
        <div class="viewqrcode"></div>
        <div id="payment_background"></div>
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
        <form action="business_payment.php" method="get">
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
				var user_phone = $("[name=user_phone]").val();
				var goodsidArray=new Array();
				var goodscountArray=new Array();
				$(".add_goods ul li").each(function(index,element){
					goodsidArray[index] = $(this).attr("id");
					goodscountArray[index] = $(this).find("span").text();
				});
           var data_content = {'business_price':price,'user_phone':user_phone,'business_id':<?php echo $item_ids;?>,'goodsidArray':goodsidArray,'goodscountArray':goodscountArray};
            $.ajax({
                url:'post/business_payment_post_test.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){
                    $('.viewqrcode').qrcode({
                        text: "/user_payment_test.php?trade_num="+data
                    })
                    payment_chek(data);
                    $(".business_code [name=paychek], .viewqrcode, #payment_background").css("display","block");
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
		
		function add_goods(name,ids) {
			if ($("#goods_"+ids).length>0) {
				var goods_count = parseInt($("#goods_"+ids+" .goods_count span").text());
				$("#goods_"+ids+" .goods_count span").text(goods_count+1);
			} else {
				$(".add_goods ul").append("<li id=\"goods_"+ids+"\"><p class=\"goods_title\">"+name+"</p><p class=\"goods_count\"><i class=\"left\" onclick=\"minus_goods('"+ids+"')\"><img src=\"img/v3/minus.svg\" alt=\"\"></i><span>1</span><i class=\"right\" onclick=\"plus_goods('"+ids+"')\"><img src=\"img/v3/plus.svg\" alt=\"\"></i></p></li>");
			}
			
		}
		function minus_goods(ids) {
			var goods_count = parseInt($("#goods_"+ids+" .goods_count span").text());
			if (goods_count>1) {
				$("#goods_"+ids+" .goods_count span").text(goods_count-1);
			} else {
				$("#goods_"+ids).remove();
			}
		}
		function plus_goods(ids) {
			var goods_count = parseInt($("#goods_"+ids+" .goods_count span").text());
			$("#goods_"+ids+" .goods_count span").text(goods_count+1);
		}
    </script>
</body>
</html>