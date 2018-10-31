<?php 
function recommend_level($reg_phone,$recommend_phone,$data_base) {
    include "$data_base";
    $recommend_time = date('Ymd',time());
    $sql_recommend_level1 = mysqli_query($mysqli,"INSERT INTO member_recommend (mre_phone, mre_level, mre_recommend, mre_time) VALUES ('{$recommend_phone}', '1', '{$reg_phone}', '{$recommend_time}')");
        
    $query_recomend_levelfor = "SELECT mre_phone,mre_level FROM member_recommend where mre_recommend = '{$recommend_phone}' and mre_level < 3";
        if ($result_recomend_levelfor = mysqli_query($mysqli, $query_recomend_levelfor))
        {
            while( $row_recomend_levelfor = mysqli_fetch_assoc($result_recomend_levelfor) ){
                $mre_phone = $row_recomend_levelfor['mre_phone'];
                $mre_level_mb = $row_recomend_levelfor['mre_level']+1;
                mysqli_query($mysqli,"INSERT INTO member_recommend (mre_phone, mre_level, mre_recommend, mre_time) VALUES ('{$mre_phone}', '{$mre_level_mb}', '{$reg_phone}', '{$recommend_time}')");
            }
        }
}
?>