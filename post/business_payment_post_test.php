<?php 
include("../include/data_base.php");
include("../include/ordernumber.php");
$trade_no = ordernumber();

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

if (isset($_POST["user_phone"])) {
    $user_phone = $_POST["user_phone"]; 
} else {
    $user_phone = 0;
}

if (isset($_POST["goodsidArray"])) {
    $goodsidArray = $_POST["goodsidArray"]; 
} else {
    $goodsidArray = '';
}
if (isset($_POST["goodscountArray"])) {
    $goodscountArray = $_POST["goodscountArray"]; 
} else {
    $goodscountArray = '';
}

if ($user_phone) {
	$query_user = "SELECT mb_id FROM fyq_member where mb_phone = '{$user_phone}' limit 1";
	if ($result_user = mysqli_query($mysqli, $query_user)) {
		$rows_user_count = mysqli_num_rows($result_user);
		if ($rows_user_count) {
			$row_user = mysqli_fetch_assoc($result_user);
			$user_id = $row_user['mb_id'];
			if (empty($goodsidArray)) {
	
			} else {
				for ($i=0;$i<count($goodsidArray);$i++) {
					$goodsidlist = $goodsidArray[$i];
					$goodscountlist = $goodscountArray[$i];
					$goodsidlist = str_replace('goods_', '',$goodsidlist);

					$query_goods = "SELECT goods_point,goods_price FROM goods_list where id = '{$goodsidlist}' limit 1";
					if ($result_goods = mysqli_query($mysqli, $query_goods)) {
						$row_goods = mysqli_fetch_assoc($result_goods);
						$goods_point = $row_goods['goods_point'];
						$goods_price = $row_goods['goods_price'];
						mysqli_query($mysqli,"INSERT INTO goods_order (goods_tradeno,user_id,point, price, item_id, goods_id, quantity, goods_state) VALUES ('{$trade_no}','{$user_id}','{$goods_point}', '{$goods_price}', '{$business_id}', '{$goodsidlist}', '{$goodscountlist}', '0')");
					}
				}
			}
		} else {
			$user_id = -1;
		}
	}
} else {
	$user_id = 0;
}

if ($user_id <> 0) {
	$payment_member = $user_phone;
}

$sql_payment = mysqli_query($mysqli,"INSERT INTO payment_list (pay_member, pay_cate, pay_status, pay_shop, pay_count, pay_price, pay_trade_no, payment_types) VALUES ('{$payment_member}', 'scan', '0', '{$business_id}', '1', '{$business_price}', '{$trade_no}', '0')");

$query_payment = "SELECT pay_id FROM payment_list where pay_trade_no = $trade_no limit 1";
if ($result_payment = mysqli_query($mysqli, $query_payment))
{
    $payment_rows = mysqli_num_rows($result_payment);
    if ($payment_rows) {
        echo $trade_no;
    } else {
        echo 0;
    }
}
?>