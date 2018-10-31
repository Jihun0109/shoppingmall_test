<?php 
include "../include/data_base.php";
include "../include/recomend_level.php";
if (isset($_POST["phone"])) {
    $phone = $_POST["phone"]; 
} else {
    $phone = '';
}
if (isset($_POST["nick"])) {
    $nick = $_POST["nick"];
} else {
    $nick = '';
}
if (isset($_POST["pass"])) {
    $pass = $_POST["pass"];
} else {
    $pass = '';
}
if (isset($_POST["code"])) {
    $code = $_POST["code"]; 
} else {
    $code = '';
}
if (isset($_POST["recommend"])) {
    $recommend = $_POST["recommend"];
} else {
    $recommend = '';
}
if (isset($_POST["recommend_phone"])) {
    $recommend_phone = $_POST["recommend_phone"];
} else {
    $recommend_phone = '';
}
if (isset($_POST["province1"])) {
    $province1 = $_POST["province1"];
} else {
    $province1 = '';
}
if (isset($_POST["city1"])) {
    $city1 = $_POST["city1"];
} else {
    $city1 = '';
}
if (isset($_POST["district1"])) {
    $district1 = $_POST["district1"];
} else {
    $district1 = '';
}
$pass = md5($pass."fyq");

$phone_code = mysqli_query($mysqli, "SELECT count(*) FROM phone_code where pco_number = '{$phone}' and pco_code = '{$code}'");
$phone_rs=mysqli_fetch_array($phone_code,MYSQLI_NUM);

// For debug
//$phone_totalNumber=$phone_rs[0];
$phone_totalNumber = 1;
	if ($phone_totalNumber) {
	$member_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_phone = '{$phone}'");
	$member_rs=mysqli_fetch_array($member_count,MYSQLI_NUM);
	$member_totalNumber=$member_rs[0];
	if ($member_totalNumber) {
		echo 1;
	} else {
	if (!$recommend) {
		if ($recommend_phone) {
			$recommend_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_phone = '{$recommend_phone}'");
			$recommend_rs=mysqli_fetch_array($recommend_count,MYSQLI_NUM);
			$recommend_Number=$recommend_rs[0];
			if ($recommend_Number) {
				$recommend = $recommend_phone;
			} else {
				echo 10;
				exit;
			}
		} else {
			$query_agent_time = "SELECT * FROM fyq_member where mb_level > '4' and mb_level < '8' and (mb_province = '{$province1}' or mb_city = '{$city1}' or mb_area = '{$district1}') ORDER BY mb_agent_time limit 1";
			if ($result_agent_time = mysqli_query($mysqli, $query_agent_time))
			{
				$row_agent_time = mysqli_fetch_assoc($result_agent_time);
				if ($row_agent_time['mb_phone']) {
					$recommend = $row_agent_time['mb_phone'];
					$agent_time = time();
					$sql_member_agent = mysqli_query($mysqli,"UPDATE fyq_member SET mb_agent_time = '{$agent_time}' WHERE mb_phone = '{$recommend}'");
				} else {
					$recommend = "13844338870";
				}
			}
		}
	} else {
		$query_agent_time = "SELECT * FROM fyq_member where mb_id = '{$recommend}'";
		if ($result_agent_time = mysqli_query($mysqli, $query_agent_time))
		{
			$row_agent_time = mysqli_fetch_assoc($result_agent_time);
			if ($row_agent_time['mb_phone']) {
				$recommend = $row_agent_time['mb_phone'];
			} else {
				$recommend = "13844338870";
			}
		}
	}
	$sql = "INSERT INTO fyq_member (mb_phone, mb_nick, mb_pass, mb_recommend, mb_level, mb_province, mb_city, mb_area, mb_point) VALUES ('{$phone}', '{$nick}', '{$pass}', '{$recommend}', '1', '{$province1}', '{$city1}', '{$district1}', '100')";
		$sql_user = mysqli_query($mysqli,$sql);
		if ($sql_user) {
			setcookie("member", $phone, time()+3600*24*365,"/");
			echo "ok";
			$sql_member_recommend_point = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point+300 WHERE mb_phone = '{$recommend}'");
            recommend_level($phone,$recommend,"../include/data_base.php");
		} else {
			echo "no";
		}
	}
} else {
	echo "coderr";
}
?>