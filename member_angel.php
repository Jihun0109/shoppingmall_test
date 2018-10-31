<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>";
	exit;
}
$angel_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_recommend = '{$member_login}'");
$angel_rs=mysqli_fetch_array($angel_count,MYSQLI_NUM);
$angelNumber=$angel_rs[0];
$head_title = "我的天使";
include("include/head_.php");
$top_title = "我的天使";
$return_url = "..";
include("include/top_navigate.php");
	?>
	<div class="member_center_info">
		<ul>
			<li>
				<p style="margin-top: 36%;">
					<font color="#FFFFFF">累计佣金</font><br>
					<font color="#fff45c"><?php echo Number_format($row_member['mb_commission_all'],2);?>元</font>
				</p>
			</li>
			<li>
				<div>
					<p><img src="<?php if ($row_member['mb_ico']) {echo $row_member['mb_ico'];} else {echo " img/test/ico.png ";}?>" alt="">
					</p>
					<p>
						<?php echo $row_member['mb_nick'];?>
					</p>
					<p><?php echo $angelNumber;?> 名</p>
				</div>
			</li>

		</ul>
	</div>
<div class="member_ranking_cate">
		<ul>
			<li>累计天使排名为定时刷新</li>
		</ul>
	</div>
<div class="member_ranking_list">
		<ul>
			<?php 
$query = "SELECT * FROM fyq_member where mb_recommend = '{$member_login}' ORDER BY mb_commission_all desc";
if ($result = mysqli_query($mysqli, $query))
	{
		for($i=1; $row = mysqli_fetch_assoc($result);$i++ ){
			if ($row['mb_ico']) {
				$mb_ico = $row['mb_ico'];
			} else {
				$mb_ico = "img/test/ico.png";
			}
			if ($i<=3) {
				$ranking_num = "<img src=\"../img/ranking_top".$i.".png\" alt=\"\">";
			} else {
				$ranking_num = $i;
			}
			
			$t_angel_count = mysqli_query($mysqli, "SELECT count(*) FROM fyq_member where mb_recommend = '{$row['mb_phone']}'");
			$t_angel_rs=mysqli_fetch_array($t_angel_count,MYSQLI_NUM);
			$t_angelNumber=$t_angel_rs[0];
	?>
			<li>
			  <div><?php echo $ranking_num;?></div>
				<div>
				  <ul>
						<li><img src="<?php echo $mb_ico;?>" alt="">
						</li>
						<li>
							<p>
								<?php echo $row['mb_nick'];?>
							</p>
							<p>名下天使(<?php echo $t_angelNumber?>)名</p>
						</li>
				  </ul>
				</div>
				<div>
					<p>累计佣金</p>
					<p>
				  <?php echo Number_format($row['mb_commission_all']+$row['mb_partner_all_gold'],2);?>元</p>
				</div>
			</li>
		<?php 
			}
	}
		?>
		<?php
	  if (!mysqli_num_rows($result)) {
	 ?>
	<li class="blank_list">
		<p><img src="../img/shop_blank.png" alt="空白"></p>
		<p>暂无内容</p>
	</li>
	<?php 
	  }
	  ?>
  </ul>
	</div>
<?php 
include("include/foot_.php");
?>