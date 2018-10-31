<?php 
include("../include/data_base.php");

function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){//获取我跟商家距离
    $EARTH_RADIUS = 6370.996; // 地球半径系数
    $PI = 3.1415926;

    $radLat1 = $latitude1 * $PI / 180.0;
    $radLat2 = $latitude2 * $PI / 180.0;

    $radLng1 = $longitude1 * $PI / 180.0;
    $radLng2 = $longitude2 * $PI /180.0;

    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;

    $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
    $distance = $distance * $EARTH_RADIUS * 1000;

    if($unit==2){
        $distance = $distance / 1000;
    }

    return round($distance, $decimal);
}

if (isset($_COOKIE["user_region"])) {
    $user_region = $_COOKIE["user_region"];
} else {
    $user_region = "延吉市";
}

$query_region = "SELECT level FROM fyq_region where region_name_c = '{$user_region}'";
if ($result_region = mysqli_query($mysqli,$query_region)) {
    $row_region = mysqli_fetch_assoc($result_region);
    if ($row_region['level'] == '3') {
        $sql_region = " and tl_district1 = '{$user_region}'";
    } else if ($row_region['level'] == '2') {
        $sql_region = " and tc_city1 = '{$user_region}'";
    } else if ($row_region['level'] == '1') {
        $sql_region = " and tc_province1 = '{$user_region}'";
    } else {
        $sql_region = "";
    }
}

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = 0;
}

if (isset($_POST["gpsla"])) {
    $gpsla = $_POST["gpsla"];
} else {
    $gpsla = 0;
}
if (isset($_POST["gpslo"])) {
    $gpslo = $_POST["gpslo"];
} else {
    $gpslo = 0;
}

if (isset($_POST['item_order_by'])) {
    $item_cate = $_POST['item_order_by'];
} else {
    $item_cate = 'recommend';
}
if ($item_cate == "recommend") {
    $order_by_item = "ORDER BY index_hot desc";
}
if ($item_cate == "hot") {
    $order_by_item = "ORDER BY tl_Sales desc";
}
if ($item_cate == "discount") {
    $order_by_item = "and tl_point_type = '3' ORDER BY tl_price";
}
if ($item_cate == "distance") {
    $order_by_item = "order by ACOS(SIN(('.$gpsla.' * 3.1415) / 180 ) *SIN((GPS_X * 3.1415) / 180 ) +COS(('.$gpsla.' * 3.1415) / 180 ) * COS((GPS_X * 3.1415) / 180 ) *COS(('.$gpslo.' * 3.1415) / 180 - (GPS_Y * 3.1415) / 180 ) ) * 6380  asc";
}

if (isset($_POST['page'])) {
    $page = $_POST['page'];
} else {
    $page = 0;
}
if ($page) {
    $page_next = $page;  
} else {
    $sql_page = "select tl_id from teacher_list where item_display = '1'{$sql_region} $order_by_item";
    if ($result_page = mysqli_query($mysqli, $sql_page))
    {
        $row_page = mysqli_fetch_assoc($result_page);
    }
    $page_next = $row_page['tl_id']+1;
}
$query = "SELECT * FROM teacher_list where tl_id < $page_next and item_display = '1'{$sql_region} $order_by_item limit 30";
if ($result = mysqli_query($mysqli, $query))
{
    $item_rows = mysqli_num_rows($result);
    $item_json = '';
    if ($item_rows) {
        while( $row = mysqli_fetch_assoc($result) ){
            $tlid = $row['tl_id'];
            $tl_name = $row['tl_name'];
            $tl_Sales = $row['tl_Sales'];
            $price_type = $row['tl_point_type'];
            $price_num = $row['tl_price'];
            $point_num = $row['tl_point_commodity'];
            $shop_type = $row['shop_menu'];
            $shop_cate = $row['tl_cate'];
            
            $sql_follow = mysqli_query($mysqli, "SELECT fl_id FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
            $follow_totalNumber = mysqli_num_rows($sql_follow);

            if ($row['tc_mainimg']) {
                $main_img = $row['tc_mainimg'];
            } else {
                $main_img = 0;
            }
            
            $query_cate = "SELECT ic_name FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
            if ($result_cate = mysqli_query($mysqli,$query_cate)) {
                $row_cate = mysqli_fetch_assoc($result_cate);
                $item_cate = $row_cate['ic_name'];
            }

            if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
                $OpenNewWindow = "onclick=\"OpenNewWindow();\"";
            } else {
                $OpenNewWindow = "target=\"_blank\"";
            }

            if ($gpsla && $gpslo && $row['GPS_X'] && $row['GPS_Y']) {
                // 起点坐标
                $longitude1 = $gpslo;
                $latitude1 = $gpsla;

                // 终点坐标
                $longitude2 = $row['GPS_X'];
                $latitude2 = $row['GPS_Y'];

                $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 1);
                if ($distance>=1000) {
                    $distance = ($distance/1000);
                    $distance = number_format($distance, 2).'km';
                } else {
                    $distance = number_format($distance, 2).'m';
                }
            } else {
                $distance = '-';
            }
            $item_json .= "{\"id\":\"$tlid\",\"user\":\"$member_login\",\"name\":\"$tl_name\",\"cate\":\"$item_cate\",\"mainimg\":\"$main_img\",\"follow\":\"$follow_totalNumber\",\"ptype\":\"$price_type\",\"price\":\"$price_num\",\"point\":\"$point_num\",\"sales\":\"$tl_Sales\"},";

            if ($item_rows<30) {
                $item_max_page = 1;
            } else {
                $item_max_page = $row['tl_id'];
            }
        }
    } else {
        $item_max_page = 1;
    }
    echo "[".$item_json."{\"page\":\"$item_max_page\"}]";
}
?>