<?php
include("top_ver.php");
function nom_comp($login_us)
{
	include("conexion.php");
	$sql_nom="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login_us'";
	$row_nom=mysql_fetch_array(mysql_db_query($db,$sql_nom,$link));
	$nom_co="$row_nom[nom_usr] $row_nom[apa_usr] $row_nom[ama_usr]";
	return($nom_co);
}
?>
<html>
<head>
	<title> GesTor F1 - PRODUCCIÓN-PROAPD - CALENDARIZACIÓN</title>
    <style type="text/css">
<!--
.margin {
	border-bottom-width: 1px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: solid;
	border-left-style: none;
	border-bottom-color: #000000;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-weight: normal;
}
.text {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-style: normal;
	font-weight: normal;
}
.style16 {font-size: 11px; font-weight: bold; }
-->
    </style>
</head>
<body><p>
<?php
include("datos_gral.php");
?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center"><font size="4" face="Arial, Helvetica, sans-serif"><strong><u>PROGRAMACION 
        DE TAREAS DIARIAS</u></strong></font></div></td>
  </tr>
</table>

<br>
<table width="100%" border="1">
  <tr align="center"> 
    <td rowspan="2" height="66">
	    <table width="100%" border="0">
			<tr> 
			  <td><div align="right"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">RESPONSABLE</font></strong></div></td>
			</tr>
			<tr> 
			  <td><div align="right"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">TAREA</font></strong></div></td>
			</tr>
			<tr> 
			  <td><div align="center"><strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FRECUENCIA</font></strong></div></td>
			</tr>
      	</table>
    </td>
    <?php 
	if($selec=="Tarea" OR $selec=="")
	{
		$lista=str_replace("|*|",",",$tareas);
		$sql_ta="SELECT HoraDe, HoraA, d_asig, Actividad, IdProgTarea FROM progtareasdiaria WHERE IdProgTarea IN($lista) ORDER BY HoraDe ASC";
	}
	if($selec=="Asignado")
	{
		$lista=str_replace("|*|",",",$asignado);
		$lista=str_replace("@","'",$lista);
		$sql_ta="SELECT HoraDe, HoraA, d_asig, Actividad, IdProgTarea FROM progtareasdiaria WHERE d_asig IN($lista) ORDER BY HoraDe ASC";	
	}	
	$result_ta=mysql_db_query($db,$sql_ta,$link);
	$result_ta2=mysql_db_query($db,$sql_ta,$link);
	$row_ta0=mysql_num_rows($result_ta);
	$limbo=0;
	$porc=90/$row_ta0;
	while($row_ta2=mysql_fetch_array($result_ta2))
	{
		$nom_resp=nom_comp($row_ta2[d_asig]);
		if($row_ta2[d_asig]=="0"){echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">Todos</font></strong></td>";}
		else
		{ echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom_resp</font></strong></td>";}
	}	
	echo "</tr><tr align=\"center\">";
	while($row_ta=mysql_fetch_array($result_ta))
	{
		echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row_ta[Actividad]<br>De: $row_ta[HoraDe]&nbsp;&nbsp;A: $row_ta[HoraA]</font></strong></td>";
		$limbo++;
		$id_prog[$limbo]=$row_ta[IdProgTarea];
	}	
	?>
  </tr>
  <?php 
	$mes=$mes0;
	$ano=$ano0;
	switch ($mes) 
	{
		case "1": $num_dias="31"; break;
		case "2": 
			$ano_now=date("Y");
			$dif_ano=$ano-2000;
			$resto=$dif_ano % 4;
			if($resto==0){$num_dias="29";} 
			else{$num_dias="28";}
		break;
		case "3": $num_dias="31"; break;
		case "4": $num_dias="30"; break;
		case "5": $num_dias="31"; break;
		case "6": $num_dias="30"; break;
		case "7": $num_dias="31"; break;
		case "8": $num_dias="31"; break;
		case "9": $num_dias="30"; break;
		case "10": $num_dias="31"; break;
		case "11": $num_dias="30"; break;
		case "12": $num_dias="31"; break;
	}	
	if(strlen($mes)==1){$mes = "0".$mes;}	 
	 
  for($j=1;$j<=$num_dias;$j++)
  {
	if(strlen($j)==1){$d = "0".$j;}
	else{$d=$j;}
	echo "<tr>";
	$sql_ta3="SELECT DAYNAME('$ano-$mes-$d') as nombre_d";
	$row_ta3=mysql_fetch_array(mysql_db_query($db,$sql_ta3,$link));
	switch ($row_ta3[nombre_d]) 
	{
		case "Monday": $dia_text="Lunes"; break;
		case "Tuesday": $dia_text="Martes"; break;
		case "Wednesday": $dia_text="Miercoles"; break;
		case "Thursday": $dia_text="Jueves"; break;
		case "Friday": $dia_text="Viernes"; break;
		case "Saturday": $dia_text="Sabado"; break;
		case "Sunday": $dia_text="Domingo";	break;
	}	
	$sql_ta4="SELECT DATE_FORMAT('$ano-$mes-$d','%d / %m / %Y') as fecha";
	$row_ta4=mysql_fetch_array(mysql_db_query($db,$sql_ta4,$link));
    echo "<td><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;&nbsp;$dia_text<br>&nbsp;&nbsp;$row_ta4[fecha]</font></strong></td>";
	for($k=1; $k<=$row_ta0; $k++)
	{
		$sql_ta5="SELECT DATE_ADD('$ano-$mes-$d', INTERVAL 1 DAY) as Fecha_post";
		$row_ta5=mysql_fetch_array(mysql_db_query($db,$sql_ta5,$link));
		
		$sql_ta6="SELECT RealizadoPor, RevisadoPor FROM progtareasdiaria1 WHERE IdProgTarea='$id_prog[$k]' AND FechaProceso BETWEEN '$ano-$mes-$d' AND '$row_ta5[Fecha_post]'";
		$row_ta6=mysql_fetch_array(mysql_db_query($db,$sql_ta6,$link));
		$nom_rea=nom_comp($row_ta6[RealizadoPor]);
		$nom_rev=nom_comp($row_ta6[RevisadoPor]);
		echo "<td><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;&nbsp;Rea: $nom_rea<br>&nbsp;&nbsp;Rev: $nom_rev</font></td>";
	}
	echo "</tr>";
  }
 ?>
</table>
<br>
</body>
</html>