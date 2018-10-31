<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$query = "SELECT * FROM memo_list where me_id = '{$_REQUEST['me_id']}'";
$result = mysqli_query($mysqli, $query);
$row = mysqli_fetch_assoc($result);


$head_title = "";
include("include/head_.php");
$top_title = "";
$return_url = "..";
include("include/top_navigate_commodity.php");
?>
<div class="businesses_blog_list" style="margin-top: 54px;">
	<div class="mui-card">
		<div style="width:95%; margin:0 auto; text-align:center; line-height:30px; font-size:20px;"><?php echo $row['me_title'];?></div>
	</div>
    <div class="mui-card">
        <p><?php echo $row['me_txt'];?></p>
	</div>
</div>
</body>
</html>