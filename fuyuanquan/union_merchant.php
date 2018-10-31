<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"college_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>联盟店</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/loding.css">
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
        #union_merchant img {
            width: 80px;
            border-radius: 5px;
        }
        .panel-heading input[name=merchant_phone] {
            width: 180px;
            height: 36px;
            border-radius: 5px;
            border: 1px solid #ddd;
            padding-left: 10px;
            padding-right: 10px;
        }
        .panel-heading input[name=merchant_search] {
            width: 80px;
            height: 36px;
            border-radius: 5px;
            border: 1px solid #5d5d5d;
            padding-left: 10px;
            padding-right: 10px;
            background-color: #5d5d5d;
            color: #fff;
        }
        .unionloding {
            margin-top: 20px;
            margin-bottom: 20px;
        }
        #union_merchant .union_on {
            background-color: #4CAF50;
            width: 100px;
            text-align: center;
            height: 32px;
            line-height: 33px;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 4px;
            margin-top: 4px;
        }
        #union_merchant .union_off {
            background-color: #f44336;
            width: 100px;
            text-align: center;
            height: 32px;
            line-height: 33px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 4px;
            margin-top: 4px;
        }
        #union_merchant .open_goods {
            background-color: #337ab7;
            width: 100px;
            text-align: center;
            height: 32px;
            line-height: 33px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 4px;
            margin-top: 4px;
        }
        .item_list {
            float: left;
            width: 100%;
        }
        .panel-body {
            float: left;
            width: 100%;
        }
        .goods_list {
            display: none;
            float: left;
            width: 100%;
        }
        .goods_list .panel-heading {
            font-size: 1.4em;
            float: left;
        }
        .goods_list .panel-heading i {
            width: 28px;
            float: left;
            margin-right: 10px;
            cursor: pointer;
        }
        .goods_list .panel-heading i svg {
            display: block;
        }
        .goods_list .item_name {
            float: left;
        }
        .goods_list .add_goods {
            float: left;
            color: #3F51B5;
            width: 100px;
            text-align: center;
            height: 30px;
            line-height: 30px;
            margin-left: 10px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .goods_list .goods_input {
            float: left;
            width: 100%;
            display: none;
        }
        .goods_list .goods_input ul {
            float: left;
            width: 100%;
        }
        .goods_list .goods_input li {
            float: left;
            width: 100%;
            list-style: none;
            margin-bottom: 5px;
            margin-top: 5px;
        }
        .goods_list .goods_input li .spanleft {
            float: left;
            width: 120px;
            height: 36px;
            line-height: 36px;
        }
        .goods_list .goods_input li .spanright {
            float: left;
            width: 240px;
        }
        .goods_list .goods_input li .spanright input[name=goods_name] {
            width: 320px;
            border: 1px solid #ddd;
            height: 36px;
            line-height: 36px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 3px;
        }
        .goods_list .goods_input li .spanright input[name=goods_point] {
            width: 180px;
            border: 1px solid #ddd;
            height: 36px;
            line-height: 36px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 3px;
        }
        .goods_list .goods_input li .spanright input[name=goods_price] {
            width: 220px;
            border: 1px solid #ddd;
            height: 36px;
            line-height: 36px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 3px;
        }
        .goods_list .goods_input li .spanright textarea[name=goods_memo] {
            width: 320px;
            border: 1px solid #ddd;
            height: 80px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 3px;
        }
        .goods_list .goods_input li .spanright input[name=goods_submit] {
            width: 80px;
            border: 1px solid #4CAF50;
            height: 36px;
            padding-left: 10px;
            padding-right: 10px;
            border-radius: 3px;
            background-color: #4CAF50;
            color: #fff;
        }
        .la-line-spin-fade-rotating.la-2x {
            margin: 0 auto;
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
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title">联盟店</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel item_list">
								<div class="panel-heading">
									<input type="tel" name="merchant_phone" value="" placeholder="请输入商家手机号">
                                    <input type="button" name="merchant_search" value="查询">
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th width="100">#</th>
												<th width="120">LOGO</th>
												<th width="380">店铺名</th>
												<th width="160">手机号码</th>
                                                <th width="180">地区</th>
												<th width="160">操作</th>
											</tr>
										</thead>
										<tbody id="union_merchant">
										</tbody>
									</table>
								</div>
							</div>
                            
                            <div class="panel goods_list">
								<div class="panel-heading"><i><svg aria-hidden="true" data-prefix="fas" data-icon="arrow-alt-circle-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-arrow-alt-circle-left fa-w-16" style="font-size: 48px;"><path fill="currentColor" d="M256 504C119 504 8 393 8 256S119 8 256 8s248 111 248 248-111 248-248 248zm116-292H256v-70.9c0-10.7-13-16.1-20.5-8.5L121.2 247.5c-4.7 4.7-4.7 12.2 0 16.9l114.3 114.9c7.6 7.6 20.5 2.2 20.5-8.5V300h116c6.6 0 12-5.4 12-12v-64c0-6.6-5.4-12-12-12z" class=""></path></svg></i><span class="item_name">芭必亚存酒卡</span><span class="add_goods">添加商品</span></div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th width="100">#</th>
												<th width="120">名称</th>
												<th width="100">积分</th>
                                                <th width="100">价格</th>
                                                <th width="260">备注</th>
												<th width="130">时间</th>
												<th width="160">操作</th>
											</tr>
										</thead>
										<tbody id="union_goods">
										</tbody>
									</table>
								</div>
                                <div class="goods_input">
                                    <ul>
                                        <li><span class="spanleft">名称</span><span class="spanright"><input type="text" name="goods_name" value="" placeholder="请输入商品名称"></span></li>
                                        <li><span class="spanleft">积分</span><span class="spanright"><input type="number" name="goods_point" value="" placeholder="请输入消费积分"></span></li>
                                        <li><span class="spanleft">价格</span><span class="spanright"><input type="number" name="goods_price" value="" placeholder="积分不够使用按价格消费"></span></li>
                                        <li><span class="spanleft">备注</span><span class="spanright"><textarea name="goods_memo" placeholder="请输入商品备注"></textarea></span></li>
                                        <li>
                                            <span class="spanleft"></span><span class="spanright">
                                                <input type="button" name="goods_submit" value="确认添加">
                                            </span>
                                        </li>
                                    </ul>
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
        $(".panel-heading [name=merchant_search]").click(function(){
            var merchant_phone = $(".panel-heading [name=merchant_phone]").val();
            if (merchant_phone == "") {
                alert("请输入查询的手机号码");
                return false;
            } else {
                unionpost('search',merchant_phone,'new','1');
            }
        })
        unionpost('list','','new','1');
        function unionpost(type,merchant_phone,state,page) {
            var data_content = {
                'type':type,
                'merchant_phone':merchant_phone,
                'page':page
            };
            $.ajax({
                url:'post/union_merchant_post.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){                   
                    var json_data = JSON.parse(data);
                    var union_list = '';
                    var union_state = '';
                    $.each(json_data, function(idx, obj) {
                        if (obj.item_id) {
                            if (obj.item_state == '1') {
                                union_state = "<p class=\"union_on\">已加入</p><p onClick=\"union_goods('"+obj.item_name+"','"+obj.item_id+"')\" class=\"open_goods\">查看商品</p>";
                            } else if (obj.item_state == '0') {
                                union_state = "<p class=\"union_off\" onClick=\"join_union('"+obj.item_name+"','"+obj.item_id+"')\">加入联盟</p>";
                            } else {
                                union_state = "-";
                            }
                            union_list += "<tr><td width=\"100\">"+obj.item_id+"</td><td width=\"120\"><img src=\""+obj.item_logo+"\" alt=\""+obj.item_name+"\"></td><td width=\"380\">"+obj.item_name+"</td><td width=\"160\">"+obj.item_phone+"</td><td width=\"180\"><p>"+obj.item_province+"</p><p>"+obj.item_city+"</p><p>"+obj.item_district+"</p></td><td width=\"160\" id=\"union_"+obj.item_id+"\">"+union_state+"</td></tr>";
                        }
                        if (obj.page) {
                            if (obj.page == '1') {

                            }
                        }
                    });
                    if (state == 'new') {
                        $("#union_merchant").html(union_list);
                    } else {
                        $("#union_merchant").append(union_list);
                    }
                    $(".unionloding").remove();
                },
                beforeSend:function(XMLHttpRequest){
                    if (state == 'new') {
                        $("#union_merchant").html("");
                    }
                    $(".panel-body").append("<div class=\"unionloding\"><div class=\"la-line-spin-fade-rotating la-2x\"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>");
                },
                complete:function(XMLHttpRequest,status){
                    if(status=='timeout'){
                        alert("当前网络有点不给力");
                    } else if (status=='error') {
                        alert("请检查网络连接是否可用");
                    }
                }
            });
        }
        
        function join_union(title,item_id) {
            if(confirm("确定要<"+title+">店加入联盟吗?")){
                $.post("post/union_merchant_join_post.php",
                {
                    item_id:item_id
                },
                function(data,status){
                    if (data == '1') {
                        $("#union_"+item_id).html("<p class=\"union_on\">已加入</p><p onClick=\"union_goods('"+item_id+"')\">查看商品</p>");
                    } else {
                        alert("加入失败, 此商家已加入或者网络超时");
                    }
                });
            }
        }
        
        function union_goods(item_name,item_id) {
            var data_content = {
                'item_id':item_id
            };
            $.ajax({
                url:'post/union_goods_post.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){
                    var json_data = JSON.parse(data);
                    var goods_list = '';
                    $.each(json_data, function(idx, obj) {
                        if (obj.item_id) {
                            goods_list += "<tr><td width=\"100\">"+obj.item_id+"</td><td width=\"120\">"+obj.goods_name+"</td><td width=\"100\">"+obj.goods_point+"</td><td width=\"100\">"+obj.goods_price+"</td><td width=\"260\">"+obj.goods_memo+"</td><td width=\"130\">"+obj.goods_time+"</td><td width=\"160\">修改</td></tr>";
                        }
                    });
                    $(".item_list").fadeOut(100,function(){
                        $(".goods_list").fadeIn(100,function(){
                            $("#union_goods").html(goods_list);
                        });
                    });
                    $(".goods_list .item_name").text(item_name);
                    $(".goods_list .add_goods").attr("onClick","add_goods_input('"+item_name+"','"+item_id+"')");
                },
                beforeSend:function(XMLHttpRequest){
                    
                },
                complete:function(XMLHttpRequest,status){
                    if(status=='timeout'){
                        alert("当前网络有点不给力");
                    } else if (status=='error') {
                        alert("请检查网络连接是否可用");
                    }
                }
            });
        }
        
        function add_goods_input(item_name,item_id) {
            $(".goods_list .goods_input").fadeIn(100,function(){
                $(".goods_list .goods_input [name=goods_submit]").attr("onClick","goods_submit('"+item_name+"','"+item_id+"')");
            });
            
        }
        
        function goods_submit(item_name,item_id){
            var goods_name = $(".goods_list .goods_input [name=goods_name]").val();
            var goods_point = $(".goods_list .goods_input [name=goods_point]").val();
            var goods_price = $(".goods_list .goods_input [name=goods_price]").val();
            var goods_memo = $(".goods_list .goods_input [name=goods_memo]").val();
            if(goods_name == '') {
                alert("请输入商品名称");
                return false;
            }
            if (goods_point == '') {
                alert("请输入积分");
                return false;
            }
            if (goods_price == '') {
                alert("请输入价格");
                return false;
            }
            var data_content = {
                'item_id':item_id,
                'goods_name':goods_name,
                'goods_point':goods_point,
                'goods_price':goods_price,
                'goods_memo':goods_memo
            };
            $.ajax({
                url:'post/union_goods_join_post.php',
                type:'post',
                timeout:5000,
                data:data_content,
                success:function(data){
                    if (data == '1') {
                        union_goods(item_name,item_id);
                        $(".goods_list .goods_input").fadeOut(100,function(){
                            $(".goods_list .goods_input [name=goods_name]").val("");
                            $(".goods_list .goods_input [name=goods_point]").val("");
                            $(".goods_list .goods_input [name=goods_price]").val("");
                            $(".goods_list .goods_input [name=goods_memo]").val("");
                            $(".goods_list .goods_input [name=goods_submit]").removeAttr("onclick");
                        });
                    } else {
                        alert("添加商品有误,请重试");
                    }
                },
                beforeSend:function(XMLHttpRequest){
                    
                },
                complete:function(XMLHttpRequest,status){
                    if(status=='timeout'){
                        alert("当前网络有点不给力");
                    } else if (status=='error') {
                        alert("请检查网络连接是否可用");
                    }
                }
            });
        }
        
        $(".goods_list .panel-heading i").click(function(){
            $(".goods_list").fadeOut(100,function(){
                $(".item_list").fadeIn(100,function(){
                    $(".goods_list .goods_input").fadeOut(100,function(){
                        $(".goods_list .goods_input [name=goods_name]").val("");
                        $(".goods_list .goods_input [name=goods_point]").val("");
                        $(".goods_list .goods_input [name=goods_price]").val("");
                        $(".goods_list .goods_input [name=goods_memo]").val("");
                        $(".goods_list .goods_input [name=goods_submit]").removeAttr("onclick");
                    });
                });
            });
        })
	</script>
</body>

</html>