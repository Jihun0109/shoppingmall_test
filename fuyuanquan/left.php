<div id="sidebar-nav" class="sidebar" style="padding-top: 86px;">
	<div class="sidebar-scroll">
		<nav>
			<ul class="nav">
				<?php 
				if ($admin_login == "fuyuanquan") {
				?>
				<li><a href="index.php" class="active"><i class="lnr lnr-home"></i> <span>首页</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"member_list")) {
				?>
				<li><a href="member_list.php" class=""><i class="lnr lnr-dice"></i> <span>会员列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"agent_list")) {
				?>
				<li><a href="agent_list.php" class=""><i class="lnr lnr-dice"></i> <span>代理会员</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"share_list")) {
				?>
				<li><a href="share_list.php" class=""><i class="lnr lnr-dice"></i> <span>股东列表</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"dividends")) {
				?>
				<li><a href="dividends_list.php" class=""><i class="lnr lnr-dice"></i> <span>分红明细</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"teacher_list")) {
				?>
				<li><a href="commodity_list.php?sort=teacher" class=""><i class="lnr lnr-dice"></i> <span>讲课列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"busines_list")) {
				?>
				<li><a href="busines_list.php" class=""><i class="lnr lnr-dice"></i> <span>学院列表</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"subscriber_list")) {
				?>
				<li><a href="subscriber_list.php" class=""><i class="lnr lnr-dice"></i> <span>爆品列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"college_list")) {
				?>
				<li><a href="college_list.php" class=""><i class="lnr lnr-dice"></i> <span>店铺列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"partner_list")) {
				?>
				<li><a href="commodity_list.php?sort=partner" class=""><i class="lnr lnr-dice"></i> <span>加入会员</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"withdraw_list")) {
				?>
                <li><a href="withdraw_list_new.php" class=""><i class="lnr lnr-dice"></i> <span>提现列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"memo_list")) {
				?>
				<li><a href="memo_list.php" class=""><i class="lnr lnr-dice"></i> <span>信息列表</span></a>
				</li>
				<?php 
				}
				?>
				<?php 
				if (strstr($admin_purview,"bill_list")) {
				?>
				<li><a href="bill_list.php" class=""><i class="lnr lnr-dice"></i> <span>流水明细</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"merchant_list")) {
				?>
				<li><a href="merchant_list.php" class=""><i class="lnr lnr-dice"></i> <span>专家入驻</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"vipcard")) {
				?>
				<li><a href="vipcard.php" class=""><i class="lnr lnr-dice"></i> <span>VIP会员</span></a>
				</li>
				<?php 
				}
				?>
                <?php 
				if (strstr($admin_purview,"AgentInfo_list")) {
				?>
				<li><a href="AgentInfo_list.php" class=""><i class="lnr lnr-dice"></i> <span>代理金比例</span></a>
				</li>
				<?php 
				}
				?>
                <?php
                if (strstr($admin_purview,"settings")) {
                    ?>
                    <li><a href="settings.php" class=""><i class="lnr lnr-dice"></i> <span>Settings</span></a>
                    </li>
                    <?php
                }
                ?>
			</ul>
		</nav>
	</div>
</div>