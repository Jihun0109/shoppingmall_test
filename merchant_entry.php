<?php
include("include/data_base.php");
include("include/function.php");
include("include/head_.php");
$head_title = "专家入驻";
$top_title = "专家入驻";
$top_navigate_index = '<a href="index.php" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
?>
<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title><?php echo $head_title;?></title>
	<link rel="apple-touch-icon" href="ico/touch-icon-iphone.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="ico/touch-icon-ipad.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="ico/touch-icon-iphone4.png"/>
	<link rel="stylesheet" type="text/css" href="css/style.css?20180414"/>
	<link rel="stylesheet" type="text/css" href="css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="css/jquery.skidder.css">
	<link rel="stylesheet" type="text/css" href="css/animation.css">
    <link href="css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/mui.css" />
    <link href="css/icons-extra.css" rel="stylesheet"/> 
    <link href="css/icomoon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/camera-image.css" />
    <link rel="stylesheet" href="css/starscore.css" />
    <link rel="stylesheet" href="css/ng.css" />
    <link rel="stylesheet" href="css/liMarquee.css" />
    <link rel="apple-touch-icon" sizes="76x76" href="fuyuanquan/assets/img/apple-icon.png">
    <link rel="icon" type="image/png" sizes="96x96" href="fuyuanquan/assets/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/webuploader.css">
    <link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/diyUpload.css">
    <link rel="stylesheet" href="fuyuanquan/assets/css/main.css">
    <link rel="stylesheet" href="fuyuanquan/assets/vendor/bootstrap/css/bootstrap.min.css">
	<script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/camera.js"></script>
    <script type="text/javascript" src="js/barcode.js" ></script>
    <script type="text/javascript" src="js/jquery-1.10.2.js" ></script>
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="js/iscroll.js"></script>
	<script type="text/javascript" src="js/clipboard.min.js"></script>
	<script type="text/javascript" src="js/smscode.js"></script>
	<script type="text/javascript" src="fuyuanquan/js/distpicker.data.js"></script>
	<script type="text/javascript" src="fuyuanquan/js/distpicker.js"></script>
	<script type="text/javascript" src="js/YdbOnline.js"></script>
	<script type="text/javascript" src="js/swiper.min.js"></script>
    <script type="text/javascript" src="js/jquery.cookie.js"></script>
    <script type="text/javascript" src="js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="js/gpsmite.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=vmmlFR9V8hDzNoPgpGOh8NwGpfjqaGDE"></script>
    <script type="text/javascript" src="js/jquery_fyq.js?<?php echo time();?>"></script>
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
    </script>
</head>

<body>
<div class="animsition">
<?php
include("include/top_navigate.php");

if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
    if (!$member_login) {
        echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>";
        exit;
    }
}
$me_state = get_user_type( $member_login, $mysqli );
if ($me_state== '1')
{
        echo "<script> alert('您的店铺已通过审核！ 如有需要修改的请联系管理员.');parent.location.href='index.php'; </script>";
        exit;
}
?>
<style type="text/css">
    .merchant_entry {
        float: left;
        width: 100%;
        margin-top: 48px;
    }
    .merchant_entry ul {
        
    }
    .merchant_entry li {
        float: left;
        width: 100%;
        border-bottom: 5px solid #f5f5f5;
        padding-bottom: 12px;
        background-color: #FFFFFF;
    }
    .merchant_entry input {
        width: 90%;
    }
    .merchant_entry_title {
        margin-left: 10px;
        height: 46px;
        line-height: 46px;
        float: left;
        font-size: 1.2em;
    }
    .merchant_entry_content {
        width: 100%;
        float: left;
        text-align: center;
        position: relative;
        margin-bottom: 6px;
    }
    .merchant_entry_content i {
        position: absolute;
        width: 100px;
        height: 100px;
        top: 14px;
        left: 0px;
        right: 0px;
        margin: 0 auto;
    }
    .merchant_upload img {
        width: 35%;
    }
    .merchant_entry_content .inputfile {
        display: none;
    }
    .merchant_entry_post {
        text-align: center;
        padding-top: 12px;
    }
    .merchant_entry_post input {
        background-color: #FF5722;
        color: #fff;
        border: 0px;
    }
    .merchant_contract_down {
        display: block;
        height: 60px;
        line-height: 60px;
        font-size: 1.2em;
        font-weight: bold;
    }
