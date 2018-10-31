<div class="horizontal-list" id="horizontal_list_div">
	<ul id="horizontal-list">
		<li value="0" class="active" id="all"><a>全部</a></li>
		<!-- <li value="-1" id="vip"><a><img src="img/vip.png" style="width: 15px">VIP</a></li> -->
		<?php 
		$query_cate = "SELECT * FROM item_cate where ic_type = 'teacher'";
		if ($result_cate = mysqli_query($mysqli,$query_cate)) {
			for ($ct=0;$row_cate = mysqli_fetch_assoc($result_cate);$ct++) {
		?>
			<li value="<?php echo $row_cate['ic_cid'];?>" id="sort_menu_<?php echo $row_cate['ic_cid'];?>"><a><?php echo $row_cate['ic_name'];?></a></li>
		<?php 
			}
		}
		?>
	</ul>
</div>