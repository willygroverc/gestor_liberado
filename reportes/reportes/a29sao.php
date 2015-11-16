<?php
$sql_ob="SELECT * FROM fichas_parametros WHERE id_param='1'";
$res_ob=mysql_db_query($db,$sql_ob,$link);
$row_ob=mysql_fetch_array($res_ob);
$sql_dato="CREATE TEMPORARY TABLE boris SELECT CASE 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_cad] AND DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_rcad] THEN '2. Caducados' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_rcad] AND DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_obs] THEN '3. Recaducados' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_obs] THEN '4. Obsoletos' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_cad] THEN '1. Vigentes' 
END AS nume FROM datfichatec;";
mysql_db_query($db,$sql_dato,$link);
$sql_dat="SELECT nume AS nom, count(nume) AS num  FROM boris GROUP BY nume;";
$prom=datos_link2($sql_dat);
?>
