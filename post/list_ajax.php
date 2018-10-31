<?php 
include("../include/data_base.php");
error_reporting(E_ALL & ~E_NOTICE);

if (isset($_POST['item_count'])) {
    $item_count = $_POST['item_count'];
} else {
    $item_count = 0;
}
if (isset($_POST['item_key'])) {
    $item_key = $_POST['item_key'];
} else {
    $item_key = '';
}
//busines			
$query = "SELECT teacher_list.*, college_list.cl_id,college_list.cl_name FROM teacher_list LEFT JOIN college_list ON teacher_list.tl_class=college_list.cl_id where college_list.cl_class = 'busines' and teacher_list.item_display = '1' ".(($item_key == "") ? "" : " and (teacher_list.tl_name LIKE '%$item_key%' or college_list.cl_name LIKE '%$item_key%') ")."order by tl_id desc limit $item_count,10";
			//echo $query;
			$nnn = 0;
			$result = mysqli_query($mysqli, $query);
			if ($result)
			{
				while( $row = mysqli_fetch_assoc($result) ){
					$nnn++;
                    $tlid = $row['tl_id'];                   
                    
                    if ($row['tl_point_type'] == "0") {
                        $price = "￥".$row['tl_price'];
						$original = "￥".$row['tl_original'];
                    }
                    if ($row['tl_point_type'] == "1") {
                        $price = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
						$original = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
                    }
                    if ($row['tl_point_type'] == "3") {
                        $price = ($row['tl_price']/10)."折";
						$original = ($row['tl_original']/10)."折";
                    }
                    
			?>


	<ul class="mui-table-view" >
		<li class="mui-table-view-cell" style="margin-bottom: 10px;">
        	<div class="table-view" style="clear:both; background-color: #FFFFFF;">
				<?php echo $row['tl_id'];?>&nbsp;&nbsp;<font color="#737373">【<?php echo $row['cl_name']?>&nbsp;[<?php echo $row['cl_id']?>]】</font>
                <div class="mui-media-body color-f99c73" style="font-size: 1.2em;">
                	<?php echo $row['tl_name']?>
                </div> 
            </div>
		</li>
	</ul>
	<?php 
        }
        }
        ?>
<?php 
if (!$result) {
	echo 0;
}
?>