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
if (isset($_POST['itme_type'])) {
    $itme_type = $_POST['itme_type'];
} else {
    $itme_type = '';
}

//busines			
$query = "SELECT * FROM memo_list where me_cate='".$itme_type."' ".(($item_key == "") ? "" : " and (me_title LIKE '%$item_key%' or me_txt LIKE '%$item_key%') ")."order by me_id desc limit $item_count,20";
			$nnn = $item_count;
			$result = mysqli_query($mysqli, $query);
			if ($result)
			{
				while( $row = mysqli_fetch_assoc($result) ){
					$nnn++;                
			?>


            <ul class="mui-table-view" style=" background-color: #FFFFFF;">
                <li class="mui-table-view-cell" style="margin-bottom: 2px;">
                    <div class="table-view" style="clear:both; background-color: #FFFFFF;" onClick="location.href='memo_view.php?me_id=<?php echo $row['me_id'];?>'">				
                        <div class="mui-media-body color-f99c73" style="font-size: 1.2em;">
                            <a href="memo_view.php?me_id=<?php echo $row['me_id'];?>" style="font-size: 0.9em;"><?php echo $nnn .'.&nbsp;&nbsp;'. $row['me_title']?></a>
                        </div> 
                        <div style="font-size: 0.8em; color:#737373; height:52px; line-height:20px; margin-top:-12px;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['me_txt']?></div>
                    </div>
                </li>
            </ul>
			<?php 
        		}
        	}
			else
			{
				echo 0;
			}
		 	?>