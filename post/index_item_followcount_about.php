<?php
include("../include/config.php");	 
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
if(isset($_POST['sort_id'])) {
	$sort_id = $_POST['sort_id'];
} else {
	$sort_id = -1;
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
	//$follow_list = mysqli_fetch_array($hotfollow,MYSQLI_NUM);
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

          $query = "SELECT * FROM college_list LEFT JOIN teacher_list ON college_list.cl_id=teacher_list.tl_class where teacher_list.tl_district1 = '{$user_region}' limit $item_count,10";
			
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
                    
					if ($row['cl_logo']) {
						$main_img = $row['cl_logo'];
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
                    
                    $price = '<span style="font-size: 0.5rem;color:#ff655e">';

                    if ($row['tl_point_type'] == "0") {
                        $price = $price.'<span style="font-size: 0.39rem;color:#ff655e">￥</span>'.explode('.',$row['tl_price'])[0].'.</span>';
                        $price = $price.'<span style="font-size: 0.43rem;color:#ff655e">'.explode('.',$row['tl_price'])[1]."</span>";
						$original = "￥".$row['tl_original'];
                    }
                    if ($row['tl_point_type'] == "1") {
                        $price = $price.$row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\"></span>";
						$original = $row['tl_point_commodity']."<img class=\"index_point_ico\" src=\"img/point_ico.png\" alt=\"积分图标\">";
                    }
                    if ($row['tl_point_type'] == "3") {
                        $price = $price.($row['tl_price']/10)."折"."</span>";
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
                    //echo "<script>alert(".$result.(string)row_num.");</script>";
                    $distance_string = "";
                    if ($gpsla && $gpslo && $row['GPS_X'] && $row['GPS_Y']) {
                        
                        // 起点坐标
                        $longitude1 = $gpslo;
                        $latitude1 = $gpsla;
                            // echo $row['GPS_X'];
                            // echo $row['GPS_Y'];
                            // echo $gpslo;
                            // echo $gpsla;
                        // 终点坐标
                        $longitude2 = $row['GPS_X'];
                        $latitude2 = $row['GPS_Y'];

                        $distance = getDistance($longitude1, $latitude1, $longitude2, $latitude2, 1);
                        
                        if ($distance>=1000) {
                            $distance = ($distance/1000);                            
                            $distance_string = number_format($distance, 2).'km';
                            
                        } else {
                            $distance_string = number_format($distance, 2).'m';
                        }
                        
                    } else {
                        $distance_string = '';
                    } 
                    
			?>
<ul class="mui-table-view ad-list" style="">
    <li class="mui-table-view-cell">
         
        <a href="user_blog.php?id=<?php echo $row['cl_id'];?>&type=teacher">
            <img class="mui-pull-left" src="<?php echo $main_img;?>" style="/*outline: 1px solid #d3d2d4;*/width:80px;height:80px;border-radius:6px;margin-right:12px;">
            <!-- <img class="mui-pull-left" style="width:80px;height:80px;border-radius:10px;margin-right:5px;" src="<?php echo $main_img;?>"> -->
            <div class="mui-media-body" style="font-size: 0.42rem; line-height: 0.42rem;">
                <?php echo $row['tl_name']?>
                <p style="font-size: 0.32rem; color: #333333;margin-top: 5px; line-height: none;" class="mui-ellipsis">
                    <?php echo nl2br($row['tl_summary']);?>
                </p>
            </div>
            <div style="margin-top:10px;">
                

                <div class="mui-pull-left mui-col-xs-8 mui-col-sm-8 mui-clearfix" style="">
                     

                     <span style="color: #999999;">
                        <p style="float: right; color: #333333; padding-left: 6px"><?php echo $row['cl_allcount'];?>集</p>
                        <img src="img/count.png" style="height: 16px; float: right;">
                        
                    </span>

                    <span style="color: #999999;">
                        <p style="float: right; color: #333333; padding-left: 6px; padding-right: 50px"><?php echo $row['cl_allfollow'];?></p>
                        <img src="img/like.png" style="height: 16px; float: right; padding-left: 16px">
                        
                    </span>
                    <!-- <span style="font-size: 0.35rem; color: #999999; display: inline-block;"><span style="color:#ff655e;font-size:0.40rem;">
                            <?php echo $row['nd_point'];?> </span>幸福豆</span> -->
                    <span style="float:right"> </span>
                        <span class="fa fa-map-marker" style="font-size: 0.42rem;color:#ff655e"></span>
                        <span style="font-size: 0.32rem; color: #999999;"><?php echo $distance_string?></span>
                    </span>
                    
                </div>
            </div>
            <div style="margin-bottom:0px;">
                
            </div>
        </a>
        <div class="mui-col-xs-12  mui-col-sm-12" style="">
            <?php
						$ll = ($pictures_length > 2) ? 2 : $pictures_length;
						for($i = 0; $i < $ll; $i++)
						{
		        		?>
            <!-- <div class="mui-pull-left mui-col-xs-6  mui-col-sm-6" style="padding: 1px 3px;">
                <a onclick="window.open('detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company')">
                    <img style="width: 100%; height: auto;" class="mui-pull-left " src="<?php echo $pictures[$i]?>">
                </a>
            </div> -->
            <?php
						}
						if($pictures_length == 1)
						{
						?>
            <!-- <div class="mui-pull-left mui-col-xs-6  mui-col-sm-6" style="padding: 1px 3px;">
                <a href="#">
                    <img style="display: none; width: 100%; height: auto;" class="mui-pull-left " src="<?php echo $pictures[0]?>">
                </a>
            </div> -->
            <?php
						}
		            	?>
        </div>
        <div class="clearfix"></div>
        <div class="table-view ">
            <div class="mui-col-xs-9 mui-col-sm-9 " style="text-align: left; margin-left: 92px;">
                <!-- <span style=" font-size: 0.32rem; margin-right: 1em;"><span class="color-f99c73" sty>
                        <?php echo $row['tl_Sales'];?></span>
                    <font style="color: #999999;">人已买</font>
                </span> -->
                <!-- <a class="mui-control-item" onclick="wxshare('<?php echo utf8_strcut(wxstrFilter($row['tl_name']),35,'');?>', '<?php echo utf8_strcut(wxstrFilter($row['tl_summary']),40,'');?>', 'http://localhost<?php echo str_replace("
                    ..","",$main_img);?>', 'http://localhost/detailed_view.php?view=
                    <?php echo $row['tl_id'];?>&type=company&mphone=
                    <?php echo $member_login?>&qid=
                    <?php echo $member_id?>')"><span style="color: #999999;">
                        <span class="fa fa-share-square-o" style="font-size: 0.333rem;color:#ff655e"></span>
                        <span style="font-size: 0.32rem; color: #999999;"><span class="color-f99c73">
                                <?php //echo $row['share_count'];?></span>分享可得</span>
                    </span>
                    <span style="font-size: 0.35rem; color: #999999; display: inline-block;"><span style="color:#ff655e;font-size:0.40rem;">
                            <?php echo $row['nd_point'];?> </span>幸福豆</span></a>
                    <span style="float:right">
                        <span class="fa fa-map-marker" style="font-size: 0.42rem;color:#ff655e"></span>
                        <span style="font-size: 0.32rem; color: #999999;"><?php echo $distance_string?></span>
                    </span> -->
            </div>
            <!-- <div class="mui-col-xs-12  mui-col-sm-12">
                
                <div class="mui-pull-right mui-col-xs-2  mui-col-sm-2" style="padding-top:2%;">
                    <div style="border:none;" class="mui-segmented-control border-radius5">
                        <a class="mui-control-item" onclick="window.open('detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company')">获取</a>
                    </div>
                </div>
            </div> -->
        </div>
        <!-- <p style="font-size: 0.35rem; margin-top: 2rem; clear:both; border-bottom: 1px solid #CCCCCC; margin-bottom: 5px; padding-bottom: 2%;"><span
                class="mui-icon mui-icon-location-filled color-f99c73"></span>
            <?php echo $distance;?>&nbsp;
            <?php echo $row["me_shop"]?>&nbsp;&nbsp;&nbsp;
            <?php echo format_date(strtotime($row['tl_time']));?>
        </p>
        <a class="mui-col-xs-6 mui-pull-left" href="#input" style="color: #999999; display: none;"><span class="mui-icon mui-icon-chat"
                style="font-size: 0.4rem; margin-left:50%;"> 88</span></a>
        <a class="mui-col-xs-6 mui-pull-right" href="#" style="color: #999999; display: none;"><span class="mui-icon fa fa-thumbs-o-up fa-4x"
                style="font-size: 1.15em; margin-left: 25%;"> 88</span></a> -->
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