<?php 
header('Content-Type: text/html; charset=utf-8');
include("include/data_base.php");
include("include/member_level.php");
include("include/function.php");

if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    setcookie("qid", $qid, time()+3600*24*7,"/");
} else {
    $qid = 0;
}
ini_set('display_errors',1);
$item = $_GET['item_id'];
$mb_id = $_GET['mb_id'];

$member_login = @$_COOKIE["member"];
$me_state = get_user_type( $member_login, $mysqli );
// if (!$item && !$mb_id) {
//     exit;
// }

// if (isset($_GET['reset'])) {
if ( !$me_state ) {
    echo '<script type="text/javascript">window.location.href="member_center.php"</script>';
}
//     setcookie("item_id", "", time()-3600);
//     echo '<script type="text/javascript">window.location.href="business_payment.php?mb_id='.$mb_id.'&item_id=0&item_login=确认"</script>';
//     exit();
// }


?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css?time=<?php echo time() ?>"/>
    <link href="/css/mui.min.css?time=<?php echo time() ?>" rel="stylesheet"/>
    <link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css?time=<?php echo time() ?>"/>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js?time=<?php echo time() ?>"></script>
    <script type="text/javascript" src="/js/jquery.qrcode.min.js?time=<?php echo time() ?>"></script>
    <link rel="stylesheet" href="/css/new-style.css?time=<?php echo time() ?>" />
    <link rel="stylesheet" href="/css/business_payment_design.css?time=<?php echo time() ?>" />
    <script type="text/javascript" src="/js/YdbOnline.js?time=<?php echo time() ?>"></script>
	<style type="text/css">
        #area_4,#area_5,#area_6,#area_7,#area_8,#area_9 ul {
            margin-top: -13px;
        }

        #confirm
        {
            display: none;
            background-color: #91FF00;
            border: 1px solid #aaa;
            position: fixed;
            width: 250px;
            left: 50%;
            margin-left: -100px;
            padding: 6px 8px 8px;
            box-sizing: border-box;
            text-align: center;
        }
        #confirm button {
            background-color: #48E5DA;
            display: inline-block;
            border-radius: 5px;
            border: 1px solid #aaa;
            padding: 5px;
            text-align: center;
            width: 100px;
            cursor: pointer;
        }
        
        #confirm .message
        {
            text-align: left;
        }

		.my_order_cate_list li:nth-child(2) div:nth-child(2) p {
			font-size: 0.8em;
		}

		.my_order_cate_list li:nth-child(3) span {
			text-align: right;
			padding-right: 3%;
			float: right;
			font-size: 0.9em;
		}
		.goods_title{
			white-space: pre-wrap;
			word-wrap: break-word;
			white-space: -webkit-pre-wrap;
			word-break: break-all;
			white-space: normal;
			font-size: 1em;
			color: #000000;
			margin-left: 5px;
			height: initial !important;
			line-height: initial !important;
		}

		.Order_title_div{
			width: initial !important;
			height: inherit !important;
		}
		.my_order_cate ul{
			color:initial;
		}
    </style>
    <script type="text/javascript">
        var YDB = new YDBOBJ();
        <?php 
        if (isset($_COOKIE["member"])) {
        ?>
        var userName = '<?php echo $_COOKIE["member"];?>';
        YDB.SetUserRelationForPush(userName);//userName为用户唯一标识
        <?php
        }
        ?>
    </script>
</head>
<body>
    <div class="animsition">
        <?php
            include("include/top_navigate.php"); 
            if ( $me_state ) {
        ?>
        <div class="business_code" id="guanli_1_business">
            
            <?php
            if (!$item) {
        				
                $query_item = "SELECT tl_id,tl_name,tl_phone FROM teacher_list";
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
            <a href="business_payment.php?mb_id=<?php echo $mb_id;?>&item_id=0&reset=1&item_login=确认" target="_self">切换收款账号</a>
            </div>
            <?php 
            } else {
            ?>
            <div class="business_content">
            <div class="business_title">福源泉商家收款</div>
            <form action="business_payment.php" method="get">
                <input type="hidden" name="mb_id" value="<?php echo $mb_id;?>" placeholder="请输入商家ID">
                <input type="number" name="item_id" value="" placeholder="请输入商家ID">
                <input type="submit" name="item_login" value="确认">
            </form>
            </div>
            <?php 
            }
            ?>
            <div class="business_payment_list">
                <div id="location1" class="tabcontent active" style="display: block;">
                    <ul>
                        <li class="title">
                            <span style="color: black;">账号</span>
                            <span style="color: black;">金额</span>
                            <span style="color: black;">时间</span>
                        </li>
                    
                        <?php 
                    							
                            $query_payment = "SELECT pay_member,pay_price,pay_real,pay_time FROM payment_list where pay_cate != 'busines' and pay_cate != 'charge' and pay_shop = '{$item}' and ship_status != '-1' order by pay_id desc limit 40";
                            if ($result_payment = mysqli_query($mysqli, $query_payment))
                            {
                                while($row_payment = mysqli_fetch_assoc($result_payment)){
                                    $phone_user = substr($row_payment['pay_member'],-4);
                    							
                        ?>
                        <li>
                            <span style="color: black;">尾号: <?php // echo $phone_user;?></span>
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
                <a href="javascript:void(0)"  onclick="get_paymentlist(1)">Load More</a>
            </div>
            
        </div>
        <?php
            }
        ?>
    </div>
    <!-- <div id="confirm">
        <div class="message"></div>
        <button class="yes">是</button>
        <button class="no">否</button>
    </div> -->
    <script type="text/javascript">
        $("[name=createqrcode]").click(function(){
            var price = $("[name=price]").val();
            if (price<0.01) {
                alert("请输入收款金额");
                return false;
            }
            // var data_content = {'business_price':price,'business_id':<?php echo $item_ids;?>};
            var data_content = {'business_price':price,'business_id': 1544};
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