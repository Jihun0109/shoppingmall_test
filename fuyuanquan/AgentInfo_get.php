<?php
	$id = isset($_POST['id']) ? intval($_POST['id']) : 0;

	include( "../db_config.php" );
	include("admin_login.php");
	if (!strstr($admin_purview,"AgentInfo_list")) {
		echo "您没有权限访问此页";
		exit;
	}
	
	$ac_upper = $id;
	$query = ""; // query string buffer.

	$buffer = array();

	/* jh test begin */
	// $pay_agent = 100;
	// $ret = mysqli_query($mysqli, "SELECT * from teacher_list WHERE tl_id = 1795;");
	// $row_pay = mysqli_fetch_assoc($ret);

	// $province = $row_pay['tc_province1'];
	// $city = $row_pay['tc_city1'];
	// $area = $row_pay['tl_district1'];

	// // search province only.
	// $query_ai_1 = "SELECT ai_region_code, ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name = '{$province}';";
	// $result_ai_1 = mysqli_query($mysqli, $query_ai_1);

	// if ($result_ai_1 && $result_ai_1->num_rows > 0){
	// 	$row_ai_1 = mysqli_fetch_assoc( $result_ai_1 ); // fetch query result
	// 	$province_code = $row_ai_1['ai_region_code'];	// get and set province code
	// 	$ai1_total = $pay_agent * $row_ai_1['ai_rate']; // province rate
	// 	$ai1 = $ai1_total / $row_ai_1['ai_cnt'];		// provice agent profit
		
	// 	// search city with province code.
	// 	$query_ai_2 = "SELECT ai_region_code, ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name ='{$city}' AND ai_upper_code='{$province_code}';";		

	// 	$result_ai_2 = mysqli_query($mysqli, $query_ai_2);
	// 	if ($result_ai_2 && $result_ai_2->num_rows > 0){
	// 		$row_ai_2 = mysqli_fetch_assoc( $result_ai_2 );			// fetch query result
	// 		$city_code = $row_ai_2['ai_region_code'];				// get and set city code
	// 		$ai2_total = $pay_agent * $row_ai_2['ai_rate'];			// city rate
	// 		$ai2 = $ai1_total / $row_ai_21['ai_cnt'];				// city agent profit
			
	// 		// search area with city code.
	// 		$query_ai_3 = "SELECT ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name='{$area}' AND ai_upper_code='{$city_code}';";
	// 		$result_ai_3 = mysqli_query($mysqli, $query_ai_3);
	// 		if ($result_ai_3 && $result_ai_3->num_rows > 0){				
	// 			$row_ai_3 = mysqli_fetch_assoc( $result_ai_3 );			// fetch query result
	// 			$ai3_total = $pay_agent * $row_ai_3['ai_rate'];			// area rate
	// 			$ai3 = $ai1_total / $row_ai_3['ai_cnt'];				// area agent profit
			
	// 		}
	// 	}
	// }
	
	/* jh test ends*/

	$query = "SELECT * FROM fyq_region WHERE upper_region='{$ac_upper}' AND level < 4;";
	if ($result = mysqli_query($mysqli, $query))
	{
		while( $row = mysqli_fetch_assoc($result) )
		{
			$region_code = $row['CODE'];
			$row['rate'] = $row['level'] == 3?"0.8":"0.1";
			$row['cnt'] = 20;

			// get region code. if not exist insert default value into db and return it.
			$query1 = "SELECT * FROM agentinfo WHERE ai_region_code='{$region_code}';";//

			if ($result1 = mysqli_query($mysqli, $query1)){
				if ($row1 = mysqli_fetch_assoc($result1)){
					$row['rate'] = $row1['ai_rate'];
					$row['cnt'] = $row1['ai_cnt'];
				}
				else{
					// agentinfo not exist
					$region_code = $row['CODE'];
					$region_name = $row['region_name_c'];
					$rate = $row['rate'];
					$cnt = $row['cnt'];

					$query2 = "INSERT INTO agentinfo (ai_region_code, ai_upper_code, ai_region_name, ai_rate,ai_cnt) 
							VALUES ('{$region_code}','{$ac_upper}','{$region_name}','{$rate}','{$cnt}');";
					mysqli_query($mysqli, $query2);
				}
			}
			else{
				
			}

			$row['state'] = $row['level'] > 2?'open':'closed';
			//$row['state'] = has_child($row['ac_code']) ? 'closed' : 'open';
			$row['id'] = $region_code;
			$row['name'] = $row['region_name_c'];

			
			array_push($buffer, $row);
		}
	}

	echo json_encode($buffer);
?>