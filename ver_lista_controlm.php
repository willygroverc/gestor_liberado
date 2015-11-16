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
include ("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - SOPORTE TÉCNICO-PROAST - MANTENIMIENTO</title>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"> 
        <p><strong><font size="4"><u><font face="Arial, Helvetica, sans-serif">PLANILLA 
          DE CONTROL DE MANTENIMIENTO<br>
          </font><br>
          </u></font></strong></p>
        </div></td>
  </tr>
</table>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td width="2%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">No</font></strong></font></div></td>
    <td width="8%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">No 
    DE ACTIVO FIJO</font></strong></font></div></td>
    <td width="8%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO 
    ADICIONAL </strong></font></div></td>
    <td width="14%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ASIGNADO A 
    </strong></font></div></td>
		
    <td width="9%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></font></div></td>
    <td width="8%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FECHA 
    DE SALIDA</font></strong></font></div></td>
    <td width="9%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FECHA 
    DE RETORNO</font></strong></font></div></td>
    <td width="12%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FUNCIONARIO 
    RESPONSABLE</font></strong></font></div></td>
    <td width="16%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">OBSERVACION</font></strong></font></div></td>
    <td width="14%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">EMPRESA</font></strong></font></div></td>
  <?php
if($tm=="T" AND $tman=="T"){$sql="SELECT a.*,DATE_FORMAT(fecha_s,'%d / %m / %Y') as fecha_s,DATE_FORMAT(fecha_r,'%d / %m / %Y') as fecha_r FROM pcontrol a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1";}
elseif($tm!="T" AND $tman!="T"){$sql="SELECT a.*,DATE_FORMAT(fecha_s,'%d / %m / %Y') as fecha_s,DATE_FORMAT(fecha_r,'%d / %m / %Y') as fecha_r FROM pcontrol a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 and tipo_mant2='$tm' AND tipo_mant='$tman'";}
elseif($tm=="T" AND $tman!="T"){$sql="SELECT a.*,DATE_FORMAT(fecha_s,'%d / %m / %Y') as fecha_s,DATE_FORMAT(fecha_r,'%d / %m / %Y') as fecha_r FROM pcontrol a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 and tipo_mant='$tman'";}
elseif($tm!="T" AND $tman=="T"){$sql="SELECT a.*,DATE_FORMAT(fecha_s,'%d / %m / %Y') as fecha_s,DATE_FORMAT(fecha_r,'%d / %m / %Y') as fecha_r FROM pcontrol a, datfichatec b WHERE a.AdicUSI=b.AdicUSI AND b.Elim<>1 and tipo_mant2='$tm'";}

$result=mysql_query($sql);
while($row=mysql_fetch_array($result))
{
	echo"<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[id_regPC] </font></td>";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[CodActFijo] </font></td>";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[AdicUSI] </font></td>";
	
	$str = "SELECT * FROM datfichatec WHERE AdicUSI='$row[AdicUSI]'";
	$res = mysql_query($str);
	$fila = mysql_fetch_array($res);

	$str0  = "SELECT NombAsig FROM asigcustficha WHERE IdFicha='$fila[IdFicha]'";
	$res0  = mysql_query(  $str0, $link);
	$fila0 = mysql_fetch_array($res0);
		 
	$str1 = "SELECT * FROM users WHERE login_usr='$fila0[NombAsig]'";
	$res1 = mysql_query($str1);
	$datos = mysql_fetch_array($res1);
	if ($datos)
	 echo "<td align=\"center\"><font size=\"1\">&nbsp;$datos[nom_usr] $datos[apa_usr] $datos[ama_usr] </font></td>";			 
	else
	 echo "<td align=\"center\"><font size=\"1\">&nbsp;Ninguno </font></td>";						
	
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[des_disp] </font></td>";		
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[fecha_s] </font></td>";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[fecha_r] </font></td>";
	$sql2="SELECT * FROM users WHERE login_usr='$row[login_usr]'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr] </font></td>";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[Observ] </font></td>";
	echo "<td align=\"center\"><font size=\"1\">&nbsp;$row[NombProv] </font></td>";	
	echo "</tr>";
}
?>
</table>
</body>
</html>