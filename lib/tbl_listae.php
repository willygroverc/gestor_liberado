<?php
@session_start();
require('../conexion.php');
require ('../funciones.php');
$tipo_busq = $_POST['tipo_busq'];
//$id_agencia= $_POST['id_agen'];
$pg=$_POST['pg'];
$txt_busq=$_POST['txt_busq'];
$txt_busq=_clean($txt_busq);
$txt_busq=SanitizeString($txt_busq);
$cond="";

if ($_SESSION['tipo']=='A'){
	$id_area= $_POST['id_area'];
	//$id_area= _clean($id_area);
	//$id_area= SanitizeString($id_area);
	$id_env=$_POST['id_env'];
	//$id_env=_clean($id_env);
	//$id_env=SanitizeString($id_env);
	if ($id_area!='0')
		$cond.=" AND u1.area_usr='$id_area'";
	if ($id_env!='0')
		$cond.=" AND o.cod_usr='$id_env'";

	if ($tipo_busq==0) 	// SIN FILTRO
		$cond.="";
	if ($tipo_busq==1) 	// ASIGNADO
		$cond.=" AND a.asig IS NOT NULL";
	if ($tipo_busq==2) 	// NO ASIGNADO
		$cond.=" AND a.asig IS NULL";
	if ($tipo_busq==3)	// SOLUCIONADO
		$cond.=" AND s.login_sol IS NOT NULL";
	if ($tipo_busq==4)	// NO SOLUCIONADO
		$cond.=" AND a.asig IS NOT NULL AND s.login_sol IS NULL";
	if ($tipo_busq==5)  // CON CONFORMIDAD
		$cond.=" AND s.login_sol IS NOT NULL AND c.id_orden IS NOT NULL";
	if ($tipo_busq==6)  // SIN CONFORMIDAD
		$cond.=" AND s.login_sol IS NOT NULL AND c.id_orden IS NULL";
}

if ($_SESSION['tipo']=='T' || $_SESSION['tipo']=='C'){
	$id_usuario=$_POST['id_u'];
	$id_usuario=_clean($id_usuario);
	$id_usuario=SanitizeString($id_usuario);
	
	
	if ($tipo_busq==0){ 	// ENVIADO POR
		if ($id_usuario!='0')
			$cond.=" AND o.cod_usr='$id_usuario'"; 
	}		
	if ($tipo_busq==1){ // ASIGNADO
		if ($id_usuario!='0')
			$cond.=" AND a.asig='$id_usuario'";
		else
			$cond.=" AND a.asig IS NOT NULL";
	}
	if ($tipo_busq==2){ 	// NO ASIGNADO
		if ($id_usuario!='0')
			$cond.=" AND a.asig <> '$id_usuario'";
		else
			$cond.=" AND a.asig IS NULL";
	}
	if ($tipo_busq==3){	// SOLUCIONADO
		if ($id_usuario!='0')
			$cond.=" AND s.login_sol='$id_usuario'";
		else	
			$cond.=" AND s.login_sol IS NOT NULL";
	}
	if ($tipo_busq==4){	// NO SOLUCIONADO
		if ($id_usuario!='0')
			$cond.=" AND s.login_sol<>'$id_usuario'";
		else	
			$cond.=" AND s.login_sol IS NULL";
	}
	if ($tipo_busq==5){ // CONFORMIDAD DE
		if ($id_usuario!='0')
			$cond.=" AND c.reg_conf='$id_usuario'";
		else
			$cond.=" AND c.id_orden IS NOT NULL";
	}
	if ($tipo_busq==6) // SIN CONFORMIDAD DE
		if ($id_usuario!='0')
			$cond.=" AND c.id_orden IS NULL AND o.cod_usr='$id_usuario'";
		else
			$cond.=" AND c.reg_conf IS NULL";
}

if($txt_busq!='')
	$cond.=" AND (o.id_orden='$txt_busq' || o.desc_inc LIKE '%$txt_busq%')";
	