</style>
	<div class="merchant_entry">
		<ul>
			<li>
				<span class="merchant_entry_title">专家名称</span>
				<span class="merchant_entry_content">
			  	<input type="text" name="merchant_shop" value="<?php echo $row_merchant['me_shop']?>" placeholder="请输入专家名称">
				</span>
			</li>
            <li>
                
                <!-- <div data-toggle="distpicker" class="area_select merchant_entry_content" style="margin-left:10px; width:90%;">
                    <span class="merchant_entry_title">证件类型</span>
                    <span class="form-group " style=" width:100%; margin-top:8px;">
                        <select class="form-control" id="province1" name="merchant_province1"></select>
                    </span>
                </div> -->

				<span class="merchant_entry_title">法人姓名</span>
                <span class="merchant_entry_content">
			  	<input type="text" name="merchant_name" value="<?php echo $row_merchant['me_name']?>" placeholder="请输入法人姓名">
				</span>
			</li>
            <li>
				<span class="merchant_entry_title">联系信息</span>
				<span class="merchant_entry_content">
			  	<input type="text" name="merchant_phone" value="<?php echo $row_merchant['me_phone']?>" placeholder="请输入联系信息">
				</span>
			</li>
            <li>
				<div data-toggle="distpicker" class="area_select merchant_entry_content" style="margin-left:10px; width:90%;">
					<span class="form-group " style=" width:100%; margin-top:8px;">
						<select class="form-control" id="province1" name="merchant_province1"></select>
					</span>
					<span class="form-group " style=" width:100%; margin-top:-8px;">
						<select class="form-control" id="city1" name="merchant_city1"></select>
					</span>
					<span class="form-group " style=" width:100%; margin-top:-8px;">
						<select class="form-control" id="district1" name="merchant_district1"></select>
					</span>
                </div>
                <div class="input-group" id="mopen" style="width: 90%; float: left;margin-left:10px; border:0px;">
                    <div class="mui-btn mui-btn-primary" style="width: 100%; float: left; margin-top:10px;"><a style="color: #FFFFFF;" href="javascript:void();">选择您的位置</a></div>
                </div>
                <div style="float: left; width: 100%; margin-left: 10px; display:none;" id="closewindow">
                    <div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
                        <span class="input-group-addon">坐标 X</span>
                        <input class="form-control" type="text" name="commodity_gpsx" id="cgx1" value="0" style="width: 142px;">
                    </div>
                    <div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
                        <span class="input-group-addon">坐标 Y</span>
                        <input class="form-control" type="text" name="commodity_gpsy" id="cgy1" value="0" style="width: 142px;">
                    </div>
                </div>
			</li>
            <li>
				<span class="merchant_entry_title">专家地址</span>
				<span class="merchant_entry_content">
			  	<input type="text" name="merchant_address" value="<?php echo $row_merchant['me_address']?>" placeholder="请输入专家地址">
				</span>
			</li>
			<li>
                <?php 
                if ($row_merchant['me_contract']) {
                    $me_contract = $row_merchant['me_contract'];
                } else {
                    $me_contract = 'svg/a317x.svg';
                }
                ?>
				<span class="merchant_entry_title">学历证书</span>
                <span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f1">
				<div class="merchant_upload merchant_contract"><img src="<?php echo $me_contract;?>" alt="学历证书"></div>
				</span>
			</li>
			<li>
                <?php 
                if ($row_merchant['me_idcard1']) {
                    $me_idcard1 = $row_merchant['me_idcard1'];
                } else {
                    $me_idcard1 = 'svg/a316x.svg';
                }
                ?>
                <?php 
                if ($row_merchant['me_idcard2']) {
                    $me_idcard2 = $row_merchant['me_idcard2'];
                } else {
                    $me_idcard2 = 'svg/a317x.svg';
                }
                ?>
				<span class="merchant_entry_title">证件照片</span>
                <span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f2">
				<div class="merchant_upload merchant_idcard1"><img src="<?php echo $me_idcard1;?>" alt="正面"></div>
				</span>
                <span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f3">
				<div class="merchant_upload merchant_idcard2"><img src="<?php echo $me_idcard2;?>" alt="反面"></div>
				</span>
			</li>
			<li>
                <?php 
                if ($row_merchant['me_shopdoor']) {
                    $me_shopdoor = $row_merchant['me_shopdoor'];
                } else {
                    $me_shopdoor = 'svg/a318x.svg';
                }
                ?>
				<span class="merchant_entry_title">学院门头</span>
				<span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f4">
				<div class="merchant_upload merchant_shopdoor"><img src="<?php echo $me_shopdoor;?>" alt="门头"></div>
                </span>
			</li>
            <li>
                <?php 
                if ($row_merchant['me_logo']) {
                    $me_logo = $row_merchant['me_logo'];
                } else {
                    $me_logo = 'svg/a319x.svg';
                }
                ?>
				<span class="merchant_entry_title">学院LOGO(186*106)</span>
				<span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f5">
				<div class="merchant_upload merchant_logo"><img src="<?php echo $me_logo;?>" alt="LOGO"></div>
				</span>
			</li>
            <li>
                <?php 
                if ($row_merchant['me_bg']) {
                    $me_bg = $row_merchant['me_bg'];
                } else {
                    $me_bg = 'svg/a319x.svg';
                }
                ?>
				<span class="merchant_entry_title">学院背景(750*350) </span>
				<span class="merchant_entry_content">
				<input type="file" name="file1" class="inputfile1" id="f5">
				<div class="merchant_upload merchant_bg"><img src="<?php echo $me_bg;?>" alt="LOGO"></div>
				</span>
			</li>
            <li style=" display:none;">
				<span class="merchant_entry_title">折扣信息</span>
				<span class="merchant_entry_content">
			  	<input type="text" name="merchant_original" value="10" placeholder="原价">
				</span>
                <span class="merchant_entry_content">
			  	<input type="text" name="merchant_price" value="10" placeholder="平台价">
				</span>
                <span class="merchant_entry_content">
			  	<input type="text" name="merchant_supply" value="10" placeholder="成本价">
				</span>
			</li>
            <div id="merchant_sigin" style="line-height: 60px; padding-bottom: 0px;">
                
