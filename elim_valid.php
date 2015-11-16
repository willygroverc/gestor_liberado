<?php
function elim_usuario($user_x){
	require ("conexion.php");
	$auxbo=array();
	$sqlbo= "SELECT max(id_asig) as maxi FROM asignacion group by id_orden";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo))  array_push($auxbo,"'".$rowbo['maxi']."'");
	$auxbo=implode(", ",$auxbo);
	
	$auxsol=array();
	$sqlsol= "SELECT id_orden FROM solucion";
	$resultsol=mysql_query($sqlsol);
	while ($rowsol = mysql_fetch_array($resultsol))  array_push($auxsol,"'".$rowsol['id_orden']."'");
	$auxsol=implode(", ",$auxsol);
	
	$sql_asig="SELECT a.asig FROM asignacion a, solucion s WHERE a.id_asig IN ($auxbo) AND a.asig='$user_x' AND a.id_orden NOT IN ($auxsol)";
	$res_asig=mysql_query($sql_asig);
	if(mysql_fetch_array($res_asig)) return false;
	else return true;
}
?>