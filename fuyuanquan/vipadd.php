<?php
include( "../db_config.php" );
include( "admin_login.php" );
if (!strstr($admin_purview,"vipcard")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>VIP会员添加</title>
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
					<h3 class="page-title">VIP会员添加</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Input</h3>
								</div>
								<div class="panel-body">
									<input type="text" class="form-control" placeholder="手机号" name="user_phone" style="margin-bottom: 10px; width: 650px;">
									<select class="form-control" name="vipitem" style="margin-bottom: 10px; width: 650px;">
                                    <?php 
                                    $query = "SELECT * FROM teacher_list where tl_phone = '{$admin_level}' and shop_menu = 'partner'";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){    
                                    ?>
										<option value="<?php echo $row['tl_id'];?>"><?php echo $row['tl_name'];?></option>
                                    <?php 
                                            }
                                        }
                                    ?>
									</select>
									
									<button type="button" class="btn btn-success" id="vipcardadd">提交</button>

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
		$( "#vipcardadd" ).click( function () {
			var user_phone = $( "[name='user_phone']" ).val();
			var vipitem = $( "[name='vipitem']" ).val();
			if ( !user_phone || !vipitem ) {
				$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
			} else {
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/vipcardad.php", {
						user_phone: user_phone,
						vipitem: vipitem
					},
					function ( data, status ) {
						if ( data == "1" ) {
							location.href = "vipcard.php";
						}
					} );
			}
		} )
	</script>
</body>

</html>