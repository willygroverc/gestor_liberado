<?php
include "charts.php";
include "../conexion.php";
//the chart's data
if(isset($fec1) && isset($fec2)) $sql_alt=" AND datetimereg_usr BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";

$sql_bloq="SELECT count(*) AS num FROM `users` WHERE bloquear = '1'".$sql_alt;
$res_bloq=mysql_db_query($db,$sql_bloq,$link);
$row_bloq=mysql_fetch_array($res_bloq);

$sql_elim="SELECT count(*) AS num FROM `users` WHERE bloquear = '2'".$sql_alt;
$res_elim=mysql_db_query($db,$sql_elim,$link);
$row_elim=mysql_fetch_array($res_elim);

$sql_act="SELECT count(*) AS num FROM `users` WHERE bloquear = '0'".$sql_alt;
$res_act=mysql_db_query($db,$sql_act,$link);
$row_act=mysql_fetch_array($res_act);

$sql_ext="SELECT count(*) AS num FROM `users` WHERE tipo_usr = 'EXTERNO'".$sql_alt;
$res_ext=mysql_db_query($db,$sql_ext,$link);
$row_ext=mysql_fetch_array($res_ext);


$chart [ 'chart_data' ] = array ( array ( "",  "Control de Cuentas"),
                                  array ( "Activos",     $row_act['num']),
                                  array ( "Externos",   $row_ext['num']),
                                  array ( "Bloqueados",   $row_bloq['num']),
                                  array ( "Eliminados",   $row_elim['num'])
                                );
 
//send the new data to charts.swf
SendChartData ( $chart );

?>