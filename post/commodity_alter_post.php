<?php 
include( "../db_config.php" );
if ( !$member_login ) {
	echo "<script> alert('ÇëÏÈµÇÂ½ÕÊºÅ');parent.location.href='index.php'; </script>";
	exit;
}
$com_title = $_POST["com_title"];
$com_province1 = $_POST["com_province1"];
$com_city1 = $_POST["com_city1"];
$com_district1 = $_POST["com_district1"];
$com_address = $_POST["com_address"];
$com_price = $_POST["com_price"];
$com_original = $_POST["com_original"];
$com_supplyprice = $_POST["com_supplyprice"];
$com_spare = $_POST["com_spare"];
$com_point = $_POST["com_point"];
$com_point_type = $_POST["com_point_type"];
$com_array = $_POST["com_array"];
$com_cate = $_POST["com_cate"];
$com_vpoint = $_POST["com_vpoint"];
$com_display = $_POST["com_display"];
$com_refund = $_POST["com_refund"];
$com_gpsx = $_POST["com_gpsx"];
$com_gpsy = $_POST["com_gpsy"];
$com_recommend = $_POST["com_recommend"];
$com_distribution_level = $_POST["com_distribution_level"];
$com_class = $_POST["com_class"];
$com_phone = $_POST["com_phone"];
$com_pushmsg = $_POST["com_pushmsg"];
$com_pushmsg = str_replace("£¬",",",$com_pushmsg);
$com_summary = $_POST["com_summary"];
$com_content = $_POST["com_content"];
$com_parentFileBox = $_POST["com_parentFileBox"];
$com_parentFileBox = substr($com_parentFileBox,0,strlen($com_parentFileBox)-1);
$com_mainimg = $_POST["com_mainimg"];
$com_index = $_POST['com_index'];
$vip1level1 = $_POST["vip1level1"];
$vip1level2 = $_POST["vip1level2"];
$vip1level3 = $_POST["vip1level3"];
$vip2level1 = $_POST["vip2level1"];
$vip2level2 = $_POST["vip2level2"];
$vip2level3 = $_POST["vip2level3"];
$vip1point1 = $_POST["vip1point1"];
$vip1point2 = $_POST["vip1point2"];
$vip1point3 = $_POST["vip1point3"];
$vip2point1 = $_POST["vip2point1"];
$vip2point2 = $_POST["vip2point2"];
$vip2point3 = $_POST["vip2point3"];
$nd_point = $_POST["nd_point"];
$up_id = $_POST['up_id'];

$sql_commodity_alter = mysqli_query($mysqli,"UPDATE teacher_list SET tl_name = '{$com_title}', tl_pictures = '{$com_parentFileBox}', tl_price = '{$com_price}', tc_province1 = '{$com_province1}', tc_city1 = '{$com_city1}', tl_district1 = '{$com_district1}', tl_address = '{$com_address}', tl_summary = '{$com_summary}', tl_detailed = '{$com_content}', tc_mainimg = '{$com_mainimg}', tl_cate = '{$com_cate}', item_display = '{$com_display}', GPS_X = '{$com_gpsx}', GPS_Y = '{$com_gpsy}', tl_distribution = '{$com_distribution_level}', tl_class = '{$com_class}', tl_phone = '{$com_phone}', tl_point_commodity = '{$com_point}', tl_point_type = '{$com_point_type}', item_array = '{$com_array}', level_one_vip1 = '{$vip1level1}', level_two_vip1 = '{$vip1level2}', level_three_vip1 = '{$vip1level3}', level_one_vip2 = '{$vip2level1}', level_two_vip2 = '{$vip2level2}', level_three_vip2 = '{$vip2level3}', tl_original = '{$com_original}', tl_supplyprice = '{$com_supplyprice}', index_hot = '{$com_index}', point_one_vip1 = '{$vip1point1}', point_two_vip1 = '{$vip1point2}', point_three_vip1 = '{$vip1point3}', point_one_vip2 = '{$vip2point1}', point_two_vip2 = '{$vip2point2}', point_three_vip2 = '{$vip2point3}', pushmsg_id = '{$com_pushmsg}', item_recommend = '{$com_recommend}', vip_point = '{$com_vpoint}', spare_gold = '{$com_spare}', nd_point={$nd_point}, refund_status='{$com_refund}' WHERE tl_id = '{$up_id}'");
	
if ($sql_commodity_alter) {
	echo 1;
    
    if ($com_recommend) {
        $query_recommend_count = "SELECT itr_id FROM item_recommend where itr_phone = '{$com_recommend}' and itr_item = '{$up_id}'";
            if ($result_recommend_count = mysqli_query($mysqli, $query_recommend_count))
            {
                if (!mysqli_num_rows($result_recommend_count)) {
                    $sql_item_recommend = mysqli_query($mysqli,"INSERT INTO item_recommend (itr_phone,itr_item) VALUES ('{$com_recommend}', '{$up_id}')");
                }
            }
    }
}
?>