<?php 
include("../include/data_base.php");
include("../include/data_base.php");
include("../include/member_db.php");
error_reporting(E_ALL & ~E_NOTICE);
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

$member_view = member_db($member_login,"mb_id,mb_point,mb_ico","../include/data_base.php");
$member_view = json_decode($member_view, true);
$member_id = $member_view['mb_id'];
error_reporting(E_ALL & ~E_NOTICE);
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
/*function format_date($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '604800'=>'星期',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $c.$v.'前';
        }
    }
}*/

function format_date($time) {
        if($time <= 0) return '刚刚';

        $nowtime = time();
        if ($nowtime <= $time) {
            return "刚刚";
        }

        $t = $nowtime - $time;
        $f = array(
            '31536000' => '年',
            '2592000' => '个月',
            '604800' => '星期',
            '86400' => '天',
            '3600' => '小时',
            '60' => '分钟',
            '1' => '秒'
        );
        foreach ($f as $k => $v) {
            $c = floor($t/$k);
            if ($c > 0) {
                return $c . $v . '前';
            }
        }
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
    $item_cate = 'discount_new';
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
if ($item_cate == "about") {
    //select * from teacher_list where (GPS_Y-42.9006848597)*(GPS_Y-42.9006848597)+(GPS_X-129.5312678846)*(GPS_X-129.5312678846)<=(0.01*5)*(0.01*5) order by abs(GPS_X-129.5312678846)+abs(GPS_Y-42.9006848597)
    $order_by_item = "and  (GPS_Y-{$gpsla})*(GPS_Y-{$gpsla})+(GPS_X-{$gpslo})*(GPS_X-{$gpslo})<=(0.01*5)*(0.01*5) order by abs(GPS_X-{$gpslo})+abs(GPS_Y-{$gpsla})";// and (tl_point_type = '0' or tl_point_type = '2') 
}


if ($item_cate == "hot_new") {
    $order_by_item = " and (tl_point_type = '0' or tl_point_type = '2') and tl_id in (select fl_tid from follow_list where fl_phone='{$member_login}') ORDER BY tl_Sales desc";
}
if ($item_cate == "discount_new") {
    $hotfollow = "SELECT fl_tid from (select fl_tid,count(fl_tid) as cnt from follow_list GROUP BY fl_tid ORDER BY cnt DESC) temp";
    if ($result = mysqli_query($mysqli, $hotfollow))
    {
        $follow_list = array();
        while( $row = mysqli_fetch_assoc($result) )
        {
            $follow_list[] = $row['fl_tid'];
        }
    }
//  $follow_list = mysqli_fetch_array($hotfollow,MYSQLI_NUM);
    $follow_str = implode(',',$follow_list);
    //$order_by_item = "and (tl_point_type = '0' or tl_point_type = '2') and tl_id in ($follow_str) ORDER BY field(tl_id,$follow_str)";// 
    $order_by_item = "and (tl_point_type = '0' or tl_point_type = '2') ORDER BY tl_time desc";
}
            //销量最多
            $sql_sales = mysqli_query($mysqli, "SELECT max(tl_Sales) FROM teacher_list");
            $sales_rs = mysqli_fetch_array($sql_sales,MYSQLI_NUM);
            $sales_totalNumber = $sales_rs[0];
            
            $starCount = 5;
            $oneCount = ceil($sales_totalNumber / 10) / 5 * 10;

            $order_by_item = "ORDER BY tl_id DESC";
            // $query = "SELECT merchant_entry.*, merchant_entry.me_shop FROM teacher_list LEFT JOIN merchant_entry ON teacher_list.tl_phone=merchant_entry.me_user where delete_status = '1' and shop_menu = 'teacher' and item_display = '1' and tl_district1 = '{$user_region}' $order_by_item limit $item_count,10";
            $query = "SELECT * from merchant_entry where me_id  limit 13";
            //echo $query;
            $nnn = 0;
            $result = mysqli_query($mysqli, $query);
            if ($result)
            {
                while( $row = mysqli_fetch_assoc($result) ){
                    $nnn++;
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
                        $price = "￥".$row['tl_price'];
                        $original = "￥".$row['tl_original'];
                    }
                    if ($row['tl_point_type'] == "1") {
                        $price = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
                        $original = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
                    }
                    if ($row['tl_point_type'] == "3") {
                        $price = ($row['tl_price']/10)."折";
                        $original = ($row['tl_original']/10)."折";
                    }
                    
                    $shop_type = $row['shop_menu'];
                    $show_nd_point = ($shop_type == "busines") ? "block" : "none";
                    $shop_cate = $row['tl_cate'];
                    $query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
                    if ($result_cate = mysqli_query($mysqli,$query_cate)) {
                        $row_cate = mysqli_fetch_assoc($result_cate);
                    }
                    if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
                        $OpenNewWindow = "onclick=\"OpenNewWindow();\"";
                    } else {
                        $OpenNewWindow = "target=\"_self\"";
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
                    //echo $gpslo;
                    echo $longitude2;
            ?>


    <ul class="mui-table-view" >
        <li class="mui-table-view-cell" style="margin-bottom: 10px;">
            <!-- <a style="margin-bottom: 1.6%;" onclick="location.href='detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company'">
                <img class="mui-media-object mui-pull-left border-radius50" src="<?php echo $main_img;?>">
                <div class="mui-media-body color-f99c73" style="font-size: 1.4em;">
                    <?php echo $row['tl_name']?>
                    <p style="margin-top:1.6%; white-space: wrap; text-overflow: clip; overflow: hidden; display: -webkit-box; -webkit-box-orient:vertical; -webkit-line-clamp:2;
" class="mui-ellipsis"><?php echo nl2br($row['tl_summary']);?></p>
                </div>

            </a> -->
            <div style="width: 100%;">
                <?php
                    $ll = ($pictures_length > 2) ? 2 : $pictures_length;
                    for($i = 0; $i < $ll; $i++)
                    {
                    ?>
                <div class="mui-pull-left mui-col-xs-6" style="padding: 0 3px;">
                    <a onclick="location.href='detailed_view.php?view=<?php echo $row['me_id'];?>&type=company'">
                        <img style="width: 100%; height: auto;" class="mui-pull-left " src="<?php echo $row['me_shopdoor']?>">
                            
                    </a>
                </div>
                 <?php
                    }
                    if($pictures_length == 1)
                    {
                    ?>
                <div class="mui-pull-left mui-col-xs-6" style="padding: 0 3px ;">
                    <a href="#">
                        <img style="display:none; width: 100%; height: auto;" class="mui-pull-left " src="<?php echo $pictures[0]?>">
                            
                    </a>
                </div>
                <?php
                    }
                    ?>
           </div>  
            <div class="table-view" style="clear:both; background-color: #FFFFFF;">
                <div class="mui-pull-left mui-col-xs-8 " style=" margin-top: 2%;">
                    <p style="margin-bottom: 6px;">手机号：<span><?php echo $row['me_user'];?></span></p>
                    <!-- <p style="font-size: 1.1em; margin-bottom: 6px;">幸福价：<span class="color-f99c73"><?php echo $row['$me_price'];?></span></p> -->
                    <!-- <div class="content" style="margin-bottom: 6px;">
                        <p class="title">人气：</p>
                        <div id="starttwo" class="block clearfix">
                            <?php
                            $tmp_star = ceil($row['tl_Sales'] );
                            for($i = 1; $i <= $starCount; $i++)
                            {
                                if($i <= $tmp_star)
                                {
                                    echo "<img src='images/starsy.png'>";
                                }
                                else
                                {
                                    echo "<img src='images/starky.png'>";
                                }
                            }
                            ?>
                        </div>
                     </div> -->
                     <p style="margin-top: 10px;" class="mui-ellipsis"><span class="mui-icon mui-icon-location-filled color-f99c73" style="font-size: 1.2em; margin-top: 2%;"></span><?php echo $distance;?>&nbsp;<?php echo $distance;?>&nbsp;&nbsp;&nbsp;<?php echo format_date(strtotime($row['tl_time']));?></p>
                    
                </div>
                <div class="mui-pull-right mui-col-xs-4" style="padding-top:20px;">
                    <div id="segmentedControl" style="border-color: #CCCCCC;" class="mui-segmented-control border-radius15">
                        <a class="mui-control-item" href="#item1" style="display:none;">预约</a>
                        <a class="mui-control-item mui-active" onclick="location.href='user_blog.php?id=<?php echo $row['me_id'];?>&type=company'" <?php echo $OpenNewWindow;?>>详情</a>
                    </div>
                    <p class="mui-pull-right" style="margin-top: 42px;"><span style="display:<?php echo $show_nd_point;?>;"><?php echo $row['nd_point'];?> 粘豆</span>
                        
                        <a href="#bottomPopover" style="color: #999999; display:none;"><span class="mui-icon-extra mui-icon-extra-share" style="font-size: 1.15em;"> 分享</span></a>
                        <a href="#input" style="color: #999999; display:none;"><span class="mui-icon mui-icon-chat" style="font-size: 1.15em;"> 88</span></a>
                        <a href="#" style="color: #999999; display:none;"><span class="mui-icon icon-thumbs-up" style="font-size: 1.15em;"> 88</span></a>
                    </p>
                </div>
            </div>
        </li>
    </ul>
    <?php 
        }
        }
        ?>
<?php 
if (!mysqli_num_rows($result)) {
    echo 0;
}
?>