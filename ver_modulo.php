<?php 
session_start();
if(!empty($_SESSION["path_trash"])) { $path_trash=$_SESSION["path_trash"];  }
include("top_ver.php");
include ("conexion.php");

$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion, DATE_FORMAT(fecha_baja, '%d/%m/%Y') AS fecha_baja FROM modulo WHERE id_mod='$id_modu'";
$result = mysql_db_query($db,$sql,$link);
$row = mysql_fetch_array($result);
?>
<html>
<head>
	<title> GesTor F1 - MODULOS - ADM. FUENTES</title>
</head>
<body>
<p>
<?php include("datos_gral.php"); ?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>
        MODULOS</u></font> </strong></div></td>
  </tr>
</table>
<br>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="169"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>No. DE MODULO:</strong></font></p>
    </td>
    <td width="75"><p><?php echo $row['id_mod'];?></p> </td>
    <td width="171"><p align="left"><font size="2" face="arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;NOMBRE 
        DEL MODULO:</strong></font></p>
    </td>
    <td width="232"><p><?php echo $row['nombre_mod'];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
  <tr height="20"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="168"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION:</strong>
       </font></p>
    </td>
    <td width="479"><p><?php echo $row['desc_mod']?>&nbsp;</p> </td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
  <tr height="20"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="26%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        DE CREACION:</strong></font></p></td>
    <td width="32%"> <font size="2" face="Arial, Helvetica, sans-serif"> <?php echo $row['fecha_creacion'] ?> 
      </font></td>
    <td width="42%">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
  <tr height="20"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
  if ($row['estado']==1){
  ?>
  <tr> 
    <td width="26%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        DE ELIMINACION:</strong></font></p></td>
    <td width="32%"> <font size="2" face="Arial, Helvetica, sans-serif"> <?php echo $row['fecha_baja'] ?> 
      </font></td>
    <td width="42%">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
  <tr height="20"> 
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php
  }
  ?>
  <tr> 
    <td width="26%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>CREADOR:</strong></font></p></td>
    <td width="32%"> <font size="2" face="Arial, Helvetica, sans-serif"> 
      <?php 
	$sql1="SELECT * FROM users WHERE login_usr='$row[login_creador]'";
	$result1 = mysql_db_query($db,$sql1,$link);
	$row1 = mysql_fetch_array($result1);
	echo $row1['nom_usr']." ".$row1['apa_usr']." ".$row1['ama_usr']; ?>
      </font></td>
  </tr>
	       <td height="2"></td>
    <td bgcolor="#000000"></td>
  <tr> 
    <td height="2"><p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></p></td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td height="2" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ARCHIVOS:</strong></font></td>
    <td ><?php 
	$sqlarch = "SELECT * FROM datos_archivos WHERE id_mod='$id_modu'";
	$resultarch = mysql_db_query($db,$sqlarch,$link);
	while($rowarch = mysql_fetch_array($resultarch)){
	echo "$rowarch[nombre_arch] <BR>";
	}
	?></td>
  </tr>
  <tr>
    <td height="2"></td>
  </tr>
</table>
<BR><BR>
<?php 
if ($row['estado']==1){
?>
<table width="647" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="45%" height="53" > 
      <p><strong><font size="2" face="Arial, Helvetica, sans-serif">
       ARCHIVOS QUE FUERON ELIMINADOS CON EL MODULO</font></strong></p>
    </td>
    
  </tr>
</table>

<table width="647" border="1" align="center" cellspacing="0" >
  <tr bgcolor="#CCCCCC">
    <td width="100"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro. DE ARCHIVO</b></font></div></td>
    <td width="100"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>Nro. DE VERSION</b></font></div></td>
    <td width="450"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><b>NOMBRE DEL ARCHIVO</b></font></div></td>
  </tr>
<?php
$sql2 = "SELECT * FROM modulos_eliminados WHERE id_mod=$id_modu ";
$result2 = mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($result2);
$path_carpeta=$path_trash."/".$row2['nombre_mod_eli'];
$dir = opendir($path_carpeta);
while ($elemento = readdir($dir))
{ 
	$sql3 = "SELECT * FROM datos_archivos WHERE nombre_arch='$elemento' AND id_mod='$id_modu'";
	$result3 = mysql_db_query($db,$sql3,$link);
	$row3 = mysql_fetch_array($result3);
	if ($row3['id_arch']){
		echo "<tr align=\"center\">";
		echo "<td><font size=\"2\" face='arial'>$row3[id_arch]</font></td>";
		echo "<td><font size=\"2\" face='arial'>&nbsp;</font></td>";
		echo "<td><font size=\"2\" face='arial'>$row3[nombre_arch]</font></td>";
		echo "</tr>";
	}
	$sql4 = "SELECT * FROM versiones WHERE id_arch='$row3[id_arch]'";
	$result4 = mysql_db_query($db,$sql4,$link);
	while ($row4=mysql_fetch_array($result4)){
		echo "<tr align=\"center\">";
		echo "<td><font size=\"2\" face='arial'>$row3[id_arch]</font></td>";
		echo "<td><font size=\"2\" face='arial'>$row4[id_version]</font></td>";
		echo "<td><font size=\"2\" face='arial'>$row4[nombre_arch]</font></td>";
		echo "</tr>";
	}
}
?>
</table>
<?php
}
?>
<br>
<br>
</body>
</html>