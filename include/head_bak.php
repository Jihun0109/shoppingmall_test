<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title><?php echo $head_title;?></title>
	<link rel="apple-touch-icon" href="http://fyq.shengtai114.com/ico/touch-icon-iphone.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="http://fyq.shengtai114.com/ico/touch-icon-ipad.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="http://fyq.shengtai114.com/ico/touch-icon-iphone4.png"/>
	<link rel="stylesheet" type="text/css" href="http://fyq.shengtai114.com/css/style.css?20180414"/>
	<link rel="stylesheet" type="text/css" href="http://fyq.shengtai114.com/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="http://fyq.shengtai114.com/css/jquery.skidder.css">
	<link rel="stylesheet" type="text/css" href="http://fyq.shengtai114.com/css/animation.css">
    <link href="css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/mui.css" />
    <link href="css/icons-extra.css" rel="stylesheet"/> 
    <link href="css/icomoon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="css/camera-image.css" />
    <link rel="stylesheet" href="css/starscore.css" />
    <link rel="stylesheet" href="css/ng.css" />
    <link rel="stylesheet" href="css/liMarquee.css" />
	<script type="text/javascript" src="js/common.js"></script>
    <script type="text/javascript" src="js/camera.js"></script>
    <script type="text/javascript" src="js/barcode.js" ></script>
    <script type="text/javascript" src="js/jquery-1.10.2.js" ></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/iscroll.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/clipboard.min.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/smscode.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/fuyuanquan/js/distpicker.data.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/fuyuanquan/js/distpicker.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/YdbOnline.js"></script>
	<script type="text/javascript" src="http://fyq.shengtai114.com/js/swiper.min.js"></script>
    <script type="text/javascript" src="http://fyq.shengtai114.com/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="http://fyq.shengtai114.com/js/jquery.qrcode.min.js"></script>
    <script type="text/javascript" src="http://fyq.shengtai114.com/js/gpsmite.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=vmmlFR9V8hDzNoPgpGOh8NwGpfjqaGDE"></script>
    <script type="text/javascript" src="http://fyq.shengtai114.com/js/jquery_fyq.js?<?php echo time();?>"></script>
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