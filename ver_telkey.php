<?php 
include("top_ver.php");
$idsis=($_GET['variable']);
$sql="SELECT * FROM telkey WHERE Idtelkey='$variable'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - PRODUCCIÓN-PROAPD - PROPIETARIOS Y RESPONSABLES</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u> TELKEY </u>
        </font></strong></div></td>
  </tr>
</table>

<br>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO 
      DE TELKEY:</strong></font></td>
    <td>&nbsp;<?php echo $row[Idtelkey];?>&nbsp;</td>
  </tr>
    <tr> 
    <td width="200" height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE RESPONSABLE:</font></strong></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row[Responsable]; ?></font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE DE CUENTA:</font></strong></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row[Cuenta]; ?></font>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO DE CUENTA:</font></strong></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row[Tipo]; ?></font>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">SISTEMA:</font></strong></td>
    <td><?php echo $row[Sistema]; ?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE ENTRADA:</font></strong></td>
    <td><?php echo $row[Fechaen]; ?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE RETIRO:</font></strong></td>
    <td><?php echo $row[Fechare]; ?>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
   </tr>
</table>

<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA DE REEMPLAZO:</font></strong></td>
    <td><?php echo $row[Reemplazo]; ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES:</font></strong></td>
    <td><?php echo $row[Observaciones]; ?>&nbsp;</td>
  </tr>
  <tr>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
</body>
</html>