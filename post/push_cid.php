<?php 
include("../include/data_base.php");

if (isset($_POST["cid"])) {
    $cid = $_POST["cid"]; 
} else {
    $cid = '0';
}

if (isset($_COOKIE["member"])) {
    $user_id = $_COOKIE["member"];
} else {
    $user_id = '0';
}

$query_push = "SELECT id FROM push_user where cid = '{$cid}'";
if ($result_push = mysqli_query($mysqli, $query_push))
{
    $push_rows = mysqli_num_rows($result_push);
    if ($push_rows) {
        mysqli_query($mysqli,"UPDATE push_user SET user = '{$user_id}' where cid = '{$cid}'");
    } else {
        mysqli_query($mysqli,"INSERT INTO push_user (cid, user) VALUES ('{$cid}', '{$user_id}')");
    }
}
?>