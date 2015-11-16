<div align="center">
  <span class="Estilo11">  </span>  <span class="Estilo11"><?php $tit= "Incidentes";$tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
			}
			else
			{
				$sql_alt="";
			}
		  $sql_dat="(SELECT count(*) AS num, CONCAT(c.dominio ,' - ', b.objetivo) AS nom FROM ordenes AS a, objetivos AS b, dominio AS c WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND b.objetivo LIKE '%Incidente%'".$sql_alt.$sql_usr." GROUP BY a.dominio) UNION (SELECT count(*) AS num, CONCAT(LEFT(c.dominio,5) ,' - ', LEFT(b.objetivo,15) ,' - ', d.punto) AS nom FROM ordenes AS a, objetivos AS b, dominio AS c, puntos AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND a.punto=d.id_punto AND d.punto LIKE '%Incidente%'".$sql_alt.$sql_usr." GROUP BY a.objetivo)";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum3", $tam1, $tam2, false, false);
?>

  </span></div>