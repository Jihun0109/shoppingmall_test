<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
$member_login = @$_COOKIE["member"];
$head_title = "福源泉";

function format_date($time){
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
}

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
@media screen and (min-width: 560px) {

}
@media screen and (min-width: 860px) {

}
.swiper-container-horizontal>.swiper-pagination-bullets, .swiper-pagination-custom, .swiper-pagination-fraction {
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
</style>
<div class="v3head">
    <ul>
        <li class="logo">
            <img src="img/v3/logo.png" alt="">
        </li>
        <li class="search">
            <span>
                <form action="item_list.php" method="get">
                <input type="hidden" name="menu" value="busines">
                <input type="text" name="bus_keyword" value="" placeholder="请输入关键词">
                <img src="img/v3/search.png" alt="">
                </form>
            </span>
        </li>
        <li class="region">
           <a href="region.php" target="_self">延吉市</a><img src="img/v3/bottom.png" alt="">
        </li>
    </ul>
</div>
<div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><a href="detailed_view.php?view=20&type=join" target="_blank"><img src="http://fyq.shengtai114.com/upload/banner/20180331092904.jpg" alt=""></a>
            </div>
            <div class="swiper-slide"><img src="http://fyq.shengtai114.com/upload/banner/20180331092911.jpg" alt="">
            </div>
            <div class="swiper-slide"><img src="http://fyq.shengtai114.com/upload/banner/20180331092914.jpg" alt="">
            </div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
  <div class="item_cate">
    <ul>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=101" target="_blank"><img src="img/v3/a1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=101" target="_blank">餐饮美食</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=106" target="_blank"><img src="img/v3/b1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=106" target="_blank">休闲娱乐</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=108" target="_blank"><img src="img/v3/c1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=108" target="_blank">美体美容</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=107" target="_blank"><img src="img/v3/d1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=107" target="_blank">运动健身</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=104" target="_blank"><img src="img/v3/e1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=104" target="_blank">装修装饰</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=102" target="_blank"><img src="img/v3/f1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=102" target="_blank">旅游酒店</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=103" target="_blank"><img src="img/v3/g1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=103" target="_blank">婚庆摄影</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=" target="_blank"><img src="img/v3/h1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=" target="_blank">车辆服务</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=109" target="_blank"><img src="img/v3/j1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=109" target="_blank">生活服务</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=college" target="_blank"><img src="img/v3/k1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=college" target="_blank">教育培训</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=" target="_blank"><img src="img/v3/l1.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=" target="_blank">医疗</a></li>
        <li><a class="animsition-link" href="item_list.php?menu=busines&type=&id=113" target="_blank"><img src="img/v3/z.png" alt=""></a><a class="animsition-link" href="item_list.php?menu=busines&type=&id=113" target="_blank">其他</a></li>
    </ul>
  </div>
<?php 
$query_push = "SELECT title,push_time FROM push_message where user = '{$member_login}' order by id desc limit 2";
if ($result_push = mysqli_query($mysqli, $query_push))
{
    if (mysqli_num_rows($result_push)) {
?>
<div class="push_message">
    <ul>
        <?php 
        for ($i=0;$row_push = mysqli_fetch_assoc($result_push);$i++) {
        ?>
        <li><a href="push_msg.php" target="_blank"><span class="push_title"><?php echo $row_push['title'];?></span><span class="push_time"><?php echo format_date(strtotime($row_push['push_time']));?></span></a></li>
        <?php
        }
        ?>
    </ul>
</div>
<?php 
    }
}
?>
  <div class="item_main_list">
    <div class="item_main_list_title">
      <ul>
        
        <li class="index_item_list_hot">
            <span onClick="index_item_list('hot','yes')">销量最高</span>
            <img class="item_main_list_title_down" src="svg/region_bottom000.svg" alt="下拉">
        </li>
        <li class="index_item_list_discount">
            <span onClick="index_item_list('discount','yes')">折扣最高</span>
            <img class="item_main_list_title_down" src="svg/region_bottom000.svg" alt="下拉">
        </li>
          <li class="index_item_list_recommend">
            <span onClick="index_item_list('recommend','yes')">推荐排序</a>
            <img class="item_main_list_title_down" src="svg/region_bottom000.svg" alt="下拉">
        </li>
      </ul>
    </div>
    <div class="item_main_list_hot">
      <ul></ul>
        <div class="item_main_list_hot_loding" style="display: none;"><div class="loader_ajax"></div></div>
    </div>
  </div>
<div class="foot"> 
    <a href="javascript:void(0);" target="_self" class="foot_ico foot_scan">
        <img src="img/scan.png" alt="扫一扫" onClick="scan_fyq();">
        <span>扫一扫</span>
    </a>
    <?php 
    if ($member_login) {
    ?>
    <a href="javascript:void(0);" target="_self" class="foot_center miclick"><img src="img/my_ico.png" alt="我"></a>
    <?php 
    } else {
    ?>
    <a href="javascript:void(0);" target="_self" class="foot_center login_ajax"><img src="img/foot_login.png" alt="登陆"></a>
    <?php 
    }
    ?>
    <a href="subscriber.php" target="_self" class="foot_ico foot_settled animsition-link">
        <img src="img/ruzhu.png" alt="爆品">
        <span>爆品</span>
    </a>

</div>
<div class="member_menu_alt">
    <div><a class="animsition-link" href="member_center.php" target="_self"><img src="img/member_i1.png" alt="会员中心">会员中心</a>
    </div>
    <div><a class="animsition-link" href="member_agent.php" target="_self"><img src="img/member_i2.png" alt="代理中心">代理中心</a>
    </div>
    <div><a class="animsition-link" href="myqrcode.php" target="_self">我的二维码</a><span>▼</span>
    </div>
</div>
<div class="body_bg"></div>
<script type="text/javascript">
var user_region = $.cookie('user_region');
if (!user_region) {
    $.cookie('user_region', '延吉市', { expires: 365 });
} else {
    $(".region a").text(user_region);
}

function DoWithGPS (la,lo){
    if ($.cookie('gpsla') !== la) {
        $.cookie('gpsla', la, { expires: 1 });
    }
    if ($.cookie('gpslo') !== lo) {
        $.cookie('gpslo', lo, { expires: 1 });
    } 
};
YDB.GetGPS("DoWithGPS");
    
$(document).ready(function (){  
    $(window).scroll(function(){ 
        if ($(".index_item_list_recommend").is(".item_main_list_title_font")) {
            index_item_list("recommend","no");
        }
        if ($(".index_item_list_hot").is(".item_main_list_title_font")) {
            index_item_list("hot","no");
        }
        if ($(".index_item_list_discount").is(".item_main_list_title_font")) {
            index_item_list("discount","no");
        }
    });
    index_item_list("hot","no");
});
function index_item_list(item_cate,return_loding){
    if (item_cate == "recommend") {
        $(".index_item_list_recommend").addClass("item_main_list_title_font");
        $(".index_item_list_recommend img").removeAttr("style");
        $(".index_item_list_hot, .index_item_list_discount").removeClass("item_main_list_title_font");
        $(".index_item_list_hot img, .index_item_list_discount img").css("display","none");
    }
    if (item_cate == "hot") {
        $(".index_item_list_hot").addClass("item_main_list_title_font");
        $(".index_item_list_hot img").removeAttr("style");
        $(".index_item_list_recommend, .index_item_list_discount").removeClass("item_main_list_title_font");
        $(".index_item_list_recommend img, .index_item_list_discount img").css("display","none");
    }
    if (item_cate == "discount") {
        $(".index_item_list_discount").addClass("item_main_list_title_font");
        $(".index_item_list_discount img").removeAttr("style");
        $(".index_item_list_hot, .index_item_list_recommend").removeClass("item_main_list_title_font");
        $(".index_item_list_hot img, .index_item_list_recommend img").css("display","none");
    }
    windowScrollHight = $(window).height();
    documentScrollHight = $(document).height();
    documentscrollTop = $(document).scrollTop();
    if ((windowScrollHight+documentscrollTop) >= (documentScrollHight-200) || return_loding == "yes") {
        looding = $(".item_main_list_hot_loding").css("display");
        if (looding == "none") {
            var item_main_list_count = $(".item_main_list_hot ul li").length;
            $(".item_main_list_hot_loding").css("display","block");
            if (return_loding == "yes") {
                item_main_list_count = 0;
                $(".item_main_list_hot ul").html("");
            }
            $.post("post/index_item_ajax.php",
            {
                item_count:item_main_list_count,
                item_order_by:item_cate
            },
            function(data,status){
                if (data == "0") {
                    $(".item_main_list_hot_loding").text("全部加载完毕");
                } else {
                    if (return_loding == "yes") {
                        $(".item_main_list_hot ul").html(data);
                    } else {
                        $(".item_main_list_hot ul").append(data);
                    }
                    $(".item_main_list_hot_loding").css("display","none");
                }
            });

        }
    }
}

//扫一扫
function scan_fyq() {
    if (isfuyuanquan) {
        YDB.Scan();
    } else {
        alert("扫一扫功能只能在APP内使用");
    }
}
//公告切换效果
$(document).ready(function(){ 
    var $obj = $( '.niangao_notice a' );
    var len = $obj.length;
    var i = 0;
    $(".niangao_notice div").click(function(){
        i++;
        if (i == len) {
            i = 0;
        }
        $obj.stop(true,true).hide().eq(i).fadeIn(600);
        return false;
    } );
})

$(document).ready(function(){
    $(".login_ajax").click(function(){
        $.get("post/login_ajax.php",function(data,status){
            $(".animsition").html(data);
        });
    })
    
    $( ".foot .miclick" ).click( function () {
        var foot_center_opacity = $( ".member_menu_alt" ).css( "display" );
        if ( foot_center_opacity == "none" ) {
            $( ".member_menu_alt" ).css( "display", "block" );
            $( ".member_menu_alt div:eq(1)" ).attr( "class", "a-fadeinB" ).prev().attr( "class", "a-fadeinB" );
            $( ".body_bg" ).css( {
                "background": "rgba(0, 0, 0, 0.7)",
                "display": "block",
                "opacity": "1",
                "z-index": "999"
            } )
        } else {
            $( ".member_menu_alt" ).css( "display", "none" );
            $( ".member_menu_alt div:eq(1)" ).removeClass( "a-fadeinB" );
            $( ".body_bg" ).removeAttr( "style" );
        }
    } )
    $( ".body_bg" ).click( function () {
        $( ".member_menu_alt" ).css( "display", "none" );
        $( ".member_menu_alt div:eq(1)" ).removeClass( "a-fadeinB" );
        $( ".body_bg" ).removeAttr( "style" );
        $(".menu_left").addClass("a-fadeoutL").css("display","none").removeClass("a-fadeinL");
    } )
    
    var swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
      },
    loop: true
    });
})
</script>
<?php
include( "include/foot_.php" );
?>