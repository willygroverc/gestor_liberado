<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: x-small;
}
-->
</style>
<div align="center">
<div align="center"><span class="style1">Tiempo de Solucion Por Tecnico</span>
  <?php
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}
	if(isset($fecha1) && isset($fecha2)) $sql_alt=" AND a.fecha_conf BETWEEN '$fecha1' AND '$fecha2'";
	else $sql_alt="";
   $sql="SELECT b.asig, ROUND( AVG( a.tiemposol_conf ) , 2 ) AS num FROM conformidad a, asignacion b WHERE a.id_orden=b.id_orden $sql_alt GROUP BY b.asig";
   $res=mysql_db_query($db,$sql,$link);
   $data="<chart caption='Tiempo de Solucion Por Tecnico' lowerLimit='1' labelDisplay='ROTATE' slantLabels='1' showValue='1' yAxisMaxValue='3' yAxisMinValue='1' yAxisName='Nivel de Conformidad'>";
   while($row=mysql_fetch_array($res)){
	   //$data.="<set label=\"".$row['asig']."\" value=\"".$row['num']." \" color='".colorbarra($row['num'])."'/>"; 
	   $data.="<set label='".$row['asig']."' value='".$row['num']."' color='".colorbarra($row['num'])."'/>";
   }
   $data.="</chart>";
   
   function colorbarra($valor){
			if($valor<1.67) return("FF654F");
			else{
				if($valor<2.33) return("F6BD0F");
				else return("8BBA00");
				}
   	}
   ?>
</div>
<div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/Column2D.swf", "myChartId", "<?php=$tam1?>", "<?php=$tam2?>", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script>