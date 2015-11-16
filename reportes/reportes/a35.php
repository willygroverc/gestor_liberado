<?php
         if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  AND a.fecha_sol BETWEEN '$fecha1' AND '$fecha2'";
			}
				else
			{
				$sql_alt="";

			}
   $sql="SELECT count(*) AS num, CONCAT(c.nom_usr,' ',c.apa_usr) AS nombre FROM solucion a, ordenes b, users c WHERE a.id_orden=b.id_orden AND b.cod_usr=c.login_usr AND a.id_orden NOT IN (SELECT id_orden FROM conformidad) $sql_alt GROUP BY b.cod_usr";
   $res=mysql_db_query($db,$sql,$link);
   $data="<chart caption='Ordenes Solucionadas Sin Conformidad' lowerLimit='1' labelDisplay='ROTATE' slantLabels='1' showValue='1'  yAxisName='Ordenes'>";
   while($row=mysql_fetch_array($res)){
	   //$data.="<set label=\"".$row['asig']."\" value=\"".$row['num']." \" color='".colorbarra($row['num'])."'/>"; 
	   $data.="<set label='".$row['nombre']."' value='".$row['num']."'/>";
   }
   $data.="</chart>";

   ?>
</div>
<div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/Column3D.swf", "myChartId", "<?php=$tam1?>", "<?php=$tam2?>", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script>