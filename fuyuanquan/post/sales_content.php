<?php 
include( "../../db_config.php" );
include("../admin_login.php");
if (!strstr($admin_purview,"sales_content")) {
	echo "您没有权限访问此页";
	exit;
}
$sales_phone = $_POST["sales_phone"];
?>
<li>
    <span>商户名称</span>
    <span>订单数量</span>
    <span>原价</span>
    <span>实付</span>
    <span>供货价</span>
    <span>毛利</span>
</li>
<?php 
$query = "SELECT s_item,count(s_item) as phone_sums, sum(s_surplus_price) as phone_surplus_price, sum(s_real_price) as phone_real_price, sum(s_supply_price) as phone_supply_price FROM salesman where s_recommend = '{$sales_phone}' GROUP BY s_item HAVING count(s_item)>0 order by count(s_item) desc";
if ($result = mysqli_query($mysqli, $query))
{
    while( $row = mysqli_fetch_assoc($result) ){
        $s_item = $row['s_item'];
        $query_item = "SELECT tl_name FROM teacher_list where tl_id = '{$s_item}'";
        if ($result_item = mysqli_query($mysqli, $query_item))
        {
            $row_item = mysqli_fetch_assoc($result_item);
        }
?>
<li>
    <span><?php echo $row_item['tl_name'];?></span>
    <span><?php echo $row['phone_sums'];?></span>
    <span><?php echo Number_format($row['phone_surplus_price'],2);?>￥</span>
    <span><?php echo Number_format($row['phone_real_price'],2);?>￥</span>
    <span><?php echo Number_format($row['phone_supply_price'],2);?>￥</span>
    <span><?php echo Number_format($row['phone_real_price']-$row['phone_supply_price'],2); ?>￥</span>
</li>
<?php 
    }
}
?>