<?php
include ("../conexion.php");
$sql_dat="SELECT count(*) AS num, login_usr AS nom FROM `registro` WHERE tipo_c LIKE 'INGRESO' GROUP BY login_usr ORDER BY num DESC";
$prom=solo_datos($sql_dat);
?>