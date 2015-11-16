<?php
include ("top_ver.php");
$id_pru=($_GET['id_pru']);
$orden=($_GET['ord_ayu']); 
$sql = "SELECT *, DATE_FORMAT(fecpru, '%d/%m/%Y') AS fecpru FROM pruebrecup  WHERE ord_ayu='$orden' ";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - CONTINGENCIA - EJECUCIÓN</title>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>PRUEBAS 
        DE RECUPERACION / PLAN DE CONTINGENCIA</u></font></strong></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="191"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>No 
        DE ORDEN DE MESA : </strong></font></p>
    </td>
    <td width="446"><p>&nbsp;<?php echo $row[ord_ayu];?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="245"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>No DE 
        PRUEBA DE RECUPERACION : </strong></font></p>
    </td>
    <td width="392"><p><?php echo $row[id_pru] ?>&nbsp;</p> </td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="158"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>RECURSO 
        PROBADO: </strong></font></p>
    </td>
    <td width="182"><p><?php echo $row[serpro] ?>&nbsp;</p> </td>
    <td width="183"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong> &nbsp;SITIO DE CONTINGENCIA : </strong></font></p>
    </td>
    <td width="114"><p><?php echo $row[sitconti] ?>&nbsp;</p> </td>

  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>

<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="14%"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA:</strong></font></p></td>
    <td width="86%">&nbsp; <?php echo $row[fecpru] ?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table width="83%" border="1" align="center">
  <tr bgcolor="#CCCCCC"> 
    <td width="18%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">RESPONSABLES 
    / ACTIVIDADES</font></strong></font></div></td>
    <td width="21%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">NOMBRES 
    Y APELLIDOS(RAZON SOCIAL)</font></strong></font></div></td>
    <td width="14%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FECHA 
    Y HORA DE INICIO</font></strong></font></div></td>
    <td width="14%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">FECHA 
    Y HORA DE CONCLUSION</font></strong></font></div></td>
    <td width="14%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">RESULTADOS</font></strong></font></div></td>
    <td width="23%"><div align="center"><font size="2"><strong><font face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></font></div></td>
  </tr>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">COMUNICACION 
        A RESPONSABLES INTERNOS</font></strong></div></td>
  </tr>
  <?php 
