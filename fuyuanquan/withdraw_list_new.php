<?php
include( "../include/data_base.php" );
include("admin_login.php");
include("../include/member_level.php");
if (!strstr($admin_purview,"withdraw_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>提现列表</title>
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
        .panel-body p {
            line-height: 26px;
        }
        .panel-body b {
            margin-right: 20px;
        }
        .panel-body span {
            cursor: pointer;
            background-color: #6c6d6d;
            padding: 5px 10px 5px 10px;
            border-radius: 3px;
            color: #fff;
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
		//$sss = "select w.* from (select w_phone,max(w_id) as w_id,w_after from withdrawal_list group by w_phone) t join withdrawal_list w on w.w_id = t.w_id";
										//$ccc = mysqli_query($mysqli, $sss);
										//$rrr=mysqli_fetch_array($ccc,MYSQLI_NUM);
										//print_r($rrr);
        ?>
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title">提现列表</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<div class="search_item">
                                    <form action="withdraw_list_new.php" method="get">
                                        <input type="text" name="withdraw_phone" value="" placeholder="请输入手机号码">
                                        <input type="submit" value="搜索">
                                    </form>
                                    </div>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>手机号码</th>
												<th>说明</th>
												<th>时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        }  else {
                                            $page = 1;
                                        }
										if (isset($_GET['withdraw_phone']) && $_GET['withdraw_phone'] != "") {
                                            $withdraw_phone = $_GET['withdraw_phone'];
                                            $withdraw_serch = " where w_phone = '{$withdraw_phone}'";
                                        } else {
                                            $withdraw_phone = '';
                                            $withdraw_serch = '';
                                        }
										
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM withdrawal_list{$withdraw_serch}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM withdrawal_list{$withdraw_serch} ORDER BY w_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
												$tl_phone = $row['w_phone'];
												$query_member = "SELECT * FROM fyq_member where mb_phone = '{$tl_phone}'";
												$result_member = mysqli_query($mysqli, $query_member);
												$row_member = mysqli_fetch_assoc($result_member);
                                                if ($row['w_price_cate'] == 1) {
                                                    $price_cate = '余额';
                                                    $real_price = $row_member['mb_not_gold'];
                                                }
                                                if ($row['w_price_cate'] == 2) {
                                                    $price_cate = '佣金';
                                                    $real_price = $row_member['mb_commission_not_gold'];
                                                }
                                                if ($row['w_price_cate'] == 3) {
                                                    $price_cate = '股东';
                                                    $real_price = $row_member['mb_partner_not_gold'];
                                                }
										?>
											<tr>
												<td>
													<?php echo $row['w_id'];?>
												</td>
												<td>
													<p><?php echo $row['w_phone'];?></p>
                                                    <p>用户名:<b><?php echo $row_member['mb_nick'];?></b> 收款姓名: <b><?php echo $row_member['mb_name_receipt'];?></b></p>
                                                    <div style="cursor: pointer;"><a href="javascript:pay_qrcode('<?php echo $row['w_phone'];?>','<?php echo $row['w_bank'];?>')" style="color:#000">查看收款帐号</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="bill_list.php?page=1&bill_phone=<?php echo $row['w_phone']?>" target="_blank">详细流水</a></div>
												</td>
												<td>
												    <p>
                                                        提现金额: <b><?php echo $row['w_price'];?></b> 
                                                        应付金额: <b><?php if ($row['w_type']) {echo $row['w_price'];} else {echo $row['w_price']-$row['w_service'];}?></b> 
                                                        余额种类: <b><?php echo $price_cate;?>提现</b>
                                                    </p>
                                                    <p>
                                                        手续费: <b><?php echo $row['w_service'];?></b>
                                                        是否使用积分: <b><?php if ($row['w_type']) {echo '是';} else {echo '否';}?></b>
                                                        使用积分: <b><?php echo $row['w_point'];?></b>
                                                    </p>
                                                    <p>
                                                        提现前: <b><?php echo $row['w_before'];?></b>
                                                        提现后: <b><?php echo $row['w_after'];?></b>
                                                        实际余额: <b><?php echo $real_price;?></b>
                                                    </p>
												</td>
												<td>
													<?php echo $row['w_time'];?>
												</td>
												<td id="status_<?php echo $row['w_id'];?>" style="width: 100px;">
												<?php 
													if ($row['w_state']) {
														echo "<span><font color=\"#94ff99\">已确认</font></span>";
													} else {
												?>
												<span style="cursor: pointer;" onClick="withdraw('<?php echo $row['w_id'];?>','<?php echo $row['w_phone'];?>')"><font color="#ffffff">待确认</font></span>
												<?php 
													}
												?>
													
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
                                    $imin = (ceil($page/$page_count)-1)*$page_count+1;
                                    $imax = ($max_page-$imin<$page_count)?$max_page:($imin+($page_count-1));
                                    if ($imin>$page_count) {
                                    ?>
                                    <a href="?page=1<?php if ($withdraw_phone){echo '&withdraw_phone='.$withdraw_phone;}?>">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?><?php if ($withdraw_phone){echo '&withdraw_phone='.$withdraw_phone;}?>">&lt;</a>
                                    <?
                                    }
                                    ?>
                                    <?php
                                    for ($i=$imin;$i<=$imax;$i++){
                                    ?>
                                    <a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?><?php if ($withdraw_phone){echo '&withdraw_phone='.$withdraw_phone;}?>"><?php echo $i;?></a>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if ($imax<$max_page) {
                                    ?>
                                    <a href="?page=<?php echo ($imax + 1);?><?php if ($withdraw_phone){echo '&withdraw_phone='.$withdraw_phone;}?>">&gt;</a> <a href="?page=<?php echo $max_page;?>">&gt;&gt;</a>
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

	</div>
	<!-- END WRAPPER -->
	
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script type="text/javascript">
		function withdraw(wid,wphone) {
			$.post("post/withdraw_state.php",
			  {
				wid:wid
			  },
			  function(data,status){
				if (data == "1") {
					$("#status_"+wid).find("span").html("<font color=\"#94ff99\">已确认</font>");
				}
			  });
		}
		function pay_qrcode(pay_phone,way) {
			$.post("post/bank_pay.php",
			  {
				pay_phone:pay_phone,
				bank_way:way
			  },
			  function(data,status){
				$("body").prepend(data);
			  });
		}
		function bank_pay_off() {
			$(".withdraw_pay_open").remove();
		}
	</script>
</body>

</html>