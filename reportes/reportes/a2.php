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
<div align="center"><span class="style1">Calidad de la Atencion</span>
<?php
	if(isset($fecha1) && isset($fecha2)) $sql_alt=" WHERE fecha_conf BETWEEN '$fecha1' AND '$fecha2'";
	else $sql_alt="";
   $sql="SELECT ROUND( AVG(calidaten_conf ) , 2 ) AS num FROM conformidad".$sql_alt;
   $res=mysql_db_query($db,$sql,$link);
   $row=mysql_fetch_array($res);
   $data="<chart caption='Calidad de la Atencion' lowerLimit='1' upperLimit='3' lowerLimitDisplay='Malo' upperLimitDisplay='Excelente' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' tickValueDistance='20' showValue='1'><colorRange><color minValue='1' maxValue='1.67' code='FF654F'/><color minValue='1.67' maxValue='2.33' code='F6BD0F'/><color minValue='2.33' maxValue='3' code='8BBA00'/></colorRange><dials><dial value='".$row['num']."' rearExtension='10'/></dials></chart>";
   ?>
   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/AngularGauge.swf", "angular", "<?php echo $tam1;?>", "<?php echo $tam2;?>", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script></div>