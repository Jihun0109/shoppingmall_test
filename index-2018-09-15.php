<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
//unset($_COOKIE["member"]);
//setcookie("member", "18643343045", time()+3600*24*365,"/");
$member_login = @$_COOKIE["member"];
$head_title = "福源泉";

$res = mysqli_query($mysqli, "SELECT * FROM settings;");
$settings = mysqli_fetch_array($res,MYSQLI_ASSOC);
$ads_count = $settings["ads_count"];

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
	.pgx li{
		width:48%;
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
	color: #f99c73!important;
	font-weight: bold;
	}
	
.mui-grid-view.mui-grid-9 .mui-table-view-cell {
margin: 0;
padding: 11px 5px;
vertical-align: top;
}
</style>
<header class="mui-bar mui-bar-nav" >
			<div id="dcontent" class="dcontent mui-col-sm-2 mui-col-xs-2" >
				<button onclick="show_cli()" class="button mui-btn mui-pull-left mui-icon headerbtn" style="font-size: 0.8em; padding-top: 4px; line-height: 1em; background: none;">下载</br>APP</button>
			</div>
            <div class="mui-title mui-bar-tab bar-border" style="width:200px;">
				<span class="index_item_list_hot" onClick="index_item_list('hot_new','yes')">关注</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<span class="index_item_list_discount" onClick="index_item_list('discount_new','yes')">热门</span>
                
			</div>
		        
		    <div class="mui-col-sm-2 mui-col-xs-2 mui-pull-right">
		    	<button onclick="scan_fyq();" class="mui-btn mui-pull-right mui-icon-extra mui-icon-extra-sweep headerbtn" style="padding-right: 0; padding-top: 1%; font-size: 1.5em; background: none;"></button>
		    </div>
		</header>
        
        <div class="mui-scroll" style="margin-top:10%">
								<ul id="topfollow" class="mui-table-view h-scroll mui-grid-view mui-grid-9" style="margin-top: 0;"></ul>
        <div style="width: 100%; background-color: #ebebeb; margin-bottom: 2%;">
	    	<div class="mui-icon icon-extra-icomoon icon-volume-high mui-pull-left color-f99c73" style="margin:0 1% 0 3%; line-height: 1.7em; font-size: 1.2em;"></div>
            <div class="dowebok">
			<?php
				$query = "SELECT * FROM memo_list where me_cate='10' order by me_id desc limit 0,5";
				$memo = "";
				if ($result = mysqli_query($mysqli, $query))
				{
					while( $row = mysqli_fetch_assoc($result))
					{
						$memo .= "<font>" . $row['me_title'] . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font>";
					}
				}
				echo $memo;
            ?></div>
	    </div>
    </div>       
	
  

  <div class="item_main_list" style="margin-top:35%">
    
    <div class="item_main_list_hot1" style="margin-top:13%">
      <ul id="item_list"></ul>
        <div class="item_main_list_hot_loding" style="display: none;"><div class="loader_ajax"></div></div>
    </div>
  </div>
  <div class="foot"> 
    <a href="index.php" target="_self" class="foot_ico no-link" style="width:17%;color: #f99c73;">
        <span class="mui-icon mui-icon-home" style="font-size:28px; width:100%;"></span>
		<span class="mui-tab-label">首页</span>
    </a>
    <a href="about_list.php" target="_self" class="foot_ico no-link" style="width:17%">
        <span style="width:100%;"><img src="img/map1.png" style="width:20px;"></span><br>
		<span class="mui-tab-label">附近</span>
    </a>    
    <a href="subscriber.php" target="_self" class="foot_center miclick no-link" style="width:32%;"><img src="img/newhot.png"></a>
    <?php
		if($member_login) 
		{
	?>
    <a href="my_orderall.php" target="_self" class="foot_ico no-link" style="width:17%">
        <span class="mui-icon" style="width:100%;"><img src="img/sss1.png" style="width:20px;"></span><br>
		<span class="mui-tab-label fz13">订单</span>
    </a>
    <a id="miclick" target="_self" class="foot_ico no-link" style="width:17%">
        <img src="images/messsage.gif" id="message-alert" style="width:20px; overflow: auto; position: absolute; left: 25px; top: -17px;">
        <span class="mui-icon" style="width:100%; height:100%;"><img src="img/my1.png" style="width:20px;"></span><br>
		<span class="mui-tab-label fz13">我</span>
    </a>
    <?php
		}
		else
		{
	?> 
    <a class="foot_ico login_ajax no-link" style="width:17%" onclick="return fasle">
        <span class="mui-icon" style="width:100%;"><img src="img/sss1.png" style="width:20px;"></span><br>
		<span class="mui-tab-label fz13">订单</span>
    </a>
    <a class="foot_ico login_ajax animsition-link no-link" style="width:17%">
        <span class="mui-icon no-link" style="width:100%;"><img src="img/my1.png" style="width:20px;"></span>
		<span class="mui-tab-label fz13">我</span>
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
    <div><a class="animsition-link" href="chat/chatList.php" target="_self">在线聊天</a></div>
    <div><a class="animsition-link" href="myqrcode.php" target="_self">我的二维码</a><span>▼</span>
    </div>
</div>
<div class="body_bg"></div>
<script type="text/javascript">
$(function(){
	$('.dowebok').liMarquee();
});

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
var topShow = 0;    
$(document).ready(function (){  
    $(window).scroll(function(){ 
        if ($(".index_item_list_hot").is(".item_main_list_title_font_new")) {
            index_item_list("hot_new","no");
        }
        if ($(".index_item_list_discount").is(".item_main_list_title_font_new")) {
            index_item_list("discount_new","no");
        }
    });
	<?php
		if($member_login)
		{
	?>
	index_item_list("discount_new","no");
    check_new_message();
    //index_item_list("hot_new","no");
	<?php
		}
		else
		{
	?>
	index_item_list("discount_new","no");
	<?php
		}
	?>
});

function check_new_message(){
    $.get("chat/ajax.php?action=checkNewMessage",
        function(data){
            if (data.count == 0) {
                $("#message-alert").css("display","none");
            } else {
                $("#message-alert").css("display","block");
            }

            setTimeout(check_new_message, 1000);
        }, 'json');
}

function index_item_list(item_cate,return_loding){
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
    if ((windowScrollHight+documentscrollTop) >= (documentScrollHight-200) || return_loding == "yes") {
        looding = $(".item_main_list_hot_loding").css("display");
        if (looding == "none") {
            var item_main_list_count = $("#item_list ul").length;
            $(".item_main_list_hot_loding").css("display","block");
            if (return_loding == "yes") {
                item_main_list_count = 0;
				topShow = 0;
				$(".item_main_list_hot_loding").html("");
                $("#item_list").html("");
				$("#topfollow").html("");
            }
            $.post("post/index_item_followcount_ajax.php",
            {
                item_count:item_main_list_count,
                item_order_by:item_cate
            },
            function(data,status){
                if (data == "0") {
                    $(".item_main_list_hot_loding").text("全部加载完毕");
                } else {
                    if (return_loding == "yes") {
                        $("#item_list").html(data);
                    } else {
						
                        $("#item_list").append(data);
                    }
                    $(".item_main_list_hot_loding").css("display","none");
                }
            });
			if(topShow == 0)
			{
				$.post("post/index_item_topfollow_ajax.php",
				{
					item_count:<?php echo $ads_count?>,
					item_order_by:item_cate
				},
				function(data,status){
					if (data == "0") {
						//$(".item_main_list_hot_loding").text("全部加载完毕");
					} else {
						if (return_loding == "yes") {
							$("#topfollow").html(data);
						} else {
							$("#topfollow").append(data);
						}
						$(".item_main_list_hot_loding").css("display","none");
					}
				});
				topShow = 1;
			}
        }
    }
}

//扫一扫
function scan_fyq() {
    YDB.Scan();
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

function show_cli()
{
	
		var cli_opacity = $( ".cli" ).css( "display" );
		if ( cli_opacity == "none" ) {
            $( ".cli" ).css( "display", "block" );
			 $( ".body_bg" ).css( {
                "background": "rgba(0, 0, 0, 0.7)",
                "display": "block",
                "opacity": "1",
                "z-index": "999"
            } )
		}else {
            $( ".cli" ).css( "display", "none" );
			$( ".body_bg" ).removeAttr( "style" );
		}
}

$(document).ready(function(){
    $(".login_ajax").click(function(){
        $.get("post/login_ajax.php",function(data,status){
            $(".animsition").html(data);
        });
    })
    
    $( "#miclick" ).click( function () {
        var foot_center_opacity = $( ".member_menu_alt" ).css( "display" );
        // $(".member_menu_alt").slideToggle();
        if ( foot_center_opacity == "none" ) {
            $( ".member_menu_alt" ).css( "display", "block" );
            $( ".member_menu_alt div:eq(1)" ).attr( "class", "a-fadeinB" ).prev().attr( "class", "a-fadeinB" );
            $( ".member_menu_alt div:eq(3)" ).attr( "class", "a-fadeinB" ).prev().attr( "class", "a-fadeinB" );
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
    } );
    $( ".body_bg" ).click( function () {
        $( ".member_menu_alt" ).css( "display", "none" );
        $( ".member_menu_alt div:eq(1)" ).removeClass( "a-fadeinB" );
		$( ".cli" ).css( "display", "none" );
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