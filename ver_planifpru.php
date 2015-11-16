<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
require_once('funciones.php');

$orden=SanitizeString($_GET['variable']);
$sql = "SELECT *, DATE_FORMAT(fecplanif, '%d/%m/%Y') AS fecplanif, DATE_FORMAT(fecelab, '%d/%m/%Y') AS fecelab
		FROM planprueba  WHERE ordayuda='$orden' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
	<title> GesTor F1 - CONTINGENCIA PROAPC - PLANIFICACION</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>PLANIFICACION 
        DE PRUEBA</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="191"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>No 
        DE ORDEN DE MESA</strong></font></p>
    </td>
    <td width="446"><p>&nbsp;<?php echo $row['ordayuda'];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="250"><p><font size="2" face="Arial, Helvetica, sans-serif">No DE 
        PLANIFICACION DE PRUEBA</font></p>
    </td>
    <td width="387"><p><?php echo $row['idplanpru'];?>&nbsp;</p> </td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="32%"><p><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
        DE LA PLANIFICACION:</font></p></td>
    <td width="17%"> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php echo $row['fecplanif'];?> </font></td>
    <td width="26%"><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE 
      APROBACION:</font></td>
    <td width="25%"><p> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['fecelab'];?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="36"> <strong><font size="2" face="Arial, Helvetica, sans-serif">I.- 
      DESCRIPCION</font></strong></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">1.- OBJETIVO DE LA PRUEBA 
        :</font></p>
    </td>
    <td width="65%"> <font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['objprue'];?>&nbsp;</font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">2.-TIPO 
        DE CONTINGENCIA :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['tipcontin'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">3.-CONDICIONES 
        :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['condicion'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">4.- 
        FECHAS RELACIONADAS :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['fecrelac'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">5.-VARIOS 
        :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['varios'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="41">
<p><strong><font size="2" face="Arial, Helvetica, sans-serif">II.- RECURSOS NECESARIOS</font></strong></p>
    </td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">1.-RECURSOS 
        DE HARDWARE :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['rechard'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">2.-RECURSOS 
        DE SOFTWARE :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['recsoft'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">3.-RECURSOS 
        DE RESPALDO :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['recresp'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">4.-FACILIDADES:</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['facilidad'];?>&nbsp;</font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="35%" height="18">
<p><font size="2" face="Arial, Helvetica, sans-serif">5.-COSTO 
        :</font></p>
    </td>
    <td width="65%"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['costo'];?>&nbsp;&nbsp;&nbsp;<?php echo $row['moneda'];?></font></p>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45%" height="53" > 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">III.- 
        RESPONSABLES RELACIONADOS :</font></strong></p>
    </td>
    
  </tr>
  
</table>
<table width="637" border="1" align="center" >
  <tr bgcolor="#CCCCCC"> 
    <td width="194"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></strong></div></td>
    <td width="427"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">COMENTARIOS 
        DEL RESPONSABLE </font></strong></div></td>
  </tr>
<?php
$sql2 = "SELECT * FROM resprelac WHERE idplanpru=$row[idplanpru]";
$result2=mysql_query($sql2);
while ($row2=mysql_fetch_array($result2)) 
{			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql3 = "SELECT * FROM users";
			  $result3 = mysql_query($sql3);
			  while ($row3 = mysql_fetch_array($result3)) 
				{
				if($row3['login_usr']==$row2['nombresp'])
				$nom=$row3['nom_usr'].' '.$row3['apa_usr'].' '.$row3['ama_usr'];
	            }			  			 
	echo '<tr align="center\">';
	echo '<td><font size="2">&nbsp;'.$nom.'</font></td>';
	echo '<td><font size="2">&nbsp;'.$row2['comentresp'].'</font></td>';
	echo "</tr>";
}
?>

</table>
<br>
<br>

<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="105" > 
      <p><font size="2" face="Arial, Helvetica, sans-serif">JEFE DE AREA 
        :</font></p></td>
    <td width="212"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif"> &nbsp; 
        <?php  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql7 = "SELECT * FROM users";
			  $result7 = mysql_query($sql7);
			  while ($row7 = mysql_fetch_array($result7)) 
				{
				if($row7['login_usr']==$row['jefeus'])
				echo $row7['nom_usr']."&nbsp;".$row7['apa_usr']."&nbsp;".$row7['ama_usr'];
	            }			  			 
	?>
        </font></p></td>
    <td width="34">&nbsp;</td>
    <td width="95"><font size="2" face="Arial, Helvetica, sans-serif">FIRMA:</font></td>
    <td width="191">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>