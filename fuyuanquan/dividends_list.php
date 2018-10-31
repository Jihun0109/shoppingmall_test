<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"dividends")) {
	echo "您没有权限访问此页";
	exit;
}
function getlastMonthDays($date){
     $timestamp=strtotime($date);
     $firstday=date('Y-m-01',strtotime(date('Y',$timestamp).'-'.(date('m',$timestamp)-1).'-01'));
     $lastday=date('Y-m-d',strtotime("$firstday +1 month -1 day"));
     return array($firstday,$lastday);
}
$lastdate = getlastMonthDays(date('Ymd'));
$lastYear = date('Y',strtotime($lastdate[0]));
$lastmonth = date('m',strtotime($lastdate[0]));

$_GET['div_year'] = (isset($_GET['div_month']) && $_GET['div_month'] != "") ? date('Y') : "";
											

?>
<!doctype html>
<html lang="en">

<head>
	<title>分红明细</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
    <style type="text/css">
        .search_item {
            margin-top: 10px;
        }
        .search_item input {
            padding: 5px;
        }
		.search_item select {
            padding: 5px;
			width:10px; 
			float:left;
        }
        .vippointbt {
            display: block;
            background-color: #607D8B;
            text-align: center;
            width: 80px;
            font-size: 12px;
            height: 26px;
            line-height: 26px;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 5px;
        }
        #vpointopen {
            position: fixed;
            top: 164px;
            left: 0;
            right: 0px;
            margin: 0 auto;
            width: 600px;
            background-color: #607D8B;
            padding: 12px;
            color: #fff;
            display: none;
            border-radius: 8px;
        }
        #vpointopen div {
           font-size: 20px;
            height: 36px;
            line-height: 36px; 
        }
        #vpointopen div span {
            float: right;
            background-color: #455258;
            font-size: 16px;
            padding-left: 12px;
            padding-right: 12px;
            border-radius: 8px;
            cursor: pointer;
        }
        #vpointopen .vuserphone {
            font-size: 24px;
        }
        #vpointopen p {
            height: 50px;
            line-height: 50px;
        }
        #vpointopen input[type=number] {
            height: 36px;
            width: 150px;
            border: 0px;
            border-radius: 5px;
            padding-left: 5px;
            padding-right: 5px;
            color: #515151;
            margin-right: 10px;
        }
        #vpointopen input[type=button] {
            background-color: #f3f3f3;
            border: 0px;
            height: 36px;
            line-height: 36px;
            border-radius: 5px;
            padding-left: 10px;
            padding-right: 10px;
            color: #5d6f77;
            width: 80px;
        }
        #vpointlog {
            position: fixed;
            top: 164px;
            left: 0px;
            right: 0px;
            margin: 0 auto;
            width: 600px;
            background-color: #607D8B;
            padding: 12px;
            color: #fff;
            border-radius: 3px;
            display: none;
        }
        #vpointlog .title {
            font-size: 20px;
            width: 100%;
            height: 30px;
        }
        #vpointlog .title span {
            width: 50%;
        }
        #vpointlog .title i {
            float: right;
            width: 60px;
            font-style: normal;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
        }
        #vpointlog ul {
            padding: 10px;
            margin: 0px;
        }
        #vpointlog li {
            list-style: none;
            height: 36px;
            line-height: 36px;
            float: left;
            width: 100%;
        }
        #vpointlog span {
            display: block;
            width: 30%;
            float: left;
        }
    </style>
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<?php include ("head.php");?>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<?php include ("left.php");?>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<h3 class="page-title">分红明细</h3>
					<div class="row">
						<div class="col-xs-12">
							<!-- BASIC TABLE -->
							<div class="panel">
								<div class="panel-heading">	
                                	<h3 class="panel-title" id="fh"><a href="javascript:dividends()" target="_self">开始分红</a></h3>								
                                    <div class="search_item">
                                    <form action="" method="get">
                                    	<div style="width:260px;">
                                    	<select name="div_year">
                                        	<option value="">请选择 年份</option>
											<?php
											$div_year = $_GET['div_year'];
											$div_month = $_GET['div_month'];
											for($i = 2018; $i <= date('Y'); $i++)
											{
												echo '<option value="'.$i.'"'.(($div_year == $i) ? ' selected' : '').'>'.$i.'</option>';
											}
											
										   ?>
                                        </select>
                                        <select name="div_month">
                                        	<option value="">请选择 月份</option>
											<?php
											for($i = 1; $i <= 12; $i++)
											{
												echo '<option value="'.$i.'"'.(($div_month == $i) ? ' selected' : '').'>'.$i.'</option>';
											}
											
										   ?>
                                        </select>
                                        
                                        <input type="text" name="div_phone" value="" placeholder="请输入手机号码">
                                        
                                        <input type="submit" value="搜索">
                                        </div>
                                    </form>
                                    </div>
                                    <span id="sumall" style="top:20px; font-size:20px; font-weight:bold"></span>
								</div>
                                
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>手机号</th>
												<th>名称</th>
												<th>分红总额（元）</th>
                                                <th>剩余（元）</th>
												<th>股份</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody>
								<?php 
										$div_serch = "";
										$div_s = "";
										if(isset($_GET['div_phone']))
										{
											$div_phone = $_GET['div_phone'];
										}
										else
										{
											$div_phone = "";
										}
										
                                        if (isset($_GET['page'])) {
                                            $page = $_GET['page'];
                                        } else {
                                            $page=1;
                                        }
                                        if (isset($div_phone) && $div_phone != "") {
                                            $div_serch .= " and b.t_phone = '{$div_phone}'";
											$div_s .= " and t_phone = '{$div_phone}'";
                                        }
										
										if (isset($div_year) && $div_year != "") {
											$div_serch .= " and SUBSTRING(b.t_description, 1, 4 ) = '{$div_year}'";
											$div_s .= " and SUBSTRING(t_description, 1, 4 ) = '{$div_year}'";
                                        }
										
										if (isset($div_month) && $div_month != "") {
											if($div_year == "") 
											{
												$div_year = date('Y');
												$div_serch .= " and SUBSTRING(b.t_description, 1, 4 ) = '{$div_year}'";
												$div_s .= " and SUBSTRING(t_description, 1, 4 ) = '{$div_year}'";
											}
											$div_serch .= " and SUBSTRING(b.t_description, 6, ".strlen($div_month)." ) = '{$div_month}'";
											$div_s .= " and SUBSTRING(t_description, 6, ".strlen($div_month)." ) = '{$div_month}'";
                                        }
                                        
										$perNumber=20;
										
										$sum_q = "SELECT sum(t_money) FROM balance_details WHERE t_cate = ''{$div_s}";
										$sum = mysqli_query($mysqli, $sum_q);
										$rs_sum=mysqli_fetch_array($sum,MYSQLI_NUM);
										$sumall=$rs_sum[0];
										
										$sum_N = "SELECT count(t_id) FROM balance_details WHERE t_cate = '' and t_time >= '".date('Y-m-10 00:00:00')."'";
										$sum1 = mysqli_query($mysqli, $sum_N);
										$rs_sum1=mysqli_fetch_array($sum1,MYSQLI_NUM);
										$sumN=$rs_sum1[0];
										
										$count_q = "select count(*) from(SELECT count(*) FROM balance_details WHERE t_cate = ''{$div_s} GROUP BY t_phone ) a";
										$count = mysqli_query($mysqli, $count_q);
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT sum(b.t_money) as t_money,b.t_phone as t_phone,m.mb_nick as mb_nick,m.mb_partner_not_gold as mb_partner_not_gold,m.mb_share as mb_share from balance_details as b left join fyq_member as m on (b.t_phone = m.mb_phone) where b.t_cate = ''{$div_serch} group by b.t_phone order by t_money desc limit {$startCount},{$perNumber}";
										
										$i = $startCount + 1;
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr>
                                                <td>
													<?php echo $i++;?>
												</td>
												<td>
													<?php echo $row['t_phone'];?>
												</td>
												<td>
                                                    <?php echo $row['mb_nick'];?>
												</td>
												<td>
													<?php echo $row['t_money'];?>
												</td>
                                                <td>
													<?php echo $row['mb_partner_not_gold'];?>
												</td>
                                                <td>
													<?php echo $row['mb_share'];?>
												</td>
                                                <td>
                                                    <span class="vippointbt" onClick="vpoint_more('<?php echo $row['t_phone'];?>','<?php echo $row['t_phone'];?>')">分红明细</span>
												</td>
											</tr>
											<?php 
											}
										}
										?>
										</tbody>
									</table>
									<div id="phq_content_page">
										<?php
										echo "共 " . $totalNumber . " 条&nbsp;&nbsp;&nbsp;&nbsp;"; 
										$page_count = 5;
										$imin = ( ceil( $page / $page_count ) - 1 ) * $page_count + 1;
										$imax = ( $max_page - $imin < $page_count ) ? $max_page : ( $imin + ( $page_count - 1 ) );
										if ( $imin > $page_count ) {
											?>
										<a href="?page=1<?php echo '&div_phone='.$div_phone.'&div_year='.$div_year.'&div_month='.$div_month;?>">&lt;&lt;</a> <a href="?page=<?php echo ($imin - 1);?><?php echo '&div_phone='.$div_phone.'&div_year='.$div_year.'&div_month='.$div_month;?>">&lt;</a>
										<?
	}
	?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?><?php echo '&div_phone='.$div_phone.'&div_year='.$div_year.'&div_month='.$div_month;?>"><?php echo $i;?></a>
											<?php
											}
											?>
											<?php
											if ( $imax < $max_page ) {
												?>
											<a href="?page=<?php echo ($imax + 1);?><?php echo '&div_phone='.$div_phone.'&div_year='.$div_year.'&div_month='.$div_month;?>">&gt;</a> <a href="?page=<?php echo $max_page;?><?php echo '&div_phone='.$div_phone.'&div_year='.$div_year.'&div_month='.$div_month;?>">&gt;&gt;</a>
											<?
	}
	?>
									</div>
								</div>
							</div>
							<!-- END BASIC TABLE -->
						</div>

					</div>


				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
