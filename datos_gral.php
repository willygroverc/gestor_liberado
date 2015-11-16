<?php
require("conexion.php");
@session_start();
$login=$_SESSION['login'];

$sql_us="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login'";
$result_us=mysql_query($sql_us);
$row_us=mysql_fetch_array($result_us);

$sql_cons="SELECT nombre , datos_gral FROM control_parametros";
$res_cons=mysql_query($sql_cons);
$row_cons=mysql_fetch_array($res_cons);
 if ($row_cons['datos_gral']==1){ 
?>
<table width="100%" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="3"><div align="left"><font size="1" face="verdana"><strong>&nbsp;<font size="2">&nbsp;<u>DATOS 
        GENERALES</u></font></strong></font></div></td>
  <tr> 
    <td width="1%"></td>
    <td width="16%" height="19" class="subtitulo"><font size="2">ENTIDAD :</font></td>
    <td width="83%" class="info"><?php echo $row_cons['nombre'];?></td>
  </tr>
  <tr> 
    <td></td>
    <td width="16%" height="19" class="subtitulo"><font size="2">REALIZADO POR 
      :</font></td>
    <td class="info"><?php echo $row_us['nom_usr'].' '.$row_us['apa_usr'].' '.$row_us['ama_usr'];?></td>
  </tr>
  <tr> 
    <td></td>
    <td width="16%" height="19" class="subtitulo"><font size="2">IP ORIGEN :</font></td>
    <td class="info"><?php echo $_SERVER['REMOTE_ADDR'];?></td>
  </tr>
  <tr> 
    <td></td>
    <td width="16%" height="20" class="subtitulo"><font size="2">FECHA Y HORA 
      :</font></td>
    <td class="info"><?php echo date("Y-m-d")."&nbsp;&nbsp;&nbsp;&nbsp;".date("H:i:s");?></td>
  </tr>
</table>
<?php
}
?>