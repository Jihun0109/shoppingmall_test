<!doctype html>
<html>
<head>
<meta charset="gb2312">
<title>¶ÌÐÅÑéÖ¤</title>
</head>

<body>
<?php 
include "../include/data_base.php";
include("../include/send_post.php");
$phone_num = $_POST["phone_num"];
$phone_type = $_POST["phone_type"];
$pco_code = rand(125000,986500);
$pco_code = 333333;

// echo $pco_code;
if ($phone_type == "login") {
	$contents = "ÑéÖ¤Âë ".$pco_code." ÄúÕýÔÚµÇÂ½Õ³¸âÍø ÇëÎðÏòÈÎºÎÈËÌá¹©ÄúÊÕµ½µÄ¶ÌÐÅÐ£ÑéÂë";
	// $contents = $pco_code;
}
if ($phone_type == "points") {
	$contents = "ÑéÖ¤Âë ".$pco_code." ÇëÎðÏòÈÎºÎÈËÌá¹©ÄúÊÕµ½µÄ¶ÌÐÅÐ£ÑéÂë";
}
if ($phone_type == "newpass") {
	$contents = "ÑéÖ¤Âë ".$pco_code." ÄúÕýÔÚÕÒ»ØÃÜÂë ÇëÎðÏòÈÎºÎÈËÌá¹©ÄúÊÕµ½µÄ¶ÌÐÅÐ£ÑéÂë";
}
if ($phone_type == "register") {
	$contents = "ÑéÖ¤Âë ".$pco_code." ÄúÕýÔÚ×¢²á¸£Ô´Èª»áÔ±, ÐèÒª½øÐÐÐ£Ñé, ÇëÎðÏòÈÎºÎÈËÌá¹©ÄúÊÕµ½µÄ¶ÌÐÅÐ£ÑéÂë";
}
if ($phone_type == "supply") {
	$phone_price = $_POST['phone_price'];
    $phone_surplus_price = $_POST['phone_surplus_price'];
    $phone_real_price = $_POST['phone_real_price'];
    $phone_payid = $_POST['phone_payid'];
    $phone_item = $_POST['phone_item'];
	$phone_num_4 = substr($phone_num,-4);
	$contents = "ÄúÎ²ºÅ ".$phone_num_4." ".date("mÔÂdÈÕ H:i")." ½áËãÊÕÈë ".Number_format($phone_price, 2).'Ôª Ô­¼Û'.$phone_surplus_price."Ôª Êµ¸¶".$phone_real_price."Ôª";
    
    $query_recom = "SELECT mb_recommend FROM fyq_member where mb_phone = '{$phone_num}'";
    if ($result_recom = mysqli_query($mysqli, $query_recom))
    {
        $row_recom = mysqli_fetch_assoc($result_recom);
        $recommend_member = $row_recom['mb_recommend'];
    }
    
    $query_payment = "SELECT pay_member FROM payment_list where pay_id = '{$phone_payid}'";
    if ($result_payment = mysqli_query($mysqli, $query_payment))
    {
        $row_payment = mysqli_fetch_assoc($result_payment);
    }
    
    $query_item = "SELECT pushmsg_id FROM teacher_list where tl_id = '{$phone_item}'";
    if ($result_item = mysqli_query($mysqli, $query_item))
    {
        $row_item = mysqli_fetch_assoc($result_item);
        $pushmsg_id = $row_item['pushmsg_id'].',15804338572';
        if (!$pushmsg_id) {
            $pushmsg_id = "15804338572";
        }
        $phone_user = substr($row_payment['pay_member'],-4);
        $content_push = "Î²ºÅ".$phone_user."ÓÃ»§ÒÑÖ§¸¶".$phone_surplus_price."Ôª";
        $content_push = iconv("gb2312","utf-8//IGNORE",$content_push);//×ª»»utf-8
        $title_push = "ÄúÓÐÒ»¸öÐÂµÄ¶©µ¥";
        $title_push = iconv("gb2312","utf-8//IGNORE",$title_push);//×ª»»utf-8
        
        $post_data = array('pushmsg_id' => $pushmsg_id,'title_push' => $title_push,'content_push' => $content_push);
        // send_post('http://fyq.shengtai114.com/post/push_msg.php', $post_data);
        send_post('http://10.0.0.153:1456/post/push_msg.php', $post_data);
    }
    
    $new_member = $row_payment['pay_member'];
    $new_time = date("Y-m-d H:i:s",strtotime("-1 hour"));
    $countnew_member = mysqli_query($mysqli, "SELECT count(mb_id) FROM fyq_member where mb_phone = '{$new_member}' and mb_time > '{$new_member}'");
    $rsnew_member = mysqli_fetch_array($countnew_member,MYSQLI_NUM);
    if ($rsnew_member) {
        $new_member_count = 1;
    } else {
        $new_member_count = 0;
    }
    $level_one_vip1 = $_POST['level_one_vip1'];
    $level_one_vip2 = $_POST['level_one_vip2'];
    $level_two_vip1 = $_POST['level_two_vip1'];
    $level_two_vip2 = $_POST['level_two_vip2'];
    $member_recommend = $_POST['member_recommend'];
    $member_recommend_two = $_POST['member_recommend_two'];
    $sql_sales = mysqli_query($mysqli,"INSERT INTO salesman (s_phone, s_trade_no, s_item, s_surplus_price, s_real_price, s_supply_price, s_recommend, new_member, recommend_phone, recommend2_phone, price_one_vip1, price_one_vip2, price_two_vip1, prcie_two_vip2) VALUES ('{$phone_num}', '{$phone_payid}', '{$phone_item}', '{$phone_surplus_price}', '{$phone_real_price}', '{$phone_price}', '{$recommend_member}', '{$new_member_count}', '{$member_recommend}', '{$member_recommend_two}', '{$level_one_vip1}', '{$level_one_vip2}', '{$level_two_vip1}', '{$level_two_vip2}')");
    $item_payment_date = date("Ymd",time());
    mysqli_query($mysqli,"INSERT INTO vital_item_payment (vip_phone_user, vip_phone_item, vip_item_id, vip_phone_recommend, vip_payment_id, vip_date) VALUES ('{$new_member}', '{$phone_num}', '{$phone_item}', '{$recommend_member}', '{$phone_payid}', '{$item_payment_date}')");
}
if ($phone_type == "expre_commission") {
	$phone_price = $_POST['phone_price'];
	$contents = "ÊÖ»úºÅ ".$phone_num." ÓÃ»§ ".date("mÔÂdÈÕ H:i")." Ó¶½ðÌáÏÖ ".Number_format($phone_price, 2).'Ôª';
	$phone_num = "13844338870";
}
if ($phone_type == "expre_patner") {
	$phone_price = $_POST['phone_price'];
	$contents = "ÊÖ»úºÅ ".$phone_num." ÓÃ»§ ".date("mÔÂdÈÕ H:i")." ¹É¶«ÌáÏÖ ".Number_format($phone_price, 2).'Ôª';
	$phone_num = "13844338870";
}
if ($phone_type == "expre_gold") {
	$phone_price = $_POST['phone_price'];
	$contents = "ÊÖ»úºÅ ".$phone_num." ÓÃ»§ ".date("mÔÂdÈÕ H:i")." Óà¶îÌáÏÖ ".Number_format($phone_price, 2).'Ôª';
	$phone_num = "13844338870";
}
if ($phone_type == "adminlogin") {
	$pco_code = rand(125000,986500);
	$pco_code = 333333;
	$contents = "ÑéÖ¤Âë ".$pco_code." ÄúÕýÔÚµÇÂ½¹ÜÀíÔ±Ò³Ãæ, ÐèÒª½øÐÐÐ£Ñé, ÇëÎðÏòÈÎºÎÈËÌá¹©ÄúÊÕµ½µÄ¶ÌÐÅÐ£ÑéÂë µ±Ç°ÑéÖ¤Âë5·ÖÖÓÄÚÓÐÐ§";
	// $contents = $pco_code;
}
$content_log = iconv("gb2312","utf-8//IGNORE",$contents);//×ª»»utf-8
//$content = iconv("utf-8","gb2312//IGNORE",$content);//×ª»»gb2312
    
    

    $sql_code = mysqli_query($mysqli,"INSERT INTO phone_code (pco_number, pco_code, pco_status, pco_type, pco_content) VALUES ('{$phone_num}', '{$pco_code}', '0', '{$phone_type}', '{$content_log}')");

    if ($phone_type !== "supply") {
        $uid = '190688';		//Êý×ÖÓÃ»§Ãû
        $pwd = 'flarns123';		//ÃÜÂë
        $mobile	 = $phone_num;	//ºÅÂë
        $content = $contents;		//ÄÚÈÝ
        //¼´Ê±·¢ËÍ
        $res = sendSMS($uid,$pwd,$mobile,$content);
        echo $res;
    }

