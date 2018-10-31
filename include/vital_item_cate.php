<?php 
function vital_tiem_cate($cate,$order,$payment_method) {
    if ($payment_method == "wechat") {
        $data_base = "../../include/data_base.php";
    } else if ($payment_method == "alipay") {
        $data_base = "../include/data_base.php";
    } else {
        $data_base = "../include/data_base.php";
    }
    include($data_base);
    
    $vital_day_time = date('Ymd',time());
    
    $vital_day_sql = mysqli_query($mysqli, "SELECT vyic_id_d FROM vital_day_item_cate where vyic_cate_d = '{$cate}' and vyic_time_d = '{$vital_day_time}'");
    $vital_day_rows = mysqli_num_rows($vital_day_sql);
    if ($vital_day_rows) {
        $sql = "UPDATE vital_day_item_cate SET vyic_order_d = vyic_order_d+$order where vyic_cate_d = '{$cate}' and vyic_time_d = '{$vital_day_time}'";
        mysqli_query($mysqli,$sql);
    } else {
        $sql = "INSERT INTO vital_day_item_cate (vyic_time_d,vyic_cate_d,vyic_order_d) VALUES ('{$vital_day_time}', '{$cate}', '{$order}')";
        mysqli_query($mysqli,$sql);
    }
}
?>