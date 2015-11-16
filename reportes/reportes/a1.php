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
<div align="center"><span class="style1">Tiempo de Solucion</span>
  <?php
if(isset($DA) && isset($MA)){
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
	$fecha1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fecha2 = $AE."-".$ME."-".$DE; 
}
if(isset($fecha1) && isset($fecha2)) {
	$sql_alt=" AND fecha_conf BETWEEN '$fecha1' AND '$fecha2'";
	if($val_area!=0) $sql_alt.=" AND b.area=$val_area";
	}
else $sql_alt="";

   $sql="SELECT ROUND( AVG( tiemposol_conf ) , 2 ) AS num FROM conformidad a, ordenes b WHERE a.id_orden=b.id_orden".$sql_alt;
   $res=mysql_db_query($db,$sql,$link);
   $row=mysql_fetch_array($res);
   $data="<chart caption='Tiempo de Solucion' lowerLimit='1' upperLimit='3' lowerLimitDisplay='Malo' upperLimitDisplay='Excelente' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' tickValueDistance='20' showValue='1'><colorRange><color minValue='1' maxValue='1.67' code='FF654F'/><color minValue='1.67' maxValue='2.33' code='F6BD0F'/><color minValue='2.33' maxValue='3' code='8BBA00'/></colorRange><dials><dial value='".$row['num']."' rearExtension='10'/></dials></chart>";
   ?>
</div>
<div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/AngularGauge.swf", "angular", "<?php=$tam1?>", "<?php=$tam2?>", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script>