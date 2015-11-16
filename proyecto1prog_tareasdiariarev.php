<?php if ($Terminar)
header("location: lista_progtareas.php");
include("top.php");

if ($INSERTAR)
{   
	if($action=="revisar"){
		$sql="UPDATE progtareasdiaria1 SET RevisadoPor='$_SESSION[login]', RevisadoPorFecha='".date("Y-m-d H:i:s")."', Aprobacion='$Aprobacion', RevisadoPorObs='$Observaciones', Revisado=1 WHERE IdProgTarea1=$IdProgTarea1";
		mysql_db_query($db, $sql);
	}
	else {
		$sql="INSERT INTO progtareasdiaria1 (IdProgTarea, FechaProceso, RealizadoPor, Realizacion, RealizadoPorObs) VALUES ($IdProgTarea, '".date("Y-m-d H:i:s")."', '$_SESSION[login]', '$Aprobacion', '$Observaciones')";
		mysql_db_query($db, $sql);
	}
	if(mysql_affected_rows()!=1) $errorMsg="Precaucion, no se ha registrado los datos. Por favor, intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}

$sql="SELECT login_usr, CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) AS Nombre FROM users";
$rs=mysql_db_query($db, $sql);
while($tmp=mysql_fetch_array($rs)){
	$lstUsuario[$tmp[login_usr]]=$tmp[Nombre];
}

?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addLength ( "Observaciones",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="95%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <th colspan="6" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">PROGRAMACION DE TAREAS - DIARIAS</font></th>
  </tr>
  <tr align="center">
    <th width="54" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
    <th width="120" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha de Programacion</font></th>
    <th colspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora</font></th>
    <th width="260" rowspan="2" bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividad</font></th>
    <th width="162" rowspan="2" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
  </tr>
  <tr align="center">
    <th width="120" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">De</font></th>
    <th width="120" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">A</font></th>
  </tr>
  <?php
		$sql = "SELECT *, DATE_FORMAT(FechaDe, '%d/%m/%Y') AS FechaDe FROM progtareasdiaria WHERE IdProgTarea='$IdProgTarea'";
		$result=mysql_db_query($db,$sql,$link);
		$row=mysql_fetch_array($result);
  		 ?>
  <tr align="center"> <?php echo "<td><font size=\"1\" face=\"Arial, Helvetica, sans-serif\">".$row[IdProgTarea]."</font></td>";?>
      <td><?php=$row[FechaDe]?></td>
      <td><div align="center">&nbsp;<?php echo $row[HoraDe]?></div></td>
      <td><div align="center">&nbsp;<?php echo $row[HoraA]?></div></td>
      <td><div align="center">&nbsp;<?php echo $row[Actividad]?></div></td>
      <td><div align="center">&nbsp;<?php echo $row[Observaciones]?></div></td>
  </tr>
</table>
<br>
<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr align="center">
    <th colspan="8"><font size="3">REALIZACION&nbsp;/&nbsp;REVISION</font></th>
  </tr>
  <tr align="center">
    <th><font size="2">Nro.</font></th>
    <th><font size="2">Realizado por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Realizacion</font></th>
    <th><font size="2">Revisado Por </font></th>
    <th><font size="2">Fecha/Hora</font></th>
    <th><font size="2">Aprobacion</font></th>
    <th><font size="2">Revision</font></th>
  </tr>
<?php		
		$sql = "SELECT *, DATE_FORMAT(FechaProceso, '%d/%m/%Y %H:%i:%s') AS FechaProceso, DATE_FORMAT(RevisadoPorFecha, '%d/%m/%Y %H:%i:%s') AS RevisadoPorFecha FROM progtareasdiaria1 WHERE IdProgTarea='$IdProgTarea'";
		$rs=mysql_db_query($db,$sql,$link);
		print mysql_error();
		while($tmp=mysql_fetch_array($rs)){
			print "<tr>";
			print "<td align=\"center\">$tmp[IdProgTarea1]</td>";
		  	$sql1 = "SELECT * FROM users WHERE login_usr='$tmp[RealizadoPor]'";
		  	$result1 = mysql_db_query($db,$sql1,$link);
		  	$row1 = mysql_fetch_array($result1);
			print "<td align=\"center\">&nbsp;$row1[nom_usr] $row1[apa_usr] $row1[ama_usr]</td>";
			print "<td align=\"center\">$tmp[FechaProceso]</td>";
			print "<td align=\"center\">$tmp[Realizacion]</td>";
		  	$sql2 = "SELECT * FROM users WHERE login_usr='$tmp[RevisadoPor]'";
		  	$result2 = mysql_db_query($db,$sql2,$link);
		  	$row2 = mysql_fetch_array($result2);
			print "<td align=\"center\">&nbsp;$row2[nom_usr] $row2[apa_usr] $row2[ama_usr]</td>";
			if($tmp[RevisadoPorFecha]=="00/00/0000 00:00:00") print "<td>&nbsp;</td>";
			else print "<td align=\"center\">$tmp[RevisadoPorFecha]</td>";
			print "<td align=\"center\">&nbsp;$tmp[Aprobacion]</td>";
			if($tmp["Revisado"]==1) print "<td align=\"center\"><img src=\"images/ok.gif\" border=\"0\"></td>";
			else {
				if($_SESSION[tipo]=="A"  || $tmp[RealizadoPor]!=$_SESSION[login]) print "<td align=\"center\"><a href=\"prog_tareasdiariarev.php?do=revisar&IdProgTarea=$IdProgTarea&IdProgTarea1=$tmp[IdProgTarea1]\"><img src=\"images/no3.gif\" border=\"0\"></a></td>";
				else print "<td align=\"center\"><img src=\"images/no2.gif\" border=\"0\"></td>";				
			}
			print "</tr>";
		}
  		 ?>  
</table>
<br>
<form action="prog_tareasdiariarev.php" method="post" name="form2" id="form2" onKeyPress="return Form()">
	<input name="IdProgTarea" type="hidden" value="<?php echo $IdProgTarea;?>">
	<input name="IdProgTarea1" type="hidden" id="IdProgTarea1" value="<?php=$_GET[IdProgTarea1]?>">
	<input name="action" type="hidden" id="action" value="<?php echo $do;?>">
	<?php if($do =="revisar"){?>
	<table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr align="center">
      <th colspan="4"><font size="3">REVISION Nro. 
      <?php=$IdProgTarea1?></font></th>
    </tr>
    <tr align="center">
      <th><font size="2">Revisado por </font></th>
      <th><font size="2">Aprobacion</font></th>
      <th><font size="2">Observaciones</font></th>
    </tr>
    <tr align="center">
      <!-- <td><?php=$lstUsuario[$_SESSION[login]]?></td> -->
	  <?php 
		  	$sql3 = "SELECT * FROM users WHERE login_usr='$_SESSION[login]'";
		  	$result3 = mysql_db_query($db,$sql3,$link);
		  	$row3 = mysql_fetch_array($result3);
			print "<td>&nbsp;$row3[nom_usr] $row3[apa_usr] $row3[ama_usr]</td>";?>
	  
      <td> <font size="2" face="Arial, Helvetica, sans-serif">
        <input name="Aprobacion" type="radio" value="SI" checked <?php if ($row3[Aprobacion]=="SI") echo "checked";?>>
      SI</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NO" <?php if ($row3[Aprobacion]=="NO") echo "checked";?>>
      NO</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NA" <?php if ($row3[Aprobacion]=="NA") echo "checked";?>>
      NA</font> </td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
        <textarea name="Observaciones" cols="15" id="Observaciones"><?php echo $row3[Observac]?></textarea>
      </font></td>
    </tr>
    <tr align="center">
      <td height="50" colspan="4">
        <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR REVISION"<?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Terminar" value="RETORNAR"></td>
    </tr>
  </table>
	<?php } else {?>
  <table width="80%"  border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr align="center">
      <th colspan="4"><font size="3">REALIZACION</font></th>
    </tr>
    <tr align="center">
      <th><font size="2">Realizado por </font></th>
      <th><font size="2">Realizacion</font></th>
      <th><font size="2">Observaciones</font></th>
    </tr>
    <tr align="center">
      <!-- <td><?php=$lstUsuario[$_SESSION[login]]?></td>-->
	  <?php 
		  	$sql4 = "SELECT * FROM users WHERE login_usr='$_SESSION[login]'";
		  	$result4 = mysql_db_query($db,$sql4,$link);
		  	$row4 = mysql_fetch_array($result4);
			print "<td>&nbsp;$row4[nom_usr] $row4[apa_usr] $row4[ama_usr]</td>";?>
	  
      <td> <font size="2" face="Arial, Helvetica, sans-serif">
        <input name="Aprobacion" type="radio" value="SI" checked <?php if ($row3[Aprobacion]=="SI") echo "checked";?>>
      SI</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NO" <?php if ($row3[Aprobacion]=="NO") echo "checked";?>>
      NO</font> <font size="2" face="Arial, Helvetica, sans-serif"><br>
&nbsp;
      <input type="radio" name="Aprobacion" value="NA" <?php if ($row3[Aprobacion]=="NA") echo "checked";?>>
      NA</font> </td>
      <td><font size="2" face="Arial, Helvetica, sans-serif">
        <textarea name="Observaciones" cols="15" id="Observaciones"><?php echo $row3[Observac]?></textarea>
      </font></td>
    </tr>
    <tr align="center">
      <td height="50" colspan="4">
        <input name="INSERTAR" type="submit" onClick="Mensaje()" id="INSERTAR" value="INSERTAR REALIZACION"<?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <input type="submit" name="Terminar" value="RETORNAR"></td>
    </tr>
  </table>
  <?php }?>
</form>
<script language="JavaScript">
		<!-- 
		<?php if($errorMsg) print "alert(\"$errorMsg\");";
		?>
function Mensaje()
{
<?php
	include ("conexion.php");
	$sql = "SELECT * FROM progtareasdiaria1 WHERE IdProgTarea='$IdProgTarea'";
	$rs  = mysql_db_query($db,$sql,$link);
	$tmp = mysql_fetch_array($rs);
	$val = $tmp[Realizacion];
	if (isset($val))
	{	//$x = 1;
		 print "alert ('La Tarea ya fue realizada\\n\\nMensaje generado por GesTor F1');";
	}		
?>
}
		
//-->
</script>
<?php include("top_.php");?>
s