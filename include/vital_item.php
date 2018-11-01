<?php 
function vital_tiem($item,$recommend_yes,$recommend_no,$follow_yes,$follow_no,$sales,$original_price,$sale_price,$supply_price,$point,$payment_method) {
    if ($payment_method == "wechat") {
        $data_base = "../../include/data_base.php";
    } else if ($payment_method == "alipay") {
        $data_base = "data_base.php";
    } else {
        $data_base = "../include/data_base.php";
    }
    include($data_base);
    $vital_day_time = date('Ymd',time());
    $gross_price = $sale_price - $supply_price;
    
    $vital_day_sql = mysqli_query($mysqli, "SELECT d_id FROM vital_day_item where d_item = '{$item}' and d_time = '{$vital_day_time}'");
    $vital_day_rows = mysqli_num_rows($vital_day_sql);
    if ($vital_day_rows) {
        $sql = "UPDATE vital_day_item SET d_recommend_yes = d_recommend_yes+$recommend_yes,d_recommend_no = d_recommend_no+$recommend_no,d_follow_yes = d_follow_yes+$follow_yes,d_follow_no = d_follow_no+$follow_no,d_sales = d_sales+$sales,d_original_price = d_original_price+$original_price,d_sale_price = d_sale_price+$sale_price,d_supply_price = d_supply_price+$supply_price,d_point = d_point+$point,d_gross_price = d_gross_price+$gross_price where d_item = '{$item}' and d_time = '{$vital_day_time}'";
        mysqli_query($mysqli,$sql);
    } else {
        $sql = "INSERT INTO vital_day_item (d_item,d_time,d_recommend_yes,d_recommend_no,d_follow_yes,d_follow_no,d_sales,d_original_price,d_sale_price,d_supply_price,d_point,d_gross_price) VALUES ('{$item}','{$vital_day_time}','{$recommend_yes}','{$recommend_no}','{$follow_yes}','{$follow_no}','{$sales}','{$original_price}','{$sale_price}','{$supply_price}','{$point}','{$gross_price}')";
        mysqli_query($mysqli,$sql);
    }
}
?>