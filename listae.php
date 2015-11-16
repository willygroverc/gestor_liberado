<?php
// Version: 	1.0
// Objetivo: 	Actualizar funciones ambiguas php NO recomendadas para version 5.3 o posterior
//				Implementacion de Mejora en asistente de busqueda de ordenes de trabajo.
// Autor:		Cesar Cuenca
// Fecha:		16/NOV/12, 14/ENE/2013
//_____________________________________________________________________________________________


include ("top.php");
include("funciones.inc.php");	
@session_start();
$_SESSION['modulo']='lista';
$login_usr = $_SESSION["login"];
?>
<p>
<script language="javascript" src="js/ordenes.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
<script type="text/javascript" language="javascript" src="js/ajax.js"></script>
<table border="1" align="center" bgcolor="#006699">
    <tr> 
		<td align="center" colspan="8">
			<input type="hidden" id="txt_tipo_usr" name="txt_tipo_usr" value="<?php echo $_SESSION['tipo']?>"></input>
			<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Asistente de B&uacute;squeda</strong></font> 
		<td>
	</tr>
	<tr>
		<!--<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Agencia :</strong></font> </td>
		<td><?php include('lib/cmb_agencia.php');?></td>-->
		<?php
		if ($_SESSION['tipo']=='A'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Area :</strong></font></td>';
			echo '<td>';
			include('lib/cmb_area.php');
			echo '</td>';
		}
		?>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Tipo :</strong></font> </td>
		<td align="center">
			<select name="cmb_filtro" id="cmb_filtro" onchange="document.getElementById('pg').value=1;filtrar_lista();">
				<option value="0">Sin filtro</option>
				<option value="1">Asignado</option>
				<option value="2">No Asignado</option>
				<option value="3">Solucionado</option>
				<option value="4">No Solucionado</option>
				<option value="5">Con Conformidad</option>
				<option value="6">Sin Conformidad</option>
			</select>
		</td>	
		<?php
		if ($_SESSION['tipo']=='A'){
			echo '<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Enviado Por:</strong></font></td>';
			echo '<td><div id="ajax_env" name="ajax_env"></div></td>';
		}
		?>
		<td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Con las palabras :</strong></font> </td>
		<td>
			<input name="txt_busqueda" id="txt_busqueda" type="text" size="25" maxlength="25" value="" onkeyup="filtrar_lista();"></input>
		</td>
		 <td>
			<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
		 </td>
	</tr>
       
  </table><br><br>
<div id="tbl_ajax"></div>
<br>
<?php 
	if ($_SESSION['tipo']=='A')
		echo '<script>filtrar_usuario_lista();</script>';
	else
		echo '<script>filtrar_lista();</script>';
?>
<script language="JavaScript">

function openStat_2(){
	window.open("orden_estadistica.php",'Estadisticas', 'status=no, scrollbars=1');
}
function openStat_3(){
	window.open("orden_estadistica2.php",'Estadisticas', 'width=610,height=160,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
function enviar(id){
	open("ver_orden.php?id_orden="+id);
}
</script>