<?php
	include( "../db_config.php" );
	include("admin_login.php");
	if (!strstr($admin_purview,"AgentInfo_up")) {
		echo "您没有权限访问此页";
		exit;
	}
	
	if (isset($_POST["ai"])) {
	    $ai = $_POST["ai"];
	} else {
	    $ai = '';
	}

	if ($ai != ""){
		$ai_region_code = $ai['CODE'];
		$rate = $ai['rate'];
		$cnt = $ai['cnt'];

		$upper_region = $ai['upper_region'];
		$level = $ai['level'];

		$query = "UPDATE agentinfo SET ai_rate = '{$rate}', ai_cnt = '{$cnt}' WHERE ai_region_code = '{$ai_region_code}';";
		if ($level == 3) // could not update ai_rate for area agent
			$query = "UPDATE agentinfo SET ai_cnt = '{$cnt}' WHERE ai_region_code = '{$ai_region_code}';";

		$sql_success = mysqli_query($mysqli,$query);
		if ($sql_success) {
			echo 1;
		} else {
			echo 0;
		}

		if ($level == 1){
			$query1 = "SELECT CODE FROM fyq_region WHERE upper_region='{$ai_region_code}' AND level < 4;";
			if ($result = mysqli_query($mysqli, $query1))
			{
				while( $row = mysqli_fetch_assoc($result) )
				{
					// iterate cities.
					$city_code = $row['CODE'];
					echo $city_code;
					echo ":";
					// get region info
					$query2 = "SELECT ai_rate FROM agentinfo WHERE ai_region_code='{$city_code}';";
					if ($result1 = mysqli_query($mysqli, $query2))
					{
						$city_agent = mysqli_fetch_assoc($result1);
						$city_rate = $city_agent['ai_rate'];

						$area_rate = 1 - (floatval($city_rate) + floatval($rate));						

						$query3 = "UPDATE agentinfo SET ai_rate = '{$area_rate}'  WHERE ai_upper_code = '{$city_code}';";
						$sql_success = mysqli_query($mysqli,$query3);
					}
				}
			}
		}
		elseif ($level == 2) {
			$query1 = "SELECT ai_rate FROM agentinfo WHERE ai_region_code='{$upper_region}';";			

			if ($result = mysqli_query($mysqli, $query1))
			{
				$row = mysqli_fetch_assoc($result);
				$upper_rate = $row['ai_rate'];

				$area_rate = 1 - (floatval($upper_rate) + floatval($rate));
				$query3 = "UPDATE agentinfo SET ai_rate = '{$area_rate}'  WHERE ai_upper_code = '{$ai_region_code}';";
				$sql_success = mysqli_query($mysqli,$query3);
			}
		}
	}
?>