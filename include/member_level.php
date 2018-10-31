<?php 
	function member_level($mld) {
		$level[1] = "普通会员";
		$level[2] = "年卡会员";
		$level[3] = "经纪人权";
		$level[4] = "合伙人权";
		$level[5] = "区代理";
		$level[6] = "市代理";
		$level[7] = "省代理";
		$level[18] = "老师";
		$level[19] = "准股东";
		$level[20] = "股东";
		return $level[$mld];
	}

	function get_user_sales_permission(  $mysqli, $mb_phone )
	{
		$query = "SELECT * FROM `merchant_entry` WHERE `me_user` = $mb_phone ";
		$result = mysqli_query( $mysqli , $query);
		if ($result) {
			$row = mysqli_fetch_assoc( $result );
			return $row['me_state'];
		} else {
			return false;
		}
	}
?>