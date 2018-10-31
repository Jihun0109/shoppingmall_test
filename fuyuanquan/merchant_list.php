<?php
include( "../db_config.php" );
include("admin_login.php");
include("../include/member_level.php");
// if (!strstr($admin_purview,"merchant_list")) {
// 	echo "您没有权限访问此页";
// 	exit;
// }

?>
<!doctype html>
<html lang="en">

<head>
	<title>专家入驻</title>
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
					<h3 class="page-title">专家入驻</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Basic Table</h3>
								</div>
                                <style type="text/css">
                                    .panel-body img {
                                        width: 120px;
                                    }
                                </style>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>专家信息</th>
												<th>学历证书</th>
												<th>证件</th>
												<th>店铺信息</th>
                                                <th>折扣信息</th>
                                                <th>状态</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
										
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(me_id) FROM merchant_entry");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM merchant_entry ORDER BY me_id desc limit {$startCount},{$perNumber}";
										//echo $query;
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr>
												<td>
													<?php echo $row['me_id'];?>
												</td>
												<td>
													<p>申请人账号：<?php echo $row['me_user'];?></p>
                                                    <p>专家名称：<?php echo $row['me_shop'];?></p>
                                                    <p>法人姓名：<?php echo $row['me_name'];?></p>
                                                    <p>联系信息：<?php echo $row['me_phone'];?></p>
                                                    <p>老师地址：<?php echo $row['me_address'];?></p>
												</td>
												<td>
												    <p><a href="<?php echo $row['me_contract'];?>" target="_blank"><img src="<?php echo $row['me_contract'];?>" alt=""></a></p>
												</td>
												<td>
													<p><a href="<?php echo $row['me_idcard1'];?>" target="_blank"><img src="<?php echo $row['me_idcard1'];?>" alt="身份张正面"></a></p>
                                                    <p><a href="<?php echo $row['me_idcard2'];?>" target="_blank"><img src="<?php echo $row['me_idcard2'];?>" alt="身份张反面"></a></p>
                                                    
												</td>
												<td>
                                                <p><a href="<?php echo $row['me_shopdoor'];?>" target="_blank"><img src="<?php echo $row['me_shopdoor'];?>" alt="店铺门头"></a></p>
                                                <p><a href="<?php echo $row['me_logo'];?>" target="_blank"><img src="<?php echo $row['me_logo'];?>" alt="logo"></a></p>
                                                </td>
                                                <td>
                                                    <p>原价：<?php echo $row['me_original'];?></p>
                                                    <p>售价：<?php echo $row['me_price'];?></p>
                                                    <p>供货：<?php echo $row['me_supply'];?></p>
                                                </td>
                                                <td>
                                                    <?php if ($row['me_state']) {?>
                                                    <span>已审核</span>
                                                    <?php } else {?>
                                                    <span onClick="merchant('<?php echo $row['me_id'];?>')" id="merchant_<?php echo $row['me_id'];?>">等待审核</span>
                                                    <?php }?>
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
										<?php
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
											<?php 
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
		function merchant(mid) {
			if(confirm("确认审核通过吗?")){
			$.post("post/merchant_review.php",
			  {
				mid:mid
			  },
			  function(data,status){
				if (data == "1") {
					$("#merchant_"+mid).removeAttr("onClick").text("已审核");
				}
			  });
			}
		}
	</script>
</body>

</html>