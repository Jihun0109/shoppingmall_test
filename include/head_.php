<!doctype html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
	<title><?php echo $head_title;?></title>
	<base href="/niangao">
	<link rel="apple-touch-icon" href="/ico/touch-icon-iphone.png"/>
	<link rel="apple-touch-icon" sizes="72x72" href="/ico/touch-icon-ipad.png"/>
	<link rel="apple-touch-icon" sizes="114x114" href="/ico/touch-icon-iphone4.png"/>
	<link rel="stylesheet" type="text/css" href="/css/style.css?20181025"/>
	<link rel="stylesheet" type="text/css" href="/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="/css/jquery.skidder.css">
	<link rel="stylesheet" type="text/css" href="/css/animation.css">
    <link href="/css/mui.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/mui.css" />
    <link href="/css/icons-extra.css" rel="stylesheet"/>
    <link href="/css/icomoon.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/css/camera-image.css" />
    <link rel="stylesheet" href="/css/starscore.css" />
    <link rel="stylesheet" href="/css/ng.css" />
    <link rel="stylesheet" href="/css/liMarquee.css" />
    <link rel="stylesheet" href="css/qrcode.css" />
	  	<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">

    <script type="text/javascript" src="/js/jquery-1.10.2.js" ></script>
    <script type="text/javascript" src="/js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="/js/common.js"></script>
    <script type="text/javascript" src="/js/camera.js"></script>
    <script type="text/javascript" src="/js/barcode.js" ></script>
    <!-- jQuery -->
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
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=vmmlFR9V8hDzNoPgpGOh8NwGpfjqaGDE"></script>
    <script type="text/javascript" src="/js/jquery_fyq.js"></script>
    <script type="text/javascript" src="/js/jquery.liMarquee.js"></script>
    <script src="/js/mui.js"></script>
    <script src="/js/mui.min.js"></script>
    <script type="text/javascript" src="js/font_self-adaption.js"></script>
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

    <link rel="stylesheet" href="/css/new-style.css" />

</head>

<body>
<div class="animsition" style="padding-bottom: 45px;">