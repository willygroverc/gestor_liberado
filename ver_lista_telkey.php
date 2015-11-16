<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require("conexion.php");
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");?>
<html>
<head>
<title>GesTor F1 - LISTA DE TELKEY</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><strong><font size="4"><u><font face="Arial, Helvetica, sans-serif">LISTADO 
        DE TELKEY</font><br>
        <br>
        </u></font></strong></div></td>
  </tr>
</table>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Nr</font></strong></div>
    <div align="center"><strong></strong></div></td>
	  <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE RESPONSABLE</font></strong></div>    </td>
	  <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE DE CUENTA </font></strong></div>    </td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIP&Ograve; DE CUENTA </font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">SISTEMA</font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE ENTRADA </font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE RETIRO</font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE REEMPLAZO </font></strong></div></td>
      <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
  <?php
$sql="SELECT * FROM telkey";
$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{?>
	<tr align="center">
	<td align="center" font size="2">&nbsp;<?php echo $row['Idtelkey'];?></td>
	<td align="center" font size="2">&nbsp;<?php echo $row['Responsable'];?></td>
	<td align="center" font size="2">&nbsp;<?php echo $row['Cuenta'];?></td>
	<td align="center" font size="2"><?php echo $row['Tipo'];?></td>
	<td align="center" font size="2"><?php echo $row['Sistema'];?></td>
	<td align="center" font size="2"><?php echo $row['Fechaen'];?></td>
	<td align="center" font size="2"><?php echo $row['Fechare'];?></td>
	<td align="center" font size="2"><?php echo $row['Reemplazo'];?></td>
	<td align="center" font size="2"><?php echo $row['Observaciones'];?></td>
	<?php
	@$sql2="SELECT * FROM users WHERE login_usr='$row[Titular1]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);?>
	<?php	
	@$sql3="SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);?>
	<?php
	@$sql4="SELECT * FROM users WHERE login_usr='$row[Titular2]'";
	$result4=mysql_query($sql4);
	$row4=mysql_fetch_array($result4);?>
	<?php
	@$sql5="SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
	$result5=mysql_query($sql5);
	$row5=mysql_fetch_array($result5);?>
	</tr>
<?php } ?>
</table>
</body>
</html>