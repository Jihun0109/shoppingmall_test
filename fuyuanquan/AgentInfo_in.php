<?php
include( "../db_config.php" );
include( "admin_login.php" );
if (!strstr($admin_purview,"AgentInfo_in")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>代理金比例</title>
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
	<link rel="stylesheet" type="text/css" href="diyUpload/css/webuploader.css">
	<link rel="stylesheet" type="text/css" href="diyUpload/css/diyUpload.css">
	<link href="../umeditor/themes/default/css/umeditor.css" type="text/css" rel="stylesheet">
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
					<h3 class="page-title">代理金比例添加</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Input</h3>
								</div>
								<div class="panel-body">
									省代理:<input type="text" class="" placeholder="省代理" name="ai1" style="margin-bottom: 10px; width: 210px;">
                                    &nbsp;&nbsp;&nbsp;省代理人数:<input type="text" class="" placeholder="省代理人数" name="ai1_cnt" style="margin-bottom: 10px; width: 210px;">
                                </div>
                                <div class="panel-body">
									市代理:<input type="text" class="" placeholder="市代理" name="ai2" style="margin-bottom: 10px; width: 210px;">
                                    &nbsp;&nbsp;&nbsp;市代理人数:<input type="text" class="" placeholder="市代理人数" name="ai2_cnt" style="margin-bottom: 10px; width: 210px;">
                                </div>
                                <div class="panel-body">
									区代理:<input type="text" class="" placeholder="区代理" name="ai3" style="margin-bottom: 10px; width: 210px;">
                                    &nbsp;&nbsp;&nbsp;区代理人数:<input type="text" class="" placeholder="区代理人数" name="ai3_cnt" style="margin-bottom: 10px; width: 210px;">
                                </div>
                                <div class="panel-body">
									<div data-toggle="distpicker6" class="area_select" id="distpicker6">
										<div class="form-group">
											<label class="sr-only" for="province1">Province</label>
											<select class="form-control" id="province1" name="member_province1">
										</select>
										</div>
										<div class="form-group" style="display:none;">
											<label class="sr-only" for="city1">City</label>
											<select class="form-control" id="city1" name="member_city1">
										</select>
										</div>
										<div class="form-group" style="display:none;">
											<label class="sr-only" for="district1">District</label>
											<select class="form-control" id="district1" name="member_district1">
										</select>
										</div>
									</div>
									<br>
									<button type="button" class="btn btn-success" id="member_in">提交</button>

									<div class="err_msg"></div>
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
	<script src="js/distpicker.data.js"></script>
	<script src="js/distpicker.js"></script>
	<script src="js/main.js"></script>
	<script type="text/javascript">
		$( "#member_in" ).click( function () {
			var ai1 = $( "[name='ai1']" ).val();
			var ai2 = $( "[name='ai2']" ).val();
			var ai3 = $( "[name='ai3']" ).val();
			var ai1_cnt = $( "[name='ai1_cnt']" ).val();
			var ai2_cnt = $( "[name='ai2_cnt']" ).val();
			var ai3_cnt = $( "[name='ai3_cnt']" ).val();
			var ai_province = $( "[name='member_province1']" ).val();
			
			if ( !ai1 || !ai2 || !ai3 ) {
				$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
			} else {
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/agentinfo_in.php", {
						ai1: ai1,
						ai2: ai2,
						ai3: ai3,
						ai1_cnt: ai1_cnt,
						ai2_cnt: ai2_cnt,
						ai3_cnt: ai3_cnt,
						ai_province:ai_province
					},
					function ( data, status ) {
						if ( data == "1" ) {
							location.href = "AgentInfo_list.php";
						}
						if (data == "2") {
							alert("数据已存在");
							$("#member_in").removeAttr("disabled").text("提交");
						}
					} );
			}
		} )
$( document ).ready( function () {
	$( '#distpicker6' ).distpicker( {
		province: '吉林省',
		city: '延吉市',
		district: '河北区'
	} );
} );
	</script>
</body>

</html>