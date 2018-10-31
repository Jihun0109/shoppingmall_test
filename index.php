<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
include("include/function.php");
//include("db_config.php");
//unset($_COOKIE["member"]);
//setcookie("member", "18643343045", time()+3600*24*365,"/");
$member_login = @$_COOKIE["member"];
$head_title = "福源泉";

$me_state = get_user_type( $member_login, $mysqli );

$res = mysqli_query($mysqli, "SELECT * FROM settings;");
$settings = mysqli_fetch_array($res,MYSQLI_ASSOC);
$ads_count = $settings["ads_count"];

//echo $query;
include( "include/head_.php" );
?>
<style type="text/css">
    .v3head {
        width: 100%;
        float: left;
    }

    .v3head ul {
        float: left;
        width: 100%;
        height: 68px;
        position: relative;
        background-color: #ea5931;
        padding: 0px;
        margin: 0px;
        padding-top: 3%;
    }

    .v3head li {
        float: left;
        list-style: none;
        height: 3em;
        line-height: 3em;
        color: #FFFFFF;
        padding-bottom: 1%;
        padding-top: 1%;
    }

    .v3head .logo {
        width: 80px;
        text-align: center;
        position: absolute;
        padding-left: 10px;
        padding-right: 10px;
        left: 0px;
        bottom: 0px;
    }

    .v3head .logo img {
        width: 100%;
        vertical-align: middle;
    }

    .v3head .search {
        text-align: center;
        left: 100px;
        position: absolute;
        right: 80px;
        bottom: 0px;
        overflow: hidden;
    }

    .v3head .search span {
        text-align: center;
        display: block;
        width: 100%;
        padding-left: 0;
        padding-right: 0;
        position: relative;
    }

    .v3head .search span input {
        width: 86%;
        height: 2.6em;
        border-radius: 3em;
        border: 0px;
        padding-left: 16px;
    }

    .v3head .search span img {
        position: absolute;
        top: 20%;
        right: 6%;
        height: 2em;
    }

    .v3head .region {
        width: 70px;
        text-align: left;
        position: absolute;
        right: 0px;
        bottom: 0px;
    }

    .v3head .region a {
        color: #FFFFFF;
        font-size: 0.8em;
    }

    .v3head .region img {
        width: 16px;
        margin-left: 5px;
    }

    .item_cate li {
        margin-bottom: 3%;
    }

    @media screen and (min-width: 560px) {}

    @media screen and (min-width: 860px) {}

    .swiper-container-horizontal>.swiper-pagination-bullets,
    .swiper-pagination-custom,
    .swiper-pagination-fraction {
        text-align: right;
    }

    .swiper-pagination-bullet {
        width: 20px;
        height: 5px;
        display: inline-block;
        border-radius: 0;
        background: #000;
        opacity: 0.2;
    }

    .swiper-pagination-bullet-active {
        background-color: #ff8664;
        opacity: 1;
    }

    .swiper-slide a {
        width: 100%;
    }

    .item_main_list_hot_pic {
        width: 30%;
    }

    .item_main_list_hot_detailed {
        float: initial;
        overflow: hidden;
        width: auto;
    }

    .item_main_list_hot_detailed_title {
        height: 38px;
        line-height: 38px;
    }

    .item_main_list_hot_detailed_title span:nth-child(1) {
        max-width: 100%;
    }

    .item_main_list_hot_detailed_cate {
        height: inherit;
        line-height: inherit;
    }

    .item_main_list_hot_detailed_cate span:nth-child(1) {
        background-color: #df443b;
        color: #FFFFFF;
        padding: 1px 5px 1px 5px;
        font-size: 0.8em;
        border-radius: 3px;
        display: block;
        float: left;
    }

    .item_main_list_hot_detailed_cate .distance {
        font-size: 0.8em;
        float: right;
        color: #565656;
    }

    .item_main_list_hot_detailed_cate span:nth-child(2) {
        font-size: 0.8em;
        float: right;
        color: #565656;
        margin-left: 0px;
    }

    .item_main_list_hot_detailed_price {
        font-size: 1em;
        color: #E91E63;
        font-weight: bold;
        float: left;
        width: 100%;
        margin-top: 3px;
    }

    .item_main_list_hot_detailed_price i {
        margin-left: 10px;
        font-size: 0.8em;
        color: #757575;
        font-weight: initial;
    }

    .item_main_list_hot_detailed_price span {
        float: right;
    }

    .item_main_list_hot_detailed_price span img {
        width: 16px;
    }

    .push_message {
        float: left;
        width: 100%;
        background-color: #fff;
        margin-bottom: 6px;
    }

    .push_message ul {
        float: left;
        width: 96%;
        padding: 2%;
    }

    .push_message li {
        float: left;
        width: 100%;
        height: 22px;
        line-height: 22px;
        font-size: 0.8em;
        color: #6d6d6d;
        list-style: inside;
    }

    .push_message .push_title {
        width: -webkit-fill-available;
        overflow: hidden;
        position: absolute;
        margin-right: 70px;
    }

    .push_message .push_time {
        float: right;
        width: 70px;
        text-align: right;
    }

    .pgx li {
        width: 48%;
    }

    .view-cell {
        width: 100%;
        font-size: 17px;
        display: inline-block;
        margin-right: -4px;
        padding: 10px 0 0 14px;
        text-align: center;
        vertical-align: middle;
        background: none;
    }

    .table-view {
        margin-left: 0;
        position: relative;
        margin-top: 0;
        margin-bottom: 0;
        padding-left: 0;
        list-style: none;
        background-color: #fff;
    }

    .item_main_list_title_font_new {
        color: #f99c73 !important;
        font-weight: bold;
    }

    .mui-grid-view.mui-grid-9 .mui-table-view-cell {
        margin: 0;
        padding: 11px 5px;
        vertical-align: top;
    }

    input::-webkit-input-placeholder {
        /* placeholder颜色  */
        color: rgba(255, 255, 255, 0.7);
        text-align: left;
    }
