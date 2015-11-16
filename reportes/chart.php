<?php   
   //In this example, we show how to connect FusionCharts to a database.
   //For the sake of ease, we've used a MySQL database containing two
   //tables.
//function datos($sql,$titulo);
include ("../conexion.php");
include("Includes/FusionCharts.php");
   //Connect to the DB
   //$strXML will be used to store the entire XML document generated
   //Generate the chart element
   $strXML = "<chart caption='Panel de Monitoreo Integral' subCaption='$titulo' pieSliceDepth='30' showBorder='1' formatNumberScale='0' numberSuffix=' Unidades'>";
   //Fetch all factory records
   $result = mysql_db_query($db,$sql,$link);

   //Iterate through each factory
   if ($result) {
      while($ors = mysql_fetch_array($result)) {
         //Now create a second query to get details for this factory
         //Generate <set label='..' value='..'/>
         $strXML .= "<set label='" . $ors['nom'] . "' value='" . $ors['num'] . "' />";
         //free the resultset
         mysql_free_result($result2);
      }
   }
   mysql_close($link);

   //Finally, close <chart> element
   $strXML .= "</chart>";
return $strXML;
   //Create the chart - Pie 3D Chart with data from $strXML
?>