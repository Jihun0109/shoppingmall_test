<?php 
include("../include/data_base.php");
if (isset($_POST['out_trade_no'])) {
    $out_trade_no = $_POST['out_trade_no'];
} else {
    $out_trade_no = '';
}

$query = "SELECT pay_member,pay_status FROM payment_list where pay_trade_no = '{$out_trade_no}'";
if ($result = mysqli_query($mysqli, $query))
{
	$row = mysqli_fetch_assoc($result);
    if ($row['pay_status'] == '1') {
        echo 1;
    } else if ($row['pay_status'] == '11') {
        echo 2;
    } else if ($row['pay_member']) {
        echo 3;
    } else {
        echo 0;
    }
}
?>