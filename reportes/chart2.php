<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>
<?php   
   //In this example, we show how to connect FusionCharts to a database.
   //For the sake of ease, we've used a MySQL database containing two
   //tables.
include("Includes/FusionCharts.php");
function datos($sql,$titulo){
include ("../conexion.php");
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
      }
   }
   mysql_close($link);

   //Finally, close <chart> element
   $strXML .= "</chart>";
return $strXML;
   //Create the chart - Pie 3D Chart with data from $strXML
}
?>

<body>
<?php
   echo renderChart("Charts/Pie3D.swf", "", $str=datos("SELECT count(*) AS num, fecha AS nom FROM ordenes GROUP BY fecha","Titulo 1"), "FactorySum", 600, 300, false, false);
?>
</body>
</html>
