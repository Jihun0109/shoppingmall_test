<?php
include( "../db_config.php" );
include( "admin_login.php" );
if ( !strstr( $admin_purview, "sales_list" ) ) {
    echo "您没有权限访问此页";
    exit;
}
include( "../include/member_level.php" );
?>
<!doctype html>
<html lang="en">

<head>
    <title>销量排行</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <!-- VENDOR CSS -->
    <link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendor/linearicons/style.css">
    <!-- MAIN CSS -->
    <link rel="stylesheet" href="assets/css/main.css">
    <!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
    <link rel="stylesheet" href="assets/css/demo.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
    <!-- ICONS -->
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <style type="text/css">
        p{
            height: 26px;
            line-height: 26px;
        }
        .a_button_this {
            padding: 10px;
            float: left;
            background-color: #FF9800;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 5px;
            margin-left: 5px;
        }
        .a_button_last {
            padding: 10px;
            float: left;
            background-color: #FF5722;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 5px;
            margin-left: 5px;
        }
        .sales_content {
            position: absolute;
            top: 22%;
            background-color: #000000eb;
            width: 90%;
            z-index: 9999;
            left: 0px;
            right: 0px;
            margin: 0 auto;
            border-radius: 8px;
            display: none;
        }
        .sales_content ul {
            margin: 0px;
            padding: 0px;
            padding-top: 10px;
            overflow-y: scroll;
            height: 500px;
            width: 100%;
        }
        .sales_content li {
            list-style: none;
            height: 42px;
            line-height: 42px;
            color: #fff;
            border-bottom: 1px solid #ffffff4d; 
        }
        .sales_content span {
            width: 16.66%;
            float: left;
            text-align: center;
        }
        .sales_content_off {
            width: 100%;
            text-align: center;
        }
        .sales_content_off span {
            float: right;
            width: 100px;
            color: #FFFFFF;
            height: 50px;
            line-height: 50px;
            cursor: pointer;
        }
        .sales_content_off font {
            height: 50px;
            line-height: 50px;
            color: #ffff;
            font-size: 30px;
        }
        #item_sales_list td:nth-child(1) {
            font-size: 1.2em;
        }
        .item_on {
            background-color: #607D8B;
            color: #FFFFFF;
        }
        .item_off {
            background-color: #9E9E9E;
            color: #FFFFFF;
        }
        .sales_serch {
            margin-bottom: 10px;
            float: left;
            width: 100%;
        }
        .sales_serch form {
            float: right;
        }
        .sales_serch [name="sales_phone"] {
            width: 200px; height: 40px; margin-left: 10px; padding-left: 5px;
        }
        .sales_serch [name="sales_time"] {
            width: 200px; height: 40px; margin-left: 10px; padding-left: 5px;
        }
        .sales_serch [name="sales_order_by"] {
            width: 120px !important;
            background-color: #fff;
            height: 40px;
            margin-bottom: 0px;
            border: 1px solid #a9a9a9;
        }
        .sales_where {
            float: left;
            color: #03A9F4;
            font-size: 1.2em;
        }
        .sales_cate {
            float: left;
            width: 100%;
            line-height: 46px;
            font-size: 1em;
            margin-bottom: 10px;
        }
        .sales_cate ul {
            padding: 0px;
            float: left;
        }
        .sales_cate li {
            float: left;
            list-style: none;
            margin-right: 20px;
            background-color: #FF5722;
            color: #fff;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 5px;
            height: 36px;
            line-height: 36px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <!-- WRAPPER -->
    <div id="wrapper">
        <!-- NAVBAR -->
        <?php include ("head.php");?>
        <!-- END NAVBAR -->
        <!-- LEFT SIDEBAR -->
        <?php include ("left.php");?>
        <!-- END LEFT SIDEBAR -->
        <!-- MAIN -->
        <?php 
        if (isset($_GET['sales_phone'])) {
            $sales_phone = $_GET['sales_phone'];
        } else {
            $sales_phone = '';
        }
        if (isset($_GET['startime'])) {
            $startime = $_GET['startime'];
        } else {
            $startime = date("Ymd",strtotime('-30 day'));
        }
        if (isset($_GET['endtime'])) {
            $endtime = $_GET['endtime'];
        } else {
            $endtime = date("Ymd",time());
        }
        if (isset($_GET['sales_order_by'])) {
            $sales_order_by = $_GET['sales_order_by'];
        } else {
            $sales_order_by = '';
        }
        ?>
        <div class="main">
            <!-- MAIN CONTENT -->
            <div class="main-content">
                <div class="container-fluid">
                    <h3 class="page-title">销量排行</h3>
                    <div class="sales_cate">
                        <ul>
                            <li style="background-color: #607D8B;">分类销量</li>
                            <?php 
                            $query = "SELECT vyic_cate_d,sum(vyic_order_d) as cateall FROM vital_day_item_cate where vyic_time_d >= '{$startime}' and vyic_time_d <= '{$endtime}' group by vyic_cate_d";
                            if ($result = mysqli_query($mysqli, $query))
                            {
                                while( $row = mysqli_fetch_assoc($result) ){
                                    $vyic_cate_d = $row['vyic_cate_d'];
                                    $query_name = "SELECT ic_name FROM item_cate where ic_cid = '{$vyic_cate_d}'";
                                    if ($result_name = mysqli_query($mysqli, $query_name))
                                    {
                                        $row_name = mysqli_fetch_assoc($result_name);
                                    }
                            ?>
                                   
                            <li><?php echo $row_name['ic_name'];?><?php echo $row['cateall'];?></li>   
                            <?php 
                                }
                            }
                          
                            ?>
                        </ul>
                    </div>
                    <div class="sales_serch">
                    <div class="sales_where">
                    排序条件:
                    <?php if ($sales_phone) {echo " 推荐人=".$sales_phone;}?>
                    </div>
                    <form action="sales_list.php" method="get">
                        <select name="sales_order_by">
                          <option value="sales"<?php if ($sales_order_by == "sales"){echo " selected";}?>>销量</option>
                          <option value="gross"<?php if ($sales_order_by == "gross"){echo " selected";}?>>毛利</option>
                        </select>
                      <input type="text" name="startime" value="<?php echo $startime;?>" placeholder="开始日期">
                        <input type="text" name="endtime" value="<?php echo $endtime;?>" placeholder="结束日期">
                        <input type="text" name="sales_phone" value="<?php echo $sales_phone;?>" placeholder="请输入推荐人">
                        <input type="submit" value="搜索" style="height: 40px;">
                    </form>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- BASIC TABLE -->
                            <div class="panel">

                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>店铺名(收款账号)</th>
                                                <th>销量</th>
                                                <th>收入</th>
                                                <th>交易</th>
                                                <th>推荐人</th>
                                            </tr>
                                        </thead>
                                        <tbody id="item_sales_list">
                                        </tbody>
                                    </table>
                                  <div id="item_sales_more" onClick="item_sales_more('0','<?php echo $sales_phone;?>','<?php echo $startime;?>','<?php echo $endtime;?>','<?php echo $sales_order_by;?>')" style="text-align: center; font-size: 2em;">更多加载</div>
                                </div>
                            </div>
                            <!-- END BASIC TABLE -->
                        </div>

                    </div>


                </div>
            </div>
            <!-- END MAIN CONTENT -->
        </div>
        <!-- END MAIN -->
        <div class="clearfix"></div>

    </div>
    
    <!-- END WRAPPER -->
    <!-- Javascript -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/scripts/klorofil-common.js"></script>

<script type="text/javascript">
item_sales_more(0,'<?php echo $sales_phone;?>','<?php echo $startime;?>','<?php echo $endtime;?>','<?php echo $sales_order_by;?>');
function item_sales_more(sales_page,sales_phone,startime,endtime,sales_order_by) {
    $("#item_sales_more").html("<div class=\"loader_ajax\"></div>").css("display","block");
    $.post("post/sales_post.php",
      {
        page:sales_page,
        recommend_phone:sales_phone,
        startime:startime,
        endtime:endtime,
        sales_order_by:sales_order_by
      },
      function(data,status){
        console.log(data);
        if (data == 0) {
            $("#item_sales_more").html("已全部加载完毕").removeAttr("onClick");
        } else {
            var json_data = JSON.parse(data);
            $.each(json_data, function(idx, obj) {
                if (obj.item_name) {
                    if (obj.item_sales < 10) {
                        var item_td_style = ' class="item_off"';
                    } else {
                        var item_td_style = ' class="item_on"';
                    }
                    $("#item_sales_list").append("<tr"+item_td_style+"><td>"+obj.item_name+"("+obj.item_phone+")</td><td><p>销量:"+obj.item_sales+"</p><p>新增会员:"+obj.recommend_yes+"</p><p>老会员:"+obj.recommend_no+"</p></td><td><p>余额:"+obj.total_gold+"</p><p>佣金:"+obj.commission_all+"</p></td><td><p>原价:"+obj.original_price+"</p><p>实付:"+obj.sale_price+"</p><p>供货:"+obj.supply_price+"</p><p>毛利:"+obj.gross_price+"</p><td><p>"+obj.item_recommend+"</p><p>"+obj.member_recommend_nick+"</p></td></tr>");
                }
                
                if (obj.page) {
                    if (obj.page == '0') {
                        $("#item_sales_more").html("已全部加载完毕").removeAttr("onClick");
                    } else {
                        $("#item_sales_more").html("加载更多").attr("onClick","item_sales_more('"+obj.page+"','"+sales_phone+"','"+startime+"','"+endtime+"','"+sales_order_by+"')");
                    }
                }
            });
            $("#item_sales_list").append("<tr style=\"background-color: #795548;\"><td></td><td></td><td></td><td></td><td></td></tr>");
        }
      });
}
</script>
</body>

</html>