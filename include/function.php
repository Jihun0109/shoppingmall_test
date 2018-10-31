<?php
function get_user_type( $member , $mysqli ){
	$query = "SELECT me_state FROM merchant_entry WHERE me_user ='{$member}'";

	if ($result = mysqli_query( $mysqli, $query )) {
		$row = mysqli_fetch_assoc( $result );
		if ($row['me_state'] == '1') {
			return true;
		} else {
			return false;
		}
	} else {
		return "sql_error";
	}
}

function format_date($time) {
    if($time <= 0) return '刚刚';

    $nowtime = time();
    if ($nowtime <= $time) {
        return "刚刚";
    }

    $t = $nowtime - $time;
    $f = array(
        '31536000' => '年',
        '2592000' => '个月',
        '604800' => '星期',
        '86400' => '天',
        '3600' => '小时',
        '60' => '分钟',
        '1' => '秒'
    );
    foreach ($f as $k => $v) {
        $c = floor($t/$k);
        if ($c > 0) {
            return $c . $v . '前';
        }
    }
}
?>