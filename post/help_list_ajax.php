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
$query = "SELECT * FROM memo_list where me_cate='30' ".(($item_key == "") ? "" : " and (me_title LIKE '%$item_key%' or me_txt LIKE '%$item_key%') ")."order by me_id desc limit $item_count,20";
			$nnn = $item_count;
			$result = mysqli_query($mysqli, $query);
			if ($result)
			{
				while( $row = mysqli_fetch_assoc($result) ){
					$nnn++;                
			?>


            <ul class="mui-table-view" style=" background-color: #FFFFFF;">
                <li class="mui-table-view-cell" style="margin-bottom: 10px;">
                    <div class="table-view" style="clear:both; background-color: #FFFFFF;">				
                        <div class="mui-media-body color-f99c73" style="font-size: 1.2em;">
                            <?php echo $nnn .'.&nbsp;&nbsp;'. $row['me_title']?>
                        </div> 
                        <div style="font-size: 1.0em; color:#737373">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['me_txt']?></div>
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