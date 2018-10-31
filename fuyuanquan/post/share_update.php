<?php 
include ("../../db_config.php");
include("../admin_login.php");
include("../../include/send_post.php");
if (!strstr($admin_purview,"share_updates")) {
	echo "您没有权限访问此页";
	exit;
}
if (isset($_POST["member_title"])) {
    $member_title = $_POST["member_title"];
} else {
    $member_title = '';
}
if (isset($_POST["member_share"])) {
    $member_share = $_POST["member_share"];
} else {
    $member_share = '';
}
if (isset($_POST["mb_id"])) {
    $mb_id = $_POST["mb_id"];
} else {
    $mb_id = '';
}

$query_share = "SELECT mb_share,mb_phone FROM fyq_member where mb_id = '{$mb_id}'";
if ($result_share = mysqli_query($mysqli, $query_share))
{
    $row_share = mysqli_fetch_assoc($result_share);
    $mb_share = $row_share['mb_share'];
    $mb_phone = $row_share['mb_phone'];
}

$sql_share = mysqli_query($mysqli,"UPDATE fyq_member SET mb_share = mb_share+$member_share WHERE mb_id = '{$mb_id}'");
if ($sql_share) {
	echo 1;
    $title_push = "股份动态";
    if ($member_share>0) {
        $share_num = "增加".$member_share;
    } else {
        $share_num = "减".$member_share;
    }
    $content_push = "后台管理员正在修改您的股份".$share_num;
    $title_push = iconv("gb2312","utf-8//IGNORE",$title_push);
    $content_push = iconv("gb2312","utf-8//IGNORE",$content_push);
    $post_data = array('pushmsg_id' => $mb_phone,'title_push' => $title_push,'content_push' => $content_push);
    send_post('http://fyq.shengtai114.com/post/push_msg.php', $post_data);
} else {
	echo 0;
}
?>