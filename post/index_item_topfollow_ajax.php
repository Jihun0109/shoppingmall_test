<?php 
include("../include/data_base.php");

function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){

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
    $user_region = "";
}
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = "";
}

if (isset($_COOKIE["gpsla"])) {
    $gpsla = $_COOKIE["gpsla"];
} else {
    $gpsla = 0;
}
if (isset($_COOKIE["gpslo"])) {
    $gpslo = $_COOKIE["gpslo"];
} else {
    $gpslo = 0;
}

if (isset($_POST['item_count'])) {
    $item_count = $_POST['item_count'];
} else {
    $item_count = 0;
}
if (isset($_POST['item_order_by'])) {
    $item_cate = $_POST['item_order_by'];
} else {
    $item_cate = 'hot_new';
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

$item_cate = "discount_new";
if ($item_cate == "hot_new") {
    //$order_by_item = "and tl_id in (select fl_tid from follow_list where fl_phone='{$member_login}') ORDER BY tl_Sales desc";
	$hotfollow = "SELECT fl_tid from (select fl_tid,count(fl_tid) as cnt from follow_list GROUP BY fl_tid ORDER BY cnt DESC) temp";
	if ($result = mysqli_query($mysqli, $hotfollow))
	{
		$follow_list = array();
		while( $row = mysqli_fetch_assoc($result) )
		{
			$follow_list[] = $row['fl_tid'];
		}
	}
	//$follow_list = mysqli_fetch_array($hotfollow,MYSQLI_NUM);
	$follow_str = implode(',',$follow_list);
    $order_by_item = "and tl_id in ($follow_str) ORDER BY field(tl_id,$follow_str)";
}
if ($item_cate == "discount_new") {
	$order_by_item = "ORDER BY tl_Sales desc";
}

			$query = "SELECT * FROM teacher_list where shop_menu = 'busines' and item_display = '1' and tl_district1 = '{$user_region}' $order_by_item limit 0,{$item_count}";
			if ($result = mysqli_query($mysqli, $query))
			{
				while( $row = mysqli_fetch_assoc($result) ){
                    $tlid = $row['tl_id'];
                    $sql_follow = mysqli_query($mysqli, "SELECT count(*) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tlid}'");
                    $follow_rs = mysqli_fetch_array($sql_follow,MYSQLI_NUM);
                    $follow_totalNumber = $follow_rs[0];
                    if ($follow_totalNumber) {
                    $follow_img = "svg/follow_on.svg";
                    } else {
                    $follow_img = "svg/follow_off.svg";
                    }
                    
					if ($row['tc_mainimg']) {
						$main_img = $row['tc_mainimg'];
					} else {
						$main_img = "";
					}
                    
                    $pictures = (explode("|",$row['tl_pictures']));
                    $pictures_length=count($pictures);
                    if ($pictures_length>0) {
                        if (strstr($pictures[0],"server")) {
                            $pictures_src0 = "../fuyuanquan/".$pictures[0];
                        } else {
                            $pictures_src0 = $pictures[0];
                        }
                    }
                    if ($pictures_length>1) {
                        if (strstr($pictures[1],"server")) {
                            $pictures_src1 = "../fuyuanquan/".$pictures[1];
                        } else {
                            $pictures_src1 = $pictures[1];
                        }
                    }
                    
                    if ($row['tl_point_type'] == "0") {
                        $price = $row['tl_price']."￥";
                    }
                    if ($row['tl_point_type'] == "1") {
                        $price = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
                    }
                    if ($row['tl_point_type'] == "3") {
                        $price = ($row['tl_price']/10)."折";
                    }
                    
                    $shop_type = $row['shop_menu'];
                    $shop_cate = $row['tl_cate'];
                    $query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
                    if ($result_cate = mysqli_query($mysqli,$query_cate)) {
                        $row_cate = mysqli_fetch_assoc($result_cate);
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
                        $distance = '';
                    }
                    
			?>
        <li class="mui-table-view-cell mui-media mui-col-xs-3 grid">
	            <div class="border-radius50"><span onclick="location.href='detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company'"><img class="mui-media-object mui-pull-left mui-icon-image" src="<?php echo $main_img;?>"></span></div>
	            <div style="white-space: wrap; text-overflow: clip; overflow: hidden; display: -webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2;" class="mui-media-body"><span onclick="location.href='detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company'"><?php echo $row['tl_name'];?></span></div>
	    </li>
        <?php 
        }
        }
        ?>
<?php 
if (!mysqli_num_rows($result)) {
	echo 0;
}
?>