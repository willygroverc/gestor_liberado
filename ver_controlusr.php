<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
require_once('funciones.php');
$idcontrol=SanitizeString($_GET['variable']);
$idcontrol=SanitizeString($_GET['variable']);
$sql="SELECT * FROM control_usr WHERE IdControl='$idcontrol'";
$resul=mysql_query($sql);
$row=mysql_fetch_array($resul);
?>
<html>
<head>
<title> GesTor F1 - SEGURIDAD PROASI - CONTROL DE USUARIOS</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>CONTROL DE USUARIOS</u></strong></font></div></td>
  </tr>
</table>

<br>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="164"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE CONTROL :</strong></font></td>
    <td width="73">&nbsp;&nbsp;<?php echo $row['IdControl']; ?>&nbsp;</td>
    <td width="399">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
  </tr>
</table>
<br>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="163"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DE USUARIO :</strong></font></td>
    <td width="473">&nbsp;&nbsp; 
      <?php 
	$sql2="SELECT * FROM users WHERE login_usr='$row[NombreUsr]'";
	$resul2=mysql_query($sql2);
	$row2=mysql_fetch_array($resul2);
	echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr']; ?>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">LOGIN</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APLICACION 
    / SISTEMA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
    DE ACCESO</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
    DE ENTRADA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
    DE SALIDA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
<?php
$sql4="SELECT *,DATE_FORMAT(FechaIn,'%d / %m / %Y') as FechaIn,DATE_FORMAT(FechaOut,'%d / %m / %Y') as FechaOut FROM control_usr WHERE IdControl='$idcontrol'";
$resul4=mysql_query($sql4);
while($row4=mysql_fetch_array($resul4)){
	echo "<tr align=\"center\">";
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['Idu'].'</font></td>';
	$sql3="SELECT * FROM sistemas WHERE Id_Sistema='".$row4['AplicSistema']."'";
	$resul3=mysql_query($sql3);
	$row3=mysql_fetch_array($resul3);
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row3['Descripcion'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['TipoAcceso'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['FechaIn'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['FechaOut'].'</font></td>';
	echo '<td align="center"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;'.$row4['Observ'].'</font></td>';
	echo '</tr>';
}
?>
</table>
</body>
</html>