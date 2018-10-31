<?php 
include("../include/data_base.php");
if (isset($_GET['out_trade_no'])) {
    $out_trade_no = $_GET['out_trade_no'];
} else {
    $out_trade_no = '';
}

$query = "SELECT * FROM payment_list where pay_trade_no = '{$out_trade_no}'";
if ($result = mysqli_query($mysqli, $query))
{
	$row = mysqli_fetch_assoc($result);
    
    $item_id = $row['pay_shop'];
    if ($item_id == "pay") {
        $item_name = '余额充值';
    } else {
        $query_item = "SELECT * FROM teacher_list where tl_id = '{$item_id}'";
        if ($result_item = mysqli_query($mysqli, $query_item))
        {
            $row_item = mysqli_fetch_assoc($result_item);
            $item_name = $row_item['tl_name'];
        }
    }
    
    $trade_no = $row['pay_trade_no'];
    $amount = $row['pay_real'];
    $status = $row['pay_status'];
    $complete_time = $row['pay_time'];
    $method = $row['payment_method'];
    if ($row['pay_status'] == '1' || $row['pay_status'] == '11') {
        echo "[{\"item_name\":\"$item_name\",\"trade_no\":\"$trade_no\",\"amount\":\"$amount\",\"status\":\"1\",\"complete_time\":\"{$complete_time}\",\"method\":\"{$method}\"}]";
    }
}
?>