<?php 
include("../db_config.php");
include("../include/send_post.php");
include('../include/vital_member_plus.php');
include('../include/vital_item.php');
include('../include/vital_item_cate.php');
include('../include/vital_all.php');

$shop_id = @$_POST["shop_id"];
$query = "SELECT * FROM payment_list where pay_id = '{$shop_id}' ORDER BY pay_id desc";

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
	$pay_time = $row['pay_time'];

	if($pay_time > "2018-09-21 06:41:42"){
		$query_pay = "SELECT * FROM teacher_list where tl_id = '{$pay_shop}'";
		if ($result_pay = mysqli_query($mysqli, $query_pay))
		{
			$row_pay = mysqli_fetch_assoc($result_pay);
			if ($pay_cate == "scan") {
				$level_one_vip1 = ($row_pay['level_one_vip1']*$pay_prices*$t_percent)/100;
				$level_two_vip1 = ($row_pay['level_two_vip1']*$pay_prices*$t_percent)/100;
				$level_three_vip1 = ($row_pay['level_three_vip1']*$pay_prices*$t_percent)/100;
				$level_one_vip2 = ($row_pay['level_one_vip2']*$pay_prices*$t_percent)/100;
				$level_two_vip2 = ($row_pay['level_two_vip2']*$pay_prices*$t_percent)/100;
				$level_three_vip2 = ($row_pay['level_three_vip2']*$pay_prices*$t_percent)/100;
				$supplyprice = ($row_pay['tl_supplyprice']*$pay_prices)/100;//������
				$spareprice = ($row_pay['spare_gold']*$pay_prices)/100;//���ý�
			} else {
				$level_one_vip1 = $row_pay['level_one_vip1'];
				$level_two_vip1 = $row_pay['level_two_vip1'];
				$level_three_vip1 = $row_pay['level_three_vip1'];
				$level_one_vip2 = $row_pay['level_one_vip2'];
				$level_two_vip2 = $row_pay['level_two_vip2'];
				$level_three_vip2 = $row_pay['level_three_vip2'];
				$supplyprice = $row_pay['tl_supplyprice'];//������
				$spareprice = $row_pay['spare_gold'];//���ý�
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
			
			/*�����ճ������ begin*/
			if((float)$nd_point > 0 && $share_phone != "")
			{
				//���»�Աճ����
				mysqli_query($mysqli,"UPDATE fyq_member SET nd_point = nd_point+{$nd_point} WHERE mb_phone = '{$share_phone}'");
				//�洢���ճ����ϸ��Ϣ
				mysqli_query($mysqli,"INSERT INTO nd_log (nd_phone, tl_id, pay_id,nd_point) VALUES ('{$share_phone}', '{$pay_shop}', '{$pay_id}', '{$nd_point}')");
			}
			
			/*�����ճ������ end*/

			$sql_payment = mysqli_query($mysqli,"UPDATE teacher_list SET tl_Sales = tl_Sales+1 WHERE tl_id = '{$pay_shop}'");//��������
			if ($supplyprice > 0) {
				$query_itemmember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '{$tl_phone}'";
				if ($result_itemmember = mysqli_query($mysqli, $query_itemmember))
				{
					$row_itemmember = mysqli_fetch_assoc($result_itemmember);
					$itemmember_mb_not_gold_before = $row_itemmember['mb_not_gold'];
					$itemmember_mb_not_gold_after = $itemmember_mb_not_gold_before+$supplyprice;
				}
				$sql_gold = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$supplyprice, mb_not_gold = mb_not_gold+$supplyprice WHERE mb_phone = '{$tl_phone}'");//��ʦ�̼�Ӷ��
				if ($sql_gold) {
					vital_member_plus($tl_phone,$supplyprice,'1','0','0','0','0','0','0',$payment_method);
					$description_supply = '������ - '.$tl_name;
					$sql_details_tl = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$supplyprice}', 'revenue', '1', '{$description_supply}' ,'{$tl_phone}', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$itemmember_mb_not_gold_before}', '{$itemmember_mb_not_gold_after}')");//��ʦ�̼ҹ�����Ӷ���¼
					if ($pay_cate == 'partner') {
						mysqli_query($mysqli,"INSERT INTO vip_card (item_id, item_name, item_pay, user_phone, item_phone, surplus_num, jion_time) VALUES ('{$pay_shop}', '{$tl_name}', '{$total_amount}', '{$member_id}' ,'{$tl_phone}', '{$vip_point}', '{$complete_time}')");
					} 
				}
			}
		}

		$member_province = $row_member['mb_province'];//ʡ
		$member_city = $row_member['mb_city'];//��
		$member_area = $row_member['mb_area'];//��
		$member_recommend = $row_member['mb_recommend'];
		$member_level = $row_member['mb_level'];
		$member_distribution = $row_member['mb_distribution'];
		$sql_pay_one = 0;
		$sql_pay_two = 0;
		$pay_original_all = $total_amount - $supplyprice; //��ȡë���۸�
		$pay_original = $pay_original_all;
		$pay_spare = $pay_original_all*0.02;//�����ʽ�
		$pay_spareprice = $pay_original_all*0.08;//�ɽ��
		$pay_agent = $pay_original_all*0.2;//�����
		if ($pay_spare > 0) {
			$query_sparemember = "SELECT mb_not_gold FROM fyq_member where mb_phone = '13069098870'";
			if ($result_sparemember = mysqli_query($mysqli, $query_sparemember))
			{
				$row_sparemember = mysqli_fetch_assoc($result_sparemember);
				$sparemember_mb_not_gold_before = $row_sparemember['mb_not_gold'];
				$sparemember_mb_not_gold_after = $sparemember_mb_not_gold_before+$pay_spare;
			}
			$description_spare = '�����ʽ�(2%) - '.$tl_name;
			$sql_spare = mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$pay_spare, mb_not_gold = mb_not_gold+$pay_spare WHERE mb_phone = '13069098870'");//�����ʽ�
			if ($pay_spare > 0) {
				vital_member_plus('13069098870',$pay_spare,'1','0','0','0','0','0','0',$payment_method);
				$sql_details_spare = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$pay_spare}', 'revenue', '1', '{$description_spare}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//�����ʽ�
			}
			$pay_original = $pay_original - $pay_spare;
			
			$description_spare1 = '�ɽ��(8%) - '.$tl_name;//�����ʽ�(�Զ���)
			$spareprice = ($spareprice > 0) ? $spareprice : $pay_spareprice;
			mysqli_query($mysqli,"UPDATE fyq_member SET mb_total_gold = mb_total_gold+$pay_spareprice, mb_not_gold = mb_not_gold+$pay_spareprice WHERE mb_phone = '13069098870'");//�ɽ��
			vital_member_plus('13069098870',$spareprice,'1','0','0','0','0','0','0',$payment_method);
			mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$pay_spareprice}', 'revenue', '1', '{$description_spare1}' ,'13069098870', 'total_gold', 'charge_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$sparemember_mb_not_gold_before}', '{$sparemember_mb_not_gold_after}')");//�ɽ��
			
			$pay_original = $pay_original - $pay_spareprice;
		}

		/*������ begin*/
		if($pay_agent > 0)
		{
			$pay_original = $pay_original - $pay_agent;
			$province = $row_pay['tc_province1'];
			$city = $row_pay['tc_city1'];
			$area = $row_pay['tl_district1'];
			
			$query_ai = "SELECT * FROM agentinfo where ai_province = '{$province}'";
			if ( $result_ai = mysqli_query( $mysqli, $query_ai ) ) {
				$row_ai = mysqli_fetch_assoc( $result_ai );		
				$ai1_total = $pay_agent * $row_ai['ai1'];//ʡ����� �ܶ�
				$ai2_total = $pay_agent * $row_ai['ai2'];//�д���� �ܶ�
				$ai3_total = $pay_agent * $row_ai['ai3'];//������� �ܶ�
				$ai1 = $ai1_total / $row_ai['ai1_cnt'];//ʡ����� ÿ��		
				$ai2 = $ai2_total / $row_ai['ai2_cnt'];//�д���� ÿ��
				$ai3 = $ai3_total / $row_ai['ai3_cnt'];//������� ÿ��
				
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
									$a_name = "������";
									$money = $ai3;
									$ai_total = $ai3_total - $ai3;
									break; 
								case 6:
									$a_name = "�д���";
									$money = $ai2;
									$ai_total = $ai2_total - $ai2;
									break;
								case 7:
									$a_name = "ʡ����";
									$money = $ai1;
									$ai_total = $ai1_total - $ai1;
									break;
							}
							$fornow = $a_name."��".$money."Ԫ"; 	
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
									$a_name = "������";
									break; 
								case 6:
									$a_name = "�д���";
									break;
								case 7:
									$a_name = "ʡ����";
									break;
							}
							$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
							$result_ml2 = mysqli_query($mysqli, $query_ml2);
							$row_ml2 = mysqli_fetch_assoc($result_ml2);
							$fornow = $a_name."ʣ����".$ai_total."Ԫ"; 	
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
								$a_name = "������";
								$money = $ai3_total;
								break; 
							case 6:
								$a_name = "�д���";
								$money = $ai2_total;
								break;
							case 7:
								$a_name = "ʡ����";
								$money = $ai1_total;
								break;
						}
						$query_ml = "SELECT * FROM fyq_member where mb_phone = '13069098870'";
						$result_ml3 = mysqli_query($mysqli, $query_ml3);
						$row_ml3 = mysqli_fetch_assoc($result_ml3);
						$fornow = $a_name."ʣ����".$money."Ԫ"; 	
						$phone = '13069098870';
						$before_money = $row_ml3['mb_commission_not_gold'];
						$after_money = $row_ml3['mb_commission_not_gold']+$money;	
						AgentInfo($money,$phone,$fornow,$before_money,$after_money);
					}
				}
			}			
		}
		/*������ end*/

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

		/*һ��*/
		$query_level_one_vip2 = "SELECT mb_id FROM fyq_member where mb_phone = '{$member_recommend}'";
		if ($result_level_one_vip2 = mysqli_query($mysqli, $query_level_one_vip2))
		{
			$level_one_vip2_totalNumber = mysqli_num_rows($result_level_one_vip2);
		}

		if ($level_one_vip2_totalNumber) {
			if ($level_one_vip2 >= 0 || $point_one_vip2 > 0) {
				$sql_pay_one = mysqli_query($mysqli," UPDATE fyq_member SET mb_commission_all = mb_commission_all+$level_one_vip2, mb_commission_not_gold = mb_commission_not_gold+$level_one_vip2, mb_commission_not_count = mb_commission_not_count+1, mb_point = mb_point+$point_one_vip2 WHERE mb_phone = '{$member_recommend}'");
				$pay_original = $pay_original-$level_one_vip2;//�۳�һ���ϻ���Ȩ�ֺ�
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
				$description_level_one_vip2 = '�ֺ�� - '.$tl_name;
				$sql_details_one_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_one_vip2}', 'revenue', '1', '{$description_level_one_vip2}' ,'{$member_recommend}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_one_vip2member_mb_not_gold_before}', '{$level_one_vip2member_mb_not_gold_after}')");//һ���ϻ���Ӷ���¼
			}
			if ($point_one_vip2 > 0) {
				vital_member_plus($member_recommend,'0','0','0','0','0','0','0',$point_one_vip2,$payment_method);
				$description_point_one_vip2 = '�ֺ�� - '.$tl_name;
				$sql_point_one_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_one_vip2}', '{$member_recommend}', '{$description_point_one_vip2}', '{$copartner_price_int}', '{$pay_id}')");//һ���ϻ��˻��ּ�¼
			}
		}


		if ($level_one_vip2_totalNumber) {
			/*����*/
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
							$pay_original = $pay_original-$level_two_vip2;//�۳������ϻ���Ȩ�ֺ�
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
							$description_level_two_vip2 = '�ֺ�� - '.$tl_name;
							$sql_details_two_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_two_vip2}', 'revenue', '1', '{$description_level_two_vip2}' ,'{$member_recommend_two}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_two_vip2member_mb_not_gold_before}', '{$level_two_vip2member_mb_not_gold_after}')");//������ʹӶ���¼
						}
						if ($point_two_vip2 > 0) {
							vital_member_plus($member_recommend_two,'0','0','0','0','0','0','0',$point_two_vip2,$payment_method);
							$description_point_two_vip2 = '�ֺ�� - '.$tl_name;
							$sql_point_two_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_two_vip2}', '{$member_recommend_two}', '{$description_point_two_vip2}', '{$copartner_price_int}', '{$pay_id}')");//���������˻��ּ�¼
						}
					}
			}
		}
		if ($level_two_vip2_totalNumber) {
			/*����*/
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
							$pay_original = $pay_original-$level_three_vip2;//�۳������ϻ���Ȩ�ֺ�
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
							$description_level_three_vip2 = '�ֺ�� - '.$tl_name;
							$sql_details_three_vip2 = mysqli_query($mysqli,"INSERT INTO balance_details (t_money, t_way, t_status, t_description, t_phone, t_caption, t_cate, t_trade_no, t_trade_no_alipay, t_payment_id, t_before_money, t_after_money) VALUES ('{$level_three_vip2}', 'revenue', '1', '{$description_level_three_vip2}', '{$member_recommend_three}', 'commission_money', 'commission_plus', '{$out_trade_no}', '{$trade_no}', '{$pay_id}', '{$level_three_vip2member_mb_not_gold_before}', '{$level_three_vip2member_mb_not_gold_after}')");//������ʹӶ���¼
						}
						if ($point_three_vip2 > 0) {
							vital_member_plus($member_recommend_three,'0','0','0','0','0','0','0',$point_three_vip2,$payment_method);
							$description_point_three_vip2 = '�ֺ�� - '.$tl_name;
							$sql_point_three_vip2 = mysqli_query($mysqli,"INSERT INTO point_log (pg_point, pg_member, pg_memo, pg_cate, pg_payment_id) VALUES ('{$point_three_vip2}', '{$member_recommend_three}', '{$description_point_three_vip2}', '{$copartner_price_int}', '{$pay_id}')");//���������˻��ּ�¼
						}
					}
				
			}
		}

		//ͳ�ƹ�������
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
	
}

$sql_payment = mysqli_query($mysqli,"UPDATE payment_list SET ship_status = '3' WHERE pay_id = '{$shop_id}'");
if ($sql_payment) {
	echo 1;
} else {
	echo 0;
}
?>