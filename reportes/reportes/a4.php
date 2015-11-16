<div align="center"><span class="Estilo11">
 <?php 
 include ("../conexion.php");
 $tit= "Numero de Ingresos";
		$tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND fecha BETWEEN '$fecha1' AND '$fecha2'";
				if(!empty($tipo_usr))	{
					if($tipo_usr=="T")
					{
							$sql_usr="  AND login_usr='$login'";
					}
				}
			}
			else
			{
				$sql_alt="";
				if(!empty($tipo_usr))	{
					if($tipo_usr=="T")
					{
						$sql_usr=" AND login_usr='$login' ";
					}
				}
			}
			if(!empty($tipo_usr))	{
			$sql_dat="SELECT count(*) AS num, login_usr AS nom FROM `registro` WHERE tipo_c LIKE 'INGRESO'".$sql_alt.$sql_usr." GROUP BY login_usr ORDER BY num DESC";
		  } else {
			$sql_dat="SELECT count(*) AS num, login_usr AS nom FROM `registro` WHERE tipo_c LIKE 'INGRESO'".$sql_alt." GROUP BY login_usr ORDER BY num DESC";
		  }
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values'  bgColor='#CCCCCC' baseFontColor='#000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum2", $tam1, $tam2, false, false);
?>
</div>