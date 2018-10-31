<?php 
header("Content-Type: text/html;charset=utf-8");
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"vipcard")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["vid"])) {
    $vid = $_POST["vid"];
} else {
    $vid = 0;
}

$query = "SELECT * FROM vip_card_log where user_id = '{$vid}'";
if ($result = mysqli_query($mysqli, $query))
{
    $rows = mysqli_num_rows($result);
    if (!$rows) {
        echo 0;
    }
    for ($i=0;$row = mysqli_fetch_assoc($result);$i++) {
?>
<li>
    <span>时间</span>
    <span>积分</span>
    <span>备注</span>
</li>
<li>
    <span><?php echo $row['log_time'];?></span>
    <span><?php echo $row['surplus_point'];?></span>
    <span><?php echo $row['point_memo'];?></span>
</li>
<?php 
    }
}
?>