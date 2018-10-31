<?php
header('Content-Type: text/html; charset=utf-8');
include("../include/config.php");
include("../include/data_base.php");
include("../include/member_db.php");

function get_shipping_address($mysqli, $shipping_id)
{
	$query = "SELECT * FROM `shipping address` WHERE id = $shipping_id";
	if( $shipping_id > 0){
		if($result = mysqli_query( $mysqli, $query )){
			$row = mysqli_fetch_assoc( $result );
			return $row['mb_ship_province'] . "," . $row['mb_ship_city'] . "," . $row['mb_ship_district'] . "," . $row['mb_receiving_address'] ;
		} else {
			return false;
		}
	} else {
		return false;
	}
}

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

if (!$member_login) {
	echo 10;
	exit;
}
if (isset($_POST['sid'])) {
    $sid = $_POST['sid'];
} else {
    $sid = '';
}

$shipping_id = $_POST['shipping_id']?$_POST['shipping_id']:0;

if($shipping_id){
	$shipping_address = get_shipping_address($mysqli, $shipping_id);
}

$smember = $member_login;
if (isset($_POST['squantity'])) {
    $squantity = $_POST['squantity'];
} else {
    $squantity = '';
}

if (isset($_POST['mphone'])) {
    $share_phone = ($_POST['mphone'] == '0') ? "" : $_POST['mphone'];
} else {
    $share_phone = '';
}

$trade_no = date("Ymdhis",time()).time().rand(111111,999999);

if ($sid == "pay") {
    if (isset($_POST['sclass'])) {
        $shop_menu = $_POST['sclass']; 
    } else {
        $shop_menu = '';
    }
	
	$tlid = $sid;
    if (isset($_POST['sprice'])) {
        $price = $_POST['sprice'];
    } else {
        $price = '';
    }
    $tl_point_type = 0;
	$item_point = 0;
} else {
	$query = "SELECT * FROM teacher_list where tl_id = '{$sid}'";
	$result = mysqli_query( $mysqli, $query );
	$row = mysqli_fetch_assoc( $result );
	$shop_menu = $row['shop_menu'];
	$tlid = $row['tl_id'];
	$price = $row['tl_price']*$squantity;
	$item_point = $row['tl_point_commodity'];
	$tl_point_type = $row['tl_point_type'];
    
    if ($tl_point_type == "0") {
        if ($row['tl_price'] == "0.00") {
            echo 5;
            exit;
        }
    }
}
if ($tl_point_type == "1") {
	$squantity = 1;
    $member_payment = member_db($_COOKIE["member"],"mb_point","../include/data_base.php");
    $member_payment = json_decode($member_payment, true);
	if ($member_payment['mb_point'] < $item_point) {
		echo 6;
		exit;
	}
}

if ($tlid == '20') {
   $query_payment = "SELECT pay_id FROM payment_list where pay_member = '{$smember}' and pay_shop = '{$tlid}' and pay_status = '1'";
    if ($result_payment = mysqli_query($mysqli, $query_payment))
    {
        $payment_Number = mysqli_num_rows($result_payment);
        if ($payment_Number) {
            echo 8;
            exit();
        }
    } 
}

$sql_payment = mysqli_query($mysqli,"INSERT INTO payment_list (pay_member, pay_cate, pay_status, pay_shop, pay_count, pay_price, pay_point_commodity, pay_trade_no, payment_types, share_phone,  shipping_id, mb_receiving_address ) VALUES ('{$smember}', '{$shop_menu}', '0', '{$tlid}', '{$squantity}', '{$price}', '{$item_point}', '{$trade_no}', '0', '{$share_phone}', '{$shipping_id}', '{$shipping_address}')");
if ($sql_payment) {
	echo $trade_no;
} else {
	echo 0;
}
?>