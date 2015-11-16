<?php
include("../conexion.php");
$sql_sai="SELECT * FROM pmi_sao WHERE id_report='$row_pmi[id_report]'";
$res_sai=mysql_db_query($db,$sql_sai,$link);
$row_sa=mysql_fetch_array($res_sai);
$data="<chart ledGap='1' clickURL='alertas_pre.php?id=".$row_pmi['id_report']."' lowerLimit='$row_sa[ind_1]' upperLimit='$row_sa[ind_5b]' lowerLimitDisplay='Malo' upperLimitDisplay='Bueno' palette='1' tickValueDistance='20' showValue='1' showTickValues='0'><colorRange><color minValue='".$row_sa['ind_1']."' maxValue='".$row_sa['ind_1b']."' code='008000'/><color  minValue='".$row_sa['ind_2']."' maxValue='".$row_sa['ind_2b']."' code='8BBA00'/><color minValue='".$row_sa['ind_3']."' maxValue='".$row_sa['ind_3b']."' code='F6BD0F'/><color minValue='".$row_sa['ind_4']."' maxValue='".$row_sa['ind_4b']."' code='FF8000'/><color minValue='".$row_sa['ind_5']."' maxValue='".$row_sa['ind_5b']."' code='FF0000'/></colorRange><value>$prom</value></chart>";
/*if($prom >= $row_sa['ind_1'] AND $prom < $row_sa['ind_1b']) $nivel=1;
if($prom >= $row_sa['ind_2'] AND $prom < $row_sa['ind_2b']) $nivel=2;
if($prom >= $row_sa['ind_3'] AND $prom < $row_sa['ind_3b']) $nivel=3;
if($prom >= $row_sa['ind_4'] AND $prom < $row_sa['ind_4b']) $nivel=4;
if($prom >= $row_sa['ind_5'] AND $prom <= $row_sa['ind_5b']) $nivel=5;*/
//$sql_nivel="INSERT INTO pmi_nivel (login_usr,id_report,nivel) VALUES ('$login_usr','$row_sa[id_report]','$nivel')";
//echo $sql_nivel;
//mysql_db_query($db,$sql_nivel,$link);
?>
   <div id="chartdiv<?php $ra=rand(); echo $ra?>" align="center">
      Grafico.
   </div>
<script type="text/javascript">
      var myChart = new FusionCharts("Charts/VLED.swf", "angular", "50", "150", "0", "0");
      myChart.setDataXML("<?php echo $data;?>");
      myChart.render("chartdiv<?php echo $ra?>");
</script>