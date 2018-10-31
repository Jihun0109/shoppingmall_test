<?php
include("include/data_base.php");
$head_title = "地区";
$top_title = "地区";
include( "include/head_.php" );
include( "include/top_navigate.php" );
?>
<style type="text/css">
    .region_speis div {
        display: block;
        width: 100%;
        height: 20px;
        line-height: 20px;
        text-align: center;
        font-size: 0.8em;
        text-decoration: none;
    }
    .region_level div {
        color: #525252;
        text-decoration: none;
        font-size: 0.8em;
        display: block;
        height: 42px;
        line-height: 42px;
        border-bottom: 1px solid #dbdbdb;
        padding-left: 3%;
        background-color: #FFFFFF;
    }
    .open_region {
        font-size: 0.8em;
    }
    .open_region span {
        height: 36px;
        line-height: 36px;
        background-color: inherit;
    }
    .open_region div {
        display: block;
        float: left;
        width: 20%;
        height: 30px;
        line-height: 30px;
        text-align: center;
        margin-top: 1%;
        margin-left: 1%;
        margin-right: 1%;
    }
    .region_serch {
        margin-top: 48px;
    }
    .region_serch input {
        background-color: #ffffff;
        width: 96%;
    }
</style>
<div class="region_serch">
    <input type="text" value="" placeholder="请您输入查找的地区">
</div>
<div class="open_region" style="margin-top: 0px;">
    <span>延边朝鲜族自治州</span>
    <div onClick="region('延吉市')">延吉市</div>
    <div onClick="region('图们市')">图们市</div>
    <div onClick="region('敦化市')">敦化市</div>
    <div onClick="region('珲春市')">珲春市</div>
    <div onClick="region('龙井市')">龙井市</div>
    <div onClick="region('和龙市')">和龙市</div>
    <div onClick="region('汪清县')">汪清县</div>
    <div onClick="region('安图县')">安图县</div>
</div>
<div class="open_region" style="margin-top: 0px;">
    <span>长春市</span>
    <div onClick="region('南关区')">南关区</div>
    <div onClick="region('宽城区')">宽城区</div>
    <div onClick="region('朝阳区')">朝阳区</div>
    <div onClick="region('二道区')">二道区</div>
    <div onClick="region('绿园区')">绿园区</div>
    <div onClick="region('双阳区')">双阳区</div>
    <div onClick="region('九台区')">九台区</div>
    <div onClick="region('农安县')">农安县</div>
    <div onClick="region('榆树市')">榆树市</div>
    <div onClick="region('德惠市')">德惠市</div>
</div>
<div class="region_level"></div>
<div class="region_speis">
    <?php 
    for ($str=65;$str<=90;$str++) {
       echo "<div onClick=\"region_scroll('#speis_".chr($str)."')\">".chr($str)."</div>";
    }
    ?>
</div>
<script type="text/javascript">
function region(diqu) {
    $.cookie('user_region', diqu, {expires:365});
    window.location.href = "../";
}
function region_scroll(scid) {
    scrollTo(scid);
}
function scrollTo(ele, speed){
	if(!speed) speed = 300;
	if(!ele){
		$("html,body").animate({scrollTop:0},speed);
	}else{
		if(ele.length>0) $("html,body").animate({scrollTop:$(ele).offset().top-48},speed);
	}
	return false;
}
    

$(".region_serch input").keyup(function () {
    var region_serch = $(".region_serch input").val();
    serch_key(region_serch);
}).change(function () {
    
});
$(document).ready(function(){
    serch_key();
});
function serch_key(region_serch) {
    $.post("post/region_ajax.php",
    {
      key_serch:region_serch
    },
    function(data,status){
      $(".region_level").html(data);
    });
}
</script>
<?php
include( "include/foot_.php" );
?>