<?php
include ("conexion.php");
session_start();
$path = $_SESSION["path"];
?>
<html>
<head>
	<title> GesTor F1 - ARCHIVOS - ADM. FUENTES</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>
        ARCHIVOS</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="780" border="1" align="center" >
  <tr bgcolor="#CCCCCC">
   <td width="35"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro.</b></font></div></td> 
    <td width="154"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>NOMBRE</b></font></div></td>
	<td width="141"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>TAMAÑO(BYTES)</b></font></div></td>
    <td width="182"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FEC. ULT. ACTUALIZACION</b></FONT> 
	<td width="110"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>FEC. CREACION</b></FONT>
	<td width="118"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>MODULO</b></font></div></td>     
  </tr>
<?php
	if (strlen($DA) == 1){ $DA = "0".$DA; }	
	if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
    $fec1 = $AA."-".$MA."-".$DA;   
	if (strlen($DE) == 1){ $DE = "0".$DE; }
	if (strlen($ME) == 1){ $ME = "0".$ME; }
	$fec2 = $AE."-".$ME."-".$DE; 
	$nombre = $_GET['nombre'];
if ( $menu == "GENERAL" )
	$sql = "SELECT *, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev, DATE_FORMAT(fecha_creado, '%d/%m/%Y') AS fecha_creado, nombre_mod nombre_mod FROM datos_archivos as d, modulo as m
			WHERE d.id_mod = m.id_mod AND eliminado<>1 ORDER BY id_arch";
else
{	$sql = "SELECT *, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev, DATE_FORMAT(fecha_creado, '%d/%m/%Y') AS fecha_creado, nombre_mod nombre_mod FROM datos_archivos as d, modulo as m
			WHERE d.id_mod = m.id_mod  AND d.id_mod = '$nombre' AND eliminado<>1 ORDER BY id_arch";
	//echo $sql;		
}			
if ( isset($DA) ) 
{ 	if ($menu == "GENERAL")
	$sql = "SELECT *, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev, DATE_FORMAT(fecha_creado, '%d/%m/%Y') AS fecha_creado, nombre_mod FROM datos_archivos as d, modulo as m
			WHERE d.id_mod = m.id_mod AND eliminado<>1 AND fecha_rev BETWEEN '$fec1' AND '$fec2'";		
	else
	$sql = "SELECT *, DATE_FORMAT(fecha_rev, '%d/%m/%Y') AS fecha_rev, DATE_FORMAT(fecha_creado, '%d/%m/%Y') AS fecha_creado, nombre_mod FROM datos_archivos as d, modulo as m
			WHERE d.id_mod = m.id_mod AND d.id_mod = '$nombre' AND eliminado<>1 AND fecha_rev BETWEEN '$fec1' AND '$fec2'";		

}		

$res = mysql_db_query( $db, $sql, $link);
while ( $fila=mysql_fetch_array($res) ) 
{	 
	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face='arial'>$fila[id_arch]</font></td>";
	echo "<td><font size=\"1\" face='arial'>$fila[nombre_arch]</font></td>";
	$path_c = $path."/".$fila[nombre_mod]."/".$fila[nombre_arch];
	$size = filesize($path_c);
	echo "<td><font size=\"1\" face='arial'>$size</font></td>";
	if ($fila[fecha_rev]!="00/00/0000") 
	echo "<td><font size=\"1\" face='arial'>$fila[fecha_rev]</font></td>";
	else echo "<td>&nbsp;</td>";	
	if ($fila[fecha_creado]!="00/00/0000") 
	echo "<td><font size=\"1\" face='arial'>$fila[fecha_creado]</font></td>";
	else echo "<td>&nbsp;</td>";	
	echo "<td><font size=\"1\" face='arial'>$fila[nombre_mod]</font></td>";			
	echo "</tr>";
}
?>

</table>
<br>
<br>
</body>
</html>