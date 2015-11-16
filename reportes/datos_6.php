<?php
include "charts.php";
include "../conexion.php";
//the chart's data
if(isset($fec1) && isset($fec2)) $sql_alt=" AND a.fecha BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";

$sql="SELECT count(*) AS num, CONCAT(d.nom_usr, ' ', d.apa_usr, ' ', d.ama_usr) AS nom FROM ordenes AS a, objetivos AS b, asignacion AS c, users AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.id_orden=c.id_orden AND c.asig=d.login_usr AND b.objetivo LIKE '%Incidente%'".$sql_alt." GROUP BY c.asig";

$res=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($res);
$chart [ 'chart_data' ][ 0 ][ 0 ] = "";
$chart [ 'chart_data' ][ 0 ][ 1 ] = "Incidentes por Tecnico";
$flag=1;

while($row=mysql_fetch_array($res)){
	$chart [ 'chart_data' ][ $flag ][ 0 ] = $row['nom'];
	$chart [ 'chart_data' ][ $flag ][ 1 ] = $row['num'];
	$flag++;
}
//send the new data to charts.swf
SendChartData ( $chart );

?>