<div align="center"><span class="Estilo11">
  <?php $tit= "Numero de Ordenes";
		  $tipo="Line";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt="  WHERE fecha BETWEEN '$fecha1' AND '$fecha2'";
				if(!empty($tipo_usr))	{
					if($tipo_usr=="T")
						{
							$sql_usr="  AND cod_usr='$login'";
						}
				}
			}
				else
			{
				$sql_alt="";
				if(!empty($tipo_usr))	{
					if($tipo_usr=="T")
					{
					$sql_usr=" WHERE cod_usr='$login' ";
					}
				}
			}
		if(!empty($sql_usr))	{
		  $sql_dat="SELECT count(*) AS num, DATE_FORMAT(fecha, '%d / %m') AS nom FROM ordenes".$sql_alt.$sql_usr." GROUP BY fecha";
		} else	{
		  $sql_dat="SELECT count(*) AS num, DATE_FORMAT(fecha, '%d / %m') AS nom FROM ordenes".$sql_alt." GROUP BY fecha";
		}
		  list($dat, $prom)=datos($sql_dat,$tit."' labelStep='1' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "�", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>
          </span></div>
