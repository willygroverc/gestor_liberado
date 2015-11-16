<?php
include("conexion.php");

$sql="SELECT nombre FROM control_parametros";
$res=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($res);
?>
<html>
<head>
<title>GesTor F1 - AudiSis</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta content="Autor:" name="Limberg Illanes Murillo">
</head>
	
<table width="70%" border="0" align="center">
  <tr> 
    <td colspan="2"><div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;<u>DATOS 
        GENERALES</u></strong></font></div></td>
  </tr>
  <tr> 
    <td width="34%">&nbsp;&nbsp;&nbsp;<strong>Entidad :</strong></td>
    <td width="66%">&nbsp;<?php echo $row['nombre'];?></td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;&nbsp;<strong>Nombre del Archivo:</strong></td>
    <td>&nbsp;<?php echo $_REQUEST['arc'];?></td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;&nbsp;<strong>IP Origen :</strong></td>
    <td>&nbsp;<?php echo $_SERVER['SERVER_ADDR'];?></td>
  </tr>
  <tr> 
    <td>&nbsp;&nbsp;&nbsp;<strong>Fecha y Hora :</strong></td>
    <td>&nbsp;<?php echo date("d/m/Y  h:i:s A"); //echo $fecha."      ".$hora; ?></td>
  </tr>
  <tr> 
    <td height="21">&nbsp;&nbsp;&nbsp;</td>
    <td>&nbsp; </td>
  </tr>
  <tr> 
    <td height="21">&nbsp;&nbsp;&nbsp;<strong>Hash del Archivo:</strong></td>
    <td>
      <?php echo $_REQUEST['hs'];?>
    </td>
  </tr>
</table>
	
	
<br>
<br>
<br>
<table width="78%" border="0" align="center">
  <tr> 
    <td width="22%" height="18" align="center"> <div align="right"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;Entregado 
        por : </font></div></td>
    <td width="23%" align="center"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">Firma 
        :_____________________ </font></div></td>
    <td width="26%" align="center"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;Realizado 
        por :</font></div></td>
    <td width="29%" align="center"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">Firma 
        :______________________</font></div></td>
  </tr>
  <tr> 
    <td height="21" align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td align="center"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">Nombre 
        :_____________________</font></div></td>
    <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td align="center"><div align="right"><font size="1" face="Arial, Helvetica, sans-serif">Nombre:______________________</font></div></td>
  </tr>
</table>
</html>