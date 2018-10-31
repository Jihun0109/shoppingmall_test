<?php
include( "../db_config.php" );
include("admin_login.php");

if (!strstr($admin_purview,"member_list")) {
	echo "您没有权限访问此页!";
	exit;
}
include("../include/member_level.php");
?>
<!doctype html>
<html lang="en">

<head>
	<title>会员列表</title>
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
					<h3 class="page-title">会员列表</h3>
					<div class="search_member">
					<form action="member_list.php" method="get">
						<input type="text" name="se_keyword" value="" placeholder="请输入手机号码或名称">
						<input type="submit" value="搜索">
					</form>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><a href="member_in.php" target="_self">添加会员</a></h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>手机号码</th>
												<th>名称</th>
												<th>登录时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$se_keyword = @$_GET['se_keyword'];
										if ($se_keyword) {
											$sql_serch = " where mb_phone like '%{$se_keyword}%' or mb_nick like '%{$se_keyword}%'";
										} else {
											$sql_serch = "";
										}
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member{$sql_serch}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM fyq_member{$sql_serch} ORDER BY mb_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
												$member_phone = $row['mb_phone'];
												$query_agent = "SELECT * FROM admin_agent where ag_phone = '{$member_phone}'";
												if ($result_agent = mysqli_query($mysqli, $query_agent))
												{
													$row_agent = mysqli_fetch_assoc($result_agent);
												}
												$mb_recommend = $row['mb_recommend'];
												$query_recommend = "SELECT * FROM fyq_member where mb_phone = '{$mb_recommend}'";
												if ($result_recommend = mysqli_query($mysqli, $query_recommend))
												{
													$row_recommend = mysqli_fetch_assoc($result_recommend);
												}
										?>
											<tr id="member_<?php echo $row['mb_id'];?>">
												<td>
													<?php echo "2".$row['mb_id'];?>
												</td>
												<td>
													<p><span style="font-size: 1.6em;"><?php echo $row['mb_phone'];?></span> (<?php echo member_level($row['mb_level']);?>) 
													<?php if ($row_agent['ag_balance']) {?><font color="#5745B1">代理资金剩余</font><font color="#FF4245"> ￥<?php echo number_format($row_agent['ag_balance'],2);?></font><?php }?></p>
													<p style="font-size: 1em;">推荐人 (<font color="#3E66FF"><?php echo $row_recommend['mb_nick'];?></font>) : <?php echo $row['mb_recommend'];?></p>
													<p>
														<font color="#00C323"><?php if ($row['mb_openid']) {echo "微信分享";}?></font>
														<font color="#FF931A"><?php if ($row['mb_openid_app']) {echo " APP微信登陆绑定";}?></font>
													</p>
												</td>
												<td>
													<?php echo $row['mb_nick'];?>
												</td>
												<td>
													<?php echo $row['mb_time'];?>
												</td>
												<td class="admin_button">
													<a href="member_up.php?id=<?php echo $row['mb_id'];?>" target="_self">修改</a>
                                                    <?php 
                                                    if (strstr($admin_purview,"member_deletes")) {
                                                    ?>
													<a href="javascript:void(0);" onClick="member_del('<?php echo $row['mb_id'];?>')" target="_self">删除</a>
													<a href="javascript:void(0);" target="_self" onClick="member_agent('<?php echo $row['mb_phone'];?>','<?php echo $row['mb_level'];?>')">代理时间</a>
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
	<div class="member_agent_alt">
		<input type="text" name="member_agent_phone" value="" disabled>
		<input type="number" name="member_agent_price" value="" placeholder="充值">
		<select class="form-control" name="member_agent_level" style="width: 210px;">
			<option value="0">选择等级</option>
			<option value="5">区代理</option>
			<option value="6">时代理</option>
			<option value="7">省代理</option>
		</select>
		<input style="width: 48%!important; float: left!important; margin-right: 2%!important;" type="button" name="member_agent_button" value="确认">
		<input style="width: 48%!important; float: right!important; margin-left: 2%!important;" type="button" name="member_agent_off" value="取消">
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script type="text/javascript">
	function member_agent(mb_ag_phone,mb_levels) {
		$("[name='member_agent_phone']").val(mb_ag_phone);
		if (mb_levels == "5" || mb_levels == "6" || mb_levels == "7") {
			$("[name='member_agent_level']").val(mb_levels);
		} else {
			$("[name='member_agent_level']").val(0);
		}
		$(".member_agent_alt").css("display","block");
	}
		$("[name='member_agent_off']").click(function(){
			$(".member_agent_alt").css("display","none");
		})
		
		$(document).ready(function(){
			$("[name='member_agent_button']").click(function(){
				var mb_agent_phone = $("[name='member_agent_phone']").val();
				var mb_agent_price = $("[name='member_agent_price']").val();
				var mb_agent_level = $("[name='member_agent_level']").val();
				$.post("post/member_agent.php",
				  {
					mb_agent_phone:mb_agent_phone,
					mb_agent_price:mb_agent_price,
					mb_agent_level:mb_agent_level
				  },
				  function(data,status){
					console.log("Data: " + data + "\nStatus: " + status);
					if (data == "1") {
						$(".member_agent_alt").css("display","none");
						location.reload();
					}
					if (data == "2") {
						alert("您已经是代理。");
					}
				  });
			})
		});
		
		function member_del(mb_id){
			if(window.confirm('你确定要删除吗？')){
				$.post("post/member_del.php",
				  {
					member_id:mb_id
				  },
				  function(data,status){
					if(data == "1") {
						$("#member_"+mb_id).remove();
					}
				  });
				return true;
			} else {
				//alert("取消");
				return false;
			}
		}
	</script>
</body>

</html>