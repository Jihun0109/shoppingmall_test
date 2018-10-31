<?php
header("Content-type: text/html; charset=utf-8");
include("db_config.php");
if (!isset($_COOKIE["member"])) {
    echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

$phone = $_COOKIE["member"];
$sql_merchant = "SELECT * FROM merchant_entry WHERE me_user='$phone'";
$result = mysqli_query($mysqli, $sql_merchant);
if(!$result || $result->num_rows == 0){
    echo "<script> alert('商户入驻后才能操作！');parent.location.href='merchant_entry.php'; </script>";
    exit;
}
$merchant_row = mysqli_fetch_array($result, MYSQLI_ASSOC);

$picUrl = 'http://fyq.shengtai114.com/qr_pay.php?mid='.$merchant_row["me_id"]; //二维码扫描出的链接
//$picUrl = 'http://fyq.shengtai114.com/qr_pay.php?mid='.$member_id; //二维码扫描出的链接
$head_title = "商店二维码";
$top_title = "商店二维码";
include("include/head_.php");
include("include/top_navigate.php");
?>
<style type="text/css">
    .myqrcode_code canvas {
        width: 100%;
        border: 8px solid #ffffff;
    }
    .myqrcode_foot span {
        float: inherit;
    }
    .myqrcode_nick {
        position: absolute;
        bottom: 7.5%;
        left: 38%;
        font-size: 1.4em;
        color: #fff;
        font-weight: bold;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 200px;
        width: 36%;
    }
    .myqrcode_ico {
        position: absolute;
        bottom: 4%;
        width: 20%;
        left: 13.5%;
        border-radius: 110px;
    }
    @media screen and (max-width: 480px) {
        .myqrcode_ico {
            bottom: 4%;
        }
    }
</style>
	<div style="position: relative; width: 80%; margin: 60px auto; margin-bottom: 0px;">
		<img style="width: 100%;" src="/img/myqrcodebg.jpg" alt="">
		<div class="myqrcode_code"></div>
		<img class="myqrcode_ico" src="<?php if ($merchant_row['me_shopdoor']) {echo $merchant_row['me_shopdoor'];} else {echo " img/test/ico.png ";}?>" alt="">
		<span class="myqrcode_nick"><?php echo $merchant_row['me_shop'];?></span>
	</div>
	<div class="myqrcode_foot">
	<?php 
		if (strstr($HTTP_USER_AGENT,"fuyuanquan.net")) {
	?>
		<span onClick="wxshare('福源泉', '联接商户粘住客户', 'http://fyq.shengtai114.com/img/logo.png', '<?php echo $picUrl;?>')">点击分享</span>
	<?php 
		} else {
	?>
		<span class="tc_detailed_share_txt" onClick="clipboard_share('<?php echo $picUrl;?>')">点击复制分享链接</span>
	<?php 
		}
	?>
	</div>
<script type="text/javascript">
$(document).ready(function(){
    $('.myqrcode_code').qrcode({
        text: "<?php echo $picUrl;?>",
        width: 300,
        height: 300,
        <?php
            if($merchant_row['me_shopdoor']):
        ?>
        imgWidth: 100,
        imgHeight: 100,
        src: "<?php echo $merchant_row['me_shopdoor']?>"
        <?php
            endif;
        ?>
    })
});
</script>
<?php 
include("include/foot_.php");
?>