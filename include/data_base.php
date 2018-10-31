<?php
error_reporting(E_ALL^E_NOTICE^E_WARNING);
ini_set('date.timezone','Asia/Shanghai');
$db_host = "localhost";
$db_user = "root";
$db_psw = "";//rhksflwk@ng
$db_name = "fuyuanquan_db";//"fuyuanquan_db";//"study_media_db";
$mysqli=mysqli_connect($db_host,$db_user,$db_psw,$db_name);
mysqli_set_charset($mysqli, "utf8");

if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    setcookie("qid", $qid, time()+3600*24*7,"/");
} else {
    $qid = 0;
}
?>