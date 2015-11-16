<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
include("top_ver.php");
$idana=($_GET['variable']);
$sql="SELECT *,DATE_FORMAT(FechaAnalisis,'%d / %m / %Y') as FechaAnalisis FROM analisisriesgdatos WHERE IdAnalisis='$idana'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - PROYECTOS</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong> PROYECTOS : ANALISIS 
        DE RIESGO</strong></u></font></div></td>
  </tr>
</table>


<br>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="188" ><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL PROYECTO : </strong></font></td>
    <td width="196"><?php echo $row['NombProy']; ?></td>
    <td width="253">&nbsp;&nbsp;&nbsp; </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    
  </tr>
</table>

<br>
<table  width="638" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="199"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NOMBRE 
      DEL RESPONSABLE :</strong> </font></td>
    <td width="187"><?php
	$sql3="SELECT * FROM users WHERE login_usr='$row[NombResp]'";
	$result3=mysql_query($sql3);
	$row3=mysql_fetch_array($result3);
	echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr'];
	?></td>
    <td width="252">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
   
  </tr>
</table>
<br>
<table  width="637" height="23" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="156"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA DE 
      ANALISIS : </strong></font></td>
    <td width="122"><?php echo $row['FechaAnalisis'];?></td>
    <td width="359">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    
  </tr>
</table>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="240"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION 
      DE REFERENCIA :</strong> </font></td>
    <td width="397"><?php echo $row['DocuRef'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="195"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
      DEL IMPACTO :</strong> </font></td>
    <td width="407"><?php echo $row['DescImpacto'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="289"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ACCIONES 
      PREVENTIVAS RECOMENDADAS :</strong> </font></td>
    <td width="356"><?php echo $row['AccionPrev'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="314"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ACCIONES DE CONTINGENCIA RECOMENDADAS :</strong> </font></td>
    <td width="323"><?php echo $row['AccionConting'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="222"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION 
      DE SOPORTE :</strong> </font></td>
    <td width="415"><?php echo $row['DocuSoporte'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>



<br>
<table width="85%" border="1" align="center">
  <tr bgcolor="#CCCCCC"> 
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NUMERO</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
        DEL RIESGO</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PROBABILIDAD 
        DE RIESGO</strong></font></div></th>
    <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>IMPACTO</strong></font></div></th>
  </tr>
  <?php
$sql2="SELECT * FROM analisisriesgdesc WHERE IdAnalisis='".$row['IdAnalisis']."'";
$result2=mysql_query($sql2);
while($row2=mysql_fetch_array($result2))
{
	echo"<tr align=\"center\">";
	echo '<td align="center"><font size="1"> &nbsp;'.$row2['IdDescripcion'].'</font></td>';
	echo '<td align="center"><font size="1"> &nbsp;'.$row2['Descripcion'].'</font></td>';
	echo '<td align="center"><font size="1"> &nbsp;'.$row2['Probabilidad'].'</font></td>';
	echo '<td align="center"><font size="1"> &nbsp;'.$row2['Impacto'].'</font></td>';
	echo "</tr>";
}

?>
</table>
<p>&nbsp;</p>
</body>
</html>