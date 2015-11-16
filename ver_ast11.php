<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

include ("top_ver.php");
@$IdInfast=($_GET['variable']);
@$impres=($_GET['im']);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - CLASIFICACI�N DE LA INFORMACI�N MANEJADA </title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center">
      <p><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>CLASIFICACION 
          DE LA INFORMACION MANEJADA </u></font></strong></p>
     <br>
    </div></td>
  </tr>
</table>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td width="3%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td width="12%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TECNICO</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td width="25%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td width="11%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CLASIFICACION</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
    <td colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RETENCION</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESTRUCCION</font></strong></div></td>
    <td width="14%" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CONTROL</font></strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></div></td>
  </tr>
  <tr> 
    <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIEMPO</font></strong></div></td>
    <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MEDIO</font></strong></div></td>
    <td width="5%" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">MEDIO</font></strong></div></td>
    <td width="7%" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CONTROL</font></strong></div></td>
    <td width="9%" bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">ACTA</font></strong></div></td>
  </tr>
  <?php
require('conexion.php');
if ($impres=="")
{$sql="SELECT * FROM informacionast ORDER BY id_infAST ASC";}
else
{$sql="SELECT * FROM informacionast WHERE tecnico='$impres' ORDER BY id_infAST ASC";}
$result=mysql_query($sql);
while ($row=mysql_fetch_array($result)) 
{
			  $sql2 = "SELECT * FROM users";
			  $result2 = mysql_query($sql2);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if($row2['login_usr']==$row['tecnico'])
				$nomtec=$row2['nom_usr'].' '.$row2['apa_usr'].' '.$row2['ama_usr'];
	            }			  			 
	$tiempo_ret=$row['tiempo_ret'].' '.$row['clas_tiempo'];
  	echo '<tr align="center">';
	echo '<td><font size="2">&nbsp;'.$row['id_infAST'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$nomtec.'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['des_infAST'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['clasifi'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$tiempo_ret.'</td>';
	echo '<td><font size="2">&nbsp;'.$row['medio_ret'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['medio_dest'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['control_dest'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['acta_dest'].'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row['control'].'</font></td>';
	echo "</tr>";
}
?>
</table>
<p>&nbsp;</p>
</body>
</html>