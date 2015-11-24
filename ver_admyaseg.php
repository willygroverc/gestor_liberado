<?php
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
$idadmy=($_GET['variable']);
$Tip=($_GET['Tipo']);
$sql="SELECT *,DATE_FORMAT(FechaAdAs,'%d / %m / %Y') as FechaAdAs FROM admyasegdatos WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>

<head>
<title> GesTor F1 - GESTION-PRODAT - PROYECTOS</title>
<link rel="stylesheet" href="css/skeleton.css">
<link rel="stylesheet" href="css/reports.css">
</head>
<body>
  <div class="container">
    <?php include("datos_gral.php"); ?>
    <div class="print-area">
      <div class="row center">
        <h5>Proyectos - Lista de Administración y Aseguramiento</h5>
      </div>
      <br>
      <h6>Administración del Alcance</h6>
      <div class="row">
        <div class="column">
          <strong>Nombre del Proyecto: </strong><?php echo $row['NombProy']; ?>
        </div>
      </div>
      <div class="row">
        <div class="column">
          <strong>Nombre del Responsable: </strong>
          <?php
          $sql3="SELECT * FROM users WHERE login_usr='".$row['NombResp']."'";
          $result3=mysql_query($sql3);
          $row3=mysql_fetch_array($result3);
          echo $row3['nom_usr']." ".$row3['apa_usr']." ".$row3['ama_usr'];  
          ?>
        </div>
      </div>
    </div> <!-- end print-area -->
  </div>



<br>

<?php 
$sqlUsers="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users ORDER BY login_usr";
$rsUsers=mysql_query($sqlUsers);
while($tmpUsers=mysql_fetch_array($rsUsers)){
	$lstUsers[$tmpUsers['login_usr']]=$tmpUsers['nom_usr']." ".$tmpUsers['apa_usr']." ".$tmpUsers['ama_usr'];
}

if ($row['Tipo']=="ADMINISTRACION DE RECURSOS HUMANOS")
	{
	echo "<table width=\"85%\" border=\"1\" align=\"center\">";
  	echo "<tr align=\"center\">";
    echo "<td rowspan=\"2\"><strong>NUMERO</strong></td>";
    echo "<td rowspan=\"2\"><strong>ACTIVIDAD /PRODUCTOS</strong></td>";
    echo "<td rowspan=\"2\"><strong>RESPONSABLES</strong></td>";
    echo "<td rowspan=\"2\"><strong>CRONOGRAMAS</strong></td>";
    echo "<td colspan=\"2\"><strong>CUMPLIMIENTO</strong></td>";
	echo "</tr>";
	echo "<tr align=\"center\">"; 
    echo "<td><strong>SI</strong></td>";
    echo "<td><strong>NO</strong></td>";
    echo "<td><strong>OBSERVACIONES</strong></td>";
	echo "</tr>";
$sql6 = "SELECT * FROM admrhdet WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
$result6=mysql_query($sql6); 
while ($row6=mysql_fetch_array($result6)) 
{
  	echo "<tr align=\"center\">";
 	echo '<td align="center">&nbsp;'.$row6['num_det'].'</td>';
 	echo '<td align="center">&nbsp;'.$row6['activprod'].'</td>';
 	echo "<td align=\"center\">&nbsp;".$lstUsers[$row6['nombresp']]."</td>";
 	echo '<td align="center">&nbsp;'.$row6['cronograma'].'</td>';
	if ($row6['cumplimiento']=="SI")
	{echo "<td align=\"center\"><img src=\"images/si1.gif\" border=\"1\"></td>";}
	else
	{echo "<td align=\"center\"><img src=\"images/no1.gif\" border=\"1\"></td>";}
	if ($row6['cumplimiento']=="NO")
	{echo "<td align=\"center\"><img src=\"images/si1.gif\" border=\"1\"></td>";}
	else
	{echo "<td align=\"center\"><img src=\"images/no1.gif\" border=\"1\"></td>";}
 	echo '<td align="center">&nbsp;'.$row6['observaciones'].'</td>';
	echo "</tr>";
}
}
else
{
	echo "</table>";
	echo "<table width=\"85%\" border=\"1\" align=\"center\">";
  	echo "<tr align=\"center\">";
    echo "<td colspan=\"2\"><strong><font size=\"2\" face=\"Arial, Helvetica, sans-serif\">"; 
    if($row['Tipo']=="ADMINISTRACION DEL ALCANCE")
	{echo "ALCANCE";}
	else
	{echo "OBJETIVOS";}
	echo "</font></strong></div></td>";
	echo "</tr>";
 echo "<tr align=\"center\">";
    echo "<td width=\"10%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>NUMERO</strong></font></td>";
    echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>DESCRIPCION</strong></font></td>";
  echo "</tr>";
$sql2 = "SELECT * FROM admyasegalcance WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
$result2=mysql_query($sql2); 
while ($row2=mysql_fetch_array($result2)) 
{
  	echo "<tr align=\"center\">";
 	echo '<td align="center">&nbsp;'.$row2['IdAlcance'].'</td>';
 	echo '<td align="center">&nbsp;'.$row2['Alcance'].'</td>';
	echo "</tr>";
}
echo "</table>";
echo "<br>";
echo "<table width=\"85%\" border=\"1\" align=\"center\">";
echo "<tr align=\"center\"> ";
echo "<td width=\"10%\"><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>NUMERO</strong></font></td>";
echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>ACTIVIDADES</strong></font></td>";
echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>RESPONSABLES</strong></font></td>";
echo "<td><font size=\"2\" face=\"Arial, Helvetica, sans-serif\"><strong>";
	if($row['Tipo']=="ADMINISTRACION DEL ALCANCE")
	{echo "SEGUIMIENTO";}
	if($row['Tipo']=="ADMINISTRACION DE LA COMUNICACION")
	{echo "SEGUIMIENTO";}
	if($row['Tipo']=="ASEGURAMIENTO DE LA CALIDAD")
	{echo "MÉTRICAS";}
echo "</strong></font></div></td>";
echo "</tr>";
$sql3 = "SELECT * FROM admyasegactiv WHERE IdAdmyAseg='$idadmy' AND Tipo='$Tip'";
$result3=mysql_query($sql3); 
	while ($row3=mysql_fetch_array($result3)){
		echo "<tr align=\"center\">";
		echo '<td>&nbsp;'.$row3['IdActividad'].'</td>';
		echo '<td>&nbsp;'.$row3['Actividad'].'</td>';
		$sql5="SELECT * FROM users WHERE login_usr='".$row3['RespActividad']."'";
		$result5=mysql_query($sql5);
		$row5=mysql_fetch_array($result5);
		echo @$row3['nom_usr']." ".@$row3['apa_usr']." ".@$row3['ama_usr'];
		echo '<td>&nbsp;'.$row5['nom_usr'].' '.$row5['apa_usr'].' '.$row5['ama_usr'].'</td>';
		echo '<td>&nbsp;'.$row3['Seguimiento'].'</td>';
		echo "</tr>";
	}
}
?>

</table>
<br>
<table  width="564" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="237"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION DE REFERENCIA : </strong></font></td>
    <td width="327"><?php echo $row['DocuRef'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="560" height="24" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="226"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DOCUMENTACION DE SOPORTE:</strong></font></td>
    <td width="340"><?php echo $row['DocuSoporte'];?></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<br>
<table  width="563" height="25" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="61"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FIRMA:</strong></font></td>
    <td width="283"> </td>
    <td width="64"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA:</strong></font></td>
    <td width="155"><?php echo $row['FechaAdAs'];?></td>

  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<p></p>
</body>
</html>