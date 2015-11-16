<div align="center"><span class="Estilo14"> <span class="Estilo11">
  <?php $tit= "Control de Cuentas";$tipo="Column3D";
		  if(isset($fecha1) && $fecha2)
			{
				$sql_alt=" AND a.fecha BETWEEN '$fecha1' AND '$fecha2'";
			}
			else
			{
				$sql_alt="";
			}
		  $sql_dat="SELECT COUNT(bloquear) as num, CASE WHEN bloquear = '0' THEN 'Activos' WHEN bloquear = '1' THEN 'Bloqueados' WHEN bloquear = '2' THEN 'Eliminados' END  AS nom FROM users GROUP BY bloquear;";
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC'  baseFontColor='#000000' baseFontColor='#000000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
		echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum4", $tam1, $tam2, false, false);
?>
  </span>
</span></div>