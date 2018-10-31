<?php
include("include/config.php");
include("include/data_base.php");
include("include/member_db.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
//echo $member_login;
include("include/shipping_address.php");
$receive_address = mb_exist_shipping($member_login, $mysqli);

$mb_id = $receive_address['mb_id'];
$query = "SELECT * FROM `shipping address` where `mb_id` = $mb_id AND `status` = 1";

$result = mysqli_query($mysqli, $query);
$row_data = mysqli_fetch_assoc($result);
$mb_receiving_address = $row_data['mb_receiving_address'];
$mb_shipping_id = $row_data['id'];
// $data['status'] = $row_data['status'];

$member_view = member_db($member_login,"mb_id,mb_point,mb_ico","include/data_base.php");
$member_view = json_decode($member_view, true);
$member_view_mb_id = $member_view['mb_id'];
if (isset($_GET['view'])) {
    $tid = $_GET['view'];
} else {
    $tid = '';
}
if (isset($_GET['type'])) {
    $type = $_GET['type'];
} else {
    $type = '';
}

if (isset($_GET['mphone'])) {
    $mphone = $_GET['mphone'];
} else {
    $mphone = '';
}

if (!$tid || !$type) {
	exit;
}

$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$sql_follow = mysqli_query( $mysqli, "SELECT count(fl_id) FROM follow_list where fl_phone = '{$member_login}' and fl_tid = '{$tid}'" );
$follow_rs = mysqli_fetch_array( $sql_follow, MYSQLI_NUM );
$follow_totalNumber = $follow_rs[ 0 ];
if ( $follow_totalNumber ) {
	$follow_img = "img/on_ok.png";
} else {
	$follow_img = "img/off_ok.png";
}

$query = "SELECT tl.*, me.mb_nick, me.mb_ico FROM teacher_list AS tl LEFT JOIN fyq_member AS me ON tl.tl_phone=me.mb_phone where tl_id = '{$tid}'";
$result = mysqli_query( $mysqli, $query );
$row = mysqli_fetch_assoc( $result );

$shop_type = $row['shop_menu'];
$shop_cate = $row['tl_cate'];
$query_cate = "SELECT * FROM item_cate where ic_cid = '{$shop_cate}' and ic_type = '{$shop_type}'";
if ($result_cate = mysqli_query($mysqli,$query_cate)) {
	$row_cate = mysqli_fetch_assoc($result_cate);
}

$cl_id = $row[ 'tl_class' ];
$query_view = "SELECT * FROM college_list where cl_id = '{$cl_id}'";
$result_view = mysqli_query( $mysqli, $query_view );
$row_view = mysqli_fetch_assoc( $result_view );

$member_id = $member_view_mb_id;
$picUrl = 'http://localhost/detailed_view.php?view='.$tid.'&type='.$type.'&mphone='.$member_login.'&qid='.$member_id;//二维码扫描出的链接

$head_title = $row['tl_name'];
$top_title = "";//$row['tl_name'];
include( "include/head_.php" );

if ($type == "individual") {
    $return_url = "teacher.php";
}
if ($type == "join") {
    $return_url = "subscriber.php";
}
//include( "include/top_navigate.php" );
?>
<?php 
if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
    $top_navigate_return = '<div onClick="YDB.GoBack()"><img src="/img/return_top.png" alt="返回"></div>';
} else {
    if (@$_SERVER["HTTP_REFERER"]) {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    } else {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    }
}
echo "<script> var tid=".$tid;
echo "</script>"
?>
<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
</div>
<style type="text/css">
    .viewqrcode canvas {
        width: 100%;
    }
    .tc_detailed_foot_gps {
        color: #FFFFFF;
    }

    #area_4,#area_5,#area_6,#area_7,#area_8,#area_9 ul {
        margin-top: -13px;
    }
