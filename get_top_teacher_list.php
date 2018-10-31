<?php
include("include/config.php");
include("include/data_base.php");

if (isset($_GET['teacherGroupNumber'])) {
    $teacherGroupNumber = $_GET['teacherGroupNumber'];
} else {
    $teacherGroupNumber = 0;
}

	$query = "SELECT * FROM college_list where cl_class = 'busines' ORDER BY cl_allfollow desc, cl_allsales desc, cl_id desc limit ".($teacherGroupNumber*6).", 6";
	
	if ($result = mysqli_query($mysqli, $query))
	{
		while( $row = mysqli_fetch_assoc($result) ){		
	?>

<div style="width: 33%; padding: 5px; float: left; ">
    <div style="width: 100%;position: relative;">
        <div style="position: absolute;z-index: 5;font-size: 11px;background-color: #ff655e; border-bottom-right-radius:6px; color: white; padding: 0px 5px;height: 19px">精品</div>
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