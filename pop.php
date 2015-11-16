<?php
session_start();
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];

if (!isset($login)) {
	header("location: index.php"); 
}
include ("conexion.php");
?>
<?php 
$sql2 = "SELECT * FROM users WHERE login_usr='$login'";	
$result2 = mysql_db_query($db,$sql2,$link);
$row2 = mysql_fetch_array($result2);

$sqlcon = "SELECT Contratos FROM roles WHERE login_usr='$login'";	
$resultcon = mysql_db_query($db,$sqlcon,$link);
$rowcon = mysql_fetch_array($resultcon);

if ($row2[tipo2_usr]=="T" OR $row2[tipo2_usr]=="A" OR $row2[tipo2_usr]=="B")
{
	//NUMERO DE ORDENES TOTALES
	$sql1 = "SELECT DISTINCT(id_orden), MAX(id_asig) FROM asignacion WHERE asig='$login' GROUP BY id_orden";
	$rs1=mysql_db_query($db,$sql1,$link);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs1))  {			
		$sql1 = "SELECT id_orden, id_asig, asig FROM asignacion WHERE id_orden=$tmp[id_orden] ORDER BY id_asig DESC";
		$rsTmp=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
		if ($rsTmp["asig"]==$login) {
			$total[$numAsig]=$rsTmp[id_orden];
			$numAsig++;
		}
	}
	$row[0]=$numAsig;
	$row[numtot]=$numAsig;
	
	//NUMERO DE ORDENES CON SOLUCION
		$solu=0;
		for ($i=0; $i<$numAsig; $i++) {
			$sql3="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
			$row3 = mysql_fetch_array(mysql_db_query($db,$sql3,$link));
			if ($row3[id_orden]==$total[$i]) {
			$solu++;}
		}
		$row3[solu]=$solu;	
		
	//NUMERO DE ORDENES SIN SOLUCION
	if ($row[numtot]>$row3[solu])
		{$nosolu=$row[numtot]-$row3[solu];}
	else
		{$nosolu=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
		if ($rsTmp3[id_orden]==$total[$i]){
		$numConf++;}
	}
	$row5[conf]=$numConf;
 		
 	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	if ($row[numtot]>$row5[conf])
		{$noconf=$row[numtot]-$row5[conf];}
	else
		{$noconf=0;}
	//NUMERO DE ORDENES CON CONFORMIDAD DEL TECNICO
		//NUMERO TOTAL DE ORDENES
		$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
		$rs6=mysql_db_query($db,$sql6,$link);
		$numAsig=0;
		while ($tmp=mysql_fetch_array($rs6))  {			
				$total[$numAsig]=$tmp[id_orden];
				$numAsig++;
		}
		$row6[0]=$numAsig;
		$row6[numtot]=$numAsig;
	
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
		if ($rsTmp3[id_orden]==$total[$i]){
		$numConf++;}
	}
	$row7[conftec]=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL TECNICO
	$noconftec=$row6[numtot]-$row7[conftec];
	
}
else
{
	//NUMERO TOTAL DE ORDENES
	$sql6 = "SELECT DISTINCT(id_orden) FROM ordenes,users WHERE ordenes.cod_usr=users.login_usr AND users.login_usr='$login'";
	$rs6=mysql_db_query($db,$sql6,$link);
	$numAsig=0;
	while ($tmp=mysql_fetch_array($rs6))  {			
			$total[$numAsig]=$tmp[id_orden];
			$numAsig++;
	}
	$row6[0]=$numAsig;
	$row6[numtot]=$numAsig;
	
	//NUMERO DE ORDENES CON SOLUCION
	$solu=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql4="SELECT id_orden FROM solucion WHERE id_orden='$total[$i]'";
		$row4 = mysql_fetch_array(mysql_db_query($db,$sql4,$link));
		if ($row4[id_orden]==$total[$i]) {
		$solu++;}
	}
	$row8[solu]=$solu;	
	
	//NUMERO DE ORDENES SIN SOLUCION
	$nosolu=$row6[numtot]-$row8[solu];
	
	//NUMERO DE ORDENES CON CONFORMIDAD DEL CLIENTE
	$numConf=0;
	for ($i=0; $i<$numAsig; $i++) {
		$sql = "SELECT id_orden FROM conformidad WHERE id_orden='$total[$i]'";
		$rsTmp3=mysql_fetch_array(mysql_db_query($db,$sql,$link));
		if ($rsTmp3[id_orden]==$total[$i]){
		$numConf++;}
	}
	$row9[conf]=$numConf;
	
	//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
	$noconf=$row6[numtot]-$row9[conf];
}
	//NUMERO DE DÍAS DE ALERTA PARA CONTRATOS
	$sqlcont="SELECT tmp_alert FROM control_parametros";
	$resultcont=mysql_db_query($db,$sqlcont,$link);
	$rowcont=mysql_fetch_array($resultcont);
