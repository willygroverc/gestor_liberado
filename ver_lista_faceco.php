<?php
include("top_ver.php");
?>
<table width="100%" border="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>ANALISIS 
        DE FACTIBILIDAD ECONOMICA</strong></u></font></div></td>
  </tr>
</table>
<br>
<table width="100%" border="1">
  <tr> 
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO</strong></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
        DEL PROYECTO</strong></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
        DEL RESPONSABLE</strong></font></div></td>
    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TOTAL 
        </strong></font></div></td>
  </tr>
<?php
$sql="SELECT * FROM ana_facti";
$resul=mysql_db_query($db,$sql,$link);
while($row=mysql_fetch_array($resul))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;$row[id_ficha]</font></td> ";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;$row[nomproy]</font></td> ";
	$sql2 = "SELECT * FROM users WHERE login_usr='$row[nomresp]'";
	$result2 = mysql_db_query($db,$sql2,$link);
	$row2 = mysql_fetch_array($result2); 
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</font></td> ";
	echo "<td align=\"center\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"> &nbsp;$row[total]</font></td> ";
	echo "</tr>";
}
?>
</table>