$fechahoy = date('Y-m-d');
if ($_SESSION['tipo']=='A'){
	$sql_ordenes="SELECT  DISTINCT (o.id_orden), o.fecha, o.time, o.cod_usr, o.desc_inc, o.tipo, o.nomb_archivo, o.area, o.dominio, o.objetivo, o.ci_ruc, o.id_anidacion, o.origen, o.hash_archivo, o.observaciones,
			a.asig, a.fechaestsol_asig, s.login_sol, CONCAT(u1.nom_usr, ' ',u1.apa_usr, ' ',u1.ama_usr) as nombre, u1.tipo2_usr, CONCAT(u2.nom_usr, ' ',u2.apa_usr, ' ',u2.ama_usr) as nombre_asig, c.reg_conf, c.tipo_conf
			FROM ordenes o LEFT JOIN asignacion a ON o.id_orden=a.id_orden
			LEFT JOIN solucion s ON o.id_orden=s.id_orden
			LEFT JOIN users u1 ON o.cod_usr=u1.login_usr
			LEFT JOIN users u2 ON a.asig=u2.login_usr
			LEFT JOIN conformidad c ON o.id_orden=c.id_orden
			WHERE '1'='1' ".$cond." 
			GROUP BY o.id_orden ORDER BY o.id_orden DESC";
}
if ($_SESSION['tipo']=='T' || $_SESSION['tipo']=='C'){
$sql_ordenes="SELECT o.id_orden, o.fecha, o.time, o.cod_usr, o.desc_inc, o.tipo, o.nomb_archivo, o.area, o.dominio, o.objetivo, o.ci_ruc, o.id_anidacion, o.origen, o.hash_archivo, o.observaciones,
				a.asig, a.fechaestsol_asig, s.login_sol, CONCAT(u1.nom_usr, ' ',u1.apa_usr, ' ',u1.ama_usr) as nombre, u1.tipo2_usr,
				CONCAT(u2.nom_usr, ' ',u2.apa_usr, ' ',u2.ama_usr) as nombre_asig, c.reg_conf, c.tipo_conf
			FROM ordenes o LEFT JOIN asignacion a ON o.id_orden=a.id_orden
			LEFT JOIN solucion s ON o.id_orden=s.id_orden
			LEFT JOIN users u1 ON o.cod_usr=u1.login_usr
			LEFT JOIN users u2 ON a.asig=u2.login_usr
			LEFT JOIN conformidad c ON o.id_orden=c.id_orden
			WHERE (o.cod_usr='".$_SESSION['login']."' OR a.asig='".$_SESSION['login']."') ".$cond." 
			GROUP BY o.id_orden ORDER BY o.id_orden DESC";
}
//echo $sql_ordenes;
$recordset_ordenes=mysql_query($sql_ordenes);
$num_filas=mysql_num_rows($recordset_ordenes);

//Paginacion
$num_paginas=$num_filas/20;
settype($num_paginas,'integer');
$pagina_fin=20*$pg;
$pagina_ini=($pagina_fin-20);
$sql_ordenes.=" LIMIT $pagina_ini, 20";
// Fin paginacion

$recordset_ordenes=mysql_query($sql_ordenes);
//echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tbl_ordenes" name="tbl_ordenes">
echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<thead>
			<tr><th colspan="17" align="center">ORDENES DE TRABAJO</th></tr>';
			if ($_SESSION['tipo']=='A' || $_SESSION['tipo']=='S'){
				echo '<tr><th colspan="17" align="center"><input type="button" value="Cerrar Ordenes Seleccionadas" onclick="cerrar_orden();"></th></tr>';
			}
			echo '<tr align="center">  
				<th width="25" class="menu">Nro</th>
				<th width="20" height="25" class="menu">ORIGEN</th>
				<th width="67" class="menu">FECHA Y HORA</th>
				<th width="90" class="menu">ENVIADO POR</th>
				<th width="17" class="menu">TIPO</th>
				<th width="88" class="menu">CLIENTE / TITULAR</th>
				<th width="150" class="menu">INCIDENCIA</th>';
				if ($_SESSION['tipo']=="A" || $_SESSION['tipo']=='S')
					echo '<th class="menu" width="10">CERRAR&nbsp;<input type="checkbox" onclick="chk_validar();" id="chk_cerrar"></input></th>';
		echo '	<th width="90" class="menu">ASIGNACION</th>
				<th width="60" class="menu">VENCIMIENTO SOLUCION</th>
				<th width="17" class="menu">SEGUI. </th>
				<th width="17" class="menu">SOLU.</th>
				<th width="17" class="menu">CONF.</th>';
				if ($_SESSION['tipo'] != "C"){
					echo '<th width="17" class="menu">COSTO</th>';
				}
echo 			'<th width="55" class="menu">IMPRIMIR INTERNO</th>
				<th width="55" class="menu">IMPRIMIR EXTERNO</th>
				<th width="55" class="menu">ARCHIVO ADJUNTO</th>
			</tr>
		</thead><tbody>';
$cont_noasig=0;
$cont_sol=0;
$cont_ven=0;
$cont_nosol=0;

