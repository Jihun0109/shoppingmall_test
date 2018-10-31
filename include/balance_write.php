<?php 
function balance_write($payment_method,$money,$way,$status,$phone,$caption,$description,$cate,$fornow,$point,$before_money,$after_money,$service_money,$service_point,$trade_no,$trade_no_alipay,$payment_id) {
    if ($payment_method == "wechat") {
        $data_base = "../../include/data_base.php";
    } else if ($payment_method == "alipay") {
        $data_base = "../include/data_base.php";
    } else {
        $data_base = "../include/data_base.php";
    }
    include($data_base);
    
    $sql = "INSERT INTO balance_details (t_money,t_way,t_status,t_phone,t_caption,t_description,t_cate,t_fornow,t_point,t_before_money,t_after_money,t_service_money,t_service_point,t_trade_no,t_trade_no_alipay,t_payment_id) VALUES ('{$money}','{$way}','{$status}','{$phone}','{$caption}','{$description}','{$cate}','{$fornow}','{$point}','{$before_money}','{$after_money}','{$service_money}','{$service_point}','{$trade_no}','{$trade_no_alipay}','{$payment_id}')";
    mysqli_query($mysqli,$sql);
    }
?>