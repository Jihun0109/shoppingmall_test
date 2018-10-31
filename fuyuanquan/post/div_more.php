<?php 
header("Content-Type: text/html;charset=utf-8");
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"dividends")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["vid"])) {
    $vid = $_POST["vid"];
} else {
    $vid = 0;
}

$query = "SELECT * FROM balance_details where t_cate = '' and t_phone = '{$vid}' order by t_time desc";
if ($result = mysqli_query($mysqli, $query))
{
    $rows = mysqli_num_rows($result);
    if (!$rows) {
        echo 0;
    }
	else
	{
		?>
<li>
    <span>时间</span>
    <span style="display:none;">金额（元）</span>
    <span>详细</span>
</li>
        <?php
    for ($i=0;$row = mysqli_fetch_assoc($result);$i++) {
?>
<li>
    <span><?php echo $row['t_time'];?></span>
    <span style="display:none;"><?php echo $row['t_money'];?></span>
    <span><?php echo $row['t_description'];?></span>
</li>
<?php 
    }
	}
}
?>