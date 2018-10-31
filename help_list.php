<?php
include("include/config.php");
include("include/data_base.php");
$item_title = "帮助";
$head_title = $item_title;
include("include/head_.php");
$top_title = $item_title;
$return_url = "..";
include("include/top_navigate.php");
?>
<div class="college_search" style="display:block;top:48px;">
  <form action="" method="get" target="_blank">
    <input type="text" name="bus_keyword" style="top:5px;" id="item_key" value="" placeholder="请输入要搜索的关键字">
    <input type="button" value="搜索" style="top:10px;" onClick="index_item_list('yes')">
  </form>
</div>

<div class="item_main_list" style="margin-top:10%">
    
    <div class="item_main_list_hot1" style="margin-top:60px;">
      <ul id="item_list"></ul>
        <div class="item_main_list_hot_loding" style="display: none;"><div class="loader_ajax"></div></div>
    </div>
  </div>
<script type="text/javascript">
$(document).ready(function (){  
    $(window).scroll(function(){ 
		index_item_list("no");
	});
	index_item_list("no");
});
function index_item_list(return_loding){
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
            $.post("post/help_list_ajax.php",
            {
                item_count:item_main_list_count,
                item_key:document.getElementById('item_key').value
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
