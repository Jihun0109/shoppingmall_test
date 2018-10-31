<?php 
function goods_payment_confirm($trade_num,$member_phone,$member_id) {
	include("include/data_base.php");
	$query_card = "SELECT surplus_num FROM vip_card where user_phone = '{$member_phone}' limit 1";
	if ($result_card = mysqli_query($mysqli, $query_card))
	{
		$rows_card = mysqli_num_rows($result_card);
		if ($rows_card) {
			$row_card = mysqli_fetch_assoc($result_card);
			$surplus_num = $row_card['surplus_num'];
		} else {
			$surplus_num = 0;
		}
	}
	$query_goods_order = "SELECT * FROM goods_order where goods_tradeno = '{$trade_num}'";
	if ($result_goods_order = mysqli_query($mysqli, $query_goods_order))
	{
		$rows_goods_order = mysqli_num_rows($result_goods_order);
		if ($rows_goods_order) {
			$all_surplus = $surplus_num;
			$all_point = 0;
			for ($i=0;$row_goods_order = mysqli_fetch_assoc($result_goods_order);$i++) {
				$quantity = $row_goods_order['quantity'];
				$point = $row_goods_order['point'];
				$price = $row_goods_order['price'];
				$goods_id = $row_goods_order['id'];
				$item_id = $row_goods_order['item_id'];
				for ($gpc=0;$gpc<$quantity;$gpc++) {
					if ($all_surplus>=$point) {
						$all_point = $all_point+$point;
						mysqli_query($mysqli,"UPDATE goods_order SET goods_state = '1' where id = '{$goods_id}'");
						mysqli_query($mysqli,"INSERT INTO vip_card_log (user_id, item_id, goods_id, consume_point, consume_price, surplus_point) VALUES ('{$member_id}', '{$item_id}', '{$goods_id}', '{$point}', '0', '0')");
					} else {
						mysqli_query($mysqli,"UPDATE goods_order SET goods_state = '2' where id = '{$goods_id}'");
						mysqli_query($mysqli,"INSERT INTO vip_card_log (user_id, item_id, goods_id, consume_point, consume_price, surplus_point) VALUES ('{$member_id}', '{$item_id}', '{$goods_id}', '0', '{$price}', '0')");
					}
				}
			}
			mysqli_query($mysqli,"UPDATE vip_card SET surplus_num = surplus_num-$all_point where user_phone = '{$member_phone}'");
		}
	}
}
?>