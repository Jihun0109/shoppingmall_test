<style>
.my_order_cate_list li:nth-child(2) div:nth-child(2) p {
	font-size: 0.8em;
}
.goods_title{
	white-space: pre-wrap;
	word-wrap: break-word;
	white-space: -webkit-pre-wrap;
	word-break: break-all;
	white-space: normal;
	font-size: 1em;
	color: #000000;
	margin-left: 5px;
	height: initial !important;
	line-height: initial !important;
}

.Order_title_div{
	width: inherit !important;
	height: inherit !important;
}
#user_phone > a{
	color: #8f8f94;
    text-align: left;
    /* padding: 14px 16px; */
    text-decoration: none;
    font-size: inherit ;
    width: auto;
    height: auto;
    margin-top: 0px;
}
</style>
<?php
include("include/payment_list.php");

if ( $result = mysqli_query( $mysqli, $query ) ) {
	while ( $row = mysqli_fetch_assoc( $result ) ) {
		$pay_shop 	= $row[ 'pay_shop' ];
		$pay_count 	= $row[ 'pay_count' ];
		$pay_cate 	= $row[ 'pay_cate' ];
		$pay_shop 	= $row[ 'pay_shop' ];

		$query_shop 	= "SELECT * FROM teacher_list where tl_id = '{$pay_shop}'";
		$result_shop 	= mysqli_query( $mysqli, $query_shop );
		$row_shop = mysqli_fetch_assoc( $result_shop );

		if ( $pay_cate == "charge" && $pay_shop == "pay" ) {
			?>
			<ul id="payment_<?php echo $row['pay_id'];?>">
				<li class="payment_allpay"><span>余额充值：￥ <?php echo $row['pay_price'];?></span>
				</li>
				<li class="payment_status">
					<?php 
				 		if ($row['pay_status'] == 0) {
					?>
							<span class="order_cate_1"><a href="payment.php?tradeno=<?php echo $row['pay_trade_no'];?>" target="_self">去支付</a></span>
							<span class="order_cate_2" onClick="order_off('<?php echo $row['pay_id'];?>')">取消订单</span>
					<?php 
						}
					?>
					<?php 
						 if ($row['pay_status'] == 1 && $row['ship_status'] == 3) {
							 // echo "<span class=\"order_cate_3\">已完成</span>";
						 }
					?>
					<?php 
				 		if ($row['pay_status'] == 2) {
					?>
							<span class="order_cate_4">已取消</span>
							<span class="order_cate_5" onClick="order_del('<?php echo $row['pay_id'];?>')">删除订单</span>
					<?php 
				 		}
					?>
				</li>
			</ul>
			<?php
		} else {
			if ($row_shop['tl_point_type'] == 3) {
				$tl_price = ($row_shop['tl_price']/10)."折";
				$tl_original = $row['pay_price'];
				$pay_price = ($tl_original*$row_shop['tl_price'])/100;
			} else {
				$tl_price = "￥".$row_shop['tl_price'];
				$tl_original = $row_shop['tl_original'];
				$pay_price = $row['pay_price'];
			}
			?>
			<ul id="payment_<?php echo $row['pay_id'];?>">
				<li>
					<?php if($row['pay_cate'] != "scan"){?>
					<div class="Order_title_div">
						<p class="goods_title">
							<?php 
								echo  $row['mb_receiving_address'];
							?>
							
						</p>
					</div>
					<?php }?>
				</li>
				<li>
					<?php 
						if($row['pay_cate']=="partner"){
							$type = 'join';
						} else {
							$type = 'company';
						}
					?>
					<div><a href='detailed_view.php?view=<?php echo $row['pay_shop']; ?>&type=<?php echo $type;?>'><img src="<?php echo $row_shop['tc_mainimg']?$row_shop['tc_mainimg']:'/img/none_img.png';?>" alt=""></a>
					</div>
					<div>
						<p>
							<?php echo $row_shop['tl_name'];?>
						</p>
						<p>价格：
							<font color="#ff0000">
								<?php echo $tl_price;?>
							</font>
						</p>
						<p>原价：
							<?php echo $tl_original;?>
						</p>
						<p id="user_phone">电话：
							<?php echo $row_shop['tl_phone'];?>
						</p>
						<p>时间：
							<?php echo $row[ 'pay_time' ];?>
						</p>
					</div>
				</li>
				<li><span>共<?php echo $row['pay_count'];?>件商品：￥ <?php echo $pay_price;?></span>
				</li>
				
				<li>
					<?php 
						if ($row['pay_status'] == 0) {
					?>
					<span class="order_cate_1"><a href="payment.php?tradeno=<?php echo $row['pay_trade_no'];?>" target="_self">去支付</a></span>
					<span class="order_cate_2" onClick="order_off('<?php echo $row['pay_id'];?>')">取消订单</span>
					<?php 
						}
					?>
					<?php 
						if ($row['pay_status'] == 1 && ($row['ship_status'] == 3 || $row['ship_status'] == 4 || $row['pay_cate']=="scan")) {
							echo "<span class=\"order_cate_3\">已完成</span>";
						}
					?>
					<?php 
		 				if ($row['pay_status'] == 1 && $row['ship_status'] == 2) {
		 			?>
		 			<span class="order_cate_4" onClick="receive('<?php echo $row['pay_id'];?>')">确认收货</span>
		 			<?php
						}
					?>
					<?php 
		 				if ($row['pay_status'] == 2) {
			 		?>
					<span class="order_cate_4">已取消</span>
					<span class="order_cate_5" onClick="order_del('<?php echo $row['pay_id'];?>')">删除订单</span>
					<?php 
						}
					?>
				</li>
			</ul>
			<?php
		}
	}
}
?>