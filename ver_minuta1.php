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
$idmin=($_GET['variable']);
$sql = "SELECT *,DATE_FORMAT(en_fecha,'%d / %m / %Y') as en_fecha,DATE_FORMAT(fecha,'%d / %m / %Y') as fecha FROM minuta  WHERE id_minuta='$idmin' ";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - ACTAS</title>
</head>
<body>
<p>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><?php echo "<img src=\"images/imagen_ins.jpg\" border=\"0\">"; ?></td>
  </tr>
</table>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#000066">
  <tr>
    <td><div align="center"><font color="#000066"><strong><font color="#FFFFFF" size="2" face="Book Antiqua"><u>ACTA DE REUNION </u></font></strong></font></div></td>
  </tr>
</table>
<!--<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="58"> <p align="left"><font size="2" face="Book Antiqua"><strong>CODIGO</strong></font></p>
    </td>
    <td width="579"><p>&nbsp;
	<?php 
	//echo "$row[codigo]";
	/*if($row[codigo]=="CSI"){echo "$row[codigo] (Comite de Sistemas)";}
	elseif($row[codigo]=="CCP"){echo "$row[codigo] (Comite de Cambios en Prod.)";}
	elseif($row[codigo]=="CRC"){echo "$row[codigo] (Comite de Recup. y Conting.)";}
	elseif($row[codigo]=="OTRO"){echo "$row[codigo]";}*/
	?></p> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>-->
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="131"> <p align="left"><font size="2" face="Book Antiqua">ELABORADO 
        POR<strong> </strong></font></p></td>
    <td width="260"><strong>	
	<?php 
	$consul="SELECT * FROM users WHERE login_usr='$row[elab_por]'";
	$resul=mysql_query($consul);
	$fila=mysql_fetch_array($resul);	
	echo $fila['nom_usr']."&nbsp;".$fila['apa_usr']."&nbsp;".$fila['ama_usr'];?>
</strong></td>
    <td width="81"><font size="2" face="Book Antiqua">EN FECHA</font></td>
    <td width="165"><p><font size="2" face="Book Antiqua">&nbsp;<?php echo $row['en_fecha'];?></font></p></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>

<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="260"><font size="2" face="Book Antiqua">TIPO DE REUNION: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ORDINARIA</font> 
      <?php 
	if ($row['tipo_min']=="Ordinaria")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="151"><font size="2" face="Book Antiqua">EXTRAORDINARIA:</font> 
      <?php 
	if ($row['tipo_min']=="Extraordinaria")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
    <td width="91"><font size="2" face="Book Antiqua">EMERGENCIA:</font></td>
    <td width="52">&nbsp;
	      <?php 
	if ($row['tipo_min']=="Emergencia")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>

	</td>
    <td width="83"><font size="2" face="Book Antiqua">OTROS:</font> 
      <?php 
	if ($row['tipo_min']=="Otros")
		{echo "<img src=\"images/si1.gif\" border=\"1\">";}
		else
		{echo "<img src=\"images/no1.gif\" border=\"1\">";}
	?>
    </td>
  </tr>
</table>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50"><font size="2" face="Book Antiqua">FECHA</font></td>
    <td width="120"><font size="2" face="Book Antiqua">&nbsp;&nbsp;<?php echo $row['fecha'];?>&nbsp;</font></td>
    <td width="64"><font size="2" face="Book Antiqua">HORA</font></td>
    <td width="93"><font size="2" face="Book Antiqua">&nbsp;&nbsp;<?php echo $row['hora']; ?>&nbsp;</font></td>
    <td width="59"><font size="2" face="Book Antiqua">LUGAR</font></td>
    <td width="251"><font size="2" face="Book Antiqua"><?php echo $row['lugar'];?>&nbsp;</font></td>
	<td width="59"><font size="2" face="Book Antiqua">ENTIDAD: </font></td>
    <td width="251"><font size="2" face="Book Antiqua"><?php $sqlP = "SELECT `nombre` FROM `control_parametros`";	
						$resultP = mysql_query($sqlP);
						$rowP = mysql_fetch_array($resultP); echo $rowP['nombre'];?>&nbsp;</font></td>
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
<table width="980" height="107" border="1" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td height="18" colspan="4" bgcolor="#000066"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">ASISTENTES</font></strong></div></td>
  </tr>
  <tr bgcolor="#000066"> 
    <!--<td height="21"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">No</font></strong></div></td>-->
    <td><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">NOMBRE Y APELLIDO</font></strong></div></td>
    <td width="203"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">CARGO 
    </font></strong></div></td>
	<td><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">ENTIDAD</font></strong></div>
	</td>
	<td width="230"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">FIRMA</font></strong></div>
	</td>
  </tr>
  <?php
