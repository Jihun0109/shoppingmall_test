<?php
include("include/data_base.php");
if (isset($_COOKIE["member"])) {
    $member_login = $_COOKIE["member"];
} else {
    $member_login = '';
}

if (!$member_login) {
    echo "<script> alert('请先登陆帐号');parent.location.href='index.php'; </script>";
    exit;
}
$head_title = "我的账单";
$top_title = "我的账单";
include("include/head_.php");
include("include/top_navigate.php");
?>
<style type="text/css">
    .details_content ul:nth-child(1) li:nth-child(1) {
        width: 20%;
    }
    .details_content ul:nth-child(1) li:nth-child(2) {
        width: 50%;
        text-align: left;
    }
    .details_content ul:nth-child(1) li span {
        width: 100%;
    }
    .details_content ul:nth-child(1) li:nth-child(3) {
        width: 30%;
    }
</style>
<div class="details_content">
    <ul>
        <li><span>分类</span>
        </li>
        <li><span>明细</span>
        </li>
        <li><span>时间</span>
        </li>
    </ul>
    <ul>
    </ul>
</div>

<div class="my_bill_more">加载更多</div>
<script type="text/javascript">
my_bill('0');
function my_bill(page) {
    $(".my_bill_more").html('<div class="loader_ajax"></div>');
    $.post( "post/bill_ajax.php", {
            page:page
        },
        function (data, status) {
            var json_data = JSON.parse(data);
            $.each(json_data, function(idx, obj) {
                if (obj.title) {
                    $(".details_content ul:eq(1)").append("<li><span>"+obj.title+"</span><span><p style=\"height: 20px; line-height: 20px;\"><font color=\"#FF9A9B\">"+obj.money+"￥</font></p><p style=\"height: 20px; line-height: 20px;\">"+obj.description+"</p></span><span>"+obj.times+"</span></li>");
                }
                if (obj.page) {
                    if (obj.page == '1') {
                        $(".my_bill_more").html("已全部加载完毕").removeAttr("onClick");
                    } else {
                        $(".my_bill_more").html("加载更多").attr("onClick","my_bill('"+obj.page+"')");
                    }
                }
            });
        } );
}
</script>
<?php
include("include/foot_.php");
?>