<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"vipcard")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>会员卡明细</title>
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
        .search_item {
            margin-top: 10px;
        }
        .search_item input {
            padding: 5px;
        }
        .vippointbt {
            display: block;
            background-color: #607D8B;
            text-align: center;
            width: 80px;
            font-size: 12px;
            height: 26px;
            line-height: 26px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 5px;
        }
        #vpointopen {
            position: fixed;
            top: 164px;
            left: 0;
            right: 0px;
            margin: 0 auto;
            width: 600px;
            background-color: #607D8B;
            padding: 12px;
            color: #fff;
            display: none;
            border-radius: 8px;
        }
        #vpointopen div {
           font-size: 20px;
            height: 36px;
            line-height: 36px; 
        }
        #vpointopen div span {
            float: right;
            background-color: #455258;
            font-size: 16px;
            padding-left: 12px;
            padding-right: 12px;
            border-radius: 8px;
            cursor: pointer;
        }
        #vpointopen .vuserphone {
            font-size: 24px;
        }
        #vpointopen p {
            height: 50px;
            line-height: 50px;
        }
        #vpointopen input[type=number] {
            height: 36px;
            width: 150px;
            border: 0px;
            border-radius: 5px;
            padding-left: 5px;
            padding-right: 5px;
            color: #515151;
            margin-right: 10px;
        }
        #vpointopen input[type=button] {
            background-color: #f3f3f3;
            border: 0px;
            height: 36px;
            line-height: 36px;
            border-radius: 5px;
            padding-left: 10px;
            padding-right: 10px;
            color: #5d6f77;
            width: 80px;
        }
        #vpointlog {
            position: fixed;
            top: 164px;
            left: 0px;
            right: 0px;
            margin: 0 auto;
            width: 600px;
            background-color: #607D8B;
            padding: 12px;
            color: #fff;
            border-radius: 3px;
            display: none;
        }
        #vpointlog .title {
            font-size: 20px;
            width: 100%;
            height: 30px;
        }
        #vpointlog .title span {
            width: 50%;
        }
        #vpointlog .title i {
            float: right;
            width: 60px;
            font-style: normal;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
        #vpointlog ul {
            padding: 10px;
            margin: 0px;
        }
        #vpointlog li {
            list-style: none;
            height: 36px;
            line-height: 36px;
            float: left;
            width: 100%;
        }
        #vpointlog span {
            display: block;
            width: 30%;
            float: left;
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
					<h3 class="page-title">会员卡明细</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><a href="vipadd.php" target="_self">添加会员</a></h3>
                                    <div class="search_item">
                                    <form action="vipcard.php" method="get">
                                        <input type="text" name="coupon_phone" value="" placeholder="请输入手机号码">
                                        <input type="submit" value="搜索">
                                    </form>
                                    </div>
								</div>
                                
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>会员手机号</th>
												<th>交易金额</th>
												<th>交易说明</th>
                                                <th>剩余积分</th>
												<th>交易时间</th>
                                                <th>管理</th>
											</tr>
										</thead>
										<tbody>
								<?php 
                                        if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page=1;
                                        }
                                        if (isset($_GET['coupon_phone'])) {
                                            $coupon_phone = $_GET['coupon_phone'];
                                            if ($admin_level == 'admin') {
                                                $coupon_serch = " where user_phone = '{$coupon_phone}'";
                                            } else {
                                                $coupon_serch = " where user_phone = '{$coupon_phone}' and item_phone = '{$admin_level}'";
                                            }
                                        } else {
                                            $coupon_phone = 0;
                                            if ($admin_level == 'admin') {
                                                $coupon_serch = '';
                                            } else {
                                                $coupon_serch = " where item_phone = '{$admin_level}'";
                                            }
                                        }
                                        
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(id) FROM vip_card{$coupon_serch}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM vip_card{$coupon_serch} ORDER BY id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr>
                                                <td>
													<?php echo $row['id'];?>
												</td>
												<td>
													<?php echo $row['user_phone'];?>
												</td>
												<td>
                                                    <?php echo $row['item_pay'];?>
												</td>
												<td>
													<?php echo $row['item_name'];?>
												</td>
                                                <td>
													<?php echo $row['surplus_num'];?>
												</td>
                                                <td>
													<?php echo $row['jion_time'];?>
												</td>
                                                <td>
													<span class="vippointbt" onClick="vpoint('<?php echo $row['id'];?>','<?php echo $row['user_phone'];?>')">使用积分</span>
                                                    <span class="vippointbt" onClick="vpoint_more('<?php echo $row['id'];?>','<?php echo $row['user_phone'];?>')">积分明细</span>
												</td>
											</tr>
											<?php 
											}
										}
										?>
										</tbody>
									</table>
									<div id="phq_content_page">
										<?php
										$page_count = 5;
										$imin = ( ceil( $page / $page_count ) - 1 ) * $page_count + 1;
										$imax = ( $max_page - $imin < $page_count ) ? $max_page : ( $imin + ( $page_count - 1 ) );
										if ( $imin > $page_count ) {
											?>
										<a href="?page=1<?php if ($coupon_phone){echo '&coupon_phone='.$coupon_phone;}?>">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?><?php if ($coupon_phone){echo '&coupon_phone='.$coupon_phone;}?>">&lt;</a>
										<?
	}
	?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?><?php if ($coupon_phone){echo '&coupon_phone='.$coupon_phone;}?>"><?php echo $i;?></a>
											<?php
											}
											?>
											<?php
											if ( $imax < $max_page ) {
												?>
											<a href="?page=<?php echo ($imax + 1);?><?php if ($coupon_phone){echo '&coupon_phone='.$coupon_phone;}?>">&gt;</a> <a href="?page=<?php echo $max_page;?><?php if ($coupon_phone){echo '&coupon_phone='.$coupon_phone;}?>">&gt;&gt;</a>
											<?
	}
	?>
									</div>
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
<div id="vpointopen">
    <input type="hidden" name="user_id" value="">
    <div>使用会员卡<span>关闭</span></div>
     <p class="vuserphone"></p>
    <p><input type="number" name="vpoint" value="0">请输入使用积分数量</p>
    <p><input type="button" name="vbutton" value="确认"></p>
