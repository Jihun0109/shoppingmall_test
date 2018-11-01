<?php 
$qid = @$_COOKIE["qid"];
$head_title = "会员注册";
include("include/head_.php");
$top_title = "会员注册";
$return_url = "..";
//include("include/top_navigate.php");
?>
	<div class="registered_bg">
		<img src="../img/registered_bg.png" alt="会员注册背景">
	</div>
	<div class="registered_content">
		<ul>
			<li style="margin-bottom: -15px "><div class="registered_ico"><img src="img/login_id.png" alt="手机号码"></div><input type="text" pattern="[0-9]*" name="login_phone" value="" placeholder="请输入手机号码" required>
			</li>
			<li style="margin-bottom: -15px "><div class="registered_ico"><img src="img/nick_ico.png" alt="名称"></div><input type="text" name="login_nick" value="" placeholder="名称" required>
			</li>
			<li style="margin-bottom: -10px "><div class="registered_ico"><img src="img/login_pass.png" alt="密码"></div><input type="password" name="login_pass" value="" placeholder="密码" required>
			</li>
			<li style="margin-bottom: -5px ">
				<div data-toggle="distpicker" class="area_select">
					<div class="form-group">
						<select class="form-control" id="province1" name="teacher_province1" required>
			</select>
					
					</div>
					<div class="form-group">
						<select class="form-control" id="city1" name="teacher_city1" required>
			</select>
					
					</div>
					<div class="form-group">
						<select class="form-control" id="district1" name="teacher_district1" required>
			</select>
					
					</div>
				</div>
			</li>
			<li style="margin-bottom: -15px "><div class="registered_ico"><img src="img/reg_code.png" alt="验证码"></div><input type="text" name="login_code" value="" placeholder="验证码" required>
				<input type="button" id="reg_code_send" value="发送验证码" onclick="sendphonecode('register','login_phone','reg_code_send')" />
			</li>
			<li >
			<?php 
			if (!$qid) {
			?>
			<div class="registered_ico"><img src="img/login_id.png" alt="推荐人手机号码"></div><input type="text" name="login_recommend" value="" placeholder="推荐人手机号码(选填)">
			<?php 
			}
			?>
			</li>
			<li class="input_protocol">
				<input type="checkbox" name="reg_protocol"><span class="protocol_alt">用户注册及使用APP隐私协议</span>
			</li>
			<li><span class="registered_submit">提交</span>
			</li>
			<li><span>已有账号,</span><span><a class="animsition-link" href="index.php" target="_self">立即登录</a></span>
			</li>
		</ul>
	</div>
	
	<div class="reg_protocol">
		<p>用户注册及使用APP隐私协议</p>
		<p>在此特别提醒您（用户）在注册成为用户之前， 请认真阅读本《用户协议》（以下简称“协议”）， 确保您充分理解本协议中各条款。 请您审慎阅读并选择接受或不接受本协议。 除非您接受本协议 所有条款，否则您无权注册、 登录或使用本协议所涉服务。 您的注册、登录、使用等行为将视为对 本协议的接受，并同意接受本协议各项条款的约束。 本协议约定福源泉与用户之间 关于“福源泉” 软件服务（以下简称“服务”）的权利义务。</p>
		<h2>一、账号注册</h2>
		<p>1、用户在使用本服务前需要注册一个“福源泉”账号。“福源泉”账号应当使用手机号码绑定注册 ，请用户使用尚未与“福源泉”账号绑定的手机号码，以及未被福源泉根据本协议封禁的手机号码注册“福源泉”账号。福源泉可以根据用户需求或产品需要对账号注册和绑定的方式进行变更，而无须事先通知用户。</p>
		<p>2、“福源泉”系基于全球服务的APP产品，用户注册时应当授权福源泉公开及使用其个人信息方可成功注册“福源泉”账号。故用户完成注册即表明用户同意福源泉提取、公开及使用用户的信息。</p>
		<p> 3、鉴于“福源泉”账号的绑定注册方式，您同意福源泉在注册时将允许您的手机号码及手机设备识 别码等信息用于注册。</p>
		<h2> 二、用户个人隐私信息保护</h2>
		<p> 1、如果福源泉发现或收到他人举报或投诉用户违反本协议约定的，福源泉有权不经通知随时对相关 内容，包括但不限于用户资料、发贴记录进行审查、删除，并视情节轻重对违规账号处以包括但不 限于警告、账号封禁 、设备封禁 、功能封禁的处罚，且通知用户处理结果。</p>
		<p> 2、因违反用户协议被封禁的用户，可以自行与福源泉联系。其中，被实施功能封禁的用户会在封禁 期届满后自动恢复被封禁功能。被封禁用户可提交申诉，福源泉将对申诉进行审查，并自行合理判 断决定是否变更处罚措施。</p>
		<p> 3、用户理解并同意，福源泉有权依合理判断对违反有关法律法规或本协议规定的行为进行处罚，对违法违规的任何用户采取适当的法律行动，并依据法律法规保存有关信息向有关部门报告等，用户 应承担由此而产生的一切法律责任。</p>
		<p> 4、用户理解并同意，因用户违反本协议约定，导致或产生的任何第三方主张的任何索赔、要求或损失，包括合理的律师费，用户应当赔偿福源泉与合作公司、关联公司，并使之免受损害。</p>
		<h2> 三、使用规则</h2>
		<p> 1、用户在本服务中或通过本服务所传送、发布的任何内容并不反映或代表，也不得被视为反映或代 表“福源泉”的观点、立场或政策，福源泉对此不承担任何责任。</p>
		<p> 2、用户不得利用“福源泉”账号或本服务进行如下行为：</p>
		<p> (1) 提交、发布虚假信息，或盗用他人头像或资料，冒充、利用他人名义的；</p>
		<p>(2) 强制、诱导其他用户关注、点击链接页面或分享信息的；</p>
		<p> (3) 虚构事实、隐瞒真相以误导、欺骗他人的；</p>
		<p> (4) 利用技术手段批量建立虚假账号的；</p>
		<p> (5) 利用“福源泉”账号或本服务从事任何违法犯罪活动的；</p>
		<p> (6) 制作、发布与以上行为相关的方法、工具，或对此类方法、工具进行运营或传播，无论这些行为是否为商业目的；</p>
		<p> (7) 其他违反法律法规规定、侵犯其他用户合法权益、干扰“福源泉”正常运营或福源泉未明示授 权的行为。</p>
		<p> 3、用户须对利用“福源泉”账号或本服务传送信息的真实性、合法性、无害性、准确性、有效性等 全权负责，与用户所传播的信息相关的任何法律责任由用户自行承担，与福源泉无关。如因此给福源泉或第三方造成损害的，用户应当依法予以赔偿</p>
		<h2>  四、其他</h2>
		<p> 1、福源泉郑重提醒用户注意本协议中免除福源泉责任和限制用户权利的条款，请用户仔细阅读，自主考虑风险。未成年人应在法定监护人的陪同下阅读本协议。</p>
		<p> 2、本协议的效力、解释及纠纷的解决，适用于中华人民共和国法律。若用户和福源泉之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，用户同意将纠纷或争议提交福源泉住所地有管辖权的人民法院管辖。</p>
		<p>3、本协议的任何条款无论因何种原因无效或不具可执行性，其余条款仍有效，对双方具有约束力。</p>
		<p> 4、本协议最终解释权归福源泉所有。</p>
		<div class="reg_protocol_off">
			<input type="button" name="reg_protocol_off" value="关闭">
		</div>
	</div>
	<script type="text/javascript">
		$( document ).ready( function () {
			$( ".registered_submit" ).click( function () {
				var login_phone = $( ".registered_content [name='login_phone']" ).val();
				var login_nick = $( ".registered_content [name='login_nick']" ).val();
				var login_pass = $( ".registered_content [name='login_pass']" ).val();
				var login_code = $( ".registered_content [name='login_code']" ).val();
				var login_recommend = $( ".registered_content [name='login_recommend']" ).val();
				var login_province1 = $( ".registered_content [name='teacher_province1']" ).val();
				var login_city1 = $( ".registered_content [name='teacher_city1']" ).val();
				var login_district1 = $( ".registered_content [name='teacher_district1']" ).val();
				if(!login_phone){ 
					alert("请输入手机号码");  
					return false;
				}
				if(!login_nick){ 
					alert("请输入名称");  
					return false;
				}
				if(!login_pass){ 
					alert("请输入密码");  
					return false;
				}
				if(!login_code){ 
					alert("请输入验证码");  
					return false;
				}
				if(!login_province1 || !login_city1 || !login_district1){ 
					alert("请选择地区");  
					return false;
				}
				$.post( "../post/registered_detection.php", {
						phone: login_phone,
						nick: login_nick,
						pass: login_pass,
						code: login_code,
						province1: login_province1,
						city1: login_city1,
						district1: login_district1,
						recommend: "<?php echo $qid;?>",
						recommend_phone: login_recommend
					},
					function ( data, status ) {
						if ( data == 1 ) {
							alert("手机号已存在! 确认跳转登录页面");
							window.location.href = "index.php";
						}
						if ( data == "ok" ) {
							alert("注册成功!");
							window.location.href = "/";
						}
						if ( data == "coderr" ) {
							alert("验证码错误!");
						}
						if (data == "10") {
							alert("推荐人手机号错误请重新填写");
						}
					} );
			} );
			$(".protocol_alt").click(function(){
				$(".reg_protocol").css("display","block");
			})
			$(".reg_protocol_off input").click(function(){
				$(".reg_protocol").css("display","none");
			})
		} );
	</script>
<?php 
include("include/foot_.php");
?>