<?php
// Version:		1.0
// Objetivo:	Modificacion funciones php obsoletas para version 5.3
//				Control de acceso directo NO autorizado
// Fecha:		20/NOV/12
// Autor:		Cesar Cuenca
//____________________________________________________________________________


@session_start();
if ($_SESSION['tipo']=='C')
	header('location:pagina_inicio.php');

require("conexion.php");
$login_usr = $_SESSION["login"];
include ("top.php");

//if ($tipo=="A" or $tipo=="T")
		
echo '<table width="80%" border="1" align="center"  bgcolor="#006699" class="toolbar">
	<tr> 
		<td align="center">
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Filtro:</strong></font>
		</td>	
		<td width="10%">	
			<select id="cmb_filtro" onchange="mostrar_asig();">
				<option value="0">Sin filtro</option>
				<option value="1">Solucionados</option>
				<option value="2">No solucionados</option>
				<option value="3">Con conformidad</option>
				<option value="4">Sin conformidad</option>
			</select>
		</td>
		<td align="center" width="10%">
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Asignado Por:</strong></font>
		</td>
		<td width="15%">';
		include('lib/cmb_asignadoPor.php');
		echo '</td>
		<td align="center" width="7%">
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Complejidad:</strong></font>
		</td>
		<td width="7%">';
		include('lib/cmb_complejidad.php');
		echo '</td>
		<td align="center" width="7%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Criticidad:</strong></font></td>
		<td width="7%">';
		include('lib/cmb_criticidad.php');
		echo '</td>
		<td width="7%"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Prioridad:</strong></td>
		<td>';
		include('lib/cmb_prioridad.php');
		echo '</td>
		</tr>
		<!--<tr>
		<td align="center" colspan="10">
			<table>
				<tr>
					<td align="center">
						<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
						<strong>Del:</strong></font>
					</td>';
					$estado='';
					if ($_SESSION['tipo']=='T')
						$estado='disabled';
			echo '	<td><input type="text" id="fecha1" name="fecha1" value="01-01-'.date('Y').'" '.$estado.'></td>
					<td align="center">
						<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
						<strong>Al:<strong></font>
					</td>
					<td>
						<input type="text" id="fecha2" name="fecha2" value="'.date('d-m-Y').'"></strong></font>
					</td>
				</tr>
			</table>
		</td>
	</tr>-->
	</table><br><br>';

echo '<div id="tbl_ajax"></div>';?>  
<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
<script language="javascript" src="js/asignacion.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script language="JavaScript">
mostrar_asig();
$(function() {
	$( "#fecha1" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});

	$( "#fecha2" ).datepicker({
	dateFormat: 'dd/mm/yy',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
function enviar(id){
		open("ver_orden.php?id_orden="+id);
}
-->
</script> 
