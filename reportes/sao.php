<?php
include("Includes/FusionCharts.php");
include("../conexion.php");
include("func_datos.php");
$sql_usr1="SELECT * FROM users WHERE tipo2_usr='A';";
$res_usr1=mysql_db_query($db,$sql_usr1,$link);
echo mysql_error();
$usr="usrboris";
while($row_usr1=mysql_fetch_array($res_usr1)){
	$usr.=",".$row_usr1['email'];
}
$usr=ereg_replace("usrboris,","",$usr);
$headers  = "From: Gestor TI <admin@jesusnazareno.coop>\n";
$headers .= "\n";
$sql_pmi="SELECT * FROM pmi_sao WHERE ind = '1'";
$res_pmi=mysql_db_query($db,$sql_pmi,$link);
while($row_pmi=mysql_fetch_array($res_pmi)){
	//echo "<br>".$row_pmi['nom_arch']."<br>";
	include("reportes/".$row_pmi['nom_arch']."sao.php");
	//echo $prom."<br>";
	include("reportes/a_alrt.php");
	//implementacion de la alerta
	$sql_sao="SELECT * FROM pmi_nivel WHERE id_report = '$row_pmi[id_report]' ORDER BY date DESC LIMIT 0,3";
	$res_sao=mysql_db_query($db,$sql_sao,$link);
	//echo $sql_sao."<br>";
	$ver=0;
	while($row_sao=mysql_fetch_array($res_sao)){
		if($row_pmi['nivel']==$row_sao['nivel']) $ver++;
	}
	if($ver==3){
		//aqui realizar la accion predeterminada
		$msj="SAO - Alert: \n
Alerta en el reporte: $row_pmi[nom] \n. 
Verificar en el sistema Gestor TI"; 
		//echo $msj."<br>";
		mail($usr,"Alerta - SAO",$msj,$headers);
	}
}
?>