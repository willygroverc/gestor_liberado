<?php
include "charts.php";

include ("../conexion.php"); 
//the chart's data
if(isset($fec1) && isset($fec2)) $sql_alt=" WHERE fecha BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";
$sql="SELECT count(*) AS num, fecha FROM ordenes".$sql_alt." GROUP BY fecha";
$res=mysql_db_query($db,$sql,$link);
$flag=1;
///////////////////////
$chart[ 'axis_category' ] = array ( 'size'=>14, 'color'=>"000000", 'alpha'=>0, 'font'=>"arial", 'bold'=>true, 'skip'=>0 ,'orientation'=>"horizontal" ); 
$chart[ 'axis_ticks' ] = array ( 'value_ticks'=>true, 'category_ticks'=>true, 'major_thickness'=>2, 'minor_thickness'=>1, 'minor_count'=>1, 'major_color'=>"000000", 'minor_color'=>"222222" ,'position'=>"outside" );

$chart[ 'chart_border' ] = array ( 'color'=>"000000", 'top_thickness'=>2, 'bottom_thickness'=>2, 'left_thickness'=>2, 'right_thickness'=>2 );
$chart [ 'chart_data' ][ 0 ][ 0 ] = "1";
$chart [ 'chart_data' ][ 1 ][ 0 ] = "Region A";
$max=0;
while($row=mysql_fetch_array($res)){
	$chart [ 'chart_data' ][ 0 ][ $flag ] = $row['fecha'];
	$chart [ 'chart_data' ][ 1 ][ $flag ] = $row['num'];
	if($row['num']>$max) $max=$row['num'];
	$flag++;
}

$chart[ 'axis_value' ] = array (  'min'=>0, 'max'=>$max, 'font'=>"arial", 'bold'=>true, 'size'=>10, 'color'=>"ffffff", 'alpha'=>50, 'steps'=>6, 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'show_min'=>true );

$chart[ 'chart_grid_h' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_grid_v' ] = array ( 'alpha'=>10, 'color'=>"000000", 'thickness'=>1, 'type'=>"solid" );
$chart[ 'chart_pref' ] = array ( 'line_thickness'=>2, 'point_shape'=>"none", 'fill_shape'=>false );
$chart[ 'chart_rect' ] = array ( 'x'=>40, 'y'=>25, 'width'=>250, 'height'=>150, 'positive_color'=>"000000", 'positive_alpha'=>30, 'negative_color'=>"ff0000",  'negative_alpha'=>10 );
$chart[ 'chart_type' ] = "Line";
$chart[ 'chart_value' ] = array ( 'prefix'=>"", 'suffix'=>"", 'decimals'=>0, 'separator'=>"", 'position'=>"cursor", 'hide_zero'=>true, 'as_percentage'=>false, 'font'=>"arial", 'bold'=>true, 'size'=>12, 'color'=>"ffffff", 'alpha'=>75 );

/*$chart[ 'draw' ] = array ( array ( 'type'=>"text", 'color'=>"ffffff", 'alpha'=>15, 'font'=>"arial", 'rotation'=>-90, 'bold'=>true, 'size'=>20, 'x'=>0, 'y'=>348, 'width'=>300, 'height'=>150, 'text'=>"CANTIDAD", 'h_align'=>"center", 'v_align'=>"top" ),
                           array ( 'type'=>"text", 'color'=>"000000", 'alpha'=>15, 'font'=>"arial", 'rotation'=>0, 'bold'=>true, 'size'=>20, 'x'=>0, 'y'=>0, 'width'=>320, 'height'=>300, 'text'=>"FECHA", 'h_align'=>"center", 'v_align'=>"bottom" ) );
*/
$chart[ 'legend_rect' ] = array ( 'x'=>-100, 'y'=>-100, 'width'=>10, 'height'=>10, 'margin'=>10 ); 

$chart[ 'series_color' ] = array ( "f7bb11"); 

SendChartData ( $chart );
?>