</style>
<div class="swiper-container swiper4">
<div class="swiper-wrapper">
		<?php 
		$pictures = (explode("|",$row['tl_pictures']));
		$pictures_length=count($pictures);
		for($x=0;$x<$pictures_length;$x++)
		{
			if (strstr($pictures[$x],"server")) {
				$pictures_src = "../fuyuanquan/".$pictures[$x];
			} else {
				$pictures_src = $pictures[$x];
			}
		?>
		<div class="swiper-slide"><img src="<?php echo $pictures_src;?>" alt="">
		</div>
		<?php 
		}
		?>
	</div>
	<!-- Add Pagination -->
	<div class="swiper-pagination"></div>
	<!-- Add Arrows -->
	<div class="swiper-button-next"></div>
	<div class="swiper-button-prev"></div>
</div>

<div class="tc_detailed_">
	<ul>
		<li class="tc_detailed_line1">
			<p class="tc_detailed_title">
				<?php echo $row['tl_name'];?>
			</p>
		</li>
		<li>
			<p>
				<?php $mediaSrc= $row['tl_video'];?>
				<audio id="player" controls style="width:100%;">
					
					<!-- <source src="<?php echo $mediaSrc;?>"> -->
					<!-- <source id="source" src="<?php echo $tid;?>"> -->
				</audio>
			</p>
		</li>
		<li class="tc_detailed_line2">
			<p class="tc_detailed_price">
				<span>
					<?php 
					if ($row['tl_point_type'] == "0") {
					?>
						幸福价￥<?php echo $row['tl_price'];?><i style="margin-left: 5px; text-decoration: line-through; color: #959595; font-size: 0.8em;">原价￥<?php echo $row['tl_original'];?></i>
						<?php if ($row_cate['ic_name']) {?>
						<span class="item_cate">
							<?php echo $row_cate['ic_name'];?>
						</span>
						<?php }?>
					<?php 
					}
					?>
					<?php 
					if ($row['tl_point_type'] == "1") {
					?>
					<img src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
						<?php 
							if ($row_cate['ic_name']) {
						?>
						<span class="item_cate">
							<?php echo $row_cate['ic_name'];?>
						</span>
						<?php 
							}
						?>
						<?php 
						if ($member_login) {
						?>
						<span class="member_point">可用幸福豆<font color="#f39800"><?php echo $member_view['mb_point'];?></font></span>
						<?php 
						}
						?>
					<?php 
					}
					?>
					<?php 
					if ($row['tl_point_type'] == "2") {
					?>
					￥<?php echo $row['tl_price'];?>
					<img style="margin-left: 10px;" src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
						<?php 
							if ($row_cate['ic_name']) {
						?>
						<span class="item_cate">
							<?php echo $row_cate['ic_name'];?>
						</span>
						<?php 
							}
						?>
						<?php 
						if ($member_login) {
						?>
						<span class="member_point">可用幸福豆<font color="#f39800"><?php echo $member_view['mb_point'];?></font></span>
						<?php 
						}
						?>
					<?php 
					}
					?>
					<?php 
					if ($row['tl_point_type'] == "3") {
					?>
					<?php echo $row['tl_price']/10;?>折
						<?php 
							if ($row_cate['ic_name']) {
						?>
						<span class="item_cate">
							<?php echo $row_cate['ic_name'];?>
						</span>
						<?php 
							}
						?>
					<?php 
					}
					?>
                    <?php 
					if ($row['tl_point_type'] == "4") {
					?>
						幸福价￥<?php echo $row['tl_price'];?><i style="margin-left: 5px; text-decoration: line-through; color: #959595; font-size: 0.8em;">原价￥<?php echo $row['tl_original'];?></i>
						<?php if ($row_cate['ic_name']) {?>
						<span class="view_cate">
							<?php echo $row_cate['ic_name'];?>
						</span>
						<?php }?>
					<?php 
					}
					?>
				</span>
				
			</p>
		</li>
		<li class="tc_detailed_line3">
			<p class="tc_detailed_sales">月销 <?php echo $row['tl_Sales'];?> 笔</p>
			<?php 
				if (strstr($HTTP_USER_AGENT,"fuyuanquan.net")) {
					$tc_mainimg = str_replace("..","",$row['tc_mainimg']);
			?>
			<p class="tc_detailed_share_txt" onClick="wxshare('<?php echo utf8_strcut(wxstrFilter($row['tl_name']),35,'');?>', '<?php echo utf8_strcut(wxstrFilter($row['tl_summary']),40,'');?>', 'http://localhost/<?php echo $tc_mainimg;?>', '<?php echo $picUrl;?>')">点击分享</p>
			<?php 
				} else {
			?>
			<!-- <p class="tc_detailed_share_txt" onClick="clipboard_share('<?php echo $picUrl;?>')">复制链接</p> -->
			<?php 
				}
			?>
		</li>
		<?php
			if( $member_login && ( $row['tl_point_type'] == "3" || $row['tl_point_type'] == "4" || $type != "company" ) ){
		?>
			<li class="tc_detailed_line4">
				<a href="/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>">
					<p class="tc_detailed_shipping_address" style="float: left;">收货地址</p>
				</a>
				<a href="/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>" style="float: right;">
					<p class="point_1"></p>
				</a>
			</li>
		<?php
			}
		?>
	</ul>
