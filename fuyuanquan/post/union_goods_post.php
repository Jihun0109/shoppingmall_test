<?php 
include("../../include/data_base.php");

if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
} else {
    exit();
}

$query_goods = "SELECT * FROM goods_list WHERE item_id = '{$item_id}' order by id desc";
if ($result_goods = mysqli_query($mysqli, $query_goods))
{
    $goods_rows = mysqli_num_rows($result_goods);
    if ($goods_rows) {
        $goods_json = '';
        for ($i=0;$row_goods = mysqli_fetch_assoc($result_goods);$i++) {
            $item_id = $row_goods['item_id'];
            $goods_name =  $row_goods['goods_name'];
            $goods_point = $row_goods['goods_point'];
            $goods_price = $row_goods['goods_price'];
            $goods_memo = $row_goods['goods_memo'];
            $goods_time = $row_goods['goods_time'];
            $goods_json .= "{\"item_id\":\"$item_id\",\"goods_name\":\"$goods_name\",\"goods_point\":\"$goods_point\",\"goods_price\":\"$goods_price\",\"goods_memo\":\"$goods_memo\",\"goods_time\":\"$goods_time\"},";
        }
    }
}
$goods_json = substr($goods_json, 0, -1);
echo "[".$goods_json."]";
?>