if (mysql_num_rows($recordset_ordenes)!=0){
	echo '<input type="hidden" value="'.mysql_num_rows($recordset_ordenes).'" id="num_registros">';
	for ($i=1;$i<=mysql_num_rows($recordset_ordenes);$i++){
		$fila_ordenes=mysql_fetch_array($recordset_ordenes);
		echo '<tr>';
		$fecha_limite=date($fila_ordenes['fechaestsol_asig']);
		if ($fila_ordenes['fechaestsol_asig']==''){ 
			$color="#FF6666"; // NO ASIGNADOS
			$cont_noasig++;
		}
		else{
			if($fila_ordenes['login_sol']!=''){
				$color="#00CC66";  // SOLUCIONADOS
				$cont_sol++;
			}
			else{
				if ($fechahoy>$fecha_limite){
					$color="#A5BBF5";  //  VENCIDAS
					$cont_ven++;
				}
				else{
					$color="#FFFF00";   //  NO SOLUCIONADOS
					$cont_nosol++;
				}
			}
		}
		
		echo '<td align="center" bgcolor="'.$color.'">'.$fila_ordenes['id_orden'].'</td>';
		if($fila_ordenes['id_anidacion']==0) { echo '<td align="center"><img src="images/eliminar.gif" width="16" height="16"></img></td>'; }
		else { echo '<td align="center"><a href="ver_orden.php?id_orden='.$fila_ordenes['id_anidacion'].'" target="_blank">'.$fila_ordenes['id_anidacion'].'</a></td>'; }
		echo '<td align="center">'.$fila_ordenes['fecha'].'<br>'.$fila_ordenes['time'].'</td>';
		if ($fila_ordenes['cod_usr']=='SISTEMA'){
			echo '<td align="center">SISTEMA</td>';
			echo '<td align="center">S</td>';
		}
		else{
			echo '<td align="center">'.$fila_ordenes['nombre'].'</td>';
			echo '<td align="center">'.$fila_ordenes['tipo2_usr'].'</td>';
		}
		
		// CLIENTE TITULAR
		if ($fila_ordenes['ci_ruc']=='')
			echo '<td align="center">-</td>';
		else
			echo '<td align="center"><a href="titular.php?ci_ruc='.$fila_ordenes['ci_ruc'].'">'.$fila_ordenes['ci_ruc'].'</a></td>';

		echo '<td align="center">'.$fila_ordenes['desc_inc'].'</td>';
		if (($_SESSION['tipo']=="A" || $_SESSION['tipo']=="S")){
			$estado='';
			if ($fila_ordenes['login_sol']!='')
				$estado='disabled';
			echo '<td align="center"><input type="checkbox" id="chk'.$i.'" value="'.$fila_ordenes['id_orden'].'" '.$estado.'></input></td>';
		}
		if ($fila_ordenes['asig']!=''){
			if ($fila_ordenes['login_sol']=='')
				echo '<td align="center"><a href="asignacion.php?id_orden='.$fila_ordenes['id_orden'].'">'.$fila_ordenes['nombre_asig'].'</a></td>';
			else
				echo '<td align="center">'.$fila_ordenes['nombre_asig'].'</td>';
		}
		else{
			if ($_SESSION['tipo']=='A' || $_SESSION['tipo']=='T')
				echo '<td align="center"><a href="asignacion.php?id_orden='.$fila_ordenes['id_orden'].'"><img src="images/no3.gif" border="0"></a></td>';
			else
				echo '<td align="center">Sin Asignaci&oacute;n</td>';
		}

		//FECHA VENCIMIENTO DE SOLUCION
		if ($fila_ordenes['fechaestsol_asig']!='')
			echo '<td align="center">'.$fila_ordenes['fechaestsol_asig'].'</td>';
		else
			echo '<td align="center">-</td>';
		
		$sql_segui="SELECT count(id_seg) as num_segui FROM seguimiento WHERE id_orden='".$fila_ordenes['id_orden']."'";
		$recordset=mysql_query($sql_segui);
		$fila_segui=mysql_fetch_array($recordset);
		echo '<td align="center">&nbsp;<a href="segui.php?id_orden='.$fila_ordenes['id_orden'].'&var2=2">'.$fila_segui['num_segui'].'</a></td>';
		
		//SOLUCION
		if ($fila_ordenes['login_sol']=='')
			echo '<td align="center"><img src="images/no2.gif" border="0" alt="Solucion"></td>';
		else
			echo '<td align="center"><a href="solucion_ver.php?id_orden='.$fila_ordenes['id_orden'].'"><img src="images/ok.gif" border="0" alt="Solucion"></a></td>';
		// CONFORMIDAD
		if ($fila_ordenes['reg_conf']==''){
			if (($fila_ordenes['cod_usr']==$_SESSION['login'] && $fila_ordenes['login_sol']!='') || ($_SESSION['tipo']=='A' && $fila_ordenes['login_sol']!=''))
				echo '<td align="center"><a href="conformidad.php?id_orden='.$fila_ordenes['id_orden'].'"><img src="images/no3.gif" border="0" alt="Conformidad"></a></td>';
			else
				echo '<td align="center"><img src="images/no2.gif" border="0" alt="Conformidad"></td>';
		}
		else
		{	
			if($fila_ordenes['tipo_conf']== "2") {
				echo '<td align="center"><a href="conformidad_ver.php?id_orden='.$fila_ordenes['id_orden'].'"><img src="images/disconf.gif" border="0" alt="Solucion"></a></td>';
			} else {
				echo '<td align="center"><a href="conformidad_ver.php?id_orden='.$fila_ordenes['id_orden'].'"><img src="images/ok.gif" border="0" alt="Solucion"></a></td>';
			}
		}
		
		
		if ($_SESSION['tipo']!='C')
			echo '<td align="center"><a href="costo.php?id_orden='.$fila_ordenes['id_orden'].'&op=2">
					<img src="images/ver.gif" border="0" alt="Costo: Ver"></a></td>';
		
		echo '<td align="center">
				<a href="ver_orden.php?id_orden='.$fila_ordenes['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir Interno"></img></a>
			</td>';
		echo '<td align="center"><a href="ver_orden2.php?id_orden='.$fila_ordenes['id_orden'].'" target="_blank"><img src="images/imprimir.gif" border="0" alt="Imprimir Externo"></img></a>
			</td>';
		
		// ARCHIVOS ADJUNTOS
		if ($fila_ordenes['nomb_archivo']=='')
			echo '<td align="center">NINGUNO</td>';
		else
			echo '<td align="center"><a href="archivos_adjuntos.php?id_orden='.$fila_ordenes['id_orden'].'">VER ARCHIVOS</a></td>';
		echo '</tr>';
	}
	echo '</tbody></table><br><br>';
}
else
{
	echo '<tbody><tr><td colspan="16" align="center"><h3>NO SE HAN ENCONTRADO RESULTADOS</h3></td></tr></tbody></table><br><br>';
}
/*PAGINACION*/
echo '<center><b><font size="2">Pagina(s): ';

