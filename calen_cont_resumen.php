<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
require("conexion.php");
require_once('funciones.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($Retornar)){ header("location: lista_calen_cont.php");}
else 
{ include ("top.php");?>
<script language="JavaScript">
<!--
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar la Calendarizacion Nro. "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
</script>
<?php 
$TipoPru=SanitizeString($_GET['TipoPru']);
@$num=SanitizeString($_GET['num']);
@$estado=SanitizeString($_GET['estado']);

if (isset($accion) && $accion=="elimina")
{ $sql="DELETE FROM calen_contingencia WHERE id_cmant='$num' AND TipoPru='$TipoPru' AND estado='$estado'";
 	mysql_query($sql);
}
?>
<input name="var" type="hidden" value="<?php echo $TipoPru;?>">
<table width="95%" border="0" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg">
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2" background="images/fondo.jpg" >
        <tr> 
          <th colspan="8" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF">CALENDARIZACION 
            INDIVIDUAL - CONTINGENCIA</font></th>
        </tr>
        <tr align="center"> 
          <th width="39" height="21" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">Nro. 
            </font></th>
          <th width="71" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ORD. 
            TRABAJO</font></th>
          <th width="319" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">INICIDENCIA</font></th>
          <th width="98" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">ESTADO</font></th>
          <th width="83" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">FECHA 
            INICIO</font></th>
          <th width="90" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
            FINAL</font></th>
          <th width="120" bgcolor="#006699"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="1">SEGUIMIENTO</font></th>
          <th width="81" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">ELIMINAR</font></th>
        </tr>
        <?php
$sql = "SELECT *, DATE_FORMAT(fecha_del, '%d/%m/%Y') AS fecha_del, DATE_FORMAT(fecha_al, '%d/%m/%Y') AS fecha_al 
		FROM calen_contingencia  WHERE TipoPru='$TipoPru' ORDER BY id_cmant ASC";  //HERE
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) {

	$sql2 = "SELECT * FROM calen_contingencia WHERE id_cmant='$row[id_cmant]' AND estado='Realizado' ";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2); 
  
  
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">$row[id_cmant]</font></td>";
	echo "<td><font size=\"1\">$row[TipoPru]</font></td>";
		$sql4 = "SELECT * FROM ordenes WHERE id_orden='$row[TipoPru]'";
		$result4=mysql_query($sql4);
		$row4=mysql_fetch_array($result4);
		echo "<td><font size=\"1\">$row4[desc_inc]</td>";
	echo "<td><font size=\"1\">$row[estado]</td>";
	echo "<td><font size=\"1\">$row[fecha_del]</font></td>";
	echo "<td><font size=\"1\">$row[fecha_al]</font></td>";
	if (!$row2['estado'])
	{	echo "<td><font size=\"1\">REALIZACION POR LLENAR</a></font></td>";}
	else
	{	echo "<td><font size=\"1\">LLENADO</font></td>";}
	echo "<td nowrap><a href=\"calen_cont_resumen.php?num=".$row['id_cmant']."&TipoPru=".$row['TipoPru']."&estado=".$row['estado']."\" onClick=\"return confirmLink(this,'$row[id_cmant]')\">ELIMINAR</a>&nbsp;</td>";
	echo "</tr>";
}

?>
      </table></td>
  </tr>
</table>
  
  
<form name="form1" method="post" action="">
  <input name="Retornar" type="submit" id="reg_form3" value="RETORNAR">
</form>

 <?php } ?>