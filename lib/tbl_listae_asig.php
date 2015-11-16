<?php
@session_start();
require('../conexion.php');
require ('../funciones.php');
$tipo_busq = $_POST['tipo_busq'];
//$id_agencia= $_POST['id_agen'];
$pg=$_POST['pg'];
$cmb_asignadoPor=$_POST['cmb_asig'];
//$cmb_asignadoPor=_clean($cmb_asignadoPor);
//$cmb_asignadoPor=SanitizeString($cmb_asignadoPor);

$cmb_comp=$_POST['cmb_comp'];
//$cmb_comp=_clean($cmb_comp);
//$cmb_comp=SanitizeString($cmb_comp);

$cmb_crit=$_POST['cmb_crit'];
//$cmb_crit=_clean($cmb_crit);
//$cmb_crit=SanitizeString($cmb_crit);

$cmb_prio=$_POST['cmb_prio'];
//$cmb_prio=_clean($cmb_prio);
//$cmb_prio=SanitizeString($cmb_prio);

$cond="";

if ($_SESSION['tipo']=='T'){
	$cond.=" AND a.asig='".$_SESSION['login']."'";
}

if ($cmb_asignadoPor!='0')
	$cond.=" AND a.reg_asig='".$cmb_asignadoPor."'";
	
if ($tipo_busq=='1')
	$cond.=" AND s.login_sol IS NOT NULL"; 
if ($tipo_busq=='2')
	$cond.=" AND s.login_sol IS NULL";
if ($tipo_busq=='3')
	$cond.=" AND c.reg_conf IS NOT NULL";
if ($tipo_busq=='4')
	$cond.=" AND c.reg_conf IS NULL AND s.login_sol IS NOT NULL";	

if($cmb_comp!='0')
	$cond.=" AND a.nivel_asig='".$cmb_comp."'";
if($cmb_crit!='0')
	$cond.=" AND a.criticidad_asig='".$cmb_crit."'";
if($cmb_prio!='0')
	$cond.=" AND a.prioridad_asig='".$cmb_prio."'";
$fechahoy = date('Y-m-d');

$sql_asig="SELECT a.id_orden, o.cod_usr, CONCAT(u1.nom_usr,' ',u1.apa_usr,' ',u1.ama_usr) as nom1, o.desc_inc, comp.n_indice as comp, crit.n_indice as crit,".
			"prio.n_indice as prio, a.asig, CONCAT(u2.nom_usr,' ',u2.apa_usr,' ',u2.ama_usr) as nom2,  a.fecha_asig, a.hora_asig, s.fecha_sol, a.fechaestsol_asig, ".
			"a.reg_asig,CONCAT(u3.nom_usr,' ',u3.apa_usr,' ',u3.ama_usr) as nom3, a.diagnos, a.escal, s.login_sol, CONCAT(u4.nom_usr,' ',u4.apa_usr,' ',u4.ama_usr) as nom4 ".
			"FROM asignacion a 
			LEFT JOIN ordenes o ON a.id_orden=o.id_orden
			LEFT JOIN solucion s ON o.id_orden=s.id_orden
			LEFT JOIN conformidad c ON o.id_orden=c.id_orden
			LEFT JOIN users u1 ON o.cod_usr=u1.login_usr
			LEFT JOIN users u2 ON a.asig=u2.login_usr
			LEFT JOIN users u3 ON a.reg_asig=u3.login_usr
			LEFT JOIN users u4 ON a.escal=u4.login_usr
			LEFT JOIN t_asig_complejidad comp ON a.nivel_asig=comp.n_cod_complejidad
			LEFT JOIN t_asig_criticidad crit ON a.criticidad_asig=crit.n_cod_criticidad
			LEFT JOIN t_asig_prioridad prio ON a.prioridad_asig=prio.n_cod_prioridad
			WHERE '1'='1' $cond
			ORDER BY o.id_orden DESC";
$recordset_asig=mysql_query($sql_asig);
$num_filas=mysql_num_rows($recordset_asig);

//Paginacion
$num_paginas=$num_filas/20;
settype($num_paginas,'integer');
$pagina_fin=20*$pg;
$pagina_ini=($pagina_fin-20);
$sql_asig.=" LIMIT $pagina_ini, 20";
// Fin paginacion

