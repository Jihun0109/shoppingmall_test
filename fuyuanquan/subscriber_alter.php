<?php
include( "../db_config.php" );
include("admin_login.php");
include( "teacher_function.php" );
$sort = @$_GET['sort'];
$tid = @$_GET[ 'id' ];
if ( !$tid ) {
	exit;
}
if ($sort == "teacher") {
	if (!strstr($admin_purview,"teacher_updates")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($sort == "busines") {
	if (!strstr($admin_purview,"busines_updates")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($sort == "college") {
	if (!strstr($admin_purview,"college_updates")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($sort == "partner") {
	if (!strstr($admin_purview,"partner_updates")) {
		echo "您没有权限访问此页";
		exit;
	}
}

$query = "SELECT * FROM teacher_list where tl_id = '{$tid}'";
if ( $result = mysqli_query( $mysqli, $query ) ) {
	$row = mysqli_fetch_assoc( $result );
	$college_count_class = $row['tl_class'];
}
//博客是否存在
$college_count = mysqli_query($mysqli, "SELECT count(*) FROM college_list where cl_class = '{$sort}' and cl_id = '{$college_count_class}'");
$college_rs = mysqli_fetch_array($college_count,MYSQLI_NUM);
$college_Number = $college_rs[0];
?>
<!doctype html>
<html lang="en">

<head>
	<title>修改内容</title>
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
					<h3 class="page-title">修改内容</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title">update</h3>
								</div>
								<div class="panel-body">
									<input type="text" class="form-control" placeholder="名称" name="commodity_title" value="<?php echo $row['tl_name'];?>">
									<div data-toggle="distpicker6" class="area_select" id="distpicker6">
										<div class="form-group">
											<label class="sr-only" for="province1">省</label>
											<select class="form-control" id="province1" name="commodity_province1">
										</select>
										</div>
										<div class="form-group">
											<label class="sr-only" for="city1">市</label>
											<select class="form-control" id="city1" name="commodity_city1">
										</select>
										</div>
										<div class="form-group">
											<label class="sr-only" for="district1">区</label>
											<select class="form-control" id="district1" name="commodity_district1">
										</select>
										</div>
									</div>
									<div style="float: left; margin-top: 10px; width: 100%;">
									<div class="input-group" style="width: 180px; float: left;">
										<span class="input-group-addon">价格￥</span>
										<input class="form-control" type="text" name="commodity_price" value="<?php echo $row['tl_price'];?>">
										<span class="input-group-addon">.00</span>
									</div>
									<div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<span class="input-group-addon">原价￥</span>
										<input class="form-control" type="text" name="commodity_original" value="<?php echo $row['tl_original'];?>" style="width: 80px;">
										<span class="input-group-addon">.00</span>
									</div>
									<div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<span class="input-group-addon">供货价格￥</span>
										<input class="form-control" type="text" name="commodity_supplyprice" value="<?php echo $row['tl_supplyprice'];?>" style="width: 80px;">
										<span class="input-group-addon">.00</span>
									</div>
                                    <div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<span class="input-group-addon">备用资金￥</span>
										<input class="form-control" type="text" name="commodity_spare" value="<?php echo $row['spare_gold'];?>" style="width: 80px;">
										<span class="input-group-addon">.00</span>
									</div>
										<div class="input-group" style="width: 180px; float: left;">
											<select class="form-control" name="commodity_display">
												<option value="1">显示</option>
												<option value="0">隐藏</option>
											</select>
										</div>
									</div>
									<div style="float: left; width: 100%; margin-top: 10px;">
									<div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<span class="input-group-addon">幸福豆</span>
										<input class="form-control" type="text" name="commodity_point" value="<?php echo $row['tl_point_commodity'];?>" style="width: 80px;">
										<span class="input-group-addon">个</span>
									</div>
                                    <div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<span class="input-group-addon">粘豆</span>
										<input class="form-control" type="text" name="nd_point" value="<?php echo $row['nd_point'];?>" style="width: 80px;">
										<span class="input-group-addon">个</span>
									</div>
									<div class="input-group" style="width: 180px; float: left; margin-right: 10px;">
										<select class="form-control" name="commodity_point_type">
											<option value="0">现金</option>
											<option value="1">幸福豆</option>
											<!--<option value="2">幸福豆➕现金</option>-->
											<option value="3">打折区</option>
                                            <option value="4">会员卡</option>
										</select>
									</div>
									<div class="input-group" style="width: 160px; float: left; margin-right: 10px;">
										<span class="input-group-addon">推荐顺序</span>
										<input class="form-control" type="text" name="commodity_array" value="<?php echo $row['item_array'];?>" style="width: 80px;">
									</div>
										<div class="input-group" style="width: 160px; float: left;">
										<span class="input-group-addon">首页顺序</span>
										<input class="form-control" type="text" name="commodity_index" value="<?php echo $row['index_hot'];?>" style="width: 80px;">
									</div>
									</div>
									<div style="float: left; width: 100%; margin-top: 10px;">
										<div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
											<span class="input-group-addon">坐标 X</span>
											<input class="form-control" type="text" name="commodity_gpsx" value="<?php echo $row['GPS_X'];?>" style="width: 142px;">
										</div>
										<div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
											<span class="input-group-addon">坐标 Y</span>
											<input class="form-control" type="text" name="commodity_gpsy" value="<?php echo $row['GPS_Y'];?>" style="width: 142px;">
										</div>
                                        <div class="input-group" style="width: 307px; float: left; margin-right: 10px;">
											<span class="input-group-addon">推荐此商家手机号</span>
											<input class="form-control" type="text" name="commodity_recommend" value="<?php echo $row['item_recommend'];?>" placeholder="设置后无法修改(必填)" style="width: 170px;"<?php if ($row['item_recommend']) {echo " disabled";}?>>
										</div>
									</div>
									<?php 
									include("distribution.php");
									?>
									<div class="input-group" style="width: 100%; float: left; margin-top: 10px; margin-bottom: 10px;">
									<div style="max-width: 650px;">
										<span class="input-group-addon" style="text-align: left; background-color: #dff0d8;">获取此产品分销权</span>
										<select class="form-control" name="commodity_distribution_level">
											<option value="0.00">无分销</option>
											<option value="1980.00">1980经纪人分销权</option>
											<option value="9800.00">9800合伙人权</option>
										</select>
										</div>
									</div>
                                    <div class="input-group" style="width: 300px; float: left;">
										<span class="input-group-addon">老师手机账号</span>
										<input class="form-control" type="text" name="commodity_phone" value="<?php echo $row['tl_phone'];?>">
									</div>
                                    <div class="input-group" style="width: 100%; float: left; margin-top: 5px; margin-bottom: 10px;">
										<span class="input-group-addon">接收订单推送</span>
										<input class="form-control" type="text" name="commodity_pushmsg" value="<?php echo $row['pushmsg_id'];?>">
									</div>
									<?php 
										include("commodity_cate.php");
									?>
									
									<div style="float: left; width: 100%; margin-bottom: 10px;">
									<label>选择列表图片</label>
									<input type="file" name="file1" class="inputfile">
									<span class="loading_upfile"><img src="../img/loding.gif" alt="加载中"></span>
									<div id="feedback"><img src="<?php echo $row['tc_mainimg'];?>" alt="">
									</div>
									</div>
									<textarea class="form-control" placeholder="简介" rows="4" name="commodity_summary"><?php echo $row['tl_summary'];?></textarea>
									<div class="commodity_in_pic">
										<?php 
										$pic_str = $row['tl_pictures'];
										$pic_num = (explode("|",$pic_str));
										$pic_length = count($pic_num);
										for($x=0;$x<$pic_length;$x++)
										   {
									?>
										<div><img src="<?php echo $pic_num[$x];?>" alt="">
											<span class="lnr lnr-trash"></span>
										</div>
										<?php 
										}
									?>
									</div>
									<div id="commodity_pic"></div>
									<textarea id="myEditor" name="commodity_content" style="width:100%;height:300px;">
										<?php echo $row['tl_detailed'];?>
									</textarea>
									<script type="text/plain" id="myEditor"></script>
									<button type="button" class="btn btn-success" id="commodity_in">提交</button>
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
	<script type="text/javascript" src="diyUpload/js/webuploader.html5only.min.js"></script>
	<script type="text/javascript" src="diyUpload/js/diyUpload.js"></script>
	<!-- 百度编辑器 -->
	<script type="text/javascript" src="../umeditor/third-party/template.min.js"></script>
	<script type="text/javascript" charset="utf-8" src="../umeditor/umeditor.config.js"></script>
	<script type="text/javascript" charset="utf-8" src="../umeditor/umeditor.min.js"></script>
	<script type="text/javascript" src="../umeditor/lang/zh-cn/zh-cn.js"></script>
	<script type="text/javascript">
	$( document ).ready( function () {
			//响应文件添加成功事件
			$( ".inputfile" ).change( function () {
				var onfiles = $( this ).attr( "class" );
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
					url: '../submit_img.php?imgtype=702_200&file_name=' + file1,
					type: 'POST',
					data: data,
					cache: false,
					contentType: false, //不可缺参数
					processData: false, //不可缺参数
					success: function ( data ) {
						$( "#feedback" ).html( '<img src="../upload/compress/' + data + '" alt="">' );
						console.log( onfiles );
						//$("#imgId").attr('src',data); 
						$( ".loading_upfile" ).hide(); //加载成功移除加载图片
					},
					error: function () {
						alert( '上传出错' );
						$( ".loading_upfile" ).hide(); //加载失败移除加载图片
					}
				} );
			} );
		} );
		/*
		 * 服务器地址,成功返回,失败返回参数格式依照jquery.ajax习惯;
		 * 其他参数同WebUploader
		 */
		$('#commodity_pic').diyUpload( {
			url: '../img_upload_many.php',
			success: function ( data ) {
				$(".commodity_in_pic" ).append('<div><img src="../upload/compress/' + data._raw + '" alt=\"\"></div>' );
				$(".parentFileBox li").fadeOut(500,function(){
					$(this).remove();
				} );
			},
			error: function ( err ) {
				console.info( err );
			},
			buttonText: '缩略图片上传',
			chunked: true,
			// 分片大小
			chunkSize: 512 * 1024,
			//最大上传的文件数量, 总文件大小,单个文件大小(单位字节);
			fileNumLimit: 50,
			fileSizeLimit: 500000 * 1024,
			fileSingleSizeLimit: 50000 * 1024,
			accept: {}
		} );
	</script>

	<script type="text/javascript">
		//实例化编辑器
		var um = UM.getEditor('myEditor');
		um.addListener('blur', function () {
			$('#focush2').html('编辑器失去焦点了')
		} );
		um.addListener('focus',function(){
			$('#focush2').html('')
		} );
	</script>
	<script type="text/javascript">
		$(".commodity_in_pic span").click(function(){
			$(this).parent().remove();
		})
		$("#commodity_in").click(function(){
			var parentFileBox = "";
			$(".commodity_in_pic img").each(function(index,element) {
				parentFileBox += $(".commodity_in_pic img:eq("+index+")").attr("src")+"|";

			} );
			var commodity_title = $("[name='commodity_title']").val();
			var commodity_province1 = $("[name='commodity_province1']").val();
			var commodity_city1 = $("[name='commodity_city1']").val();
			var commodity_district1 = $("[name='commodity_district1']").val();
			var commodity_price = $("[name='commodity_price']").val();
			var commodity_original = $("[name='commodity_original']").val();
			var commodity_supplyprice = $("[name='commodity_supplyprice']").val();
            var commodity_spare = $("[name='commodity_spare']").val();
			var commodity_point = $("[name='commodity_point']").val();
			var commodity_point_type = $("[name='commodity_point_type']").val();
			var commodity_array = $("[name='commodity_array']").val();
			var commodity_cate = $("[name='commodity_cate']").val();
            var commodity_vpoint = $( "[name='commodity_vpoint']" ).val();
			var commodity_display = $( "[name='commodity_display']" ).val();
			var commodity_gpsx = $( "[name='commodity_gpsx']" ).val();
			var commodity_gpsy = $( "[name='commodity_gpsy']" ).val();
            var commodity_recommend = $( "[name='commodity_recommend']" ).val();
			var commodity_distribution_level = $("[name='commodity_distribution_level']").val();
			if ($("[name='commodity_class']").length>0) {
				var commodity_class = $("[name='commodity_class']").val();
			} else {
				var commodity_class = "<?php echo $row['tl_class'];?>";
			}
			var commodity_phone = $("[name='commodity_phone']").val();
            var commodity_pushmsg = $( "[name='commodity_pushmsg']" ).val();
			var commodity_summary = $("[name='commodity_summary']").val();
			var commodity_content = $(".edui-body-container").html();
			var commodity_mainimg = $("#feedback img").attr("src");
			var commodity_index = $("[name='commodity_index']").val();
			var vip1level_1 = $("[name='vip1level_1']").val();
			var vip1level_2 = $("[name='vip1level_2']").val();
			var vip1level_3 = $("[name='vip1level_3']").val();
			var vip2level_1 = $("[name='vip2level_1']").val();
			var vip2level_2 = $("[name='vip2level_2']").val();
			var vip2level_3 = $("[name='vip2level_3']").val();
			var vip1point_1 = $( "[name='vip1point_1']" ).val();
			var vip1point_2 = $( "[name='vip1point_2']" ).val();
			var vip1point_3 = $( "[name='vip1point_3']" ).val();
			var vip2point_1 = $( "[name='vip2point_1']" ).val();
			var vip2point_2 = $( "[name='vip2point_2']" ).val();
			var vip2point_3 = $( "[name='vip2point_3']" ).val();
			if (!commodity_title || !commodity_province1 || !commodity_city1 || !commodity_price || !commodity_cate || !commodity_summary || !commodity_content || !parentFileBox ) {
				$(".err_msg").html("<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 内容填写不完整!</div>");
			} else {
				$(this).attr("disabled", "disabled").text("提交中...").prepend('<i class="fa fa-spinner fa-spin"></i>');
				$.post("post/commodity_alter_post.php", {
						com_title: commodity_title,
						com_province1: commodity_province1,
						com_city1: commodity_city1,
						com_district1: commodity_district1,
						com_price: commodity_price,
						com_original:commodity_original,
						com_supplyprice:commodity_supplyprice,
                        com_spare:commodity_spare,
						com_point:commodity_point,
						com_point_type:commodity_point_type,
						com_array:commodity_array,
						com_cate: commodity_cate,
                        com_vpoint: commodity_vpoint,
						com_display:commodity_display,
						com_gpsx:commodity_gpsx,
						com_gpsy:commodity_gpsy,
                        com_recommend:commodity_recommend,
						com_distribution_level:commodity_distribution_level,
						com_class:commodity_class,
						com_phone:commodity_phone,
                        com_pushmsg: commodity_pushmsg,
						com_summary: commodity_summary,
						com_content: commodity_content,
						com_parentFileBox: parentFileBox,
						com_mainimg: commodity_mainimg,
						com_index:commodity_index,
						vip1level1: vip1level_1,
						vip1level2: vip1level_2,
						vip1level3: vip1level_3,
						vip2level1: vip2level_1,
						vip2level2: vip2level_2,
						vip2level3: vip2level_3,
						vip1point1: vip1point_1,
						vip1point2: vip1point_2,
						vip1point3: vip1point_3,
						vip2point1: vip2point_1,
						vip2point2: vip2point_2,
						vip2point3: vip2point_3,
						up_id: <?php echo $row['tl_id'];?>,
						com_sort:'<?php echo $sort;?>'
				},
					function (data, status){
						if (data == "1"){
							<?php 
							if ($college_Number) {
							?>
							location.href = "commodity_list.php?sort=<?php echo $row['shop_menu'];?>&i_class=<?php echo $row['tl_class'];?>";
							<?php 
							} else {
							?>
							location.href = "commodity_list.php?sort=<?php echo $row['shop_menu'];?>";
							<?php 
							}
							?>
						}
						if (data == "2"){
							location.href = "subscriber_list.php";
						}
					} );
			}
		} )

		$(function(){
			$('#distpicker6').distpicker({
				province:'<?php echo $row['tc_province1'];?>',
				city:'<?php echo $row['tc_city1'];?>',
				district:'<?php echo $row['tl_district1'];?>'
			});
			$("[name='commodity_cate']").val("<?php echo $row['tl_cate'];?>");
			$("[name='commodity_display']").val("<?php echo $row['item_display'];?>");
			$("[name='commodity_distribution_level']").val("<?php echo $row['tl_distribution'];?>");
			$("[name='commodity_point_type']").val("<?php echo $row['tl_point_type'];?>");
			if ($("[name='commodity_class']").length>0) {
				$("[name='commodity_class']").val("<?php echo $row['tl_class'];?>");
			}
		} );
	</script>
</body>

</html>