</style>
<img src="../img/banner/banner-bg.png" style="position:fixed; top:50px; z-index: -10; width: 100%">
<div style="padding: 0px" class="mui-bar mui-bar-nav header_slave">
<?php
    include("sort_menu.php");
?>
</div>

<div style="position:fixed; top: 50px; z-index: 7; background-color: transparent;box-shadow: none;" class="mui-bar mui-bar-nav">
    <div style="position: absolute;left:0px;height: 44px;width:100%;background-image: url('../img/banner/banner-bg.png'); background-size: cover;"></div>
    <form action="item_list.php" method="get" class="mui-pull-left mui-col-sm-7 mui-col-xs-7 mui-input-row color-white" style="margin-top: 0.15em; text-align: center;padding-left: 10px;padding-right: 10px;">
        <input type="hidden" name="menu" value="busines">
        <input type="search" name="bus_keyword" style="background-color:rgba(255,255,255,0.3);text-overflow: ellipsis;white-space: nowrap;overflow: hidden;padding-left: 28px" value="" placeholder="请输入你要查找的关键词">    
    </form>
    <img style="position: absolute;width: 18px; top: 14px;left: 28px" src="img/magnifying-glass.png">
    <div id="dcontent" class="mui-pull-left dcontent mui-col-sm-2 mui-col-xs-3" style="margin-top: 4.7px;">
            <button onclick="show_cli()" class="button mui-btn  headerbtn color-white  mui-pull-left icon-qrcode1" style=" font-size: 0.5rem; background: none; padding: 0;margin-right:initial;">
            </button>
            <p style="font-size: 0.35rem;margin-top: 6px;margin-left: 20px;margin-right: -10px;" class="color-white" onclick="show_cli()">下载码</p>
    </div>
    <div class="mui-pull-right mui-col-sm-2 mui-col-xs-2" onclick="window.open('region.php', '_self')" style="margin-right: -5px;">
        <img src="img/location.png" style="height: 22px;margin-top: 10px;margin-left: -15px; float: left; ">
        <p style="font-size: 0.35rem;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;margin-top: 11px;" class="color-white" id="current_location"><?php echo $_COOKIE['user_region'];?></p>
    </div>
