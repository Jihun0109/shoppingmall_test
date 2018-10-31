<?php 
function vital_all($payment_method,$member_count,$member_vip1,$member_vip2,$business,$price,$real_price,$supply_price,$margin_price,$surplus_price,$sales,$withdraw_gold,$withdraw_commission,$withdraw_partner) {
    if ($payment_method == "wechat") {
        $data_base = "../../include/data_base.php";
    } else if ($payment_method == "alipay") {
        $data_base = "../include/data_base.php";
    } else {
        $data_base = "../include/data_base.php";
    }
    include($data_base);
    
    $vha_day_time = date('Ymd',time());    
    
    $vha_day_sql = mysqli_query($mysqli, "SELECT vha_id_d FROM vital_day_all where vha_time_d = '{$vha_day_time}'");
    $vha_day_rows = mysqli_num_rows($vha_day_sql);
    if ($vha_day_rows) {
        $sql = "UPDATE vital_day_all SET vha_member_count_d = vha_member_count_d+$member_count,vha_member_vip1_d = vha_member_vip1_d+$member_vip1,vha_member_vip2_d = vha_member_vip2_d+$member_vip2,vha_business_d = vha_business_d+$business,vha_price_d = vha_price_d+$price,vha_real_price_d = vha_real_price_d+$real_price,vha_supply_price_d = vha_supply_price_d+$supply_price,vha_margin_price_d = vha_margin_price_d+$margin_price,vha_surplus_price_d = vha_surplus_price_d+$surplus_price,vha_sales_d = vha_sales_d+$sales,vha_withdraw_gold_d = vha_withdraw_gold_d+$withdraw_gold,vha_withdraw_commission_d = vha_withdraw_commission_d+$withdraw_commission,vha_withdraw_partner_d = vha_withdraw_partner_d+$withdraw_partner where vha_time_d = '{$vha_day_time}'";
        mysqli_query($mysqli,$sql);
    } else {
        $sql = "INSERT INTO vital_day_all (vha_time_d,vha_member_count_d,vha_member_vip1_d,vha_member_vip2_d,vha_business_d,vha_price_d,vha_real_price_d,vha_supply_price_d,vha_margin_price_d,vha_surplus_price_d,vha_sales_d,vha_withdraw_gold_d,vha_withdraw_commission_d,vha_withdraw_partner_d) VALUES ('{$vha_day_time}','{$member_count}','{$member_vip1}','{$member_vip2}','{$business}','{$price}','{$real_price}','{$supply_price}','{$margin_price}','{$surplus_price}','{$sales}','{$withdraw_gold}','{$withdraw_commission}','{$withdraw_partner}')";
        mysqli_query($mysqli,$sql);
    }
}
?>