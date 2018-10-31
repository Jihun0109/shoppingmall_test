<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"bill_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>流水明细</title>
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
					<h3 class="page-title">流水明细</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									
                                    <div class="search_item">
                                    <form action="bill_list.php" method="get">
                                        <input type="text" name="bill_phone" value="" placeholder="请输入手机号码">
                                        <input type="submit" value="搜索">
                                    </form>
                                    </div>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>手机号</th>
												<th>交易金额</th>
                                                <th>交易前</th>
                                                <th>交易后</th>
												<th>交易说明</th>
												<th>交易时间</th>
											</tr>
										</thead>
										<tbody>
								<?php 
                                        if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page=1;
                                        }
                                        if (isset($_GET['bill_phone']) && $_GET['bill_phone'] != "") {
                                            $bill_phone = $_GET['bill_phone'];
                                            $bill_serch = " where t_phone = '{$bill_phone}'";
                                        } else {
                                            $bill_phone = '';
                                            $bill_serch = '';
                                        }
                                        
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(t_id) FROM balance_details{$bill_serch}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM balance_details{$bill_serch} ORDER BY t_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){		
										?>
											<tr>
                                                <td>
													<?php echo $row['t_id'];?>
												</td>
												<td>
													<?php echo $row['t_phone'];?>
												</td>
												<td>
                                                    <?php echo $row['t_money'];?>
												</td>
                                                <td>
                                                    <?php echo $row['t_before_money'];?>
												</td>
                                                <td>
                                                    <?php echo $row['t_after_money'];?>
												</td>
												<td>
													<?php echo $row['t_description'];?>
												</td>
                                                <td>
													<?php echo $row['t_time'];?>
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
										<a href="?page=1<?php if ($bill_phone){echo '&bill_phone='.$bill_phone;}?>">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?><?php if ($bill_phone){echo '&bill_phone='.$bill_phone;}?>">&lt;</a>
										<?
	}
	?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?><?php if ($bill_phone){echo '&bill_phone='.$bill_phone;}?>"><?php echo $i;?></a>
											<?php
											}
											?>
											<?php
											if ( $imax < $max_page ) {
												?>
											<a href="?page=<?php echo ($imax + 1);?><?php if ($bill_phone){echo '&bill_phone='.$bill_phone;}?>">&gt;</a> <a href="?page=<?php echo $max_page;?><?php if ($bill_phone){echo '&bill_phone='.$bill_phone;}?>">&gt;&gt;</a>
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
</body>

</html>