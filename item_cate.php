<?php
include("include/data_base.php");
$head_title = "分类";
$top_title = "分类";
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


<div id="divItemList" style="width: 100%; margin-top: 65px; margin-left: 25px;">
            
         <?php

            $query = "SELECT * FROM item_cate where ic_type = 'teacher'";
            
            if ($result = mysqli_query($mysqli, $query))
            {
                while( $row = mysqli_fetch_assoc($result) ){        
         ?>

            <div style="width: 33%; padding: 5px; float: left; ">
                <div style="width: 100%;position: relative;">
                    
                    <li value="<?php echo $row_cate['ic_cid'];?>" id="sort_menu_<?php echo $row_cate['ic_cid'];?>"><a><?php echo $row_cate['ic_name'];?></a></li>
                   
                </div>
                <div style="color: #313131"><?php echo $row['ic_name'];?></div>
            </div>
        <?php 
                }
            }
        ?>

        

</div>
<div class="clearfix"></div>


<?php
include( "include/foot_.php" );
?>