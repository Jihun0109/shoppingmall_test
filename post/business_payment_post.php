<?php 
include("../include/data_base.php");
if (isset($_POST["business_id"])) {
    $business_id = $_POST["business_id"]; 
} else {
    $business_id = '';
}

if (isset($_POST["business_price"])) {
    $business_price = $_POST["business_price"]; 
} else {
    $business_price = '';
}

$trade_no = date("Ymdhis",time()).rand(11111,999999);

$sql_payment = mysqli_query($mysqli,"INSERT INTO payment_list (pay_member, pay_cate, pay_status, pay_shop, pay_count, pay_price, pay_trade_no, payment_types) VALUES ('', 'scan', '0', '{$business_id}', '1', '{$business_price}', '{$trade_no}', '0')");

$query = "SELECT pay_id FROM payment_list where pay_trade_no = $trade_no limit 1";
if ($result = mysqli_query($mysqli, $query))
{
    $payment_rows = mysqli_num_rows($result);
    if ($payment_rows) {
        echo $trade_no;
    } else {
        echo 0;
    }
}
?>