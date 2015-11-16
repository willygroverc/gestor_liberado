<?php
$sql_dat="SELECT count(*) AS num, DATE_FORMAT(fecha, '%d / %m') AS nom FROM ordenes".$sql_alt.$sql_usr." GROUP BY fecha";
$prom=solo_datos($sql_dat);
//echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>