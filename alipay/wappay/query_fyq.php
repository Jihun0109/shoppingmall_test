<?php
/* *
 * 功能：支付宝手机网站alipay.trade.query (统一收单线下交易查询)调试入口页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 请确保项目文件有可写权限，不然打印不了日志。
 */

header("Content-type: text/html; charset=utf-8");


require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'service/AlipayTradeService.php';
require_once dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'buildermodel/AlipayTradeQueryContentBuilder.php';
require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';


    //商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
    //商户订单号，和支付宝交易号二选一
    $out_trade_no = trim($_POST['WIDout_trade_no']);

    //支付宝交易号，和商户订单号二选一
    $trade_no = "2017092121001004220279576800";

    $RequestBuilder = new AlipayTradeQueryContentBuilder();
    $RequestBuilder->setTradeNo($trade_no);
    $RequestBuilder->setOutTradeNo($out_trade_no);

    $Response = new AlipayTradeService($config);
   	$result=$Response->Query($RequestBuilder);

    return ;
?>