<div id="vpointlog">
    <div class="title"><span></span><i>关闭</i></div>
    <div id="fhbtn" style="display:none;"></div>
    <ul>
    </ul>           
</div>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="assets/vendor/jquery/jquery.min.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script>
    <script type="text/javascript">
	$("#sumall").text("分红总额：<?php echo $sumall?> 元");
	
	function dividends()
	{
		var n = <?php echo $sumN?>;
		var d = <?php echo date('j')?>;
		if(n <= 0)
		{
			if(d < 10)
			{
				alert('每月10日分红。');
			}
			else
			{
				if(confirm('确定要开始分红吗?'))
				{
					document.getElementById('fh').style.display = 'none';
					//location='dividends.php';
					$.post("dividends.php",
					{
						//vid:id
					},
					function(data,status){
						$("#vpointlog").css("display","block");
						$("#fhbtn").text("fh");
						$("#vpointlog .title span").text("<?php echo $lastYear?>年<?php echo $lastmonth?>月 分红");
						$("#vpointlog ul").html(data);
					}); 
				}
			}
		}
		else
		{
			alert('已经完成<?php echo $lastYear?>年<?php echo $lastmonth?>月的分红.');
		}
	}
	
    function vpoint(id,uphone) {
        $("#vpointopen [name=user_id]").val(id);
        $("#vpointopen .vuserphone").text(uphone);
        $("#vpointopen").css("display","block");
    }
    function vpoint_more(id,uphone){
        $.post("post/div_more.php",
        {
            vid:id
        },
        function(data,status){
            $("#vpointlog").css("display","block");
            $("#vpointlog .title span").text(uphone+" 的 分红明细");
            if (data == '0') {
                $("#vpointlog ul").html("未找到分红明细");
            } else {
                $("#vpointlog ul").html(data);
            }
        }); 
    }
    $("#vpointopen div span").click(function(){
        $("#vpointopen").css("display","none");
    })
    $("#vpointlog .title i").click(function(){
        $("#vpointlog").css("display","none");
		if(document.getElementById('fhbtn').innerHTML != "")
		{
			location.reload();
		}
    })
    $("#vpointopen [name=vbutton]").click(function(){
        var vuser = $("#vpointopen [name=user_id]").val();
        var vpoint = $("#vpointopen [name=vpoint]").val();
        $.post("post/vipcardup.php",
        {
            vuser:vuser,
            vpoint:vpoint
        },
        function(data,status){
            if (data == '2') {
                alert('当前会员积分不够使用!');
                return false;
            } else if (data == '1') {
                alert('积分正常使用!');
                window.location.reload();
                return false;
            } else {
                alert('您的操作有误!');
            }
        });
    })
    </script>
</body>

</html>