/*--------------------------------
¹¦ÄÜ:HTTP½Ó¿Ú ·¢ËÍ¶ÌÐÅ
ËµÃ÷:		http://http.yunsms.cn/tx/?uid=Êý×ÖÓÃ»§Ãû&pwd=MD5Î»32ÃÜÂë&mobile=ºÅÂë&content=ÄÚÈÝ
×´Ì¬:
	100 ·¢ËÍ³É¹¦
	101 ÑéÖ¤Ê§°Ü
	102 ¶ÌÐÅ²»×ã
	103 ²Ù×÷Ê§°Ü
	104 ·Ç·¨×Ö·û
	105 ÄÚÈÝ¹ý¶à
	106 ºÅÂë¹ý¶à
	107 ÆµÂÊ¹ý¿ì
	108 ºÅÂëÄÚÈÝ¿Õ
	109 ÕËºÅ¶³½á
	110 ½ûÖ¹Æµ·±µ¥Ìõ·¢ËÍ
	111 ÏµÍ³ÔÝ¶¨·¢ËÍ
	112	ÓÐ´íÎóºÅÂë
	113	¶¨Ê±Ê±¼ä²»¶Ô
	114	ÕËºÅ±»Ëø£¬10·ÖÖÓºóµÇÂ¼
	115	Á¬½ÓÊ§°Ü
	116 ½ûÖ¹½Ó¿Ú·¢ËÍ
	117	°ó¶¨IP²»ÕýÈ·
	120 ÏµÍ³Éý¼¶
--------------------------------*/

