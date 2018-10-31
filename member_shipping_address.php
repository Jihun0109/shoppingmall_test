<?php
	header('Content-Type: text/html; charset=utf-8');
	include( "db_config.php" );
	if ( !$member_login ) {
		echo "<script> alert('请先登录！');parent.location.href='index.php'; </script>";
		exit;
	}
	$head_title = "收货地址管理";
	include("include/head_.php");
	include("include/shipping_address.php");
	$top_title = "收货地址管理";
	$return_url = "..";
	include("include/top_navigate.php");

	$receive_address = mb_exist_shipping($member_login, $mysqli);
	$shipping_data = view_shipping( $receive_address['mb_id'], $mysqli );

?>

<style type="text/css">
	body {
	    /*margin: 0px auto;*/
	    background-color: white;
	}
	.address_update {
        background-color: #fe3030;
	    color: #fff;
	    display: block;
	    /*width: 150px;*/
	    width: 100%;
	    margin-right: 0px;
	    margin: 0 auto;
	    line-height: 42px;
	    border-radius: 10px;
	    border: 0;
	    text-align: center;
	    margin-right: 20px;	
	}
</style>

	<div class="member_center_info">
		<ul>
			<li>
				<p style="margin-top: 36%;">
				</p>
			</li>
			<li>
				<div>
					<p><img src="<?php if ($row_member['mb_ico']) {echo $row_member['mb_ico'];} else {echo " img/test/ico.png ";}?>" alt="">
					</p>
					<p>
						<?php echo $row_member['mb_nick'];?>
					</p>
				</div>
			</li>
		</ul>
	</div>
	<div class="member_shipping_address">
		<ul>
			<li></li>
		</ul>
	</div>
	<div class="member_shipping_list">
		<ul>
			<li>
				<p><button class="member_shipping_address_add" id="add_address">添加地址</button></p>
			</li>
		</ul>
		<div class="address_content">
			<?php
				if ($shipping_data) {

					for ($i=1; $row = mysqli_fetch_assoc($shipping_data) ; $i++) { 
					 	$shipping_id = $row['id'];
					 	$mb_receiving_address = $row['mb_receiving_address'];
					 	$status = $row['status'];
					 	$province1 = $row['mb_ship_province'] ? $row['mb_ship_province'] . "," : "";
					 	$city1 = $row['mb_ship_city'] ? $row['mb_ship_city'] . "," : "";
					 	$district1 = $row['mb_ship_district'] ? $row['mb_ship_district'] . "," : "";
		 	?>

 			<li>
 				<?php
 					if ($status ==1 ) {
				?>
					<span><input type="radio" name="address_status" id="address_status" onclick="set_default_status()" value="<?php echo $shipping_id;?>" checked ="true" style="height:21px;width:21px;"></span>
				<?php
 					 	
 					} else {
 				?>
 					<span><input type="radio" name="address_status" id="address_status" onclick="set_default_status()" value="<?php echo $shipping_id;?>"  style="height:21px;width:21px;"></span>
 				<?php 
 					}
 				?>
				
                <span>
                    <p><?php echo  $province1 . " " . $city1 . " " . $district1 . $mb_receiving_address ;?></p>
                </span>
                <span>
                    <img src="../img/edit.png" alt="空白" onclick="edit_address('<?php echo $shipping_id;?>')">&nbsp;&nbsp;&nbsp;
                    <img src="../img/delete.png" alt="空白" onclick="delete_address('<?php echo $shipping_id;?>')">
                </span>
            </li> 
		 	<?php
					}
				echo "</div>";				
				 	
				} else {
			?>
			<li class="blank_list">
	            <p><img src="../img/shop_blank.png" alt="空白"></p>
				<p>暂无内容</p>
	        </li> 
			<?php 	
				}
			?>
		</div>
		<style type="text/css">
			/*在线支付样式*/
			.setting_default_address {
				width: 100%;
			}
			.setting_default_address li {
				float: left;
				width: 100%;
				height: 60px;
				line-height: 60px;
				background-color: #FFFFFF;
				margin-top: 10px;
			}
			.setting_default_address li span {
				float: left;
				margin-top: 10px;
			}
			.setting_default_address li span:nth-child(1) {
				width: 20%;
				text-align: center;
			}
			.setting_default_address li span:nth-child(1) img {
				vertical-align: middle;
				width: 20px;
			}
			.setting_default_address li span:nth-child(2) {
				width: 60%;
				font-size: 1em;
			}
			.setting_default_address li span:nth-child(3) { 
				width: 20%;
				text-align: center;
			}
			.setting_default_address li span:nth-child(3) input {
				width: 32px;
				height: 32px;
				vertical-align: middle;
			}
		</style>
		<!-- The Address Add Modal -->
		<div id="address_add_modal" class="modal">
			<!-- Modal content -->
			<div class="modal-content">
				<div class="modal-header">
					<span class="close">&times;</span>
					<h2>添加收货地址</h2>
			    </div>
			    <div class="modal-body">
			    	<div data-toggle="distpicker" class="area_select">
						<div class="form-group">
							<select class="form-control" id="province1" name="province1" required></select>
						</div>
						<div class="form-group">
							<select class="form-control" id="city1" name="city1" required></select>
						</div>
						<div class="form-group">
							<select class="form-control" id="district1" name="district1" required></select>
						</div>
					</div>
					<textarea id="shipping_address" name="shipping_address" value="">
					</textarea>
			    </div>
			    <div class="modal-footer">
			      <button class="address_add" id="address_add" onclick="save_address()">添加</button>
			      <button class="address_update" id="address_update" onclick="update_address()">保存</button>
			    </div>	
			</div>
		</div>
	</div>
	<input type="hidden" name="shipping_address_id" id="shipping_address_id" value="">
	<input type="hidden" name="shipping_address_status" id="shipping_address_status" value="">
