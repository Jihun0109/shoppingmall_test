<?php
include("db_config.php");
include("include/send_post.php");
include('include/vital_member_plus.php');
include('include/vital_item.php');
include('include/vital_item_cate.php');
include('include/vital_all.php');

/** Virtual input data */

	$out_trade_no = "201811010512111541063531559461";//$_POST['out_trade_no'];
	$total_amount = 1000;//$_POST['total_amount'];
	//支付宝交易号
	$trade_no = "123456789123456789";//$_POST['trade_no'];
	//交易状态
	//$trade_status = $_POST['trade_status'];
	$payment_method = "alipay";	
/** Virtual input data */

$query_check = "SELECT pay_status FROM payment_list where pay_trade_no = '{$out_trade_no}'";
if ($result_check = mysqli_query($mysqli, $query_check))
{
    $row_check = mysqli_fetch_assoc($result_check);
    
}
if ($row_check['pay_status'] == '0') {

mysqli_query($mysqli,"UPDATE payment_list SET pay_status = '11' WHERE pay_trade_no = '{$out_trade_no}'");
if (!$total_amount || !$trade_no) {
	exit;
}
$member_id = $member_login;
if (!$member_id) {
	$query = "SELECT pay_member FROM payment_list where pay_trade_no = '{$out_trade_no}'";
    if ($result = mysqli_query($mysqli, $query))
    {
        $row = mysqli_fetch_assoc($result);
    }
    $member_id = $row['pay_member'];
    $query_notify = "SELECT * FROM fyq_member where mb_phone = '{$member_id}'";
    if ($result_notify = mysqli_query($mysqli, $query_notify))
    {
        $row_member = mysqli_fetch_assoc($result_notify);
    }
	
}

/** Get Profit Rates */
$rate_for_partners = 0.05; // Default 5%  주주가 가져가는 비률
$rate_for_agent = 0.1; // Default 10% 대리들이 가져가는 비률
$rate_for_our_company = 0.1; // 회사가 가지는 비률.

$arrGroupRates = [];
$arrSharedRates = [];

$shared_total_money = 0;
$group_total_money = 0;

$queryAllSettings = "SELECT * FROM profit_setting ORDER BY ps_type";
if ($result = mysqli_query($mysqli, $queryAllSettings))
{
	while( $row = mysqli_fetch_assoc($result) )
	{
		if ($row['ps_level'] == 2){ // 추천인들
			$row['money'] = $total_amount * $row['ps_profit'];
			array_push($arrSharedRates, $row);
		} else if ($row['ps_level'] == 1){ //기금회사들
			$row['money'] = $total_amount * $row['ps_profit'];
			$group_total_money += $row['money'];
			array_push($arrGroupRates, $row);
		} else if ($row['ps_type'] == "agents")
			$rate_for_agent = $row['ps_profit'];
		else if ($row['ps_type'] == "partner")
			$rate_for_partners = $row['ps_profit'];
		else if ($row['ps_type'] == "partner")
			$rate_for_our_company = $row['ps_profit'];
	}
}

/* Recommend Member Chain  Test with 13591856103*/  
// 모든 추천인들의 목록을 얻는다. => array_recommend_members
$first_recommend_member = $row_member['mb_recommend'];
$array_recommend_members = [$first_recommend_member];
$recommend_deep = 1;

while (true){
	$query_recommend_chain = "SELECT mb_recommend FROM fyq_member WHERE mb_phone = {$first_recommend_member};";
	if ($result_chain = mysqli_query($mysqli, $query_recommend_chain)){
		if ($result_chain->num_rows == 0)
			break;
		$row_chain = mysqli_fetch_assoc($result_chain);
		if (!$row_chain['mb_recommend'] || $row_chain['mb_recommend'] == "" )
			break;

		array_push($array_recommend_members, $row_chain['mb_recommend']);
		$recommend_deep ++;
		$first_recommend_member = $row_chain['mb_recommend'];

	} else {
		break;
	}
}

// 저리 여기서 수익금을 배당해 버리자!!!
$money_to_our_company = $total_amount * $rate_for_our_company;
$money_to_agents = $total_amount * $rate_for_agent;
$money_to_partners = $total_amount * $rate_for_partners;

for ($i=0; $i<count($arrSharedRates,0); $i++){
	if ($i < count($array_recommend_members,0)){
		$arrSharedRates[$i]['ps_phonenumber'] = $array_recommend_members[$i];
		$arrSharedRates[$i]['money'] = $arrSharedRates[$i]['ps_profit'] * $total_amount;
		$shared_total_money += $arrSharedRates[$i]['money'];
	} else {
		$arrSharedRates[$i]['money'] = 0;
	}
}

$rest_amount = $total_amount - $money_to_our_company - $money_to_agents - $money_to_partners - $shared_total_money - $group_total_money;
/** */

//利润分成比 리익분배비률
//分红是按照总毛利的70%计算的，剩余20%是给代理商的，8%是股金池，2%是备用金 배당금 총 총 이익의 70 %, 나머지 20 %는 에이전트, 8 %는 주식 풀, 2 %는 예비 자금입니다.
$t_percent = 0.7;
$agent_price_int = "1980.00";
$copartner_price_int = "9800.00";
$complete_time = date('Y-m-d H:i:s');
$day_time = date("Ymd",time());
$query = "SELECT * FROM payment_list where pay_member = '{$member_id}' and pay_status = '11' and pay_trade_no = '{$out_trade_no}' ORDER BY pay_id desc";
if ($result = mysqli_query($mysqli, $query))
{
    $payment_count_Number = mysqli_num_rows($result);
    if (!$payment_count_Number) {
        exit;
    }
	$row = mysqli_fetch_assoc($result);
	$pay_id = $row['pay_id'];
	$pay_shop = $row['pay_shop'];
	$pay_cate = $row['pay_cate'];
    $pay_point_commodity = $row['pay_point_commodity'];
	$share_phone = $row['share_phone'];
	$pay_prices = floatval($row['pay_price']);
	if ($pay_shop == "pay" && $pay_cate == "charge") { // 점수충전하는 경우
		$query_paymember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '{$member_id}'";
        if ($result_paymember = mysqli_query($mysqli, $query_paymember))
        {
            $row_paymember = mysqli_fetch_assoc($result_paymember);
            $paymember_mb_not_gold_before = $row_paymember['mb_not_gold'];
            $paymember_mb_not_gold_after = $paymember_mb_not_gold_before+$pay_prices;
        }
		$sql_member_charge = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$pay_prices, mb_not_gold = mb_not_gold+$pay_prices WHERE mb_phone = '{$member_id}'");
		if ($sql_member_charge) {
			$sql_payment = mysqli_query($mysqli,"UPDATE payment_list SET pay_status = '1', ship_status = '1', pay_real = '{$total_amount}', pay_trade_no_alipay = '{$trade_no}', payment_method = '{$payment_method}', pay_complete_time = '{$complete_time}' WHERE pay_trade_no = '{$out_trade_no}'");
			$sql_details_charge = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$pay_prices}', 'charge', '1', '充值' ,'{$member_id}', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$paymember_mb_not_gold_before}', '{$paymember_mb_not_gold_after}')");//余额充值记录
		}
		
	} else {
		
		$sql_payment = mysqli_query($mysqli,"UPDATE payment_list SET pay_status = '1', ship_status = '1',  pay_real = '{$total_amount}', pay_trade_no_alipay = '{$trade_no}', payment_method = '{$payment_method}', pay_complete_time = '{$complete_time}' WHERE pay_trade_no = '{$out_trade_no}'");
		
		$query_pay = "SELECT * FROM teacher_list where tl_id = '{$pay_shop}'";
//		$query_pay = "SELECT * FROM teacher_list where tl_id = '{$pay_shop}' and tl_phone = '{$member_id}'";
		$result_pay = mysqli_query($mysqli, $query_pay);

		if($pay_cate == "scan"){
			
				if ($result_pay = mysqli_query($mysqli, $query_pay))
				{
					// 상품정보 => $row_pay
				$row_pay = mysqli_fetch_assoc($result_pay);
				if ($pay_cate == "scan") {
					$level_one_vip1 = ($row_pay['level_one_vip1']*$pay_prices*$t_percent)/100;
					$level_two_vip1 = ($row_pay['level_two_vip1']*$pay_prices*$t_percent)/100;
					$level_three_vip1 = ($row_pay['level_three_vip1']*$pay_prices*$t_percent)/100;
					$level_one_vip2 = ($row_pay['level_one_vip2']*$pay_prices*$t_percent)/100;
					$level_two_vip2 = ($row_pay['level_two_vip2']*$pay_prices*$t_percent)/100;
					$level_three_vip2 = ($row_pay['level_three_vip2']*$pay_prices*$t_percent)/100;
					$supplyprice = ($row_pay['tl_supplyprice']*$pay_prices)/100;//供货价 공급가격
					$spareprice = ($row_pay['spare_gold']*$pay_prices)/100;//备用金 여유기금
					} else {
						$level_one_vip1 = $row_pay['level_one_vip1'];
						$level_two_vip1 = $row_pay['level_two_vip1'];
						$level_three_vip1 = $row_pay['level_three_vip1'];
						$level_one_vip2 = $row_pay['level_one_vip2'];
						$level_two_vip2 = $row_pay['level_two_vip2'];
						$level_three_vip2 = $row_pay['level_three_vip2'];
						$supplyprice = $row_pay['tl_supplyprice'];//供货价
						$spareprice = $row_pay['spare_gold'];//备用金
				}

				$point_one_vip1 = floatval($row_pay['point_one_vip1']);
				$point_two_vip1 = floatval($row_pay['point_two_vip1']);	
				$point_three_vip1 = floatval($row_pay['point_three_vip1']);	
				$point_one_vip2 = floatval($row_pay['point_one_vip2']);	
				$point_two_vip2 = floatval($row_pay['point_two_vip2']);	
				$point_three_vip2 = floatval($row_pay['point_three_vip2']);

				
				$tl_phone = $row_pay['tl_phone'];
				$tl_distribution = $row_pay['tl_distribution'];
				$tl_class = $row_pay['tl_class'];
				$tl_name = $row_pay['tl_name'];
				$shop_menu = $row_pay['shop_menu'];
				$tl_cate = $row_pay['tl_cate'];
				$vip_point = $row_pay['vip_point'];
				$nd_point = $row_pay['nd_point'];			
				
				/*分享得粘豆部分 begin*/
				// if((float)$nd_point > 0 && $share_phone != "")
				// {
				// 	//更新会员粘豆数
				// 	mysqli_query($mysqli,"UPDATE fyq_member SET nd_point = nd_point+{$nd_point} WHERE mb_phone = '{$share_phone}'");
				// 	//存储获得粘豆详细信息
				// 	mysqli_query($mysqli,"INSERT INTO nd_log (nd_phone, tl_id, pay_id,nd_point) VALUES ('{$share_phone}', '{$pay_shop}', '{$pay_id}', '{$nd_point}')");
				// }
				
				/*分享得粘豆部分 end*/

				$sql_payment = mysqli_query($mysqli,"UPDATE teacher_list SET tl_Sales = tl_Sales+1 WHERE tl_id = '{$pay_shop}'");//销量更新
				// if ($supplyprice > 0) {
				// 	$query_itemmember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '{$tl_phone}'";
				// 	if ($result_itemmember = mysqli_query($mysqli, $query_itemmember))
				// 	{
				// 		$row_itemmember = mysqli_fetch_assoc($result_itemmember);
				// 		$itemmember_mb_not_gold_before = $row_itemmember['mb_not_gold'];
				// 		$itemmember_mb_not_gold_after = $itemmember_mb_not_gold_before+$supplyprice;
				// 	}
				// 	$sql_gold = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$supplyprice, mb_not_gold = mb_not_gold+$supplyprice WHERE mb_phone = '{$tl_phone}'");//老师商家佣金
				// 	if ($sql_gold) {
				// 		vital_member_plus($tl_phone,$supplyprice,'1','0','0','0','0','0','0',$payment_method);
				// 		$description_supply = '供货价 - '.$tl_name;
				// 		$sql_details_tl = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$supplyprice}', 'revenue', '1', '{$description_supply}' ,'{$tl_phone}', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$itemmember_mb_not_gold_before}', '{$itemmember_mb_not_gold_after}')");//老师商家供货价佣金记录
				// 		if ($pay_cate == 'partner') {
				// 			mysqli_query($mysqli,"INSERT INTO vip_card (item_id, item_name, item_pay, user_phone, item_phone, surplus_num, jion_time) VALUES ('{$pay_shop}', '{$tl_name}', '{$total_amount}', '{$member_id}' ,'{$tl_phone}', '{$vip_point}', '{$complete_time}')");
				// 		} 
				// 	}
				// }
				}

					// 구매자 정보 => $row_member
				$member_province = $row_member['mb_province'];//省
				$member_city = $row_member['mb_city'];//市
				$member_area = $row_member['mb_area'];//区
				$member_recommend = $row_member['mb_recommend'];

				

				$member_level = $row_member['mb_level'];
				$member_distribution = $row_member['mb_distribution'];
				$sql_pay_one = 0;
				$sql_pay_two = 0;
				$pay_original_all = $total_amount;/* - $supplyprice;*/ //获取毛利价格 매출의 총리익금
				$pay_original = $pay_original_all;
				$pay_spare = $pay_original_all*0.02;//备用资金 여유기금
				$pay_spareprice = $pay_original_all*0.08;//股金池 주식금 
				//$pay_agent = $pay_original_all*0.2;//代理金 대리금

				// 주식금 배분모듈
				if ($money_to_partners > 0){
					$query_sparemember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '13069098870'";
					if ($result_sparemember = mysqli_query($mysqli, $query_sparemember))
					{
						$row_sparemember = mysqli_fetch_assoc($result_sparemember);
						$sparemember_mb_not_gold_before = $row_sparemember['mb_not_gold'];
						$sparemember_mb_not_gold_after = $sparemember_mb_not_gold_before+$money_to_partners;

						$description_spare1 = "股金池(".($rate_for_partners*100)."%) - ".$tl_name;//备用资金(自定义)					
						mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$money_to_partners, mb_not_gold = mb_not_gold+$money_to_partners WHERE mb_phone = '13069098870'");//股金池
						vital_member_plus('13069098870',$money_to_partners,'1','0','0','0','0','0','0',$payment_method);
						mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$money_to_partners}', 'revenue', '1', '{$description_spare1}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//股金池					
					}					
				}

					// 기금 배분모듈
				if ($arrGroupRates){
					foreach($arrGroupRates as $group){
						$query_sparemember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '{$group['ps_phonenumber']}'";
						if ($result_sparemember = mysqli_query($mysqli, $query_sparemember))
						{
							$row_sparemember = mysqli_fetch_assoc($result_sparemember);
							$sparemember_mb_not_gold_before = $row_sparemember['mb_not_gold'];
							$sparemember_mb_not_gold_after = $sparemember_mb_not_gold_before+$group['money'];

							$description_spare = '备用资金('.($group['ps_profit']*100).'%) - '.$tl_name;

							$sql_spare = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+{$group['money']}, mb_not_gold = mb_not_gold+{$group['money']} WHERE mb_phone = '13069098870'");//备用资金
							if ($group['money'] > 0) {
								vital_member_plus($group['ps_phonenumber'], $group['money'],'1','0','0','0','0','0','0',$payment_method);
								$sql_details_spare = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$group['money']}', 'revenue', '1', '{$description_spare}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//备用资金
							}
						}
					}
				}

					// Old Module 

				// if ($pay_spare > 0) {
				// 	$query_sparemember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '13069098870'";
				// 	if ($result_sparemember = mysqli_query($mysqli, $query_sparemember))
				// 	{
				// 		$row_sparemember = mysqli_fetch_assoc($result_sparemember);
				// 		$sparemember_mb_not_gold_before = $row_sparemember['mb_not_gold'];
				// 		$sparemember_mb_not_gold_after = $sparemember_mb_not_gold_before+$pay_spare;
				// 	}
				// 	$description_spare = '备用资金(2%) - '.$tl_name;
				// 	$sql_spare = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$pay_spare, mb_not_gold = mb_not_gold+$pay_spare WHERE mb_phone = '13069098870'");//备用资金
				// 	if ($pay_spare > 0) {
				// 		vital_member_plus('13069098870',$pay_spare,'1','0','0','0','0','0','0',$payment_method);
				// 		$sql_details_spare = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$pay_spare}', 'revenue', '1', '{$description_spare}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//备用资金
				// 	}
				// 	$pay_original = $pay_original - $pay_spare;
					
				// 	$description_spare1 = '股金池(8%) - '.$tl_name;//备用资金(自定义)
				// 	$spareprice = ($spareprice > 0) ? $spareprice : $pay_spareprice;
				// 	mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$pay_spareprice, mb_not_gold = mb_not_gold+$pay_spareprice WHERE mb_phone = '13069098870'");//股金池
				// 	vital_member_plus('13069098870',$spareprice,'1','0','0','0','0','0','0',$payment_method);
				// 	mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$pay_spareprice}', 'revenue', '1', '{$description_spare1}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//股金池
					
				// 	$pay_original = $pay_original - $pay_spareprice;
				// }

				/*代理部分 begin*/
				if($money_to_agents > 0)
				{
					$province = $row_pay['tc_province1'];
					$city = $row_pay['tc_city1'];
					$area = $row_pay['tl_district1'];
					
					// search province only.
					$query_ai_1 = "SELECT ai_region_code, ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name = '{$province}';";
					$result_ai_1 = mysqli_query($mysqli, $query_ai_1);

					if ($result_ai_1 && $result_ai_1->num_rows > 0){
						$row_ai_1 = mysqli_fetch_assoc( $result_ai_1 ); // fetch query result
						$province_code = $row_ai_1['ai_region_code'];	// get and set province code
						$ai1_total = $money_to_agents * $row_ai_1['ai_rate']; // province rate
						$ai1 = $ai1_total / $row_ai_1['ai_cnt'];		// provice agent profit
						
						// search city with province code.
						$query_ai_2 = "SELECT ai_region_code, ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name ='{$city}' AND ai_upper_code='{$province_code}';";		

						$result_ai_2 = mysqli_query($mysqli, $query_ai_2);
						if ($result_ai_2 && $result_ai_2->num_rows > 0){
							$row_ai_2 = mysqli_fetch_assoc( $result_ai_2 );			// fetch query result
							$city_code = $row_ai_2['ai_region_code'];				// get and set city code
							$ai2_total = $money_to_agents * $row_ai_2['ai_rate'];			// city rate
							$ai2 = $ai1_total / $row_ai_21['ai_cnt'];				// city agent profit
							
							// search area with city code.
							$query_ai_3 = "SELECT ai_rate, ai_cnt FROM agentinfo WHERE ai_region_name='{$area}' AND ai_upper_code='{$city_code}';";
							$result_ai_3 = mysqli_query($mysqli, $query_ai_3);
							if ($result_ai_3 && $result_ai_3->num_rows > 0){				
								$row_ai_3 = mysqli_fetch_assoc( $result_ai_3 );			// fetch query result
								$ai3_total = $money_to_agents * $row_ai_3['ai_rate'];			// area rate
								$ai3 = $ai1_total / $row_ai_3['ai_cnt'];				// area agent profit
							
								for($i = 5; $i <= 7; $i++)
								{
									$a_name = "";
									$ai_total = 0;
									$result_ml = getAgentList($i,$province,$city,$area);
									if($result_ml->num_rows > 0)
									{
										while($row_tmp = mysqli_fetch_assoc($result_ml))
										{
											switch($i)
											{
												case 5:
													$a_name = "区代理";
													$money = $ai3;
													$ai_total = $ai3_total - $ai3;
													break; 
												case 6:
													$a_name = "市代理";
													$money = $ai2;
													$ai_total = $ai2_total - $ai2;
													break;
												case 7:
													$a_name = "省代理";
													$money = $ai1;
													$ai_total = $ai1_total - $ai1;
													break;
											}
											$fornow = $a_name."金".$money."元 -".$tl_name; 	
											$phone = $row_tmp['mb_phone'];
											$before_money = $row_tmp['mb_commission_not_gold'];
											$after_money = $row_tmp['mb_commission_not_gold']+$money;	
											AgentInfo($money,$phone,$fornow,$before_money,$after_money);
										}
										if($ai_total > 0)
										{
											switch($i)
											{
												case 5:
													$a_name = "区代理";
													break; 
												case 6:
													$a_name = "市代理";
													break;
												case 7:
													$a_name = "省代理";
													break;
											}
											$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
											$result_ml2 = mysqli_query($mysqli, $query_ml2);
											$row_ml2 = mysqli_fetch_assoc($result_ml2);
											$fornow = $a_name."剩余金额".$ai_total."元 -".$tl_name; 	
											$phone = '13069098870';
											$before_money = $row_ml2['mb_commission_not_gold'];
											$after_money = $row_ml2['mb_commission_not_gold']+$ai_total;	
											AgentInfo($ai_total,$phone,$fornow,$before_money,$after_money);
										}
									}
									else
									{
										switch($i)
										{
											case 5:
												$a_name = "区代理";
												$money = $ai3_total;
												break; 
											case 6:
												$a_name = "市代理";
												$money = $ai2_total;
												break;
											case 7:
												$a_name = "省代理";
												$money = $ai1_total;
												break;
										}
										$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
										$result_ml3 = mysqli_query($mysqli, $query_ml3);
										$row_ml3 = mysqli_fetch_assoc($result_ml3);
										$fornow = $a_name."剩余金额".$money."元 -".$tl_name; 	
										$phone = '13069098870';
										$before_money = $row_ml3['mb_commission_not_gold'];
										$after_money = $row_ml3['mb_commission_not_gold']+$money;	
										AgentInfo($money,$phone,$fornow,$before_money,$after_money);
									}
								}
							}
						}
					}

					
					//if ( $result_ai = mysqli_query( $mysqli, $query_ai ) ) {
						// $row_ai = mysqli_fetch_assoc( $result_ai );		
						// $ai1_total = $pay_agent * $row_ai['ai1'];//省代理金 总额
						// $ai2_total = $pay_agent * $row_ai['ai2'];//市代理金 总额
						// $ai3_total = $pay_agent * $row_ai['ai3'];//区代理金 总额
						// $ai1 = $ai1_total / $row_ai['ai1_cnt'];//省代理金 每份		
						// $ai2 = $ai2_total / $row_ai['ai2_cnt'];//市代理金 每份
						// $ai3 = $ai3_total / $row_ai['ai3_cnt'];//区代理金 每份
						
					// 	$row_ai_1 = mysqli_fetch_assoc( $result_ai_1 );
					// 	$row_ai_2 = mysqli_fetch_assoc( $result_ai_2 );
					// 	$row_ai_3 = mysqli_fetch_assoc( $result_ai_3 );

					// 	$ai1_total = $pay_agent * $row_ai_1['ai_rate'];
					// 	$ai2_total = $pay_agent * $row_ai_2['ai_rate'];
					// 	$ai3_total = $pay_agent * (1-$row_ai_1['ai_rate']-$row_ai_2['ai_rate']);

					// 	$ai1 = $ai1_total / $row_ai_1['ai_cnt'];
					// 	$ai2 = $ai2_total / $row_ai_2['ai_cnt'];
					// 	$ai3 = $ai3_total / $row_ai_3['ai_cnt'];
						
					// 	for($i = 5; $i <= 7; $i++)
					// 	{
					// 		$a_name = "";
					// 		$ai_total = 0;
					// 		$result_ml = getAgentList($i,$province,$city,$area);
					// 		if($result_ml->num_rows > 0)
					// 		{
					// 			while($row_tmp = mysqli_fetch_assoc($result_ml))
					// 			{
					// 				switch($i)
					// 				{
					// 					case 5:
					// 						$a_name = "区代理";
					// 						$money = $ai3;
					// 						$ai_total = $ai3_total - $ai3;
					// 						break; 
					// 					case 6:
					// 						$a_name = "市代理";
					// 						$money = $ai2;
					// 						$ai_total = $ai2_total - $ai2;
					// 						break;
					// 					case 7:
					// 						$a_name = "省代理";
					// 						$money = $ai1;
					// 						$ai_total = $ai1_total - $ai1;
					// 						break;
					// 				}
					// 				$fornow = $a_name."金".$money."元 -".$tl_name; 	
					// 				$phone = $row_tmp['mb_phone'];
					// 				$before_money = $row_tmp['mb_commission_not_gold'];
					// 				$after_money = $row_tmp['mb_commission_not_gold']+$money;	
					// 				AgentInfo($money,$phone,$fornow,$before_money,$after_money);
					// 			}
					// 			if($ai_total > 0)
					// 			{
					// 				switch($i)
					// 				{
					// 					case 5:
					// 						$a_name = "区代理";
					// 						break; 
					// 					case 6:
					// 						$a_name = "市代理";
					// 						break;
					// 					case 7:
					// 						$a_name = "省代理";
					// 						break;
					// 				}
					// 				$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
					// 				$result_ml2 = mysqli_query($mysqli, $query_ml2);
					// 				$row_ml2 = mysqli_fetch_assoc($result_ml2);
					// 				$fornow = $a_name."剩余金额".$ai_total."元 -".$tl_name; 	
					// 				$phone = '13069098870';
					// 				$before_money = $row_ml2['mb_commission_not_gold'];
					// 				$after_money = $row_ml2['mb_commission_not_gold']+$ai_total;	
					// 				AgentInfo($ai_total,$phone,$fornow,$before_money,$after_money);
					// 			}
					// 		}
					// 		else
					// 		{
					// 			switch($i)
					// 			{
					// 				case 5:
					// 					$a_name = "区代理";
					// 					$money = $ai3_total;
					// 					break; 
					// 				case 6:
					// 					$a_name = "市代理";
					// 					$money = $ai2_total;
					// 					break;
					// 				case 7:
					// 					$a_name = "省代理";
					// 					$money = $ai1_total;
					// 					break;
					// 			}
					// 			$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
					// 			$result_ml3 = mysqli_query($mysqli, $query_ml3);
					// 			$row_ml3 = mysqli_fetch_assoc($result_ml3);
					// 			$fornow = $a_name."剩余金额".$money."元 -".$tl_name; 	
					// 			$phone = '13069098870';
					// 			$before_money = $row_ml3['mb_commission_not_gold'];
					// 			$after_money = $row_ml3['mb_commission_not_gold']+$money;	
					// 			AgentInfo($money,$phone,$fornow,$before_money,$after_money);
					// 		}
					// 	}
					// }			
				}
				/*代理部分 end*/

				$query_dividends = "SELECT id FROM share_dividends where day_time = '{$day_time}'";
				if ($result_dividends = mysqli_query($mysqli, $query_dividends))
				{
					$dividends_totalNumber = mysqli_num_rows($result_dividends);
					if ($dividends_totalNumber) {
						mysqli_query($mysqli," UPDATE share_dividends SET pay_amount = pay_amount+$total_amount, supply_price = supply_price+$supplyprice, a_bonus = a_bonus+$level_one_vip2, b_bonus = b_bonus+$level_two_vip2, c_bonus = c_bonus+$level_three_vip2, profit_price = profit_price+$pay_original WHERE day_time = '{$day_time}'");
					} else {
						mysqli_query($mysqli,"INSERT INTO share_dividends (pay_amount, supply_price, a_bonus, b_bonus, c_bonus, profit_price, day_time) VALUES ('{$total_amount}', '{$supplyprice}', '{$level_one_vip2}', '{$level_two_vip2}' ,'{$level_three_vip2}', '{$pay_original}', '{$day_time}')");
					}
				}

				/*一级*/
				$query_level_one_vip2 = "SELECT mb_id FROM fyq_member where mb_phone = '{$member_recommend}'";
				if ($result_level_one_vip2 = mysqli_query($mysqli, $query_level_one_vip2))
				{
					$level_one_vip2_totalNumber = mysqli_num_rows($result_level_one_vip2);
				}

				if ($level_one_vip2_totalNumber) {
					if ($level_one_vip2 >= 0 || $point_one_vip2 > 0) {
						$sql_pay_one = mysqli_query($mysqli," UPDATE fyq_member SET mb_commission_all = mb_commission_all+$level_one_vip2, mb_commission_not_gold = mb_commission_not_gold+$level_one_vip2, mb_commission_not_count = mb_commission_not_count+1, mb_point = mb_point+$point_one_vip2 WHERE mb_phone = '{$member_recommend}'");
						$pay_original = $pay_original-$level_one_vip2;//扣除一级合伙人权分红
					}
					if ($level_one_vip2 > 0) {
						vital_member_plus($member_recommend,'0','0',$level_one_vip2,'1','0','0','0','0',$payment_method);
						$query_level_one_vip2member = "SELECT mb_commission_not_gold FROM fyq_member where mb_phone = '{$member_recommend}'";
						if ($result_level_one_vip2member = mysqli_query($mysqli, $query_level_one_vip2member))
						{
							$row_level_one_vip2member = mysqli_fetch_assoc($result_level_one_vip2member);
							$level_one_vip2member_mb_not_gold_before = $row_level_one_vip2member['mb_commission_not_gold'];
							$level_one_vip2member_mb_not_gold_after = $level_one_vip2member_mb_not_gold_before+$level_one_vip2;
						}
						$description_level_one_vip2 = '分红★ - '.$tl_name;
						$sql_details_one_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_one_vip2}', 'revenue', '1', '{$description_level_one_vip2}' ,'{$member_recommend}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_one_vip2member_mb_not_gold_before}', '{$level_one_vip2member_mb_not_gold_after}')");//一级合伙人佣金记录
					}
					if ($point_one_vip2 > 0) {
						vital_member_plus($member_recommend,'0','0','0','0','0','0','0',$point_one_vip2,$payment_method);
						$description_point_one_vip2 = '分红★ - '.$tl_name;
						$sql_point_one_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_one_vip2}', '{$member_recommend}', '{$description_point_one_vip2}', '{$copartner_price_int}', '{$pay_id}')");//一级合伙人积分记录
					}
				}


				if ($level_one_vip2_totalNumber) {
					/*二级*/
					$query_two = "SELECT mb_recommend FROM fyq_member where mb_phone = '{$member_recommend}'";
					if ($result_two = mysqli_query($mysqli, $query_two))
					{
						$row_two = mysqli_fetch_assoc($result_two);
						$member_recommend_two = $row_two['mb_recommend'];
						
						$query_level_two_vip2 = "SELECT mb_id FROM fyq_member where mb_phone = '{$member_recommend_two}'";
						if ($result_level_two_vip2 = mysqli_query($mysqli, $query_level_two_vip2))
						{
							$level_two_vip2_totalNumber = mysqli_num_rows($result_level_two_vip2);
						}
						
							if ($level_two_vip2_totalNumber) {
								if ($level_two_vip2 >= 0 || $point_two_vip2 > 0) {
									$sql_pay_two = mysqli_query($mysqli,"UPDATE fyq_member SET mb_commission_all = mb_commission_all+$level_two_vip2, mb_commission_not_gold = mb_commission_not_gold+$level_two_vip2, mb_commission_not_count = mb_commission_not_count+1, mb_point = mb_point+$point_two_vip2 WHERE mb_phone = '{$member_recommend_two}'");
									$pay_original = $pay_original-$level_two_vip2;//扣除二级合伙人权分红
								}
								if ($level_two_vip2 > 0) {
									vital_member_plus($member_recommend_two,'0','0',$level_two_vip2,'1','0','0','0','0',$payment_method);
									$query_level_two_vip2member = "SELECT mb_commission_not_gold FROM fyq_member where mb_phone = '{$member_recommend_two}'";
									if ($result_level_two_vip2member = mysqli_query($mysqli, $query_level_two_vip2member))
									{
										$row_level_two_vip2member = mysqli_fetch_assoc($result_level_two_vip2member);
										$level_two_vip2member_mb_not_gold_before = $row_level_two_vip2member['mb_commission_not_gold'];
										$level_two_vip2member_mb_not_gold_after = $level_two_vip2member_mb_not_gold_before+$level_two_vip2;
									}
									$description_level_two_vip2 = '分红● - '.$tl_name;
									$sql_details_two_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_two_vip2}', 'revenue', '1', '{$description_level_two_vip2}' ,'{$member_recommend_two}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_two_vip2member_mb_not_gold_before}', '{$level_two_vip2member_mb_not_gold_after}')");//二级天使佣金记录
								}
								if ($point_two_vip2 > 0) {
									vital_member_plus($member_recommend_two,'0','0','0','0','0','0','0',$point_two_vip2,$payment_method);
									$description_point_two_vip2 = '分红● - '.$tl_name;
									$sql_point_two_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_two_vip2}', '{$member_recommend_two}', '{$description_point_two_vip2}', '{$copartner_price_int}', '{$pay_id}')");//二级经纪人积分记录
								}
							}
					}
				}
				if ($level_two_vip2_totalNumber) {
					/*三级*/
					$query_three = "SELECT mb_recommend FROM fyq_member where mb_phone = '{$member_recommend_two}'";
					if ($result_three = mysqli_query($mysqli, $query_three))
					{
						$row_three = mysqli_fetch_assoc($result_three);
						$member_recommend_three = $row_three['mb_recommend'];
						
						$query_level_three_vip2 = "SELECT mb_id FROM fyq_member where mb_phone = '{$member_recommend_three}'";
						if ($result_level_three_vip2 = mysqli_query($mysqli, $query_level_three_vip2))
						{
							$level_three_vip2_totalNumber = mysqli_num_rows($result_level_three_vip2);
						}
						
							if ($level_three_vip2_totalNumber) {
								if ($level_three_vip2 >= 0 || $point_three_vip2 > 0) {
									$sql_pay_three = mysqli_query($mysqli,"UPDATE fyq_member SET mb_commission_all = mb_commission_all+$level_three_vip2, mb_commission_not_gold = mb_commission_not_gold+$level_three_vip2, mb_commission_not_count = mb_commission_not_count+1, mb_point = mb_point+$point_three_vip2 WHERE mb_phone = '{$member_recommend_three}'");
									$pay_original = $pay_original-$level_three_vip2;//扣除三级合伙人权分红
								}
								if ($level_three_vip2 > 0) {
									vital_member_plus($member_recommend_three,'0','0',$level_three_vip2,'1','0','0','0','0',$payment_method);
									$query_level_three_vip2member = "SELECT mb_commission_not_gold FROM fyq_member where mb_phone = '{$member_recommend_three}'";
									if ($result_level_three_vip2member = mysqli_query($mysqli, $query_level_three_vip2member))
									{
										$row_level_three_vip2member = mysqli_fetch_assoc($result_level_three_vip2member);
										$level_three_vip2member_mb_not_gold_before = $row_level_three_vip2member['mb_commission_not_gold'];
										$level_three_vip2member_mb_not_gold_after = $level_three_vip2member_mb_not_gold_before+$level_three_vip2;
									}
									$description_level_three_vip2 = '分红■ - '.$tl_name;
									$sql_details_three_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_three_vip2}', 'revenue', '1', '{$description_level_three_vip2}', '{$member_recommend_three}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_three_vip2member_mb_not_gold_before}', '{$level_three_vip2member_mb_not_gold_after}')");//三级天使佣金记录
								}
								if ($point_three_vip2 > 0) {
									vital_member_plus($member_recommend_three,'0','0','0','0','0','0','0',$point_three_vip2,$payment_method);
									$description_point_three_vip2 = '分红■ - '.$tl_name;
									$sql_point_three_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_three_vip2}', '{$member_recommend_three}', '{$description_point_three_vip2}', '{$copartner_price_int}', '{$pay_id}')");//三级经纪人积分记录
								}
							}
						
					}
				}

				//统计购买数量
				$item_buy_count = mysqli_query($mysqli, "SELECT id FROM item_limit where item_id = '{$pay_shop}' and user_id = '{$member_id}'");
				$item_buy_rows = mysqli_num_rows($item_buy_count);
				if ($item_buy_rows) {
					mysqli_query($mysqli,"UPDATE item_limit SET buy_count = buy_count+1 WHERE item_id = '{$pay_shop}' and user_id = '{$member_id}'");
				} else {
					mysqli_query($mysqli,"INSERT INTO item_limit (item_id, user_id, buy_count) VALUES ('{$pay_shop}', '{$member_id}', '1')");
				}

				$vital_item_sql = mysqli_query($mysqli, "SELECT pay_id FROM payment_list where pay_member = '{$member_id}' and pay_status = '1' limit 1");
				$vital_item_rows = mysqli_num_rows($vital_item_sql);
				if ($vital_item_rows) {
				   $recommend_yes = 0;
				   $recommend_no = 1;
				} else {
				   $recommend_yes = 1;
				   $recommend_no = 0;
				}
				vital_tiem($pay_shop,$recommend_yes,$recommend_no,'0','0','1',$pay_prices,$total_amount,$supplyprice,$pay_point_commodity,$payment_method);
				vital_tiem_cate($tl_cate,'1',$payment_method);
				$margin_price = $total_amount - $supplyprice;
				vital_all($payment_method,'0','0','0','0',$pay_prices,$total_amount,$supplyprice,$margin_price,$pay_original,'1','0','0','0');
				//END
		}
        
		if ($pay_cate == "college" || $pay_cate == "busines" || $pay_cate == "scan") {
			$sql_college_allsales = mysqli_query($mysqli,"UPDATE college_list SET cl_allsales = cl_allsales+1 WHERE cl_id = '{$tl_class}'");
			if ($supplyprice>=0.01) {
				$post_data = array('phone_num' => $tl_phone,'phone_type' => 'supply','phone_price' => $supplyprice,'phone_real_price' => $total_amount,'phone_surplus_price' => $pay_prices,'phone_payid' => $pay_id,'phone_item' => $pay_shop,'level_one_vip1' => $level_one_vip1,'level_one_vip2' => $level_one_vip2,'level_two_vip1' => $level_two_vip1,'level_two_vip2' => $level_two_vip2,'member_recommend' => $member_recommend,'member_recommend_two' => $member_recommend_two,);
				send_post('http://test.shengtai114.com/post/smscode.php', $post_data);
			}
		}
	}
}
}
?>