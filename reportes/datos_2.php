<?php
include "charts.php";
include ("../conexion.php"); 
if(isset($fec1) && isset($fec2)) $sql_alt=" AND fecha BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";
$sql="SELECT count(*) AS num, login_usr FROM `registro` WHERE tipo_c LIKE 'INGRESO'".$sql_alt." GROUP BY login_usr ORDER BY num DESC";
$res=mysql_db_query($db,$sql,$link); 
//the chart's data
$chart [ 'chart_data' ][ 0 ][ 0 ] = "";
$chart [ 'chart_data' ][ 0 ][ 1 ] = "Numero de Ingresos";
$flag=1;

while($row=mysql_fetch_array($res)){
	$chart [ 'chart_data' ][ $flag ][ 0 ] = $row['login_usr'];
	$chart [ 'chart_data' ][ $flag ][ 1 ] = $row['num'];
	$flag++;
}

//send the new data to charts.swf
SendChartData ( $chart );

?>