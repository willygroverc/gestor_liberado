<?php
$sql_dat="SELECT count(*) AS num, CONCAT(c.dominio ,' - ', b.objetivo) AS nom FROM ordenes AS a, objetivos AS b, dominio AS c WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND b.objetivo LIKE '%Incidente%'".$sql_alt.$sql_usr." GROUP BY a.dominio";
$prom=solo_datos($sql_dat);
?>