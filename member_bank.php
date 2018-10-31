<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$head_title = "收款信息";
include("include/head_.php");
$top_title = "收款信息";
$return_url = "..";
include("include/top_navigate.php");
?>
	<div class="member_bank_content">
		<ul>
			<li>
				<span>收款姓名</span>
				<span>
			  	<input type="text" name="receipt_name" value="<?php echo $row_member['mb_name_receipt'];?>" placeholder="请输入收款姓名">
				</span>
			</li>
			<li>
				<span>支付宝</span><span>
				<input type="file" name="file1" class="inputfile">
				<div id="receipt_alipay"><img src="<?php if ($row_member['mb_alipay_receipt']) {echo $row_member['mb_alipay_receipt'];} else {echo "../img/test/zhifubao.jpg";}?>" alt="支付宝"></div>
				</span>
				<div style="text-align: center;">点击二维码修改</div>
				<input type="text" name="alipay_account" value="<?php echo $row_member['mb_alipay_account'];?>" placeholder="请输入支付宝帐号" style="display: block;height: 36px;font-size: 0.8em;width: 80%;margin: 10px auto 0 auto;">
			</li>
			<li>
				<span>微信</span><span>
				<input type="file" name="file1" class="inputfile">
				
				<div id="receipt_wechat"><img src="<?php if ($row_member['mb_wechat_receipt']) {echo $row_member['mb_wechat_receipt'];} else {echo "../img/test/weixin.jpg";}?>" alt="微信"></div>
				</span>
				<div style="text-align: center;">点击二维码修改</div>
			</li>
			<li>
				<span>银行卡</span>
				<span>
			  		<input type="text" name="receipt_open_bank" value="<?php echo $row_member['mb_open_bank'];?>" placeholder="开户行">
			  		<input type="text" name="receipt_card" value="<?php echo $row_member['mb_bankcardnumber'];?>" placeholder="卡号">
				</span>
			</li>
		</ul>
	</div>
	<div class="member_bank_loading_upfile"><img src="../img/loding.gif" alt="加载中"></div>
<script type="text/javascript">
    $( document ).ready( function () {
        $(".top_navigate").append("<span>保存</span>");
        $(".top_navigate span:eq(2)").click(function(){
             var receipt_name = $(".member_bank_content [name='receipt_name']").val();
             var receipt_alipay = $("#receipt_alipay img").attr("src");
             var alipay_account = $(".member_bank_content [name='alipay_account']").val();
             var receipt_wechat = $("#receipt_wechat img").attr("src");
             var receipt_card = $(".member_bank_content [name='receipt_card']").val();
             var receipt_open_bank = $(".member_bank_content [name='receipt_open_bank']").val();

            $.post("post/member_bank.php",
              {
                receipt_name:receipt_name,
                receipt_alipay:receipt_alipay,
                alipay_account:alipay_account,
                receipt_wechat:receipt_wechat,
                receipt_card:receipt_card,
                receipt_open_bank:receipt_open_bank
              },
              function(data,status){
                    if (data == "1") {
                        alert("收款信息修改成功！");
                    } else {
                        alert("收款信息修改失败！");
                    }
              });
        })
    } );
</script>
<script type="text/javascript">
 //响应返回数据容器

		$( document ).ready(function(){
			$("#receipt_alipay").click(function(){
				$(this).prev(".inputfile").click();
			})
			$("#receipt_wechat").click(function(){
				$(this).prev(".inputfile").click();
			})
			//响应文件添加成功事件
			$(".inputfile").change(function(){
				var onfiles = $(this).attr("class");
				var onfiles_next = $(this).next();
				//创建FormData对象
				var data = new FormData();
				//为FormData对象添加数据
				$.each($(this)[0].files, function (i,file) {
					data.append('upload_file'+i,file);
				} );

				$(".member_bank_loading_upfile").show(); //显示加载图片
				//发送数据
				var file1 = $("input:file").prop( "name" );
				$.ajax( {
					url: '../submit_img.php?imgtype=nosize&file_name=' + file1,
					type: 'POST',
					data: data,
					cache: false,
					contentType: false, //不可缺参数
					processData: false, //不可缺参数
					success: function ( data ) {
						$(onfiles_next).html('<img src="../upload/'+data+'" alt="">');
						$( ".member_bank_loading_upfile" ).hide(); //加载成功移除加载图片
					},
					error: function () {
						alert( '上传出错' );
						$( ".member_bank_loading_upfile" ).hide(); //加载失败移除加载图片
					}
				} );
			} );
		} ); 

// JavaScript Document
</script>
<?php 
include("include/foot_.php");
?>