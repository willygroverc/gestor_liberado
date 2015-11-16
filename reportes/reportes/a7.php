<div align="center">
  <span class="Estilo11">	
  <?php
  		 $tit= "Incidentes por Tecnico";$tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
				if($tipo_usr=="T")
						{
						$sql_usr="  AND d.login_usr='$login'";
						}
			}
			else
			{
				$sql_alt="";
				if($tipo_usr=="T")
					{
					$sql_usr=" AND d.login_usr='$login'";
					}
			}
		  if($val_area!=0) $sql_alt.=" AND a.area=$val_area";
	 	  $sql_dat="SELECT count(*) AS num, CONCAT(d.nom_usr, ' ', d.apa_usr, ' ', d.ama_usr) AS nom FROM ordenes AS a, objetivos AS b, asignacion AS c, users AS d WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.id_orden=c.id_orden AND c.asig=d.login_usr AND b.objetivo LIKE '%Incidente%'".$sql_alt.$sql_usr." GROUP BY c.asig";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC'  baseFontColor='#000000' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "�", $sql_dat);
		echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum5", $tam1, $tam2, false, false);
?>
  </span></div>