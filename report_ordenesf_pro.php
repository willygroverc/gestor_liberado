<?php
// version: 	1.0
// Tipo: 		Perfectivo, Correctivo
// Objetivo:	Exportar reporte en  formato PDF.
// Fecha:		08/NOV/12

// Objetivo:	Control acceso directo No autorizado.
//				Modificacion funciones php obsoletas para version 5.3
// Fecha:		22/NOV/2012 
// Autor:		Cesar Cuenca
//____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if (isset($_SESSION['tipo']) && $_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
require ("conexion.php");

if (strlen($DA) == 1){ $DA = "0".$DA; }
if (strlen($MA) == 1){ $MA = "0".$MA; }	 	 
if (strlen($DE) == 1){ $DE = "0".$DE; }
if (strlen($ME) == 1){ $ME = "0".$ME; }
$fecha_inicio=$AA."-".$MA."-".$DA;
$fecha_fin=$AE."-".$ME."-".$DE;
//==========ORDENES DE TRABAJO==========================

//NUMERO DE ORDENES ASIGNADAS/*
$tipo=$_GET['tipo'];
if ($tipo=="asignadas") {
$nombre="ASIGNADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES NO ASIGNADAS
if ($tipo=="noasignadas") {
$nombre="NO ASIGNADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']==""){
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}
//NUMERO DE ORDENES ESCALADAS
if ($tipo=="escaladas") {
$nombre="ESCALADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden,escal FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden'])
		{
			if($row_as['escal']<>'0'){$auxbo=$auxbo.",".$rowbo['id_orden'];}
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}
//NUMERO DE ORDENES NO ESCALADAS
if ($tipo=="noescaladas") {
$nombre="NO ESCALADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden,escal FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden'])
		{
			if($row_as['escal']=='0'){$auxbo=$auxbo.",".$rowbo['id_orden'];}
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES CON SEGUIMIENTO ++++++++++++++++++++++++
if ($tipo=="conseguimiento") {
$nombre="CON SEGUIMIENTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM seguimiento WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_seg DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden'])	{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//MUMERO DE ORDENES SIN SEGUIMIENTO ++++++++++++++++++++++++
if ($tipo=="sinseguimiento") {
$nombre="SIN SEGUIMIENTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)) 
	{
		$sql_as="SELECT id_orden FROM seguimiento WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_seg DESC limit 1";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']=="")	{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES CON SOLUCION
if ($tipo=="consolucion") {
$nombre="CON SOLUCION";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)) {
		$sql_as="SELECT id_orden FROM solucion WHERE id_orden='".$rowbo['id_orden']."'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden'])	{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES SIN SOLUCION
if ($tipo=="sinsolucion") {
$nombre="SIN SOLUCION";
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
			$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				$sql_so="SELECT id_orden FROM solucion WHERE id_orden='".$row_as['id_orden']."'";
				$row_so=mysql_fetch_array(mysql_query($sql_so));
				if($row_so['id_orden']=="")	{
					$auxbo=$auxbo.",".$row_as['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDNES CON CONFORMIDAD DEL CLIENTE
if ($tipo=="conconformidad") {
$nombre="CON CONFORMIDAD";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)) {
		$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='".$rowbo['id_orden']."'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden'])	{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES SIN CONFORMIDAD DEL CLIENTE
if ($tipo=="sinconformidad") {
$nombre="SIN CONFORMIDAD";
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)){
			$sql_as="SELECT id_orden FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden'])	{
				$sql_so="SELECT id_orden FROM solucion WHERE id_orden='".$row_as['id_orden']."'";
				$row_so=mysql_fetch_array(mysql_query($sql_so));
				if($row_so['id_orden']){
					$sql_co="SELECT id_orden FROM conformidad WHERE id_orden='".$row_so['id_orden']."'";
					$row_co=mysql_fetch_array(mysql_query($sql_co));
					if($row_co['id_orden']=="")	{
						$auxbo=$auxbo.",".$row_so['id_orden'];
					}
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}
// =================

//HERE ORDENES CON CONFORMIDAD DE LAS CULAES XXX son Disconformes
if ($tipo=="disconforme") {
$nombre="DISCONFORME";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='".$rowbo['id_orden']."' AND tipo_conf='2'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//HERDE ORDENES CON CONFORMIDAD DE LAS CULAES XXX realmente estan conformes
if ($tipo=="conforme") {
$nombre="CONFORME";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='".$rowbo['id_orden']."' AND tipo_conf='1'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES CON COSTO
if ($tipo=="concosto") {
$nombre="CON COSTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM costo WHERE id_orden='".$rowbo['id_orden']."' GROUP BY id_orden";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES SIN COSTO
if ($tipo=="sincosto") {
$nombre="SIN COSTO";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM costo WHERE id_orden='".$rowbo['id_orden']."' GROUP BY id_orden";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']=="")	{
			$auxbo=$auxbo.",".$rowbo['id_orden'];
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES CON ANIDAMIENTO
if ($tipo=="anidadas") {
$nombre="ANIDADAS";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)) {
		$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='".$rowbo['id_orden']."'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$sql_an="SELECT * FROM ordenes WHERE id_orden='".$row_as['id_orden']."' AND id_anidacion<>0";
			$row_an=mysql_fetch_array(mysql_query($sql_an));
			if($row_an['id_orden']){
				$auxbo=$auxbo.",".$row_an['id_orden'];
			}
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//NUMERO DE ORDENES SIN ANIDAMIENTO
if ($tipo=="sinanidar") {
$nombre="SIN ANIDAR";
	$auxbo='nochar';
	$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
	$resultbo=mysql_query($sqlbo);
	while ($rowbo = mysql_fetch_array($resultbo)){
		$sql_as="SELECT id_orden FROM conformidad WHERE id_orden='".$rowbo['id_orden']."'";
		$row_as=mysql_fetch_array(mysql_query($sql_as));
		if($row_as['id_orden']){
			$sql_an="SELECT * FROM ordenes WHERE id_orden='".$row_as['id_orden']."' AND id_anidacion<>0";
			$row_an=mysql_fetch_array(mysql_query($sql_an));
			if($row_an['id_orden']==""){
				$auxbo=$auxbo.",".$row_as['id_orden'];
			}
		}			
	}
	if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
	else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
	$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

//ORIGINADAS POR PROCESOS
if ($tipo=="originadasporprocesos") {
$nombre="ORIGINADAS POR PROCESOS";
$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha, a.*
		 FROM ordenes AS a 
		 WHERE a.id_proceso<>'0' 
		 AND a.cod_usr<>'SISTEMA'
		 AND a.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
		 ORDER BY a.id_orden DESC";
}

// SIN ORIGEN EN UN PROCESO
if ($tipo=="sinorigenenunproceso") {
$nombre="SIN ORIGEN EN UN PROCESO";
$sql = "SELECT DATE_FORMAT(a.fecha,'%d/%m/%Y') AS fecha, a.*
		 FROM ordenes AS a 
		 WHERE a.id_proceso='0' 
		 AND a.cod_usr<>'SISTEMA'
		 AND a.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
		 ORDER BY a.id_orden DESC";
}

//=============USUARIOS=================
//NUMERO DE ADMINISTRADORES
$sql7 = "SELECT count(tipo2_usr) AS adm FROM users WHERE tipo2_usr='A'";
$row7 = mysql_fetch_array(mysql_query($sql7));

//NUMERO DE CLIENTES
$sql8 = "SELECT count(tipo2_usr) AS cli FROM users WHERE tipo2_usr='C'";
$row8 = mysql_fetch_array(mysql_query($sql8));

//NUMERO DE TECNICOS
$sql9 = "SELECT count(tipo2_usr) AS tec FROM users WHERE tipo2_usr='T'";
$row9 = mysql_fetch_array(mysql_query($sql9));

//NUMERO TOTAL DE TECNICOS
$totuser=$row7['adm']+$row8['cli']+$row9['tec'];

//Complejidad, criticidad, prioridad
		//Complejidad, criticidad, prioridad
	
if ($tipo=="complejidadalta")
{
$nombre="COMPLEJIDAD ALTA";
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)){
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden'])	{
				if($row_as['nivel_asig']=='3')	{
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="complejidadmedia"){
$nombre="COMPLEJIDAD MEDIA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden'])	{
				if($row_as['nivel_asig']=='2')	{
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="complejidadbaja")
{
$nombre="COMPLEJIDAD BAJA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,nivel_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				if($row_as['nivel_asig']=='1'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="criticidadalta"){
$nombre="CRITICIDAD ALTA";
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden'])	{
				if($row_as['criticidad_asig']=='1')	{
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="criticidadmedia"){
$nombre="CRITICIDAD MEDIA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)){
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				if($row_as['criticidad_asig']=='2'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="criticidadbaja")
{
$nombre="CRITICIDAD BAJA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)){
			$sql_as="SELECT id_orden,criticidad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				if($row_as['criticidad_asig']=='3'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="prioridadalta"){
$nombre="PRIORIDAD ALTA";
		$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) {
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden'])	{
				if($row_as['prioridad_asig']=='1'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="prioridadmedia")
{
$nombre="PRIORIDAD MEDIA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)) 
		{
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				if($row_as['prioridad_asig']=='2'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}

if ($tipo=="prioridadbaja"){
$nombre="PRIORIDAD BAJA";
	$auxbo='nochar';
		$sqlbo= "SELECT id_orden FROM ordenes WHERE cod_usr<>'SISTEMA' AND fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'";
		$resultbo=mysql_query($sqlbo);
		while ($rowbo = mysql_fetch_array($resultbo)){
			$sql_as="SELECT id_orden,prioridad_asig FROM asignacion WHERE id_orden='".$rowbo['id_orden']."' ORDER BY id_asig DESC limit 1";
			$row_as=mysql_fetch_array(mysql_query($sql_as));
			if($row_as['id_orden']){
				if($row_as['prioridad_asig']=='3'){
					$auxbo=$auxbo.",".$rowbo['id_orden'];
				}
			}			
		}
		if($auxbo=="nochar"){$auxbo3 = str_replace('nochar','0', $auxbo);}
		else{$auxbo3 = str_replace('nochar,',' ', $auxbo);}
		$sql="SELECT * FROM ordenes WHERE cod_usr<>'SISTEMA' AND id_orden IN ($auxbo3) ORDER BY id_orden DESC";
}
$query=mysql_query($sql);
$count=mysql_query($sql);
?>
<html>
<head>
<style type="text/css">
body          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
th            {font-family: Arial, Helvetica, sans-serif; font-size: small; font-weight: bolder; color: #FFFFFF; background-color: #006699}
.th2           {font-family: Arial, Helvetica, sans-serif; font-size: 10; font-weight: bolder; color: #FFFFFF; background-color: #006699}
td            {font-family: Arial, Helvetica, sans-serif; font-size: xx-small;}
form          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
input         {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
select        {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
textarea	  {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
.menu 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #FFFFFF; background-color: #006699}		
.menu2 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #999999; background-color: #006699}		
.normal       {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
</style>

<?php 
$html_PDF='<style type="text/css">
body          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
th            {font-family: Arial, Helvetica, sans-serif; font-size: small; font-weight: bolder; color: #FFFFFF; background-color: #006699}
.th2           {font-family: Arial, Helvetica, sans-serif; font-size: 10; font-weight: bolder; color: #FFFFFF; background-color: #006699}
td            {font-family: Arial, Helvetica, sans-serif; font-size: xx-small;}
form          {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
input         {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
select        {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
textarea	  {font-family: Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
.menu 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #FFFFFF; background-color: #006699}
.menu2 	  	  {font-family: Arial, Helvetica, sans-serif; font-size: xx-small; color: #999999; background-color: #006699}
.normal       {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: x-small; color: #000000}
</style>';
?>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="jquery.js"></script>
<script language="javascript">
$(document).ready(function() {
	$(".botonPDF").click(function(event) {
		//$("#datos_a_enviar").val( $("<div>").append( $("#tbl").eq(0).clone()).html());
		$("#pdf_export").submit();
});
});
</script>
</head>
<title>GesTor F1 - TI</title>
<body>
<table width="80%" border="1" cellspacing="0" align="center">
  <tr> 
    <td width="20%"> <img src="images/imagen_ins.png" alt="Yanapti" width="222" height="81"></td>
    <td colspan="4" width="80%"><img src="images/bannerTIL.jpg" width="642"> </tr>
</table>
<br><br>
<table align="center"><tr><td><a href="">
<img src="images/PDF.jpg" style="width:80px" class="botonPDF" border="0"></img></a></td></tr></table>
<?php 
$html='<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<tr align="center"><th colspan="12">ORDENES - '.$nombre.': '; 
$html_PDF.='<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2">
		<tr align="center"><th colspan="9">ORDENES - '.$nombre.': '; 
	$i=0; 
	while ($aux=mysql_fetch_array($count)) { 
		$i++; 
	} 
	$html.=$i." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Del $DA/$MA/$AA&nbsp;&nbsp; Al $DE/$ME/$AE</th>";
	$html_PDF.=$i." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Del $DA/$MA/$AA&nbsp;&nbsp; Al $DE/$ME/$AE</th>";
	
	$html.='</tr>
        <tr>
          <td width="25" class="menu" align="center">Nro</td>
		  <td width="20" class="menu" align="center">ORIGEN</td>
          <td width="72" class="menu" align="center">FECHA Y HORA</td>
          <td width="84" class="menu" align="center">ENVIADO POR</td>
          <td width="17" class="menu" align="center">TIPO</td>
	      <td width="230" class="menu" align="center">DESCRIPCION DE LA INCIDENCIA</td>
  	      <td width="200" class="menu" align="center">ASIGNACION</td>
		  <td width="150" class="menu" align="center">AREA</td>
		  <td width="100" class="menu" align="center">ENTIDAD</td>
   	      <td width="60" class="menu" align="center">FECHA SOLUCION</td>
   	      <td width="40" class="menu" align="center">IMPRIMIR</td>
		 </tr>';
	
	$html_PDF.='</tr>
        <tr>
          <td width="25" class="menu" align="center">Nro</td>
          <td width="52" class="menu" align="center">FECHA Y HORA</td>
          <td width="84" class="menu" align="center">ENVIADO POR</td>
          <td width="17" class="menu" align="center">TIPO</td>
	      <td width="180" class="menu" align="center">DESCRIPCION DE LA INCIDENCIA</td>
  	      <td width="100" class="menu" align="center">ASIGNACION</td>
		  <td width="100" class="menu" align="center">AREA</td>
		  <td width="70" class="menu" align="center">ENTIDAD</td>
   	      <td width="60" class="menu" align="center">FECHA SOLUCION</td>
   	      </tr>';
		 
	 while($datos=mysql_fetch_array($query)){
		$html.='<tr><td align="center">'.$datos['id_orden'].'</td>';
		$html_PDF.='<tr><td align="center">'.$datos['id_orden'].'</td>';
		$html.='<td align="center">';
			if ($datos['id_anidacion']!="0") { 
				$html.=$datos['id_anidacion']; 
			} 
			else { 
				$html.='<img src=images/eliminar.gif>'; 
			}
			$html.='</td>';
			$html.='<td align="center">'.$datos['fecha'].' '.$datos['time'].'</td>';
			$html_PDF.='<td align="center">'.$datos['fecha'].' '.$datos['time'].'</td>';
			
			$sql_user="SELECT nom_usr,apa_usr,ama_usr,tipo2_usr FROM users WHERE login_usr='".$datos['cod_usr']."'";
			$datos_usr=mysql_fetch_array(mysql_query($sql_user));
			
			$html.='<td align="center">'.$datos_usr['nom_usr'].' '.$datos_usr['apa_usr'].' '.$datos_usr['ama_usr'].'</td>
			<td align="center">'.$datos_usr['tipo2_usr'].'</td>
			<td align="center">'.$datos['desc_inc'].'</td>';
			$html_PDF.='<td align="center">'.$datos_usr['nom_usr'].' '.$datos_usr['apa_usr'].' '.$datos_usr['ama_usr'].'</td>
			<td align="center">'.$datos_usr['tipo2_usr'].'</td>
			<td align="center">'.$datos['desc_inc'].'</td>';
			
			$sql_aux = "SELECT id_orden, asig, fechaestsol_asig, DATE_FORMAT(fechaestsol_asig, '%d/%m/%Y') AS fechaestsol_asig2 FROM asignacion WHERE id_orden='".$datos['id_orden']."' ORDER BY id_asig DESC limit 1";
			$datos_aux=mysql_fetch_array(mysql_query($sql_aux));
			$sql_asig="SELECT nom_usr,apa_usr,ama_usr,area_usr,enti_usr FROM users WHERE login_usr='$datos_aux[asig]' ";
			$datos_asig=mysql_fetch_array(mysql_query($sql_asig));
			
			$html.='<td align="center">'.$datos_asig['nom_usr'].' '.$datos_asig['apa_usr'].' '.$datos_asig['ama_usr'].'.&nbsp;</td>
			<td align="center">'.$datos_asig['area_usr'].'&nbsp;</td>
			<td align="center">'.$datos_asig['enti_usr'].'&nbsp;</td>
			<td align="center">'.$datos_aux['fechaestsol_asig2'].'&nbsp;</td>
			<td align="center"><a href="ver_orden.php?id_orden='.$datos['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir"></a></td></tr>';
			
			$html_PDF.='<td align="center">'.$datos_asig['nom_usr'].' '.$datos_asig['apa_usr'].' '.$datos_asig['ama_usr'].'.&nbsp;</td>
			<td align="center">'.$datos_asig['area_usr'].'&nbsp;</td>
			<td align="center">'.$datos_asig['enti_usr'].'&nbsp;</td>
			<td align="center">'.$datos_aux['fechaestsol_asig2'].'&nbsp;</td></tr>';
		}
		$html.='</table>';
		$html_PDF.='</table>';
		$html_PDF=str_replace('"','&quot;',$html_PDF);
		echo $html;
	?>
<div align="center"></div>
	<form action="reports_PDF.php" method="post" target="_blank" id="pdf_export" name="pdf_export">
	<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" value="<?php echo $html_PDF;?>"/>
	<input type="hidden" id="titulo" name="titulo" value="<?php echo 'ORDENES_'.$nombre.'_DEL_'.$DA.'-'.$MA.'-'.$AA.'_AL_'.$DE.'-'.$ME.'-'.$AE;?>">
	</form>
</body>
</html>