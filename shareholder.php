<?php 
include("include/data_base.php");
include("include/member_db.php");
include("include/member_level.php");

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}
$member_shar = member_db($member_login,"mb_nick,mb_level,mb_ico,mb_partner_all_gold,mb_partner_not_gold,mb_partner_finish_gold,mb_share","include/data_base.php");
$member_shar = json_decode($member_shar, true);
if ($member_shar['mb_level'] < 20) {
	echo "<script> alert('此页面仅限股东访问！');parent.location.href='/'; </script>"; 
	exit;
}
$head_title = "股东中心";
include("include/head_.php");
$top_title = "股东中心";
$return_url = "..";
include("include/top_navigate.php");
?>
	<div class="shareholder_center">
		<ul>
			<li><img src="<?php echo $member_shar['mb_ico'];?>" alt=""></li>
			<li>
				<p style="color:#FFF; font-size:18px;"><?php echo $member_shar['mb_nick'];?></p>
				<p><span><img src="img/member_level.png" alt=""></span><?php echo member_level($member_shar['mb_level'])?></p>
                <p style="color:#FFF; font-size:16px;">拥有股份：<span style="color:#FFF000; font-size:18px;"><?php echo $member_shar['mb_share'];?></span></p>
                <p style="color:#FFF; font-size:16px;">股份占比：<span style="color:#FFF000; font-size:18px;"><?php echo sprintf("%.2f",($member_shar['mb_share']/60000000) * 100);?>%</span>
			</li>
			<li>
				<p>本月累计分红</p>
				<p><?php echo Number_format($member_shar['mb_partner_all_gold'],2);?></p>
				<p class="shareholder_tixian"><a href="withdrawal.php" target="_self">提现</a></p>
			</li>
		</ul>
	</div>
	<div class="shareholder_content">
		<ul>
			<li>
				<p>累计分红</p>
				<p><?php echo Number_format($member_shar['mb_partner_all_gold'],2);?><font color="#9a9a9a">元</font></p>
			</li>
			<li>
				<p>待结算分红</p>
				<p><?php echo Number_format($member_shar['mb_partner_not_gold'],2);?><font color="#9a9a9a">元</font></p>
			</li>
			<li>
				<p>已结算分红</p>
				<p><?php echo Number_format($member_shar['mb_partner_finish_gold'],2);?><font color="#9a9a9a">元</font></p>
			</li>
		</ul>
	</div>
<?php 
include("include/foot_.php");
?>