</div>
<?php
if ( $type == "company" ) {
	?>
	<div class="businesses_detailed_account">
		<ul>
			<li><img src="<?php echo $row_view['cl_logo'];?>" alt="">
			</li>
			<li>
				<p>
					<?php echo $row_view['cl_name'];?>
				</p>
				<p class="detailed_view_region">
					<font color="#828282">
						<?php echo $row['tc_province1'];?>
						<?php echo $row['tc_city1'];?>
						<?php echo $row['tl_district1'];?>
					</font>
				</p>
                <p id="user_phone">电话：
						<?php echo $row['tl_phone'];?>
				</p>
			</li>
			<li><a href="user_blog.php?id=<?php echo $row_view['cl_id'];?>" target="_self">详情</a>
			</li>
		</ul>
		<ul>
			<li><a href="#" target="_self">学院宝贝 <font color="#707070"><?php echo $row_view['cl_allcount'];?></font></a>
			</li>
			<li><a href="my_commodity_add1.php" target="_self">学院销量 <font color="#707070"><?php echo $row_view['cl_allsales'];?></font></a>
			</li>
			<li><a href="index_test.php" target="_self">关注人数 <font color="#707070"><?php echo $row_view['cl_allfollow'];?></font></a>
			</li>
		</ul>
	</div>
	<?php
}
?>
<?php
if ($row['tl_summary']){
?>
	<div class="tc_detailed_simple"><?php echo nl2br($row['tl_summary']);?></div>
<?php
}
?>
	<div class="tc_detailed_content">
		
	</div>

