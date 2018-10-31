<?php 
header('Content-Type: text/html; charset=utf-8');
include("include/data_base.php");

if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    setcookie("qid", $qid, time()+3600*24*7,"/");
} else {
    $qid = 0;
}
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
<?php 

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
    <link rel="stylesheet" type="text/css" href="/css/style.css?20180414"/>
    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
    <link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
    <link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
    <link rel="stylesheet" type="text/css" href="/css/style.css"/>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>
    <link rel="stylesheet" href="/css/new-style.css" />
    <link rel="stylesheet" href="/css/business_payment_design.css" />
    <script type="text/javascript">
        $(document).ready(function(){
            $("#guanli_1" ).last().addClass( "active" );
            $("#area_4").hide();
            $("#area_5").hide();
            $("#area_6").show();
            $("#area_7").hide();
            $("#area_8").hide();
            $("#area_9").hide();
            open_list(3);
            get_count();
        })

        function get_area_html( area_id ){
            $.ajax({
                type: 'POST',
                url: "/include/payment_list.php?action=area",
                data: { 
                    area_id : area_id,
                },
                headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
                success: function(response) {
                    var html = '';
                    if(JSON.parse(response)['data']){
                        if (area_id == 4 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id  + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li><li><span onclick="pay_status_close('+ JSON.parse(response)['data'][i].pay_id +',' + 4 + ')">关 闭</span></li></ul>';
                            }    
                            $( "div#area_4" ).html(html);
                        } else if( area_id == 5 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }
                            $( "div#area_5" ).html(html);
                        } else if( area_id == 6 ){
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li><li><span onclick="sending('+ JSON.parse(response)['data'][i].pay_id +','+ 6 +')">发完了</span></li></ul>';
                            }                       
                            $( "div#area_6" ).html(html);
                        } else if( area_id == 7 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id  + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }                       
                            $( "div#area_7" ).html(html);
                        } else if( area_id == 8 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
                            }                       
                            $( "div#area_8" ).html(html);
                        } else if( area_id == 9 ) {
                            for (var i = 0 ; i < JSON.parse(response)['data'].length; i++) {
                                var address = JSON.parse(response)['data'][i].address;
                                var img_url = JSON.parse(response)['data'][i].tc_mainimg?JSON.parse(response)['data'][i].tc_mainimg:'/img/none_img.png';
                                html += '<ul id="payment_' + JSON.parse(response)['data'][i].pay_id + '"><li><div><p>'+ address + '</p></div></li><li><div><img src="'+ img_url + '" alt=""></div><div><p>' + JSON.parse(response)['data'][i].tl_name +'</p><p>价格：<font color="#ff0000">' + JSON.parse(response)['data'][i].tl_price +'</font></p><p>原价：' + JSON.parse(response)['data'][i].tl_original +'</p><p>手机号：' + JSON.parse(response)['data'][i].pay_member +'</p><p>名称：' + JSON.parse(response)['data'][i].pay_member_nick +'</p><p>时候：' + JSON.parse(response)['data'][i].pay_time +'</p></div></li><li><span style="color: black;">共' + JSON.parse(response)['data'][i].pay_count +'件商品 需付款：￥ ' + JSON.parse(response)['data'][i].pay_price +'</span></li></ul>';
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
                    $("#sending" ).last().addClass( "my_order_cate_on" );
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
                    $("#not_pay" ).last().removeClass( "my_order_cate_on" );
                    $("#sended" ).last().removeClass( "my_order_cate_on" );
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

                    get_count();
                    get_area_html(9);

                    break;
                default: break;
            }
        }

        function sending (pay_id,area_id){
            functionConfirm("您确定发货了吗？", 
                function yes(){
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
                }, 
                function no(){
                    return false;
                }
            );
        }

        function pay_status_close( pay_id, area_id ){
            functionConfirm("您确定关闭这个订单吗？", 
                function yes(){
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
                }, 
                function no(){return false;}
            );
        }

        function get_count()
        {
            $.ajax({
                type: 'POST',
                url: "/include/payment_list.php?action=get_count",
                data: { 
                    action : 1, 
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

    </script>
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
    </style>
</head>
<body>
    <div class="animsition">
        <div class="top_navigate">
            <ul>
              <li><a href="#" id="guanli_1" onclick="open_list(1)">面对面付款</a></li>
              <li><a href="#" id="guanli_2" onclick="open_list(2)">在线订单管理</a></li>
            </ul>
        </div>

        <div class="business_code" id="guanli_1_business">
            
            <?php
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
            <!-- <span class="business_phone">收款账号: <?php // echo $item_phone;?></span>
            <input type="button" name="paychek" value="等待客户确认">
            <a href="business_payment.php?reset=1" target="_self">切换收款账号</a> -->
            </div>
            <div class="business_payment_list">
                <div id="location1" class="tabcontent active" style="display: block;">
                    <ul>
                        <li class="title">
                            <span style="color: black;">账号</span>
                            <span style="color: black;">金额</span>
                            <span style="color: black;">时间</span>
                        </li>

                        <?php 
                        $query_payment = "SELECT pay_member,pay_price,pay_real,pay_time FROM payment_list where pay_cate != 'busines' and pay_cate != 'charge' order by pay_id desc limit 40";
                        if ($result_payment = mysqli_query($mysqli, $query_payment))
                        {
                            while($row_payment = mysqli_fetch_assoc($result_payment)){
                                $phone_user = substr($row_payment['pay_member'],-4);
                        ?>
                        <li>
                            <span style="color: black;">尾号: <?php echo $phone_user;?></span>
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
                <!-- <a href="javascript:void(0)"  onclick="get_paymentlist(1)">Load More</a> -->
            </div>
            <?php 
            // } else {
            ?>
           <!--  <div class="business_content">
            <div class="business_title">福源泉商家收款</div>
            <form action="business_payment.php" method="get">
                <input type="number" name="item_id" value="" placeholder="请输入商家ID">
                <input type="submit" name="item_login" value="确认">
            </form>
            </div> -->
            <?php 
            // }
            ?>
        </div>
        
        <div class="my_order_cate_list" id="guanli_2_business" style="display: none;margin-top: 35px;">
            <div class="my_order_cate" style="height: 84px;">
                <ul>
                    <li class="my_order_cate_on" id="pending" onclick="open_list(3)" style="margin-top: 1%;font-size: 1.3em;">
                        <b>进行中</b>
                    </li>
                    <li onclick="open_list(4)" id="completed" style="font-size: 1.3em;"><b>已完成</b></li>
                    <li onclick="open_list(5)" id="close" style="font-size: 1.3em;"><b>已关闭</b></li>
                </ul>
            </div>
            <div class="my_order_cate" id="pending_area" style="height: 84px; margin-top: 5px;">
                <ul style="margin-top: -4px;height: 80px;">
                    <li class="my_order_cate_on" onclick="open_list(6)" id="sending" style="margin-top: 1%;height: 100px;margin-top: 5px;">
                        <span id="sending_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;">0</span>
                        <b>待发货</b>
                    </li>
                    <li onclick="open_list(7)" id="not_pay_area" style="height: 100px;margin-top: 5px;">
                        <span id="not_pay_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;">0</span>
                        <b>待付款</b>
                    </li>
                    <li onclick="open_list(8)" id="sended_area" style="height: 100px;margin-top: 1px;">
                        <span id="sended_count" style="display:  block;height: 30px;top: -24px;margin-top: -10px;text-align: center;float: initial;">0</span>
                        <b>已发货</b>
                    </li>
                    <li onclick="open_list(9)" id="back_save" style="text-align: center;height: 100px;margin-top: 1px;">
                        <span id="back_save_count" style="display: block;height: 30px;top: -24px;margin-top: -10px;background-color: initial;float: initial;color: inherit;                            line-height:inherit;">0</span>
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
    </div>
    <div id="confirm">
        <div class="message"></div>
        <button class="yes">是</button>
        <button class="no">否</button>
    </div>
</body>
</html>