<script type="text/javascript" charset="utf-8">
	var YDB = new YDBOBJ();
	$('document').ready(function(){
		document.getElementById('shipping_address').value = "";
		$("#address_status_area").hide();
		// $("#province1").val("");
		// $("#city1").val("");
		// $("#district1").val("");
	});

	function save_address(){
		var shipping_address = $("#shipping_address").val();
		var province1 = $("#province1").val();
		var city1 = $("#city1").val();
		var district1 = $("#district1").val();
		var member_id = "<?php echo $receive_address['mb_id']?>";
		if (shipping_address && province1 && city1 && district1) {
			$.ajax({
				type: 'POST',
				url: "/include/shipping_address.php?action=Save_Address",
				data: { 
					id : member_id, 
					shipping_address: shipping_address,
					province1: province1,
					city1: city1,
					district1: district1
				},
				headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
				success: function(response) {
					if(JSON.parse(response)['status'] == "success"){
						alert('您的收货地址已成功存档。');
						window.location = location.href;
					} else {
						alert("您的收货地址已存在。");
					}
				},
				error: function (request, error) {
			        window.location = location.href;
			    },
			});
		} else {
			alert("请输入送货地址!");
		}
	}

	function edit_address( shipping_address_id ){

		$('#address_add').hide();
		$('#address_update').show();
		$("#address_status_area").show();
		$.ajax({
			type: 'POST',
			url: "/include/shipping_address.php?action=Get_Address",
			data: { 
				id : shipping_address_id, 
			},
			headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
			success: function(response) {
				modal.style.display = "block";
				var member_id = "<?php echo $receive_address['mb_id']?>";


				$("#province1").val(JSON.parse(response)['mb_ship_province']); 
				$("#province1").change();
				setTimeout(function(){
					$("#city1").val(JSON.parse(response)['mb_ship_city']); 
					$("#city1").change();
					setTimeout(function(){
						$("#district1").val(JSON.parse(response)['mb_ship_district']); 		
					},1000)
				},1000);
				
				$("#shipping_address").val(JSON.parse(response)['mb_receiving_address']); 
				$("#shipping_address_id").val(JSON.parse(response)['id']); 
				$("#shipping_address_status").val(JSON.parse(response)['status']);
			},
			error: function (request, error) {
		        
		        window.location = location.href;
		    },
		});
	}

	function update_address(){
		var shipping_address = $("#shipping_address").val();
		var shipping_address_id = $("#shipping_address_id").val();
		var shipping_address_status = $("#shipping_address_status").val();
		var province1 = $("#province1").val();
		var city1 = $("#city1").val();
		var district1 = $("#district1").val();
		var member_id = "<?php echo $receive_address['mb_id']?>";

		$.ajax({
			type: 'POST',
			url: "/include/shipping_address.php?action=Update_Address",
			data: { 
				shipping_address_id : shipping_address_id, 
				member_id : member_id ,
				shipping_address : shipping_address, 
				province1 : province1, 
				city1 : city1, 
				district1 : district1, 
				shipping_address_status : shipping_address_status 
			},
			headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
			contentType: "application/json; charset=utf-8",
			success: function(response) {
				if(JSON.parse(response)['status'] == "success"){
					// alert('您的收货地址成功更改。');
					window.location = location.href;
				} else if(JSON.parse(response)['status'] == "exist"){
					alert("您的收货地址已存在。");
				} else if(JSON.parse(response)['status'] == "false"){
					alert("地址更改失败。");
				}
			},
			error: function (request, error) {
		        
		        window.location = location.href;
		    },
		});
	}

	function delete_address( shipping_address_id ) {
		if (confirm("你想真的删除地址吗？")) {
			$.ajax({
				type: 'POST',
				url: "/include/shipping_address.php?action=Delete_Address",
				data: { 
					id : shipping_address_id, 
				},
				headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
				success: function(response) {
					alert("它被删除成功");
					window.location = location.href;
				},
				error: function (request, error) {
			        
			        window.location = location.href;
			    },
			});	
		}
	}

	function set_default_status() {
		var member_id = "<?php echo $receive_address['mb_id']?>";
		var shipping_address_id = $('input[name=address_status]:checked').val();
		$.ajax({
			type: 'POST',
			url: "/include/shipping_address.php?action=set_default_status",
			data: { 
				id : shipping_address_id,
				mb_id: member_id
			},
			headers: {"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8"},
			success: function(response) {
				if(JSON.parse(response)['status'] == true){
					alert('成功设置为默认地址');
					<?php
						if(isset($_GET['from_detail']) && $_GET['from_detail'] == 1){
							$server_port = "";
							if ($_SERVER["SERVER_PORT"] != "80"){
								$server_port = ":".$_SERVER["SERVER_PORT"];
							}
							?>
							window.location.href =  "<?php echo $_SERVER['REQUEST_SCHEME']."://".$_SERVER['SERVER_NAME'].$server_port; ?>/detailed_view.php?view=<?php echo $_GET['detail_item']; ?>&type=<?php echo $_GET['detail_type']; ?>";
							<?php
						}else{
							echo "window.location.reload(); ";
						}
					?>
				} else if(JSON.parse(response)['status'] == "false"){
					alert("地址更改失败。");
				}
			},
			error: function (request, error) {
		        
		        window.location = location.href;
		    },
		});
	}
	// Get the modal
	var modal = document.getElementById('address_add_modal');

	// Get the button that opens the modal
	var btn = document.getElementById("add_address");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
		$('#address_add').show();
		$('#address_update').hide();
	    modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	    modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	    }
	}
</script>

<?php 
	include("include/foot_.php");
?>