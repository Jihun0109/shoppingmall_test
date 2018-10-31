<?php 
include("../include/data_base.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
?>
<?php 
if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 0;
}
if ($page) {
    $page_next = $page;  
} else {
    $sql = "select vip_id from vital_item_payment where vip_phone_item = '{$member_login}' order by vip_id desc limit 1";
    if ($result = mysqli_query($mysqli, $sql))
    {
        $row = mysqli_fetch_assoc($result);
    }
    $page_next = $row['vip_id']+1;
}

$query_item_payment = "select * from vital_item_payment where vip_id < $page_next and vip_phone_item = '{$member_login}' order by vip_id desc limit 10";
if ($result_item_payment = mysqli_query($mysqli, $query_item_payment))
{
    $item_payment_rows = mysqli_num_rows($result_item_payment);
    if ($item_payment_rows) {
        $item_json = '';
        while($row_item_payment = mysqli_fetch_assoc($result_item_payment)){
            $phone_user = substr($row_item_payment['vip_phone_user'],-4);
            $vip_payment_id = $row_item_payment['vip_payment_id'];
            $query_payment_list = "SELECT pay_price FROM payment_list where pay_id = '{$vip_payment_id}'";
            if ($result_payment_list = mysqli_query($mysqli, $query_payment_list))
            {
                $row_payment_list = mysqli_fetch_assoc($result_payment_list);
                $user_payment_price = $row_payment_list['pay_price'];
            }

            $vip_item_id = $row_item_payment['vip_item_id'];
            $query_item_list = "SELECT tl_name FROM teacher_list where tl_id = '{$vip_item_id}'";
            if ($result_item_list = mysqli_query($mysqli, $query_item_list))
            {
                $row_item_list = mysqli_fetch_assoc($result_item_list);
                $item_name = $row_item_list['tl_name'];
            }
            $item_time1 = date('H:i:s',strtotime($row_item_payment['vip_time']));
            $item_time2 = date('Y-m-d',strtotime($row_item_payment['vip_time']));
            $item_json .= "{\"user\":\"$phone_user\",\"price\":\"$user_payment_price\",\"item_name\":\"$item_name\",\"time1\":\"$item_time1\",\"time2\":\"$item_time2\"},";
            if ($item_payment_rows<10) {
                $item_max_page = 1;
            } else {
                $item_max_page = $row_item_payment['vip_id'];
            }
        }
        echo "[".$item_json."{\"page\":\"$item_max_page\"}]";
    } else {
        echo 0;
    }
}
?>