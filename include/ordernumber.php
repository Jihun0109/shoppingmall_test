<?php 
function ordernumber(){
	$time = date("YmdHis",time());
	$str = uniqid($time);
	$str = str_replace('q', '10', $str);
	$str = str_replace('w', '11', $str);
	$str = str_replace('e', '12', $str);
	$str = str_replace('r', '13', $str);
	$str = str_replace('t', '14', $str);
	$str = str_replace('y', '15', $str);
	$str = str_replace('u', '16', $str);
	$str = str_replace('i', '17', $str);
	$str = str_replace('o', '18', $str);
	$str = str_replace('p', '19', $str);
	$str = str_replace('a', '20', $str);
	$str = str_replace('s', '21', $str);
	$str = str_replace('d', '22', $str);
	$str = str_replace('f', '23', $str);
	$str = str_replace('g', '24', $str);
	$str = str_replace('h', '25', $str);
	$str = str_replace('j', '26', $str);
	$str = str_replace('k', '27', $str);
	$str = str_replace('l', '28', $str);
	$str = str_replace('z', '29', $str);
	$str = str_replace('x', '30', $str);
	$str = str_replace('c', '31', $str);
	$str = str_replace('v', '32', $str);
	$str = str_replace('b', '33', $str);
	$str = str_replace('n', '34', $str);
	$str = str_replace('m', '35', $str);
	return trim($str);
}
?>