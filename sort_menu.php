<div class="horizontal-list" id="horizontal_list_div">
	<ul id="horizontal-list">
		<li value="0" class="active" id="all"><a>推荐</a></li>
		<li value="-1" id="cate" onclick="window.open('item_cate.php', '_self')"><a ><img src="img/cate.png"style="width: 20px"></a></li>
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
	<!-- <ul><li value="-1" id="vip"><a><img src="img/cate.png"style="width: 45px"></a></li></ul> -->
</div>