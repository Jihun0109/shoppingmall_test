<?php 
include ("../include/data_base.php");
include("../include/send_post.php");

session_start();
if (isset($_SESSION['withdrawal'])) {
    $withdrawal_time = time()-$_SESSION['withdrawal'];
    if ($withdrawal_time < 10) {
        echo 11;
        exit();
    } else {
        $_SESSION['withdrawal']=time();
    }
} else {
    $_SESSION['withdrawal']=time();
}

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

if (isset($_POST['bank_list'])) {
    $bank_list = $_POST['bank_list'];
} else {
    $bank_list = '';
}

if (isset($_POST['withdrawal_cash'])) {
    $withdrawal_cash = $_POST['withdrawal_cash'];
} else {
    $withdrawal_cash = '';
}

if (isset($_POST['withdrawal_price'])) {
    $withdrawal_price = $_POST['withdrawal_price'];
} else {
    $withdrawal_price = '';
}

if (isset($_POST['withdrawal_point'])) {
    $withdrawal_point = $_POST['withdrawal_point'];
} else {
    $withdrawal_point = '';
}
$withdrawal_price = floatval($withdrawal_price);
$withdrawal_cash = floatval($withdrawal_cash);
$withdrawal_point = floatval($withdrawal_point);

if (!$withdrawal_price) {
    echo 9;
    exit();
}

if (!$withdrawal_cash) {
    echo 9;
    exit();
}

if ($withdrawal_price < 100) {
    echo 10;
    exit();
}

//if ($withdrawal_cash>1) {
//    $withdrawal_day = date("d",time());
//    if ($withdrawal_day !== '10') {
//        echo 12;
//        exit();
//    }
//}

$query_withdrawal = "SELECT * FROM fyq_member where mb_phone = {$member_login}";
if ($result_withdrawal = mysqli_query($mysqli, $query_withdrawal))
{
	$row_withdrawal = mysqli_fetch_assoc($result_withdrawal);
	
    if ($withdrawal_point) {
        $mb_point = $row_withdrawal['mb_point'];
        $point_post = round(($withdrawal_price*0.06),2)*100;
        if ($point_post>$mb_point) {
            echo 8;
            exit();
        }
        if ($withdrawal_cash == 1) {
            $point_post = 0;
        }
    } else {
        $point_post = 0;
    }
    
    if ($withdrawal_cash == 1) {
        $mb_not_gold = $row_withdrawal['mb_not_gold'];
        $before_price = $mb_not_gold;
        $after_price = $mb_not_gold-$withdrawal_price;
        if ($withdrawal_price > $mb_not_gold) {
            echo 7;
            exit();
        }
    }
    
    if ($withdrawal_cash == 2) {
        $mb_commission_not_gold = $row_withdrawal['mb_commission_not_gold'];
        $before_price = $mb_commission_not_gold;
        $after_price = $mb_commission_not_gold-$withdrawal_price;
        if ($withdrawal_price > $mb_commission_not_gold) {
            echo 6;
            exit();
        }
    }
    
    if ($withdrawal_cash == 3) {
        $mb_partner_not_gold = $row_withdrawal['mb_partner_not_gold'];
        $before_price = $mb_partner_not_gold;
        $after_price = $mb_partner_not_gold-$withdrawal_price;
        if ($withdrawal_price > $mb_partner_not_gold) {
            echo 5;
            exit();
        }
    }
    
    if ($bank_list == 'bank') {
        $mb_name_receipt = $row_withdrawal['mb_name_receipt'];
        $mb_open_bank = $row_withdrawal['mb_open_bank'];
        $mb_bankcardnumber = $row_withdrawal['mb_bankcardnumber'];
        if (!$mb_name_receipt || !$mb_open_bank || !$mb_bankcardnumber) {
            echo 4;
            exit();
        }
    }
    
    if ($bank_list == 'wechat') {
        $mb_wechat_receipt = $row_withdrawal['mb_wechat_receipt'];
        if (!$mb_wechat_receipt) {
            echo 4;
            exit();
        }
    }
    
    if ($bank_list == 'alipay') {
        $mb_alipay_receipt = $row_withdrawal['mb_alipay_receipt'];
        $mb_alipay_account = $row_withdrawal['mb_alipay_account'];
        if (!$mb_alipay_receipt && !$mb_alipay_account) {
            echo 4;
            exit();
        }
    }
    
    if ($withdrawal_cash == 1) {
        $w_service = 0;
    } else {
        $w_service = round(($withdrawal_price*0.06),2);
    }
	$date_now = date("Y-m-d");
	$cf_sql = "select count(w_id) as cnt from withdrawal_list where w_phone = '{$member_login}' and w_price = '{$withdrawal_price}' and w_price_cate = '{$withdrawal_cash}' and w_service = '{$w_service}' and w_bank = '{$bank_list}' and w_type = '{$withdrawal_point}' and w_point = '{$point_post}' and w_before = '{$before_price}' and w_after = '{$after_price}' SUBSTR( w_time, 1, 10 ) =  '{$date_now}'";
	
	$result_cf = mysqli_query($mysqli, $cf_sql);
	$row_cf = mysqli_fetch_assoc($result_cf);
	if($row_cf['cnt'] > 0)
	{
		echo 3;
        exit();
	}
    
    $withdrawal_sql = mysqli_query($mysqli,"INSERT INTO withdrawal_list (w_phone, w_price, w_price_cate, w_service, w_bank, w_type, w_point, w_before, w_after) VALUES ('{$member_login}', '{$withdrawal_price}', '{$withdrawal_cash}', '{$w_service}', '{$bank_list}', '{$withdrawal_point}', '{$point_post}', '{$before_price}', '{$after_price}')");
    if ($withdrawal_sql) {
        if ($withdrawal_cash == 1) {
            $member_sql = " mb_not_gold = mb_not_gold - '{$withdrawal_price}', mb_finish_gold = mb_finish_gold+ '{$withdrawal_price}'";
        }
        if ($withdrawal_cash == 2) {
            $member_sql = " mb_commission_not_gold = mb_commission_not_gold - '{$withdrawal_price}', mb_commission_finish_gold = mb_commission_finish_gold+'{$withdrawal_price}', mb_commission_finish_count = mb_commission_finish_count+1";
        }
        if ($withdrawal_cash == 3) {
            $member_sql = " mb_partner_not_gold = mb_partner_not_gold - '{$withdrawal_price}', mb_partner_finish_gold = mb_partner_finish_gold+'{$withdrawal_price}'";
        }
        if ($withdrawal_point) {
            $point_sql = ", mb_point = mb_point - {$point_post}";
        } else {
            $point_sql = "";
        }
        mysqli_query($mysqli,"UPDATE fyq_member SET{$member_sql}{$point_sql} WHERE mb_phone = '{$member_login}'");
    }
}
exit();
?>