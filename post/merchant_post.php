<?php 
include ("../include/data_base.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
    exit();
}


if (isset($_POST["merchant_shop"])) {
    $merchant_shop = $_POST["merchant_shop"];
} else {
    $merchant_shop = '';
}

if (isset($_POST["merchant_name"])) {
    $merchant_name = $_POST["merchant_name"];
} else {
    $merchant_name = '';
}

if (isset($_POST["merchant_phone"])) {
    $merchant_phone = $_POST["merchant_phone"];
} else {
    $merchant_phone = '';
}

if (isset($_POST["merchant_address"])) {
    $merchant_address = $_POST["merchant_address"];
} else {
    $merchant_address = '';
}

if (isset($_POST["merchant_contract"])) {
    $merchant_contract = $_POST["merchant_contract"];
} else {
    $merchant_contract = '';
}

if (isset($_POST["merchant_idcard1"])) {
    $merchant_idcard1 = $_POST["merchant_idcard1"];
} else {
    $merchant_idcard1 = '';
}

if (isset($_POST["merchant_idcard2"])) {
    $merchant_idcard2 = $_POST["merchant_idcard2"];
} else {
    $merchant_idcard2 = '';
}

if (isset($_POST["merchant_shopdoor"])) {
    $merchant_shopdoor = $_POST["merchant_shopdoor"];
} else {
    $merchant_shopdoor = '';
}

if (isset($_POST["merchant_original"])) {
    $merchant_original = $_POST["merchant_original"];
} else {
    $merchant_original = '';
}

if (isset($_POST["merchant_price"])) {
    $merchant_price = $_POST["merchant_price"];
} else {
    $merchant_price = '';
}

if (isset($_POST["merchant_supply"])) {
    $merchant_supply = $_POST["merchant_supply"];
} else {
    $merchant_supply = '';
}

if (isset($_POST["merchant_sigin"])) {
    $merchant_sigin = $_POST["merchant_sigin"];
} else {
    $merchant_sigin = '';
}

if (isset($_POST["merchant_province"])) {
    $merchant_province = $_POST["merchant_province"];
} else {
    $merchant_province = '';
}

if (isset($_POST["merchant_city"])) {
    $merchant_city = $_POST["merchant_city"];
} else {
    $merchant_city = '';
}

if (isset($_POST["merchant_district"])) {
    $merchant_district = $_POST["merchant_district"];
} else {
    $merchant_district = '';
}

if (isset($_POST["merchant_logo"])) {
    $merchant_logo = $_POST["merchant_logo"];
} else {
    $merchant_logo = '';
}

if (isset($_POST["merchant_bg"])) {
    $merchant_bg = $_POST["merchant_bg"];
} else {
    $merchant_bg = '';
}

$query_merchant = "SELECT me_id FROM merchant_entry where me_shop = '{$merchant_shop}' or me_phone = {$merchant_phone}";
	if ($result_merchant = mysqli_query($mysqli, $query_merchant))
	{
        $merchant_rows = mysqli_num_rows($result_merchant);
        if (!$merchant_rows) {
            $merchant_sql = mysqli_query($mysqli,"INSERT INTO merchant_entry (me_user,me_shop, me_name, me_phone, me_address, me_contract, me_idcard1, me_idcard2, me_shopdoor, me_original, me_price, me_sigin, me_supply, me_province, me_city, me_area, me_logo, me_bg) VALUES ('{$member_login}','{$merchant_shop}', '{$merchant_name}', '{$merchant_phone}', '{$merchant_address}', '{$merchant_contract}', '{$merchant_idcard1}', '{$merchant_idcard2}', '{$merchant_shopdoor}', '{$merchant_original}', '{$merchant_price}', '{$merchant_sigin}', '{$merchant_supply}', '{$merchant_province}', '{$merchant_city}', '{$merchant_district}', '{$merchant_logo}', '{$merchant_bg}')");
            if ($merchant_sql) {
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 2;
        }
    }
    

?>