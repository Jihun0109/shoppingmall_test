<?php 
header("Content-Type: text/html;charset=utf-8");
include ("../../include/data_base.php");
if (isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $query = "SELECT search_keyword FROM teacher_list where tl_id = '{$item_id}'";
    if ($result = mysqli_query($mysqli, $query))
    {
        $row = mysqli_fetch_assoc($result);
        echo $row['search_keyword'];
    }
}
?>