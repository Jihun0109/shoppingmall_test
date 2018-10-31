<?php 
if (strstr($_SERVER['HTTP_USER_AGENT'],"fuyuanquan.net")) {
    $top_navigate_return = '<div onClick="YDB.GoBack()"><img src="/img/return_top.png" alt="返回"></div>';
} else {
    if (@$_SERVER["HTTP_REFERER"]) {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    } else {
        $top_navigate_return = '<a href="/" target="_self"><img src="/img/return_top.png" alt="返回"></a>';
    }
}
?>
<div class="top_navigate"> 
	<span>
		<?php echo $top_navigate_return;?>
	</span> 
	<span><?php echo $top_title;?></span> 
    <?php echo $top_url;?>
    <?php 
        if(isset($top_button)){
            echo $top_button;
        }
    ?>
</div>