</div>
<div class="mui-scroll" style="margin-top: 80px; padding: 15px">
    <div id="slider-img" class="mui-slider" style="height: 4.3rem;border-radius: 6px">
        <div class="mui-slider-group mui-slider-loop">
            <!-- 额外增加的一个节点(循环轮播：第一个节点是最后一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-7.png">
                </a>
            </div>
            <!-- 第一张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-1.png">
                </a>
            </div>
            <!-- 第二张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-2.png">
                </a>
            </div>
            <!-- 第三张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-3.png">
                </a>
            </div>
            <!-- 第四张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-4.png">
                </a>
            </div>
            <!-- 第五张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-5.png">
                </a>
            </div>
            <!-- 第六张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-6.png">
                </a>
            </div>
            <!-- 第七张 -->
            <div class="mui-slider-item">
                <a href="/">
                    <img style="border-radius: 6px" src="images/img-7.png">
                </a>
            </div>
            <!-- 第八张 -->
<!--             <div class="mui-slider-item">
                <a href="/">
                    <img src="images/img-8.png">
                </a>
            </div> -->
            <!-- 第九张 -->
            <!-- <div class="mui-slider-item">
                <a href="/">
                    <img src="images/img-9.png">
                </a>
            </div> -->
            <!-- 额外增加的一个节点(循环轮播：最后一个节点是第一张轮播) -->
            <div class="mui-slider-item mui-slider-item-duplicate">
                <a href="/">
                    <img src="images/img-1.png">
                </a>
            </div>
        </div>
        <div class="mui-slider-indicator" style="bottom: 5px">
            <div class="mui-indicator mui-active"></div>
            <div class="mui-indicator"></div>
            <div class="mui-indicator"></div>
            <div class="mui-indicator"></div>
            <div class="mui-indicator"></div>
            <div class="mui-indicator"></div>
            <div class="mui-indicator"></div>
        </div>
    </div>
</div>
<div class="item_main_list" style="margin-top:7rem;" onclick="window.open('memo_list.php?me_type=10','_self');">
    <div style="background-color: white; width: 100%;height: 40px; padding: 5px">
        <img src="img/ads-hot.png" height="100%" style="float: left">
        <p style="font-size: 0.4rem; float: left;background-color: #efeff4; border-radius: 6px;padding: 5px; margin-left: 5px; color: #959595;text-overflow: ellipsis;white-space: nowrap;overflow: hidden;">活动公告显示从右到左滑动显示...
        <p style="font-size: 0.4rem; float: right;padding-top: 6px; margin-right: 24px;">更多
    </div>
</div>
<div class="clearfix"></div>
<div style="background-color: white; width: 100%;padding:10px;">
    <div style="width: 100%;">
        <img src="img/section.png" style="float: left;width: 16px">
        <p style="float: left;font-size: 0.4rem;color: #333333;margin-left: 5px">名师推荐</p>
        <a href="./mingshi.php"><p style="float: right;font-size: 0.4rem">查看全部></p></a>
    </div>
    <div class="clearfix"></div>
    <div id="divTeacherList" style="width: 100%;">
            
            <?php

if (isset($_GET['teacherGroupNumber'])) {
    $teacherGroupNumber = $_GET['teacherGroupNumber'];
} else {
    $teacherGroupNumber = 0;
}

    $query = "SELECT * FROM college_list where cl_class = 'busines' ORDER BY cl_allfollow desc, cl_allsales desc, cl_id desc limit ".($teacherGroupNumber*6).", 6";
    
    if ($result = mysqli_query($mysqli, $query))
    {
        while( $row = mysqli_fetch_assoc($result) ){        
    ?>

<div style="width: 33%; padding: 5px; float: left; ">
    <div style="width: 100%;position: relative;">
        <div style="position: absolute;z-index: 5;font-size: 11px;background-color: #ff655e; border-bottom-right-radius:6px; color: white; padding: 0px 5px;height: 19px">名师</div>
        <a class="animsition-link" href="user_blog.php?id=<?php echo $row['cl_id'];?>&type=join" target="_self"><img src="<?php echo $row['cl_logo'];?>" style="width: 100%;height: 100%"></a>
        <div style="width: 100%;height: 24px;position: absolute;z-index: 5;background-color: rgba(0,0,0,0.5);padding: 2px 5px; bottom: 6px;">
            <p style="float: right; color: white; padding-left: 6px"><?php echo $row['cl_allfollow'];?></p>
            <img src="img/like.png" style="height: 16px; float: right;">
        </div>
    </div>
    <div style="color: #313131"><?php echo $row['cl_name'];?></div>
</div>
<?php 
        }
    }
?>

        </div>
        <div class="clearfix"></div>
        <div style="background-color: #efeff4;border-radius: 20px;padding: 4px 20px;overflow: hidden;margin: auto;width: 38%">
            <img id="loading_teacher" src="img/refresh.png" style="float: left;width: 20px;margin: 5px;">
            <p style="float: right;margin: 5px" onclick="get_top_teacher_group()">换一批</p>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div style="background-color: white; width: 100%;padding:10px;margin-top: 10px;">
        <div style="width: 100%;">
            <img src="img/section.png" style="float: left;width: 16px">
            <p style="float: left;font-size: 0.4rem;color: #333333;margin-left: 5px">推荐学院</p>
            <a href="./recommend.php"><p style="float: right;font-size: 0.4rem">查看全部></p></a>
        </div>
        <div class="clearfix"></div>
    <div id="divLectureList" style="width: 100%;">
            
            <?php



    $query = "SELECT * FROM college_list  ORDER BY cl_allcount desc limit 3";
    
    if ($result = mysqli_query($mysqli, $query))
    {
        while( $row = mysqli_fetch_assoc($result) ){       
    ?>

<div style="width: 33%; padding: 5px; float: left; ">
    <div style="width: 100%;position: relative;">
        <div style="position: absolute;z-index: 5;font-size: 11px;background-color: #ff655e; border-bottom-right-radius:6px; color: white; padding: 0px 5px;height: 19px">学院</div>
        <a class="animsition-link" href="user_blog.php?view=<?php echo $row['cl_id'];?>&type=teacher" target="_self"><img src="<?php echo $row['cl_logo'];?>" style="width: 100%;height: 100%"></a>
        <div style="width: 100%;height: 24px;position: absolute;z-index: 5;padding: 2px 5px; bottom: 6px;">
            <!-- <p style="float: right; color: white; padding-left: 6px"><?php echo $row['tl_class'];?></p>
            <img src="img/like.png" style="height: 16px; float: right;"> -->
        </div>
    </div>
    <div style="color: #313131"><?php echo $row['cl_name'];?></div>
</div>
<?php 
        }
    }
?>

        </div>
      
    <div class="clearfix"></div></div>
    <div style="background-color: white; width: 100%;padding:10px;margin-top: 10px;">
        <div style="width: 100%;">
            <img src="img/section.png" style="float: left;width: 16px">
            <p style="float: left;font-size: 0.4rem;color: #333333;margin-left: 5px">附近</p>
            <a href="./about_list.php"><p style="float: right;font-size: 0.4rem">查看全部></p></a>
        </div>
        <div class="clearfix"></div>
    <div id="divTeacherList" style="width: 100%;">
            
            <?php


    $order_by_item = "ORDER BY tl_id DESC";
    // $query = "SELECT merchant_entry.*, merchant_entry.me_shop FROM teacher_list LEFT JOIN merchant_entry ON teacher_list.tl_phone=merchant_entry.me_user where delete_status = '1' and shop_menu = 'teacher' and item_display = '1' and tl_district1 = '延吉市' $order_by_item limit 3";
    $query = "SELECT * from merchant_entry where me_id  limit 3";
    
    if ($result = mysqli_query($mysqli, $query))
    {
        while( $row = mysqli_fetch_assoc($result) ){       
    ?>
    

    <div style="width: 33%; padding: 5px; float: left; ">
    <div style="width: 100%;position: relative;">
        <div style="position: absolute;z-index: 5;font-size: 11px;background-color: #ff655e; border-bottom-right-radius:6px; color: white; padding: 0px 5px;height: 19px">附近</div>
        <a class="animsition-link" href="detailed_view.php?view=<?php echo $row['me_id'];?>&type=teacher" target="_self"><img src="<?php echo $row['me_shopdoor'];?>" style="width: 100%;height: 100%"></a>
        <div style="width: 100%;height: 24px;position: absolute;z-index: 5;padding: 2px 5px; bottom: 6px;">
            <!-- <p style="float: right; color: white; padding-left: 6px"><?php echo $row['cl_allfollow'];?></p>
            <img src="img/like.png" style="height: 16px; float: right;"> -->
        </div>
    </div>
    <div style="color: #313131"><?php echo $row['me_name'];?></div>
</div>
<?php 
        }
    }
?>

        </div>
        <div class="clearfix"></div>
        
    </div>
<div class="clearfix"></div>
    <div style="background-color: white; width: 100%;padding:10px;margin-top: 10px;">
        <div style="width: 100%;">
            <img src="img/section.png" style="float: left;width: 16px">
            <p style="float: left;font-size: 0.4rem;color: #333333;margin-left: 5px">精品课程</p>
            <a href="./subscriber.php"><p style="float: right;font-size: 0.4rem">查看全部></p></a>
        </div>
        <div class="clearfix"></div>
         <div class="item_main_list_hot1" style="width: 100%; margin-top: 0px;">
        <div id="item_list" style="margin:auto;background-color: white"></div>
        <div class="item_main_list_hot_loding" style="display: none;">
            <div class="loader_ajax"></div>
        </div>
    </div>
</div>
   

</div>
<div class="foot">
    <a href="index.php" target="_self" class="foot_ico no-link" style="color: #f99c73; background-color: #5a2dab;border-top: #f99c73 3px solid;">
        <span><img src="img/bot-menu-home.png" style="height: 40px" ></span>
    </a>
    <a href="about_list.php" target="_self" class="foot_ico no-link" style="color: #f99c73; font-weight: bolder;">
        <img src="img/bot-menu-near.png" style="height: 30px">
        <div style="font-size: 11px;line-height: 5px">附近</div>
    </a>
    <!-- <a href="subscriber.php" target="_self" class="foot_center miclick no-link" style="color: #f99c73;"><img src="img/newhot.png"></a> -->
    <a href="subscriber.php" target="_self" class="foot_ico no-link" style="color: #f99c73; font-weight: bolder;">
        <img src="img/bot-menu-official.png" style="height: 30px">
        <div style="font-size: 11px;line-height: 5px">精品</div>
    </a>
    <?php
		if($member_login) 
		{
			if( $me_state ){
				echo '<a href="/business_payment_qr.php" target="_self" class="foot_ico no-link"  style="color: #f99c73; font-weight: bolder;">';
			} else {
				echo '<a href="merchant_entry.php" target="_self" class="foot_ico no-link" style="color: #f99c73; font-weight: bolder;">';
			}
	?>
            <img src="img/bot-menu-login.png" style="height: 30px">
            <div style="font-size: 11px;line-height: 5px" class="fz13">
        <?php 
			if( $me_state ){
				echo "收款码";
			} else {
				echo "专家入驻";
			}
		?>
            </div>
            </a>
    <a id="miclick" target="_self" class="foot_ico no-link" style="color: #f99c73; font-weight: bolder;">
        <img src="images/messsage.gif" id="message-alert" style="width:20px; overflow: auto; position: absolute; left: 25px; top: -17px;">
        <img src="img/bot-menu-private.png" style="height:30px;">
        <div style="font-size: 11px;line-height: 5px">我</div>
    </a>
    <?php
		}
		else
		{
	?>
    <a class="foot_ico login_ajax no-link" onclick="return false" style="color: #f99c73; font-weight: bolder;">
        <img src="img/bot-menu-login.png" style="height:30px;">
        <div style="font-size: 11px;line-height: 5px">订单</div>
    </a>
    <a class="foot_ico login_ajax animsition-link no-link" style="color: #f99c73; font-weight: bolder;">
        <img src="img/bot-menu-private.png" style="height:30px;">
        <div style="font-size: 11px;line-height: 5px">我</div>
    </a>
    <?php
		}
	?>
</div>
<div class="cli"><img src="img/cli_300px.png"></div>
<div class="member_menu_alt">
    <div><a class="animsition-link" href="member_center.php" target="_self"><img src="img/member_i1.png" alt="会员中心">会员中心</a>
    </div>
    <div><a class="animsition-link" href="my_commodity.php" target="_self">发布信息</a></div>
    <!--<div><a class="animsition-link" href="chat/chatList.php" target="_self">在线聊天</a></div>-->
    <div><a class="animsition-link" href="myqrcode.php" target="_self">我的二维码</a><span>▼</span>
    </div>
</div>
<div class="body_bg"></div>
<script type="text/javascript">
    $(function () {
        $('.dowebok').liMarquee();
    });

    var user_region = $.cookie('user_region');
    if (!user_region) {
        $.cookie('user_region', '延吉市', {
            expires: 365
        });
    } else {
        $("#current_location").text(user_region);
    }

    function DoWithGPS(la, lo) {
        if ($.cookie('gpsla') !== la) {
            $.cookie('gpsla', la, {
                expires: 1
            });
        }
        if ($.cookie('gpslo') !== lo) {
            $.cookie('gpslo', lo, {
                expires: 1
            });
        }
    };
    YDB.GetGPS("DoWithGPS");
    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(position){
        var ret = this.getStatus();        
        /*
            position.point = {
                address: {
                    city: "",
                    district:"",
                    province:"",
                    street:"",
                    ...
                },
                latitude: number,
                longitude: number,
                point:{
                    lat: number,
                    lng: number
                }
                ...
            }
        */
//        alert(position.address.city);
        DoWithGPS(position.point.lat,position.point.lng);
    });
    var topShow = 0;
    $(document).ready(function () {
        sort_id = $("ul#horizontal-list li.active").val();

        if (/iPhone|iPod|Android|iPad/.test(window.navigator.platform)) {
            /* cache dom references */
            var $body = jQuery('body');

            /* bind events */
            $(document)
                .on('focus', 'input', function () {
                    var scrollTop = $(document).scrollTop();
                    var fixedInterval = setInterval(function () {
                        $(document).scrollTop(scrollTop)
                    }, 1);
                    setTimeout(function () {
                        clearInterval(fixedInterval);
                    }, 1200)
                })
                .on('blur', 'input', function () {});
        }

        $(window).scroll(function () {
            if ($(".index_item_list_hot").is(".item_main_list_title_font_new")) {
                index_item_list("hot_new", "no", sort_id);
            }
            if ($(".index_item_list_discount").is(".item_main_list_title_font_new")) {
                index_item_list("discount_new", "no", sort_id);
            }
        });
        <?php
		if($member_login)
		{
	?>
        index_item_list("discount_new", "no", sort_id);
        check_new_message();
        //index_item_list("hot_new","no");
        <?php
		}
		else
		{
	?>
        index_item_list("discount_new", "no", sort_id);
        <?php
		}
	?>
    });
    $("#horizontal-list li").click(function () {
        $("ul#horizontal-list li").removeClass("active");
        $("ul#horizontal-list li#" + this.id).addClass("active");
        sort_id = $("ul#horizontal-list li.active").val();
        $(".item_main_list_hot_loding").html("");
        $("#item_list").html("");
        if ($(".index_item_list_hot").is(".item_main_list_title_font_new")) {
            item_cate = "hot_new";
        }
        else if ($(".index_item_list_discount").is(".item_main_list_title_font_new")) {
            item_cate = "discount_new";
        }
        else{
            item_cate = "discount_new";
        }
        $.post("post/index_item_followcount_main.php", {
                item_count: 0,
                item_order_by: item_cate,
                sort_id: sort_id,
            },
            function (data, status) {
                if (data == "0") {
                    $(".item_main_list_hot_loding").text("全部加载完毕");
                    $("body").css("background-color", "white");
                } else {
                    $("body").css("background-color", "#efeff4");
                    $("#item_list").html(data);
                    $(".item_main_list_hot_loding").css("display", "none");
                }
            });
    });

    function check_new_message() {
        $.get("chat/ajax.php?action=checkNewMessage",
            function (data) {
                if (data.count == 0) {
                    $("#message-alert").css("display", "none");
                } else {
                    $("#message-alert").css("display", "block");
                }

                setTimeout(check_new_message, 1000);
            }, 'json');
    }
    var teacherGroupNumber = 1;
    function get_top_teacher_group(){
        $("#loading_teacher").addClass("loading");
        $.get("get_top_teacher_list.php?teacherGroupNumber=" + teacherGroupNumber,
            function(data) {
                if (data.length > 0) {
                    $("#loading_teacher").removeClass("loading");
                    $("#divTeacherList").html(data);
                    teacherGroupNumber++;
                }
            });
    }

    function index_item_list(item_cate, return_loding, sort_id) {
        if (item_cate == "hot_new") {
            $(".index_item_list_hot").addClass("item_main_list_title_font_new");
            $(".index_item_list_discount").removeClass("item_main_list_title_font_new");
        }
        if (item_cate == "discount_new") {
            $(".index_item_list_discount").addClass("item_main_list_title_font_new");
            $(".index_item_list_hot").removeClass("item_main_list_title_font_new");
        }
        windowScrollHight = $(window).height();
        documentScrollHight = $(document).height();
        documentscrollTop = $(document).scrollTop();
        if ((windowScrollHight + documentscrollTop) >= (documentScrollHight - 200) || return_loding == "yes") {
            looding = $(".item_main_list_hot_loding").css("display");
            if (looding == "none") {
                var item_main_list_count = $("#item_list ul").length;
                $(".item_main_list_hot_loding").css("display", "block");
                if (return_loding == "yes") {
                    item_main_list_count = 0;
                    topShow = 0;
                    $(".item_main_list_hot_loding").html("");
                    $("#item_list").html("");
                    //$("#slider-img").html("");
                }
                $.post("post/index_item_followcount_main.php", {
                        item_count: item_main_list_count,
                        item_order_by: item_cate,
                        sort_id: sort_id,
                    },
                    function (data, status) {
                        if (data == "0") {
                            $(".item_main_list_hot_loding").text("全部加载完毕");
                        } else {
                            if (return_loding == "yes") {
                                $("#item_list").html(data);
                                return_loding = "no"
                            } else {

                                $("#item_list").append(data);
                            }
                            $(".item_main_list_hot_loding").css("display", "none");
                        }
                    });
                /*if(topShow == 0)
                {
                	$.post("post/index_item_topslider-img_ajax.php",
                	{
                		item_count:<?php echo $ads_count?>,
                		item_order_by:item_cate
                	},
                	function(data,status){
                		if (data == "0") {
                			//$(".item_main_list_hot_loding").text("全部加载完毕");
                		} else {
                			if (return_loding == "yes") {
                				$("#slider-img").html(data);
                			} else {
                				$("#slider-img").append(data);
                			}
                			$(".item_main_list_hot_loding").css("display","none");
                		}
                	});
                	topShow = 1;
                }*/
            }
        }
    }

    //扫一扫
    function scan_fyq() {
        YDB.Scan();
    }
    //公告切换效果
    $(document).ready(function () {
        var $obj = $('.niangao_notice a');
        var len = $obj.length;
        var i = 0;
        $(".niangao_notice div").click(function () {
            i++;
            if (i == len) {
                i = 0;
            }
            $obj.stop(true, true).hide().eq(i).fadeIn(600);
            return false;
        });
    })

    function show_cli() {
        var cli_opacity = $(".cli").css("display");
        if (cli_opacity == "none") {
            $(".cli").css("display", "block");
            $(".body_bg").css({
                "background": "rgba(0, 0, 0, 0.7)",
                "display": "block",
                "opacity": "1",
                "z-index": "999"
            })
        } else {
            $(".cli").css("display", "none");
            $(".body_bg").removeAttr("style");
        }
    }

    $(document).ready(function () {
        $(".login_ajax").click(function () {
            $.get("post/login_ajax.php", function (data, status) {
                $(".animsition").html(data);
            });
        })

        $("#miclick").click(function () {
            var foot_center_opacity = $(".member_menu_alt").css("display");
            // $(".member_menu_alt").slideToggle();
            if (foot_center_opacity == "none") {
                $(".member_menu_alt").css("display", "block");
                $(".member_menu_alt div:eq(1)").attr("class", "a-fadeinB").prev().attr("class",
                    "a-fadeinB");
                $(".member_menu_alt div:eq(3)").attr("class", "a-fadeinB").prev().attr("class",
                    "a-fadeinB");
                $(".body_bg").css({
                    "background": "rgba(0, 0, 0, 0.7)",
                    "display": "block",
                    "opacity": "1",
                    "z-index": "999"
                })
            } else {
                $(".member_menu_alt").css("display", "none");
                $(".member_menu_alt div:eq(1)").removeClass("a-fadeinB");
                $(".body_bg").removeAttr("style");
            }
        });
        $(".body_bg").click(function () {
            $(".member_menu_alt").css("display", "none");
            $(".member_menu_alt div:eq(1)").removeClass("a-fadeinB");
            $(".cli").css("display", "none");
            $(".body_bg").removeAttr("style");
            $(".menu_left").addClass("a-fadeoutL").css("display", "none").removeClass("a-fadeinL");
        })

        var swiper = new Swiper('.swiper-container', {
            pagination: {
                el: '.swiper-pagination',
            },
            loop: true
        });
    })
</script>
<script type="text/javascript" charset="utf-8">
    mui.init({
        swipeBack: true //启用右滑关闭功能
    });
    var slider = mui("#slider-img");
    slider.slider({
        interval: 4000
    });
</script>

<?php
include( "include/foot_.php" );
?>