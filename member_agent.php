<?php 
include("db_config.php");
include("include/member_level.php");
if (!$member_login) {
	echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>"; 
	exit;
}

$angel_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_recommend = '{$member_login}'");
$angel_rs=mysqli_fetch_array($angel_count,MYSQLI_NUM);
$angelNumber=$angel_rs[0];
$head_title = "代理中心";
include("include/head_.php");
$top_title = "代理中心";
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="member_center_info">
  <ul>
    <li>
      <div>
        <a href="myqrcode.php" target="_self"><img src="../img/menu/agent_qrcode.png" alt="二维码" style="width: 35%; max-width: 60px;"></a>
      </div>
    </li>
    <li>
      <div>
        <p><img src="<?php if ($row_member['mb_ico']) {echo $row_member['mb_ico'];} else {echo "img/test/ico.png";}?>" alt=""></p>
        <p><?php echo $row_member['mb_nick'];?></p>
        <p>
        	<img src="img/member_level.png" alt="<?php echo member_level($row_member['mb_level'])?>">
        	<?php 
				echo member_level($row_member['mb_level']);
				if ($row_member['mb_level'] !== 3 || $row_member['mb_level'] !== 4) {
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
      
    </li>
  </ul>
</div>
<div class="member_center_cate member_daili">
  <ul>
    <li style="width: 40%;">
      <p>提现成功佣金(元)</p>
      <p><?php echo Number_format($row_member['mb_commission_finish_gold'],2);?></p>
    </li>
    <li style="width: 35%;">
      <p>可提现佣金(元)</p>
      <p><?php echo Number_format($row_member['mb_commission_not_gold'],2);?></p>
    </li>
    <li class="member_center_cate_on" style="width: 30%;">
      <p><a class="member_agent_click" href="withdrawal.php" target="_self">佣金提现</a></p>
    </li>
  </ul>
</div>
<div class="member_center_navi">
  <ul>
    <li>
		<p><a href="member_angel.php" target="_self"><img src="img/agent_1.png" alt="我的天使"></a></p>
		<p><a href="member_angel.php" target="_self">我的天使<br><?php echo $angelNumber;?>名</a></p>
    </li>
    <li>
		<p><img src="img/agent_4.png" alt="分销佣金"></p>
		<p>分销佣金<br><?php echo Number_format($row_member['mb_commission_all'],2);?>元</p>
    </li>
    <li>
		<p><a href="my_bill.php" target="_self"><img src="img/agent_5.png" alt="佣金明细"></a></p>
      <p><a href="my_bill.php" target="_self">佣金明细<br><?php echo $row_member['mb_commission_not_count'];?>笔</a></p>
    </li>
    <li>
      <p><a href="member_data.php" target="_self"><img src="img/agent_6.png" alt="我的数据"></a></p>
      <p><a href="member_data.php" target="_self">我的数据</a></p>
    </li>
  </ul>
</div>
<?php 
include("include/foot_.php");
?>