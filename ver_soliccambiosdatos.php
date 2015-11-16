<?php
include("top_ver.php");
require_once('funciones.php');
$id_orden=SanitizeString($id_orden);
$sql="SELECT *, DATE_FORMAT(FechSolic, '%d/%m/%Y') AS FechSolic, DATE_FORMAT(FechaAprob, '%d/%m/%Y') AS FechaAprob, 
	  DATE_FORMAT(FechaImple, '%d/%m/%Y') AS FechaImple, DATE_FORMAT(FechaReg, '%d/%m/%Y') AS FechaReg 
	 FROM soliccambiodatos WHERE Codigo='$id_orden'";
$resul=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($resul); 
?>
<?php
$sql_pepe="SELECT nombre FROM control_parametros";
$res_hola=mysql_db_query($db,$sql_pepe,$link);
$row_martin=mysql_fetch_array($res_hola);
?>

<html>
<head>
<title> GesTor F1 - CAMBIOS EN PRODUCCION</title>
</head>
<body>
<div align="center"></div>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><strong><font size="4" face="Arial, Helvetica, sans-serif"><u>CAMBIO 
        EN PRODUCCION</u></font></strong></div></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="147"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Codigo 
      de Solicitud:</strong></font></td>
    <td width="73">&nbsp;&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['id_cambio']; ?></font>&nbsp;</td>
    <td width="417">&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="158"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Solicitante 
      del Cambio:</strong></font></td>
    <td width="479"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp; 
      <?php 
	  $id_orden=SanitizeString($id_orden);
	$sql_ord="SELECT a.desc_inc,b.nom_usr,b.apa_usr,b.ama_usr FROM ordenes a, users b WHERE id_orden='$id_orden' AND login_usr=cod_usr";
	$row_ord=mysql_fetch_array(mysql_db_query($db,$sql_ord,$link));
	echo "$row_ord[nom_usr] $row_ord[apa_usr] $row_ord[ama_usr]"; ?>
      </font>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="108" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Requerimiento:</strong></font></td>
    <td width="529"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row_ord['desc_inc']; ?></font>&nbsp;</td>
  </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td>&nbsp;</td>
    <td width="126">&nbsp;</td>
    <td width="169">&nbsp;</td>
    <td width="170">&nbsp;</td>
  </tr>
  <tr> 
    <td colspan="4"><font size="2" face="Arial, Helvetica, sans-serif"><strong><u>SOLICITUD 
      DEL CAMBIO</u></strong></font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha y Hora:</strong></font></td>
    <td colspan="3">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><?php echo "$row[FechaReg] $row[HoraReg]";?></font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td colspan="3" bgcolor="#000000"></td>
  </tr>
  <tr> 
    <td width="172"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Lider 
      del Cambio:</strong></font></td>
    <td colspan="3">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"> 
      <?php 
	$sql2="SELECT * FROM users WHERE login_usr='$row[LiderProyecto]'";
	$resul2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($resul2);
	echo $row2['nom_usr']."&nbsp;".$row2['apa_usr']."&nbsp;".$row2['ama_usr']; ?>
      </font><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font>&nbsp;<font face="Arial, Helvetica, sans-serif" size="2">&nbsp; 
      </font></td>
  </tr>
  <tr> 
    <td></td>
    <td colspan="3" bgcolor="#000000" height="2"></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Lider Unidad 
      de Sistemas:</strong></font></td>
    <td colspan="3"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp; 
      <?php
	$sql3="SELECT * FROM users WHERE login_usr='$row[LiderProyUS]'";
	$resul3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($resul3);
	echo $row3['nom_usr']."&nbsp;".$row3['apa_usr']."&nbsp;".$row3['ama_usr']; ?>
      </font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" colspan="3" bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="172"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Descripcion 
      del Cambio:</strong></font></td>
    <td width="465">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['DescProyecto']; ?></font></td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="172"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Proposito 
      del Cambio:</strong></font></td>
    <td width="465">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['PropProyecto']; ?></font></td>
  </tr>
    </tr>
    <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
<table width="639" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="139"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
      de Solicitud:</strong></font></td>
    <td width="97"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['FechSolic']; ?></font></div></td>
    <td width="85">&nbsp;</td>
    <td width="176"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
      de Implementacion:</strong></font></td>
    <td width="85"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><?php echo $row['FechaImple']; ?></font></div></td>
    <td width="57">&nbsp;</td>
  </tr></tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td width="85"></td>
    <td width="176"></td>
    <td width="85" bgcolor="#000000"></td>
    <td width="57"></td>
  </tr>
