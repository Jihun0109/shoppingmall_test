<?php
include("include/config.php");
include("include/data_base.php");
$item_title = "";
//$head_title = $item_title;
include("include/head_.php");
$top_title = $item_title;
$return_url = "..";

$top_title = '<form action="" method="get" target="_blank" id="sh" style="float:right;width:84%; margin-right:10px;">
    <input type="search" name="bus_keyword" id="item_key" value="" style="background-color:#FFFFFF; color:#000000; text-align:left;" placeholder="请输入要搜索的关键字">
  </form>';
include("include/top_navigate.php");
?>
    <div class="item_main_list_hot1" style=" margin-top:56px;">
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
            $.post("post/memo_list_ajax.php",
            {
                item_count:item_main_list_count,
                item_key:document.getElementById('item_key').value,
				itme_type:<?php echo $_REQUEST['me_type']?>
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


$('#sh').on('submit', function(event){
	//拦截表单默认提交事件
     event.preventDefault();
    //获取input框的值，用ajax提交到后台
	//var content = $('#searchInput').val();
	index_item_list('yes');
});
</script>
<?php 
include("include/foot_.php");
?>
