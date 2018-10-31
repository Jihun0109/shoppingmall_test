<?php
include( "../db_config.php" );
include("admin_login.php");
if (!strstr($admin_purview,"AgentInfo_list")) {
	echo "您没有权限访问此页";
	exit;
}
?>
<!doctype html>
<html lang="en">

<head>
	<title>代理金比例</title>
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

	<!-- apollo append begin -->
	<link rel="stylesheet" type="text/css" href="assets/vendor/easyui/easyui.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/easyui/icon.css">
    <link rel="stylesheet" type="text/css" href="assets/vendor/easyui/demo.css">
    <!-- <script type="text/javascript" src="assets/vendor/easyui/jquery.min.js"></script> -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="assets/vendor/easyui/jquery.easyui.min.js"></script>

	<!-- <script src="assets/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/scripts/klorofil-common.js"></script> -->
    <!-- apollo append end -->
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
					<h3 class="page-title">代理金比例</h3>

					<div class="row">
						<div style="margin:5px 0;text-align: right;">
							<a href="javascript:void(0)" style="margin-right: 35px;" class="hide" onclick="init()">全部建立</a>
					        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="edit()">编辑</a>
					        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="save()">保存</a>
					        <a href="javascript:void(0)" class="easyui-linkbutton" onclick="cancel()">取消</a>
					    </div>
						<table id="tg" title="代理金比例" class="easyui-treegrid" style="width:100%;height:1200px;"
					            data-options="
					                url: 'AgentInfo_get.php',
					                animate: true,
					                fitColumns: true,
					                idField: 'id',
					                treeField: 'name',
					                showFooter: false
					            ">
					        <thead>
					            <tr>
					                <th data-options="field:'name'" width="50%">省/市/区</th>
					                <th data-options="field:'rate',editor:'text'" width="25%" align="left">代理</th>
					                <th data-options="field:'cnt',editor:'text'" width="25%">人数</th>
					            </tr>
					        </thead>
					    </table>

					</div>
					<!-- 
					<div class="row">
						<div class="col-xs-12">
							
							<div class="panel">
                            	<div class="panel-heading">
									<h3 class="panel-title"><a href="AgentInfo_in.php" target="_self">添加代理金比例</a></h3>
								</div>
								<div class="panel-body">
									<table class="table">
										<thead>
											<tr>
												<th>#</th>
												<th>地区</th>
												<th>省代理/人数</th>
												<th>市代理/人数</th>
												<th>区代理/人数</th>
												<th>操作</th>
											</tr>
										</thead>
										<tbody>
											<?php 
										$page = @$_GET['page']; 
										if (!@$_GET['page']) {
										 $page=1;
										}
										$perNumber=20;
										$count = mysqli_query($mysqli, "SELECT count(*) FROM agentinfo");
										$rs=mysqli_fetch_array($count,MYSQLI_NUM);
										$totalNumber=$rs[0];
										$max_page=ceil($totalNumber/$perNumber);
										$startCount=($page-1)*$perNumber;
										$query = "SELECT * FROM agentinfo ORDER BY ai_id desc limit {$startCount},{$perNumber}";
										if ($result = mysqli_query($mysqli, $query))
										{
											while( $row = mysqli_fetch_assoc($result) ){
										?>
											<tr id="agent_<?php echo $row['ai_id'];?>">
                                            	<td>
													<?php echo $row['ai_id'];?>
												</td>
												<td>
													<?php echo $row['ai_province'];?>
												</td>
												<td>
													<?php echo $row['ai1'];?>/<?php echo $row['ai1_cnt'];?>
												</td>
												<td>
													<?php echo $row['ai2'];?>/<?php echo $row['ai2_cnt'];?>
												</td>
												<td>
													<?php echo $row['ai3'];?>/<?php echo $row['ai3_cnt'];?>
												</td>
												<td class="admin_button">
													<a href="AgentInfo_up.php?id=<?php echo $row['ai_id'];?>" target="_self">修改</a>
													<a href="#" onClick="agent_del('<?php echo $row['ai_id'];?>')" target="_self">删除</a>
													
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
										$page_count = 5;
										$imin = ( ceil( $page / $page_count ) - 1 ) * $page_count + 1;
										$imax = ( $max_page - $imin < $page_count ) ? $max_page : ( $imin + ( $page_count - 1 ) );
										if ( $imin > $page_count ) {
											?>
										<a href="?page=1";?>">&lt;&lt;</a> <a href="?page=".($imin - 1);?>">&lt;</a>
										<?
	}
	?>
										<?php
										for ( $i = $imin; $i <= $imax; $i++ ) {
											?>
										<a<?php echo $i !=$page? '': ' class="over"'?> href="?page=<?php echo $i;?>"><?php echo $i;?></a>
											<?php
											}
											?>
											<?php
											if ( $imax < $max_page ) {
												?>
											<a href="?page=".($imax + 1);?>">&gt;</a> <a href="?page=".$max_page;?>">&gt;&gt;</a>
											<?
	}
	?>
									</div>
								</div>
							</div>
							
						</div>

					</div> -->


				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>

	</div>
	
	<!-- END WRAPPER -->
	<!-- Javascript -->
	
	<script type="text/javascript">
	function agent_del(mid) {
		if(confirm("确定要删除数据吗?")){
			$.post("post/agentinfo_del.php",
			  {
				ai_id:mid
			  },
			  function(data,status){
				$("#agent_"+mid).remove();
			  });
		 }
	}
	</script>
	<script type="text/javascript">
		var editingId;
		var t = $('#tg');
		$('#tg').treegrid({
			onDblClickRow: function(row){
				if (editingId != undefined)
					save();
				cancel();
				edit();
			},
			onExpand: function(row){
				if (row['level'] == 1){
					var nodes = t.treegrid('getRoots');
					for (var i=0; i<nodes.length; i++){
						if (nodes[i]['id'] != row['id'])
							t.treegrid('collapse', nodes[i]['id']);
					}
				}
			},
			onBeforeEdit: function(row){
				if (row['level'] == 3){
					var param = t.treegrid('options', row['id']);
				}
			}
		})
    	
    	$('#tg').keypress(function(e){
    		alert(e);
    	});

    	function edit(){    		
            if (editingId != undefined){
                //$('#tg').treegrid('select', editingId);
                $('#tg').treegrid('select', editingId);
                return;
            }
            var row = $('#tg').treegrid('getSelected');
            if (row){
                editingId = row.id
                $('#tg').treegrid('beginEdit', editingId);
            }            
        }
        function save(){
            if (editingId != undefined){
                
                t.treegrid('endEdit', editingId);
                selected = t.treegrid('find', editingId);
                //alert(selected['level']);
                var temp_id = editingId;
                editingId = undefined;
                var persons = 0;
                var rows = t.treegrid('getChildren');
                for(var i=0; i<rows.length; i++){
                    var p = parseInt(rows[i].persons);
                    if (!isNaN(p)){
                        persons += p;
                    }
                }

				//var dataString = JSON.stringify(dataPost);

				$.ajax({
				   url: 'AgentInfo_update.php',
				   data: {ai: selected},
				   type: 'POST',
				   success: function(response) {
				      t.treegrid('reload', temp_id);
				      t.treegrid('expand', temp_id);
				      t.treegrid('unselectAll');
				   }
				});

                // var frow = t.treegrid('getFooterRows')[0];
                // frow.persons = persons;
                // t.treegrid('reloadFooter');
            }
        }
        function cancel(){
            if (editingId != undefined){
                $('#tg').treegrid('cancelEdit', editingId);
                editingId = undefined;
            }
        }

        function init(){
        	$('#tg').treegrid('expandAll');
        }
    </script>
</body>
</html>