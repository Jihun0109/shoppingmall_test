<?php
header("Content-Type: text/html;charset=utf-8");
include ("../../include/data_base.php");
function fenci($str,$charset){//分词函数，第二个参数为你的字符编码
    require 'ChineseToPinyin.class.php';
    //多个关键词转数组
    $str_keyword = (explode(",",$str));
    $keyword_length = count($str_keyword);
    
    //关键词分散数组
    $arr_key1 = array();
    for ($arcs=0;$arcs<$keyword_length;$arcs++) {
        $len_key1 = mb_strlen($str_keyword[$arcs],$charset);
        for($i = 0; $i < $len_key1; $i++){
            for($h = 1; $h < $len_key1; $h++){
                $arr_key1[] = mb_substr($str_keyword[$arcs],$i,$h,$charset);
            }
        }
        $arr_key1[] = $str_keyword[$arcs];
    }
    //关键词分散数组后转拼音
    $pinyin = array();
    for ($i=0;$i<count($arr_key1);$i++) {
        ChineseToPinyin::convert($arr_key1[$i],'',$allWord,$firstWord);
        $allWord = array_unique($allWord);
        for ($p=0;$p<count($allWord);$p++) {
            $pinyin[] = $allWord[$p];
        }
    }
    $keyword_arr = array_merge($arr_key1,$pinyin);//数组合并
    $keyword_arr = array_unique($keyword_arr);//重复值删除
    $keyword_arr = array_values($keyword_arr);//重新建立索引下标
    return $keyword_arr;//返回结果
}
if (isset($_POST['keyword']) && isset($_POST['item_id'])) {
    $str_keyword = $_POST['keyword'];
    $str_item = $_POST['item_id'];
    $str_keyword = str_replace('，', ',', $str_keyword);
    $query = "SELECT tc_province1,tc_city1,tl_district1 FROM teacher_list where tl_id = '{$str_item}'";
    if ($result = mysqli_query($mysqli, $query))
    {
        $row = mysqli_fetch_assoc($result);
        $tc_province1 = $row['tc_province1'];
        $tc_city1 = $row['tc_city1'];
        $tl_district1 = $row['tl_district1'];
    }
    $sql_item_key_up = mysqli_query($mysqli,"UPDATE teacher_list SET search_keyword = '{$str_keyword}' WHERE tl_id = '{$str_item}'");
    $str_keyword = preg_replace('# #', '',$str_keyword);
    $str_keyword_arr = fenci($str_keyword,'UTF-8');
    $str_keyword_num = count($str_keyword_arr);
    for ($kw=0;$kw<$str_keyword_num;$kw++) {
        $str_keyword_arr_new = $str_keyword_arr[$kw];
        $query_check = "SELECT key_code FROM search_keyword where key_code = '{$str_keyword_arr_new}' and key_item = '{$str_item}' and key_province = '{$tc_province1}' and key_city = '{$tc_city1}' and key_area = '{$tl_district1}'";
        if ($result_check = mysqli_query($mysqli, $query_check))
        {
            if (!mysqli_num_rows($result_check)) {
                mysqli_query($mysqli,"INSERT INTO search_keyword (key_code, key_item, key_province, key_city, key_area) VALUES ('{$str_keyword_arr_new}', '{$str_item}', '{$tc_province1}', '{$tc_city1}', '{$tl_district1}')"); 
            }
        }
    }
    echo 1;
} else {
    echo 0;
}
?>