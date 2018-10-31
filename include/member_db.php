<?php 
function member_db($mbphone,$dbname,$dburl) {
    include($dburl);
    $query = "SELECT $dbname FROM fyq_member where mb_phone = '$mbphone'";
        if ($result = mysqli_query($mysqli, $query))
        {
            $row_member = mysqli_fetch_assoc($result);
            $dbname_arr = (explode(",",$dbname));
            $dbnamelength = count($dbname_arr);
            $reutrn_content = "";
            for($name=0;$name<$dbnamelength;$name++)
            {
                $reutrn_content .= '"'.$dbname_arr[$name].'"'.':"'.$row_member[$dbname_arr[$name]].'",';
            }
            $reutrn_content = substr($reutrn_content, 0, -1);
            $reutrn_content = "{".$reutrn_content."}";
            return $reutrn_content;
        }
}
?>