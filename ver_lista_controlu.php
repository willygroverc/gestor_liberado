<?php
include("top_ver.php");
$impres=($_GET['im']);
?>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><U>LISTA DE CONTROL DE USUARIOS</U></strong> 
        </font></div></td>
  </tr>
</table>

<br>
<table width="100%" border="1">
  <tr bgcolor="#CCCCCC"> 
    <td width="5%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NUMERO 
    DE APLICACION</font></strong></div></td>
    <td width="25%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE 
    DEL USUARIO</font></strong></div></td>
    <td width="15%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">IDENTIFICACION 
    DE USUARIO</font></strong></div></td>
    <td width="12%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">APLICACION/SISTEMA</font></strong></div></td>
    <td width="8%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO 
    DE ACCESO</font></strong></div></td>
    <td width="9%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
    DE INGRESO</font></strong></div></td>
    <td width="9%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA 
    DE SALIDA</font></strong></div></td>
    <td width="20%"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
  </tr>
<?php
if(isset($im)){
	if ($impres=="")
	{$sql="SELECT *,DATE_FORMAT(FechaIn,'%d / %m / %Y') as FechaIn,DATE_FORMAT(FechaOut,'%d / %m / %Y') as FechaOut FROM control_usr";}
	else
	{$sql="SELECT *,DATE_FORMAT(FechaIn,'%d / %m / %Y') as FechaIn,DATE_FORMAT(FechaOut,'%d / %m / %Y') as FechaOut FROM control_usr WHERE NombreUsr='$impres' ORDER BY IdControl ASC";}
}
if(isset($sis)){
	$sql="SELECT *,DATE_FORMAT(FechaIn,'%d / %m / %Y') as FechaIn,DATE_FORMAT(FechaOut,'%d / %m / %Y') as FechaOut FROM control_usr WHERE AplicSistema='$sis'";
}
$resul=mysql_db_query($db,$sql,$link);
while($row=mysql_fetch_array($resul))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[IdUsr]</font></td>";
	$sql2="SELECT * FROM users WHERE login_usr='$row[NombreUsr]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td>";	
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Idu]</font></td>";
	$sql3="SELECT * FROM sistemas WHERE Id_Sistema='$row[AplicSistema]'";
	$resul3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($resul3);
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row3[Descripcion]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[TipoAcceso]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[FechaIn]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[FechaOut]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[Observ]</font></td>";
	echo "</tr>";
}
?>
</table>
