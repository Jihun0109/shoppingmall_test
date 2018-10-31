<?php 
include("db_config.php");
$head_title = "我的关注";
include("include/head_.php");
$top_title = "我的关注";
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="tc_lecture_list" style="margin-top: 48px;">
  <ul>
	<?php 
		$query = "SELECT * FROM follow_list where fl_phone = '{$member_login}' order by fl_id desc";
		$result = mysqli_query($mysqli, $query);
		for ($i=0;$row = mysqli_fetch_assoc($result);$i++) {
			$tid = $row['fl_tid'];
			$query_view = "SELECT * FROM teacher_list where tl_id = '{$tid}'";
			$result_view = mysqli_query($mysqli, $query_view);
			$row_view = mysqli_fetch_assoc($result_view);
			
			if ($row_view['shop_menu'] == "teacher") {
				$href_view = "detailed_view.php?view=".$row_view['tl_id']."&type=individual";
			}
			if ($row_view['shop_menu'] == "partner") {
				$href_view = "detailed_view.php?view=".$row_view['tl_id']."&type=join";
			}
			if ($row_view['shop_menu'] == "college") {
				$href_view = "detailed_view.php?view=".$row_view['tl_id']."&type=company";
			}
			if ($row_view['shop_menu'] == "busines") {
				$href_view = "detailed_view.php?view=".$row_view['tl_id']."&type=company";
			}
			$shop_type = $row_view['shop_menu'];
			$shop_cate = $row_view['tl_cate'];
			$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
			if ($result_cate = mysqli_query($mysqli,$query_cate)) {
				$row_cate = mysqli_fetch_assoc($result_cate);
			}
	?>
    <li>
      <p><a href="<?php echo $href_view;?>" target="_self"><img src="<?php echo $row_view['tc_mainimg'];?>" alt=""></a></p>
      <p><?php echo $row_view['tl_name'];?></p>
      <p class="tc_lecture_list_cate"><span><?php echo $row_cate['ic_name'];?></span><span><img id="follow_<?php echo $row_view['tl_id'];?>" onClick="follows('<?php echo $row_view['tl_id'];?>','<?php echo $row_member['mb_phone'];?>','img/on_ok.png')" src="img/on_ok.png" alt=""></span></p>
    </li>
    <?php 
		}
	 ?>
  </ul>
</div>
<?php 
include("include/foot_.php");
?>
