<?php
	header('Content-Type: text/html; charset=utf-8');
	include ("../db_config.php");

	function mb_exist_shipping( $mb_login, $mysqli ){
		$query = "SELECT mb_id, mb_receiving_address FROM fyq_member where mb_phone = $mb_login";
		if ($result = mysqli_query($mysqli, $query)){
			$row_receiving_address = mysqli_fetch_assoc($result);
			return $row_receiving_address;
		} else {
			return false;
		}
	}
	
	function exist_shipping( $mb_id, $ship_adddress, $mysqli ){

		$query = "SELECT id FROM `shipping address` WHERE `mb_id` = $mb_id AND `mb_receiving_address` = '$ship_adddress'";
		if ($result = mysqli_query($mysqli, $query)){
			$row_id = mysqli_fetch_assoc($result);
			return $row_id['id'];
		} else {
			return false;
		}
	}

	function insert_shipping( $mb_id, $ship_adddress, $province1, $city1, $district1, $mysqli ){
		// $member_id, $_POST['shipping_address'], $_POST['province1'], $_POST['city1'], $_POST['district1'], $mysqli
		$query = "INSERT INTO `shipping address` (`id`, `mb_id`, `mb_receiving_address`, `mb_ship_province`, `mb_ship_city`, `mb_ship_district`, `status`) VALUES (NULL, '$mb_id', '$ship_adddress', '$province1', '$city1', '$district1', '0');";
		if ($result = mysqli_query($mysqli, $query)){
			return true;
		} else {
			return false;
		}
	}

	function view_shipping( $mb_id, $mysqli ){

		$query = "SELECT * FROM `shipping address` where mb_id = $mb_id ORDER BY `status` DESC";

		if ($result = mysqli_query($mysqli, $query)){
			return $result;
		} else {
			return false;
		}
	}

	function getting_shipping_address( $shipping_address_id, $status, $mysqli){
		$data = array();
		if ( $status == -1 ) {
		$query = "SELECT * FROM `shipping address` where `id` = $shipping_address_id";
		} else {
			$query = "SELECT * FROM `shipping address` where `id` = $shipping_address_id AND `status` = $status";
		}
		if( $result = mysqli_query($mysqli, $query) ){
			$row_data = mysqli_fetch_assoc($result);
			$data['id'] = $row_data['id'];
			$data['mb_id'] = $row_data['mb_id'];
			$data['mb_ship_province'] = $row_data['mb_ship_province'];
			$data['mb_ship_city'] = $row_data['mb_ship_city'];
			$data['mb_ship_district'] = $row_data['mb_ship_district'];
			$data['mb_receiving_address'] = $row_data['mb_receiving_address'];
			$data['status'] = $row_data['status'];
			return $data;
		} else {
			return false;
		}
	}

	function update_shipping_address( $shipping_address_id, $mb_id , $mb_receiving_address, $mb_ship_province, $mb_ship_city, $mb_ship_district, $status = 0, $mysqli ){
		$query = "UPDATE `shipping address` SET `mb_receiving_address` = '{$mb_receiving_address}', `mb_ship_province` = '{$mb_ship_province}', `mb_ship_city` = '{$mb_ship_city}', `mb_ship_district` = '{$mb_ship_district}' WHERE `id` = $shipping_address_id	;";
		$status = exist_shipping( $mb_id, $mb_receiving_address, $mysqli );
		// if($status == false ){
			if( $result = mysqli_query($mysqli, $query) ){
				$data['status'] = "success";
				return $data;
			} else {
				$data['status'] = "false";
				return $data;
			}
		/*} else {
			$data['status'] = "exist";
			return $data;
		}*/
		
	}

	function getting_default_shipping_address_id( $mb_id, $mysqli ){
		$data = array();
		
		$query = "SELECT * FROM `shipping address` where `mb_id` = $mb_id AND `status` = 1";
		
		if( $result = mysqli_query($mysqli, $query) ){
			$row_data = mysqli_fetch_assoc($result);
			$data['id'] = $row_data['id'];
			$data['mb_id'] = $row_data['mb_id'];
			$data['mb_receiving_address'] = $row_data['mb_receiving_address'];
			$data['status'] = $row_data['status'];
			return $data;
		} else {
			return false;
		}
	}

	function delete_shipping_address( $shipping_address_id, $mysqli ){
		$data = array();
		$query = "DELETE FROM `shipping address` WHERE `id` = $shipping_address_id";
		if( $result = mysqli_query($mysqli, $query) ){
			$data['status'] = "success";
			return $data;
		} else {
			$data['status'] = "false";
			return $data;
		}

	}

	function getting_default_shipping_address( $mb_id, $mysqli ){
		$query = "SELECT * FROM `shipping address` where `status` = 1 AND `mb_id` = $mb_id";
		if( $result = mysqli_query($mysqli, $query) ){
			if (mysqli_num_rows($result) <=1) {
				$row_data = mysqli_fetch_assoc($result);
				$data['mb_receiving_address'] = $row_data['mb_receiving_address'];
				$data['mb_ship_province'] = $row_data['mb_ship_province'];
				$data['mb_ship_city'] = $row_data['mb_ship_city'];
				$data['mb_ship_district'] = $row_data['mb_ship_district'];

				return $data;	
			} else {
				return "error";
			}
			
		} else {
			return false;
		}
	}

	if ($_POST) {
		
		switch ($_GET['action']) {
			case 'Save_Address':

				$data = array();
				$member_id 		= $_POST["id"];
				// $exist_shipping = exist_shipping( $member_id, $_POST['shipping_address'], $_POST['province1'], $_POST['city1'], $_POST['district1'], $mysqli );

				// if ( $exist_shipping == false ) {
				$result = insert_shipping( $member_id, $_POST['shipping_address'], $_POST['province1'], $_POST['city1'], $_POST['district1'], $mysqli );
					$data['status'] = "success";
				// } else {
					// $data['status'] = "exist";
				// }

				echo json_encode($data);

				break;

			case 'Get_Address':

				$shipping_address_id = $_POST['id'];
				$result = getting_shipping_address( $shipping_address_id , -1,  $mysqli );
				echo json_encode($result);

				break;

			case 'Update_Address':

				$shipping_address_id = $_POST['shipping_address_id'];
				$member_id = $_POST['member_id'];
				$shipping_address_status = $_POST['shipping_address_status'];
				$province1 = $_POST['province1'];
				$city1 = $_POST['city1'];
				$district1 = $_POST['district1'];
				$data = update_shipping_address( $shipping_address_id, $member_id, 	$_POST['shipping_address'], $province1, $city1, $district1,$shipping_address_status, $mysqli);
				echo json_encode($data);

				break;

			case 'Delete_Address':

				$shipping_address_id = $_POST['id'];
				$data = delete_shipping_address( $shipping_address_id , $mysqli );
				echo json_encode($data);

				break;

			case 'set_default_status':

				$data = array();

				$shipping_address_id = $_POST['id'];
				$mb_id = $_POST['mb_id'];
				
					$query = "UPDATE `shipping address` SET `status` = 0 WHERE `mb_id` = $mb_id AND `status` = 1;";
				mysqli_query($mysqli, $query);

				$query1 = "UPDATE `shipping address` SET `status` = 1 WHERE `id` = $shipping_address_id;";

				if( $result = mysqli_query($mysqli, $query1) ){
					$data['status'] = true;
				} else {
					$data['status'] = "false";
				}

				echo json_encode($data);

				break;

			case 'getting_default_shipping_address':
				
				$mb_id = $_POST['mb_id'];
				$data = getting_default_shipping_address($mb_id ,$mysqli);
				echo json_encode($data);
				
				break;

			default:
				break;
		}
	}

?>