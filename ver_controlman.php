<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		02/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include("top_ver.php");
require_once('funciones.php');
$idreg=SanitizeString($_GET['variable']);
$sql="SELECT *,DATE_FORMAT(fecha_s,'%d / %m / %Y') as fecha_s,DATE_FORMAT(fecha_r,'%d / %m / %Y') as fecha_r,DATE_FORMAT(fecha_ret,'%d / %m / %Y') as fecha_ret FROM pcontrol WHERE id_regPC='$idreg'";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - SOPORTE TÉCNICO-PROAST - MANTENIMIENTO FUERA</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>PLANILLA 
        DE CONTROL DE MANTENIMIENTO</strong></u></font></div></td>
  </tr>
</table>


<br>
<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="244" ><font size="2" face="Arial, Helvetica, sans-serif"><strong>MANTENIMIENTO 
      : </strong></font></td>
    <td width="115">&nbsp;&nbsp;
      <?php 
	if($row['tipo_mant2']=="I"){echo "INTERNO";}
	elseif($row['tipo_mant2']=="E"){echo "EXTERNO";}?>
    </td>
    <td width="519">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="244" ><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro. DE 
      REGISTRO : </strong></font></td>
    <td width="74">&nbsp;&nbsp;<?php echo $row['id_regPC']; ?> </td>
    <td width="560">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>

<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="253"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro. DE 
      ACTIVO FIJO :</strong></font></td>
    <td width="625">&nbsp;&nbsp;<?php echo $row['CodActFijo']; ?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="243"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nro. CODIGO 
      ADICIONAL :</strong></font></td>
    <td width="635">&nbsp;&nbsp;<?php echo $row['AdicUSI'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><strong>I.- 
        DATOS INTERNOS</strong></font></div></td>
  </tr>
</table>
&nbsp; 
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="233"><font size="2" face="Arial, Helvetica, sans-serif">1.- EQUIPO 
      ASIGNADO A :</font></td>
    <td width="548">&nbsp;&nbsp; 
      <?php
	$str = "SELECT * FROM datfichatec WHERE AdicUSI='$row[AdicUSI]'";
	$res = mysql_query($str);
	$fila = mysql_fetch_array($res);
	
	$str0  = "SELECT NombAsig FROM asigcustficha WHERE IdFicha='$fila[IdFicha]'";
	$res0  = mysql_query(  $str0, $link);
	$fila0 = mysql_fetch_array($res0);
					 
	$str1 = "SELECT * FROM users WHERE login_usr='$fila0[NombAsig]'";
	$res1 = mysql_query($str1);
	$datos = mysql_fetch_array($res1);
	
	if (isset($datos))
	echo $datos['nom_usr']."&nbsp;".$datos['apa_usr']."&nbsp;".$datos['ama_usr'];	
	else
	echo "Ninguno";		
	 ?>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="216" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">2.- 
      DESCRIPCION :</font></td>
    <td width="565"><div align="justify">&nbsp;&nbsp;<?php echo $row['des_disp'];?>&nbsp;</div></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="268"><font size="2" face="Arial, Helvetica, sans-serif">2.- TIPO 
      DE MANTENIMIENTO :</font></td>
    <td width="513">&nbsp;&nbsp;<?php echo $row['tipo_mant'];?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="243"><font size="2" face="Arial, Helvetica, sans-serif">3.- FECHA 
      DE SALIDA :</font></td>
    <td width="538">&nbsp;&nbsp;<?php echo $row['fecha_s'];?>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="352"><font size="2" face="Arial, Helvetica, sans-serif">4.- FECHA 
      ESTIMADA DE RETORNO :</font></td>
    <td width="429">&nbsp;&nbsp;<?php echo $row['fecha_r'];?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="510"><font size="2" face="Arial, Helvetica, sans-serif">5.- FUNCIONARIO 
      RESPONSABLE - ENTREGA</font> :</td>
    <td width="271">&nbsp;
	<?php 
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[login_usr]'";
	$result2 = mysql_query($sql2);
	$row2 = mysql_fetch_array($result2);
	echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr'];
	?></td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="352" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">6.- 
      OBSERVACIONES DE ENTREGA :</font></td>
    <td width="429"><div align="justify">&nbsp;&nbsp;<?php echo $row['Observ'];?></div></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="244"><font size="2" face="Arial, Helvetica, sans-serif">7.- FECHA 
      DE RETORNO :</font></td>
    <td width="537">&nbsp;&nbsp;<?php 
	if($row['fecha_ret']=="00 / 00 / 0000"){echo "SIN DEVOLUCION";}
	else{echo $row['fecha_ret'];}?>    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="445"><font size="2" face="Arial, Helvetica, sans-serif">8.- FUNCIONARIO 
      RESPONSABLE - RETORNO:</font></td>
    <td width="336">&nbsp;&nbsp;<?php 
	if($row['login_usr2']==""){echo "SIN DEVOLUCION";}
	else{
		$sql2 = "SELECT * FROM users WHERE login_usr='$row[login_usr2]'";
		$result2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($result2);
		echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr'];
	}
	?>    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="381" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">9.- 
      OBSERVACIONES DE RETORNO :</font></td>
    <td width="400"><div align="justify">&nbsp;&nbsp;<?php 
	if($row['obs_retorno']==""){echo "SIN DEVOLUCION";}
	else{echo $row['obs_retorno'];}?> 
      </div></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<?php 
$tm=SanitizeString($tm);
if(isset($tm) && $tm=="E"){?>
<table  width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>II.- 
        DATOS EXTERNOS - EMPRESA</strong></font></div></td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="240"><font size="2" face="Arial, Helvetica, sans-serif">1.- NOMBRE 
      DE LA EMPRESA : </font></td>
    <td width="393">&nbsp;&nbsp;<?php echo $row['NombProv'];?></td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="264"><font size="2" face="Arial, Helvetica, sans-serif">2.- RESPONSABLE 
      - ENTREGA:</font></td>
    <td width="373">&nbsp;&nbsp;<?php if (isset($row['ncProv']))echo $row['ncProv'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table  width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="264"><font size="2" face="Arial, Helvetica, sans-serif">3.- RESPONSABLE 
      - RETORNO:</font></td>
    <td width="373">&nbsp;&nbsp;<?php echo $row['enc_prov2'];?></td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<?php }?>
</body>
</html>