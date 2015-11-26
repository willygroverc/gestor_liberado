<div align="center"><span class="Estilo11">
  <?php $tit= "Niveles";
		  $tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{  
				$sql_alt=" AND o.fecha BETWEEN '$fecha1' AND '$fecha2'";
				$url="%26AA=$AA%26MA=$MA%26DA=$DA%26AE=$AE%26ME=$ME%26DE=$DE";
			}
				else
			{    //echo "sin fecha";
				$sql_alt="";
				$url="";
			}
			if(!$n){
				$n=0;
			}
			switch($n){
				case 1:
					$sql_dat="SELECT CONCAT('niveles.php?n=2%26dominio_cod=', id_dominio, '$url') AS id, COUNT(*) AS num, d.dominio AS nom FROM dominio d, ordenes o WHERE d.id_area='$area_cod' AND d.id_dominio=o.dominio $sql_alt GROUP BY  id_dominio;";
					list($dat, $prom)=datos_link($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
					break;
				case 2:
					$sql_dat="SELECT COUNT(*) AS num, b.objetivo AS nom FROM objetivos b, ordenes o WHERE b.id_objetivo=o.objetivo AND o.dominio='$dominio_cod' $sql_alt GROUP BY b.id_objetivo;";
					list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
					break;
/*				case 3:
					$sql_dat="SELECT COUNT(*) AS num, d.dominio AS nom FROM dominio d, ordenes o WHERE d.id_area='$a' AND d.id_dominio=o.dominio $sql_alt GROUP BY id_dominio;";
					list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
					break;*/
				default :
					$sql_dat="SELECT CONCAT('niveles.php?n=1%26area_cod=', area_cod, '$url') AS id, count(*) AS num, area_nombre AS nom FROM area a, ordenes o WHERE a.area_cod=o.area $sql_alt GROUP BY area;";	
					//echo $sql_dat;
					list($dat, $prom)=datos_link($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
					//echo $dat;
					break;
			}
		  //$sql_dat=ereg_replace("'", "ç", $sql_dat);
		  //echo $sql_dat;
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>
</span></div>