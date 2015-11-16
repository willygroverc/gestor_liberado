<div align="center"><span class="Estilo11">
  <?php $tit= "Estado de los Equipos";
$tipo="Column3D";
if(isset($fecha1) && $fecha2)
{
	$sql_alt=" WHERE FechPruFunc BETWEEN '$fecha1' AND '$fecha2'";
}
	else
{
	$sql_alt="";
}
$sql_ob="SELECT * FROM fichas_parametros WHERE id_param='1'";
$res_ob=mysql_db_query($db,$sql_ob,$link);
$row_ob=mysql_fetch_array($res_ob);
//			$sql_dat="SELECT COUNT(YEAR(FechPruFunc)) AS num,YEAR(FechPruFunc)  AS nom FROM datfichatec".$sql_alt." GROUP BY nom";
//			$sql_dat="SELECT *, DATE_FORMAT(FechPruFunc,'%d / %m / %Y') as FechPruFunc, DATEDIFF(CURRENT_DATE(), FechPruFunc) AS dias FROM datfichatec WHERE DATEDIFF(CURRENT_DATE(), FechPruFunc) >= '$row_ob[obj_cad]' AND DATEDIFF(CURRENT_DATE(), FechPruFunc) < '$row_ob[obj_rcad]' ORDER BY AdicUSI";
//		  	$sql_dat="SELECT COUNT(bloquear) as num, CASE WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) AS dias = '0' THEN 'Activos' WHEN bloquear = '1' THEN 'Bloqueados' WHEN bloquear = '2' THEN 'Eliminados' END  AS nom FROM users GROUP BY bloquear;";
$sql_dato="CREATE TEMPORARY TABLE boris SELECT CASE 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_cad] AND DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_rcad] THEN '2. Caducados' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_rcad] AND DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_obs] THEN '3. Recaducados' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) > $row_ob[obj_obs] THEN '4. Obsoletos' 
WHEN DATEDIFF(CURRENT_DATE(), FechPruFunc) < $row_ob[obj_cad] THEN '1. Vigentes' 
END AS nume FROM datfichatec;";
mysql_db_query($db,$sql_dato,$link);
$sql_dat="SELECT nume AS nom, COUNT(nume) AS num  FROM boris GROUP BY nume;";
list($dat, $prom)=datos_link($sql_dat,$tit."' showLabels='$show_lab'  showValues='$show_values' bgColor='#CCCCCC' baseFontColor='#000000");
$sql_dat=ereg_replace("'", "�", $sql_dat);
echo renderChart("Charts/$tipo.swf", "", $dat, "FactorySum1", $tam1, $tam2, false, false);
?>
</span></div>
