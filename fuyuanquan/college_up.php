<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"college_updates")) {
	echo "您没有权限访问此页";
	exit;
}
$bid = @$_GET[ 'id' ];
if ( !$bid ) {
	exit;
}
$query = "SELECT * FROM college_list where cl_id = '{$bid}' and cl_class = 'college'";
if ( $result = mysqli_query( $mysqli, $query ) ) {
	$row = mysqli_fetch_assoc( $result );
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>学院修改</title>
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
					<h3 class="page-title">学院修改</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">Input</h3>
								</div>
								<div class="panel-body">
									<input type="text" class="form-control" placeholder="学院名称" name="college_title" value="<?php echo $row['cl_name'];?>">
									<div data-toggle="distpicker6" class="area_select" id="distpicker6">
										<div class="form-group">
											<label class="sr-only" for="province1">Province</label>
											<select class="form-control" id="province1" name="college_province1">
										</select>
										</div>
										<div class="form-group">
											<label class="sr-only" for="city1">City</label>
											<select class="form-control" id="city1" name="college_city1">
										</select>
										</div>
										<div class="form-group">
											<label class="sr-only" for="district1">District</label>
											<select class="form-control" id="district1" name="college_district1">
										</select>
										</div>
									</div>

									<br>
									<select class="form-control" name="college_cate">
										<option value="">分类</option>
										<option value="10">其他</option>
									</select>

									<br>
									<br>
									<label>上传学院LOGO(186*106)</label>
									<input type="file" name="file1" class="inputfile">
									<div id="feedback" class="college_logo">
									<img src="<?php echo $row['cl_logo'];?>" alt="">
									</div>
									<br>
									<label>上传学院背景(750*350)</label>
									<input type="file" name="file1" class="inputfile">
									
									<div id="feedback" class="college_bg">
									<img src="<?php echo $row['cl_bg'];?>" alt="">
									</div>
									<span class="loading_upfile"><img src="../img/loding.gif" alt="加载中"></span>
									<br>
									<button type="button" class="btn btn-success" id="college_in">提交</button>

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
$( "#college_in" ).click( function () {
	var college_title = $( "[name='college_title']" ).val();
	var college_province1 = $( "[name='college_province1']" ).val();
	var college_city1 = $( "[name='college_city1']" ).val();
	var college_district1 = $( "[name='college_district1']" ).val();
	var college_cate = $( "[name='college_cate']" ).val();
	var college_logo = $(".college_logo img").attr("src");
	var college_bg = $(".college_bg img").attr("src");
	if ( !college_title || !college_province1 || !college_city1 || !college_cate ) {
		$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>" );
	} else {
		$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
		$.post( "post/college_up.php", {
				cs_title: college_title,
				cs_province1: college_province1,
				cs_city1: college_city1,
				cs_district1: college_district1,
				cs_cate: college_cate,
				cs_logo:college_logo,
				cs_bg:college_bg,
				up_id:"<?php echo $row['cl_id'];?>"
			},
			function ( data, status ) {
				if ( data == "1" ) {
					console.log(data);
					location.href = "college_list.php";
				}
			} );
	}
} )
</script>
<!-- 响应返回数据容器 -->
<script type="text/javascript">
	$( document ).ready( function () {
		//响应文件添加成功事件
		$( ".inputfile" ).change( function () {
			var onfiles = $( this ).attr( "class" );
			var onfiles_next = $(this).next();
			var	onfile_class = onfiles_next.attr("class");
			if (onfile_class == "college_logo") {
				var imgtype = "186_106";
			}
			if (onfile_class == "college_bg") {
				var imgtype = "750_350";
			}
			//创建FormData对象
			var data = new FormData();
			//为FormData对象添加数据
			$.each( $( this )[ 0 ].files, function ( i, file ) {
				data.append( 'upload_file' + i, file );
			} );
			$( ".loading_upfile" ).show(); //显示加载图片
			//发送数据
			var file1 = $( "input:file" ).prop( "name" );
			$.ajax( {
				url: '../submit_img.php?imgtype='+imgtype+'&file_name=' + file1,
				type: 'POST',
				data: data,
				cache: false,
				contentType: false, //不可缺参数
				processData: false, //不可缺参数
				success: function ( data ) {
					$(onfiles_next).html('<img src="../upload/compress/' + data + '" alt="">');
					$( ".loading_upfile" ).hide(); //加载成功移除加载图片
				},
				error: function () {
					alert( '上传出错' );
					$( ".loading_upfile" ).hide(); //加载失败移除加载图片
				}
			} );
		} );
		
		$( '#distpicker6' ).distpicker( {
			province: '<?php echo $row['cl_province'];?>',
			city: '<?php echo $row['cl_city'];?>',
			district: '<?php echo $row['cl_area'];?>'
		} );
		$( "[name='college_cate']" ).val( "<?php echo $row['cl_cate'];?>" );
	} );
</script>
</body>

</html>