<?php
$sql_dat="SELECT COUNT(YEAR(FechPruFunc)) AS num,YEAR(FechPruFunc)  AS nom FROM datfichatec".$sql_alt." GROUP BY nom";
$prom=solo_datos($sql_dat);
?>
