<?php 
include("../db_config.php");
$viewid = $_POST['viewid'];
	$query = "SELECT tl_detailed FROM teacher_list where tl_id = '{$viewid}'";
	if ($result = mysqli_query($mysqli, $query))
	{
	   $row = mysqli_fetch_assoc($result);
        echo $row['tl_detailed'];
    }
?>