<p>延边福源泉络科技有限公司网络服务协议书 <br>
  甲方：<u>延边福源泉络科技有限公司 </u></p>
<ul>
  <li>乙双方根据《中华人民共和国合同法》等相关法律、法规之规定，本着平等互利、共同发展的原则，就乙方使用甲方提供的延边福源泉络科技有限公司平台（下称福源泉络平台）推广商户信息及销售商品等相关事宜协商一致，自愿签订本协议。 </li>
</ul>
<p>一、服务项目 <br>
  1.甲方将其所有的福源泉络平台资源提供给乙方使用，并在该平台协助乙方推广乙方商品，并提升乙方的商业知名度。 <br>
  2.乙方通过福源泉络平台推广商品信息，进行交易活动(详见附件：商户信息表)。乙方保证《商户信息表》中的信息真实、有效，若有不实或虚假,自行承担法律责任。乙方在经营过程中,商户信息若有变动，应及时告知甲方。 <br>
  二、使用期限 <br>
  1.福源泉络平台使用期限为一年，使用期限届满，本协议自动终止。本协议终止后，甲方有权将福源泉络平台上的乙方商品强行下架(无需通知乙方)。乙方可以在使用期限届满前15日内向甲方申请续约(申请方式：书面申请或甲、乙双方在履行本协议过程中使用的其他方式)。 <br>
  三、权利与义务 <br>
  1.甲方保证其提供的福源泉络平台的合法性，并定期检测和维护网络平台的安全性及稳定性。但因不可抗力、不因甲方原因导致的网络平台出现故障，甲方不承担责任。&nbsp; <br>
  2.乙方保证在福源泉络平台提供的商品及相关资源、商户信息(包括准确住所地址以及联系方式)必须符合《产品质量法》、《消费者权益保护法》等法律、法规和规章的规定，且真实、有效。乙方违反上述约定，给甲方或第三方造成损失由乙方自行承担。 <br>
  3.乙方应及时向甲方反馈在使用福源泉络平台过程中遇到的情况（包括系统故障、功能瑕疵）。甲方应及时处理乙方提供的反馈意见。乙方未及时提供上述反馈意见或甲方未能及时协商处理、解决而造成的增加部分的损失双方各自负担。 <br>
  4.乙方在使用福源泉络平台时，应按照甲方提供的操作规范进行操作，不得违反、规避该操作规范(包括但不限于乙方提供的商户信息、商品信息不真实、不准确；乙方说服或诱导消费者不使用甲方提供的二维码等)。 <br>
  5.本协议有效期内以及终止后，下述保密条款仍具有法律效力。 <br>
  (1)未经协议相对方书面同意的情况下，不得向第三方泄露双方之间的协议等往来资料以及通过签订和履行本协议而获知的对方商业信息;(2)未经协议相对方书面同意，任何一方不得将对方的品牌、标识、资料等一切商业文件用于商业目的活动;(3)乙方未经甲方书面同意，将本协议项下的福源泉络平台使用权以及相应资源转让予他人；（4）乙方应当对自己的注册名、密码等资料自行采取保密措施，并自行承担因保密不慎而产生的一切后果。 <br>
  四、解除协议与相关责任 <br>
  1.乙方违反本协议第三条第2项、第4项、第5项的情形下，甲方可以单方解除协议，并有权将福源泉络平台上的乙方商品强行下架(无需通知乙方)，给甲方或第三方造成的损失(包括但不限于诉讼费、保全费、律师费、执行费等)均由乙方承担。 <br>
  2.甲方未对乙方提供的产品进行准时上架、推广或无故阻碍乙方在网络平台进行正常交易活动，乙方可以解除协议。 <br>
  <strong>五、免责声明 </strong><br>
  <strong>乙方已充分理解甲方在运行福源泉络平台过程中，为了福源泉络平台的正常运行或基于市场整体利益考虑，需要定期或不定期地对福源泉络平台进行停机维护或对其平台的服务内容、版面布局、页面设计等有关方面进行调整，因此类情况而影响甲方本协议项下义务的履行，甲方不对此负法律责任，但甲方应提前通知乙方，且避免上述影响或将上述影响减少至最低程度</strong>。 </p>
