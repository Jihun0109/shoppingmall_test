<?php 
include("db_config.php");
include("include/member_level.php");

if (!$member_login) {
	echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>"; 
	exit;
}
$check_time = date("Y-m-d",time());
if ($row_member['mb_check_in'] == $check_time) {
	$member_check = 2;
} else {
	$member_check = 1;
}

$pay_count = mysqli_query($mysqli, "SELECT count(pay_id) FROM payment_list left join teacher_list on payment_list.pay_shop = teacher_list.tl_id where pay_member = '{$member_login}' and pay_status = '0' and ship_status != '-1' and  teacher_list.delete_status !=0");
$pay_rs = mysqli_fetch_array($pay_count,MYSQLI_NUM);
$pay_Number = $pay_rs[0];

$head_title = "会员中心";
include("include/head_.php");
$top_title = "会员中心";//"会员中心";
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="member_center_info">
  <ul>
    <li>
      <div>
        <p>总余额</p>
        <p><?php echo Number_format($row_member['mb_not_gold']+$row_member['mb_commission_not_gold']+$row_member['mb_partner_not_gold'],2);?></p>
		  <p><a class="animsition-link" href="balance_recharge.php" target="_self">充值</a></p>
      </div>
    </li>
    <li>
      <div>
        <p><img src="<?php if ($row_member['mb_ico']) {echo $row_member['mb_ico'];} else {echo "img/test/ico.png";}?>" alt=""></p>
        <p><?php echo $row_member['mb_nick'];?></p>
        <p>
        	<img src="img/member_level.png" alt="<?php echo member_level($row_member['mb_level']);?>">
        	<?php 
				echo member_level($row_member['mb_level']);
				if ($row_member['mb_level'] !== 3 && $row_member['mb_level'] !== 4) {
					if ($row_member['mb_distribution'] == "1980.00") {
						echo " & 经纪人";
					}
					if ($row_member['mb_distribution'] == "9800.00") {
						echo " & 合伙人";
					}
				}
			?>
        </p>
      </div>
    </li>
    <li>
      <div>
        <p>幸福豆</p>
        <p><?php echo $row_member['mb_point'];?></p>
        <?php 
        if ($member_check == 2) {
            echo "<p onClick=\"member_check('$member_check')\" class=\"checkin menu_checkin\">已签到</p>";
        }
        if ($member_check == 1) {
            echo "<p onClick=\"member_check('$member_check')\" class=\"checkin menu_checkin\">签到</p>";
        }
        ?>
      </div>
    </li>
  </ul>
</div>
<div class="member_center_cate">
  <ul>
    <li>
		<p><a class="animsition-link" href="my_order.php" target="_self"><img src="img/member_ico1.png" alt="待付款"><span><?php echo $pay_Number;?></span></a></p>
		<p><a class="animsition-link" href="my_order.php" target="_self">待付款</a></p>
    </li>
    <li class="member_center_cate_on">
		<p><a class="animsition-link" href="my_orderall.php" target="_self"><img src="img/member_ico4.png" alt="全部订单"></a></p>
		<p><a class="animsition-link" href="my_orderall.php" target="_self">全部订单</a></p>
     
    </li>
  </ul>
</div>
<div class="member_center_navi">
  <ul>
    <li>
  		<p><a class="animsition-link" href="shareholder.php" target="_self"><img src="img/member_east.png" alt="股东中心"></a></p>
  		<p><a class="animsition-link" href="shareholder.php" target="_self">股东中心</a></p>
    </li>
    <li>
  		<p><a class="animsition-link" href="withdrawal.php" target="_self"><img src="img/member_prese.png" alt="余额提现"></a></p>
  		<p><a class="animsition-link" href="withdrawal.php" target="_self">余额提现</a></p>
    </li>
    <li>
  		<p><a class="animsition-link" href="my_bill.php" target="_self"><img src="img/member_bright.png" alt="余额明细"></a></p>
  		<p><a class="animsition-link" href="my_bill.php" target="_self">余额明细</a></p>
    </li>
    <li>
      <p><a href="member_agent.php" target="_self"><img src="img/member_area.png" alt="代理中心"></a></p>
		  <p><a href="member_agent.php" target="_self">代理中心</a></p>
    </li>
    <li>
  		<p><a class="animsition-link" href="tc_follow.php" target="_self"><img src="img/member_affection.png" alt="我的关注"></a></p>
  		<p><a class="animsition-link" href="tc_follow.php" target="_self">我的关注</a></p>
    </li>
    <li >
      <!-- style="background-color: #607D8B;" -->
  		<p><a class="animsition-link" href="merchant_entry.php" target="_self"><img src="img/member_merchant.png" alt="专家入驻"></a></p>
  		<p><a class="animsition-link" href="merchant_entry.php" target="_self">专家入驻</a></p>
    </li>
    <li>
      <p><a class="animsition-link" href="member_shipping_address.php" target="_self"><img src="img/member_prese.png" alt="收货地址"></a></p>
      <p><a class="animsition-link" href="member_shipping_address.php" target="_self">收货地址</a></p>
    </li>
    <?php 
    if ( get_user_sales_permission( $mysqli, $member_login ) ) {
    ?>
    <li>
      <p><a class="animsition-link" href="business_payment.php?mb_id=<?php echo $member_login;?>&item_id=0&item_login=确认" target="_self"><img src="img/member_bright.png" alt="卖家中心"></a></p>
      <p><a class="animsition-link" href="business_payment.php?mb_id=<?php echo $member_login;?>&item_id=0&item_login=确认" target="_self">卖家中心</a></p>
    </li>
    <?php
    }
    ?>
	
  </ul>
	
		<a href="httP://test.shengtai114.com/" style="color: #f0f0f0;"> don't click this characters for test</a>
	
</div>
<script type="text/javascript">
$(".top_navigate").append("<span class=\"member_center_config\"><a class=\"animsition-link\" href=\"member_config.php\" target=\"_self\"><img src=\"img/member_config_ico.png\" alt=\"个人信息\"></a></span>");
</script>
<?php 
include("include/foot_.php");
?>