<div class="tc_detailed_foot" style="z-index: 100;">
	<ul>
		<li>
            <?php if($member_login && $row["mb_nick"]): ?>
                <span style="width:20%;" onclick="location.href='/chat/chat.php?partner=<?php echo $row["tl_phone"];?>'"><img src="images/chat.png" id="toggle-chat"></span>
            <?php endif;?>
            <?php
            if ($row['GPS_X'] && $row['GPS_Y']) {
            ?>
            <span class="tc_detailed_foot_gps">查看路线</span>
            <span class="tc_detailed_foot_follow1"><img id="follow_<?php echo $row['tl_id'];?>" onClick="follows('<?php echo $tid;?>','<?php echo $member_login;?>','<?php echo $follow_img;?>')" src="<?php echo $follow_img;?>" alt="收藏"></span>
            <?php 
            } else {
            ?>
            <span class="tc_detailed_foot_follow2"><img id="follow_<?php echo $row['tl_id'];?>" onClick="follows('<?php echo $tid;?>','<?php echo $member_login;?>','<?php echo $follow_img;?>')" src="<?php echo $follow_img;?>" alt="收藏"></span>
            <?php }?>
        </li>
		<?php
		if ($row['tl_point_type'] == "0" && $member_login == $row['tl_phone']) {
		?>
		<li class="item_buy" style="pointer-events: none;background-color: grey;">立即获取</li>
		<?php 
		} else if($row['tl_point_type'] == "0" && $member_login != $row['tl_phone']){
			echo '<li class="item_buy">立即获取</li>';
		}
		?>
		<?php 
		if ($row['tl_point_type'] == "1" && $member_login == $row['tl_phone']) {
		?>
		<li class="item_point" style="pointer-events: none;background-color: grey;">立即兑换</li>
		<?php 
		} else if($row['tl_point_type'] == "1" && $member_login != $row['tl_phone']){
		?>
		<li class="item_point">立即兑换</li>
		<?php
		}
		?>
		<?php 
		if ($row['tl_point_type'] == "2" && $member_login == $row['tl_phone']) {
			echo '<li class="item_buy" style="pointer-events: none;background-color: grey;">立即获取</li>';
		} else if($row['tl_point_type'] == "2" && $member_login != $row['tl_phone']){
		?>
		<li class="item_buy">立即获取</li>
		<?php 
		}
		?>
		<?php 
		if ($row['tl_point_type'] == "3" && $member_login == $row['tl_phone']) {
			echo '<li class="item_scan" style="pointer-events: none;background-color: grey;">立即支付</li>';
		} else if($row['tl_point_type'] == "3" && $member_login != $row['tl_phone']){
		?>
		<li class="item_scan" onclick='check_shipping_address("scan_pay.php?bid=<?php echo $row['tl_id'];?>")'><a>立即支付</a></li>
		<?php 
		}
		?>
        <?php 
		if ($row['tl_point_type'] == "4" && $member_login == $row['tl_phone']) {
			echo '<li class="item_scan" style="pointer-events: none;background-color: grey;">立即支付</li>';
		} else if($row['tl_point_type'] == "4" && $member_login != $row['tl_phone']){
		?>
		<li class="item_scan"  onclick='check_shipping_address("vip_card.php?bid=<?php echo $row['tl_id'];?>")'>
			<a>立即获取</a>
		</li>
		
		<?php 
		}
		?>
	</ul>



</div>

<div class="tc_detailed_confirm">
	<ul>
		<li class="tc_detailed_confirm_view">
			<div> <img src="<?php echo $row['tc_mainimg'];?>" alt=""> </div>
			<div>
				<p>
					<?php echo $row['tl_name'];?><span><img src="img/off_tc.png" alt="取消" class="tc_detailed_off"></span>
				</p>
				<p>
					<?php if ($row_cate['ic_name']) {echo $row_cate['ic_name'];}?>
				</p>
				<?php 
				if ($row['tl_point_type'] == "0") {
				?>
				<p>
					<font color="#cdcdcd">价格:</font>
					<font color="#ff0000">￥
						<?php echo $row['tl_price'];?>
					</font>
				</p>
				<?php 
				}
				?>
				<?php 
				if ($row['tl_point_type'] == "1") {
				?>
				<p class="item_point">
					<img src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
				</p>
				<?php 
				}
				?>
				<?php 
				if ($row['tl_point_type'] == "2") {
				?>
				<p class="item_point">
					<span>￥<?php echo $row['tl_price'];?></span>
					<img src="img/point_ico.png" alt="幸福豆图标"><?php echo $row['tl_point_commodity'];?>
				</p>
				<?php 
				}
				?>
			</div>
		</li>
		<?php 
