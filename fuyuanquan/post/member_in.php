<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_inserts")) {
	echo "您没有权限访问此页";
	exit;
}
$member_pass_old = rand(10000,99999);
$member_phone = $_POST["member_phone"];
$member_recommend = $_POST["member_recommend"];
$member_nick = $_POST["member_nick"];
$member_pass = md5($member_pass_old."fyq");
$member_level = $_POST["member_level"];
$member_province1 = $_POST["member_province1"];
$member_city1 = $_POST["member_city1"];
$member_district1 = $_POST["member_district1"];

if ($member_level == "3") {
	$member_distribution = "1980.00";
} else if ($member_level == "4") {
	$member_distribution = "9800.00";
} else {
	$member_distribution = "0.00";
}

$member_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_phone = '{$member_phone}'");
$member_rs=mysqli_fetch_array($member_count,MYSQLI_NUM);
$memberNumber=$member_rs[0];
if ($memberNumber) {
	echo 2;
	exit;
} else {
	$sql_member = mysqli_query($mysqli,"INSERT INTO fyq_member (mb_phone, mb_nick, mb_pass, mb_level, mb_province, mb_city, mb_area, mb_recommend, mb_distribution) VALUES ('{$member_phone}', '{$member_nick}', '{$member_pass}', '{$member_level}', '{$member_province1}', '{$member_city1}', '{$member_district1}', '{$member_recommend}', '{$member_distribution}')");
	if ($sql_member) {
		echo 1;
	} else {
		echo 0;
		exit;
	}
}
?><?php

/*--------------------------------
功能:HTTP接口 发送短信
说明:		http://http.yunsms.cn/tx/?uid=数字用户名&pwd=MD5位32密码&mobile=号码&content=内容
状态:
	100 发送成功
	101 验证失败
	102 短信不足
	103 操作失败
	104 非法字符
	105 内容过多
	106 号码过多
	107 频率过快
	108 号码内容空
	109 账号冻结
	110 禁止频繁单条发送
	111 系统暂定发送
	112	有错误号码
	113	定时时间不对
	114	账号被锁，10分钟后登录
	115	连接失败
	116 禁止接口发送
	117	绑定IP不正确
	120 系统升级
--------------------------------*/
$uid = '190688';		//数字用户名
$pwd = 'flarns123';		//密码
$mobile	 = $member_phone;	//号码
$content = '您的账号已经导入到 新平台上 请及时修改密码! 账号:'.$mobile.' 密码:'.$member_pass_old.' 新平台APP下载地址: http://www.shengtai114.com';		//内容
//即时发送
$res = sendSMS($uid,$pwd,$mobile,$content);
//echo $res;

//定时发送
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
		'uid'=>$uid,					//数字用户名
		'pwd'=>strtolower(md5($pwd)),	//MD5位32密码
		'mobile'=>$mobile,				//号码
		'content'=>$content,			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
		//'content'=>iconv('gbk','utf-8',$content),			//内容 如果对方是utf-8编码，则需转码iconv('gbk','utf-8',$content); 如果是gbk则无需转码
		'time'=>$time,		//定时发送
		'mid'=>$mid						//子扩展号
		);
	$re= postSMS($http,$data);			//POST方式提交
	
	 
	if( trim($re) == '100' )
	{
		return "";//发送成功!
	}
	else 
	{
		return "".$re;//发送失败! 状态：
	}
}

function postSMS($url,$data='')
{
	$post='';
	$row = parse_url($url);
	$host = $row['host'];
	$port = $row['port'] ? $row['port']:80;
	$file = $row['path'];
	while (list($k,$v) = each($data)) 
	{
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//转URL标准码
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