<?php
	include( "db_config.php" );
	include("include/shipping_address.php");

	if ( !$member_login ) {
		echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
		exit;
	}
	$head_title = "我的信息";
	$top_title = "我的信息";
	$return_url = "..";
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title><?php echo $head_title;?></title>
	<link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
	<link rel="stylesheet" type="text/css" href="/css/style.css?20180414"/>
	<link rel="stylesheet" type="text/css" href="/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.skidder.css">
	<script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/js/iscroll.js"></script>
	<script type="text/javascript" src="/js/clipboard.min.js"></script>
	<script type="text/javascript" src="/js/smscode.js"></script>
	<script type="text/javascript" src="/fuyuanquan/js/distpicker.data.js"></script>
	<script type="text/javascript" src="/fuyuanquan/js/distpicker.js"></script>
	<script type="text/javascript" src="/js/YdbOnline.js"></script>
	<script type="text/javascript" src="/js/swiper.min.js"></script>
    <script type="text/javascript" src="/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="/js/gpsmite.js"></script>
    <script type="text/javascript" src="/js/jquery_fyq.js?<?php echo time();?>"></script>
    <script type="text/javascript" src="js/jquery.liMarquee.js"></script>
    <script type="text/javascript">
        var YDB = new YDBOBJ();
        <?php 
        if (isset($_COOKIE["member"])) {
        ?>
        var userName = '<?php echo $_COOKIE["member"];?>';
        YDB.SetUserRelationForPush(userName);//userName为用户唯一标识
        <?php
        }
        ?>
		//function show_input()
		//	{
		//		$(".inputfile").click();
		//	}
    </script>
    <style type="text/css">
       .member_config_content [name=member_nick] {
            text-align: right;
       }
       .member_config_content_input {
	        width: 60%;
        }
    </style>
</head>

<body>
	<div>
	<?php
	include("include/top_navigate.php");
	?>
	<div class="member_config_content">
		<ul>
			<li>
				<span>头像</span>
                <span>				
				<span class="loading_upfile"><img src="../img/loding.gif" alt="加载中"></span>
                <img id="feedback" src="<?php if ($row_member['mb_ico']) {echo $row_member['mb_ico'];} else {echo "../img/test/ico.png";}?>" alt="">
                <span><input type="file" name="file1" class="inputfile"></span>
				</span>
			</li>
			<li>
				<span>名称</span><span><input type="text" name="member_nick" value="<?php echo $row_member['mb_nick'];?>"></span>
			</li>
			<li>
				<span>性别</span>
				<span>
			  	<select class="member_sex">
				  <option value="1">男</option>
				  <option value="2">女</option>
				</select>
				</span>
			</li>
			<li>
				<span>手机号</span><span><?php echo $row_member['mb_phone'];?></span>
			</li>
			<li>
				<span>QQ</span><span class="member_config_content_input"><input type="number" name="member_qq" pattern="[0-9]*" value="<?php echo $row_member['mb_qq'];?>"></span>
			</li>
			<li>
				<span>收货地址</span><span class="member_config_content_input"><input type="text" name="member_receivingaddress" value="<?php echo $row_member['mb_receiving_address'];?>"></span>
			</li>
			<li>
				<span>邮编</span><span class="member_config_content_input"><input type="text" name="member_postcode" pattern="[0-9]*" value="<?php echo $row_member['mb_postcode'];?>"></span>
			</li>
			<li>
				<a href="member_bank.php" target="_self" class="member_bank_link animsition-link">收款信息</a>
			</li>
			<li>
				<a href="member_pass.php" target="_self" class="member_pass_link animsition-link">修改密码</a>
			</li>
		</ul>
	</div>
<script type="text/javascript" charset="utf-8">
    $( document ).ready( function () {
        $(".top_navigate").append("<span>保存</span>");
        $(".top_navigate span:eq(2)").click(function(){
            var member_ico = $("#feedback").attr("src");
			//alert($("#feedback").attr("src"));
            var member_sex = $(".member_sex").val();
            var member_nick = $(".member_config_content [name='member_nick']").val();
            var member_qq = $(".member_config_content [name='member_qq']").val();
            var member_receivingaddress = $(".member_config_content [name='member_receivingaddress']").val();
            var member_postcode = $(".member_config_content [name='member_postcode']").val();
            $.post("post/member_config.php",
              {
                member_ico:member_ico,
                member_sex:member_sex,
                member_nick:member_nick,
                member_qq:member_qq,
                member_receivingaddress:member_receivingaddress,
                member_postcode:member_postcode
              },
              function(data,status){
                    if (data == "1") {
                        alert("个人信息修改成功！");
                    } else {
                        alert("个人信息修改失败！");
                    }
              });
        })
        $(".member_sex").val("<?php echo $row_member['mb_sex'];?>");

        // 响应返回数据容器
		$("#feedback").click(()=>{
			$(".inputfile").click();
		})
		//响应文件添加成功事件
		$(".inputfile").change(function(){
			var onfiles = $(this).attr("class");
			//创建FormData对象
			var data = new FormData();
			//为FormData对象添加数据
			$.each($(this)[0].files, function (i,file) {
				data.append('upload_file'+i,file);
			} );

			$(".loading_upfile").show(); //显示加载图片
			//发送数据
			var file1 = $("input:file").prop( "name" );
			$.ajax( {
				url: '../submit_img.php?imgtype=100_100&file_name=' + file1,
				type: 'POST',
				data: data,
				cache: false,
				contentType: false, //不可缺参数
				processData: false, //不可缺参数
				success: function ( data ) {
					//$("#feedback").html('<img src="/upload/compress/'+data+'" alt="">');
					$("#feedback").attr('src','../upload/compress/'+data);
					$( ".loading_upfile" ).hide(); //加载成功移除加载图片
				},
				error: function () {
					alert( '上传出错' );
					$( ".loading_upfile" ).hide(); //加载失败移除加载图片
				}
			} );
		} );
		
		$("[name='member_sex']").val("<?php echo $row_member['mb_sex'];?>");
    } );

  
</script>

<script type="text/javascript">
	// 响应返回数据容器
	// $( document ).ready(function(){
		
		
	// } ); 
// JavaScript Document
</script>
<?php 
include("include/foot_.php");
?>