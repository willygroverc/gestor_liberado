<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		1/JULIO/2013
// Autor:		Alvaro Rodriguez
//____________________________________________________________________________
@session_start();
if ($_SESSION['tipo']=='C')
	header('location:pagina_inicio.php');
	
require("conexion.php");
$login_usr = $_SESSION["login"];
include ("top.php");

echo '<div id="tbl_ajax"></div>';
echo "<input name=\"nueva\" type=\"submit\" id=\"nueva\" value=\"NUEVO PROYECTO\" onclick=\"location.href = 'solicproyecto1.php'\">";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input name=\"estadisticas\" type=\"submit\" id=\"estadisticas\" value=\"ESTADISTICAS\" onclick=\"location.href = 'report_solicproyectos.php'\">";
//echo '<input type="button" value="ESTADISTICAS" onclick="window.open(report_solicproyectos.php)" />';

?> 

<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
<script language="javascript" src="js/proyectos.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<?php 
	//if ($_SESSION['tipo']=='A')
	
		echo '<script>filtrar_lista();</script>';
		//echo "willy";
?>