//¶¨Ê±·¢ËÍ
/*
$time = '2010-05-27 12:11';
$res = sendSMS($uid,$pwd,$mobile,$content,$time);
echo $res;
*/
function sendSMS($uid,$pwd,$mobile,$content,$time='',$mid='')
{
	$http = 'http://http.yunsms.cn/tx/';
	$data = array
		(
		'uid'=>$uid,					//Êý×ÖÓÃ»§Ãû
		'pwd'=>strtolower(md5($pwd)),	//MD5Î»32ÃÜÂë
		'mobile'=>$mobile,				//ºÅÂë
		'content'=>$content,			//ÄÚÈÝ Èç¹û¶Ô·½ÊÇutf-8±àÂë£¬ÔòÐè×ªÂëiconv('gbk','utf-8',$content); Èç¹ûÊÇgbkÔòÎÞÐè×ªÂë
		//'content'=>iconv('gbk','utf-8',$content),			//ÄÚÈÝ Èç¹û¶Ô·½ÊÇutf-8±àÂë£¬ÔòÐè×ªÂëiconv('gbk','utf-8',$content); Èç¹ûÊÇgbkÔòÎÞÐè×ªÂë
		'time'=>$time,		//¶¨Ê±·¢ËÍ
		'mid'=>$mid						//×ÓÀ©Õ¹ºÅ
		);
	$re= postSMS($http,$data);			//POST·½Ê½Ìá½»
	
	 
	if( trim($re) == '100' )
	{
		return "·¢ËÍ³É¹¦!";
	}
	else 
	{
		return "·¢ËÍÊ§°Ü! ×´Ì¬£º".$re;
	}
}

function postSMS($url,$data='')
{
	$post='';
	$row = parse_url($url);
	$host = $row['host'];
    $port = isset($row['port']) ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//×ªURL±ê×¼Âë
	}
	$post = substr( $post , 0 , -1 );
	$len = strlen($post);
	
	//$fp = @fsockopen( $host ,$port, $errno, $errstr, 10);
	 
	$fp = stream_socket_client("tcp://".$host.":".$port, $errno, $errstr, 10);
	
	
	
	
	if (!$fp) {
		return "$errstr ($errno)\n";
	} else {
		$receive = '';
		$out = "POST $file HTTP/1.0\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Content-type: application/x-www-form-urlencoded\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Content-Length: $len\r\n\r\n";
		$out .= $post;		
		fwrite($fp, $out);
		while (!feof($fp)) {
			$receive .= fgets($fp, 128);
		}
		fclose($fp);
		$receive = explode("\r\n\r\n",$receive);
		unset($receive[0]);
		return implode("",$receive);
	}
}
?>
</body>
</html>
