<?php
require("conexion.php");
$id_area=$_GET['a'];
$filtro1=$_GET['f'];
$id_nombre=$_GET['id'];
$f1=$_GET['f1'];
$f2=$_GET['f2'];
$fecha1=substr($f1,8,2).'-'.substr($f1,5,2).'-'.substr($f1,0,4);
$fecha2=substr($f2,8,2).'-'.substr($f2,5,2).'-'.substr($f2,0,4);
$tipo=$_GET['t'];

$recordset=mysql_query("SELECT area_nombre FROM area WHERE area_cod='$id_area'");
$fila=mysql_fetch_array($recordset);
$area=$fila['area_nombre'];
$cond='';
?>
<html>
<head>
<style type="text/css">
<!--
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

-->
</style>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>GesTor F1 - TI</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
	<table width="80%" border="1" cellspacing="0" align="center">
		<tr> 
			<td width="20%"> <img src="images/imagen_ins.jpg"></td>
			<td colspan="4" width="80%"><img src="images/imagen.jpg">
		</tr>
	</table>
<br><br>

<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
	<tr align="center">
		<th colspan="12">ORDENES
		<?php 
			if ($area!=''){
				echo ' - '.$area; 
				if ($id_nombre==0)
					$cond.=" AND u.area_usr='$id_area'";
			} 
			echo ' Del: '.$fecha1.' Al: '.$fecha2 ?></th>
	 </tr>
	<?php 
	if ($id_nombre!='0'){
		$recordset=mysql_query("SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$id_nombre'");
		$fila=mysql_fetch_array($recordset);
		$label='';
		if ($filtro1=='1' || $filtro1=='2'){ 
			$label='Enviadas por: '.$fila['nom_usr'].' '.$fila['apa_usr'].' '.$fila['ama_usr'];
			$cond.=" AND o.cod_usr='$id_nombre'";
		}
		if ($filtro1=='3'){
			if ($tipo==1 || $tipo==3){
				$label='Asignadas a:'.$fila['nom_usr'].' '.$fila['apa_usr'].' '.$fila['ama_usr'];
				$cond.=" AND a.asig='$id_nombre'";
			}
		}
		echo '<tr><th colspan="12">'.$label.'</th></tr>';  
	}
    
	if ($tipo==1){ // ASIGNADAS
		$cond.=" AND a.asig IS NOT NULL";
	}
	if ($tipo==2){ // NO ASIGNADAS
		$cond.=" AND a.asig IS NULL";
	}
	if ($tipo==3){ // ESCALADAS
		$cond.=" AND a.escal<>'0'";
	}
	if ($tipo==4){ // NO ESCALADAS
		$cond.=" AND a.escal='0'";
	}
	if ($tipo==5){ // CON SEGUIMIENTO
		$cond.=" AND o.id_orden IN (SELECT s.id_orden FROM seguimiento s)";
	}
	if ($tipo==6){ // SIN SEGUIMIENTO
		$cond.=" AND a.escal='0'";
	}
	if ($tipo==7){ // CON SOLUCION
		$cond.=" AND o.id_orden IN (SELECT s.id_orden FROM solucion s)";
	}
	if ($tipo==8){ // SIN SOLUCION
		$cond.=" AND o.id_orden NOT IN (SELECT s.id_orden FROM solucion s)";
	}
	if ($tipo==9){ // CON CONFORMIDAD
		$cond.=" AND o.id_orden IN (SELECT c.id_orden FROM conformidad c)";
	}
	if ($tipo==10){ // SIN CONFORMIDAD
		$cond.=" AND o.id_orden NOT IN (SELECT c.id_orden FROM conformidad c)";
	}
	if ($tipo==11){ //  CONFORMES
		$cond.=" AND o.id_orden IN (SELECT c.id_orden FROM conformidad c WHERE tipo_conf=1)";
	}
	if ($tipo==12){ // DISCONFORMES
		$cond.=" AND o.id_orden IN (SELECT c.id_orden FROM conformidad c WHERE tipo_conf=2)";
	}
	if ($tipo==13){ // CON COSTO
		$cond.=" AND WHERE u.costo_usr>0";
	}
	if ($tipo==14){ // SIN COSTO
		$cond.=" AND WHERE u.costo_usr=0";
	}
	if ($tipo==15){ // ANIDADAS
		$cond.=" AND o.id_anidacion<>0";
	}
	if ($tipo==16){ // SIN ANIDACION
		$cond.=" AND o.id_anidacion=0";
	}
	if ($tipo==17){ // COMPLEJIDAD BAJA
		$cond.=" AND a.nivel_asig=1";
	}
	if ($tipo==18){ // COMPLEJIDAD MEDIA
		$cond.=" AND a.nivel_asig=2";
	}
	if ($tipo==19){ // COMPLEJIDAD ALTA
		$cond.=" AND a.nivel_asig=3";
	}
	if ($tipo==20){ // CRITICIDAD BAJA
		$cond.=" AND a.criticidad_asig=1";
	}
	if ($tipo==21){ // CRITICIDAD MEDIA
		$cond.=" AND a.criticidad_asig=2";
	}
	if ($tipo==22){ // CRITICIDAD ALTA
		$cond.=" AND a.criticidad_asig=3";
	}
	if ($tipo==23){ // PRIORIDAD BAJA
		$cond.=" AND a.prioridad_asig=1";
	}
	if ($tipo==24){ // PRIORODAD MEDIA
		$cond.=" AND a.prioridad_asig=2";
	}
	if ($tipo==25){ // PRIORIDAD ALTA
		$cond.=" AND a.prioridad_asig=3";
	}
	if ($tipo==26){ // TIPIFICADAS NIVEL 1
		$cond.=" AND o.area <> 0";
	}
	if ($tipo==27){ // TIPIFICADAS NIVEL 2
			$cond.=" AND o.area <> 0 AND o.dominio <> 0 ";
	}
	if ($tipo==28){ // TIPIFICADAS NIVEL 3
		$cond.=" AND o.area <> 0 AND o.dominio <> 0 AND o.objetivo <> 0";
	}
	if ($tipo==29){ // SIN TIPIFICAR
			$cond.=" AND o.area=0";
	}
	
	$sql="SELECT DISTINCT o.id_orden, o.id_anidacion, o.fecha, o.time, o.cod_usr, u.tipo2_usr, o.desc_inc, a.asig, a1.area_nombre, u.enti_usr, a.fechaestsol_asig
			FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr
			LEFT JOIN asignacion a ON o.id_orden=a.id_orden
			LEFT JOIN area a1 ON o.area=a1.area_cod WHERE o.cod_usr<>'SISTEMA' $cond AND o.fecha BETWEEN '$f1' AND '$f2' ORDER BY o.id_orden";
	//echo $sql;
	$recordset=mysql_query($sql);
	echo '<tr>
          <td width="3%" class="menu" align="center">Nro</td>
		  <td width="3%" class="menu" align="center">ORIGEN</td>
          <td width="8%" class="menu" align="center">FECHA Y HORA</td>
          <td width="15%" class="menu" align="center">ENVIADO POR</td>
          <td width="2%" class="menu" align="center">TIPO</td>
	      <td width="25%" class="menu" align="center">DESCRIPCION DE LA INCIDENCIA</td>
  	      <td width="15%" class="menu" align="center">ASIGNACION</td>
		  <td width="8%" class="menu" align="center">AREA</td>
		  <td width="8%" class="menu" align="center">ENTIDAD</td>
   	      <td width="8%" class="menu" align="center">FECHA SOLUCION</td>
   	      <td width="7%" class="menu" align="center">IMPRIMIR</td>
		</tr>';
	if (mysql_num_rows($recordset)!=0){
		for ($i=1;$i<=mysql_num_rows($recordset);$i++){ 
		$fila=mysql_fetch_array($recordset); 
		echo '<tr>
			  <td align="center">'.$fila['id_orden'].'</td>
			  <td align="center">'.$fila['id_anidacion'].'</td>
			  <td align="center">'.$fila['fecha'].' '.$fila['time'].'</td>
			  <td align="center">'.$fila['cod_usr'].'</td>
			  <td align="center">'.$fila['tipo2_usr'].'</td>
			  <td align="center">'.$fila['desc_inc'].'</td>
			  <td align="center">'.$fila['asig'].'</td>
			  <td align="center">'.$fila['area_nombre'].'</td>
			  <td align="center">'.$fila['enti_usr'].'</td>
			  <td align="center">'.$fila['fechaestsol_asig'].'</td>
			  <td align="center"><a href="ver_orden.php?id_orden='.$fila['id_orden'].'"><img src="images/imprimir.gif"></img></a></td>
			</tr>';	
		}
	}
	else{
		echo '<tr><td colspan="12" align="center">NO SE HAN ENCONTRADO RESULTADOS.</td></tr>';
	}
	echo '</table>';
	?>

</body>
</html>

