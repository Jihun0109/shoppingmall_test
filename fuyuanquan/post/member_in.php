<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (!strstr($admin_purview,"member_inserts")) {
	echo "��û��Ȩ�޷��ʴ�ҳ";
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
����:HTTP�ӿ� ���Ͷ���
˵��:		http://http.yunsms.cn/tx/?uid=�����û���&pwd=MD5λ32����&mobile=����&content=����
״̬:
	100 ���ͳɹ�
	101 ��֤ʧ��
	102 ���Ų���
	103 ����ʧ��
	104 �Ƿ��ַ�
	105 ���ݹ���
	106 �������
	107 Ƶ�ʹ���
	108 �������ݿ�
	109 �˺Ŷ���
	110 ��ֹƵ����������
	111 ϵͳ�ݶ�����
	112	�д������
	113	��ʱʱ�䲻��
	114	�˺ű�����10���Ӻ��¼
	115	����ʧ��
	116 ��ֹ�ӿڷ���
	117	��IP����ȷ
	120 ϵͳ����
--------------------------------*/
$uid = '190688';		//�����û���
$pwd = 'flarns123';		//����
$mobile	 = $member_phone;	//����
$content = '�����˺��Ѿ����뵽 ��ƽ̨�� �뼰ʱ�޸�����! �˺�:'.$mobile.' ����:'.$member_pass_old.' ��ƽ̨APP���ص�ַ: http://www.shengtai114.com';		//����
//��ʱ����
$res = sendSMS($uid,$pwd,$mobile,$content);
//echo $res;

//��ʱ����
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
		'uid'=>$uid,					//�����û���
		'pwd'=>strtolower(md5($pwd)),	//MD5λ32����
		'mobile'=>$mobile,				//����
		'content'=>$content,			//���� ����Է���utf-8���룬����ת��iconv('gbk','utf-8',$content); �����gbk������ת��
		//'content'=>iconv('gbk','utf-8',$content),			//���� ����Է���utf-8���룬����ת��iconv('gbk','utf-8',$content); �����gbk������ת��
		'time'=>$time,		//��ʱ����
		'mid'=>$mid						//����չ��
		);
	$re= postSMS($http,$data);			//POST��ʽ�ύ
	
	 
	if( trim($re) == '100' )
	{
		return "";//���ͳɹ�!
	}
	else 
	{
		return "".$re;//����ʧ��! ״̬��
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
		$post .= rawurlencode($k)."=".rawurlencode($v)."&";	//תURL��׼��
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