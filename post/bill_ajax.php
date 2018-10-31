<?php 
include("../include/data_base.php");
$balance_state = '';
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
    exit;
}

if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 0;
}
if ($page) {
    $page_next = $page;  
} else {
    $sql = "select t_id from balance_details where t_phone = '{$member_login}' order by t_id desc limit 1";
    if ($result = mysqli_query($mysqli, $sql))
    {
        $row = mysqli_fetch_assoc($result);
    }
    $page_next = $row['t_id']+1;
}

	$query = "SELECT * FROM balance_details where t_id < $page_next and t_phone = '{$member_login}' and t_money > '0.01' order by t_id desc limit 20";
	if ($result = mysqli_query($mysqli, $query))
	{
        $balance_rows = mysqli_num_rows($result);
        if ($balance_rows) {
            $balance_json = '';
            while($row = mysqli_fetch_assoc($result)){
                $details_way = $row['t_way'];
                if ($row['t_caption'] == "commission_money") {
                    $balance_title = "佣金";
                }
                if ($row['t_caption'] == "partner_money") {
                    $balance_title = "股东";
                }
                if ($row['t_caption'] == "total_gold") {
                    $balance_title = "供货价";
                }
				if ($row['t_caption'] == "agent_money") {
                    $balance_title = "代理分红";
                }
                if ($row['t_cate'] == "charge_plus" ||$row['t_cate'] == "commission_plus" || $row['t_cate'] == "partner_plus") {
                    $balance_state = "+";
                }
                if ($row['t_cate'] == "charge_less" || $row['t_cate'] == "commission_less" || $row['t_cate'] == "partner_less") {
                    $balance_state = "-";
                }
                $today_time = date("Y-m-d",time());
                $balance_time = date("Y-m-d",strtotime($row['t_time']));
                if ($today_time == $balance_time) {
                    $balance_times = date("H:i:s",strtotime($row['t_time']));
                } else {
                    $balance_times = date("Y-m-d",strtotime($row['t_time']));
                }
                $money = Number_format($balance_state.$row['t_money'],2);
                $description = $row['t_description'];
                $balance_json .= "{\"title\":\"$balance_title\",\"money\":\"$money\",\"description\":\"$description\",\"times\":\"$balance_times\"},";
                if ($balance_rows<20) {
                    $balance_max_page = 1;
                } else {
                    $balance_max_page = $row['t_id'];
                }
            }
            echo "[".$balance_json."{\"page\":\"$balance_max_page\"}]";
        } else {
            echo 0;
        }
		
	}
	?>