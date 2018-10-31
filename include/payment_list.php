<?php 
	header('Content-Type: text/html; charset=utf-8');
	include ("../db_config.php");

	$pay_id = $_POST['id'] ? $_POST['id'] : "";
	$area_id = $_POST['area_id'] ? $_POST['area_id'] : "";

	function get_order_info( $result , $mysqli )
	{
		$data = array();
		$i = 0;
		while ( $row = mysqli_fetch_assoc( $result ) ) {
            $pay_shop = $row[ 'pay_shop' ];
            $pay_count = $row[ 'pay_count' ];
            $pay_cate = $row[ 'pay_cate' ];
            $pay_shop = $row[ 'pay_shop' ];
            $pay_member = $row['pay_member'];
            $shipping_id = $row['shipping_id'];
	        $pay_member_nick = $row['mb_nick'];
            $pay_time = $row['pay_time'];
			$mb_receiving_address = $row['mb_receiving_address'];

            $query_shop = "SELECT * FROM teacher_list where tl_id = $pay_shop";
            $result_shop = mysqli_query( $mysqli, $query_shop );
            $row_shop = mysqli_fetch_assoc( $result_shop );

            if ($row_shop['tl_point_type'] == 3) {
                $tl_price = ($row_shop['tl_price']/10)."折";
                $tl_original = $row['pay_price'];
                $pay_price = ($tl_original*$row_shop['tl_price'])/100;

                // 收货地址。
            } else {
                $tl_price = "￥".$row_shop['tl_price'];
                $tl_original = $row_shop['tl_original'];
                $pay_price = $row['pay_price'];
            }
		
			$address = get_shipping_address($mysqli, $shipping_id) ? get_shipping_address($mysqli, $shipping_id) : "没有收货地址。";
			if($row['pay_cate'] == "partner"){
				$type = 'join';
			} else {
				$type = 'company';
			}
            $data[$i]['pay_shop'] 		= "/detailed_view.php?view=" . $row['pay_shop'] . "&type=" . $type;
            $data[$i]['pay_id'] 		= $row['pay_id'];
            $data[$i]['tc_province1'] 	= $row_shop['tc_province1'];
            $data[$i]['tc_city1'] 		= $row_shop['tc_city1'];
            $data[$i]['tl_district1'] 	= $row_shop['tl_district1'];
            $data[$i]['tc_mainimg'] 	= $row_shop['tc_mainimg'];
            $data[$i]['tl_name'] 		= $row_shop['tl_name'];
            $data[$i]['tl_price'] 		= $tl_price;
            $data[$i]['tl_original'] 	= $tl_original;
            $data[$i]['pay_member'] 	= $pay_member;
            $data[$i]['pay_member_nick'] = $pay_member_nick;
            $data[$i]['pay_time'] 		= $pay_time;
            $data[$i]['pay_price'] 		= $pay_price;
            $data[$i]['pay_count'] 		= $pay_count;
            $data[$i]['address'] 		= $address;
			$data[$i]['mb_address'] 	= $mb_receiving_address;
            $i ++;
        }

        return $data;
	}

	function get_shipping_address($mysqli, $shipping_id)
	{
		$query = "SELECT * FROM `shipping address` WHERE id = $shipping_id";
		if( $shipping_id > 0){
			if($result = mysqli_query( $mysqli, $query )){
				$row = mysqli_fetch_assoc( $result );
				return $row['mb_ship_province'] . "," . $row['mb_ship_city'] . "," . $row['mb_ship_district'] . "," . $row['mb_receiving_address'] ;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}


	if ($_POST) {
		switch ($_GET['action']) {
			case 'sending':
				$query = "UPDATE `payment_list` SET `ship_status` = '2' WHERE `payment_list`.`pay_id` = '" . $pay_id . "'";
				if( $result = mysqli_query($mysqli, $query) ){
					$data['status'] = "success";
				} else {
					$data['status'] = "false";
				}

				echo json_encode($data);
				break;
			case 'area':
				$mb_id = $_POST['mb_id'];
				if ($mb_id) {
					$query = "SELECT * , payment_list.mb_receiving_address FROM payment_list left join fyq_member on `payment_list`.`pay_member` = `fyq_member`.`mb_phone` left join teacher_list on payment_list.pay_shop = teacher_list.tl_id where  pay_status <> '10' and `payment_list`.pay_shop in (select tl_id from teacher_list where tl_phone='{$mb_id}') and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1'";
				} else {
					$query = "SELECT * FROM payment_list left join fyq_member on `payment_list`.`pay_member` = `fyq_member`.`mb_phone` where  pay_status <> '10' and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1'";  
				}
				
				if ($area_id == 4) {
					$query .= " and pay_status = '1' and ship_status = '3' order by pay_id desc;";
					$result = mysqli_query( $mysqli, $query);
					if ($result) {
						$data['data'] = get_order_info( $result , $mysqli);
						$data['status'] = "success";
					} else {
						$data['status'] = "error";
					}
					
				} else if( $area_id == 3 || $area_id == 6 ){
					$query .= " and pay_status = '1' and ship_status = '1' order by pay_id desc;";
					$result = mysqli_query( $mysqli, $query);
					if ($result) {
						$data['data'] = get_order_info( $result , $mysqli);
						$data['status'] = "success";
					} else {
						$data['status'] = "error";
					}
				} else if( $area_id == 5 ){
					$query .= "and ship_status = '4' order by pay_id desc;";
					$result = mysqli_query( $mysqli, $query);
					if ($result) {
						$data['data'] = get_order_info( $result , $mysqli);
						$data['status'] = "success";
						
					} else {
						$data['status'] = "error";
					}
				} else if( $area_id == 7 ){

					$query .= "and teacher_list.delete_status != '0' and pay_status = '0' order by pay_id desc;";
					$result = mysqli_query( $mysqli, $query);
					if ($result) {
						$data['data'] = get_order_info( $result , $mysqli);
						$data['status'] = "success";
					} else {
						$data['status'] = "error";
					}
				} else if( $area_id == 8 ){
					$query .= " and pay_status = '1' and ship_status = '2' order by pay_id desc;";
					$result = mysqli_query( $mysqli, $query);
					if ($result) {
						$data['data'] = get_order_info( $result , $mysqli);
						$data['status'] = "success";
					} else {
						$data['status'] = "error";
					}
				} else if( $area_id == 9 ){
					$data['data'] = "";
					$data['status'] = "success";
				}

				echo json_encode($data);
				break;
			case 'pay_status_close':
				$mb_id = $_POST['mb_id'];
				$query = "UPDATE `payment_list` SET `ship_status` = '4' WHERE `payment_list`.`pay_id` = '" . $pay_id . "'";
				if( $result = mysqli_query($mysqli, $query) ){
					$data['status'] = "success";
				} else {
					$data['status'] = "false";
				}

				echo json_encode($data);
				break;
			case 'get_count':

				$mb_id = $_POST['mb_id'];
				$query = "SELECT COUNT(pay_id) FROM payment_list left join teacher_list on payment_list.pay_shop = teacher_list.tl_id where pay_status <> '10' and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1' and `payment_list`.pay_shop in (select tl_id from teacher_list where tl_phone='{$mb_id}')";
				if ( $mb_id > 0 ) {
					$query1 = $query . " and pay_status = '1' and ship_status = '1'";
					$query2 = $query . " and teacher_list.delete_status != '0' and pay_status = '0' and ship_status = '0'";
					$query3 = $query . " and pay_status = '1' and ship_status = '2'";
				} else {
					$query1 = "SELECT COUNT(pay_id) FROM payment_list where pay_status <> '10' and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1' and pay_status = '1' and ship_status = '1'";
					$query2 = "SELECT COUNT(pay_id) FROM payment_list where pay_status <> '10' and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1' and ship_status = '0' and pay_status = '0'";
					$query3 = "SELECT COUNT(pay_id) FROM payment_list where pay_status <> '10' and (pay_cate = 'busines' OR pay_cate = 'charge') and  `ship_status` != '-1' and pay_status = '1' and ship_status = '2'";	
				}

				

	            $result1 = mysqli_query( $mysqli, $query1 );
	            $result2 = mysqli_query( $mysqli, $query2 );
	            $result3 = mysqli_query( $mysqli, $query3 );
	            
	            $row1 = mysqli_fetch_assoc( $result1 );
	            $row2 = mysqli_fetch_assoc( $result2 );
	            $row3 = mysqli_fetch_assoc( $result3 );

				$data['sending'] 	= $row1['COUNT(pay_id)'];
				$data['not_pay'] 	= $row2['COUNT(pay_id)'];
				$data['sended'] 	= $row3['COUNT(pay_id)'];

				echo json_encode($data);

				break;
			
			default:
				$data['status'] = "error";
				echo json_encode($data);

				break;
		}
	}
?>