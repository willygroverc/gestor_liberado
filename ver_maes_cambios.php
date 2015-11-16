<?php
include ("top_ver.php");
require_once('funciones.php');
$orden=SanitizeString($_GET['orden']);
$sql = "SELECT *, DATE_FORMAT(fechaprog, '%d/%m/%Y') AS fechaprog, DATE_FORMAT(fechareal, '%d/%m/%Y') AS fechareal FROM maestro WHERE num_orden='$orden' ";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
$sql1 = "SELECT desc_inc, cod_usr FROM ordenes WHERE id_orden='$orden' ";
$result1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($result1);
$sql2 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row1[cod_usr]' ";
$result2=mysql_db_query($db,$sql2,$link);
$row2=mysql_fetch_array($result2);
$solic=$row2['nom_usr']." ".$row2['apa_usr']." ".$row2['ama_usr'];
?>
<html>
<head>
<title> GesTor F1 - CAMBIOS-PROACP - MAESTRO DE CAMBIOS </title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u><strong>MAESTRO 
        DE CAMBIOS</strong></u></font></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="160" height="19"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ORDEN 
        N&deg; :</strong></font></p></td>
    <td width="95"><p>&nbsp;<?php echo $orden;?></p></td>
    <td width="382">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="25%" height="18"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>CAMBIO 
        N&deg; :</strong></font></p></td>
    <td width="15%">&nbsp; <?php echo "$row[num_cambio]";?> </td>
    <td width="60%">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" height="22"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>INCIDENCIA:</strong></font></p>
    </td>
    <td width="75%"><p>&nbsp;<?php echo $row1['desc_inc'];?></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" height="19">
<p><font size="2" face="Arial, Helvetica, sans-serif"><strong>SOLICITANTE :</strong></font></p>
    </td>
    <td width="75%"><p>&nbsp;<?php echo $solic;?></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="29%" height="19" valign="top"> <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
        DEL CAMBIO:</strong></font></p></td>
    <td width="71%"><p><?php echo $row['desc_cambio'];?>&nbsp;&nbsp;</p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="25%" height="19"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        PROGRAMADA :</strong></font></p></td>
    <td width="23%"><p>&nbsp;<?php echo $row['fechaprog'];?></p></td>
    <td width="12%">&nbsp;</td>
    <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
      REAL :</strong></font></td>
    <td width="23%"><?php echo $row['fechareal'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="25%" height="19"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PRIORIDAD 
      :</strong></font></td>
    <td width="23%"> &nbsp; 
      <?php if ($row['prioridad']=="1"){echo "(1) Alto";}
	     elseif ($row['prioridad']=="2"){echo "(2) Medio";}
		 elseif ($row['prioridad']=="3"){echo "(3) Bajo";} 
	  ?>
    </td>
    <td width="12%"><div align="right"> </div></td>
    <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NIVEL 
      :</strong></font></td>
    <td width="23%"> &nbsp; 
      <?php if ($row['nivel']=="1"){echo "(1) Alto";}
	     elseif ($row['nivel']=="2"){echo "(2) Medio";}
		 elseif ($row['nivel']=="3"){echo "(3) Bajo";} 
	  ?>
    </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td></td>
    <td></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="25%" height="19"> 
      <p><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES 
        :</strong></font></p>
    </td>
    <td width="75%"><p><?php echo $row['observaciones'];?>&nbsp;</p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
</body>
</html>