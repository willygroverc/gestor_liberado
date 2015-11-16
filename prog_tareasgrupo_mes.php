<?php
include ("conexion.php");
if ($Terminar)  header("location: lista_progtareas.php");
include ("top.php");
if ($INSERTAR)
{	$datos2 = explode(":", $datos);
	$codigos2 = explode(":", $codigos);
	for ($i=0; $i <(count($datos2) - 1); $i++)  $valores[$i] = $datos2[$i];
	for ($i=0; $i <(count($codigos2) - 1); $i++)  $cod[$i] = $codigos2[$i];				
	for  ($i=0; $i<count($cod); $i++)
	{ 	$sql2 = "SELECT *, DATE_FORMAT(FechaProceso, '%d/%m/%Y') AS FechaProceso, DATE_FORMAT(RevisadoPorFecha, '%d/%m/%Y %H:%i:%s') AS RevisadoPorFecha FROM progtareasdiaria1 WHERE IdProgTarea1='$cod[$i]'";
	    $res2 = mysql_db_query($db, $sql2, $link);
		$row2 = mysql_fetch_array($res2);
		if ( $row2[Revisado] != "1" )
		{	if( $_SESSION[tipo]=="A" || $row2[RealizadoPor] != $_SESSION[login]) 	
			{	$sql3 = "UPDATE progtareasdiaria1 SET RevisadoPor='$_SESSION[login]', RevisadoPorFecha='".date("Y-m-d H:i:s")."', Aprobacion='$Aprobacion', RevisadoPorObs='$Observaciones', Revisado='1' WHERE IdProgTarea1='$cod[$i]'";
				mysql_db_query($db, $sql3, $link);
			}
		}
	}	
}
?>
<html>
<head>
<title>GesTor F1</title>
</head>
<body>
<table width="95%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr bgcolor="#006699"><td colspan="6" align="center" ><font size="2" face="arial" color="#FFFFFF"><b>PROGRAMACION DE TAREAS - DIARIAS</b></font></td></tr>
  <tr  bgcolor="#006699">
  	<td width="6%" align="center"><font size="1" face="arial" color="#FFFFFF">Nro.</FONT></td>
	<td width="14%" align="center"><font size="1" face="arial" color="#FFFFFF">FECHA PROGRAMACION</FONT></td>
	<td width="10%" align="center"><font size="1" face="arial" color="#FFFFFF">DE HORAS</FONT></td>
	<td width="10%" align="center"><font size="1" face="arial" color="#FFFFFF">A HORAS</FONT></td>
	<td width="35%" align="center"><font size="1" face="arial" color="#FFFFFF">ACTIVIDAD</FONT></td>
	<td width="25%" align="center"><font size="1" face="arial" color="#FFFFFF">OBSERVACIONES</FONT></td>	
  </tr>
  <?php
		for ( $i=0; $i<count($valores); $i++ )
		{	$sql = "SELECT *, DATE_FORMAT(FechaDe, '%d/%m/%Y') AS FechaDe FROM progtareasdiaria WHERE IdProgTarea='$valores[$i]'";
			$result = mysql_db_query($db,$sql,$link);
			$row = mysql_fetch_array($result);
  		 ?>
		<tr align="center"> <?php echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">".$row[IdProgTarea]."</font></td>";?>
		  <td><?php=$row[FechaDe]?></td>
		  <td><div align="center">&nbsp;<?php echo $row[HoraDe]?></div></td>
		  <td><div align="center">&nbsp;<?php echo $row[HoraA]?></div></td>
		  <td><div align="center">&nbsp;<?php echo $row[Actividad]?></div></td>
		  <td><div align="center">&nbsp;<?php echo $row[Observaciones]?></div></td>
		</tr>
	<?php }?>
</table>
<br>
<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr align="center">
    <th colspan="8"><font size="3">REALIZACION&nbsp;/&nbsp;REVISION</font></th>
  </tr>
  <tr align="center">
    <th><font size="2">Nro.</font></th>
    <th><font size="2">Realizado por</font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Realizacion</font></th>
    <th><font size="2">Revisado Por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Aprobacion</font></th>
    <th><font size="2">Revision</font></th>
  </tr>
 <?php
