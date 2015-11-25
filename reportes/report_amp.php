<html>
   <head>
      <title>Panel de Mando Integral</title>
      <script language="JavaScript" src="Charts/FusionCharts.js"></script>
      <style type="text/css">
<!--
.Estilo1 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 24px;
}
-->
      </style>
</head>
   <body bgcolor="#ffffff">
   <a href="#" onClick="imprimir();">Imprimir Reporte</a>
   <br>
   <div align="center" class="Estilo1">
     <p>Reporte Panel de Monitoreo Integral      <br>
	 <?php //echo $tit;?></p>
   </div>
   <br><br>
<?php
include("Includes/FusionCharts.php");
include("../conexion.php");
include("func_datos.php");

if(isset($_REQUEST['rep'])) $rep=$_REQUEST['rep']; else $rep="";
if(isset($_REQUEST['fecha1'])) $fecha1=$_REQUEST['fecha1']; else $fecha1="";
if(isset($_REQUEST['fecha2'])) $fecha2=$_REQUEST['fecha2']; else $fecha2="";

$show_values=1;
$show_lab=1;
$tam1=840;
$tam2=420;
include("reportes/".$rep.".php");
?>
      <br>
   </body>
</html>
<hr size="3">
<div align="center"><font face="arial, verdana" size="1">GesTor F1 - Panel de Mando Integral Version 1.1<br>
COPYRIGHT © 2006 YANAPTI S.R.L. </font></div>
<script language="JavaScript" type="text/javascript">
function imprimir(){
    window.print();
}
</script>
