<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_list")) {
	echo "您没有权限访问此页";
	exit;
}
$phonenumber = $_POST["phonenumber"];
$ps_profit = $_POST["ps_profit"];
$ps_level = $_POST["ps_level"];

$ps_title = "";


/* Recommend Member Chain */
// $first_recommend_member = $phonenumber;
// $array_recommend_members = [$first_recommend_member];
// $recommend_deep = 1;

// while (true){
// 	$query_recommend_chain = "SELECT mb_recommend FROM fyq_member WHERE mb_phone = {$first_recommend_member};";
// 	if ($result_chain = mysqli_query($mysqli, $query_recommend_chain)){
// 		if ($result_chain->num_rows == 0)
// 			break;
// 		$row_chain = mysqli_fetch_assoc($result_chain);
// 		if (!$row_chain['mb_recommend'] || $row_chain['mb_recommend'] == "" )
// 			break;

// 		array_push($array_recommend_members, $row_chain['mb_recommend']);
// 		$recommend_deep ++;
// 		$first_recommend_member = $row_chain['mb_recommend'];
		
// 	} else {
// 		break;
// 	}
// }

if ($ps_level == 1){
	$get_member_query = "SELECT * FROM fyq_member WHERE mb_phone = {$phonenumber};";
	if ($result_member = mysqli_query($mysqli, $get_member_query))
	{
		if ($result_member->num_rows > 0){
			$row_members = mysqli_fetch_assoc($result_member);
			$ps_title = $row_members['mb_nick'];

			$add_query = "INSERT INTO profit_setting (ps_title, ps_type, ps_profit, ps_enabled, ps_level, ps_phonenumber) VALUES ('{$ps_title}', 'group', {$ps_profit}, 1, {$ps_level}, {$phonenumber})";
			$result_add = mysqli_query($mysqli, $add_query);
			echo 1;
		} else {
			echo 2;
		}		
	} else {
		echo 2;
	}
} else if ($ps_level == 2){
	$get_shares_query = "SELECT * FROM profit_setting WHERE ps_level = {$ps_level};";
	if ($result_shares =  mysqli_query($mysqli, $get_shares_query)){
		$current_index = $result_shares->num_rows + 1;
		$ps_title = $current_index."차 추천인";
		$ps_type = "recommend_".$current_index;
		$add_query = "INSERT INTO profit_setting (ps_title, ps_type, ps_profit, ps_enabled, ps_level, ps_phonenumber) VALUES ('{$ps_title}', '{$ps_type}', {$ps_profit}, 1, {$ps_level}, null)";
		$result_add = mysqli_query($mysqli, $add_query);
		echo 1;
	} else {
		echo 0;
	}
}

?>