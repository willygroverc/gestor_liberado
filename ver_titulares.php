<?php include ("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - FICHA TECNICA</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">TITULARES</font></u></b></div></td>
  </tr>
</table>
<br>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th height="14"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CI/RUC</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">NOMBRES</font></strong></th>
          <th><strong><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">APELLIDO 
            PATERNO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">APELLIDO 
            MATERNO </font></strong></th>
		<th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">APELLIDO 
            DE CASADA </font></strong></th>
			
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">E-MAIL</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">ENTIDAD</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">AREA</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CARGO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">TELEFONO</font></strong></th>
          <th><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FAX</font></strong></th>
        </tr>
<?php
$sql = "SELECT * FROM titular ORDER BY ci_ruc ASC";
$result=mysql_db_query($db,$sql,$link); 
while ($row=mysql_fetch_array($result)) {	
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[ci_ruc]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[nombre]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[apaterno]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[amaterno]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[acasada]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[email]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[entidad]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[area]</font></td>";
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[cargo]</font></td>";	
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[telf]</font></td>";	
	echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[externo]</font></td>";
	echo "</tr>";
}?>
      </table></td>
  </tr>
</table>
</body>
</html>