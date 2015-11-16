<?php include ("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - RESUMEN GLOBAL DE CONTRATOS</title>
<style type="text/css">
<!--
td {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
}
.style1 {
	font-size: 11px;
	font-weight: bold;
}
.style4 {font-size: 11px}
-->
</style>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">RESUMEN GLOBAL DE CONTRATOS</font></u></b></div></td>
  </tr>
</table>
<br>

<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699">
  <tr> 
    <td height="68" valign="top"><table width="100%" border="1" align="center" cellpadding="0" cellspacing="2">
        <tr align=\"center\" bgcolor="#CCCCCC"> 
          <th width="51" height="14"><span class="style4"><font color="#000000" face="Arial, Helvetica, sans-serif">Nro. CONTRATO</font></span></th>
		  <th width="182" height="14"><span class="style4"><font color="#000000" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></span></th>
          <th width="58"><span class="style4"><font face="Arial, Helvetica, sans-serif" color="#000000">CODIGO</font></span></th>
          <th width="83"><span class="style4"><font color="#000000" face="Arial, Helvetica, sans-serif">PLAZO</font></span></th>
          <th width="62" colspan="1"><span class="style4"> 
            <font color="#000000" face="Arial, Helvetica, sans-serif"><strong>FECHA VENC.</strong></font></span></th>
          <th width="35"><span class="style4"><font color="#000000" face="Arial, Helvetica, sans-serif"><strong>FASES</strong></font></span></th>
          <th width="47"><span class="style4"><font color="#000000" face="Arial, Helvetica, sans-serif"><strong>GARANTIA</strong></font></span></th>
          <th width="70"><span class="style1"><font color="#000000" face="Arial, Helvetica, sans-serif">VENC. PLAZO</font></span></th>
          <th width="142"><span class="style1"><font color="#000000" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></span></th>
        </tr>
        <?php
$sql = "SELECT *, DATE_FORMAT(FechDe, '%d/%m/%Y') AS FechDe, DATE_FORMAT(FechAl,'%d/%m/%Y') as FechAl FROM contratodatos ORDER BY IdContra ASC";
$result=mysql_db_query($db,$sql,$link); 
while ($row=mysql_fetch_array($result)) {

  	echo "<tr align=\"center\">";
	echo "<td><font size=\"1\">&nbsp;$row[IdContra]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[TipoContra]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[CodLegalContra]</font></td>";
	$a1=substr($row['FechDe'],6,4);
	$m1=substr($row['FechDe'],3,2);
	$d1=substr($row['FechDe'],0,2);
	$a2=substr($row['FechAl'],6,4);
	$m2=substr($row['FechAl'],3,2);
	$d2=substr($row['FechAl'],0,2);
	$d3=$d2-$d1; $m3=$m2-$m1; $a3=$a2-$a1;
	if ($a3 >= "0") 
		{if ($m3 >= "0")
	 		{if ($d3 >= "0")
			    {$a3=$a3;
				 $m3=$m3;
				 $d3=$d3;}
			 elseif ($d3<"0") 
			 	{$m3=$m3-1; $d3=30+$d3;
				 if ($m3 < "0"){$a3=$a3-1; $m3=12+$m3;}}}
		else {$a3=$a3-1; $m3=12+$m3;
				if ($d3 >= "0"){
				 $a3=$a3;
				 $m3=$m3;
				 $d3=$d3;}	}}
	else
	 			{$a3="0";
				 $m3="0";
				 $d3="0";}
	if ($a3<>"0") {$a3=$a3."Ano ";} else {$a3="";}
	if ($m3<>"0") {$m3=$m3."Meses ";} else {$m3="";}
	if ($d3<>"0") {$d3=$d3."Dias";} else {$d3="";}
	echo "<td><font size=\"1\">&nbsp;$a3$m3$d3</font></td>";
	echo "<td><font size=\"1\">$row[FechAl]</font></td>";
	$sql1 = "SELECT MAX(Fase) AS Fas FROM contratofases WHERE IdContra='$row[IdContra]'";
	$result1=mysql_db_query($db,$sql1,$link); 
	$row1=mysql_fetch_array($result1); 
	echo "<td><font size=\"1\">&nbsp;$row1[Fas]</font></td>";
	$G=0;
	$sql2 = "SELECT * FROM contratofases WHERE IdContra='$row[IdContra]'";
	$result2=mysql_db_query($db,$sql2,$link); 
	while ($row2=mysql_fetch_array($result2))
	{ if ($row2['Garantia']<>"")  {$G=$G+1;}}
  		if  ($G>="1") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}
  		elseif ($G>="0"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
	$sql3 = "SELECT DATE_FORMAT(MAX(VencPlazo),'%d / %m / %Y') as FP FROM contratofases WHERE IdContra='$row[IdContra]'";
	$result3=mysql_db_query($db,$sql3,$link); 
	$row3=mysql_fetch_array($result3); 
	echo "<td><font size=\"1\">&nbsp;$row3[FP]</font></td>";
	echo "<td><font size=\"1\">&nbsp;$row[ObsContra]</font></td>";
}?>
      </table></td>
  </tr>
</table>
</body>
</html>    