</table>
<table width="638" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="139"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Nivel 
      de Cambio:</strong></font></td>
    <td width="96"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2"> 
        <?php echo "($row[Nivel]) "; 
	 if ($row['Nivel']=="1"){echo "Alta";}
	 elseif ($row['Nivel']=="2"){echo "Media";}
	 elseif ($row['Nivel']=="3"){echo "Baja";}
	 
	 ?> </font></div></td>
    <td width="85">&nbsp;</td>
    <td width="73"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Prioridad:</strong></font></td>
    <td width="83"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2">
	<?php echo "($row[Prioridad]) "; 
	 if ($row['Prioridad']=="1"){echo "Alta";}
	 elseif ($row['Prioridad']=="2"){echo "Media";}
	 elseif ($row['Prioridad']=="3"){echo "Baja";}
	 
	 ?></font></div></td>
	<td width="162">&nbsp;</td>
  </tr></tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
	<td width="85"></td>
    <td width="73"></td>
    <td bgcolor="#000000"></td>
	<td width="162"></td>
  </tr>
</table>
<br>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E1E1E1"> 
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">GRUPO 
        PARA LA IMPLEMENTACION DEL PROYECTO</font></strong></div></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <td height="18"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Especialidad 
        del Cambio</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Equipo 
        Involucrado para el Cambio</font></strong></div></td>
    <td><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Contraparte 
        para Pruebas</font></strong></div></td>
  </tr>
  <?php
  $id_orden=SanitizeString($id_orden);
