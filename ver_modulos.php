<?php include ("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - MODULOS</title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">LISTA DE MODULOS</font></u></b></div></td>
  </tr>
</table>
<br>

<table width="749" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" >
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="4" cellspacing="0">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th width="6%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
          <th width="15%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">NOMBRE</font></th>
          <th width="34%"><font face="Arial, Helvetica, sans-serif" color="#000000" size="2">DESCRIPCION</font></th>
          <th width="20%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA DE CREACION</font></th>
		  <th width="25%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">CREADO 
            POR </font></th>
        </tr>
        <?php
		$sql = "SELECT *, DATE_FORMAT(fecha_creacion,'%d/%m/%Y') AS fecha_creacion FROM modulo WHERE estado=0 ORDER BY id_mod DESC";
		$result=mysql_db_query($db,$sql,$link); 
		while ($row=mysql_fetch_array($result)){
		echo "<tr align=\"center\">";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[id_mod]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[nombre_mod]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[desc_mod]</font></td>";
		echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[fecha_creacion]</font></td>";
			$sql1 = "SELECT * FROM users WHERE login_usr='$row[login_creador]'";
			$result1=mysql_db_query($db,$sql1,$link); 
			$row1=mysql_fetch_array($result1);
			echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row1[nom_usr]&nbsp;$row1[apa_usr]&nbsp;$row1[ama_usr]</font></td>";
		}
		?>
      </table></td>
  </tr>
</table>
</body>
</html>