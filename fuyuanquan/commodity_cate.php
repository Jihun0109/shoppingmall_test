<div class="input-group" style="width: 90%;min-width: 360px; float: left; margin-bottom: 20px;">
	<?php 
if ($sort == "teacher") {
?>
	<!-- <select class="form-control" name="commodity_cate">
	<option value="10">个人讲座</option>
	<option value="20">专题讲座</option>
</select> -->
	<br>
	<?php 
	}
?>
	<select class="form-control" name="commodity_cate">
		<?php 
	$query_cate = "SELECT * FROM item_cate where ic_type = '{$sort}'";
if ($result_cate = mysqli_query($mysqli,$query_cate)) {
	for ($ct=0;$row_cate = mysqli_fetch_assoc($result_cate);$ct++) {
?>
		<option value="<?php echo $row_cate['ic_cid'];?>">
			<?php echo $row_cate['ic_name'];?>
		</option>
		<?php 
	}
}
?>
	</select>
	<?php 
if ($sort == 'partner') {
    if (isset($row['vip_point'])) {
        $vip_point = $row['vip_point'];
    } else {
        $vip_point =0;
    }
?>
	<span class="input-group-addon">赠送积分</span>
	<input class="form-control" type="text" name="commodity_vpoint" value="<?php echo $vip_point;?>">
	<?php 
}
?>
</div>