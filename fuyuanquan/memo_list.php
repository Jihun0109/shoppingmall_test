<?php
include( "../db_config.php" );
include("admin_login.php");
include("../include/member_level.php");
if (!strstr($admin_purview,"memo_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>信息列表</title>
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
					<h3 class="page-title">信息列表</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><a href="memo_in.php" target="_self">信息添加</a></h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>发送</th>
												<th>接收</th>
												<th>标题</th>
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
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM memo_list");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM memo_list order by me_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr id="memo_<?php echo $row['me_id'];?>">
												<td width="60">
													<?php 
														if ($row['me_cate'] == "10") {
															echo "公告";
														}
														if ($row['me_cate'] == "20") {
															echo "信息";
														}
														if ($row['me_cate'] == "30") {
															echo "买家帮助";
														}
														if ($row['me_cate'] == "40") {
															echo "卖家帮助";
														}
													?>
												</td>
												<td width="100">
													<?php echo $row['me_send'];?>
												</td>
												<td width="100">
													<?php echo $row['me_receive'];?>
												</td>
												<td width="300">
													<?php echo $row['me_title'];?>
												</td>
												<td width="150">
													<?php echo date("Y-m-d H:i:s",$row['me_time']);?>
												</td>
												<td class="admin_button" width="100">
                                                	<?php if($row['me_cate'] != '20'){?><a href="memo_up.php?id=<?php echo $row['me_id'];?>" target="_self">修改</a><?php }?>
													<a href="#" onClick="memo_del('<?php echo $row['me_id'];?>')">删除</a>
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
	function memo_del(mid) {
		if(confirm("确定要删除数据吗?")){
			$.post("post/memo_del.php",
			  {
				dids:mid
			  },
			  function(data,status){
				$("#memo_"+mid).remove();
			  });
		 }
	}
	</script>
</body>

</html>