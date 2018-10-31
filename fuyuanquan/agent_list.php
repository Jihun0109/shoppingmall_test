<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"agent_list")) {
	echo "您没有权限访问此页";
	exit;
}
include("../include/member_level.php");
?>
<!doctype html>
<html lang="en">

<head>
	<title>代理会员</title>
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
					<h3 class="page-title">代理会员</h3>
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
												<th>地区</th>
												<th>注册时间</th>
												<th>代理时间</th>
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
										$count = mysqli_query($mysqli, "SELECT count(*) FROM admin_agent");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM admin_agent ORDER BY ag_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
												$ag_phone = $row['ag_phone'];
												$query_member = "SELECT * FROM fyq_member where mb_phone = '{$ag_phone}'";
												if ($result_member = mysqli_query($mysqli, $query_member))
												{
													$row_member = mysqli_fetch_assoc($result_member);
												}
										?>
											<tr id="agent_<?php echo $row_member['mb_phone'];?>">
												<td>
													<?php echo $row_member['mb_id'];?>
												</td>
												<td>
													<?php echo $row_member['mb_phone'];?>(<?php echo member_level($row_member['mb_level']);?>) 
													<?php if ($row['ag_balance']) {?><br /><font color="#5745B1">代理资金剩余</font><font color="#FF4245"> ￥<?php echo number_format($row['ag_balance'],2);?></font><?php }?>
												</td>
												<td>
													<?php echo $row_member['mb_nick'];?>
												</td>
												<td>
													<?php echo $row_member['mb_province'];?> <br /><?php echo $row_member['mb_city'];?> <br /><?php echo $row_member['mb_area'];?>
												</td>
												<td>
													<?php echo $row_member['mb_time'];?>
												</td>
												<td>
													<?php echo date("Y-m-d",strtotime($row['ag_time']));?>
												</td>
												<td class="admin_button">
													<a href="member_up.php?id=<?php echo $row_member['mb_id'];?>" target="_self">修改</a>
													<a href="#" onClick="agent_del('<?php echo $row_member['mb_phone'];?>')" target="_self">删除</a>
													
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
										<a <?php echo $i !=$page? '': 'class="over"'?> href="?page=<?php echo $i;?>"><?php echo $i;?></a>
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
	function agent_del(mid) {
		if(confirm("确定要删除数据吗?")){
			$.post("post/agent_del.php",
			  {
				dids:mid
			  },
			  function(data,status){
				$("#agent_"+mid).remove();
			  });
		 }
	}
	</script>
</body>

</html>