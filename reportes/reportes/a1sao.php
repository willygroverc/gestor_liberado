<?php
$sql="SELECT ROUND( AVG( tiemposol_conf ) , 2 ) AS num FROM conformidad".$sql_alt;
$res=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($res);
$prom=$row['num'];
?>