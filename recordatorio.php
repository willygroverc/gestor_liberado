<?php
//recordatorio
include("conexion.php");
include("env_correo.php");
$correos=array();
$mensajes=array();
$sql_adm="SELECT email FROM users WHERE login_usr='admin'";
$res_adm=mysql_db_query($db,$sql_adm,$link);
$row_adm=mysql_fetch_array($res_adm);
$asunto = "Gestor F1 - Recordatorio";

//sin_asignación
$sql_na="SELECT DISTINCT a.id_orden, a.fecha, a.cod_usr, a.desc_inc FROM ordenes a LEFT JOIN asignacion b USING (id_orden) WHERE b.id_orden IS NULL";
$res_na=mysql_db_query($db,$sql_na,$link);
while($row_na=mysql_fetch_array($res_na)){
	$sql_usr="SELECT email FROM users WHERE login_usr='$row_na[cod_usr]'";
	$res_usr=mysql_db_query($db,$sql_usr,$link);
	$row_usr=mysql_fetch_array($res_usr);
	$mensaje=" Orden $row_na[id_orden] pendiente de asignación \n Fecha: $row_na[fecha] \n Usuario: $row_na[cod_usr] \n Descripción: $row_na[desc_inc]";
//correo tecnico, administrador
	array_push($correos,$row_usr[email],$row_adm[email]);
	array_push($mensajes,$mensaje,$mensaje);
}
/*
//no_solucionadas
$sql_ns="SELECT DISTINCT a.id_orden, a.asig, a.fecha_asig, a.diagnos FROM asignacion a LEFT JOIN solucion b USING (id_orden) WHERE b.id_orden IS NULL";
$res_ns=mysql_db_query($db,$sql_ns,$link);
while($row_ns=mysql_fetch_array($res_ns)){
	$sql_usr="SELECT email FROM users WHERE login_usr='$row_ns[asig]'";
	$res_usr=mysql_db_query($db,$sql_usr,$link);
	$row_usr=mysql_fetch_array($res_usr);
	$mensaje=" Orden $row_ns[id_orden] pendiente de solucion \n Fecha: $row_ns[fecha_asig] \n  Diagnostico: $row_ns[diagnos]";
//correo tecnico, administrador
	array_push($correos,$row_usr[email]);
	array_push($mensajes,$mensaje);
}*/

//sin_conformidad
$sql_sc="SELECT DISTINCT a.id_orden, a.fecha_sol, a.detalles_sol FROM solucion a LEFT JOIN conformidad b USING (id_orden) WHERE b.id_orden IS NULL";
$res_sc=mysql_db_query($db,$sql_sc,$link);
while($row_sc=mysql_fetch_array($res_sc)){
	$sql_usr="SELECT b.email FROM ordenes a, users b where a.cod_usr=b.login_usr AND a.id_orden='$row_sc[id_orden]'";
	$res_usr=mysql_db_query($db,$sql_usr,$link);
	$row_usr=mysql_fetch_array($res_usr);
	$mensaje=" Orden $row_sc[id_orden] pendiente de conformidad \n Fecha: $row_sc[fecha_sol] \n  Solucion: $row_sc[detalles_sol]";
//correo tecnico, administrador
	array_push($correos,$row_usr[email]);
	array_push($mensajes,$mensaje);
}

//Solución atrasada
$sql_ns="SELECT DISTINCT a.id_orden, a.asig, a.fecha_asig, a.diagnos, (To_days(NOW()) - TO_DAYS(fechaestsol_asig)) as diferencia FROM asignacion a LEFT JOIN solucion b USING (id_orden) WHERE b.id_orden IS NULL";
$res_ns=mysql_db_query($db,$sql_ns,$link);
while($row_ns=mysql_fetch_array($res_ns)){
	$sql_usr="SELECT email FROM users WHERE login_usr='$row_ns[asig]'";
	$res_usr=mysql_db_query($db,$sql_usr,$link);
	$row_usr=mysql_fetch_array($res_usr);
	$mensaje=" Orden $row_ns[id_orden] pendiente de solucion \n Fecha: $row_ns[fecha_asig] \n  Diagnostico: $row_ns[diagnos] \n"; 			    if($row_ns[diferencia] > 0) $mensaje.=" <b>Solución Retrasada en $row_ns[diferencia] dia(s).</b> \n";
//correo tecnico, administrador
	array_push($correos,$row_usr[email]);
	array_push($mensajes,$mensaje);
}	

//Envio de todos los correos
enviar($correos,$asunto,$mensajes);
?>