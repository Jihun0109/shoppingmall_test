<?php
include( "../db_config.php" );
include( "admin_login.php" );
if (!strstr($admin_purview,"memo_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>信息添加</title>
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
					<h3 class="page-title">信息添加</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Input</h3>
								</div>
								<div class="panel-body">
									<input type="text" class="form-control" placeholder="标题" name="memo_title" style="margin-bottom: 10px; width: 650px;">
									<select class="form-control" name="memo_cate" style="margin-bottom: 10px; width: 650px;">
										<option value="10">公告</option>
										<option value="20">信息</option>
                                        <option value="30">帮助</option>
									</select>
									<textarea id="myEditor" name="memo_content" style="width:100%;height:300px;">这里写信息内容</textarea>
									<script type="text/plain" id="myEditor"></script>

									<br>
									<button type="button" class="btn btn-success" id="memo_in">提交</button>

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
	<!-- 百度编辑器 -->
	<script type="text/javascript" src="../umeditor/third-party/template.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="../umeditor/umeditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="../umeditor/umeditor.min.js"></script>
	<script type="text/javascript" src="../umeditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript">
		//实例化编辑器
		var um = UM.getEditor( 'myEditor' );
		um.addListener( 'blur', function () {
			$( '#focush2' ).html( '编辑器失去焦点了' )
		} );
		um.addListener( 'focus', function () {
			$( '#focush2' ).html( '' )
		} );
	</script>
	<script type="text/javascript">
		$( "#memo_in" ).click( function () {
			var memo_title = $( "[name='memo_title']" ).val();
			var memo_cate = $( "[name='memo_cate']" ).val();
			var memo_content = $( ".edui-body-container" ).html();
			if ( !memo_title || !memo_content ) {
				$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
			} else {
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/memo_in.php", {
						me_title: memo_title,
						me_cate: memo_cate,
						me_content: memo_content
					},
					function ( data, status ) {
						if ( data == "1" ) {
							location.href = "memo_list.php";
						}
					} );
			}
		} )
	</script>
</body>

</html>