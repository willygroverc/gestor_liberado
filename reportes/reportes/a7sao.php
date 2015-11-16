<?php
$sql_dat="SELECT count(*) AS num, CONCAT(d.nom_usr, ' ', d.apa_usr, ' ', d.ama_usr) AS nom FROM ordenes AS a, objetivos AS b, asignacion AS c, users AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.id_orden=c.id_orden AND c.asig=d.login_usr AND b.objetivo LIKE '%Incidente%'".$sql_alt.$sql_usr." GROUP BY c.asig";
$prom=solo_datos($sql_dat);
?>