if ($type == "company") {
?>
		<li class="tc_detailed_confirm_squantity"> <span>获取数量</span>
			<div class="tc_detailed_confirm_count"><img src="img/shopchartcount1.png" alt="减" class="businesses_detailed_jian">
				<input type="number" name="businesses_detailed_count" value="1">
				<img src="img/shopchartcount2.png" alt="加" class="businesses_detailed_jia">
			</div>
		</li>
		<?php 
}
?>
		<li class="tc_detailed_line4" id="shipping_address" style="background-color: white;margin-bottom: 20px;margin-top: 20px;">
			<?php 
				if($member_login){
			?>
			<a href="/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>">
				<p class="tc_detailed_shipping_address" style="float: left;">收货地址</p>
			</a>
			<a href="/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>" style="float: right;">
				<p class="point_2"></p>
			</a>
			<?php
			}?>
		</li>
		<li class="tc_detailed_confirm_confirm"> 确定 </li>
	</ul>
</div>
<div class="tc_detailed_bg"></div>
<?php
if($member_login && $row["mb_nick"]):
    ?>
    <script type="text/javascript" src="/js/chat.js"></script>
    <div id="chatContainer" style="display: none;">
        <div id="chatTitleBar"><?php echo $row["mb_nick"]?></div>

        <input id="chatTo" style="display: none;" value="<?php echo $row["tl_phone"]?>">
        <input id="to_ico" style="display: none;" value="<?php echo $row["mb_ico"]?>">
        <input id="me_ico" style="display: none;" value="<?php echo $member_view['mb_ico']?>">

        <div id="chatLineHolder"></div>
        <div id="chatBottomBar">
            <form id="submitForm" method="post" action="">
                <input id="chatText" name="chatText" class="rounded" maxlength="255" />
                <input type="submit" class="blueButton" value="发送" />
            </form>

        </div>
    </div>
    <?php
endif;
?>
<div class="view_qrcode">
	<ul>
		<li>
			<img src="<?php echo $row['tc_mainimg'];?>" alt="">
			<video class="mui-pull-left" src="<?php echo $main_img;?>" type="video/mp4" style="outline: 1px solid #d3d2d4;width:80px;height:80px;border-radius:10px;margin-right:5px;"></video>
		</li>
		<li>
			<div class="viewqrcode"></div>
			<div style="width: 60%;">
				<p>
					<?php echo $row['tl_name'];?>
				</p>
				<p>
					<span>
						<?php 
						if ($row['tl_point_type'] == "0") {
							echo $row['tl_price'];
						}
						if ($row['tl_point_type'] == "1") {
							echo "<img src=\"img/point_ico.png\" alt=\"幸福豆图标\">".$row['tl_point_commodity'];
						}
						if ($row['tl_point_type'] == "2") {
							echo "<span>￥".$row['tl_price']."</span>";
							echo "<img src=\"img/point_ico.png\" alt=\"幸福豆图标\">".$row['tl_point_commodity'];
						}
						if ($row['tl_point_type'] == "3") {
							echo ($row['tl_price']/10)."折";
						}
						?>
					</span>
					<?php 
					if ($row['tl_point_type'] == "0") {
					?>
					<span>
						<?php echo $row['tl_original'];?>
					</span>
					<?php 
					}
					?>
				</p>
			</div>
		</li>
		<li>截屏保存分享给您的朋友</li>
	</ul>
</div>

