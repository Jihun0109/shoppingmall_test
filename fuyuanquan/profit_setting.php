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
	$shared_count = 0;

	$queryAllSettings = "SELECT * FROM profit_setting";
	if ($result = mysqli_query($mysqli, $queryAllSettings))
	{
		while( $row = mysqli_fetch_assoc($result) )
		{
			if ($row['ps_level'] == 2)
				$shared_count++;
			array_push($arrSettings, $row);
		}
	}
	// array_push($arrSettings, array("ps_id" => 1, "ps_title" => "회사", "ps_type"=> "company", "ps_profit"=>0.1, "ps_enabled"=>1, "ps_deep"=>0));
	// array_push($arrSettings, array("ps_id" => 2, "ps_title" => "주주", "ps_type"=> "partner", "ps_profit"=>0.05, "ps_enabled"=>1, "ps_deep"=>0));
	// array_push($arrSettings, array("ps_id" => 3, "ps_title" => "대리", "ps_type"=> "agent", "ps_profit"=>0.1, "ps_enabled"=>1, "ps_deep"=>0));

	// array_push($arrSettings, array("ps_id" => 4, "ps_title" => "xyz 기금회사", "ps_type"=> "group_1", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));
	// array_push($arrSettings, array("ps_id" => 5, "ps_title" => "abc 모금 위원회", "ps_type"=> "group_2", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));
	// array_push($arrSettings, array("ps_id" => 6, "ps_title" => "나몰라 돈내라.", "ps_type"=> "group_3", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>1));

	// array_push($arrSettings, array("ps_id" => 7, "ps_title" => "1차 추천회원", "ps_type"=> "shared_1", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
	// array_push($arrSettings, array("ps_id" => 8, "ps_title" => "2차 추천회원", "ps_type"=> "shared_2", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
	// array_push($arrSettings, array("ps_id" => 9, "ps_title" => "3차 추천회원", "ps_type"=> "shared_3", "ps_profit"=>0.025, "ps_enabled"=>1, "ps_deep"=>2));
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
											if ($arrSettings[$i]['ps_level'] == 0){
									 ?>
										<div style="margin-bottom:8px;">
											<label for="" style="margin-right:10px;min-width:240px;text-align:center"><?php echo $arrSettings[$i]['ps_title'] ?></label>	
											<input type="number" name="se_keyword" 
												value="<?php echo $arrSettings[$i]['ps_profit']?>" step="0.001" placeholder=""
												style="padding-left:10px;">
											<button class="btn btn-primary" style="" onClick="onSaveClick(<?php echo $arrSettings[$i]['ps_id'];?>, this);">更新</button>
										</div>
									<?php 
										} 
									}?>

									<hr>
									<?php 
										for ($i=0; $i<count($arrSettings,0); $i++){
											if ($arrSettings[$i]['ps_level'] == 1){
									 ?>
										<div style="margin-bottom:8px;">
											<label for="" style="margin-right:10px;min-width:240px;text-align:center"><?php echo $arrSettings[$i]['ps_title'] ?></label>	
											<input type="number" name="se_keyword" 
												value="<?php echo $arrSettings[$i]['ps_profit']?>" step="0.001" placeholder=""
												style="padding-left:10px;">
											<button class="btn btn-primary" style="" onClick="onSaveClick(<?php echo $arrSettings[$i]['ps_id'];?>, this);">更新</button>
											<button class="btn btn-danger" style="" onClick="onDeleteClick(<?php echo $arrSettings[$i]['ps_id'];?>);">删除</button>
										</div>
									<?php 
										} 
									}?>

									<!-- insert new one -->
									<div style="margin-bottom:8px;">
										<!-- <div style="">
											<select placeholder="단위명을 입력하시오." style="margin-right:10px;min-width:240px;text-align:center;width:240px!important;">
												<option value="아동기금">아동기금</option>
											</select>
										</div> -->
										<input type="number" placeholder="전화번호를 입력하시오." style="margin-right:10px;min-width:240px;text-align:center;width:240px!important;">
										<input type="number" name="se_keyword" 
											value="" step="0.001" placeholder="0~1수를 입력"
											style="padding-left:10px;">
										<button class="btn btn-info" style="" onClick="onAddClick(1, this);">附加</button>										
									</div>
									<!-- insert new one -->
									<hr>
									<?php 
										for ($i=0; $i<count($arrSettings,0); $i++){
											if ($arrSettings[$i]['ps_level'] == 2){
												$shared_count --;
									 ?>
										<div style="margin-bottom:8px;">
											<label for="" style="margin-right:10px;min-width:240px;text-align:center"><?php echo $arrSettings[$i]['ps_title'] ?></label>	
											<input type="number" name="se_keyword" 
												value="<?php echo $arrSettings[$i]['ps_profit']?>" step="0.001" placeholder=""
												style="padding-left:10px;">
											<button class="btn btn-primary" style="" onClick="onSaveClick(<?php echo $arrSettings[$i]['ps_id'];?>, this);">更新</button>
											<?php 
											if ($shared_count == 0){
											?>
											<button class="btn btn-danger" style="" onClick="onDeleteClick(<?php echo $arrSettings[$i]['ps_id'];?>);">删除</button>
											<?php 
											} 
											?>
										</div>
									<?php 
										} 
									}?>
									<!-- insert new one -->
									<div style="margin-bottom:8px;">
										
										<input type="number" name="se_keyword" 
											value="" step="0.001" placeholder="0~1수를 입력"
											style="padding-left:10px;margin-left:254px;">
										<button class="btn btn-info" style="" onClick="onAddClick(2, this);">附加</button>
									</div>
									<!-- insert new one -->
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
		function onSaveClick(id, element) {

			var profit = $(element).prev().val();
			$.post("post/profit_setting_update.php",
				{
					ps_id:id,
					ps_profit:profit
				},
				function(data,status){
					if(data==1){
						location.reload();
					}
				});
		}

		function onDeleteClick(id) {
			if (confirm("정말 삭제하시겠습니까?")){
				$.post("post/profit_setting_delete.php",
					{
						ps_id:id
					},
					function(data,status){
						if(data==1){
							location.reload();
						}
					});
			}
		}

		function onAddClick(level, element) {

			var phone ="";
			if (level == 1)
				phone = $(element).prev().prev().val();
			var profit = $(element).prev().val();
			
			if (level == 1 && phone == ""){
				alert("전화번호를 입력하세요");
				$(element).prev().prev().focus();
				return;
			}
			if (profit == ""){
				alert("리윤률을 입력하세요.");
				$(element).prev().focus();
				return;
			}
			if (parseInt(profit) >= 1 || parseInt(profit) < 0){
				alert("리윤률은 0부터 1사이의 수자여야 합니다.");
				$(element).prev().focus();
				return;
			}
			
			$.post("post/profit_setting_add.php",
				{
					phonenumber:phone,
					ps_profit:profit,
					ps_level: level
				},
				function(data,status){
					if(data==1){
						// Success
						alert("성공");
						location.reload();
					} else if (data == 2){
						// 그런 사용자는 없습니다.
						alert("그런 사용자는 없습니다.");
					} else if (data == 0){
						alert("오유!");
					}
				});
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