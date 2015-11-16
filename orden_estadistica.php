<?php 
@session_start();
$_SESSION['modulo']='reportes';
$fecha_actual=date('d-m-Y');
$anio_actual=date('Y');
require ("conexion.php");
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script lenguaje="javascript" type="text/javascript">
<!--
function procesos(area, filtro1, id, f1, f2, tipo){
	window.open("report_ordenes_pro.php?a="+area+"&f="+filtro1+"&id="+id+"&f1="+f1+"&f2="+f2+"&t="+tipo, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
function procesos_asig(area, filtro1, id, f1, f2, tipo){
	window.open("report_ordenes_pro_asig.php?a="+area+"&f="+filtro1+"&id="+id+"&f1="+f1+"&f2="+f2+"&t="+tipo, "", 'width=900,height=500,status=no,resizable=yes,top=150,left=250,dependent=yes,alwaysRaised=yes,Scrollbars=yes');
}
-->
</script>
<script>
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
</script>
<script language="javascript" src="js/ajax.js"></script>
<script language="javascript" src="js/reportes.js"></script>
<title>GesTor F1 - Estadisticas</title></head>
<body style="font-family: 'Trebuchet MS', 'Helvetica', 'Arial',  'Verdana' , 'sans-serif';font-size: 62.5%;">
<table border="1" background="images/fondo.jpg" width="70%"  align="center" border="1">
	<tr>
		<td  bgcolor="#006699" align="center" colspan="7">
			<font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>ESTADISTICAS</b></font>
		</td>
	</tr>
	<tr>
		<td colspan="2" align="center">A continuacion seleccione los criterios solicitados.</td>
	</tr>
	<?php
	echo '<tr>
			<td>Agencia:</td>
		<td>';
		if ($_SESSION['tipo']=='A'){
			$recordset=mysql_query("SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE id_dadicional='".$_SESSION['agencia']."'");
			$fila=mysql_fetch_array($recordset);
			echo '<select name="cmb_agencia" id="cmb_agencia" disabled>';
			echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
			echo '</select>';
		}
		if ($_SESSION['tipo']=='S'){
			$recordset=mysql_query("SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='agencia' AND estado='0' ORDER BY nombre_dadicional ASC");
			echo '<option value="0">Todas</option>';
			for ($i=1;$i<=mysql_num_rows($recordset);$i++){
				$fila=mysql_fetch_array($recordset);
				echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
				echo '</select>';
			}
		}
	echo '</td></tr>';
    echo '<tr><td>Area:</td>';
	echo '<td>';
				if($_SESSION['tipo']=='A' || $_SESSION['tipo']=='S'){
					$recordset=mysql_query("SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='area' AND estado='0'");
					echo '<select id="cmb_area" name="cmb_area" onchange="act_usuarios();">
							<option value="0">Todas</option>';
					for ($i=1;$i<=mysql_num_rows($recordset);$i++){
						$fila=mysql_fetch_array($recordset);
						echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
					}
					echo '</select>';
				}
	echo '</td></tr>';
	?>
	<tr>	
		<td width="10%">Filtrar por:</td>
		<td width="20%">
			<select id="filtro1" name="filtro1" onchange="act_usuarios();">
				<option value="0">Todas las Ordenes</option>
				<option value="1">Enviadas por Tecnico</option>
				<option value="2">Enviadas por Cliente</option>
				<option value="3">Asignado a</option>
			</select>
		</td>
	</tr>
	<tr>
		<td width="10%">Nombre:</td>
		<td width="25%"><div id="ajax_cmb"></div></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<table border="1">
			<tr>
				<td>Del:</td><td><input type="text" id="fecha1" name="fecha1" value="<?php echo '01-01-'.$anio_actual;?>" size="10"></input></td>
				<td>Al:</td><td><input type="text" id="fecha2" name="fecha2" value="<?php echo $fecha_actual;?>" size="10"></input></td>
			</tr>
		</table>
		</td>
	</tr>
	<tr>
		<td align="center" colspan="2"><input type="button" value="      VER REPORTE      " onclick="mostrar_reporte();"></td>
	</tr>
	</table>
	<div id="tbl_ajax" name="tbl_ajax" align="center"></div>
<script language="javascript">act_usuarios();</script>
</body>
</html>