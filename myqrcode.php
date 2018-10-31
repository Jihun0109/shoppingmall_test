<?php
header("Content-type: text/html; charset=utf-8");
include("include/member_db.php");
if (!isset($_COOKIE["member"])) {
    echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
	exit;
}
$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];
$member_qrcode = member_db($_COOKIE["member"],"mb_id,mb_ico,mb_nick","include/data_base.php");
$member_qrcode = json_decode($member_qrcode, true);
$member_id = $member_qrcode['mb_id'];
$picUrl = 'http://fyq.shengtai114.com/recommend_reg.php?qid='.$member_id; //二维码扫描出的链接
$head_title = "我的二维码";
$top_title = "我的二维码";
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
		<img style="width: 100%;" src="../img/myqrcodebg.jpg" alt="">
		<div class="myqrcode_code"></div>
		<img class="myqrcode_ico" src="<?php if ($member_qrcode['mb_ico']) {echo $member_qrcode['mb_ico'];} else {echo " img/test/ico.png ";}?>" alt="">
		<span class="myqrcode_nick"><?php echo $member_qrcode['mb_nick'];?></span>
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
        text: "<?php echo $picUrl;?>"
    })
});
</script>
<?php 
include("include/foot_.php");
?>