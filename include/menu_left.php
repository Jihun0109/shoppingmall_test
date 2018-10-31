<div class="menu_left">
	<ul class="menu_top">
		<?php 
	  if ($member_login) {
		if ($row_member['mb_ico']) {
			$member_ico = $row_member['mb_ico'];
		} else {
			$member_ico = "img/test/ico.png";
		}
	  
	  ?>
		<li class="member_ico"><img src="<?php echo $member_ico;?>" alt="홍길동">
		</li>
		<span>|</span>
		<li class="member_nick">
			<?php echo $row_member['mb_nick'];?>
		</li>
		<li class="member_level">
			<?php echo member_level($row_member['mb_level']);?>
		</li>
		<li class="member_edit"><a href="member_config.php" target="_self">编辑</a>
		</li>
		<?php 
	  } else {
	  ?>
		<li class="login_btn"><a href="login.php" target="_self">登录</a>
		</li>
		<span>|</span>
		<li class="reg_btn"><a href="registered.php" target="_self">会员注册</a>
		</li>
		<?php 
	  }
	  ?>

		<li class="menu_off"><img src="img/left_off.png" alt="导航关闭">
		</li>
	</ul>
	<ul class="menu_cate_list">
		<li style="background: rgb(255, 255, 255); border-left: 3px solid rgb(235, 97, 0);">关于我们 </li>
		<li>老师简介 </li>
		<li>学院 </li>
		<!--<li>商户 </li>-->
		<li>会员中心 </li>
		<li>代理中心 </li>
		<!--<li>课程回放 </li>-->
		<li>课程公告</li>
		<li>学院入驻</li>
	</ul>
	<div class="menu_cate_content">
		<ul style="display: block; opacity: 1;">
			<li class="menu_center"><img src="img/menu/cate1.png" alt="" style="width: 45%;">
			</li>
			
			<li class="menu_center"><a href="company_profile.php" target="_self" class="menu_company_profile">关于福源泉</a>
			</li>
		</ul>
		<ul>
			<li class="menu_ico_title"><i><img src="img/menu/ico1.png" alt="个人讲座"></i><a href="teacher.php?menu=individual" target="_self">个人讲座</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/menu/ico2.png" alt="专题讲座"></i><a href="teacher.php?menu=special" target="_self">专题讲座</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
		</ul>
		<ul>
			<li class="menu_ico_title"><i><img src="img/menu/ico3.png" alt="文化"></i><a href="item_list.php?menu=college&type=&id=101" target="_self">文化</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/menu/ico4.png" alt="艺术"></i><a href="item_list.php?menu=college&type=&id=102" target="_self">艺术</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/00001.png" alt="语言"></i><a href="item_list.php?menu=college&type=&id=103" target="_self">语言</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/00002.png" alt="早教"></i><a href="item_list.php?menu=college&type=&id=104" target="_self">早教</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/00003.png" alt="职业教育"></i><a href="item_list.php?menu=college&type=&id=105" target="_self">职业教育</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
		</ul>
		<!--<ul>
				<li class="menu_ico_title"><i><img src="img/menu/ico5.png" alt="绿色有机"></i><a href="#" target="_self">绿色有机</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
				</li>
			</ul>-->
		<ul>
			<li class="menu_center">
				<?php 
                if ($member_check == 2) {
                    echo "<p onClick=\"member_check('$member_check')\" class=\"checkin menu_checkin\">已签到</p>";
                }
                if ($member_check == 1) {
                    echo "<p onClick=\"member_check('$member_check')\" class=\"checkin menu_checkin\">签到</p>";
                }
                ?>
			</li>
			<li class="menu_ico_title"><i><img src="img/menu/ico7.png" alt="个人信息"></i><a href="member_center.php" target="_self">个人信息</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<div class="menu_bottom"></div>
			<li class="menu_ico_title"><i><img src="img/menu/ico8.png" alt="股东中心"></i><a href="shareholder.php" target="_self">股东中心</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/menu/ico9.png" alt="代理中心"></i><a href="act_apply.php" target="_self">代理中心</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<div class="menu_bottom"></div>
			<li class="menu_ico_title"><i><img src="img/menu/ico10.png" alt="余额提现"></i><a href="tixian.php" target="_self">余额提现</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<li class="menu_ico_title"><i><img src="img/menu/ico11.png" alt="余额明细"></i><a href="details.php" target="_self">余额明细</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<div class="menu_bottom"></div>
			<li class="menu_ico_small">

				<div><i><a href="tc_follow.php" target="_self"><img src="img/menu/ico13.png" alt="我的关注"></a></i><a href="tc_follow.php" target="_self">我的关注</a>
				</div>
				<div><i><img src="img/menu/ico14.png" alt="我的足迹"></i><a href="#" target="_self">我的足迹</a>
				</div>
			</li>
			<div class="menu_bottom"></div>
			<li class="menu_ico_title"><i><img src="img/menu/ico15.png" alt="收款信息"></i><a href="member_bank.php" target="_self">收款信息</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
		</ul>
		<ul>
			<li class="menu_ico_title"><i><img src="img/menu/ico16.png" alt="我的天使"></i><a href="member_angel.php" target="_self">我的天使</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<!--<li class="menu_ico_title"><i><img src="img/menu/ico17.png" alt="区域代理中心"></i><a href="#" target="_self">区域代理中心</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
				</li>-->
			<li class="menu_ico_title"><i><img src="img/menu/ico18.png" alt="推广二维码"></i><a href="myqrcode.php" target="_self">推广二维码</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<!--<div class="menu_bottom"></div>-->
			<!--<li class="menu_ico_title"><i><img src="img/menu/ico19.png" alt="小店设置"></i><a href="#" target="_self">小店设置</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
				</li>
				<li class="menu_ico_title"><i><img src="img/menu/ico20.png" alt="自选商品"></i><a href="#" target="_self">自选商品</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
				</li>-->
			<div class="menu_bottom"></div>
			<li class="menu_ico_title"><i><img src="img/menu/ico21.png" alt="佣金排名"></i><a href="member_ranking.php" target="_self">佣金排名</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
			<div class="menu_bottom"></div>
			<li class="menu_ico_small">
				<div style="width: 33%;"><i><img src="img/menu/ico22.png" alt="分销佣金"></i><a href="#" target="_self">分销佣金</a>
					<span>
						<font color="#f86342">
							<?php if ($member_login) {echo Number_format($row_member['mb_commission_all'],2);} else {echo "0";}?>
						</font> 元</span>
				</div>
				<div style="width: 33%;"><i><a href="commission_details.php" target="_self"><img src="img/menu/ico23.png" alt="佣金明细"></a></i><a href="commission_details.php" target="_self">佣金明细</a>
					<span>
						<font color="#f86342">
							<?php if ($member_login) {echo $row_member['mb_commission_not_count'];} else {echo "0";}?>
						</font> 笔</span>
				</div>
				<div style="width: 33%;"><i><a href="commission_details.php" target="_self"><img src="img/menu/ico24.png" alt="提现明细"></a></i><a href="commission_details.php" target="_self">提现明细</a>
					<span>
						<font color="#f86342">
							<?php if ($member_login) {echo $row_member['mb_commission_finish_count'];} else {echo "0";}?>
						</font> 笔</span>
				</div>
			</li>
			<li class="menu_gold">
				<div><span>成功提现佣金</span>
					<h2>
						<?php if ($member_login) {echo Number_format($row_member['mb_commission_finish_gold'],2);} else {echo "00.00";}?> 元</h2>
				</div>
				<div><span>可提现佣金</span>
					<h2>
						<?php if ($member_login) {echo Number_format($row_member['mb_commission_not_gold'],2);} else {echo "00.00";}?> 元</h2>
				</div>
			</li>
			<li class="menu_center"><a href="commission_tixian.php" target="_self" class="gold_member_out">佣金提现</a>
			</li>
		</ul>
		<!--<ul>
				<li class="menu_ico_title"><i><img src="img/menu/ico26.png" alt="课程回放"></i><a href="#" target="_self">课程回放</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
				</li>
			</ul>-->
		<ul>
			<li class="menu_ico_title"><i><img src="img/menu/ico27.png" alt="课程公告"></i><a href="#" target="_self">课程公告</a><span><img src="img/menu/more_ico.png" alt="바로가기"></span>
			</li>
		</ul>
		<ul style="padding-top: 0px;">
			<li class="menu_settled">
				<div class="menu_settled_txt"><span>请留下您的联系方式申请提交<br>
          我们会尽快联系您完成学院入住<br>
          宝贝描述.</span>
				</div>
				<!--<div class="menu_settled_input"><input type="number" name="settled_" value="" placeholder="请输入正确的联系方式(手机号)"></div>-->
				<!--<div class="menu_settled_button"><img src="img/menu/ico29.png" alt="申请提交"></div>-->
				<div class="menu_settled_button">制作中
				</div>
				<div class="menu_settled_qq"><img src="img/menu/qq_ico.png" alt="QQ">
					<input name="qqid" type="text" disabled value="QQ号： 2376296143">
				</div>
			</li>
		</ul>
	</div>
</div>