$sql2 = "SELECT * FROM invitados WHERE id_agenda=$row[id_minuta]";
$result2=mysql_query($sql2);
while ($row2=mysql_fetch_array($result2)) 
{
	$cont=$cont+1;
	$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 	
	echo "<tr align=\"center\">";
	if($row3)
	{
	echo "<td align=\"center\"><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";
	}
	else
	{echo "<td><font size=\"2\">&nbsp;$row2[nombre]</font></td>";}
	//$sql7 = "SELECT * FROM us_ext_user WHERE nombre='$row2[nombre]'";
	$sql7 = "SELECT e.nombre AS entidad
FROM us_ext_mod AS e, us_ext_user AS u
WHERE u.nombre = '$row2[nombre]'
AND u.id_mod = e.id_mod";
	$result7 = mysql_query($sql7);
	$row7 = mysql_fetch_array($result7); 
	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row2[cargo]</font></td>";
	if($row3)
	{ echo "<td align=\"center\"><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row3[enti_usr]</font></td>"; }
	else { echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row7[entidad]</font></td>"; }
	echo "<td align=\"left\">&nbsp;</td>";
	echo "</tr>";
	
}
?>
</table>
<br>
<table width="980" height="96" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#000066"> 
    <td colspan="4"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">ORDEN DEL DIA</font></strong></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Book Antiqua">No</font></strong> Orden </div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">TEMA</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">RESPONSABLE</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">DURACION(min)</font></strong></div></td>
  </tr>
  <?php
$ttotal=0;
$sql25= "SELECT * FROM temad WHERE id_minuta=$row[id_minuta]";
$result25=mysql_query($sql25);
while ($row25=mysql_fetch_array($result25)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row25[id_tema]</font></td>";
		$sql5 = "SELECT * FROM temas WHERE id_tema='$row25[tema]'  AND id_agenda='$row[id_minuta]'";
		$result5 = mysql_query($sql5);
		$row5 = mysql_fetch_array($result5);
		if (!isset($row5['id_tema']))
		{echo "<td>&nbsp;$row25[tema]</td>";}
		else
		{echo "<td>&nbsp;$row5[tema]</td>";}
	$sql3 = "SELECT * FROM users WHERE login_usr='$row25[responsable]'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 
	if($row3)
	{echo "<td align=\"center\"><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";}
	else
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row25[responsable]</font></td>";}
	echo "<td><font size=\"2\">&nbsp;$row25[duracion]</font></td>";
	$ttotal+=$row25['duracion'];
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="3"><div align="right"><font color="#000000" size="2" face="Book Antiqua"><strong>TOTAL 
        =</strong></font></div></td>
    <td align="center"><font color="#000000" size="2" face="Book Antiqua"><strong>&nbsp; 
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
<table width="980" height="80" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#000066"> 
    <td colspan="2"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">ASUNTOS TRATADOS</font></strong></div></td>
  </tr>
  <tr> 
    <td width="100"><div align="center"><strong><font size="2" face="Book Antiqua">No Orden</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">RESULTADOS</font></strong></div></td>
  </tr>
  <?php
$sql13 = "SELECT * FROM rtema WHERE id_minuta=$row[id_minuta]";
$result13=mysql_query($sql13);
while ($row13=mysql_fetch_array($result13)) 
{
	echo "<tr align=\"Rigth\">";
	echo "<td align=\"center\"><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row13[id_tema]</font></td>";
	//echo "<td><font size=\"2\">&nbsp;&nbsp;<strong>Asuntos tratados sobre orden No$row13[id_tema]:</strong>&nbsp;&nbsp;$row13[resultado]</font></td>";
	if($row13['id_tema']==1)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;PRIMERO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==2)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;SEGUNDO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==3)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;TERCERO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==4)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;CUARTO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==5)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;QUINTO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==6)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;SEXTO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==7)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;SEPTIMO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==8)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;OCTAVO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==9)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;NOVENO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==10)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;DECIMO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==11)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;UNDECIMO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==12)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;DUODECIMO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==13)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;DECIMO TERCERO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==14)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;DECIMO CUARTO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	if($row13['id_tema']==15)
	{	echo "<td><font size=\"2\" face=\"Book Antiqua\"><strong>&nbsp;&nbsp;DECIMO QUINTO&nbsp;Asuntos tratados respecto&nbsp;OD$row13[id_tema]:</strong>&nbsp;&nbsp;<br>&nbsp;&nbsp;$row13[resultado]</font></td>";}
	
	
	echo "</tr>";
}
?>
</table>
<br>
<table width="980" height="72" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#000066"> 
    <td colspan="4"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">ACCIONES 
        POR TEMAS</font></strong></div></td>
  </tr>
  <tr> 
    <td><div align="center"><strong><font size="2" face="Book Antiqua">No</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">ACCION</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">RESPONSABLE</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Book Antiqua">FECHA 
        LIMITE</font></strong></div></td>
  </tr>
  <?php
