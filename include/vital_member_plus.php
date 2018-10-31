<?php 
function vital_member_plus($phone,$total_gold,$gold_count,$commission_all,$commission_count,$partner_all_gold,$partner_count,$recommend_count,$point,$payment_method) {
    if ($payment_method == "wechat") {
        $data_base = "../../include/data_base.php";
    } else if ($payment_method == "alipay") {
        $data_base = "../include/data_base.php";
    } else {
        $data_base = "../include/data_base.php";
    }
    include($data_base);
    
    $vital_day_time = date('Ymd',time());
    $vital_day_sql = mysqli_query($mysqli, "SELECT d_id FROM vital_day_member_plus where d_phone = '{$phone}' and d_time = '{$vital_day_time}'");
    $vital_day_rows = mysqli_num_rows($vital_day_sql);
    if ($vital_day_rows) {
        mysqli_query($mysqli,"UPDATE vital_day_member_plus SET 
        d_total_gold = d_total_gold+$total_gold,
        d_gold_count = d_gold_count+$gold_count,
        d_commission_all = d_commission_all+$commission_all,
        d_commission_count = d_commission_count+$commission_count,
        d_partner_all_gold = d_partner_all_gold+$partner_all_gold,
        d_partner_count = d_partner_count+$partner_count,
        d_recommend_count = d_recommend_count+$recommend_count,
        d_point = d_point+$point
        where d_phone = '{$phone}' and d_time = '{$vital_day_time}'");
    } else {
        mysqli_query($mysqli,"INSERT INTO vital_day_member_plus (
        d_phone, 
        d_time,
        d_total_gold, 
        d_gold_count,
        d_commission_all, 
        d_commission_count, 
        d_partner_all_gold, 
        d_partner_count, 
        d_recommend_count, 
        d_point
        ) VALUES (
        '{$phone}', 
        '{$vital_day_time}',
        '{$total_gold}',
        '{$gold_count}',
        '{$commission_all}',
        '{$commission_count}',
        '{$partner_all_gold}',
        '{$partner_count}',
        '{$recommend_count}',
        '{$point}'
        )");
    }
}
?>