if ($pg>20){
	echo '<a href="javascript:pag_lista(3,0);">Anterior,&nbsp</a>';
	$pagina_ini=$pg-20+1;
	$pagina_fin=$pg;
}
else{
	$pagina_ini=1;
	if ($num_paginas<=20)
		$pagina_fin=$num_paginas;
	else
		$pagina_fin=20;
}

for ($i=$pagina_ini;$i<=$pagina_fin;$i++){
	if ($i==$pg)
		echo $i;
	else{
		echo '<a href="javascript:pag_lista(1,'.$i.');">'.$i.'</a>';
	}	
	if ($i!=$num_paginas)
		echo ',';
}
if ($i>20 & $i<=$num_paginas){
	echo '<a href="javascript:pag_lista(2,0)">&nbsp;Siguiente</a>';
}
/*FIN PAGINACION*/
echo '</font></b></center><br>';
echo '  <table width="70%" border="1" align="center">
    <tr align="center"> 
      <td width="12%" >NO ASIGNADOS</td>
      <td width="5%" bgcolor="#FF6666">'.$cont_noasig.'&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">NO SOLUCIONADOS</td>
      <td width="5%" bgcolor="#FFFF00">'.$cont_nosol.'&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">SOLUCIONADOS</td>
      <td width="5%" bgcolor="#00CC66">'.$cont_sol.'&nbsp;</td>
      <td width="10%">&nbsp;</td>
      <td width="12%">VENCIDOS</td>
      <td width="5%" bgcolor="#A5BBF5">'.$cont_ven.'&nbsp;</td>
    </tr>
  </table><br>';
    if ($_SESSION['tipo']=="A" or $_SESSION['tipo']=="B" or $_SESSION['tipo']=="S") {
		echo '<div align="center"><br>';
		echo '<input name="estadisticas" type="button" id="estadisticas" value="REPORTES" onClick="openStat_2();">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input name="estadisticas" type="button" id="estadisticas" value="ESTADISTICAS" onClick="openStat_4();">';
		//echo '<input name="report" type="button" id="report" value="REPORTE" onClick="openStat_4()">';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input name="imprimir" type="button" id="imprimir" value="IMPRIMIR" onClick="openStat_3()">';
		echo '</div>';
	 }
?>