$sql2 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='1'"; //here1
$result2=mysql_db_query($db,$sql2,$link);
while ($row2=mysql_fetch_array($result2)) 
{
	$consul3="SELECT * FROM users WHERE login_usr='$row2[nombresin]'";
	$resul3=mysql_db_query($db,$consul3,$link);
	$fila3=mysql_fetch_array($resul3);
	if($row2)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row2[resact]</font></td>";
	if($fila3)
	{echo "<td><font size=\"2\">&nbsp;$fila3[nom_usr]&nbsp;$fila3[apa_usr]&nbsp;$fila3[ama_usr]</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row2[nombresin] </font></td>";} //HERE2
	echo "<td><font size=\"2\">&nbsp;$row2[fechain]&nbsp; $row2[horain]</font></td>";
	if($row2[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUIDO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row2[fechacon]&nbsp;$row2[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row2[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row2[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">COMUNICACION 
        A RESPONSABLES EXTERNOS</font></strong></div></td>
  </tr>
  <?php
$sql3 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='2'"; //HERE
$result3=mysql_db_query($db,$sql3,$link);
while ($row3=mysql_fetch_array($result3)) 
{
	$consul4="SELECT * FROM proveedor WHERE IdProv='$row3[nombresin]'";
	$resul4=mysql_db_query($db,$consul4,$link);
	$fila4=mysql_fetch_array($resul4);
	if($row3)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row3[resact]&nbsp;$row3[tipo2]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila4[NombProv]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row3[fechain] &nbsp; $row3[horain]</font></td>";
	if($row3[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUIDO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row3[fechacon]&nbsp;$row3[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row3[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row3[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROVISION 
        DE HARDWARE REQUERIDO</font></strong></div></td>
  </tr>
  <?php   
$sql4 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='3'";  //HERE4
$result4=mysql_db_query($db,$sql4,$link);
while ($row4=mysql_fetch_array($result4)) 
{
	$consul5="SELECT * FROM datfichatec WHERE IdFicha='$row4[nombresin]'";
	$resul5=mysql_db_query($db,$consul5,$link);
	$fila5=mysql_fetch_array($resul5);
	if($row4)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row4[resact] </font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila5[Modelo]&nbsp;$fila5[AdicUSI]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row4[fechain] &nbsp; $row4[horain]</font></td>";
	if($row4[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUIDO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row4[fechacon]&nbsp;$row4[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row4[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row4[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PROVISION 
        DE INSTALADORES DE SOFTWARE Y BASES DE DATOS</font></strong></div></td>
  </tr>
  <?php 
$sql5 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='4'";
$result5=mysql_db_query($db,$sql5,$link);
while ($row5=mysql_fetch_array($result5)) 
{
	$consul6="SELECT * FROM sistemas WHERE Id_Sistema='$row5[nombresin]'";
	$resul6=mysql_db_query($db,$consul6,$link);
	$fila6=mysql_fetch_array($resul6);
	if($row5)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row5[resact]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila6[Descripcion]&nbsp;</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row5[fechain] &nbsp; $row5[horain]</font></td>";
	if($row5[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row5[fechacon]&nbsp;$row5[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row5[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row5[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">INSTALACION 
        DE SOFTWARE BASE</font></strong></div></td>
  </tr>
  <?php
$sql6 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='5'";  //HERE6
$result6=mysql_db_query($db,$sql6,$link);
while ($row6=mysql_fetch_array($result6)) 
{
	$consul7="SELECT * FROM sistemas WHERE Id_Sistema='$row6[nombresin]'";
	$resul7=mysql_db_query($db,$consul7,$link);
	$fila7=mysql_fetch_array($resul7);
	if($row6)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row6[resact]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila7[Descripcion]&nbsp;</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row6[fechain] &nbsp; $row6[horain]</font></td>";
	if($row6[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row6[fechacon]&nbsp;$row6[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row6[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row6[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">INSTALACION 
        DE APLICACIONES</font></strong></div></td>
  </tr>
  <?php
$sql7 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		 FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='6'";
$result7=mysql_db_query($db,$sql7,$link);
while ($row7=mysql_fetch_array($result7)) 
{
	$consul8="SELECT * FROM sistemas WHERE Id_Sistema='$row7[nombresin]'";
	$resul8=mysql_db_query($db,$consul8,$link);
	$fila8=mysql_fetch_array($resul8);
	if($row7)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row7[resact]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila8[Descripcion]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row7[fechain] &nbsp; $row7[horain]</font></td>";
	if($row7[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row7[fechacon]&nbsp;$row7[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row7[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row7[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESTAURACION 
        DE BASE DE DATOS </font></strong></div></td>
  </tr>
  <?php
$sql8 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='7'"; // HERE 7
$result8=mysql_db_query($db,$sql8,$link);
while ($row8=mysql_fetch_array($result8)) 
{
	$consul9="SELECT * FROM sistemas WHERE Id_Sistema='$row8[nombresin]'";
	$resul9=mysql_db_query($db,$consul9,$link);
	$fila9=mysql_fetch_array($resul9);
	if($row8)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row8[resact]</font></td>"; //HERE
	echo "<td><font size=\"2\">&nbsp;$fila9[Descripcion]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row8[fechain]&nbsp; $row8[horain]</font></td>";
	if($row8[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row8[fechacon]&nbsp;$row8[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row8[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row8[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PRUEBAS 
        INTERNAS </font></strong></div></td>
  </tr>
  <?php
$sql9 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='8'";  //here8
$result9=mysql_db_query($db,$sql9,$link);
while ($row9=mysql_fetch_array($result9)) 
{
	$consul10="SELECT * FROM users WHERE login_usr='$row9[nombresin]'";
	$resul10=mysql_db_query($db,$consul10,$link);
	$fila10=mysql_fetch_array($resul10);
	if($row9)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row9[resact]</font></td>";
	if($fila10)
	{echo "<td><font size=\"2\">&nbsp;$fila10[nom_usr]&nbsp;$fila10[apa_usr]&nbsp;$fila10[ama_usr]</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row9[nombresin]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row9[fechain] &nbsp; $row9[horain]</font></td>";
	if($row9[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row9[fechacon]&nbsp;$row9[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row9[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row9[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
  <tr> 
    <td colspan="6"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">PRUEBAS 
        DE USUARIO </font></strong></div></td>
  </tr>
  <?php
$sql10 = "SELECT *, DATE_FORMAT(fechain, '%d/%m/%Y') AS fechain, DATE_FORMAT(fechacon, '%d/%m/%Y') AS fechacon 
		FROM pruebrecuptipo WHERE id_pru='$row[id_pru]' AND id_tipopru='9'";  //here9
$result10=mysql_db_query($db,$sql10,$link);
while ($row10=mysql_fetch_array($result10)) 
{
	$consul11="SELECT * FROM users WHERE login_usr='$row10[nombresin]'";
	$resul11=mysql_db_query($db,$consul11,$link);
	$fila11=mysql_fetch_array($resul11);
	if($row10)
	{echo "<tr align=\"center\">";
	echo "<td><font size=\"2\">&nbsp;$row10[resact]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$fila11[nom_usr]&nbsp;$fila11[apa_usr]&nbsp;$fila11[ama_usr]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row10[fechain] &nbsp; $row10[horain]</font></td>";
	if($row10[fechacon]=="0000-00-00")
	{echo "<td><font size=\"2\">&nbsp;NO CONCLUDIO</font></td>";}
	else
	{echo "<td><font size=\"2\">&nbsp;$row10[fechacon]&nbsp;$row10[horacon]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row10[resulresin]</font></td>";
	echo "<td><font size=\"2\">&nbsp;$row10[obsresin]</font></td>";
	echo "</tr>";
	}
}
?>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="131"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
        DE APC :</strong></font></p>
    </td>
    <td width="312"><p>
	<?php 
	$consul1="SELECT * FROM users WHERE login_usr='$row[nomapc]'";
	$res1=mysql_db_query($db,$consul1,$link);
	$fila1=mysql_fetch_array($res1);
	echo $fila1[nom_usr]."&nbsp;".$fila1[apa_usr]."&nbsp;".$fila1[ama_usr]; ?>&nbsp;</p> </td>
    <td width="70"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp; FIRMA : </strong></font></p>
    </td>
    <td width="124"><p>&nbsp;</p> </td>

  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="194"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
        DEL EVALUADOR :</strong></font></p>
    </td>
    <td width="250"><p>
	<?php 
	$consul2="SELECT * FROM users WHERE login_usr='$row[nomeval]'";
	$res2=mysql_db_query($db,$consul2,$link);
	$fila2=mysql_fetch_array($res2);
	
	echo $fila2[nom_usr]."&nbsp;".$fila2[apa_usr]."&nbsp;".$fila2[ama_usr] ?>
	 &nbsp;</p> </td>
    <td width="69"><p><font size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp; FIRMA : </strong></font></p>
    </td>
    <td width="124"><p>&nbsp;</p> </td>

  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>
</body>
</html>
