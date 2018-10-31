<?php 
include("../../include/data_base.php");

if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
} else {
    exit();
}
if (isset($_POST['goods_name'])) {
    $goods_name = $_POST['goods_name'];
} else {
    exit();
}
if (isset($_POST['goods_point'])) {
    $goods_point = $_POST['goods_point'];
} else {
    exit();
}
if (isset($_POST['goods_price'])) {
    $goods_price = $_POST['goods_price'];
} else {
    exit();
}
if (isset($_POST['goods_memo'])) {
    $goods_memo = $_POST['goods_memo'];
} else {
    exit();
}

$union_goods_join = mysqli_query($mysqli,"INSERT INTO goods_list (item_id, goods_name,goods_point,goods_price,goods_memo) VALUES ('{$item_id}', '{$goods_name}','{$goods_point}','{$goods_price}','{$goods_memo}')");
if ($union_goods_join) {
    echo 1;
} else {
    echo 0;
}
?>