</div>
<div id="vpointlog">
    <div class="title"><span></span><i>关闭</i></div>
    <ul>
    </ul>       
</div>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
    <script type="text/javascript">
    function vpoint(id,uphone) {
        $("#vpointopen [name=user_id]").val(id);
        $("#vpointopen .vuserphone").text(uphone);
        $("#vpointopen").css("display","block");
    }
    function vpoint_more(id,uphone){
        $.post("post/vcard_more.php",
        {
            vid:id
        },
        function(data,status){
            $("#vpointlog").css("display","block");
            $("#vpointlog .title span").text(uphone+" 的 积分使用明细");
            if (data == '0') {
                $("#vpointlog ul").html("未找到积分明细");
            } else {
                $("#vpointlog ul").html(data);
            }
        }); 
    }
    $("#vpointopen div span").click(function(){
        $("#vpointopen").css("display","none");
    })
    $("#vpointlog .title i").click(function(){
        $("#vpointlog").css("display","none");
    })
    $("#vpointopen [name=vbutton]").click(function(){
        var vuser = $("#vpointopen [name=user_id]").val();
        var vpoint = $("#vpointopen [name=vpoint]").val();
        $.post("post/vipcardup.php",
        {
            vuser:vuser,
            vpoint:vpoint
        },
        function(data,status){
            if (data == '2') {
                alert('当前会员积分不够使用!');
                return false;
            } else if (data == '1') {
                alert('积分正常使用!');
                window.location.reload();
                return false;
            } else {
                alert('您的操作有误!');
            }
        });
    })
    </script>
</body>

</html>