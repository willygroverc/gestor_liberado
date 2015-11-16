<div align="center"><span class="Estilo11">
  <?php $tit= "Numero de Incidentes por Mes";
		  $tipo="Line";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND fecha BETWEEN '$fecha1' AND '$fecha2'";
/*					if($tipo_usr=="T")
						{
						$sql_usr="  AND cod_usr='$login'";
						}*/
			}
				else
			{
				$sql_alt="";
/*					if($tipo_usr=="T")
					{
					$sql_usr=" WHERE cod_usr='$login' ";
					}*/
			}
		  
			$sql_dat="SELECT COUNT(a.id_orden) AS num, DATE_FORMAT(a.fecha,'%Y-%m') AS nom FROM ordenes AS a, objetivos AS b, dominio AS c WHERE a.dominio=b.id_dominio AND a.objetivo=b.id_objetivo AND a.dominio=c.id_dominio AND b.objetivo LIKE '%Incidente%'".$sql_alt."GROUP BY DATE_FORMAT(fecha,'%Y-%m')";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>
          </span></div>
