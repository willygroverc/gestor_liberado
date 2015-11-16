<div align="center"><span class="Estilo11">
 <?php 
 include ("../conexion.php");
 $tit= "Numero de Ordenes";
		$tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND fecha BETWEEN '$fecha1' AND '$fecha2'";
					if($tipo_usr=="T")
						{
						$sql_usr="  AND login_usr='$login'";
						}
			}
			else
			{
				$sql_alt="";
					if($tipo_usr=="T")
					{
					$sql_usr=" AND login_usr='$login' ";
					}
			}
		  $sql_dat="SELECT count( * ) AS num, cod_usr AS nom FROM `ordenes` WHERE cod_usr <> 'SISTEMA'".$sql_alt.$sql_usr." GROUP BY cod_usr ORDER BY num DESC";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values'  bgColor='#CCCCCC' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum2", $tam1, $tam2, false, false);
?>
</div>