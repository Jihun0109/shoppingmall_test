<?php 
header('Content-Type: text/html; charset=utf-8');
include("include/data_base.php");
include("include/member_level.php");

if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    setcookie("qid", $qid, time()+3600*24*7,"/");
} else {
    $qid = 0;
}
//ini_set('display_errors',1);
$item = $_GET['item_id'];
$mb_id = $_GET['mb_id'];

if (!$item && !$mb_id) {
    exit;
}

if (isset($_GET['reset'])) {
    if ( !isset($_GET['mb_id']) ) {
        echo '<script type="text/javascript">window.location.href="member_center.php"</script>';
    }
    setcookie("item_id", "", time()-3600);
    echo '<script type="text/javascript">window.location.href="business_payment.php?mb_id='.$mb_id.'&item_id=0&item_login=确认"</script>';
    exit();
}


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
        $(document).ready(function(){
//            $("#guanli_1" ).last().addClass( "active" );

            $("#area_4").hide();
            $("#area_5").hide();
            $("#area_6").show();
            $("#area_7").hide();
            $("#area_8").hide();
            $("#area_9").hide();

			$("#guanli_1" ).last().removeClass( "active" );
			$("#guanli_2" ).last().addClass( "active" );
			$("#guanli_2_business").show();
			$("#guanli_1_business").hide();
			
            open_list(3);
            get_count();
        })

        function get_area_html( area_id ){
            $.ajax({
                type: 'POST',
                url: "/include/payment_list.php?action=area",
                data: { 
                    area_id : area_id,
                    mb_id : <?php echo $mb_id;?>,
                },
                headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
                success: function(response) {
                    var html = '';
					console.log(response);
                    if(JSON.parse(response)['data']){
						
						var shipping_address = "";

                        if (area_id == 4 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id  + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li><li><span onclick="pay_status_close('+ JSON.parse(response)['data'][i].pay_id +',' + 4 + ')">关闭订单</span></li></ul>';
                            }    
                            $( "div#area_4" ).html(html);
                        } else if( area_id == 5 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li>></ul>';
                            }
                            $( "div#area_5" ).html(html);
                        } else if( area_id == 6 ){
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
								var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li><li><span onclick="sending('+ JSON.parse(response)['data'][i].pay_id +','+ 6 +')">发货</span></li></ul>';
								// JSON.parse(response)['data'][i].pay_member
                            }                       
                            $( "div#area_6" ).html(html);
                        } else if( area_id == 7 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id  + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }                       
                            $( "div#area_7" ).html(html);
                        } else if( area_id == 8 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }                       
                            $( "div#area_8" ).html(html);
                        } else if( area_id == 9 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
								var mb_address = JSON.parse(response)['data'][i].mb_address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div class="Order_title_div"><p class="goods_title">'+ mb_address + '</p></div>></li><li><div><a style="display: initial;" href="' + JSON.parse(response)['data'][i].pay_shop + '"><img src="'+ img_url + '" alt=""></a></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p id="user_phone">电话：' + JSON.parse(response)['data'][i].pay_member +'</p><p>姓名：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时间：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 ：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }                       
                            $( "div#area_9" ).html(html);
                        } else if( area_id == 3 ) {
                            get_area_html(6);
                        }
                    } else{

                    }
                    
                },
                error: function (request, error) {
                    alert(" 不能这样做因为: " + error);
                },
            });
        }

        function open_list( status ) {
            $("#sended_area" ).css("color", "");
            $("#not_pay_area" ).css("color", "");
            switch(status)
            {
                case 1: 
                    $("#guanli_2" ).last().removeClass( "active" );
                    $("#guanli_1" ).last().addClass( "active" );
                    $("#guanli_1_business").show();
                    $("#guanli_2_business").hide();

                    break;
                case 2: 
                    $("#guanli_1" ).last().removeClass( "active" );
                    $("#guanli_2" ).last().addClass( "active" );
                    $("#guanli_2_business").show();
                    $("#guanli_1_business").hide();

                    open_list(3);
                    break;
                case 3: 
                    $("#area_4").hide();
                    $("#area_5").hide();
                    $("#area_6").show();
                    $("#area_7").hide();
                    $("#area_8").hide();
                    $("#area_9").hide();
                    $("#pending_area").show();
                    $("#close" ).last().removeClass( "my_order_cate_on" );
                    $("#completed" ).last().removeClass( "my_order_cate_on" );
                    $("#not_pay" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().removeClass( "my_order_cate_on" );
                    $("#back_save" ).last().removeClass( "my_order_cate_on" );
                    $("#pending" ).last().addClass( "my_order_cate_on" );
                    $("#sending" ).css("color", "");
                    get_count();
                    get_area_html(6);
                    

                    break;
                case 4: 
                    $("#area_6").hide();
                    $("#area_4").show();
                    $("#area_3").hide();
                    $("#area_7").hide();
                    $("#area_8").hide();
                    $("#area_9").hide();
                    $("#area_5").hide();
                    $("#pending_area").hide();
                    $("#pending" ).last().removeClass( "my_order_cate_on" );
                    $("#close" ).last().removeClass( "my_order_cate_on" );
                    $("#completed" ).last().addClass( "my_order_cate_on" );

                    get_area_html(4);
                    
                    break;
                case 5: 
                    $("#area_6").hide();
                    $("#area_7").hide();
                    $("#area_8").hide();
                    $("#area_9").hide();
                    $("#area_4").hide();
                    $("#area_3").hide();
                    $("#area_5").show();
                    $("#pending_area").hide();
                    $("#pending" ).last().removeClass( "my_order_cate_on" );
                    $("#completed" ).last().removeClass( "my_order_cate_on" );
                    $("#close" ).last().addClass( "my_order_cate_on" );

                    get_area_html(5);
                    break;
                case 6: 
                    $("#area_6").show();
                    $("#area_7").hide();
                    $("#area_8").hide();
                    $("#area_9").hide();
                    $("#sending" ).removeClass("color", "red");
                    $("#not_pay" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().removeClass( "my_order_cate_on"  );
                    $("#back_save" ).last().removeClass( "my_order_cate_on" );
                    $("#sending" ).last().addClass( "my_order_cate_on" );
                    get_area_html(6);
                    get_count();
                    break;
                case 7: 
                    $("#area_6").hide();
                    $("#area_7").show();
                    $("#area_8").hide();
                    $("#area_9").hide();
                    $("#sending" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().removeClass( "my_order_cate_on" );
                    $("#back_save" ).last().removeClass( "my_order_cate_on" );
                    $("#not_pay" ).last().addClass( "my_order_cate_on" );
                    $("#not_pay_area" ).css("color", "red");
                    $("#sended_area" ).css("color", "");
                    $("#sending" ).css("color", "");

                    get_area_html(7);
                    get_count();
                    break;
                case 8: 
                    $("#area_6").hide();
                    $("#area_7").hide();
                    $("#area_8").show();
                    $("#area_9").hide();
                    $("#not_pay" ).last().removeClass( "my_order_cate_on" );
                    $("#sending" ).last().removeClass( "my_order_cate_on" );
                    $("#back_save" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().addClass( "my_order_cate_on" );
                    $("#sended_area" ).css("color", "red");
                    $("#not_pay_area" ).css("color", "");
                    $("#sending" ).css("color", "");

                    get_area_html(8);
                    get_count();
                    break;
                case 9: 
                    $("#area_6").hide();
                    $("#area_7").hide();
                    $("#area_8").hide();
                    $("#area_9").show();
                    $("#not_pay" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().removeClass( "my_order_cate_on" );
                    $("#sending" ).last().removeClass( "my_order_cate_on" );
                    $("#back_save" ).last().addClass( "my_order_cate_on" );
                    $("#sending" ).css("color", "");

                    get_count();
                    get_area_html(9);

                    break;
                default: break;
            }
        }

        function sending (pay_id,area_id){
			if(window.confirm("您确定发货了吗？"))
			{
				 $.ajax({
					type: 'POST',
					url: "/include/payment_list.php?action=sending",
					data: { 
						id : pay_id,
					},
					headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
					success: function(response) {
						console.log(JSON.parse(response)['status']);
						if ( JSON.parse(response)['status'] == "success" ) {
							get_area_html(area_id);
							get_count();
						}
					},
					error: function (request, error) {
						alert(" 不能这样做因为: " + error);
					},
				});
			}
        }

        function pay_status_close( pay_id, area_id ){
			if(window.confirm("您确定关闭这个订单吗？")){
			   $.ajax({
					type: 'POST',
					url: "/include/payment_list.php?action=pay_status_close",
					data: { 
						id : pay_id, 
					},
					headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
					success: function(response) {
						console.log(JSON.parse(response)['status']);
						if ( JSON.parse(response)['status'] == "success" ) {
							get_area_html(area_id);
						}
					},
					error: function (request, error) {
						                                                                                                                                                                                                                                                                                                                                                                                                                                                   alert(" 不能这样做因为: " + error);
					},
				});
			}
        }

        function get_count()
        {
            $.ajax({
                type: 'POST',
                url: "/include/payment_list.php?action=get_count",
                data: { 
                    action : 1,
                    mb_id : <?php echo $mb_id;?>,
                },
                headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
                success: function(response) {
                    console.log(JSON.parse(response)['sending']);
                    $("#sending_count").text(JSON.parse(response)['sending']);
                    $("#not_pay_count").text(JSON.parse(response)['not_pay']);
                    $("#sended_count").text(JSON.parse(response)['sended']);
                },
                error: function (request, error) {
                    alert(" 不能这样做因为: " + error);
                },
            });
        }

        function functionConfirm(msg, myYes, myNo)
        {
            var confirmBox = $("#confirm");
            confirmBox.find(".message").text(msg);
            confirmBox.find(".yes,.no").unbind().click(function()
            {
              confirmBox.hide();
            });
            confirmBox.find(".yes").click(myYes);
            confirmBox.find(".no").click(myNo);
            confirmBox.show();
        }

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
        <div class="top_navigate">
            <?php
                if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
                    $top_navigate_return = '<div onClick="YDB.GoBack()"><img src="/img/return_top.png" alt="返回"></div>';
                } else {
                    if (@$_SERVER["HTTP_REFERER"]) {
                        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
                    } else {
                        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
                    }
                }
            ?>
            <span>
                <?php echo $top_navigate_return;?>
            </span> 
            <!-- <ul>
              <li><a href="#" id="guanli_1" onclick="open_list(1)">面对面付款</a></li>
              <li><a href="#" id="guanli_2" onclick="open_list(2)">在线订单管理</a></li>
            </ul> -->
			<span>在线订单管理</span>
        </div>
        <?php 
            if ( get_user_sales_permission(  $mysqli, $mb_id ) ) {
        ?>
        <!-- <div class="business_code" id="guanli_1_business">
            
            <?php
            //if ($item) {
        				/*
                $query_item = "SELECT tl_id,tl_name,tl_phone FROM teacher_list where tl_id = '{$item}' ";
                if ($result_item = mysqli_query($mysqli, $query_item))
                {
                    $row_item = mysqli_fetch_assoc($result_item);
                    $item_ids = $row_item['tl_id'];
                    $item_name = $row_item['tl_name'];
                    $item_phone = $row_item['tl_phone'];
                }
        				*/
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
            //} else {
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
            //}
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
                    							/*
                            $query_payment = "SELECT pay_member,pay_price,pay_real,pay_time FROM payment_list where pay_cate != 'busines' and pay_cate != 'charge' and pay_shop = '{$item}' and ship_status != '-1' order by pay_id desc limit 40";
                            if ($result_payment = mysqli_query($mysqli, $query_payment))
                            {
                                while($row_payment = mysqli_fetch_assoc($result_payment)){
                                    $phone_user = substr($row_payment['pay_member'],-4);
                    							*/
                        ?>
                        <li>
                            <span style="color: black;">尾号: <?php // echo $phone_user;?></span>
                            <span>
                                <p><?php// echo $row_payment['pay_price'];?></p>
                                <p><?php echo $row_payment['pay_real'];?></p>
                            </span>
                            <span>
                                <p><?php// echo date("Y-m-d",strtotime($row_payment['pay_time']));?></p>
                                <p><?php// echo date("H:i:s",strtotime($row_payment['pay_time']));?></p>
                            </span>
                        </li>
                            <?php 
                                //}
                            //}
                            ?>
                    </ul>
                </div>
                <a href="javascript:void(0)"  onclick="get_paymentlist(1)">Load More</a>
            </div>
            
        </div> -->
        
        <div class="my_order_cate_list" id="guanli_2_business" style="display: none;margin-top: 35px;">
            <div class="my_order_cate" style="height: 74px;margin-bottom: -1px;">
                <ul>
                    <li class="my_order_cate_on" id="pending" onclick="open_list(3)" style="margin-top: 1%;font-size: 1.2m;">
                        <b>进行中</b>
                    </li>
                    <li onclick="open_list(4)" id="completed" style="font-size: 1.05em;"><b>已完成</b></li>
                    <li onclick="open_list(5)" id="close" style="font-size: 1em;"><b>已关闭</b></li>
                </ul>
            </div>
            <div class="my_order_cate" id="pending_area" style="height: 74px; margin-top: 5px;">
                <ul style="margin-top: -11px;height:67px;">
                    <li class="my_order_cate_on" onclick="open_list(6)" id="sending" style="margin-top: 1%;height: 100px;margin-top: 5px;font-size: 1.1em;">
                        <span id="sending_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;">0</span>
                        <b>待发货</b>
                    </li>
                    <li onclick="open_list(7)" id="not_pay_area" style="height: 100px;margin-top: 5px;font-size: 1.1em;">
                        <span id="not_pay_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;">0</span>
                        <b>待付款</b>
                    </li>
                    <li onclick="open_list(8)" id="sended_area" style="height: 100px;margin-top: 1px;   ">
                        <span id="sended_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;text-align: center;float: initial;font-size: 1.1em;">0</span>
                        <b>已发货</b>
                    </li>
                    <li onclick="open_list(9)" id="back_save" style="text-align: center;height: 100px;margin-top: 1px;font-size: 1.1em;">
                        <span id="back_save_count" style="display: block;height: 30px;top: -24px;margin-top: -10px;background-color: initial;float: initial;color: inherit;line-height:inherit;margin-left: -15px;">0</span>
                        <b>退款/售后</b>
                    </li>
                </ul>
            </div>
            <div id="area_4"></div>
            <div id="area_5"></div>
            <div id="area_6"></div>
            <div id="area_7"></div>
            <div id="area_8"></div>
            <div id="area_9"></div>
            
            <ul style="text-align: center;">
                <!-- <a href="javascript:void(0)"  onclick="get_paymentlist(2)">Load More</a> -->
            </ul>
        </div>
        <?php
            }
        ?>
    </div>
    <div id="confirm">
        <div class="message"></div>
        <button class="yes">是</button>
        <button class="no">否</button>
    </div>
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
                        text: "http://localhost/user_payment.php?trade_num="+data
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