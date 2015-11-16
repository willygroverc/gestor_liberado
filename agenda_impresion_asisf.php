<?php 
include("conexion.php");
if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
$fec1 = $AA."-".$MA."-".$DA;   
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
$fec2 = $AE."-".$ME."-".$DE; 
?>
<html>
<head>
<title>Impresion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<br>
<div align="center">
  <p><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>LISTA DE PROPOSICIONES</u></font></strong></p>
  <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;USUARIO: 
    </strong> 
    <?php
	$sql_usr="SELECT CONCAT(nom_usr,' ',apa_usr,' ',ama_usr) AS nombre FROM users WHERE login_usr='$elab_por'";
	$res_usr=mysql_db_query($db,$sql_usr,$link);
	$row_usr=mysql_fetch_array($res_usr);
	echo $row_usr[nombre];
	?>
    </font> </p>
  <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;FECHAS: 
    </strong> Del <?php=$fec1?>, al <?php=$fec2?> </font> </p>
</div>
<table width="100%" border="3" align="center" cellpadding="0" cellspacing="0">
  <tr align="center"> 
    <th width="10%" class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">REUNION No.</font></strong></th>
    <th width="16%" class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></strong></th>
    <th width="74%" class="menu"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROPOSICION</font></strong></th>
  </tr>
<?php
$sql = "SELECT * FROM asistentes s, agenda a WHERE s.id_minuta=a.id_agenda AND s.nombre='$elab_por' AND s.prop IS NOT NULL AND en_fecha BETWEEN '$fec1' AND '$fec2'"; 
$result=mysql_db_query($db,$sql,$link);
while ($row=mysql_fetch_array($result)) 
{
  	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[num_codigo]</font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[en_fecha]</font></td>";
	echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row[prop]</td>";
	echo "</tr>\n";}
?>
</table>
</body>
</html>
