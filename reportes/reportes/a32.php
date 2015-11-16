<div align="center"><span class="Estilo11">
 <?php 
 include ("../conexion.php");
 //$sqlU="SELECT nom_usr, apa_usr,ama_usr FROM users WHERE login_usr = '$desc.$sql_alt'";
 //$resultU=mysql_query($sqlU);
 //$filaU=mysql_fetch_array($resultU);
 $tit= "Normas mas visitadas de: ".$desc.$sql_alt;
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
			
			if(!empty($tipo_usr))	{
			$sql_dat="SELECT count(DISTINCT p.cod_pnp) AS num, p.n_nombre AS nom FROM t_pnp AS p WHERE login_usr = '$desc.$sql_alt' GROUP BY pnp";
		  } else {
			$sql_dat="SELECT count(DISTINCT p.cod_pnp) AS num, p.n_nombre AS nom FROM t_pnp AS p WHERE login_usr = '$desc' GROUP BY pnp";
		  }
		  list($dat, $prom)=datos($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values'  bgColor='#CCCCCC' baseFontColor='#000");
		  $sql_dat=ereg_replace("'", "ç", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum2", $tam1, $tam2, false, false);
?>
</div>