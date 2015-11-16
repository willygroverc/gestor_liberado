<chart lowerLimit='0' upperLimit='3' lowerLimitDisplay='Malo' upperLimitDisplay='Excelente' gaugeStartAngle='180' gaugeEndAngle='0' palette='1' tickValueDistance='20' showValue='1'>
   <colorRange>
      <color minValue='0' maxValue='1' code='FF654F'/>
      <color minValue='1' maxValue='2' code='F6BD0F'/>
      <color minValue='2' maxValue='3' code='8BBA00'/>
   </colorRange>
   <dials>
   <?php
   include("../conexion.php");
   if(isset($fec1) && isset($fec2)) $sql_alt=" WHERE fecha_conf BETWEEN '$fec1' AND '$fec2'";
else $sql_alt="";
   $sql="SELECT ROUND( AVG( calidaten_conf ) , 2 ) AS num FROM conformidad".$sql_alt;
   $res=mysql_db_query($db,$sql,$link);
   $row=mysql_fetch_array($res);
   ?>
      <dial value='<?php echo $row['num'];?>' rearExtension='10'/>
   </dials>
</chart>