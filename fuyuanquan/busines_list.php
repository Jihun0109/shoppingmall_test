<?php
include( "../db_config.php" );
include("admin_login.php");


if (!strstr($admin_purview,"busines_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>学院列表</title>
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
					<h3 class="page-title">学院列表</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><a href="busines_in.php" target="_self">学院添加</a></h3>
                                    <div class="search_item">
                                    <form action="busines_list.php" method="get">
                                        <input type="text" name="item_keyword" value="" placeholder="请输入关键词">
                                        <input type="submit" value="搜索">
                                    </form>
                                    </div>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>老师名称</th>
												<th>老师地区</th>
												<th>老师分类</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?php 
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
                                        $item_keyword = @$_GET['item_keyword'];
                                        if ($item_keyword) {
                                            $item_serch = " and cl_name like '%{$item_keyword}%'";
                                        } else {
                                            $item_serch = "";
                                        }
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM college_list where cl_class = 'busines' and cl_admin = '{$admin_level}'{$item_serch}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM college_list where cl_class = 'busines' and cl_admin = '{$admin_level}'{$item_serch} ORDER BY cl_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){		
										?>
											<tr id="busines_<?php echo $row['cl_id'];?>">
												<td>
													<?php echo $row['cl_id'];?>
												</td>
												<td>
													<?php if ($row['cl_logo']) {?><p><img src="<?php echo $row['cl_logo'];?>" alt="" style="width: 186px; height: 106px;"></p><?php }?>
													<p><?php echo $row['cl_name'];?></p>
												</td>
												<td>
													<p><?php echo $row['cl_province'].$row['cl_city'].$row['cl_area'];?></p>
                                                    <p>&nbsp;</p>
                                                    <p>联系电话:<?php echo $row['cl_phone'];?></p>
                                                    
												</td>
												<td>
													<?php echo $row['cl_cate'];?>
												</td>
												<td class="admin_operate">
												<a href="busines_up.php?id=<?php echo $row['cl_id'];?>" target="_self">修改</a>
												<a href="#" onClick="busines_del('<?php echo $row['cl_id'];?>')">删除</a>
												<a href="commodity_list.php?sort=busines&i_class=<?php echo $row['cl_id'];?>" target="_self">讲课</a>
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
											<a href="?page=<?php echo ($imax + 1);?>">&gt;</a> <a href="?page=<?php echo $max_page;?>">&gt;&gt;</a>
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
	function busines_del(bid) {
		if(confirm("确定要删除数据吗?")){
			$.post("post/busines_del.php",
			  {
				dids:bid
			  },
			  function(data,status){
				$("#busines_"+bid).remove();
			  });
		 }
	}
	</script>
</body>

</html>