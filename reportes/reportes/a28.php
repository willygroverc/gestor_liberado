<div align="center"><span class="Estilo11">
  <?php $tit= "Alta de Equipos por Año";
		  $tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" WHERE FechPruFunc BETWEEN '$fecha1' AND '$fecha2'";
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
		  
			$sql_dat="SELECT COUNT(YEAR(FechPruFunc)) AS num,YEAR(FechPruFunc)  AS nom FROM datfichatec".$sql_alt." GROUP BY nom";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>
          </span></div>
