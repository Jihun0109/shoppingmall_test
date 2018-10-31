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
	<title>리윤분배설정</title>
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
<?php 
	$arrSettings = [];
	array_push($arrSettings, array("ps_id" => 1, "ps_title" => "회사", "ps_type"=> "company", "ps_profit"=>0.1, "ps_enabled"=>1, "ps_deep"=>0));
	array_push($arrSettings, array("ps_id" => 2, "ps_title" => "주주", "ps_type"=> "partner", "ps_profit"=>0.05, "ps_enabled"=>1, "ps_deep"=>0));
	array_push($arrSettings, array("ps_id" => 3, "ps_title" => "대리", "ps_type"=> "agent", "ps_profit"=>0.1, "ps_enabled"=>1, "ps_deep"=>0));

	array_push($arrSettings, array("ps_id" => 4, "ps_title" => "xyz 기금회사", "ps_type"=> "group_1", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));
	array_push($arrSettings, array("ps_id" => 5, "ps_title" => "abc 모금 위원회", "ps_type"=> "group_2", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));
	array_push($arrSettings, array("ps_id" => 6, "ps_title" => "나몰라 돈내라.", "ps_type"=> "group_3", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));

	array_push($arrSettings, array("ps_id" => 7, "ps_title" => "1차 추천회원", "ps_type"=> "shared_1", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
	array_push($arrSettings, array("ps_id" => 8, "ps_title" => "2차 추천회원", "ps_type"=> "shared_2", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
	array_push($arrSettings, array("ps_id" => 9, "ps_title" => "3차 추천회원", "ps_type"=> "shared_3", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
 ?>
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
					
					</div>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									heading
								</div>
								<div class="panel-body">
									<?php 
										for ($i=0; $i<count($arrSettings,0); $i++){
									 ?>
										<div>
											<label for="" style="margin-right:0.34rem;min-width:240px;text-align:center"><?php echo $arrSettings[$i]['ps_title'] ?></label>	
											<input type="number" name="se_keyword" 
												value="<?php echo $arrSettings[$i]['ps_profit']?>" step="0.001" placeholder=""
												style="padding-left:10px;">
											<input type="submit" value="搜索" class="btn btn-primary">
										</div>
									<?php } ?>
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