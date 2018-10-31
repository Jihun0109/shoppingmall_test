<?php
include( "../db_config.php" );
session_start();
if (isset($_SESSION['agent'])) {
    $agent_id = $_SESSION['agent']; 
} else {
    $agent_id = '';
}

if (!$agent_id) {
	exit;
}
include("../include/member_level.php");

$query_agent = "SELECT * FROM admin_agent where ag_phone = '{$agent_id}'";
if ($result_agent = mysqli_query($mysqli, $query_agent))
{
	$row_agent = mysqli_fetch_assoc($result_agent);
	$ag_balance = $row_agent['ag_balance'];
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>会员列表</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="../fuyuanquan/assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="../fuyuanquan/assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../fuyuanquan/assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="../fuyuanquan/assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="../fuyuanquan/assets/css/demo.css">
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
					<h3 class="page-title">我的会员 <font color="#FF6D9F">我的代理余额 ￥<?php echo number_format($ag_balance,2);?></font></h3>
                    <div class="search_member">
					<form action="member_list.php" method="get">
						<input type="text" name="se_keyword" value="" placeholder="请输入手机号码">
						<input type="submit" value="搜索">
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
												<th>注册时间</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
								<?php 
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
                                        $se_keyword = @$_GET['se_keyword'];
                                        if ($se_keyword) {
                                            $keword_sql = " and mb_phone like '%{$se_keyword}%'";
                                        } else {
                                            $keword_sql = "";
                                        }
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_recommend = '{$agent_id}'{$keword_sql}");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM fyq_member where mb_recommend = '{$agent_id}'{$keword_sql} ORDER BY mb_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){		
										?>
											<tr>
												<td>
													<?php echo $row['mb_id'];?>
												</td>
												<td>
													<?php echo $row['mb_phone'];?>(<?php echo member_level($row['mb_level']);?>)
												</td>
												<td>
													<?php echo $row['mb_nick'];?>
												</td>
												<td>
													<?php echo $row['mb_time'];?>
												</td>
												<td class="admin_button"><span onClick="member_agent('<?php echo $row['mb_phone'];?>','<?php echo $row['mb_level'];?>')">修改等级</span></td>
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
	<div class="member_agent_alt">
		<input type="text" name="member_agent_phone" value="" disabled>
		<select class="form-control" name="member_agent_level" style="width: 210px;">
			<option value="0">选择等级</option>
			<?php /*?><option value="3">经纪人</option><?php */?>
			<option value="4">合伙人</option>
		</select>
		<input style="width: 48%!important; float: left!important; margin-right: 2%!important;" type="button" name="member_agent_button" value="确认">
		<input style="width: 48%!important; float: right!important; margin-left: 2%!important;" type="button" name="member_agent_off" value="关闭">
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="../fuyuanquan/assets/vendor/jquery/jquery.min.js"></script>
	<script src="../fuyuanquan/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="../fuyuanquan/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="../fuyuanquan/assets/scripts/klorofil-common.js"></script>
	<script type="text/javascript">
	function member_agent(mb_ag_phone,mb_levels) {
		$("[name='member_agent_phone']").val(mb_ag_phone);
		if (mb_levels == "3" || mb_levels == "4") {
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
				var mb_agent_level = $("[name='member_agent_level']").val();
				$.post("post/agent_level.php",
				  {
					mb_agent_phone:mb_agent_phone,
					mb_agent_level:mb_agent_level
				  },
				  function(data,status){
					if (data == "1") {
						$(".member_agent_alt").css("display","none");
						location.reload();
					}
					if (data == "2") {
						alert("当前会员等级无法升级");
					}
					if (data == "5") {
						alert("您的余额不够操作失败");
					}
				  });
			})
		});
	</script>
</body>

</html>