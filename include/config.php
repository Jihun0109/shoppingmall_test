<?php 
if (isset($_GET['qid'])) {
    $qid = $_GET['qid'];
    setcookie("qid", $qid, time()+3600*24*7,"/");
} else {
    $qid = '';
}

//date_default_timezone_set("Asia/Hong_Kong");
ini_set('date.timezone','Asia/Shanghai');
function utf8_strcut( $str, $size, $suffix='' ) {
	$substr = substr( $str, 0, $size * 2 );
	$multi_size = preg_match_all( '/[\x80-\xff]/', $substr, $multi_chars );

	if ( $multi_size > 0 )
		$size = $size + intval( $multi_size / 3 ) - 1;

	if ( strlen( $str ) > $size ) {
		$str = substr( $str, 0, $size );
		$str = preg_replace( '/(([\x80-\xff]{3})*?)([\x80-\xff]{0,2})$/', '$1', $str );
		$str .= $suffix;
	}

	return $str;
}

function wxstrFilter($str){
    $str = str_replace('`', '', $str);
    $str = str_replace('·', '', $str);
    $str = str_replace('~', '', $str);
    $str = str_replace('!', '', $str);
    $str = str_replace('！', '', $str);
    $str = str_replace('@', '', $str);
    $str = str_replace('#', '', $str);
    $str = str_replace('$', '', $str);
    $str = str_replace('￥', '', $str);
    $str = str_replace('%', '', $str);
    $str = str_replace('^', '', $str);
    $str = str_replace('……', '', $str);
    $str = str_replace('&', '', $str);
    $str = str_replace('*', '', $str);
    $str = str_replace('(', '', $str);
    $str = str_replace(')', '', $str);
    $str = str_replace('（', '', $str);
    $str = str_replace('）', '', $str);
    $str = str_replace('-', '', $str);
    $str = str_replace('_', '', $str);
    $str = str_replace('——', '', $str);
    $str = str_replace('+', '', $str);
    $str = str_replace('=', '', $str);
    $str = str_replace('|', '', $str);
    $str = str_replace('\\', '', $str);
    $str = str_replace('[', '', $str);
    $str = str_replace(']', '', $str);
    $str = str_replace('【', '', $str);
    $str = str_replace('】', '', $str);
    $str = str_replace('{', '', $str);
    $str = str_replace('}', '', $str);
    $str = str_replace(';', '', $str);
    $str = str_replace('；', '', $str);
    $str = str_replace(':', '', $str);
    $str = str_replace('：', '', $str);
    $str = str_replace('\'', '', $str);
    $str = str_replace('"', '', $str);
    $str = str_replace('“', '', $str);
    $str = str_replace('”', '', $str);
    $str = str_replace(',', '', $str);
    $str = str_replace('，', '', $str);
    $str = str_replace('<', '', $str);
    $str = str_replace('>', '', $str);
    $str = str_replace('《', '', $str);
    $str = str_replace('》', '', $str);
    $str = str_replace('.', '', $str);
    $str = str_replace('。', '', $str);
    $str = str_replace('/', '', $str);
    $str = str_replace('、', '', $str);
    $str = str_replace('?', '', $str);
    $str = str_replace('？', '', $str);
    $str = str_replace(' ', '', $str);
    $str = str_replace("\n", "", $str);
    $str = str_replace("\r\n", "", $str);
    $str = str_replace("\r", "", $str);
    $str = str_replace(PHP_EOL, '', $str);
    return trim($str);
}
?>