?>
<?php 
		echo "<table background=\"images/fondo.jpg\" width=\"100%\" border=\"1\" cellspacing=\"0\" align=\"center\">";
		echo "<tr>";
		if ($row2[tipo2_usr]=="T" OR $row2[tipo2_usr]=="A" OR $row2[tipo2_usr]=="B")
	{
		echo "<td width=\"70%\" align=\"right\"><font color=\"#006699\" size=3><b>Usuario: </b></font></td><td width=\"18%\" align='center'><font size=3><b>".$row2[login_usr]."</b></font></td></tr>";
		echo "<tr><td width=\"18%\" align=\"right\"><font color=\"006699\" size=3><b>Pendientes de solucion: </b></font></td><td width=\"18%\" align='center'><font size=3><b>".$nosolu."</b></font></td></tr>";
		echo "<tr><td width=\"30%\" align=\"right\"><font color=\"006699\" size=3><b>Pendientes de conformidad del cliente: </b></font></td><td width=\"30%\" align='center'><font size=3><b>".$noconf."</b></font></td></tr>";
		if ($row2[tipo2_usr]=="A" OR $row2[tipo2_usr]=="B")
		echo "<tr><td width=\"35%\"align=\"right\"><font color=\"006699\" size=3><b>Pendientes de conformidad del administrador: </b></font></td><td width=\"35%\"align='center'><font size=3><b>".$noconftec."</b></font></td></tr>";
		if ($row2[tipo2_usr]=="T")
		echo "<tr><td width=\"35%\"align=\"right\"><font color=\"006699\" size=3><b>Pendientes de conformidad del tecnico: </b></font></td><td width=\"35%\"align='center'><font size=3><b>".$noconftec."</b></font></td><tr>";
	}
	else
	{
		echo "<tr><td width=\"20%\" align=\"right\"><font color=\"#006699\" size=3><b>Usuario: </b></font></td><td width=\"20%\" align='center'><font size=3><b>".$row2[login_usr]."</b></font></td></tr>";
		echo "<tr><td width=\"40%\" align=\"right\"><font color=\"006699\" size=3><b>Ordenes de trabajo pendientes de solucion: </b></font><td width=\"40%\" align='center'><font size=3><b>".$nosolu."</b></font></td></td></tr>";
		echo "<tr><td width=\"40%\"align=\"right\"><font color=\"006699\" size=3><b>Ordenes de trabajo pendientes de conformidad: </b></font></td><td width=\"40%\"align='center'><font size=3><b>".$noconf."</b></font></td><tr>";
	}
	?>
<html>
<head>
<title>GesTor F1</title>
</head>
<?php
if ($rowcon[Contratos]=="r"){
?>	
<table background="images/fondo.jpg" width="100%" border="1" cellspacing="0" align="center">
  <tr> 
    <td height="22" colspan="2" align="center" bgcolor="#006699"><div align="left"><font color="#FFFFFF" size=2 face="Arial, Helvetica"><b>Contratos 
        por vencer :</b></font></div></td>
  </tr>
  <tr> 
    <td width="30%" align="center" bgcolor="#006699" face="Arial, Helvetica"><font color="#FFFFFF" size=2 face="Arial, Helvetica"><b>N&ordm; 
      de Contrato</b></font></td>
    <td width="70%" align="center" bgcolor="#006699" face="Arial, Helvetica"><font color="#FFFFFF" size=2 face="Arial, Helvetica"><b>Fecha de expiraci&oacute;n</b></font></td>
  </tr>
  <?php
  $sql="SELECT IdContra, FechAl FROM contratodatos WHERE FechAl BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL $rowcont[tmp_alert] DAY) ORDER BY FechAl";
  $result=mysql_db_query($db,$sql,$link);
  while($row=mysql_fetch_array($result)){
  echo "<tr> 
    <td align='center'>$row[IdContra]</td>
    <td align='center'>$row[FechAl]</td>
  	</tr>";
  }}
  ?>
</table>
</html>