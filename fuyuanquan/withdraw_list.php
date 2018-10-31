<?php
include( "../db_config.php" );
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
					<h3 class="page-title">提现列表</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Basic Table</h3>
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
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
										$bank_['bank'] = "银行卡";
										$bank_['weixin'] = "微信";
										$bank_['alipay'] = "支付宝";
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM balance_details where t_cate = 'commission_less' or t_caption = 'expend' or t_cate = 'partner_less' or t_cate = 'charge_less'");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM balance_details where t_cate = 'commission_less' or t_caption = 'expend' or t_cate = 'partner_less' or t_cate = 'charge_less' ORDER BY t_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
												$tl_phone = $row['t_phone'];
												$query_member = "SELECT * FROM fyq_member where mb_phone = '{$tl_phone}'";
												$result_member = mysqli_query($mysqli, $query_member);
												$row_member = mysqli_fetch_assoc($result_member);
										?>
											<tr>
												<td>
													<?php echo $row['t_id'];?>
												</td>
												<td>
													<?php echo $row['t_phone'];?><div style="cursor: pointer;" onClick="pay_qrcode('<?php echo $row['t_phone'];?>','<?php echo $row['t_way'];?>')">查看收款帐号</div>
												</td>
												<td>
												<font color="#FF9091">
												<?php 
													if ($row_member['mb_name_receipt']) {	
														echo $row_member['mb_name_receipt'];
													} else {
														echo $row_member['mb_nick'];
													}
												?>
													</font>
													<?php echo $bank_[$row['t_way']];?> - 
													<?php if ($row['t_cate'] == 'all_money') {echo "余额提现";}?>
													<?php if ($row['t_cate'] == 'commission_money') {echo "佣金提现";}?>
													<font color="#FF7A7C">(<?php echo $row['t_money'];?>)</font>
												</td>
												<td>
													<?php echo $row['t_time'];?>
												</td>
												<td id="status_<?php echo $row['t_id'];?>">
												<?php 
													if ($row['t_status']) {
														echo "<span><font color=\"#4BD968\">已确认</font></span>";
													} else {
												?>
												<span style="cursor: pointer;" onClick="withdraw('<?php echo $row['t_id'];?>','<?php echo $row['t_phone'];?>')"><font color="#f44336">待确认</font></span>
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
										$imin = ( ceil( $page / $page_count ) - 1 ) * $page_count + 1;
										$imax = ( $max_page - $imin < $page_count ) ? $max_page : ( $imin + ( $page_count - 1 ) );
										if ( $imin > $page_count ) {
											?>
										<a href="?page=1";?>">&lt;&lt;</a> <a href="?page=".($imin - 1);?>">&lt;</a>
										<?
	}
	?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?>"><?php echo $i;?></a>
											<?php
											}
											?>
											<?php
											if ( $imax < $max_page ) {
												?>
											<a href="?page=".($imax + 1);?>">&gt;</a> <a href="?page=".$max_page;?>">&gt;&gt;</a>
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
			$.post("post/withdraw_pay.php",
			  {
				wid:wid,
				wphone:wphone
			  },
			  function(data,status){
				if (data == "1") {
					$("#status_"+wid).find("span").html("<font color=\"#4BD968\">已确认</font>");
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