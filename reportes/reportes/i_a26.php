<?php

include ("../conexion.php");
if(isset($_REQUEST['prom'])) $prom=$_REQUEST['prom']; else $prom="";
$sql="SELECT * FROM pmi_sao WHERE id_report='$report'";
$res=mysql_db_query($db,$sql,$link);
$row_pmi=mysql_fetch_array($res);
$data="<chart ledGap='1' clickURL='alertas_pre.php?id=".$row_pmi['id_report']."' lowerLimit='$row_pmi[ind_1]' upperLimit='$row_pmi[ind_5b]' lowerLimitDisplay='Malo' upperLimitDisplay='Bueno' palette='1' tickValueDistance='20' showValue='1' showTickValues='0'><colorRange><color minValue='".$row_pmi['ind_1']."' maxValue='".$row_pmi['ind_1b']."' code='008000'/><color  minValue='".$row_pmi['ind_2']."' maxValue='".$row_pmi['ind_2b']."' code='8BBA00'/><color minValue='".$row_pmi['ind_3']."' maxValue='".$row_pmi['ind_3b']."' code='F6BD0F'/><color minValue='".$row_pmi['ind_4']."' maxValue='".$row_pmi['ind_4b']."' code='FF8000'/><color minValue='".$row_pmi['ind_5']."' maxValue='".$row_pmi['ind_5b']."' code='FF0000'/></colorRange><value>$prom</value></chart>";
?>
   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/VLED.swf", "angular", "<?php echo $tam3;?>", "<?php echo $tam4;?>", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script>