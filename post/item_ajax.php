<?php 
include("../include/data_base.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
if (isset($_POST['cid'])) {
    $cid = $_POST['cid'];
} else {
    $cid = '';
}
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
} else {
    $keyword = '';
}
if (isset($_POST['menu'])) {
    $menu = $_POST['menu'];
} else {
    $menu = '';
}
if (isset($_POST['type'])) {
    $type = $_POST['type']; 
} else {
    $type = '1';
}
if (isset($_POST['item_count'])) {
    $item_count = $_POST['item_count']; 
} else {
    $item_count = '0';
}


if ($type == "1") {
	$type_sql = " and (tl_point_type = '0' or tl_point_type = '2')";
}
if ($type == "2") {
	$type_sql = " and tl_point_type = '3'";
}
if ($type == "3") {
	$type_sql = " and tl_point_type = '1'";
}
if (!$type) {
	$type_sql = "";
}

if ($cid) {
	$cate_common = " and tl_cate = '{$cid}'";
} else {
	$cate_common = "";
}
if ($keyword) {
	$key_sql = " and tl_name like '%$keyword%'";
} else {
	$key_sql = "";
}
$query = "SELECT * FROM teacher_list where shop_menu = '{$menu}'{$type_sql}{$key_sql}{$cate_common} and item_display = '1' order by item_array desc,tl_Sales desc,tl_price limit $item_count,30";
if ($result = mysqli_query($mysqli, $query))
{
	while($row = mysqli_fetch_assoc($result)){
		$tlid = $row['tl_id'];
		$sql_follow = mysqli_query($mysqli, "SELECT count(*) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
		$follow_rs = mysqli_fetch_array($sql_follow,MYSQLI_NUM);
		$follow_totalNumber = $follow_rs[0];
		if ($follow_totalNumber) {
		$follow_img = "img/on_ok.png";
		} else {
		$follow_img = "img/off_ok.png";
		}
		$shop_type = $row['shop_menu'];
		$shop_cate = $row['tl_cate'];
		$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
		if ($result_cate = mysqli_query($mysqli,$query_cate)) {
			$row_cate = mysqli_fetch_assoc($result_cate);
		}
        if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
            $agent_target = " onClick=\"OpenNewWindow();\"";
        } else if (strstr($_SERVER['HTTP_USER_AGENT'],"isMicroMessenger")) {
            $agent_target = " target=\"_self\"";
        }  else {
             $agent_target = " target=\"_blank\"";
        }
?>
<li>
	<p class="college_list_small"><a class="animsition-link" href="detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company"<?php echo $agent_target;?>><img src="<?php echo $row['tc_mainimg'];?>" alt=""></a></p>
  <p class="college_list_title"><?php echo $row['tl_name'];?></p>
  <p class="college_list_cate"><span><?php echo $row_cate['ic_name'];?></span><span><img id="follow_<?php echo $row['tl_id'];?>" onClick="follows('<?php echo $row['tl_id'];?>','<?php echo $member_login;?>','<?php echo $follow_img;?>')" src="<?php echo $follow_img;?>" alt=""></span></p>
	<p class="college_list_price">
	<?php 
		if ($row['tl_point_type'] == "0") {
			echo "￥".$row['tl_price']."<i>￥".$row['tl_original']."</i>";
		}
	?>
	<?php 
		if ($row['tl_point_type'] == "1") {
			echo '<img src="img/point_ico.png" alt="积分图标">'.$row['tl_point_commodity'];
		}
	?>
	<?php 
		if ($row['tl_point_type'] == "2") {
			echo '<img src="img/point_ico.png" alt="积分图标">'.$row['tl_point_commodity']."<b>￥".$row['tl_price']."</b>";
		}
	?>
	<?php 
		if ($row['tl_point_type'] == "3") {
			echo ($row['tl_price']/10)." 折";
		}
	?>
	</p>
</li>
<?php 
	}
}
?>
<?php 
if (!mysqli_num_rows($result)) {
	echo 0;
}
?>