$recordset_asig=mysql_query($sql_asig);
//echo '<table cellpadding="0" cellspacing="0" border="0" class="display" id="tbl_ordenes" name="tbl_ordenes">
echo '<table width="100%" border="1" align="center" cellpadding="0" cellspacing="2"  background="images/fondo.jpg">
		<thead>
			<tr><th colspan="17" align="center">ASIGNACIONES</th></tr>';
		echo '<tr align="center">  
				<th width="25" class="menu">Nro Orden</th>
				<th width="90" height="25" class="menu">INCIDENCIA</th>
				<th width="15" class="menu">ENVIADO POR</th>
				<th width="10" class="menu">COMP</th>
				<th width="10" class="menu">CRIT</th>
				<th width="10" class="menu">PRIO</th>
				<th width="15" class="menu">ASIGNADO A</th>';
		echo '	<th width="10" class="menu">SEGUI</th>
				<th width="60" class="menu">FECHA-HORA</th>
				<th width="17" class="menu">FECHA SOL</th>
				<th width="17" class="menu">ASIGNADO POR</th>
				<th width="17" class="menu">DIAGNOSTICO</th>';
		echo '	<th width="15" class="menu">ESCAL</th>
			</tr>
		</thead><tbody>';

$cont_sol=0;
$cont_ven=0;
$cont_nosol=0;
if (mysql_num_rows($recordset_asig)!=0){
	echo '<input type="hidden" value="'.mysql_num_rows($recordset_asig).'" id="num_registros">';
	for ($i=1;$i<=mysql_num_rows($recordset_asig);$i++){
		$fila_asig=mysql_fetch_array($recordset_asig);
		echo '<tr>';
		$fecha_limite=date($fila_asig['fechaestsol_asig']);
		
		if ($fechahoy>$fecha_limite){
			if($fila_asig['login_sol']!=''){
				$color="#00CC66";  // SOLUCIONADOS
				$cont_sol++;
			}
			else{
				$color="#A5BBF5";  //  VENCIDAS
				$cont_ven++;
			}
		}
		else{
			if($fila_asig['login_sol']!=''){
				$color="#00CC66";  // SOLUCIONADOS
				$cont_sol++;
			}else{
				$color="#FFFF00";   //  NO SOLUCIONADOS
				$cont_nosol++;
			}
		}
		echo '<td align="center" bgcolor="'.$color.'"><a href="solucion.php?id_orden='.$fila_asig['id_orden'].'">'.$fila_asig['id_orden'].'</td>';
		echo '<td align="center">'.$fila_asig['desc_inc'].'</td>';
		echo '<td align="center">'; if(!empty($fila_asig['nom1'])) { echo $fila_asig['nom1']; } else { echo "SISTEMA"; } echo '</td>';
		echo '<td align="center">'.$fila_asig['comp'].'</td>';
		echo '<td align="center">'.$fila_asig['crit'].'</td>';
		echo '<td align="center">'.$fila_asig['prio'].'</td>';
		echo '<td align="center">'.$fila_asig['nom2'].'</td>';
		$sql_segui="SELECT count(id_seg) as nro FROM seguimiento WHERE id_orden='".$fila_asig['id_orden']."'";
		$recordset_segui=mysql_query($sql_segui);
		$fila_segui=mysql_fetch_array($recordset_segui);
		echo '<td align="center"><a href="segui.php?id_orden='.$fila_asig['id_orden'].'">'.$fila_segui['nro'].'</a></td>';
		$fecha_asig=substr($fila_asig['fecha_asig'],8,2).'-'.substr($fila_asig['fecha_asig'],5,2).'-'.substr($fila_asig['fecha_asig'],0,4);
		echo '<td align="center">'.$fecha_asig.'<br>'.$fila_asig['hora_asig'].'</td>';
		if ($fila_asig['fecha_sol']!=''){
			$fecha_sol=substr($fila_asig['fecha_sol'],8,2).'-'.substr($fila_asig['fecha_sol'],5,2).'-'.substr($fila_asig['fecha_sol'],0,4);
			echo '<td align="center">'.$fecha_sol.'</td>';
		}
		else
			echo '<td align="center">-</td>';
		echo '<td align="center">'.$fila_asig['nom3'].'</td>';
		echo '<td align="center">'.$fila_asig['diagnos'].'</td>';
		if ($fila_asig['nom4']!='')
			echo '<td align="center">'.$fila_asig['nom4'].'</td>';
		else
			echo '<td align="center">-</td>';
		echo '</tr>';
	}
	echo '</tbody></table><br><br>';
}
else{
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
?>