<script type="text/javascript">
        var mb_id = "<?php echo $mb_id;?>";
	var shipping_id = "<?php echo $mb_shipping_id;?>";

	$( document ).ready( function () {
		if ( mb_id ) {
			$.ajax({
				type: 'POST',
				url: "/include/shipping_address.php?action=getting_default_shipping_address",
				data: { 
					mb_id: mb_id,
				},
				headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
				success: function(response) {
					var mb_ship_province = JSON.parse(response).mb_ship_province ? JSON.parse(response).mb_ship_province + ', ' : "";
					var mb_ship_city = JSON.parse(response).mb_ship_city ? JSON.parse(response).mb_ship_city + ', ' : "";
					var mb_ship_district = JSON.parse(response).mb_ship_district ? JSON.parse(response).mb_ship_district + ', ' : "";
					var mb_receiving_address = JSON.parse(response).mb_receiving_address ? JSON.parse(response).mb_receiving_address : "";
					
					$.trim($('.tc_detailed_line4 a:nth-child(2) p').text(mb_ship_province + mb_ship_city + mb_ship_district + mb_receiving_address));
				},
				error: function (request, error) {
			        alert(" 不能这样做因为: " + error);
			    },
			});
		}

        $('.viewqrcode').qrcode({
            text: "<?php echo $picUrl;?>"
        })
		$( ".top_navigate" ).append( "<span class=\"tc_qrcode\"><img src=\"img/qrcode_ico.png\" alt=\"二维码\"></span>" );

		$( ".tc_detailed_content" ).css( {
			"display": "block",
		} );
		$.post("post/view_content.php",
		{
			viewid:"<?php echo $tid;?>"
		},
		function(data,status){
		$(".tc_detailed_content").html(data);
			// scrollTo('.tc_detailed_content');
		});

		// $( ".tc_comtent_more p" ).click( function () {
			
		// } )
		$(".tc_detailed_foot .item_buy").click(function () {
			<?php 
		if ($type == "join") {
		?>
			$( ".tc_detailed_confirm_confirm" ).click();
			<?php 
		} else {
		?>
			$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","block");
			<?php 
		}
		?>
		} )
		
		$( ".tc_detailed_off" ).click( function () {
			$( ".tc_detailed_confirm, .tc_detailed_bg" ).css("display","none");
		} )

		$( ".businesses_detailed_jian" ).click( function () {
			var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
			if ( parseInt( businesses_detailed_val ) > 1 ) {
				$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) - 1 );
			}
		} )
		$( ".businesses_detailed_jia" ).click( function () {
			var businesses_detailed_val = $( "[name='businesses_detailed_count']" ).val();
			if ( parseInt( businesses_detailed_val ) > 0 ) {
				$( "[name='businesses_detailed_count']" ).val( parseInt( businesses_detailed_val ) + 1 );
			}
		} )

		$( ".top_navigate .tc_qrcode" ).click( function () {
			$( ".view_qrcode, .tc_detailed_bg" ).css( "display", "block" );
		} )
		$( ".tc_detailed_bg" ).click( function () {
				$( ".view_qrcode, .tc_detailed_bg, #chatContainer").css( "display", "none" );
			} )
		$( ".tc_point_commodity" ).click( function () {
			var tc_point_commodity_selected = $( ".tc_point_commodity" ).is( '.point_selected' );
			if ( tc_point_commodity_selected ) {
				$( this ).removeClass( "point_selected" );
			} else {
				$( this ).addClass( "point_selected" );
			}
		} )
		
		$("#player").on("play", function () {
			
			if ($('#player').attr("src") == "" || $('#player').attr("src") === undefined){
				$.post('record/play_request.php', {'tid': tid}, function (data,status) {
					
					if (data < 0){
						alert("Log in failed");					
					}
					else if (data < 1){
						alert("you did not paid!");
					}
					else if (data == 1){
						$('#player').attr("src", "record/playsong.php?tid=" + tid);						
						player.load();
						player.play();
					}
					
				});
			}
			else{
				
			}
		});
	} );

	//点击更多滑倒详细内容
	function scrollTo(ele, speed) {
		if (!speed) speed = 600;
		if (!ele) {
			$("html,body").animate( {
				scrollTop: 0
			},speed);
		} else {
			if (ele.length > 0) $("html,body").animate({
				scrollTop:$(ele).offset().top-48
			},speed);
		}
		return false;
	}

	function check_shipping_address(url) {
		var shipping_address = $.trim($('.tc_detailed_line4 a:nth-child(2) p.point_1').text());
		if(mb_id){
			if(shipping_address){
				window.open( url + '&shipping_address=' + shipping_address ,'_self')	
			} else {
				alert("请您先设定收货地址一下。");
				window.location = "/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>";
			}
		} else {
			$.get("post/login_ajax.php",function(data,status){
				$(".animsition").html(data);
			});
		}
			
	}
