<?php include("top_ver.php");?>
<html>
<head>
<title> GesTor F1 - CAMBIOS-PROACP - MAESTRO DE CAMBIOS </title>
</head>
<body>
<p>
<?php
include("datos_gral.php");
?>
<table width="100%" border="0" align="center">
  <tr> 
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><u><strong>MAESTRO 
        DE CAMBIOS</strong></u></font></div></td>
  </tr>
</table>
<div align="center"><br>
  
<table width="100%" border="1">
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="4%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>N&deg; 
      DE CAMBIO</strong></font></td>
    <td width="4%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>N&deg; 
      ORDEN</strong></font></td>
    <td width="7%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>INCIDENCIA</strong></font></td>
    <?php if ($tipo=="A" or $tipo=="B") {?>
    <td width="6%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>ASIGNADO 
      A</strong></font></td>
    <?php }?>
    <td width="7%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
      PROGRAMADA</strong></font></td>
    <td width="14%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
      REAL</strong></font></td>
    <td width="19%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DESCRIPCION 
      DEL CAMBIO</strong></font></td>
    <td width="8%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PRIORIDAD</strong></font></td>
    <td width="14%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>NIVEL</strong></font></td>
    <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>OBSERVACIONES</strong></font></td>
  </tr>
     <?php 
	 	if ($tipo=="A" OR $tipo=="B"){	
		$sql = "SELECT * FROM maestro ORDER BY num_cambio ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
	 	{
		 $sql2 = "SELECT cod_usr,desc_inc FROM ordenes WHERE id_orden='$row[num_orden]'";
		 $result2=mysql_db_query($db,$sql2,$link);
		 $row2=mysql_fetch_array($result2);
		 $sql3 = "SELECT asig,area FROM asignacion WHERE id_orden='$row[num_orden]' ORDER BY id_asig DESC limit 1";
		 $result3=mysql_db_query($db,$sql3,$link);
		 $row3=mysql_fetch_array($result3);
	     if ($row3['area']=="Cambios"){	 
	 ?>
  <tr align="center"> 
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['num_cambio']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['num_orden']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['desc_inc']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	$sql4 = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$row3[asig]'";
    $result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr']?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['fechaprog']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row['fechareal']=="0000-00-00") {echo "AUN NO DEFINIDO";} 
	  else{echo $row['fechareal'];}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['desc_cambio']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row['prioridad']=="1"){echo "1 (Alto)";}
	  if ($row['prioridad']=="2"){echo "2 (Medio)";}
	  if ($row['prioridad']=="3"){echo "3 (Bajo)";}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row['nivel']=="1"){echo "1 (Alto)";}
	  if ($row['nivel']=="2"){echo "2 (Medio)";}
	  if ($row['nivel']=="3"){echo "3 (Bajo)";}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['observaciones']?></font></td>
  </tr>
  <?php }}}
  else
  		{$sql = "SELECT * FROM maestro ORDER BY num_cambio ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
	 	{
		 $sql2 = "SELECT cod_usr,desc_inc FROM ordenes WHERE id_orden='$row[num_orden]'";
		 $result2=mysql_db_query($db,$sql2,$link);
		 $row2=mysql_fetch_array($result2);
		 $sql3 = "SELECT asig,area FROM asignacion WHERE id_orden='$row[num_orden]' ORDER BY id_asig DESC limit 1";
		 $result3=mysql_db_query($db,$sql3,$link);
		 $row3=mysql_fetch_array($result3);
	   if ($login=="$row3[asig]" AND $row3[area]=="Cambios") {	 
	 ?>
  <tr align="center"> 
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['num_cambio']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['num_orden']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row2['desc_inc']?></font></td>
    <?php if ($tipo=="A" or $tipo=="B") {?>
	<td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	$sql4 = "SELECT nom_usr,apa_usr,ama_usr FROM users WHERE login_usr='$row3[asig]'";
    $result4=mysql_db_query($db,$sql4,$link);
	$row4=mysql_fetch_array($result4);
	echo $row4[nom_usr]." ".$row4[apa_usr]." ".$row4[ama_usr]?>
      </font></td>
	 <?php }?>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['fechaprog']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row[fechareal]=="0000-00-00") {echo "AUN NO DEFINIDO";} 
	  else{echo $row[fechareal];}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['desc_cambio']?></font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row[prioridad]=="1"){echo "1 (Alto)";}
	  if ($row[prioridad]=="2"){echo "2 (Medio)";}
	  if ($row[prioridad]=="3"){echo "3 (Bajo)";}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
      <?php 
	  if ($row[nivel]=="1"){echo "1 (Alto)";}
	  if ($row[nivel]=="2"){echo "2 (Medio)";}
	  if ($row[nivel]=="3"){echo "3 (Bajo)";}?>
      </font></td>
    <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['observaciones']?></font></td>
  </tr>
  <?php }}}?>
  
</table>
</body>
</html>
