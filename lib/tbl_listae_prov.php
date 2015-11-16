<?php
// Objetivo:	Optimización de consulta SQL, para listado de ordenes de trabajo
//				Modificación de metodo de envio de datos (a POST)
//				Validacion para Inyeccion SQL.
// Autor:		Alvaro Rodriguez
// Fecha:		08/junio/2013
// Desc:		
//________________________________________________________________________________
//header('content-type text/html charset=iso-8859-1');
@session_start();
require('../conexion.php');
require ('../funciones.php');
$fechahoy = date('Y-m-d');
$menu = $_POST['tipo_busq'];
$text = $_POST['txt_busq'];
echo $menu;
echo $text;
echo '<table width="95%"border="1" cellpadding="0" cellspacing="2" background="images/fondo.jpg">
	<tr> 
	  <th colspan="11" background="windowsvista-assets1/main-button-tile.jpg" height="30px">LISTA DE PROVEEDORES / CLIENTES</th>
	</tr>
	<tr align=\"center\"> 
	  <th class="menu" background="images/main-button-tileR1.jpg">N°</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">NOM. PROVEEDOR</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">DIRECCION</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">TEL. 1</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">TEL. 2</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">ENCARGADO</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">E-MAIL</th>
	  <th class="menu" background="images/main-button-tileR1.jpg">OBSERVACION</th>';
  	   if ($tipo=="A") {
	  echo '<th class="menu" background="images/main-button-tileR1.jpg">MODIFICAR</th>
  	  <th class="menu" background="images/main-button-tileR1.jpg">ELIMINAR</th>'; }
	  echo '<th class="menu" background="images/main-button-tileR1.jpg">IMPRIMIR</th>
	</tr>';
//$sql = "SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic FROM solicproydatos ORDER BY Codigo DESC LIMIT $_pagi_inicial,$_pagi_cuantos";
if(empty($text)){
	$sql = "SELECT * FROM proveedor ORDER BY IdProv DESC";
} else {
	if($menu=='cod')	{
		$sql = "SELECT * FROM proveedor WHERE NombProv LIKE '%$text%' ORDER BY IdProv DESC";
	}
	if($menu=='tel')	{
		$sql = "SELECT * FROM proveedor WHERE Fono1Prov LIKE '%$text%' ORDER BY IdProv DESC";
	}
	if($menu=='nom')	{
		$sql = "SELECT * FROM proveedor WHERE EncProv LIKE '%$text%' ORDER BY IdProv DESC";
	}
}
//echo $sql;
if(isset($IdProv))	{
	$sql = "DELETE from proveedor WHERE IdProv='$IdProv'";   
	mysql_query($sql);
}
//$sql = "SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic FROM solicproydatos ORDER BY Codigo DESC";

/*$result=mysql_query($sql);


$recordset=mysql_query($sql);
	$num_paginas=mysql_num_rows($recordset);
	$num_paginas=($num_paginas/20)+1;
	settype($num_paginas,'integer');
	$pagina_fin=20*$pg;
	$pagina_ini=($pagina_fin-20);
	$sql.=" LIMIT $pagina_ini, 20";
	$recordset=mysql_query($sql);
*/
$result=mysql_query($sql); 
while ($row=mysql_fetch_array($result)) {
  	echo "<tr align=\"center\">";
	echo "<td>&nbsp;$row[IdProv]</td>";
	echo "<td>&nbsp;$row[NombProv]</td>";
	echo "<td>&nbsp;$row[DirecProv]</td>";
	echo "<td>&nbsp;$row[Fono1Prov]</td>";
	echo "<td>&nbsp;$row[Fono2Prov]</td>";
	echo "<td>&nbsp;$row[EncProv]</td>";
	echo "<td>&nbsp;$row[EmailProv]</td>";
	echo "<td>&nbsp;$row[ObsProv]</td>";
	if ($tipo=="A") {
	echo "<td><a href=\"proveedor.php?IdProv=".$row['IdProv']."\"><img src=\"images/editar.gif\" border=\"0\" alt=\"Modificar\"></a></td>";
	echo "<td><a href=\"lista_proveed.php?IdProv=".$row['IdProv']."\" onClick=\"return confirmLink(this,'$row[NombProv]')\"><img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a></td>";}
	echo "<td><a href=\"ver_proveedor.php?variable=".$row['IdProv']."\" target=\"_blank\"><img src=\"images/imprimir.gif\" border=\"0\" alt=\"Imprimir\"></a></td>";
	echo "</tr>";	
	}
echo "</tr>
</table>";
?>
<script language="JavaScript">
<!--
function pagina() {
	window.open("ver_lista_prov.php");
}
function confirmLink(theLink, usuario)
{
    var is_confirmed = confirm("Desea Realmente Eliminar "+ ' :\n' + usuario);
    if (is_confirmed) {
        theLink.href += '&accion=elimina';
    }
    return is_confirmed;
} // end of the 'confirmLink()' function
//-->
</script>