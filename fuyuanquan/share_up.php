<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"share_updates")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_GET['id'])) {
    $mid = $_GET['id'];
} else {
    exit();
}
$query = "SELECT * FROM fyq_member where mb_id = '{$mid}'";
if ( $result = mysqli_query( $mysqli, $query ) ) {
	$row = mysqli_fetch_assoc( $result );
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>修改会员</title>
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
					<h3 class="page-title">修改会员</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Update</h3>
								</div>
								<div class="panel-body">
									<input name="member_title" type="text" disabled class="form-control" placeholder="手机号" value="<?php echo $row['mb_phone'];?>">
									<input name="member_share" type="number" class="form-control" placeholder="当前股份:<?php echo $row['mb_share'];?>" value="">
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
<script type="text/javascript">
$( "#member_in" ).click( function () {
	var member_title = $( "[name='member_title']" ).val();
	var member_share = $( "[name='member_share']" ).val();
	if (!member_title || !member_share) {
		$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
	} else {
		$(this).attr("disabled", "disabled").text("提交中...").prepend('<i class="fa fa-spinner fa-spin"></i>');
		$.post( "post/share_update.php", {
				member_title: member_title,
				member_share: member_share,
				mb_id:"<?php echo $row['mb_id'];?>"
			},
			function ( data, status ) {
				if (data == "1") {
                    window.location.reload();
				}
			} );
	}
} )
</script>
</body>

</html>