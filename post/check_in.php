<?php 
include( "../db_config.php" );
$check_time = date("Y-m-d",time());

$check_count_sql = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_check_in <> '{$check_time}' and mb_phone = '{$member_login}'");
$check_count_rs = mysqli_fetch_array($check_count_sql,MYSQLI_NUM);
$check_count_Number = $check_count_rs[0];
if ($check_count_Number) {
    $sql_check = mysqli_query($mysqli,"UPDATE fyq_member SET mb_point = mb_point+10, mb_check_in = '{$check_time}' WHERE mb_check_in <> '{$check_time}' and mb_phone = '{$member_login}'");
    if ($sql_check) {
        echo 1;
    }
} else {
    echo 2;
}
?>