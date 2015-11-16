<?php
include ("conexion.php");
//Consultas
// alerta nro 2
$carnet = "3891178SC";
$sql_cal_super = "SELECT u FROM import WHERE d='$carnet'";
$res_cal_super = mysql_db_query($db, $sql_cal_super, $link); 
$row_cal_super = mysql_fetch_array($res_cal_super);
echo "cal_super: ".$row_cal_super[u];

$sql_cal_for = "SELECT cal_crop FROM fort500 WHERE carnet='$carnet'";
$res_cal_for = mysql_db_query($db, $sql_cal_for, $link); 
$row_cal_for = mysql_fetch_array($res_cal_for);

echo "<br>cal_for: ".$row_cal_for[cal_crop];

?>