</script>
<script type="text/javascript">
        $(".tc_detailed_confirm_confirm, .tc_detailed_foot .item_point").click(function(){ 
		var shipping_address = "shipping_address";//$.trim($('.tc_detailed_line4 a:nth-child(2) p.point_2').text());
		if ( mb_id ) {
			if (shipping_address) {
	if ($("[name='businesses_detailed_count']").length > 0){
		var detailed_count = $("[name='businesses_detailed_count']").val();
	} else {
		var detailed_count = 1;
	}
	var point_selected = $(".tc_point_commodity").is(".point_selected");
	if (point_selected) {
		point_selected = 1;
	} else {
		point_selected = 0;
	}
	$.post("post/payment_.php",{
			sid: "<?php echo $row['tl_id'];?>",
			squantity: detailed_count,
			point_selected: point_selected,
						mphone: "<?php echo ($mphone > '0') ? $mphone : "0";?>",
						shipping_id: "<?php echo $mb_shipping_id;?>"
		},
		function (data, status) {
						console.log(data);
			if (data == "5") {
				alert("此讲课暂时无法获取!");
				return;
			} else if (data == "6") {
				alert("您当前积分不够获取此产品");
				return;
			} else if (data == "10") {
				alert("请先登录后操作");
				ShowLoginForm();
				return;
			} else if (data == "8") {
                alert("此产品仅限一次获取");
				return;
			} else if (data.length > 30) {
                document.title = data;
				return;
            } else if (data) {
				location.href = "payment.php?tradeno=" + data;
			}
	});
			} else {
				location.href = "payment.php?tradeno=" + data;
			
				// alert("请您先设定收货地址一下。");
				// window.location = "/member_shipping_address.php?from_detail=1&detail_item=<?php echo $_GET['view']; ?>&detail_type=<?php echo $_GET['type']; ?>";
			}
		} else {
			$.get("post/login_ajax.php",function(data,status){
				$(".animsition").html(data);
			});
		}
	});
</script>
<?php 
$endlat = $row['GPS_Y'];
$endlon = $row['GPS_X'];
?>
<script type="text/javascript">
var isiPhone = userAgent.indexOf('iPhone') != -1;
$(".tc_detailed_foot_gps").click(function(){
    //if (isfuyuanquan) {
        YDB.NavigatorInfo("getnavigator");
    //} else {
    //    alert("导航功能只能在 APP 内使用");
    //}
})
  
function DoWithGPSapple (la,lo){
    startlats = la-0.006;
    startlons = lo-0.0065;
    endlats = <?php echo $endlat;?>-0.006;
    endlons = <?php echo $endlon;?>-0.0065;
    YDB.appleNavigation(startlats, startlons, endlats, endlons);
}
function DoWithGPSBaidu (la,lo){
    YDB.NavigatorBaiduPath(la, lo, "<?php echo $endlat;?>", "<?php echo $endlon;?>");
}
function DoWithGPSGaode (la,lo){
    startlats = la-0.006;
    startlons = lo-0.0065;
    endlats = <?php echo $endlat;?>-0.006;
    endlons = <?php echo $endlon;?>-0.0065;
    YDB.NavigatorGaodePath(startlats, startlons, "", endlats, endlons, "");
}
  
function getnavigator(info){
    var info = $.parseJSON(info);
    var baiduMap = info.bMap;
    var gaodeMap = info.aMap;
    var googleMap = info.gMap;
    if (isiPhone) {
        YDB.GetGPS('DoWithGPSapple');
    } else {
        if (baiduMap == "true") {
            YDB.GetGPS('DoWithGPSBaidu');
            return false;
        } else
        if (gaodeMap == "true") {
            YDB.GetGPS('DoWithGPSGaode');
            return false;
        } else {
            alert("请先安装百度地图或高德地图");
            return false;
        }
    }
}
</script>
<?php
include( "include/foot_.php" );
?>