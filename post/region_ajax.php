<?php 
include("../include/data_base.php");
?>
<?php
if (isset($_POST['key_serch'])) {
    $key_serch = $_POST['key_serch'];
} else {
    $key_serch = '';
}

if ($key_serch) {
    $region_sql = " where region_name_c like '{$key_serch}%' or region_name_e like '{$key_serch}%'";
} else {
    $region_sql = " where country_code = 'CN' and level < '4' and level >1 order by region_name_e";
}
$region_name_e = 0;
$query1 = "SELECT * FROM fyq_region{$region_sql}";
	if ($result1 = mysqli_query($mysqli, $query1))
	{
		while($row1 = mysqli_fetch_assoc($result1)){
            if ($region_name_e !==substr($row1['region_name_e'], 0, 1)) {
                $region_speis = strtoupper(substr($row1['region_name_e'], 0, 1));
                echo '<span id="speis_'.$region_speis.'">'.$region_speis.'</span>';
            }
            $region_name_e = substr($row1['region_name_e'], 0, 1);
            echo "<li><div onClick=\"region('".$row1['region_name_c']."')\">".$row1['region_name_c']."</div></li>";
        } 
    }
?>