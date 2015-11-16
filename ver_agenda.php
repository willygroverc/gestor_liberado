<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
include ("top_ver.php");
require ("conexion.php");
$idage=($_GET['variable']);
$sql = "SELECT *,DATE_FORMAT(en_fecha,'%d / %m / %Y') as en_fecha,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha 
FROM agenda  WHERE id_agenda='$idage' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - ACTAS</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font color="#000000" size="4" face="Arial, Helvetica, sans-serif"><u>AGENDA 
        DE REUNION</u></font></strong></div></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="67"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO :</strong></font></p>
      </td>
    <td width="295"><p>&nbsp;
	<?php 
	echo "$row[codigo]";
	/*if($row[codigo]=="CSI"){echo "$row[codigo] (Comite de Sistemas)";}
	elseif($row[codigo]=="CCP"){echo "$row[codigo] (Comite de Cambios en Prod.)";}
	elseif($row[codigo]=="CRC"){echo "$row[codigo] (Comite de Recup. y Conting.)";}
	elseif($row[codigo]=="OTRO"){echo "$row[codigo]";}*/
	?></p> </td>
    </td>
    <td width="76"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NRO. :
      </strong></font></td>
    <td width="203"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['num_codigo'];?></font></p></td>
			
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
    <td width="126"> <p align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ELABORADO 
        POR :</strong></font></p></td>
    <td width="232"> 
      <?php 
	$consul="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
	$resul=mysql_query($consul);
	$fila=mysql_fetch_array($resul);
	echo "<font size=\"2\" face='Arial, Helvetica, sans-serif'>";	
	echo $fila['nom_usr']."&nbsp;".$fila['apa_usr']."&nbsp;".$fila['ama_usr'];
	echo "</font>";
	?>
      </td>
    <td width="76"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EN 
      FECHA :</strong></font></td>
    <td width="203"><p><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['en_fecha'];?></font></p></td>
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
    <td width="260"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TIPO 
      DE REUNION: </strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;ORDINARIA</strong></font> 
      <?php 
	if ($row['tipo_reu']=="Ordinaria")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="151"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EXTRAORDINARIA:</strong></font> 
      <?php 
	if ($row['tipo_reu']=="Extraordinaria")	
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="95"><font size="2" face="Arial, Helvetica, sans-serif"><strong>EMERGENCIA</strong></font><strong>:&nbsp;</strong></td>
    <td width="39">&nbsp;
	<?php 
	if ($row['tipo_reu']=="Emergencia")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
	</td>
    <td width="82"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OTROS:</strong></font> 
      <?php 
	if ($row['tipo_reu']=="Otros")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="55"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
      :</strong></font></td>
    <td width="139"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['fecha'];?>&nbsp;</font></td>
    <td width="45"><font size="2" face="Arial, Helvetica, sans-serif"><strong>HORA 
      :</strong></font></td>
    <td width="97"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['hora']; ?>&nbsp;</font></td>
    <td width="54"><font size="2" face="Arial, Helvetica, sans-serif"><strong>LUGAR 
      :</strong></font></td>
    <td width="247"><font size="2" face="Arial, Helvetica, sans-serif"><?php 
	echo "<font size=\"2\" face='Arial, Helvetica, sans-serif'>";
	echo $row['lugar'];
	echo "</font>";
	?>&nbsp;</font></td>
  </tr>
<tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>

  </tr>
</table>

<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>INVITADOS</strong></font></div></td>
  </tr>
  <tr> 
    <td width="62"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td width="105"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TIPO</font></strong></div></td>
    <td width="199"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></strong></div></td>
    <td width="261"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">CARGO 
        /ROL</font></strong></div></td>
  </tr>
  <?php
$sql2 = "SELECT * FROM invitados WHERE id_agenda=$row[id_agenda]";
$result2=mysql_query($sql2);
$cont=0;
while ($row2=mysql_fetch_array($result2)) 
{
	$cont++;
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;$cont</font></td>";
	echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row2['tipo']."</font></td>";
	$sql3 = "SELECT * FROM users WHERE login_usr='".$row2['nombre']."'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 
	if($row3){
		echo "<td align=\"center\"><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row3['nom_usr']." ".$row3['apa_usr']." ".$row3['ama_usr']."</font></td>";}
	else{
		echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row2['nombre']."</font></td>";}
		echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row2['cargo']."</font></td>";
		echo "</tr>";
}
?>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>TEMAS 
        PROPUESTOS</strong></font></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">TEMA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">DURACION(min)</font></strong></div></td>
  </tr>
  <?php  
$sql25= "SELECT * FROM temas WHERE id_agenda=$row[id_agenda]";
$ttotal=0;
$result25=mysql_query($sql25);
while ($row25=mysql_fetch_array($result25)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row25['id_tema']."</font></td>";
	echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row25['tema']."</font></td>";
	$sql3 = "SELECT * FROM users WHERE login_usr='".$row25['responsable']."'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 
	if(isset($row3)){
		echo "<td align=\"center\"><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;".$row3['nom_usr']." ".$row3['apa_usr']." ".$row3['ama_usr']."</font></td>";}
	else
	{
		echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;$row25[responsable]</font></td>";}
	echo "<td><font size=\"2\" face='Arial, Helvetica, sans-serif'>&nbsp;$row25[duracion]</font></td>";
	$ttotal+=$row25['duracion'];
	echo "</tr>";
}
?>
  <tr bgcolor="#CCCCCC"> 
    <td colspan="3"><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>TOTAL 
        =</strong></font></div></td>
    <td align="center"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp; 
      <?php 
			  $minutos=$ttotal%60;
			  $ttotal-=$minutos;
			  $horas=$ttotal/60;
			  if($horas > 0) echo $horas." hrs. ".$minutos." min.";
			  else echo $minutos." min.";?>
      </strong></font></td>
  </tr>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td bgcolor="#FFFFFF"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>COMENTARIOS</strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#FFFFFF"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;
	<?php 
	echo "<font size=\"2\" face='Arial, Helvetica, sans-serif'>";
	echo $row['comentario']; 
	echo "</font>";
	?></font></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>