$sql14 = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta=$row[id_minuta]";
$result14=mysql_query($sql14);
while ($row14=mysql_fetch_array($result14)) 
{
	echo "<tr align=\"center\">";
	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row14[id_tema]</font></td>";
	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row14[accion]</font></td>";
	$sql3 = "SELECT * FROM users WHERE login_usr='$row14[responsable]'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 
	if($row3)
	{echo "<td align=\"center\"><font size=\"2\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</font></td>";}
	else
	{echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row14[responsable]</font></td>";}
	echo "<td><font size=\"2\" face=\"Book Antiqua\">&nbsp;$row14[flimite]</font></td>";
	echo "</tr>";
}
?>
</table><br>

<br>
<table width="980" height="76" border="2" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr bgcolor="#000066"> 
    <td width="631" height="18"><div align="center"><strong><font color="#FFFFFF" size="2" face="Book Antiqua">COMENTARIOS</font></strong></div></td>
  </tr>
  <tr> 
    <td height="42" valign="top"><div align="center"><font size="2"><?php echo $row['comentario'];?></font></div></td>
  </tr>
  <?php
		$cont=0;	
		$sql24 = "SELECT * FROM asistentes WHERE id_minuta='$row[id_minuta]' AND prop IS NOT NULL";
		$result24=mysql_query($sql24);
		while($row24=mysql_fetch_array($result24)) 
  		{
		$cont=$cont+1;
		 ?>
  
  <?php 
		
		 }
		 ?>
</table>
<p>&nbsp;</p>
<div align="center"><br>
  <!-- <table width="637" border="2" cellpadding="0" cellspacing="0">
    <tr> 
      <td><div align="center"><font size="2" face="Book Antiqua"><strong>RECAUDACIONES</strong></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><strong><font size="2" face="Book Antiqua">Total 
          Recaudado :</font></strong><font size="2" face="Book Antiqua"> 
          <?php//=$row[recau]?>
          Bs.</font> </div></td>
    </tr>
  </table> -->
</div>


<table width=50% height=50% border="0" align="center" cellpadding="0" cellspacing="0">
<?php
/*		FIRMAS DEL ACTA
$sql2 = "SELECT * FROM asistentes WHERE id_minuta=$row[id_minuta]";
$result2=mysql_query($sql2);
$cont=0;
while ($row2=mysql_fetch_array($result2)) 
{
	if ($cont%2==0){
	echo "</tr>";}
	$cont=$cont+1;
	$sql3 = "SELECT * FROM users WHERE login_usr='$row2[nombre]'";
	$result3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($result3); 
	echo "<td align=\"center\"><font size=\"2\">&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr] <br> $row3[cargo]</font></td>";
	if ($cont%2==0){
	echo "</tr>";}
}*/
?>
</table>
</body>
</html>