$consul1="SELECT * FROM soliccambiogrupoproy WHERE Codigo='$id_orden'";
$resultado1=mysql_db_query($db,$consul1,$link);
while ($fila1=mysql_fetch_array($resultado1))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$fila1[EspecialidProy]</font></td>";
	echo "<td align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"1\">";
	$respon=explode("|*|",$fila1['InvolucProy']);
	$num_respon=count($respon);
	for($j=0;$j<$num_respon;$j++)
	{
		$sql2 = "SELECT * FROM users WHERE login_usr='$respon[$j]'";
		$result2 = mysql_db_query($db,$sql2,$link);
		$row2 = mysql_fetch_array($result2); 
		echo "- $row2[nom_usr] $row2[apa_usr] $row2[ama_usr]&nbsp;<br>";
	}
	echo "</font></td>";
	echo "<td align=\"center\"><font face=\"Arial, Helvetica, sans-serif\" size=\"1\">";
	$respon=explode("|*|",$fila1['ContraProy']);
	$num_respon=count($respon);
	for($j=0;$j<$num_respon;$j++)
	{
		$sql2 = "SELECT * FROM users WHERE login_usr='$respon[$j]'";
		$result2 = mysql_db_query($db,$sql2,$link);
		$row2 = mysql_fetch_array($result2); 
		echo "- $row2[nom_usr] $row2[apa_usr] $row2[ama_usr]&nbsp;<br>";
	}
	echo "</font></td>";
	echo "</tr>";

}
?>
</table>
<br>
<?php 
$id_orden=SanitizeString($id_orden);
$cons="SELECT *,DATE_FORMAT(Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioplanif WHERE Codigo='$id_orden'";
$res_lim1=mysql_db_query($db,$cons,$link);
$row_lim1=mysql_fetch_array($res_lim1);
if($row_lim1)
{
?>
<table width="637" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="7"><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>FASE 
        DE PLANIFICACION</u></font></strong></div></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td width="600" rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividades</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Planificacion</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Aprobacion</font></strong></div>
      <div align="center"><strong></strong></div></td>
    <td width="400" rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Entre 
        Fechas </strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td bgcolor="#E1E1E1"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <?php
  $id_orden=SanitizeString($id_orden);
$cons="SELECT *,DATE_FORMAT(Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioplanif WHERE Codigo='$id_orden'";
$result=mysql_db_query($db,$cons,$link);
$ass=array();
$i=1;
while ($f1=mysql_fetch_array($result))
{
	$ass[$f1['IdProyPlanif']]=$i;
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$ass[$f1['IdProyPlanif']]."</font></td>";
	$i++;
	echo "<td width=\"600\" align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Actividades]</font></td>";	
	if ($f1['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"mages/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f1[Observac]</font></td>";	
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;Del: $f1[Fecha_del]<br>Al: $f1[Fecha_al]</font></td>";	
	echo "</tr>";
}
?>
<tr><td colspan="7">
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
        de Aprobacion : <?php echo $row['FechaAprob'];?></font></strong></div></td>
  </tr>
  <tr> 
    <td>&nbsp;</td>
  </tr>
</table>
</td></tr>
<?php 
$id_orden=SanitizeString($id_orden);
$cons1="SELECT a.*,DATE_FORMAT(a.Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(a.Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioejecucion a, soliccambioplanif b WHERE a.Codigo='$id_orden' AND a.Responsabilid=b.IdProyPlanif ORDER BY b.IdProyPlanif ASC";
$res_lim=mysql_db_query($db,$cons1,$link);
$row_lim=mysql_fetch_array($res_lim);
if($row_lim)
{
?>
  <tr>
    <td colspan="7"><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>FASE 
        DE EJECUCION</u></font></strong></div></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividades</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Ejecucion</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Aprobacion</font></strong></div>
    </td>
	 <td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Entre 
        Fechas </strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <?php

$result1=mysql_db_query($db,$cons1,$link);
while ($f2=mysql_fetch_array($result1))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$ass[$f2['Responsabilid']]."</font></td>";
	$id_orden=SanitizeString($id_orden);
	$sql_act="SELECT Responsabilid FROM soliccambioplanif WHERE Codigo='$id_orden' AND IdProyPlanif='$f2[Responsabilid]'";
	$row_act=mysql_fetch_array(mysql_db_query($db,$sql_act,$link));
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row_act[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f2[Actividades]</font></td>";	
	if ($f2['Aprobacion']=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f2[Observac]</font></td>";	
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;Del: $f2[Fecha_del]<br>Al: $f2[Fecha_al]</font></td>";	
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="7">&nbsp;</td>
  </tr>
<?php }
$id_orden=SanitizeString($id_orden);
$cons2="SELECT a.*,DATE_FORMAT(a.Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(a.Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambiocontrol a, soliccambioplanif b WHERE a.Codigo='$id_orden' AND a.Responsabilid=b.IdProyPlanif ORDER BY b.IdProyPlanif ASC";
$res_lim=mysql_db_query($db,$cons2,$link);
$row_lim=mysql_fetch_array($res_lim);
if($row_lim)
{
?>
  <tr>
    <td colspan="7"><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>FASE 
        DE CONTROL</u></font></strong></div></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividades</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Control</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Aprobacion</font></strong></div>
    <div align="center"><strong></strong></div></td>
	<td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
        y Hora</strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <?php
$cons2="SELECT a.*,DATE_FORMAT(a.Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(a.Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambiocontrol a, soliccambioplanif b WHERE a.Codigo='$id_orden' AND a.Responsabilid=b.IdProyPlanif ORDER BY b.IdProyPlanif ASC";
$result2=mysql_db_query($db,$cons2,$link);
while ($f3=mysql_fetch_array($result2))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$ass[$f3[Responsabilid]]."</font></td>";
	$sql_act="SELECT Responsabilid FROM soliccambioplanif WHERE Codigo='$id_orden' AND IdProyPlanif='$f3[Responsabilid]'";
	$row_act=mysql_fetch_array(mysql_db_query($db,$sql_act,$link));
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row_act[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f3[Actividades]</font></td>";	
	if ($f3[Aprobacion]=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f3[Observac]</font></td>";	
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;Del: $f3[Fecha_del]<br>Al: $f3[Fecha_al]</font></td>";	
	echo "</tr>";
}
?>
  <tr> 
    <td colspan="7">&nbsp;</td>
  </tr>
<?php }
$cons3="SELECT a.*,DATE_FORMAT(a.Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(a.Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambiocierre a, soliccambioplanif b WHERE a.Codigo='$id_orden' AND a.Responsabilid=b.IdProyPlanif ORDER BY b.IdProyPlanif ASC";
$res_lim=mysql_db_query($db,$cons3,$link);
$row_lim=mysql_fetch_array($res_lim);
if($row_lim)
{
?>
  <tr>
    <td colspan="7"><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif"><u>FASE 
        DE CIERRE</u></font></strong></div></td>
  </tr>
  <tr bgcolor="#E1E1E1"> 
  <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.</font></strong></div></td>
    <td rowspan="2" bgcolor="#E1E1E1"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Actividades</font></strong></div></td>
    <td rowspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Cierre</font></strong></div></td>
    <td colspan="3"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Aprobacion</font></strong></div>
    <div align="center"><strong></strong></div></td>
	<td rowspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Fecha 
        y Hora</strong></font></div></td>
  </tr>
  <tr> 
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font></div></td>
    <td bgcolor="#E1E1E1"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>Observaciones</strong></font></div></td>
  </tr>
  <?php
$cons3="SELECT a.*,DATE_FORMAT(a.Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(a.Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambiocierre a, soliccambioplanif b WHERE a.Codigo='$id_orden' AND a.Responsabilid=b.IdProyPlanif ORDER BY b.IdProyPlanif ASC";
$result3=mysql_db_query($db,$cons3,$link);
while ($f4=mysql_fetch_array($result3))
{
	echo "<tr align=\"center\">";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;".$ass[$f4[Responsabilid]]."</font></td>";
	$sql_act="SELECT Responsabilid FROM soliccambioplanif WHERE Codigo='$id_orden' AND IdProyPlanif='$f4[Responsabilid]'";
	$row_act=mysql_fetch_array(mysql_db_query($db,$sql_act,$link));
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$row_act[Responsabilid]</font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f4[Actividades]</font></td>";	
	if ($f4[Aprobacion]=="SI")
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"> </font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	}
	else
	{echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/no1.gif\" border=\"1\"></font></td>";
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp; <img src=\"images/si1.gif\" border=\"1\"></font></td>";
	}
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;$f4[Observac]</font></td>";	
	echo "<td align=\"center\"><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;Del: $f4[Fecha_del]<br>Al: $f4[Fecha_al]</font></td>";	
	echo "</tr>";
}
}
?>
</table>
<?php }
if($row['Archivos'])
{
?>
<br>
<table width="637" border="2" align="center" cellpadding="2" cellspacing="0">
  <tr bgcolor="#E1E1E1"> 
    <th colspan="9"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
      ARCHIVOS ADJUNTOS</font></th>
  </tr>
  <tr bgcolor="#E1E1E1"> 
    <th width="8%" height="26" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
    <th width="23%" nowrap><font size="2" face="Arial, Helvetica, sans-serif" color="#000000">Adjuntado 
      por </font></th>
    <th width="23%" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Archivo</font></th>
    <th width="20%" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Hash</font></th>
    <th width="26%" nowrap><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
  </tr>
  <?php 
		  	$sql_aas="SELECT Usr_archivos, Archivos, Hash_archi, Observ_archi FROM soliccambiodatos WHERE Codigo='$id_orden'";
			$row_aas=mysql_fetch_array(mysql_db_query($db,$sql_aas, $link));
			
			if($row_aas['Archivos']!="")
			{	
				$usr_ar1=explode("|*|",$row_aas['Usr_archivos']);
				$arch1=explode("|*|",$row_aas['Archivos']);
				$arch2=count($arch1);
				$ha_ar1=explode("|*|",$row_aas['Hash_archi']);
				$ob_ar1=explode("|*|",$row_aas['Observ_archi']);
				
				for($c=0;$c<$arch2;$c++)
				{
		  ?>
  <tr align="center"> 
    <td height="26" nowrap> <?php echo $c+1;?> &nbsp;</td>
    <td nowrap> 
      <?php 
					$sql_us="SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$usr_ar1[$c]'";
					$row_us=mysql_fetch_array(mysql_db_query($db,$sql_us,$link));
					echo "$row_us[nom_usr] $row_us[apa_usr] $row_us[ama_usr]";?>
      &nbsp;</td>
    <td nowrap> 
      <?php 
					$nom_ar=explode("_",$arch1[$c]);
					$nom_ar1="$nom_ar[0]_$nom_ar[1]_$nom_ar[3]";			
					echo "$nom_ar1";?>
      &nbsp;</td>
    <td nowrap> <?php echo $ha_ar1[$c];?> &nbsp;</td>
    <td nowrap><?php echo $ob_ar1[$c];?>&nbsp;</td>
  </tr>
  <?php }
		  }?>
</table>
<?php }?>
<br>
<br>
<br>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="112"><font size="2" face="Arial, Helvetica, sans-serif"><strong>REVISADO 
      POR :</strong></font></td>
    <td width="174">&nbsp;
	<?php 
	$sq2="SELECT * FROM users WHERE login_usr='$row[NombAprob]'";
	$resu2=mysql_db_query($db,$sq2,$link);
	$ro2=mysql_fetch_array($resu2);
	echo $ro2['nom_usr']."&nbsp;".$ro2['apa_usr']."&nbsp;".$ro2['ama_usr']; ?></td>
    <td width="166"><div align="right"><font size="2" face="Arial, Helvetica, sans-serif"><strong>APROBADO 
        POR:</strong></font></div></td>
    <td width="185">&nbsp;<?php if($row['NombAprob']!="00/00/0000") echo $row['NombAprob'];?></td>
  </tr>
   <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
    <td height="3"></td>
    <td bgcolor="#000000"></td>
  </tr>

</table>
<p>&nbsp;</p>
</body>
</html>