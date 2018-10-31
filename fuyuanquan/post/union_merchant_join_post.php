<?php 
include("../../include/data_base.php");

if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
} else {
    exit();
}
$query_item = "SELECT tl_id,tl_phone FROM teacher_list where tl_id = '{$item_id}'";
if ($result_item = mysqli_query($mysqli, $query_item))
{
    $row_item = mysqli_fetch_assoc($result_item);
    $item_id = $row_item['tl_id'];
    $item_phone = $row_item['tl_phone'];
    
    $union_merchant_join = mysqli_query($mysqli,"INSERT INTO union_merchant (item_id, item_phone) VALUES ('{$item_id}', '{$item_phone}')");
    if ($union_merchant_join) {
        echo 1;
    } else {
        echo 0;
    }
}
?>