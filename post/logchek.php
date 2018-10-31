<?php 
include("../db_config.php");
if (isset($_POST["id"])) {
    $id = $_POST["id"];
} else {
    $id = '';
}
if (isset($_POST["code"])) {
    $code = $_POST["code"];
} else {
    $code = '';
}

$query_mb = "select mb_id from fyq_member where mb_phone = '{$id}' limit 1";
if ($result_mb = mysqli_query($mysqli, $query_mb))
{
    $mb_rows = mysqli_num_rows($result_mb);
    if (!$mb_rows) {
        echo 2;
        exit();
    }
}

$query_code = "select pco_id from phone_code where pco_type = 'login' and pco_code = '{$code}' order by pco_id desc limit 1";
if ($result_code = mysqli_query($mysqli, $query_code))
{
    $code_rows = mysqli_num_rows($result_code);
    
}
if ($code_rows) {
	setcookie("member", $id, time()+3600*24*365,"/");
	echo 1;
} else {
	echo 0;
}
?>
