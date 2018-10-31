<?php 
include( "../../include/data_base.php" );
$last_time = date("Ym",strtotime("last month"));
$this_time = date("Ym",time());

if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 0;
}

if (isset($_POST['recommend_phone'])) {
    $recommend_phone = $_POST['recommend_phone'];
} else {
    $recommend_phone = '';
}

if (isset($_POST['startime'])) {
    $startime = $_POST['startime'];
} else {
    $startime = '';
}

if (isset($_POST['endtime'])) {
    $endtime = $_POST['endtime'];
} else {
    $endtime = '';
}

if (isset($_POST['sales_order_by'])) {
    $sales_order_by = $_POST['sales_order_by'];
} else {
    $sales_order_by = '';
}

if ($recommend_phone) {
    $recommend_sql = " and teacher_list.item_recommend = '{$recommend_phone}'";
} else {
    $recommend_sql = '';
}

if ($startime) {
    $sales_sql = $startime;
} else {
    $sales_sql = $this_time;
}

if ($sales_order_by) {
    if ($sales_order_by == "sales") {
        $sales_order_sql = " order by vital_day_item.d_sales desc";
    } else if ($sales_order_by == "gross") {
        $sales_order_sql = " order by vital_day_item.d_gross_price desc";
    }
} else {
    $sales_order_sql = " order by vital_day_item.d_sales desc";
}

$item_page = $page*20;
$query = "SELECT teacher_list.item_recommend, teacher_list.tl_name,teacher_list.tl_phone, vital_day_item.d_id, vital_day_item.d_item, sum(vital_day_item.d_sales) as sales,sum(vital_day_item.d_recommend_yes) as recommend_yes,sum(vital_day_item.d_recommend_no) as recommend_no,sum(vital_day_item.d_original_price) as original_price,sum(vital_day_item.d_sale_price) as sale_price,sum(vital_day_item.d_supply_price) as supply_price FROM teacher_list,vital_day_item where teacher_list.tl_id=vital_day_item.d_item and vital_day_item.d_time >= '{$startime}' and vital_day_item.d_time <= '{$endtime}'{$recommend_sql} group by vital_day_item.d_item{$sales_order_sql} limit $item_page,20";                                       

if ($result = mysqli_query($mysqli, $query))
{
    $item_rows = mysqli_num_rows($result);
    if ($item_rows) {
    $sales_json = '';
    while( $row = mysqli_fetch_assoc($result) ){
        $item_phone = $row['tl_phone'];
        $query_member_plus = "SELECT * FROM vital_day_member_plus where d_phone = '{$item_phone}'";
        if ($result_member_plus = mysqli_query($mysqli, $query_member_plus))
        {
            $row_member_plus = mysqli_fetch_assoc($result_member_plus);
            $uid = $row['d_id'];
            $item_name = $row['tl_name'];
            $item_sales = $row['sales'];
            $recommend_yes = $row['recommend_yes'];
            $recommend_no = $row['recommend_no'];
            $item_recommend = $row['item_recommend'];
            $total_gold = Number_format($row_member_plus['d_total_gold'],2);
            $commission_all = Number_format($row_member_plus['d_commission_all'],2);
            $original_price = Number_format($row['d_original_price'],2);
            $sale_price = Number_format($row['d_sale_price'],2);
            $supply_price = Number_format($row['d_supply_price'],2);
            $gross_price = $sale_price - $supply_price;
            
            $query_member_recommend = "SELECT mb_nick FROM fyq_member where mb_phone = '{$item_recommend}'";
            if ($result_member_recommend = mysqli_query($mysqli, $query_member_recommend))
            {
                $row_member_recommend = mysqli_fetch_assoc($result_member_recommend);
                $member_recommend_nick = $row_member_recommend['mb_nick'];
            }
            
            $sales_json .= "{\"uid\":\"$uid\",\"item_name\":\"$item_name\",\"item_phone\":\"$item_phone\",\"item_sales\":\"$item_sales\",\"recommend_yes\":\"$recommend_yes\",\"recommend_no\":\"$recommend_no\",\"total_gold\":\"$total_gold\",\"commission_all\":\"$commission_all\",\"original_price\":\"$original_price\",\"sale_price\":\"$sale_price\",\"supply_price\":\"$supply_price\",\"item_recommend\":\"$item_recommend\",\"member_recommend_nick\":\"$member_recommend_nick\",\"gross_price\":\"$gross_price\"},";
            
        }
    }
        $next_page = $page+1;
        echo "[".$sales_json."{\"page\":\"$next_page\"}]";
    } else {
        echo 0;
    }
}
?>