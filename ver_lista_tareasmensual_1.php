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
        DE TAREAS MENSUALES</u></strong></font></div></td>
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
		$sql_ta="SELECT HoraDe, HoraA, m_asig, Actividad, IdProgTarea, Dia FROM progtareasmensual WHERE IdProgTarea IN($lista) ORDER BY Dia ASC";
	}
	if($selec=="Asignado")
	{
		$lista=str_replace("|*|",",",$asignado);
		$lista=str_replace("@","'",$lista);
		$sql_ta="SELECT HoraDe, HoraA, m_asig, Actividad, IdProgTarea, Dia FROM progtareasmensual WHERE m_asig IN($lista) ORDER BY Dia ASC";	
	}
	$result_ta=mysql_db_query($db,$sql_ta,$link);
	$result_ta2=mysql_db_query($db,$sql_ta,$link);
	$row_ta0=mysql_num_rows($result_ta);
	$limbo=0;
	$porc=90/$row_ta0;
	while($row_ta2=mysql_fetch_array($result_ta2))
	{
		$nom_resp=nom_comp($row_ta2[m_asig]);
		if($row_ta2[m_asig]=="0"){echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">Todos</font></strong></td>";}
		else
		{ echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nom_resp</font></strong></td>";}
	}	
	echo "</tr><tr align=\"center\">";
	while($row_ta=mysql_fetch_array($result_ta))
	{
		echo "<td width=".$porc."%><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$row_ta[Actividad]<br>$row_ta[Dia] de cada mes&nbsp;&nbsp;De:$row_ta[HoraDe]&nbsp;&nbsp;A:$row_ta[HoraA]</font></strong></td>";
		$limbo++;
		$id_prog[$limbo]=$row_ta[IdProgTarea];
	}	
	?>
  </tr>
  <?php 
	$lista2=str_replace("|*|",",",$mes0);
	$mes=$lista2;
	$ano="2006";
	$meses=explode(",",$mes); 
	$num_meses=count($meses);
	for($lim=0;$lim<$num_meses;$lim++)
  	{
		switch ($meses[$lim]) 
		{
			case "1": $num_dias="31"; $nom_mes="Enero"; break;
			case "2": 
				$ano_now=date("Y");
				$dif_ano=$ano-2000;
				$resto=$dif_ano % 4;
				if($resto==0){$num_dias="29";} 
				else{$num_dias="28";}
				$nom_mes="Febrero";
			break;
			case "3": $num_dias="31"; $nom_mes="Marzo"; break;
			case "4": $num_dias="30"; $nom_mes="Abril"; break;
			case "5": $num_dias="31"; $nom_mes="Mayo"; break;
			case "6": $num_dias="30"; $nom_mes="Junio"; break;
			case "7": $num_dias="31"; $nom_mes="Julio"; break;
			case "8": $num_dias="31"; $nom_mes="Agosto"; break;
			case "9": $num_dias="30"; $nom_mes="Septiembre"; break;
			case "10": $num_dias="31"; $nom_mes="Octubre"; break;
			case "11": $num_dias="30"; $nom_mes="Noviembre"; break;
			case "12": $num_dias="31"; $nom_mes="Diciembre"; break;
		}
		if(strlen($meses[$lim])==1){$meses[$lim] = "0".$meses[$lim];}
		$nombre_mes[$lim]=$nom_mes;
		$dia_ini[$lim]="$ano-$meses[$lim]-01";
		$dia_ini2[$lim]="01-$meses[$lim]-$ano";
		$dia_fin[$lim]="$ano-$meses[$lim]-$num_dias";
		$dia_fin2[$lim]="$num_dias-$meses[$lim]-$ano";
	}	
  
  for($lim=0;$lim<$num_meses;$lim++)
  {
		echo "<tr>";
		echo "<td><div align=\"center\"><strong><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">$nombre_mes[$lim]<br>Del: $dia_ini2[$lim]<br>Al: $dia_fin2[$lim]</font></strong></div></td>";
		for($fer=1;$fer<=$row_ta0;$fer++)
		{
			$sql_ta6="SELECT RealizadoPor, RevisadoPor, DATE_FORMAT(FechaProceso,'%d/%m/%Y %H:%i:%s') as FechaProceso, DATE_FORMAT(RevisadoPorFecha,'%d/%m/%Y %H:%i:%s') as RevisadoPorFecha FROM progtareasmensual1 WHERE IdProgTarea='$id_prog[$fer]' AND FechaProceso BETWEEN '$dia_ini[$lim]' AND '$dia_fin[$lim]'";
			$row_ta6=mysql_fetch_array(mysql_db_query($db,$sql_ta6,$link));
			$nom_rea=nom_comp($row_ta6[RealizadoPor]);
			$nom_rev=nom_comp($row_ta6[RevisadoPor]);
			echo "<td><font color=\"#000000\" size=\"1\" face=\"Arial, Helvetica, sans-serif\">&nbsp;Rea: $nom_rea<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$row_ta6[FechaProceso]<br>&nbsp;Rev: $nom_rev<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$row_ta6[RevisadoPorFecha]</font></td>";
		}			
		echo "</tr>";
  }
 ?>
</table>
<br>
</body>
</html>