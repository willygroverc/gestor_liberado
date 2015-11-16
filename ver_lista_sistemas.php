<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
 include("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - PRODUCCION-PROAPD - PROPIETARIOS Y RESPONSABLES </title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><strong><font size="4"><u><font face="Arial, Helvetica, sans-serif">LISTADO 
        DE PROPIETARIOS Y RESPONSABLES</font><br>
        <br>
        </u></font></strong></div></td>
  </tr>
</table>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">SISTEMA</font></strong></div>
    <div align="center"><strong></strong></div></td>
	  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></div>
    <div align="center"><strong></strong></div></td>
	  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO</font></strong></div>
    <div align="center"><strong></strong></div></td>
    <td colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">UNIDAD 
    DE SISTEMA</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DUENO</font></strong></div></td>
  </tr>
  <tr> 
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TITULAR</font></strong></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">SUPLENTE</font></strong></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Area</font></strong></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TITULAR</font></strong></div></td>
    <td bgcolor="#CCCCCC"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">SUPLENTE</font></strong></div></td>
  </tr>
  <?php
$sql="SELECT * FROM sistemas";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{?>
	<tr align="center">
	<td align="center" font size="2">&nbsp;<?php echo $row['Id_Sistema'];?></td>
	<td align="center" font size="2">&nbsp;<?php echo $row['Descripcion'];?></td>
	<td align="center" font size="2">&nbsp;<?php echo $row['Id_Tipo'];?></td>
	<?php
	$sql2="SELECT * FROM users WHERE login_usr='$row[Titular1]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);?>
	<td align="center" font size="2">&nbsp;<?php echo $row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];?> </td>
	<?php	
	$sql3="SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);?>
	<td align="center" font size="2">&nbsp;<?php echo $row3['nom_usr']." ".$row3['apa_usr']." ".$row3['ama_usr'];?></td>
	<td align="center" font size="2">&nbsp;<?php echo $row['Area'];?></td>
	<?php
	$sql4="SELECT * FROM users WHERE login_usr='$row[Titular2]'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);?>
	<td align="center" font size="2">&nbsp;<?php echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr'];?></td>	
	<?php
	$sql5="SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);?>
	<td align="center" font size="2">&nbsp;<?php echo $row5['nom_usr']." ".$row5['apa_usr']." ".$row5['ama_usr'];?></td>	
	</tr>
<?php } ?>
</table>
</body>
</html>