<ul>
  <li>争议解决方式 </li>
</ul>
<p>本协议项下争议由双方友好协商解决，若未能达成一致意见，应向甲方所在地法院诉讼解决。 </p>
<ul>
  <li>其他 </li>
</ul>
<p>本协议一式两份，于双方签字或盖章之日生效。本协议的附件是本协议组成部分，与本协议具有同等法律效力。 </p>
<p>甲方签字（盖章）：  乙方签字（盖章）：<u>              </u></p>
<p>   附件：老师信息表 <br>
  乙方营业执照及身份证明复印件各一份 </p>
 
                <div id="sigin_check">下方灰色部分签字</div></div>
            <li style="text-align: center;">
                <div id="signature" style="border: 5px solid #9E9E9E; margin-bottom: 5px;"></div>
                <input type="button" value="确定" id="siginend">
                <input type="button" value="刷新" id="siginreset">
            </li>
            <li class="merchant_entry_post">
                <input type="button" value="提交审核">
            </li>
		</ul>
	</div>
	<div class="member_bank_loading_upfile"><img src="../img/loding.gif" alt="加载中"></div>
<div id="showmap" style="display:none; width:100%; height:100%; position:absolute; z-index:9999;">
    <div id="allmap" style="width: 100%;height:1100px;"></div>
    <div class="foot" style=" height:80px; bottom: 0;"> 
    <span class="mui-tab-item" style="width:100%; float:left;"><input type="text" id="nm" style="width:100%; float:left;"></span>
    <div style="width:100%; text-align:center;"><sapn id="gt"><img src="img/ok.gif" style="width:30%;margin-top:-10px;"> </sapn></div>
    </div>
    </div>  
