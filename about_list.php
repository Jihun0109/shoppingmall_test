<?php
include("include/config.php");
include("include/data_base.php");
$item_title = "附近";
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

<div class="item_main_list" style="margin-top:0%">
    
    <div class="item_main_list_hot1" style="margin-top:48px;">
      <ul id="item_list"></ul>
        <div class="item_main_list_hot_loding" style="display: none;"><div class="loader_ajax"></div></div>
    </div>
  </div>
<script type="text/javascript">
$(document).ready(function (){  
    $(window).scroll(function(){ 
        index_item_list("about","no");
    });
    index_item_list("about","no");
});
function index_item_list(item_cate,return_loding){
    windowScrollHight = $(window).height();
    documentScrollHight = $(document).height();
    documentscrollTop = $(document).scrollTop();
    if ((windowScrollHight+documentscrollTop) >= (documentScrollHight-200) || return_loding == "yes") {
        looding = $(".item_main_list_hot_loding").css("display");
        if (looding == "none") {
            var item_main_list_count = $("#item_list ul").length;
            $(".item_main_list_hot_loding").css("display","block");
            if (return_loding == "yes") {
                item_main_list_count = 0;
                $("#item_list").html("");               
            }
            $.post("post/index_item_followcount_about.php",
            {
                item_count:item_main_list_count,
                item_order_by:item_cate
            },
            function(data,status){
                if (data == "0") {
                    $(".item_main_list_hot_loding").text("全部加载完毕");
                } else {
                    if (return_loding == "yes") {
                        $("#item_list").html(data);
                    } else {
                        $("#item_list").append(data);
                    }
                    $(".item_main_list_hot_loding").css("display","none");
                }
            });
        }
    }
}
//index_item_list("about","no");
</script>
<?php 
include("include/foot_.php");
?>
