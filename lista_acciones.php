<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require_once('funciones.php');
$objti=_clean($objti);
$objti=SanitizeString($objti);
$login=$_SESSION["login"];

include("conexion.php");
if (isset($varia3) && $varia3=="creacion")
{	$sql2 = "SELECT * FROM planif_estrategica WHERE TipoPlanifica='$varia2' AND NumPlanif='$NumPlanif' AND ObjTi='$objti'";
	$result2=mysql_query($sql2);
	$row2=mysql_fetch_array($result2);
	
	$val = explode("|",$row2['Accion']);
	$accion_obj = $val[$posi]." (Objetivo: ".$row2['ObjTi'].")";
	$sql3 = "INSERT INTO ordenes (fecha, time, cod_usr, desc_inc,tipo,origen,nomb_archivo,area,dominio,objetivo,ci_ruc,id_anidacion,hash_archivo,observaciones) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$accion_obj','L','1.4','','0','0','0','0','0','0','0')";
	mysql_query($sql3);
	$sql5 = "SELECT MAX(id_orden) AS Ord FROM ordenes";
	$result5 = mysql_query($sql5);
	$row5 = mysql_fetch_array($result5);
	$ord="";
	if($row2['orden']=="")
	{
		for($jj=0;$jj<count($val)-1;$jj++)
		{
			if($jj==$posi){$ord=$ord."$row5[Ord]|";}
			else{$ord=$ord."|";}
		}
	}
	else
	{	
		$val2 = explode("|",$row2['orden']);
		for($jjj=0;$jjj<count($val)-1;$jjj++)
		{
			if($jjj==$posi){$ord=$ord.$row5['Ord']."|";}
			else{$ord=$ord."$val2[$jjj]|";}
		}
	}
	$sql6="INSERT INTO ".
	"asignacion (id_orden,nivel_asig,criticidad_asig,prioridad_asig,asig,fecha_asig,hora_asig,fechaestsol_asig,reg_asig,diagnos,escal,date_esc,time_esc,fechasol_esc,area) ".
	"VALUES('$row5[Ord]','2','2','2','$row2[RespPlanifica]','".date("Y-m-d")."','".date("H:i:s")."','$row2[FechaPlanifica]','$login','Planificacion Estrategica - Actividad a Corto Plazo','0','".date("Y-m-d")."','".date("H:i:s")."','$row2[FechaPlanifica]','Mesa')";
	mysql_query($sql6);	

	$sql4="UPDATE planif_estrategica SET orden='$ord' WHERE TipoPlanifica='$varia2' AND NumPlanif='$NumPlanif' AND ObjTi='$objti'";
	mysql_query($sql4);
}
if (isset($Terminar)) header("location:actividades_pre.php?plan=$varia2&varia2=$varia2&numer=$NumPlanif&ObjNegocio=$objnegocioaux&actividad=1");	
if (isset($Nacciones))
{	$sql3 = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica FROM planif_estrategica WHERE TipoPlanifica='$varia2' AND NumPlanif='$NumPlanif'";
	$res3 = mysql_query($sql3);
	$row3 = mysql_fetch_array($res3);
	$val  = explode("|",$row3['Accion']);
	if ( $row3['orden'] == "SI" )
	$msg = "No se puede anadir mas acciones porque ya se crearon ordenes de trabajo";
	else
	{	if (count($val)-1<0) header("location:actividades.php?plan=$varia2&numer=$NumPlanif&sw=2&fil=1&objti=$objti&objnegocioaux=$objnegocioaux");
		else header("location:actividades.php?plan=$varia2&numer=$NumPlanif&sw=2&objti=$objti&objnegocioaux=$objnegocioaux");
	}
	
}
//echo "hola";
include("top.php");
$sql3 = "SELECT *, DATE_FORMAT(FechaPlanifica, '%d/%m/%Y') AS FechaPlanifica FROM planif_estrategica WHERE TipoPlanifica='$varia2' AND NumPlanif='$NumPlanif' AND ObjTi='$objti'";
$res3 = mysql_query($sql3);
$row3 = mysql_fetch_array($res3);
$sql  = "SELECT * FROM users WHERE login_usr='$row3[RespPlanifica]'";
$res  = mysql_query($sql);
$row  = mysql_fetch_array($res);
$name = $row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'];
?>
<html>
<head>
</head>
<body>
<table width="85%" background="images/fondo.jpg" border="1">
  <tr> 
      <th colspan="4" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
         <?php echo "PLANIFICACION ESTRATEGICA - ".$varia2;?></font></th>
  </tr>
  <tr>
  	<td colspan="4">
		<table width="100%">
		<tr>
			<td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Nro Planificacion:</b></font></td>							
			<td width="250"><?php echo $row3['NumPlanif']?></td>
			<td width="85"><font face="arial, verdana" size="2"><b>Responsable:</b></font></td>
			<td width="149"><?php echo $name;?></td>			
		</tr>
		<tr>
          <td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Objetivo Negocio:</b></font></td>							
			<td width="250"><?php 
			echo $row3['ObjNegocio'];?></td>
			<td width="85"><font face="arial, verdana" size="2"><b>Costo:</b></font></td>
			<td width="149"><?php 
			$costo_tot=explode("|",$row3['costo']);
			echo "$"."us ".array_sum($costo_tot);
			?></td>
		</tr>
		<tr>
          <td width="126"><font face="arial, verdana" size="2"><b>&nbsp;Objetivo TI:</b></font></td>							
		  <td width="250"><?php=$objti;?></td>
          <td width="85"><font face="arial, verdana" size="2"><b>Fecha:</b></font></td>
		  <td width="149"><?php echo $row3['FechaPlanifica'];?></td>
		</tr>
		</table>
	</td>
  </tr>
  <tr> 
      <td width="3%" height="16" align="center" bgcolor="#006699"><font color="#FFFFFF" size="1" face="Arial, Helvetica">Nro.</font></td>
	  <td width="73%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">DESCRIPCION ACCION</font></td>
	  <td width="11%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">COSTO</font></td>
	  <?php if (isset($varia2) && $varia2=="CORTO PLAZO") {?>
	  <td width="13%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">Nro. ORDEN</font></td>
	  <?php }?>
  </tr>
 <?php
	$val  = explode("|",$row3['Accion']);
	$val_c  = explode("|",$row3['costo']);
	$val2  = explode("|",$row3['orden']);
	if (count($val)-1>0)
	{	for ($i=0; $i< count($val)-1; $i++)
		{ 	$c = $i + 1	;
			echo "<tr><td align=center>$c</td>";
			echo "<td>&nbsp;".$val[$i]."</td>";
			echo "<td align=center>&nbsp;".$val_c[$i]."</td>";
			if ($varia2=="CORTO PLAZO") {
				if($val2[$i]==""){echo "<td align=center><a href=\"lista_acciones.php?varia2=$varia2&varia3=creacion&NumPlanif=$NumPlanif&posi=$i&op=$op&objti=$objti&objnegocioaux=$objnegocioaux\">CREAR ORDEN</a></td>";}
				else {echo "<td align=center><a href=\"ver_orden.php?id_orden=$val2[$i]\" target=\"_blank\">Orden Nro.$val2[$i] </a></td>";}
			}
			//}

			echo "</tr>";
		}
	}
	else
	{	if (!(empty($row3['Accion'])))	
		{	echo "<tr align=center><td>1</td>";
			echo "<td>".$row3['Accion']."</td>";
			echo "</tr>";
		}	
	}	
 ?> 
</table>
<form action="lista_acciones.php" method="post">
<input name="varia2" type="hidden" value="<?php echo $varia2;?>"> 
<input name="NumPlanif" type="hidden" value="<?php echo $NumPlanif;?>"> 
<input name="op" type="hidden" value="<?php echo $op;?>">
<input name="objti" type="hidden" value="<?php=$objti;?>">
  <input name="objnegocioaux" type="hidden" id="objnegocioaux" value="<?php=$objnegocioaux;?>">
<center>

<input type="submit" name="Nacciones" value="AÑADIR ACCIONES">
&nbsp;&nbsp;&nbsp;&nbsp;

<input type="submit" name="Terminar" value="RETORNAR"><br>
</center>
</form>

</body>
</html>
 <script language="JavaScript">
		<!-- 
		<?php if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>

</script>