<script type="text/javascript" src="js/jSignature.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $("#signature").jSignature();
        $("#siginend").click(function(){
            var $sigdiv = $("#signature");
            var datapair = $sigdiv.jSignature("getData", "svg");
            $("#sigin_check").html(datapair[1]);
            $sigdiv.jSignature("reset");
        })
        $("#siginreset").click(function(){
            var $sigdiv = $("#signature");
            $sigdiv.jSignature("reset");
        })
        
    })
</script>
<script type="text/javascript">
    $( document ).ready( function () {
        $(".merchant_entry_post input").click(function(){
             var merchant_shop = $(".merchant_entry [name='merchant_shop']").val();
             var merchant_name = $(".merchant_entry [name='merchant_name']").val();
             var merchant_phone = $(".merchant_entry [name='merchant_phone']").val();
             var merchant_address = $(".merchant_entry [name='merchant_address']").val();
             var merchant_contract = $(".merchant_contract img").attr("src");
             var merchant_idcard1 = $(".merchant_idcard1 img").attr("src");
             var merchant_idcard2 = $(".merchant_idcard2 img").attr("src");
             var merchant_shopdoor = $(".merchant_shopdoor img").attr("src");
             var merchant_original = $(".merchant_entry [name='merchant_original']").val();
             var merchant_price = $(".merchant_entry [name='merchant_price']").val();
             var merchant_supply = $(".merchant_entry [name='merchant_supply']").val();
             var merchant_sigin = $("#merchant_sigin").html();
			 var merchant_province = $(".merchant_entry [name='merchant_province1']").val();
			 var merchant_city = $(".merchant_entry [name='merchant_city1']").val();
			 var merchant_district = $(".merchant_entry [name='merchant_district1']").val();
			 var merchant_logo = $(".merchant_logo img").attr("src");
			 var merchant_bg = $(".merchant_bg img").attr("src");
             var commodity_gpsx = $( ".merchant_entry [name='commodity_gpsx']" ).val();
            var commodity_gpsy = $( ".merchant_entry [name='commodity_gpsy']" ).val();
            // var com_gpsx = $( ".merchant_entry [name='commodity_gpsx']" ).val();
            // var com_gpsy = $( ".merchant_entry [name='commodity_gpsy'] ").val();
            // var commodity_gpsx = $( "[name='commodity_gpsx']" ).val();
            // var commodity_gpsy = $( "[name='commodity_gpsy']" ).val();

            
            if (!merchant_shop) {
                alert("请填写专家名称");
                return false;
            }
            if (!merchant_name) {
                alert("请填写法人姓名");
                return false;
            }
            if (!merchant_phone) {
                alert("请填写联系电话");
                return false;
            }
            if (!merchant_address) {
                alert("请填写老师地址");
                return false;
            }
            if (merchant_contract == 'svg/a323x.svg') {
                alert("请上传营业执照");
                return false;
            }
            if (merchant_idcard1 == 'svg/a316x.svg') {
                alert("请上传身份证正面");
                return false;
            }
            if (merchant_idcard2 == 'svg/a317x.svg') {
                alert("请上传身份证反面");
                return false;
            }
            if (merchant_shopdoor == 'svg/a318x.svg') {
                alert("请上传老师门头");
                return false;
            }
            if (!merchant_original) {
                alert("请填写零售价");
                return false;
            }
            if (!merchant_price) {
                alert("请填写平台价");
                return false;
            }
            if (!merchant_supply) {
                alert("请填写供货价");
                return false;
            }
            if ($("#merchant_sigin").html().length<200) {
                alert("请先签字后在提交申请");
                return false;
            }
            
            
            $.post("post/merchant_post.php",
              {
                merchant_shop:merchant_shop,
                merchant_name:merchant_name,
                merchant_phone:merchant_phone,
                merchant_address:merchant_address,
                merchant_contract:merchant_contract,
                merchant_idcard1:merchant_idcard1,
                merchant_idcard2:merchant_idcard2,
                merchant_shopdoor:merchant_shopdoor,
                merchant_original:merchant_original,
                merchant_price:merchant_price,
                merchant_supply:merchant_supply,
                merchant_sigin:merchant_sigin,
				merchant_province:merchant_province,
				merchant_city:merchant_city,
				merchant_district:merchant_district,
				merchant_logo:merchant_logo,
				merchant_bg:merchant_bg,
                com_gpsx:commodity_gpsx,
                com_gpsy:commodity_gpsy,
              },

              function(data,status){alert("d");
				  if (data == "2") {
                    alert("您已提交成功,请忽重复操作");
					location.href = "index.php";
                } else if (data == "1") {
                    alert("已提交成功，请等待审核！");
					location.href = "index.php";
                } else {
                    alert("信息提交失败，请重试！");
                }
              });
        })
    } );
