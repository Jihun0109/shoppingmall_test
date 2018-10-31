<?php
include( "db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}

$query_member = "SELECT * FROM fyq_member where mb_phone = '{$member_login}'";
$result_member = mysqli_query($mysqli, $query_member);
$row_member = mysqli_fetch_assoc($result_member);

$query_merchant = "SELECT * FROM merchant_entry where me_user = '{$member_login}'";
$result_merchant = mysqli_query($mysqli, $query_merchant);
$query_college = "SELECT * FROM college_list where cl_phone = '{$member_login}'";
$result_college = mysqli_query($mysqli, $query_college);
$row_merchant = "";
//print_r($result_merchant);
if ($result_merchant->num_rows > 0 || $result_college->num_rows > 0)
{
	$row_merchant = mysqli_fetch_assoc($result_merchant);
    if ($row_merchant['me_state'] == '0') 
	{
        echo "<script> alert('专家入驻审核中！');parent.location.href='index.php'; </script>";
        exit;
    }
}
else
{
	echo "<script> alert('专家入驻后才能操作！');parent.location.href='merchant_entry.php'; </script>";
    exit;
}
$college_id = mysqli_query( $mysqli, "SELECT cl_id FROM college_list where cl_phone = '{$member_login}'" );
$college_rs = mysqli_fetch_array( $college_id, MYSQLI_NUM );
$i_class = $college_rs[ 0 ];

$head_title = "新发布";
include("include/head_.php");
$top_title = "新发布";
$top_url = "";
$top_button = "<a class='top-navigate-btn' id='commodity_in'>完成</a>";

$return_url = "..";
include("include/top_navigate_commodity.php");
?>
<script src="fuyuanquan/assets/vendor/jquery/jquery.min.js"></script>
<script src="fuyuanquan/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="fuyuanquan/assets/scripts/klorofil-common.js"></script>
<script src="fuyuanquan/assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="fuyuanquan/diyUpload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="fuyuanquan/diyUpload/js/diyUpload.js"></script>
<script type="text/javascript" src="fuyuanquan/js/thumbnail_picture.js"></script>
<script type="text/javascript" src="umeditor/third-party/template.min.js?t=<?php echo time();?>"></script>
<script type="text/javascript" charset="utf-8" src="umeditor/umeditor.config.js?t=<?php echo time();?>"></script>
<script type="text/javascript" charset="utf-8" src="umeditor/umeditor.js?t=<?php echo time();?>"></script>
<script type="text/javascript" src="umeditor/lang/zh-cn/zh-cn.js?t=<?php echo time();?>"></script>
<!-- <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=vmmlFR9V8hDzNoPgpGOh8NwGpfjqaGDE"></script> -->
<script src="fuyuanquan/js/distpicker.data.js"></script>
<script src="fuyuanquan/js/distpicker.js"></script>
<link rel="stylesheet" href="fuyuanquan/assets/vendor/bootstrap/css/bootstrap.min.css">
<!-- ICONS -->
<link rel="apple-touch-icon" sizes="76x76" href="fuyuanquan/assets/img/apple-icon.png">
<link rel="icon" type="image/png" sizes="96x96" href="fuyuanquan/assets/img/favicon.png">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/diyUpload.css">
<link rel="stylesheet" href="fuyuanquan/assets/css/main.css">
<link href="../umeditor/themes/default/css/umeditor.css?t=<?php echo time();?>" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="fuyuanquan/diyUpload/css/globle.css">
<style type="text/css">
    .merchant_entry {
        float: left;
        width: 100%;
        margin-top: 48px;
    }
    .merchant_entry .good_uploader_container{
        margin-top: 10px;
        /*margin-left: 14px;*/
        padding-left: 14px;
        padding-right: 14px;
    }
    @media only screen and (max-width: 320px) {
        .merchant_entry {
            float: left;
            width: initial;
            margin-top: 48px;
        }
        .merchant_entry .good_uploader_container{
            margin-top: 10px;
            /*margin-left: 14px;*/
            padding-left: 35px;
            padding-right: 35px;
        }
    }
    @media only screen and (max-width: 414px) {
        .merchant_entry .good_uploader_container{
            margin-top: 10px;
            padding-left: 14px;
            padding-right: initial;
        }
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
    .merchant_entry li div#feedback img{
        width: inherit;
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

    .circle {
	  	background: red;
		width: 60px;
		height: 60px;
		border-radius: 50%;
		margin-left: auto;
		margin-right: auto;
		margin-bottom: 67px;
		position: relative;
		top: 15px;
	}

</style>
	<div class="merchant_entry">
        <div id="new_pic" style="padding-bottom: 20px;">
            <p align="center" style="margin-top: 8px;font-size: 1.0em;"><font color="#FF0000">可以让讲课的图像最少2，最多5张。</font></p>
            <div style="" class="good_uploader_container">
                <ul class="upload-ul clearfix">
                    <li class="upload-pick">
                        <div class="webuploader-container clearfix" id="goodsUpload">
                            <input type="file" name="file[]" class="webuploader-element-invisible" multiple accept="">
			</div>
                    </li>
                </ul>
                <p align="center"><a class="upload-btn" href="javascript:;">开始上传</a></p>
		</div>
        </div>
		
		<span id="" class="commodity_in_pic"></span>
		<ul>
        	<li>
                <div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
                    <label class="shanggpin_label input-group-addon">活动标题</label>
                    <input type="text" class="form-control" placeholder="请输入话动标题" name="commodity_title" >
                </div>            
                
            	<input class="form-control" type="hidden" alt="备用金" name="commodity_spare" value="0.00">
                <input class="form-control" type="hidden" alt="现金" name="commodity_point_type" value="0">
                <input class="form-control" type="hidden" alt="首页顺序" name="commodity_index" value="0">
                <input class="form-control" type="hidden" alt="推荐顺序" name="commodity_array" value="0">
                <input class="form-control" type="hidden" alt="不详" name="commodity_point" value="0">
                <input class="form-control" type="hidden" alt="不详" name="commodity_vpoint" value="0">
                <input class="form-control" type="hidden" alt="推荐此商家手机号" name="commodity_recommend" value="">
                <input class="form-control" type="hidden" alt="商家店铺号" name="commodity_class" value="<?php echo $i_class;?>">
                <input class="form-control" type="hidden" alt="商家手机号" name="commodity_phone" value="<?php echo $member_login;?>">
                <!--经纪人权分销(1980)-->
                <input class="form-control" type="hidden" alt="一级" name="vip1level_1" value="0">
                <input class="form-control" type="hidden" alt="二级" name="vip1level_2" value="0">
                <input class="form-control" type="hidden" alt="三级" name="vip1level_3" value="0">
                <input class="form-control" type="hidden" alt="一级豆" name="vip1point_1" value="0">
                <input class="form-control" type="hidden" alt="二级豆" name="vip1point_2" value="0">
                <input class="form-control" type="hidden" alt="三级豆" name="vip1point_3" value="0">
				<!--合伙人分销(9800)-->
                <input class="form-control" type="hidden" alt="一级" name="vip2level_1" value="0">
                <input class="form-control" type="hidden" alt="二级" name="vip2level_2" value="0">
                <input class="form-control" type="hidden" alt="三级" name="vip2level_3" value="0">
                <input class="form-control" type="hidden" alt="一级豆" name="vip2point_1" value="0">
                <input class="form-control" type="hidden" alt="二级豆" name="vip2point_2" value="0">
                <input class="form-control" type="hidden" alt="三级豆" name="vip2point_3" value="0">
                <input class="form-control" type="hidden" alt="无分销" name="commodity_distribution_level" value="0">
			</li>
            <li>
                <div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
                    <div style="font-weight: bold; margin-bottom: 5px;">活动内容</div>
                    <textarea class="form-control" placeholder="请输入活动内容" rows="4" name="commodity_summary" ></textarea>
                </div>            

			</li>
			<li>
				<div>
					<?php  include("record/record.php");
					?>
				</div>
			</li>
			<li>
				<div style="float: left; margin-left:10px; width: 90%; margin-top:10px;">
					<label id="spic" class="mui-btn mui-btn-primary">选择讲课头像</label>
                    <p style="font-size: 1.0em;float: right;"><font color="#FF0000">只能上传1张图片</font></p>
					<input type="file" name="file1" class="inputfile" style="display:none;">
					<div id="feedback" style="float: left; width: 100%;margin-top: 20px;"></div>
                    <span id="lfile" style="display:none;position: absolute;background-color: #FFFFFF"></span>					
				</div>
			</li>
			
            <li>
            	<div style="margin-left:10px; width:90%;">
                	<div class="input-group" style="width: 100%; float: left; margin-top:10px;">
                        <span class="input-group-addon" style="width:90px;">零售价格</span>
                        <input class="form-control" type="text"  name="commodity_original" value="" >
                        <span class="input-inner-label">元</span>
                    </div>
                    <div class="input-group" style="width: 100%; float: left; margin-top:5px;">
                        <span class="input-group-addon" style="width:90px;">幸福价</span>
                        <input class="form-control" type="text"  name="commodity_price" value="" >
                        <span class="input-inner-label">元</span>
                    </div>                    
                    <div class="input-group" style="width: 100%; float: left; margin-top:5px;">
                        <span class="input-group-addon" style="width:90px;">成本价</span>
                        <input class="form-control" type="text"  name="commodity_supplyprice" value="" >
                        <span class="input-inner-label">元</span>
                    </div>
                </div>
			</li>
            <li>
                <div class="input-group" id="mopen" style="width: 90%; float: left;margin-left:10px; border:0px;">
                    <div class="mui-btn mui-btn-primary" style="width: 100%; float: left; margin-top:10px;"><a style="color: #FFFFFF;" href="javascript:void();">选择您的位置</a></div>
                </div>
                <div style="float: left; width: 100%; margin-left: 10px; display:none;" id="closewindow">
                    <div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
                        <span class="input-group-addon">坐标 X</span>
                        <input class="form-control" type="text" name="commodity_gpsx" id="cgx" value="0" style="width: 142px;">
                    </div>
                    <div class="input-group" style="width: 202px; float: left; margin-right: 10px;">
                        <span class="input-group-addon">坐标 Y</span>
                        <input class="form-control" type="text" name="commodity_gpsy" id="cgy" value="0" style="width: 142px;">
                    </div>
                </div>
                <div style="width: 90%; float: left;margin-left:10px; border:0px;">
                    <a class="show-hide-address" id="show-item-address">地址 <img src="img/plus-circle.png" alt=""></a>
                    <a class="show-hide-address" id="hide-item-address" style="display: none;">地址 <img src="img/minus-circle.png" alt=""></a>
                </div>
                <script>
                    $(".show-hide-address").click(function(){
                        $(".show-hide-address").hide();
                        if($(this).attr("id") == "show-item-address"){
                            $("#hide-item-address").show();
                            $("#address_container").show();
                        }else{
                            $("#show-item-address").show();
                            $("#address_container").hide();
                        }
                    })
                </script>
                <div id="address_container" style="display: none;">
                    <div class="area_select" id="distpicker" style="width:90%; margin-left:10px;">
                        <div class="form-group" style=" width:100%; margin-top:8px;">
                            <select class="form-control" id="province1" name="commodity_province1"></select>
                        </div>
                        <div class="form-group" style=" width:100%; margin-top:-8px;">
                            <select class="form-control" id="city1" name="commodity_city1"></select>
                        </div>
                        <div class="form-group" style=" width:100%; margin-top:-8px;">
                            <select class="form-control" id="district1" name="commodity_district1"></select>
                        </div>
                    </div>
                </div>
			</li>
            
            <li>
            	<div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
					<span class="input-group-addon">填写详细地址</span>
					<input class="form-control" type="text" name="commodity_address" value="<?php echo $row_merchant['me_address'];?>">
				</div>
            </li>
			<li>
            	<div class="input-group" style="width: 90%; float: left;margin-left:10px; border:0px;">
					<select class="form-control" name="commodity_display" style="width: 100%; float: left; margin-top:10px;">
						<option value="1">显示</option>
						<option value="0">隐藏</option>
					</select>
				</div>
            </li>
            <li>
            	<div class="input-group" style="width: 90%; float: left;margin-left:10px; border:0px;">
					<select class="form-control" name="commodity_refund" style="width: 100%; float: left; margin-top:10px;">
						<option value="1">不可以退款</option>
						<option value="0">可以退款</option>
					</select>
				</div>
            </li>
            <li>
            	<div class="input-group" style="float: left; margin-left: 10px; width: 90%; margin-top:10px;">
					<span class="input-group-addon">接单手机号</span>
					<input class="form-control" type="text" name="commodity_pushmsg" placeholder="请输入接单手机号，用“，”号隔开" value="<?php echo $member_login;?>">
				</div>
            </li>
            <li>
            	<div style=" margin-left:10px; width:100%; margin-top:10px;">
            	<?php 
					$sort = "teacher";
					include("fuyuanquan/commodity_cate.php");
				?>
                </div>
            </li>
            <li style="display:none;">
            	<div style="margin-left:10px;">
				<textarea id="myEditor" name="commodity_content" style="width:100%;height:300px;"></textarea>				</div>
				<script type="text/plain" id="myEditor"></script>
            </li>					
            <li>
				<div class="err_msg" style="margin-left:10px;"></div>
            </li>
            <!--<li>
            	<div style=" text-align:center;">
            		<button type="button" class="btn btn-success" id="commodity_in">提交</button>
                </div>
            </li>-->
		</ul>
    </div>	
    <div id="showmap" style="display:none; width:100%; height:100%; position:absolute; z-index:9999;">
    <div id="allmap" style="width: 100%;height:1100px;"></div>
	<div class="foot" style=" height:80px; bottom: 0;"> 
	<span class="mui-tab-item" style="width:100%; float:left;"><input type="text" id="nm" style="width:100%; float:left;"></span>
	<div style="width:100%; text-align:center;"><sapn id="gt"><img src="img/ok.gif" style="width:30%;margin-top:-10px;"> </sapn></div>
	</div>
    </div>							
	<!-- 百度编辑器 -->
	<script type="text/javascript">
	    function upload_product_details()
	    {
	    	$( "#product_details" ).click();
	    }
	</script>
    <script type="text/javascript" src="fuyuanquan/diyUpload/js/webuploader.min.js"></script>
    <script type="text/javascript" src="fuyuanquan/diyUpload/js/diyUpload_.js"></script>
    <script>
        var good_count = 0;
        $(function(){
            //上传图片
            var $tgaUpload = $('#goodsUpload').diyUpload({
                url:'../img_upload_many.php',
                success:function( data ) {
                    
                                good_count ++;

                    $(".upload-ul").prepend('<li><div class="viewThumb"><img src="../upload/compress/' + data._raw + '"></div></li>');
                    var i = 0;
                    $(".upload-ul li").each( function () {
                        if($(".upload-ul li").get(i).id != ""){
                            $(".upload-ul li#" + $(".upload-ul li").get(i).id).fadeOut( 500, function () {
					$( this ).remove();
                            });
                        }
                        i ++;
                    });
			},
                error:function( err ) {
				console.info( err );
			},
                buttonText : '',
			chunked: true,
			// 分片大小
			chunkSize: 512 * 1024,
                accept: {
                    title: "Images",
                    extensions: 'gif,jpg,jpeg,bmp,png'
                },
                thumb:{
                    width:110,
                    height:90,
                    quality:100,
                    allowMagnify:true,
                    crop:true,
                    type:"image/jpeg"
                },
			fileNumLimit: 5,
                        fileSizeLimit: 500000 * 1024,
			fileSingleSizeLimit: 50000 * 1024,
			accept: {}
            });
        });
	</script>

	<script type="text/javascript">
		//实例化编辑器
		var um = UM.getEditor( 'myEditor', { initialFrameWidth:'100%' } );
		um.addListener( 'blur', function () {
			$( '#focush2' ).html( '编辑器失去焦点了' )
		} );
		um.addListener( 'focus', function () {
			$( '#focush2' ).html( '' )
		} );
	</script>
	<script type="text/javascript">
		$( ".commodity_in_pic span" ).click( function () {
			$( this ).parent().remove();
		} )
		$( "#commodity_in" ).click( function () {
			var parentFileBox = "";
            var i = 0;
            $( ".upload-ul li" ).each( function ( index, element ) {
                if($(".upload-ul li").get(i).className !="upload-pick" ){
                    parentFileBox += $( ".upload-ul img:eq(" + index + ")" ).attr( "src" ) + "|";
                    console.log($(".upload-ul li").get(i).className)
                }
                i ++;
            });
			var commodity_title = $( "[name='commodity_title']" ).val().trim();
			var commodity_province1 = $( "[name='commodity_province1']" ).val();
			var commodity_city1 = $( "[name='commodity_city1']" ).val();
			var commodity_district1 = $( "[name='commodity_district1']" ).val();
			var commodity_address = $( "[name='commodity_address']" ).val();
			var commodity_price = $( "[name='commodity_price']" ).val().trim();
			var commodity_phone = $( "[name='commodity_phone']" ).val();
            var commodity_pushmsg = $( "[name='commodity_pushmsg']" ).val();
			var commodity_original = $( "[name='commodity_original']" ).val().trim();
			var commodity_supplyprice = $( "[name='commodity_supplyprice']" ).val().trim();
            var commodity_spare = $("[name='commodity_spare']").val();
			var commodity_point = $( "[name='commodity_point']" ).val();
			var commodity_point_type = $( "[name='commodity_point_type']" ).val();
			var commodity_array = $( "[name='commodity_array']" ).val();
			var commodity_cate = $( "[name='commodity_cate']" ).val();
            var commodity_vpoint = $( "[name='commodity_vpoint']" ).val();
			var commodity_display = $( "[name='commodity_display']" ).val();
			var commodity_refund = $( "[name='commodity_refund']" ).val();
			var commodity_gpsx = $( "[name='commodity_gpsx']" ).val();
			var commodity_gpsy = $( "[name='commodity_gpsy']" ).val();
            var commodity_recommend = $( "[name='commodity_recommend']" ).val();
			var commodity_distribution_level = $( "[name='commodity_distribution_level']" ).val();
			if ( $( "[name='commodity_class']" ).length > 0 ) {
				var commodity_class = $( "[name='commodity_class']" ).val();
			} else {
				var commodity_class = "<?php echo $i_class;?>";
			}
			var commodity_summary = $( "[name='commodity_summary']" ).val().trim();
			var commodity_content = $( ".edui-body-container" ).html();
			var commodity_mainimg = $( "#feedback img" ).attr( "src" );
			var commodity_index = $("[name='commodity_index']").val();
			var vip1level_1 = $( "[name='vip1level_1']" ).val();
			var vip1level_2 = $( "[name='vip1level_2']" ).val();
			var vip1level_3 = $( "[name='vip1level_3']" ).val();
			var vip2level_1 = $( "[name='vip2level_1']" ).val();
			var vip2level_2 = $( "[name='vip2level_2']" ).val();
			var vip2level_3 = $( "[name='vip2level_3']" ).val();
			var vip1point_1 = $( "[name='vip1point_1']" ).val();
			var vip1point_2 = $( "[name='vip1point_2']" ).val();
			var vip1point_3 = $( "[name='vip1point_3']" ).val();
			var vip2point_1 = $( "[name='vip2point_1']" ).val();
			var vip2point_2 = $( "[name='vip2point_2']" ).val();
			var vip2point_3 = $( "[name='vip2point_3']" ).val();

			var shop_img = $( "[name='file1']" ).val();
			

			if ( !commodity_title || !commodity_province1 || !commodity_city1 || !commodity_price || !commodity_cate || !commodity_summary || !parentFileBox || !shop_img) {
				var msgstr = "内容填写不完整!";
				if(!commodity_title)
				{
					alert('请填写活动标题！');	
					return false;
				}
				if(!commodity_province1)
				{
					alert('请选择省市区！');	
					return false;
				}
				if(!commodity_price)
				{
					alert('请填写幸福价！');	
					return false;
				}
				if(!commodity_summary)
				{
					alert('请填写活动内容！');	
					return false;
				}
				if(!parentFileBox)
				{
					alert('请上传图片！');	
					return false;
				}

				if(!shop_img)
				{
					alert('请上传店铺图片！');
					return false;
				}
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> "+msgstr+"</div>" );
			}
			else if(parseFloat(commodity_price) <= 0)
			{
				alert('请正确填写幸福价!');
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 幸福价不能高于原价!</div>" );
			} 
			else if(parseFloat(commodity_original) <= 0)
			{
				alert('请正确填写原价!');
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 幸福价不能高于原价!</div>" );
			} 
			else if(parseFloat(commodity_supplyprice) <= 0)
			{
				alert('请正确填写成本价!');
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 幸福价不能高于原价!</div>" );
			} 
			else if(parseFloat(commodity_price) > parseFloat(commodity_original))
			{
				alert('幸福价不能高于原价!');
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 幸福价不能高于原价!</div>" );
			} 
			else if(parseFloat(commodity_price) - parseFloat(commodity_supplyprice) < 1)
			{
				alert('幸福价必须大于成本价1元以上!');
				//$( ".err_msg" ).html( "<div class=\"alert alert-danger alert-dismissible\" role=\"alert\" style=\"margin-top: 5px;\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button><i class=\"fa fa-warning\"></i> 幸福价必须大于成本价1元以上!</div>" );
			} 
			else 
			{
                if (parentFileBox && good_count < 2) { 
                    alert('可以让讲课的图像最少2，最多5张'); 
                    return false;
                }

				mediaUrl = getMediaSrcUrl();
				if (!recoredCompleted()){
					alert('请记录。');	
					//return false;
				}
				else{					
					$('#upload-to-server').click();
				}

				//价格计算,备用金，坐标
				var commodity_all = commodity_price - commodity_supplyprice;
				commodity_spare = (commodity_all * 0.08).toFixed(2);
				//var ndpoint = (commodity_all * 0.7).toFixed(2); //暂定总利润的70%
				commodity_all = (commodity_all * 0.7).toFixed(2);
				vip2level_1 = (commodity_all * 0.7).toFixed(2); 
				vip2level_2 = (commodity_all * 0.1).toFixed(2);
				vip2level_3 = (commodity_all * 0.2).toFixed(2); 
				var ndpoint = vip2level_1;
				
				$( this ).attr( "disabled", "disabled" ).text( "提交中..." ).prepend( '<i class="fa fa-spinner fa-spin"></i>' );
				$.post( "post/commodity_add_post.php", {
						com_title: commodity_title,
						com_province1: commodity_province1,
						com_city1: commodity_city1,
						com_district1: commodity_district1,
						com_address: commodity_address,
						com_price: commodity_price,
						com_phone: commodity_phone,
                        com_pushmsg: commodity_pushmsg,
						com_original: commodity_original,
						com_supplyprice: commodity_supplyprice,
                        com_spare: commodity_spare,
						com_point: commodity_point,
						com_point_type: commodity_point_type,
						com_array: commodity_array,
						com_cate: commodity_cate,
                        com_vpoint: commodity_vpoint,
						com_display:commodity_display,
						com_refund: commodity_refund,
						com_gpsx:commodity_gpsx,
						com_gpsy:commodity_gpsy,
                        com_recommend:commodity_recommend,
						com_distribution_level: commodity_distribution_level,
						com_class: commodity_class,
						com_summary: commodity_summary,
						com_content: commodity_content,
						com_parentFileBox: parentFileBox,
						com_mainimg: commodity_mainimg,
						com_index:commodity_index,
						com_shopmenu: "<?php echo $sort;?>",
						vip1level1: vip1level_1,
						vip1level2: vip1level_2,
						vip1level3: vip1level_3,
						vip2level1: vip2level_1,
						vip2level2: vip2level_2,
						vip2level3: vip2level_3,
						vip1point1: vip1point_1,
						vip1point2: vip1point_2,
						vip1point3: vip1point_3,
						vip2point1: vip2point_1,
						vip2point2: vip2point_2,
						vip2point3: vip2point_3,
						nd_point: ndpoint,
						media_filename: mediaUrl,
					},
					function ( data, status ) {						
						if ( data == "1" ) {
							alert('发布成功！');
							location.href = "my_commodity.php";
						}
						else
						{
							alert('发布失败！');
							location.href = "my_commodity.php";
						}
					} );
			}
		} )
		
		$('#distpicker').distpicker({
				province:'<?php echo $row_member['mb_province'];?>',
				city:'<?php echo $row_member['mb_city'];?>',
				district:'<?php echo $row_member['mb_area'];?>'
			});
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
		document.getElementById("cgx").value = String(point.lng);
		document.getElementById("cgy").value = String(point.lat);
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
    <script type="text/javascript">
 //响应返回数据容器
 		$( document ).ready(function(){
			$("#spic").click(()=>{
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
				$("#feedback").html('<img src="../img/loding.gif" alt="加载中" style="width:50px;">');
				//$("#lfile").show(); //显示加载图片//<img src="../img/loding.gif" alt="加载中">
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
						$("#feedback").html('<img src="/upload/'+data+'" alt="" style="width:inherit;">');
						//$("#feedback").attr('src','../upload/compress/'+data);
						//$( "#lfile" ).hide(); //加载成功移除加载图片
					},
					error: function () {
						alert( '上传出错' );
						//$( "#lfile" ).hide(); //加载失败移除加载图片
						$("#feedback").html('');
					}
				} );
			} );			
		} ); 

// JavaScript Document
</script>
</body>

</html>