<?php
include( "../db_config.php" );
include( "admin_login.php" );
if (!strstr($admin_purview,"member_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>会员添加</title>
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
					<h3 class="page-title">会员添加</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Input</h3>
								</div>
								<div class="panel-body">
									<input type="number" class="form-control" placeholder="手机号" name="member_phone" style="margin-bottom: 10px; width: 210px;">
									<input type="number" class="form-control" placeholder="推荐人手机号" name="member_recommend" style="margin-bottom: 10px; width: 210px;">
									<input type="text" class="form-control" placeholder="名称" name="member_nick" style="margin-bottom: 10px; width: 210px;">
									<select class="form-control" name="member_level" style="width: 210px;">
										<option value="">会员等级</option>
                                        <?php 
                                        if (strstr($admin_purview,"member_level1")) {
                                        ?>
										<option value="1">普通会员</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level2")) {
                                        ?>
										<option value="2">年卡会员</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level3")) {
                                        ?>
										<option value="3">经纪人</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level4")) {
                                        ?>
										<option value="4">合伙人</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level5")) {
                                        ?>
										<option value="5">区代理</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level6")) {
                                        ?>
										<option value="6">市代理</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level7")) {
                                        ?>
										<option value="7">省代理</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level18")) {
                                        ?>
										<option value="18">商户</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level19")) {
                                        ?>
										<option value="19">准股东</option>
                                        <?php 
                                        }
                                        ?>
                                        <?php 
                                        if (strstr($admin_purview,"member_level20")) {
                                        ?>
										<option value="20">股东</option>
                                        <?php 
                                        }
                                        ?>
									</select>
									<div data-toggle="distpicker6" class="area_select" id="distpicker6">
										<div class="form-group">
											<label class="sr-only" for="province1">Province</label>
											<select class="form-control" id="province1" name="member_province1">
										</select>
										</div>
										<div class="form-group">
											<label class="sr-only" for="city1">City</label>
											<select class="form-control" id="city1" name="member_city1">
										</select>
										</div>
										<div class="form-group">
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
			var member_phone = $( "[name='member_phone']" ).val();
			var member_recommend = $( "[name='member_recommend']" ).val();
			var member_nick = $( "[name='member_nick']" ).val();
			var member_level = $( "[name='member_level']" ).val();
			var member_province1 = $( "[name='member_province1']" ).val();
			var member_city1 = $( "[name='member_city1']" ).val();
			var member_district1 = $( "[name='member_district1']" ).val();
			
			if ( !member_phone || !member_nick || !member_level ) {
				$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
			} else {
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/member_in.php", {
						member_phone: member_phone,
						member_recommend: member_recommend,
						member_nick: member_nick,
						member_level:member_level,
						member_province1:member_province1,
						member_city1:member_city1,
						member_district1:member_district1
					},
					function ( data, status ) {
						if ( data == "1" ) {
							location.href = "member_list.php";
						}
						if (data == "2") {
							alert("会员已存在");
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