<?php 
include("db_config.php");
$clid = @$_GET['id'];
if (!$clid) {
	exit;
}
$query = "SELECT * FROM college_list where cl_id = '{$clid}'";
if ($result = mysqli_query($mysqli, $query))
{
	$row = mysqli_fetch_assoc($result);
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<title><?php echo $row['cl_name'];?></title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script>
$(document).ready(function(){
	blog_height_bg();
});
function blog_height_bg() {
	var busblog_height = ($(".businesses_blog_detailed").width()/75)*35;
	$(".businesses_blog_detailed").height(busblog_height);
	var busblog_logo = ($(".businesses_blog_detailed li:eq(0) img").width()/19)*10;
	$(".businesses_blog_detailed li:eq(0) img").height(busblog_logo);
}
$(window).resize(function(){
	blog_height_bg();
})
function follow_id(fid) {
	var follow_ico = $("#follow_"+fid).attr("src");
	console.log(follow_ico);
	$.post("../post/follow.php",
	  {
		phone_num:"<?php echo $member_login;?>",
		follow_ico:follow_ico,
		shop_id:fid
	  },
	  function(data,status){
		if (data == "0") {
			  alert("请先登录使用!");
		  }
		  if (data == "1") {
			  alert("关注成功");
			  $("#follow_"+fid).attr("src","img/on_ok.png");
		  }
		  if (data == "2") {
			  alert("关注已取消");
			  $("#follow_"+fid).attr("src","img/off_ok.png");
		  }
	  });
}
</script>
</head>

<body>
<?php 
	$top_title = $row['cl_name'];
	$return_url = "..";
	include("include/top_navigate.php");
?>
<div class="businesses_blog_detailed" style="background-image: url('<?php echo $row['cl_bg'];?>'); background-size: cover;margin-top:50px ">
  <ul>
    <li><img src="<?php echo $row['cl_logo'];?>" style="width: 80%; height: 60px"></li>
    <li>
      <p><?php echo $row['cl_name'];?></p>
      <p><?php echo $row['cl_province'];?> <?php echo $row['cl_city'];?> <?php echo $row['cl_area'];?></p>
    </li>
    <!--<li>
      <p><img src="img/off_ok.png" alt="关注">关注</p>
      <p>365 人</p>
    </li>-->
  </ul>
	<!--<div id="businesses_blog_edit">店铺编辑</div>-->
</div>
<div class="businesses_blog_list">
  <ul>
   <?php 
	$tid = $row['cl_id'];
	$query_list = "SELECT * FROM teacher_list where tl_class = '{$tid}' ORDER BY tl_id desc";
	if ($result_list = mysqli_query($mysqli, $query_list))
	{
	while( $row_list = mysqli_fetch_assoc($result_list) ){ 
		$tlid = $row_list['tl_id'];
		$sql_follow = mysqli_query($mysqli, "SELECT count(*) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
		$follow_rs = mysqli_fetch_array($sql_follow,MYSQLI_NUM);
		$follow_totalNumber = $follow_rs[0];
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
    <li>
		<p class="businesses_blog_list_small"><a href="detailed_view.php?view=<?php echo $row_list['tl_id'];?>&type=company" target="_self"><img src="<?php echo $row_list['tc_mainimg'];?>" alt=""></a></p>
      <p class="businesses_blog_list_title"><?php echo $row_list['tl_name'];?></p>
      <p class="businesses_blog_list_cate"><span><?php echo $row_cate['ic_name'];?></span><span><img id="follow_<?php echo $row_list['tl_id'];?>" onClick="follow_id('<?php echo $row_list['tl_id'];?>')" src="<?php echo $follow_img;?>" alt=""></span></p>
		<p class="businesses_blog_list_price">
			<?php 
			if ($row_list['tl_point_type'] == "0") 
			{
			?>
				<!-- echo "￥".$row_list['tl_price']."<i>￥".$row_list['tl_original']."</i>"; -->
				幸福价￥<?php echo $row_list['tl_price'];?><i style="margin-left: 5px; text-decoration: line-through; color: #959595; font-size: 0.8em;">原价￥<?php echo $row_list['tl_original'];?></i>
			<?php
			}
			?>
			<?php 
				if ($row_list['tl_point_type'] == "1") {
					echo '<img src="img/point_ico.png" alt="积分图标" style="width:10%">'.$row_list['tl_point_commodity'];
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
    </li>
    <?php 
	}
	}
	?>
  </ul>
</div>
</body>
</html>