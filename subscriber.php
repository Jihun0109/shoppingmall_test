<?php
include("db_config.php");
$head_title = "精品";
include( "include/head_.php" );
$top_title = "精品";
$return_url = "..";
include( "include/top_navigate.php" );
$query = "SELECT * FROM teacher_list where shop_menu='partner' and tl_class='0' and item_display='1' ORDER BY item_lever asc";
?>

<div class="subscriber_list" style="width: 100%;padding: 10px;padding-top: 43px">
	<ul>
    	<?php
    	if ($result = mysqli_query($mysqli, $query))
		{
			while( $row = mysqli_fetch_assoc($result) )
			{	
		?>
		<li>
			<p><a class="animsition-link" href="detailed_view.php?view=<?php echo $row['tl_id'];?>&type=join" target="_self"><img style="width: 100%" src="<?php echo $row['tc_mainimg'];?>" alt="<?php echo $row['tl_name'];?>"></a>
			</p>
		</li>
        <?php
			}
		}
		?>
	</ul>
</div>
<?php 
include( "include/foot_.php" );
?>