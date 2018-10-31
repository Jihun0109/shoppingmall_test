<?php 
include ("../../db_config.php");
include("../admin_login.php");
if (isset($_POST['com_shopmenu'])) {
    $com_shopmenu = $_POST['com_shopmenu'];
} else {
    $com_shopmenu = '';
}

if ($com_shopmenu == "teacher") {
	if (!strstr($admin_purview,"teacher_inserts")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($com_shopmenu == "busines") {
	if (!strstr($admin_purview,"busines_inserts")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($com_shopmenu == "college") {
	if (!strstr($admin_purview,"college_inserts")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($com_shopmenu == "partner") {
	if (!strstr($admin_purview,"partner_inserts")) {
		echo "您没有权限访问此页";
		exit;
	}
}
if ($admin_level == "admin") {
    $com_admin = "admin";
} else {
    $com_admin = $admin_login;
}
if (isset($_POST["com_title"])) {
    $com_title = $_POST["com_title"]; 
} else {
    $com_title = '';
}
if (isset($_POST["com_province1"])) {
    $com_province1 = $_POST["com_province1"];
} else {
    $com_province1 = '';
}
if (isset($_POST["com_city1"])) {
    $com_city1 = $_POST["com_city1"];
} else {
    $com_city1 = '';
}
if (isset($_POST["com_district1"])) {
    $com_district1 = $_POST["com_district1"];
} else {
    $com_district1 = '';
}
if (isset($_POST["com_price"])) {
    $com_price = $_POST["com_price"];
} else {
    $com_price = '';
}
if (isset($_POST["com_phone"])) {
    $com_phone = $_POST["com_phone"]; 
} else {
    $com_phone = '';
}
if (isset($_POST["com_pushmsg"])) {
    $com_pushmsg = $_POST["com_pushmsg"];
    $com_pushmsg = str_replace("，",",",$com_pushmsg);
} else {
    $com_pushmsg = '';
}
if (isset($_POST["com_original"])) {
    $com_original = $_POST["com_original"];
} else {
    $com_original = '';
}
if (isset($_POST["com_supplyprice"])) {
    $com_supplyprice = $_POST["com_supplyprice"];
} else {
    $com_supplyprice = '';
}
if (isset($_POST["com_spare"])) {
    $com_spare = $_POST["com_spare"];
} else {
    $com_spare = '';
}
if (isset($_POST["com_point"])) {
    $com_point = $_POST["com_point"];
} else {
    $com_point = '';
}
if (isset($_POST["com_point_type"])) {
    $com_point_type = $_POST["com_point_type"];
} else {
    $com_point_type = '';
}
if (isset($_POST["com_array"])) {
    $com_array = $_POST["com_array"];
} else {
    $com_array = '';
}
if (isset($_POST["com_cate"])) {
    $com_cate = $_POST["com_cate"];
} else {
    $com_cate = '';
}
if (isset($_POST["com_vpoint"])) {
    $com_vpoint = $_POST["com_vpoint"];
} else {
    $com_vpoint = '';
}
if (isset($_POST["com_display"])) {
    $com_display = $_POST["com_display"];
} else {
    $com_display = '';
}
if (isset($_POST["com_gpsx"])) {
    $com_gpsx = $_POST["com_gpsx"]; 
} else {
    $com_gpsx = '';
}
if (isset($_POST["com_gpsy"])) {
    $com_gpsy = $_POST["com_gpsy"];
} else {
    $com_gpsy = '';
}
if (isset($_POST["com_recommend"])) {
    $com_recommend = $_POST["com_recommend"];
} else {
    $com_recommend = '';
}
if (isset($_POST["com_distribution_level"])) {
    $com_distribution_level = $_POST["com_distribution_level"];
} else {
    $com_distribution_level = '';
}
if (isset($_POST["com_class"])) {
    $com_class = $_POST["com_class"];
} else {
    $com_class = '';
}
if (isset($_POST["com_summary"])) {
    $com_summary = $_POST["com_summary"];
} else {
    $com_summary = '';
}
if (isset($_POST["com_content"])) {
    $com_content = $_POST["com_content"];
} else {
    $com_content = '';
}
if (isset($_POST["com_parentFileBox"])) {
    $com_parentFileBox = $_POST["com_parentFileBox"];
    $com_parentFileBox = substr($com_parentFileBox,0,strlen($com_parentFileBox)-1);
} else {
    $com_parentFileBox = '';
}
if (isset($_POST["com_mainimg"])) {
    $com_mainimg = $_POST["com_mainimg"];
} else {
    $com_mainimg = '';
}
if (isset($_POST['com_index'])) {
    $com_index = $_POST['com_index'];
} else {
    $com_index = '';
}
if (isset($_POST['com_shopmenu'])) {
    $com_shopmenu = $_POST['com_shopmenu']; 
} else {
    $com_shopmenu = '';
}
if (isset($_POST["vip1level1"])) {
    $vip1level1 = $_POST["vip1level1"];
} else {
    $vip1level1 = '';
}
if (isset($_POST["vip1level2"])) {
    $vip1level2 = $_POST["vip1level2"];
} else {
    $vip1level2 = '';
}
if (isset($_POST["vip1level3"])) {
    $vip1level3 = $_POST["vip1level3"]; 
} else {
    $vip1level3 = '';
}
if (isset($_POST["vip2level1"])) {
    $vip2level1 = $_POST["vip2level1"];
} else {
    $vip2level1 = '';
}
if (isset($_POST["vip2level2"])) {
    $vip2level2 = $_POST["vip2level2"]; 
} else {
    $vip2level2 = '';
}
if (isset($_POST["vip2level3"])) {
    $vip2level3 = $_POST["vip2level3"];
} else {
    $vip2level3 = '';
}
if (isset($_POST["vip1point1"])) {
    $vip1point1 = $_POST["vip1point1"];
} else {
    $vip1point1 = '';
}
if (isset($_POST["vip1point2"])) {
    $vip1point2 = $_POST["vip1point2"];
} else {
    $vip1point2 = '';
}
if (isset($_POST["vip1point3"])) {
    $vip1point3 = $_POST["vip1point3"]; 
} else {
    $vip1point3 = '';
}
if (isset($_POST["vip2point1"])) {
    $vip2point1 = $_POST["vip2point1"];
} else {
    $vip2point1 = '';
}
if (isset($_POST["vip2point2"])) {
    $vip2point2 = $_POST["vip2point2"];
} else {
    $vip2point2 = '';
}
if (isset($_POST["vip2point3"])) {
    $vip2point3 = $_POST["vip2point3"];
} else {
    $vip2point3 = '';
}
if (isset($_POST["nd_point"])) {
    $nd_point = $_POST["nd_point"];
} else {
    $nd_point = '0.00';
}

if($com_class == "0" && $com_shopmenu == "partner")
{
	$count = mysqli_query($mysqli, "SELECT (MAX(item_lever) + 1) as il FROM teacher_list where shop_menu='partner' and tl_class='0'");
	$rs=mysqli_fetch_array($count,MYSQLI_NUM);
	$item_lever=$rs[0];	
}
else
{
	$item_lever = '0';
}
//echo "INSERT INTO teacher_list (tl_name, tl_pictures, tl_price, tl_Sales, tc_province1, tc_city1, tl_district1, tl_class, tl_summary, tl_detailed, tc_mainimg, tl_cate, item_display, GPS_X, GPS_Y, tl_distribution, tl_original, tl_supplyprice, tl_phone, tl_point_commodity, tl_point_type, item_array, level_one_vip1, level_two_vip1, level_three_vip1, level_one_vip2, level_two_vip2, level_three_vip2, shop_menu, index_hot, item_admin, point_one_vip1, point_two_vip1, point_three_vip1, point_one_vip2, point_two_vip2, point_three_vip2, pushmsg_id, item_recommend, vip_point, spare_gold, nd_point, item_lever) VALUES ('{$com_title}', '{$com_parentFileBox}', '{$com_price}', '0', '{$com_province1}', '{$com_city1}', '{$com_district1}', '{$com_class}', '{$com_summary}', '{$com_content}', '{$com_mainimg}', '{$com_cate}', '{$com_display}', '{$com_gpsx}', '{$com_gpsy}', '{$com_distribution_level}', '{$com_original}', '{$com_supplyprice}', '{$com_phone}', '{$com_point}', '{$com_point_type}', '{$com_array}', '{$vip1level1}', '{$vip1level2}', '{$vip1level3}', '{$vip2level1}', '{$vip2level2}', '{$vip2level3}', '{$com_shopmenu}', '{$com_index}', '{$com_admin}', '{$vip1point1}', '{$vip1point2}', '{$vip1point3}', '{$vip2point1}', '{$vip2point2}', '{$vip2point3}', '{$com_pushmsg}', '{$com_recommend}', '{$com_vpoint}', '{$com_spare}', '{$nd_point}', '{$item_lever}')";

$sql_commodity = mysqli_query($mysqli,"INSERT INTO teacher_list (tl_name, tl_pictures, tl_price, tl_Sales, tc_province1, tc_city1, tl_district1, tl_class, tl_summary, tl_detailed, tc_mainimg, tl_cate, item_display, GPS_X, GPS_Y, tl_distribution, tl_original, tl_supplyprice, tl_phone, tl_point_commodity, tl_point_type, item_array, level_one_vip1, level_two_vip1, level_three_vip1, level_one_vip2, level_two_vip2, level_three_vip2, shop_menu, index_hot, item_admin, point_one_vip1, point_two_vip1, point_three_vip1, point_one_vip2, point_two_vip2, point_three_vip2, pushmsg_id, item_recommend, vip_point, spare_gold, nd_point, item_lever) VALUES ('{$com_title}', '{$com_parentFileBox}', '{$com_price}', '0', '{$com_province1}', '{$com_city1}', '{$com_district1}', '{$com_class}', '{$com_summary}', '{$com_content}', '{$com_mainimg}', '{$com_cate}', '{$com_display}', '{$com_gpsx}', '{$com_gpsy}', '{$com_distribution_level}', '{$com_original}', '{$com_supplyprice}', '{$com_phone}', '{$com_point}', '{$com_point_type}', '{$com_array}', '{$vip1level1}', '{$vip1level2}', '{$vip1level3}', '{$vip2level1}', '{$vip2level2}', '{$vip2level3}', '{$com_shopmenu}', '{$com_index}', '{$com_admin}', '{$vip1point1}', '{$vip1point2}', '{$vip1point3}', '{$vip2point1}', '{$vip2point2}', '{$vip2point3}', '{$com_pushmsg}', '{$com_recommend}', '{$com_vpoint}', '{$com_spare}', '{$nd_point}', '{$item_lever}')");
if ($sql_commodity) {
	if($com_class == "0")
	{
		echo 2;
	}
	else
	{
		echo 1;
	}
	$sql_college_flow = mysqli_query($mysqli,"UPDATE college_list SET cl_allcount = cl_allcount+1 WHERE cl_id = '{$com_class}'");
    
    if ($com_recommend) {
        $query_recommend = "SELECT max(tl_id) as item_id FROM teacher_list where item_recommend = '{$com_recommend}'";
        if ($result_recommend = mysqli_query($mysqli, $query_recommend))
        {
            $row_recommend = mysqli_fetch_assoc($result_recommend);
            $item_recommend = $row_recommend['item_id'];

            $query_recommend_count = "SELECT itr_id FROM item_recommend where itr_phone = '{$com_recommend}' and itr_item = '{$item_recommend}'";
            if ($result_recommend_count = mysqli_query($mysqli, $query_recommend_count))
            {
                if (!mysqli_num_rows($result_recommend_count)) {
                    $sql_item_recommend = mysqli_query($mysqli,"INSERT INTO item_recommend (itr_phone,itr_item) VALUES ('{$com_recommend}', '{$item_recommend}')");
                }
            }
        }
    }
}
?>