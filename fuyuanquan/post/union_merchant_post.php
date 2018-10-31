<?php 
include("../../include/data_base.php");

if (isset($_POST['type'])) {
    $type = $_POST['type'];
} else {
    $type = 'list';
}

if ($type == 'search') {
    if (isset($_POST['merchant_phone'])) {
        $merchant_phone = $_POST['merchant_phone'];
        //$query_union = "SELECT * FROM teacher_list where tl_phone = '{$merchant_phone}' order by tl_id desc limit 30";
        $query_union = "SELECT teacher_list.*, union_merchant.id FROM teacher_list LEFT JOIN union_merchant ON teacher_list.tl_id=union_merchant.item_id where teacher_list.tl_phone = '{$merchant_phone}' ORDER BY teacher_list.tl_id limit 10";
    } else {
        exit();
    }
} else if ($type == 'list') {
    $query_union = "SELECT teacher_list.*,union_merchant.id FROM teacher_list, union_merchant WHERE teacher_list.tl_id = union_merchant.item_id limit 10";
} else {
    exit();
}

if ($result_union = mysqli_query($mysqli, $query_union))
{
    $union_rows = mysqli_num_rows($result_union);
    if ($union_rows) {
        $union_json = '';
        for ($i=0;$row_union = mysqli_fetch_assoc($result_union);$i++) {
            if (empty($row_union['id'])) {
                $item_state = 0;
            } else {
                $item_state = 1;
            }
            $item_id = $row_union['tl_id'];
            $item_name =  $row_union['tl_name'];
            $item_phone = $row_union['tl_phone'];
            $item_logo = $row_union['tc_mainimg'];
            $item_province = $row_union['tc_province1'];
            $item_city = $row_union['tc_city1'];
            $item_district = $row_union['tl_district1'];
            $union_json .= "{\"item_id\":\"$item_id\",\"item_name\":\"$item_name\",\"item_phone\":\"$item_phone\",\"item_logo\":\"$item_logo\",\"item_province\":\"$item_province\",\"item_city\":\"$item_city\",\"item_district\":\"$item_district\",\"item_state\":\"$item_state\"},";
            $union_max_page = 0;
        }
    } else {
        $union_max_page = 0;
    }
}
echo "[".$union_json."{\"page\":\"$union_max_page\"}]";
?>