</script>
<script type="text/javascript">
 //响应返回数据容器

		$( document ).ready(function(){
			$(".merchant_upload").click(function(){
				//alert($(".inputfile").attr("id"));
				//$(".inputfile").unbind('click').click();
			})
			//响应文件添加成功事件
			$(".inputfile1").change(function(){
				var onfiles = $(this).attr("class");
				var onfiles_next = $(this).next();;
				//var onfiles_next = $(this).next();
				
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
<script>    
    $("#mopen").click(function(){
        document.getElementById('showmap').style.display = "block";
    });
 </script>
 <script type="text/javascript">
    // 百度地图API功能
    var map = new BMap.Map("allmap");
    var point = new BMap.Point(108.95,34.27);
    map.centerAndZoom(point,16);

    var geolocation = new BMap.Geolocation();
    geolocation.getCurrentPosition(function(r){
        // console.log(r.point)
        if(this.getStatus() == BMAP_STATUS_SUCCESS){
            var mk = new BMap.Marker(r.point);
            map.addOverlay(mk);//标出所在地
            map.panTo(r.point);//地图中心移动
            //alert('您的位置：'+r.point.lng+','+r.point.lat);
            var point = new BMap.Point(r.point.lng,r.point.lat);//用所定位的经纬度查找所在地省市街道等信息
            addres(point);
            
        }else {
            alert('failed'+this.getStatus());
        }        
    },{enableHighAccuracy: true})
    
    //addEventListener--添加事件监听函数
    //click--点击事件获取经纬度
    map.addEventListener("click",function(e){
        addres(e.point)
    });
    
    function addres(point)
    {
        map.clearOverlays();//删除所有标注
        //prompt("",e.point.lng + "," + e.point.lat);
        var xElement = document.getElementById("cgx1");
        var yElement = document.getElementById("cgy1");

        document.getElementById("cgx1").value = String(point.lng);
        document.getElementById("cgy1").value = String(point.lat);
        var marker = new BMap.Marker(point);
        map.addOverlay(marker);
        var gc = new BMap.Geocoder();
        gc.getLocation(point, function(rs)
        {
            var addComp = rs.addressComponents; 
            // console.log(rs.address);//地址信息
            //alert(rs.address);//弹出所在地址
            document.getElementById("nm").value = rs.address;
        });
    }
    $("#gt").click(function(){
        document.getElementById('showmap').style.display = "none";
    });
    </script>
<?php 
include("include/foot_.php");
?>