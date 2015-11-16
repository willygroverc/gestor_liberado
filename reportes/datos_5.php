<?php
include 'charts.php';
include '../conexion.php';

if(isset($fec1) && isset($fec2)) $sql_alt=" AND a.fecha BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";

$sql_num="SELECT count(*) AS num FROM ordenes AS a, objetivos AS b, asignacion AS c, users AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.id_orden=c.id_orden AND c.asig=d.login_usr AND b.objetivo".$sql_alt." LIKE '%Incidente%'";
$res_num=mysql_db_query($db,$sql_num,$link);
$row_num=mysql_fetch_array($res_num);

$sql="SELECT count(*) AS num, CONCAT(d.nom_usr, ' ', d.apa_usr, ' ', d.ama_usr) AS nom FROM ordenes AS a, objetivos AS b, asignacion AS c, users AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.id_orden=c.id_orden AND c.asig=d.login_usr AND b.objetivo LIKE '%Incidente%'".$sql_alt." GROUP BY c.asig";
$res=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($res);

$chart [ 'chart_data' ][ 0 ][ 0 ] = "";
$chart [ 'chart_data' ][ 0 ][ 1 ] = "";
$flag=1;

while($row=mysql_fetch_array($res)){
	$chart [ 'chart_data' ][ 0 ][ $flag ] = $row['nom'];
	$chart [ 'chart_data' ][ 1 ][ $flag ] = round($row['num']/$row_num['num']*100);
	$flag++;
}

//$chart[ 'chart_data' ] = array ( array ( "", "Oficial de Seguridad", "Ivan Paniagua", "Eduardo Aneiva", "Ramiro Guzman", "Eduardo Quezada" ), array ( "", 8, 10, 29, 22, 31 ) );

$chart[ 'chart_grid_h' ] = array ( 'alpha'=>20, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_rect' ] = array ( 'positive_color'=>"ffffff", 'positive_alpha'=>20, 'negative_color'=>"ff0000", 'negative_alpha'=>10 );
$chart[ 'chart_type' ] = "pie";
$chart[ 'chart_value' ] = array ( 'color'=>"ffffff", 'alpha'=>90, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'position'=>"inside", 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'as_percentage'=>true );

$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>10, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>30, 'x'=>0, 'y'=>140, 'width'=>400, 'height'=>150, 'text'=>"|||||||||||||||||||||||||||||||||||||||||||||||", 'h_align'=>"center", 'v_align'=>"bottom" )) ;

$chart[ 'legend_label' ] = array ( 'layout'=>"horizontal", 'bullet'=>"circle", 'font'=>"arial", 'bold'=>true, 'size'=>13, 'color'=>"ffffff", 'alpha'=>85 ); 
$chart[ 'legend_rect' ] = array ( 'fill_color'=>"ffffff", 'fill_alpha'=>10, 'line_color'=>"000000", 'line_alpha'=>0, 'line_thickness'=>0 ); 

$chart[ 'series_color' ] = array ( "ddaa41", "88dd11", "4e62dd", "ff8811", "4d4d4d", "5a4b6e" ); 
$chart[ 'series_explode' ] = array ( 20, 0, 50 );

SendChartData ( $chart );

?>