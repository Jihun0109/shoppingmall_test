<?php
include( "../db_config.php" );
include("admin_login.php");

$i_class = '0';
$sort = 'partner';

if (!$sort) {
	exit();
}
if ($sort == "partner") {
	if (!strstr($admin_purview,"subscriber_list")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($sort == "partner") {
	if (!strstr($admin_purview,"partner_list")) {
		echo "您没有权限访问此页";
		exit;
	}
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>爆品列表</title>
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
    <style type="text/css">
        .commodity_keyword {
            position: fixed;
            top: 20%;
            background-color: #000000c7;
            width: 600px;
            left: 0px;
            right: 0px;
            margin: 0 auto;
            padding: 10px;
            border-radius: 5px;
            display: none;
        }
        .commodity_keyword input {
            margin-left: 5px;
            padding-left: 5px;
            padding-right: 5px;
            height: 36px;
            border-radius: 3px;
            border: 2px solid #9E9E9E;
        }
        .commodity_keyword_off {
            text-align: center;
            margin-top: 10px;
        }
        .commodity_keyword_off input {
            width: 100px;
            height: 32px;
        }
    </style>
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
					<h3 class="page-title">爆品列表</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">
									<h3 class="panel-title"><a href="subscriber_add.php?sort=partner&i_class=0" target="_self">添加</a></h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>名称</th>
												<th>地区</th>
												<th>分类</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
										<?php 
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
										$i_class_sql = " and tl_class = '0'";
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM teacher_list where shop_menu = 'partner'{$i_class_sql}");// and item_admin = '{$admin_level}'
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM teacher_list where shop_menu = 'partner'{$i_class_sql} ORDER BY tl_id desc limit {$startCount},{$perNumber}";//and item_admin = '{$admin_level}'//管理员上传的讲课,现在全部显示
										
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){		
										?>
											<tr id="commodity_<?php echo $row['tl_id'];?>">
												<td>
													<?php echo $row['tl_id'];?>
												</td>
												<td>
													<?php if ($row['tc_mainimg']) {?><p><img src="<?php echo $row['tc_mainimg'];?>" alt="" style="width: 200px; height: 57px;"></p><?php }?>
													<p><?php echo $row['tl_name'];?></p>
												</td>
												<td>
													<?php echo $row['tc_province1'].$row['tc_city1'].$row['tl_district1'];?>
												</td>
												<td>
													
												</td>
												<td class="admin_operate">
												<a href="subscriber_alter.php?sort=<?php echo $row['shop_menu'];?>&id=<?php echo $row['tl_id'];?>" target="_self">修改</a>
												<span onClick="commodity_del('<?php echo $row['tl_id'];?>')">删除</span>
												<?php 
												if ($row['tl_point_type'] == "3") {
												?>
												<span style="background-color: #4CAF50;" onClick="commodity_qrcode('<?php echo $row['tl_id'];?>','<?php echo $row['tc_mainimg'];?>')">收款二维码</span>
												<?php 
												}
												?>
                                                <span style="background-color: #ff5722;" onClick="commodity_keyword('<?php echo $row['tl_id'];?>')">搜索关键词</span>
												</td>
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
										<a href="?page=1<?php if ($sort) {echo '&sort='.$sort;}?><?php if ($i_class) {echo '&i_class='.$i_class;}?>">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?><?php if ($sort) {echo '&sort='.$sort;}?><?php if ($i_class) {echo '&i_class='.$i_class;}?>">&lt;</a>
										<?php
                                        }
                                        ?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?><?php if ($sort) {echo '&sort='.$sort;}?><?php if ($i_class) {echo '&i_class='.$i_class;}?>"><?php echo $i;?></a>
                                        <?php
                                        }
                                        ?>
                                        <?php
                                        if ( $imax < $max_page ) {
                                            ?>
                                        <a href="?page=<?php echo ($imax + 1);?><?php if ($sort) {echo '&sort='.$sort;}?><?php if ($i_class) {echo '&i_class='.$i_class;}?>">&gt;</a> <a href="?page=<?php echo $max_page;?><?php if ($sort) {echo '&sort='.$sort;}?><?php if ($i_class) {echo '&i_class='.$i_class;}?>">&gt;&gt;</a>
								        <?php
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
	<div id="commodity_qrcode_img">
		<span>关闭</span>
	</div>
    <div class="commodity_keyword">
        <input type="hidden" name="keyword_item" value="">
        <input type="text" name="keyword_list" value="" placeholder="请输入关键词(列: 粘糕,福源泉)" style="width: 500px;">
        <input type="button" name="keyword_button" value="提交" style="width: 66px;">
        <div class="commodity_keyword_off"><input type="button" value="关闭"></div>
    </div>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
	<script src="http://localhost/js/jquery.qrcode.min.js"></script>
	<script type="text/javascript">
		function commodity_del(del_id) {
			 if(confirm("确定要删除数据吗?")){
				$.post("post/commodity_del.php",
				  {
					commoditydel_id:del_id
				  },
				  function(data,status){
					if (data) {
						$("#commodity_"+del_id).remove();
					}
				  });
			 }else{
				 console.log("取消删除");
			 }
			
		}
		function commodity_qrcode(qrcode_id,logoimg) {
			if ($("#commodity_qrcode_img canvas").length) {
				return false;
			} else {
				$('#commodity_qrcode_img').qrcode({
					text: "http://localhost/scan_pay.php?bid="+qrcode_id,
					height: 500,
					width: 500,
					src: logoimg
				})
				$("#commodity_qrcode_img").css("display","block");
			}
		}
		
		$(document).ready(function(){
			$("#commodity_qrcode_img span").click(function(){
				$("#commodity_qrcode_img").css("display","none");
				$("#commodity_qrcode_img img").remove();
				$("#commodity_qrcode_img canvas").remove();
			})
		});
        
        function commodity_keyword(key_id) {
            $(".commodity_keyword").css("display","block");
            $.post("post/keywrod_item.php",
              {
                item_id:key_id
              },
              function(data,status){
                console.log(key_id);
                
                $(".commodity_keyword [name='keyword_item']").val(key_id);
                $(".commodity_keyword [name='keyword_list']").val(data);
              });
        }
        $(document).ready(function(){
            $(".commodity_keyword [name='keyword_button']").click(function(){
                var keyword = $(".commodity_keyword [name='keyword_list']").val();
                var item_id = $(".commodity_keyword [name='keyword_item']").val();
                console.log(item_id);
                
                $.post("post/keywrod_list.php",
                  {
                    item_id:item_id,
                    keyword:keyword
                  },
                  function(data,status){
                    if (data == '1') {
                        alert("关键词更新成功");
                    } else if (data == '0') {
                        alert("请重新设置");
                    }
                  });
            })
            $(".commodity_keyword_off input").click(function(){
                $(".commodity_keyword").css("display","none");
            })
        });
	</script>
</body>

</html>