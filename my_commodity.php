<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$query_merchant = "SELECT * FROM merchant_entry where me_user = '{$member_login}'";
$result_merchant = mysqli_query($mysqli, $query_merchant);

$query_college = "SELECT * FROM college_list where cl_phone = '{$member_login}'";
$result_college = mysqli_query($mysqli, $query_college);
//print_r($result_merchant);

if ($result_merchant->num_rows > 0 || $result_college->num_rows > 0)
{
	$row_merchant = mysqli_fetch_assoc($result_merchant);
    if ($row_merchant['me_state'] == '0') 
	{
        echo "<script> alert('专家入驻审核中！');parent.location.href='index.php'; </script>";
        exit;
    }
}
else
{
	echo "<script> alert('专家入驻后才能操作！');parent.location.href='merchant_entry.php'; </script>";
    exit;
}

$head_title = "讲课列表";
include("include/head_.php");
$top_title = "讲课列表";
$top_url = '<span style="text-align: right; width: auto; margin-right:2%;" onClick="window.location.href=\'my_commodity_add.php\'">新发布<span>';
$return_url = "..";
include("include/top_navigate_commodity.php");
?>
<div class="businesses_blog_list" style="margin-top: 54px;">
	<?php 
	   $query = "SELECT * FROM college_list where cl_phone = '{$member_login}'";	
	   
	if ($result = mysqli_query($mysqli, $query))
	{
		$row = mysqli_fetch_assoc($result);
	}
	$tid = $row['cl_id'];	
	$query_list = "SELECT * FROM teacher_list where tl_class = '{$tid}'  and delete_status != 0 ORDER BY tl_id desc";	
	$result_list = mysqli_query($mysqli, $query_list);
	if ($result_list && $tid != '')
	{
	while( $row_list = mysqli_fetch_assoc($result_list) ){ 
		$tlid = $row_list['tl_id'];
		$follow_totalNumber = false;
		$sql_follow = mysqli_query($mysqli, "SELECT count(*) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
		
		if($sql_follow)
		{
			$follow_rs = mysqli_fetch_array($sql_follow,MYSQLI_NUM);
			$follow_totalNumber = $follow_rs[0];
		}
		if ($follow_totalNumber) {
		$follow_img = "img/on_ok.png";
		} else {
		$follow_img = "img/off_ok.png";
		}
		$shop_type = $row_list['shop_menu'];
		$shop_cate = $row_list['tl_cate'];
		$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
		if ($result_cate = mysqli_query($mysqli,$query_cate)) {
			$row_cate = mysqli_fetch_assoc($result_cate);
		}
	?>
	<div class="mui-card" id="commodity_<?php echo $row_list['tl_id'];?>">
		
		<div class="mui-card-header mui-card-media card businesses_blog_list_small" ><a class="mui-media-object" href="detailed_view.php?view=<?php echo $row_list['tl_id'];?>&type=company" target="_self"><img src="<?php echo $row_list['tc_mainimg'];?>" alt=""></a></div>
		<div class="mui-card-content">
			<div class="mui-card-content-inner businesses_blog_list_title">
				<p class="businesses_blog_list_title mui-h3"><?php echo $row_list['tl_name'];?></p>
				<p style="line-height: 2em;" class="mui-h4 businesses_blog_list_price">
					<?php 
					if ($row_list['tl_point_type'] == "0") {
						echo "幸福价￥".$row_list['tl_price']." &nbsp; &nbsp; &nbsp;原价￥<span style='text-decoration: line-through'>".$row_list['tl_original']."</span>";
					}
					?>
					<?php 
						if ($row_list['tl_point_type'] == "1") {
							echo '<img src="img/point_ico.png" alt="积分图标">'.$row_list['tl_point_commodity'];
						}
					?>
					<?php 
						if ($row_list['tl_point_type'] == "2") {
							echo '<img src="img/point_ico.png" alt="积分图标">'.$row_list['tl_point_commodity']."<b>￥".$row_list['tl_price']."</b>";
						}
					?>
					<?php 
						if ($row_list['tl_point_type'] == "3") {
							echo ($row_list['tl_price']/10)." 折";
						}
					?>
				</p>
			</div>
		</div>
		<div class="mui-pull-right businesses_blog_list_cate" style="margin-bottom: 5%; margin-right: 2%;">
        	<div class="mui-btn mui-btn-primary"><a style="color: #FFFFFF;" href="javascript:recommodity('<?php echo $row_list['tl_id'];?>');">重新发布</a></div>
			<div class="mui-btn mui-btn-primary"><a style="color: #FFFFFF;" href="my_commodity_alter.php?id=<?php echo $row_list['tl_id'];?>">修改</a></div>
			<div class="mui-btn" style="margin-left: 15px;" onClick="commodity_del('<?php echo $row_list['tl_id'];?>')">删除</div>
		</div>
	</div>
	<?php 
	}
	}
	?>
</div>
</body>
</html>
<script type="text/javascript">
function commodity_del(del_id) {
	 if(confirm("确定?")){
		$.post("post/commodity_del.php",
		  {
			commoditydel_id:del_id
		  },
		  function(data,status){
			if (data) {
				alert("删除成功！");
				$("#commodity_"+del_id).remove();
			}
		  });
	 }else{
		 console.log("取消");
	 }log
	
}

function recommodity(re_id)
{
	$.post("post/commodity_re.php",
		  {
			commodity_id:re_id
		  },
		  function(data,status){
			if (data == '1') {
				alert("重新发布成功！");
			}
			else if (data == '2')
			{
				alert("请10分钟后重新发布！");
			}
			else
			{
				alert("系统繁忙，请稍后重新发布！");
			}
		  });
}
</script>