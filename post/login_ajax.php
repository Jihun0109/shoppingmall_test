<div class="login_bg">
	<img src="../img/login_bg.png" alt="登录背景">
</div>
<div class="login_content">
	<ul>
		<li><img src="img/login_id.png" alt="帐号"><input type="number" pattern="[0-9]*" name="login_phone" value="" placeholder="请输入手机号码">
		</li>
		<li style="position: relative;"><img src="img/login_pass.png" alt="验证码"><input type="number" pattern="[0-9]*" name="login_code" value="" placeholder="验证码">
            <input style="right: 15%;" type="button" id="reg_code_send" value="发送验证码" onclick="sendphonecode('login','login_phone','reg_code_send')" />
		</li>
		<li><span>登录</span>
		</li>
		<li><span onClick="login_return()">返回</span><span><a href="registered.php" target="_self">注册</a></span>
		</li>
	</ul>
</div>
<script type="text/javascript">
	$(document).ready(function () {
		$(".login_content li:eq(2)").click( function () {
			var login_id = $("[name='login_phone']").val();
			var login_code = $("[name='login_code']").val();
			$.post("../post/logchek.php", {
					id: login_id,
					code: login_code
				},
				function (data, status) {
					if (data == '1') {
						location.reload();
					} else if (data == '2') {
                        alert("福源泉 找不到您的账号 请先注册!");
                    } else {
						alert("手机号或验证码不正确!");
					}
				} );
		} )
	} );
    function login_return() {
        location.reload();
    }
</script>