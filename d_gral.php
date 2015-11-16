<?php include("conexion.php");
session_start();
$login=$_SESSION['login'];

$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login'";
$result_us=mysql_db_query($db,$sql_us,$link);
$row_us=mysql_fetch_array($result_us);

$sql_pepe="SELECT nombre FROM control_parametros";
$res_hola=mysql_db_query($db,$sql_pepe,$link);
$row_martin=mysql_fetch_array($res_hola);
?>
<table width="100%" border="0">
  <tr>
    <td colspan="2"><div align="left"><font size="3" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;<u>DATOS GENERALES</u></strong></font></div></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<strong>Entidad :</strong></td>
    <td>&nbsp;<?php echo $row_martin[nombre];?></td>
  </tr>
  <tr>
    <td width="13%">&nbsp;&nbsp;&nbsp;<strong>Ralizado por :</strong></td>
    <td width="87%">&nbsp;<?php echo "$row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]";?></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<strong>IP Origen :</strong></td>
    <td>&nbsp;<?php echo $_SERVER['REMOTE_ADDR'];?></td>
  </tr>
  <tr>
    <td>&nbsp;&nbsp;&nbsp;<strong>Fecha y Hora :</strong></td>
    <td>&nbsp;<?php echo date("Y-m-d")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s");?></td>
  </tr>
  <tr>
    <td height="21">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

