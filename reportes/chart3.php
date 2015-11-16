<?php
//We've included ../Includes/FusionCharts.php and ../Includes/DBConn.php, which contains
//functions to help us easily embed the charts and connect to a database.
include("Includes/FusionCharts.php");
?>
<HTML>
   <HEAD>
      <TITLE>FusionCharts - Database Example</TITLE>
      <SCRIPT LANGUAGE="Javascript" SRC="Charts/FusionCharts.js"></SCRIPT>
   </HEAD>
   <BODY>
   <CENTER>
   <?php   
   //In this example, we show how to connect FusionCharts to a database.
   //For the sake of ease, we've used a MySQL database containing two
   //tables.

   //Connect to the DB
//   $link = connectToDB();

   //$strXML will be used to store the entire XML document generated
   //Generate the chart element
   function datos($strQuery,$titulo){
   include("../conexion.php");
   $strXML = "<chart caption='Panel de Monitoreo Integral' subCaption='$titulo' showBorder='1' formatNumberScale='0' numberSuffix=' Units'>";

   //Fetch all factory records
   $result = mysql_db_query($db,$strQuery,$link) or die(mysql_error());

   //Iterate through each factory
   if ($result) {
      while($ors = mysql_fetch_array($result)) {
         //Now create a second query to get details for this factory
         //Generate <set label='..' value='..'/>
         $strXML .= "<set label='" . $ors['nom'] . "' value='" . $ors['num'] . "' />";
         //free the resultset
      }
   }
   mysql_close($link);

   //Finally, close <chart> element
   $strXML .= "</chart>";
   return $strXML;
   }
//   echo $strXML;

   //Create the chart - Pie 3D Chart with data from $strXML
   
//   echo renderChart("Charts/Line.swf", "", $dat=datos("SELECT count(*) AS num, fecha AS nom FROM ordenes".$sql_alt." GROUP BY fecha","Cantidad de Ordenes x Dia"), "FactorySum", 600, 300, false, false);
   echo renderChart("Charts/Area2D.swf", "", $dat=datos("SELECT count(*) AS num, fecha AS nom FROM ordenes".$sql_alt." GROUP BY fecha","Cantidad de Ordenes x Dia"), "FactorySum", 600, 300, false, false);

?>
</BODY>
</HTML>