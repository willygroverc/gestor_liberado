<?php
$sql_dat="SELECT COUNT(a.id_orden) AS num, DATE_FORMAT(a.fecha,'%Y-%m') AS nom FROM ordenes AS a, objetivos AS b, dominio AS c WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND b.objetivo LIKE '%Incidente%'".$sql_alt."GROUP BY DATE_FORMAT(fecha,'%Y-%m')";
$prom=solo_datos($sql_dat);
?>
