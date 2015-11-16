<?php
include "charts.php";
include "../conexion.php";
if(isset($fec1) && isset($fec2)) $sql_alt=" AND a.fecha BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";
$sql="SELECT count(*) AS num, c.dominio FROM ordenes AS a, objetivos AS b, dominio AS c WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND b.objetivo LIKE '%Incidente%'".$sql_alt." GROUP BY a.dominio";
$res=mysql_db_query($db,$sql,$link);

$chart [ 'chart_data' ][ 0 ][ 0 ] = "";
$chart [ 'chart_data' ][ 0 ][ 1 ] = "Incidentes";
$flag=1;

while($row=mysql_fetch_array($res)){
	$chart [ 'chart_data' ][ $flag ][ 0 ] = $row['dominio'];
	$chart [ 'chart_data' ][ $flag ][ 1 ] = $row['num'];
	$flag++;
}

//send the new data to charts.swf
SendChartData ( $chart );

?>