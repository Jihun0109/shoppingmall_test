<?php
include("include/data_base.php");
$head_title = "推送消息";
include( "include/head_.php" );
$top_title = "推送消息";
$return_url = "..";

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
include( "include/top_navigate.php" );
?>
<style type="text/css">
    .push_message {
        margin-top: 48px;
        float: left;
        width: 100%;
    }
    .push_message ul {
        float: left;
        width: 100%;
    }
    .push_message li {
        background-color: #fff;
        margin-bottom: 3px;
        float: left;
        width: 96%;
        padding: 2%;
    }
    .push_message .title {
        color: #777;
        font-size: 0.8em;
        margin-bottom: 6px;
    }
    .push_message .content {
        color: #000;
        font-size: 1em;
    }
    .push_message .push_time {
        color: #7E7E7E;
        font-size: 0.8em;
        text-align: right;
    }
</style>
<div class="push_message">
	<ul>
        <?php 
        $query = "SELECT * FROM push_message where user = '{$member_login}' order by id desc limit 50";
        if ($result = mysqli_query($mysqli, $query))
        {
            for ($i=0;$row = mysqli_fetch_assoc($result);$i++) {
        ?>
        <li>
			<p class="title"><?php echo $row['title'];?></p>
            <p class="content"><?php echo $row['message'];?></p>
            <p class="push_time"><?php echo $row['push_time'];?></p>
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