<?php
include("include/config.php");
include("include/data_base.php");
$cid = @$_GET['id'];
$menu = @$_GET['menu'];
$type = @$_GET['type'];
$keyword = @$_GET['bus_keyword'];
if (!$menu) {
	exit;
}
if ($menu == "busines") {
	$item_title = "商户";
}
if ($menu == "college") {
	$item_title = "学院";
}

if ($type == "1") {
	$type_sql = " and (tl_point_type = '0' or tl_point_type = '2')";
}
if ($type == "2") {
	$type_sql = " and tl_point_type = '3'";
}
if ($type == "3") {
	$type_sql = " and tl_point_type = '1'";
}
if (!$type) {
	$type_sql = "";
}
$head_title = $item_title;
include("include/head_.php");
$top_title = $item_title;
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="college_search">
  <form action="item_list.php" method="get" target="_blank">
	<input type="hidden" name="menu" value="<?php echo $menu;?>">
    <input type="text" name="bus_keyword" value="" placeholder="请输入要搜索的关键字">
    <input type="submit" value="搜索">
  </form>
</div>
<?php 
	$college_hot_width = 156*10;
?>
<div id="college_side">
  <div id="college_hot" style="width: <?php echo $college_hot_width;?>px">
    <ul>
     <?php 
	$query = "SELECT * FROM teacher_list where shop_menu = '{$menu}' and item_display = '1' order by item_array desc limit 10";
	if ($result = mysqli_query($mysqli, $query))
	{
		while($row = mysqli_fetch_assoc($result)){
			$vid = $row['tl_class'];
			$query_view = "SELECT * FROM college_list where cl_id = '{$vid}'";
			if ($result_view = mysqli_query($mysqli, $query_view))
			{
				$row_view = mysqli_fetch_assoc($result_view);
			}
	?>
      <li>
		<p class="college_hot_small"><a class="animsition-link" href="detailed_view.php?view=<?php echo $row['tl_id'];?>&type=company" target="_self"><img src="<?php echo $row['tc_mainimg'];?>" alt=""></a></p>
        <p class="college_hot_title"><?php echo $row['tl_name'];?></p>
        <p class="college_hot_logo"><img src="<?php echo $row_view['cl_logo'];?>" alt="LOGO"></p>
      </li>
    <?php 
		}
	}
	?>
    </ul>
    <div class="college_hot_bg"></div>
  </div>
</div>
<?php 
$query_type = "SELECT * FROM item_cate where ic_type = '{$menu}' order by ic_id";
	if ($result_type = mysqli_query($mysqli, $query_type))
	{
	$cate_count=mysqli_num_rows($result_type)+1;
	$college_cate_width = 90*$cate_count;
?>
<div id="college_cate">
 <div id="college_cate_list" style="width: <?php echo $college_cate_width;?>px;">
  <ul>
	<li><div onClick="item_loding('','','<?php echo $menu;?>','','new')">전부</div></li>
	<?php 
		while($row_type = mysqli_fetch_assoc($result_type)){
	?>
	<li id="item_cate<?php echo $row_type['ic_cid'];?>"><div onClick="item_loding('<?php echo $row_type['ic_cid'];?>','','<?php echo $menu;?>','','new')"><?php echo $row_type['ic_name'];?></div></li>
	<?php 
	  }
	?>
  </ul>
 </div>
</div>
<?php 
	}
?>
<div class="college_list">
<div style="width: 100%;text-align: center; display: none; color: #9E9E9E;" id="item_loding_ajax"></div>
    <ul>
    </ul>
    <div class="my_bill_more" onClick="item_loding('<?php echo $cid;?>','<?php echo $keyword?>','<?php echo $menu;?>','<?php echo $type;?>','old')">加载更多</div>
</div>
<div class="college_foot">
  <ul>
    <li id="item_type1"><div onClick="item_loding('','','<?php echo $menu;?>','1','new')"><img src="img/item1.png">优惠</div></li>
	<li id="item_type2"><div onClick="item_loding('','','<?php echo $menu;?>','2','new')"><img src="img/item2.png">折扣</div></li>
	<li id="item_type3"><div onClick="item_loding('','','<?php echo $menu;?>','3','new')"><img src="img/item3.png">幸福豆</div></li>
  </ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$(".top_navigate").append("<span class=\"bus_search\"><img src=\"img/search.png\" alt=\"搜索\"></span>");
	$(".bus_search img").click(function(){
		$(".college_search").fadeToggle();
	});
	loaded();
	item_loding('<?php echo $cid;?>','<?php echo $keyword?>','<?php echo $menu;?>','','new');
});
var myScroll;
var myScroll_cate;
function loaded () {
	myScroll = new IScroll('#college_side', { eventPassthrough: true, scrollX: true, scrollY: false, preventDefault: false });
	myScroll_cate = new IScroll('#college_cate', { eventPassthrough: true, scrollX: true, scrollY: false, preventDefault: false });
}
//商品列表加载
function item_loding(cid,keyword,menu,type,renovate){
	var item_count = $(".college_list ul li").length;
    if (renovate == "new") {
        item_count = 0;
        $(".my_bill_more").css("display","none");
        if ($('div').is('.my_bill_more_off')) {
            $(".my_bill_more_off").css("display","none");
        }
        $(".college_list ul").html("");
        $("#item_loding_ajax").html("<div class=\"loader_ajax\"></div>").css("display","block");
    } else {
        $(".my_bill_more").html('<div class="loader_ajax"></div>');
    }
    $.post("post/item_ajax.php",
    {
      cid:cid,
	  keyword:keyword,
	  menu:menu,
	  type:type,
      item_count:item_count
    },
    function(data,status){
		if (data == "0") {
			$(".my_bill_more").text("已全部加载完毕").addClass("my_bill_more_off").removeClass("my_bill_more");
            $("#item_loding_ajax").html("未找到内容!");
		} else {
            $("#item_loding_ajax").css("display","none");
            $(".my_bill_more").css("display","block");
            if (renovate == "old") {
                $(".college_list ul").append(data);
            } else if (renovate == "new") {
                $(".college_list ul").html(data);
            }
            if ($('div').is('.my_bill_more_off')) {
                $(".my_bill_more_off").addClass("my_bill_more").removeClass("my_bill_more_off");
            }
            if (cid) {
                $("#item_cate"+cid+" div").css("color","#f86342");
                $("#college_cate li div").not("#item_cate"+cid+" div").removeAttr("style");
            } else {
                $("#college_cate li div").removeAttr("style");
            }
            $("#item_type"+type).addClass("item_on");
            $(".college_foot li").not("#item_type"+type).removeClass("item_on");
			$(".my_bill_more").text("加载更多").attr("onclick","item_loding('"+cid+"','"+keyword+"','"+menu+"','"+type+"','old')");
		}
    });
}
</script>
<?php 
include("include/foot_.php");
?>
