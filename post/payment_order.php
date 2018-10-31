<?php 
include("../include/data_base.php");
include ("../include/recomend_level.php");
if (isset($_POST["recommend_phone"])) {
    $recommend_phone = $_POST["recommend_phone"]; 
} else {
    $recommend_phone = '';
}
if (isset($_POST["recommend_trade"])) {
    $recommend_trade = $_POST["recommend_trade"];
} else {
    $recommend_trade = '';
}
if (isset($_POST["recommend_itemphone"])) {
    $recommend_itemphone = $_POST["recommend_itemphone"];
} else {
    $recommend_itemphone = '';
}
if (isset($_POST["recommend_openid"])) {
    $recommend_openid = $_POST["recommend_openid"];
} else {
    $recommend_openid = '';
}

$query_member = "SELECT mb_id FROM fyq_member where mb_phone = '{$recommend_phone}'";
if ($result_member = mysqli_query($mysqli, $query_member))
{
    $member_rows = mysqli_num_rows($result_member);
    if ($member_rows) {
        mysqli_query($mysqli,"UPDATE fyq_member SET mb_openid = '{$recommend_openid}' where mb_phone = '{$recommend_phone}'");//更新openid
        setcookie("member", $recommend_phone, time()+3600*24*365,"/");
    } else {
        $query_recommend = "SELECT * FROM fyq_member where mb_phone = '{$recommend_itemphone}'";
        if ($result_recommend = mysqli_query($mysqli, $query_recommend))
        {
            $row_recommend = mysqli_fetch_assoc($result_recommend);
            $mb_phone = $row_recommend['mb_phone'];
            $mb_province = $row_recommend['mb_province'];
            $mb_city = $row_recommend['mb_city'];
            $mb_area = $row_recommend['mb_area'];

            $recommend_nick = substr($recommend_phone,-4);
            $recommend_pass = md5($recommend_nick."fyq");

            $sql_user_recommend = mysqli_query($mysqli,"INSERT INTO fyq_member (mb_phone, mb_nick, mb_pass, mb_recommend, mb_level, mb_province, mb_city, mb_area, mb_point, mb_openid) VALUES ('{$recommend_phone}', '{$recommend_nick}', '{$recommend_pass}', '{$mb_phone}', '1', '{$mb_province}', '{$mb_city}', '{$mb_area}', '100', '{$recommend_openid}')");
            if ($sql_user_recommend) {
                setcookie("member", $recommend_phone, time()+3600*24*365,"/");
                $sql_recommend_member = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point+300 where mb_phone = '{$mb_phone}'");
                recommend_level($recommend_phone,$mb_phone,"../include/data_base.php");
            }
        }
    }
}

$sql_payment_oder = mysqli_query($mysqli,"UPDATE payment_list SET pay_member = '{$recommend_phone}' where pay_trade_no = '{$recommend_trade}'");
if ($sql_payment_oder) {
    echo $recommend_trade;
} else {
    echo 10;
}
?>