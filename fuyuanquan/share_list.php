<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"share_list")) {
	echo "您没有权限访问此页";
	exit;
}

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}
if (isset($_GET['phone_num'])) {
    $phone_num = $_GET['phone_num'];
    $sql_phone = " where mb_phone = '{$phone_num}'";
} else {
    $phone_num = "";
    $sql_phone = "";
}

$queryshare = "SELECT SUM(mb_share) as shareall FROM fyq_member where mb_share>0";
if ($resultshare = mysqli_query($mysqli, $queryshare))
{
    $rowshare = mysqli_fetch_assoc($resultshare);
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>股东列表</title>
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
        .table>tbody>tr>td {
            padding: 12px;
            vertical-align: middle;
        }
        .search_member span {
            color: #565656;
            font-size: 18px;
            margin-left: 20px;
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
					<h3 class="page-title">股东列表</h3>
                    
					<div class="search_member">
					<form action="share_list.php" method="get">
						<input type="text" name="phone_num" value="<?php echo $phone_num;?>" placeholder="请输入手机号码">
						<input type="submit" value="搜索">
                        <span>已发放股份: <?php echo $rowshare['shareall'];?></span>
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
												<th>#</th>
												<th>手机号码</th>
												<th>名称</th>
                                                <th>股份</th>
												<th>注册时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(mb_id) FROM fyq_member{$sql_phone}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM fyq_member{$sql_phone} ORDER BY mb_share desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr>
												<td>
													<?php echo $row['mb_id'];?>
												</td>
												<td>
													<p><span style="font-size: 1.6em;"><?php echo $row['mb_phone'];?></span></p>
												</td>
												<td>
													<?php echo $row['mb_nick'];?>
												</td>
                                                <td>
													<?php echo $row['mb_share'];?>
												</td>
												<td>
													<?php echo $row['mb_time'];?>
												</td>
												<td class="admin_button">
													<a href="share_up.php?id=<?php echo $row['mb_id'];?>" target="_self">修改</a>
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
										<a href="?page=1">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?>">&lt;</a>
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
											<a href="?page=<?php echo ($imax + 1);?>">&gt;</a> <a href="?page=<?php echo $max_page;?>">&gt;&gt;</a>
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