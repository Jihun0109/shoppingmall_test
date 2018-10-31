<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$head_title = "修改密码";
include("include/head_.php");
$top_title = "修改密码";
$return_url = "..";
include("include/top_navigate.php");
?>
	<div class="member_pass_content">
		<ul>
			<li>
				<span>原密码</span><span><input type="password" name="orld_pass" value=""></span>
			</li>
			<li>
				<span>新密码</span><span><input type="password" name="new_pass1" value=""></span>
			</li>
			<li>
				<span>确认密码</span><span><input type="password" name="new_pass2" value=""></span>
			</li>
		</ul>
	</div>
<script type="text/javascript">
    $( document ).ready( function () {
        $(".top_navigate").append("<span>保存</span>");
        $(".top_navigate span:eq(2)").click(function(){
             var orld_pass = $("[name='orld_pass']").val();
             var new_pass1 = $("[name='new_pass1']").val();
             var new_pass2 = $("[name='new_pass2']").val();
            $.post("post/member_pass.php",
              {
                orld_pass:orld_pass,
                new_pass1:new_pass1,
                new_pass2:new_pass2
              },
              function(data,status){
                    if (data == "1") {
                        alert("密码修改成功！");
                    } else if (data == "2") {
                        alert("原密码不正确！");
                    } else if (data == "3") {
                        alert("两个新密码不一致！");
                    } else {
                        alert("密码修改失败！");
                    }
              });
        })
    } );
</script>
<?php 
include("include/foot_.php");
?>