$c = 0;
for ($i=0; $i<count($valores); $i++)
{	$fec1 = date("Y-m-d");
	$fec2 = date("Y-m-d");
	$sql = "SELECT * FROM progtareasdiaria1 WHERE (FechaProceso BETWEEN '#$fec1 00:00:00#' AND '#$fec2 23:59:59#') AND IdProgTarea='$valores[$i]'";	
	$res = mysql_db_query($db, $sql, $link);
	while ($row2 = mysql_fetch_array($res))
	{	$sql1 = "SELECT * FROM users WHERE login_usr='$row2[RealizadoPor]'";
		$result1 = mysql_db_query($db,$sql1,$link);
		$row1 = mysql_fetch_array($result1);				
		$tareas[$c] = $row2[IdProgTarea1];
		$c++;
		echo "<tr>";
		echo "<td align='center'>$row2[IdProgTarea]</td>";
		echo "<td align='center'>$row1[nom_usr] $row1[apa_usr] $row1[ama_usr]</td>";
		echo "<td align='center'>$row2[FechaProceso]</td>";
		echo "<td align='center'>$row2[Realizacion]</td>";
		if ( $row2[Revisado] == "1" )
		{	$sql_rev = "SELECT * FROM users WHERE login_usr='$row2[RevisadoPor]'";
		  	$res_rev = mysql_db_query($db,$sql_rev,$link);
		  	$row_rev = mysql_fetch_array($res_rev);
			echo "<td align='center'>$row_rev[nom_usr] $row_rev[apa_usr] $row_rev[ama_usr]</td>";
			echo "<td align='center'>$row2[RevisadoPorFecha]</td>";
			echo "<td align='center'>$row2[Aprobacion]</td>";
			echo "<td align=\"center\"><img src=\"images/ok.gif\" border=\"0\"></td>";
		}
		else 
		{	echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			echo "<td>&nbsp;</td>";
			if($_SESSION[tipo]=="A"  || $row2[RealizadoPor]!=$_SESSION[login]) 							
			echo "<td align=\"center\"><img src=\"images/no3.gif\" border=\"0\"></td>";							
			else echo "<td align=\"center\"><img src=\"images/no2.gif\" border=\"0\"></td>";
		}
		echo "</tr>"; 				
	}
}
?> 
</table>
<br>
<form action="" method="post" name="form1">
<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr align="center">
      <th colspan="4"><font size="3">REALIZACION
      <?php=$IdProgTarea1?></font></th>
    </tr>
    <tr align="center">
      <th width="31%"><font size="2">Realizado </font></th>
      <th width="28%"><font size="2">Realizacion</font></th>
      <th width="41%"><font size="2">Observaciones</font></th>
    </tr>
    <tr align="center">
	  <?php 
		  	$sql3 = "SELECT * FROM users WHERE login_usr='$_SESSION[login]'";
		  	$result3 = mysql_db_query($db,$sql3,$link);
		  	$row3 = mysql_fetch_array($result3);?>		
	  <td> <?php echo $row3[nom_usr]." ".$row3[apa_usr]." ".$row3[ama_usr]; ?></td>	  
      <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <input name="Aprobacion" type="radio" value="SI" checked <?php if ($Aprobacion=="SI") echo "checked";?>>
        SI</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
		&nbsp;
        <input type="radio" name="Aprobacion" value="NO" <?php if ($Aprobacion=="NO") echo "checked";?>>
        NO</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
		&nbsp;
        <input type="radio" name="Aprobacion" value="NA" <?php if ($Aprobacion=="NA") echo "checked";?>>
        NA</font> </td>
        <td><font size="2" face="Arial, Helvetica, sans-serif">
        <textarea name="Observaciones" cols="30" id="Observaciones"><?php echo $Observaciones;?></textarea>
      </font>
	  </td>
    </tr>
    <tr align="center">
      <td height="30" colspan="4"> 
        <input name="INSERTAR" type="submit" id="INSERTAR" value="    INSERTAR    " >
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      	<input type="submit" name="Terminar" value="    RETORNAR    "></td>
    </tr>
  </table>
  <?php 
  ?>
  <input type="hidden" name=datos value="<?php 
      for ($i=0; $i<count($valores); $i++)
      {	 echo $valores[$i].":";  }	
  ?>">
 <input type="hidden" name=codigos value="<?php 
      for ($i=0; $i<count($tareas); $i++)
      {	 echo $tareas[$i].":";  }	
  ?>">  
</form>
</body>
</html>
<SCRIPT language="JavaScript">
function Validar()
{	var form = document.form1;
	/*if (form.Observaciones.value == "" )		
	{	alert ("Observaciones no debe ser vacio.\n\nMensaje generado por GesTor F1.");
		return (false);
	}*/
	if ( !(form.tipo_re[0].checked) )	
	{	if ( !(form.tipo_re[1].checked) )
		{	alert ("Debe seleccionar REALIZACION o REVISION\n\nMensaje generado por GesTor F1.");
			return (false);
		}
	}
	return true;	
}
</SCRIPT>
