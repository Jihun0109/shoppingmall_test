<?php
include("db_config.php");
$head_title = "名师";
include( "include/head_.php" );
$top_title = "名师";
$return_url = "..";
include( "include/top_navigate.php" );
$query = "SELECT * FROM  college_list where cl_allfollow > 30";
?>
<div class="tc_lecture_list" style="width: 100%; float: left; padding: 5px;position: relative;top: 45px">
	    	<?php
    	if ($result = mysqli_query($mysqli, $query))
		{
			while( $row = mysqli_fetch_assoc($result) )
			{	
		?>
			<div style="width: 33%; padding: 5px; float: left; ">
				<div style="width: 100%;position: relative;">
				    <div style="position: absolute;z-index: 5;font-size: 11px;background-color: #ff655e; border-bottom-right-radius:6px; color: white; padding: 0px 5px;height: 19px">名师</div>
				    <a class="animsition-link" href="user_blog.php?id=<?php echo $row['cl_id'];?>&type=join" target="_self"><img src="<?php echo $row['cl_logo'];?>" style="width: 100%;height: 100%"></a>
				    <div style="width: 100%;height: 24px;position: absolute;z-index: 5;background-color: rgba(0,0,0,0.5);padding: 2px 5px; bottom: 6px;">
				        <p style="float: right; color: white; padding-left: 6px"><?php echo $row['cl_allfollow'];?></p>
				        <img src="img/like.png" style="height: 16px; float: right;">
				    </div>
				</div>
			    <div style="color: #313131"><?php echo $row['cl_name'];?></div>
			</div>
        <?php
			}
		}
		?>
	
</div>
<?php 
include( "include/foot_.php" );
?>