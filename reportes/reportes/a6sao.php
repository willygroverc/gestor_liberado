<?php
$sql_dat="SELECT COUNT(bloquear) as num, CASE WHEN bloquear = '0' THEN 'Activos' WHEN bloquear = '1' THEN 'Bloqueados' WHEN bloquear = '2' THEN 'Eliminados' END  AS nom FROM users GROUP BY bloquear;";
$prom=solo_datos($sql_dat);
?>