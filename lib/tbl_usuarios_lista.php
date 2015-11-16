<?php 
// Version:		1.0
// Autor:		Cesar Cuenca
// Objetivo:	Implementacion de Seguridad, cambio de transacciones de GET a POST.
// 				Modularizacion de tablas y filtros de busqueda
//				Optimizacion de consultas SQL.
//_________________________________________________________________________________
// Version:		2.0
// Autor:		Alvaro ROdriguez
// Objetivo:	Se ha corrgido el vista de los caracteres especiales y 
// 				se ha cambiado el formato de fecha.
//_________________________________________________________________________________
@session_start();
require('../conexion.php');
//header('Content-Type: text/html; charset=iso-8859-1');
//header('Content-Type: text/html; charset=UTF-8');
$usrbloq=$_POST['usrbloq'];
$usrint=$_POST['usrint'];
$usrext=$_POST['usrext'];
$usrelim=$_POST['usrelim'];
$agencia=$_POST['agencia'];
$area=$_POST['area'];
$busq=$_POST['busq'];
$pg=$_POST['pg'];
$cond="";
if ($usrbloq=="true" && $usrelim=="false")
	$cond.=' AND u.bloquear=1';

if ($usrelim=="true" && $usrbloq=="false")
	$cond.=' AND u.bloquear=2';

if ($usrbloq=="true" && $usrelim=="true")
	$cond.="";
	
if ($usrint=="true" && $usrext=="false")
	$cond.=" AND u.tipo_usr='INTERNO'";
	
if ($usrext=="true" && $usrint=="false")
	$cond.=" AND u.tipo_usr='EXTERNO'";
	
if ($usrint=="true" && $usrext=="true")
	$cond.="";

if ($agencia!=0)
	$cond.=" AND u.adicional1='$agencia'";
	
if ($area!=0)
	$cond.=" AND u.area_usr='$area'";

if ($busq!='')
	$cond.=" AND (u.login_usr LIKE '$busq%' OR u.nom_usr LIKE '$busq%' OR u.apa_usr LIKE '$busq%' OR u.ama_usr LIKE '$busq%')";

  $cont_bloq=0;
  $cont_int=0;
  $cont_ext=0;
  $cont_eli=0;
  echo '<table width="95%" border="1" align="center" background="images/fondo.jpg">
			<tr align="center">
				<th width="5%"><a class="menu" href="#">LOGIN</a></th>
				<th width="4%"><a class="menu" href="#">TIPO</a></th>
				<th width="20%" class="menu"><a href="#" class="menu">NOMBRES</a>&nbsp;Y&nbsp;<a class="menu" href="#">APELLIDOS</a></th>
				<th width="7%" class="menu">AGENCIA</th>
				<th width="5%"><a class="menu" href="#">AREA</a></th>
				<th width="6%"><a class="menu" href="#">CARGO</a></th>';
				if($_SESSION['tipo']=='A') {
					echo '<th width="5%"><font class="menu">&nbsp;&nbsp;PODER ASIGNAR&nbsp;&nbsp;</font></th>';
				}
				echo '<th width="4%"><a class="menu" href="#">TELF</a></th>
				<th align="center" width="18%"><a class="menu" href="#">DIRECCION</a></th>';
				if($_SESSION['tipo']=='A') {
				echo '<th class="menu" width="5%">ELIMINAR</th>
				<th class="menu" width="8%" colspan="2">PRIVIL</th>
				<th class="menu" width="13%">ULT. ACCESO</th>
				<th class="menu" width="8%">BLOQUEAR DESBLOQUEAR</th>';
				}
				echo '<th class="menu" width="4%">IMPRIMIR</th> 
		  </tr>';
    
	$sql="SELECT u.login_usr,u.tipo_usr, u.tipo2_usr, u.nom_usr, u.apa_usr, u.ama_usr, u.email, u.email_alter, u.enti_usr, da2.nombre_dadicional as area, da1.nombre_dadicional as agencia, u.cargo_usr, u.ext_usr, u.ext_usr, u.ciu_usr, u.direc_usr, u.esp_usr, u.adicional1, u.bloquear, u.fecha_creacion, u.fecha_eliminacion, u.asig_usr 
	FROM users u LEFT JOIN datos_adicionales da1 ON u.adicional1=da1.id_dadicional
	LEFT JOIN datos_adicionales da2 ON u.area_usr=da2.id_dadicional WHERE 1=1 $cond";
	//echo $sql;
	$recordset=mysql_query($sql);
	$num_paginas=mysql_num_rows($recordset);
	$num_paginas=($num_paginas/20)+1;
	settype($num_paginas,'integer');
	$pagina_fin=20*$pg;
	$pagina_ini=($pagina_fin-20);
	$sql.=" LIMIT $pagina_ini, 20";
	$recordset=mysql_query($sql);
// Fin paginacion
	//echo $sql;
	if (mysql_num_rows($recordset)!=0){
		for($i=1;$i<=mysql_num_rows($recordset);$i++){
			$fila=mysql_fetch_array($recordset);
			$color="";
			echo '<tr>';
			if ($fila['bloquear']==0){
				if ($fila['tipo_usr']=='INTERNO')
					$color='bgcolor="#00CC00"';
				if ($fila['tipo_usr']=='EXTERNO')
					$color='bgcolor="#FFFF00"';
			}
			else
			{
				if ($fila['bloquear']==1){
					$color='bgcolor="#A5BBF5"';
				}
				else{
					$color='bgcolor="#FF6666"'; 
				}
			}	
			
			echo '<td align="center" '.$color.'><a href="usuario_modi.php?login_usr='.$fila['login_usr'].'">'.$fila['login_usr'].'</a></td>';
			
			echo '<td align="center">'.$fila['tipo2_usr'].'</td>';
			echo '<td align="center">'.$fila['nom_usr'].' '.$fila['apa_usr'].' '.$fila['ama_usr'].'</td>';
			
			if ($fila['agencia']=='')
				echo '<td align="center">Sin Agencia</td>';
			else
				echo '<td align="center">'.$fila['agencia'].'</td>';
			
			echo '<td align="center">'.$fila['area'].'</td>';
			echo '<td align="center">'.$fila['cargo_usr'].'</td>';
			if ($fila['asig_usr']==0){
				if ($fila['bloquear']!=2) {
					if($_SESSION['tipo']=='A') {
						echo '<td align="center">
						<a href="javascript:usuario_parametros(\''.$fila['login_usr'].'\',1,1)">
						<img src="images/no3.gif" border="0" alt="Habilitar Asignacion"></img></a></td>';
					}
				}
				else {
					if($_SESSION['tipo']=='A') {
						echo '<td align="center">
						<img src="images/no3.gif" border="0" alt="Habilitar Asignacion"></img></td>';
					}
				}
			}
			else{
				if($_SESSION['tipo']=='A') {
					echo '<td align="center">
						<a href="javascript:usuario_parametros(\''.$fila['login_usr'].'\',1,0)">
						<img src="images/ok.gif" border="0" alt="Deshabilitar Asignacion"></img></a></td>';
				}
			}
			if ($fila['ext_usr']==0)
				echo '<td align="center">-</td>';
			else
				echo '<td align="center">'.$fila['ext_usr'].'</td>';
			echo '<td align="center">'.$fila['ciu_usr'].'-'.$fila['direc_usr'].'</td>';
			
			if ($fila['bloquear']==2){
				if($_SESSION['tipo']=='A') {
					echo '<td align="center">Eliminado</td>';
				}
				$cont_eli++;
				}
			else {
				if($_SESSION['tipo']=='A')
					echo '<td align="center"><a href="javascript:usuario_parametros(\''.$fila['login_usr'].'\',2,2)"><img src="images/eliminar.gif" border="0" alt="Eliminar"></a></td>';
			}
			if ($fila['bloquear']!=2){
				if($_SESSION['tipo']=='A')
					echo '<td align="center"><a href="roles.php?login_usr='.$fila['login_usr'].'"><img src="images/usuario.gif" border="0" alt="Roles"></a>&nbsp;</td>';
			} else {
				if($_SESSION['tipo']=='A')
					echo '<td align="center"><img src="images/usuario.gif" border="0" alt="Roles">&nbsp;</td>';
			}
			if($_SESSION['tipo']=='A') {
				echo '<td align="center"><a href="javascript:ver_roles(\''.$fila['login_usr'].'\')">
					<img src="images/imprimir.gif" border="0"></img></a></td>';
			}
			$sql_ingreso="SELECT DATE_FORMAT(fecha,'%Y-%m-%d') as ult_acceso FROM registro WHERE login_usr='".$fila['login_usr']."' AND tipo_c='INGRESO' ORDER BY fecha DESC LIMIT 0,1";
			$recordset_ingreso=mysql_query($sql_ingreso);
			$fila_ingreso=mysql_fetch_array($recordset_ingreso);
			if (mysql_num_rows($recordset_ingreso)==0) {
				if($_SESSION['tipo']=='A') 
					echo '<td align="center">El usuario aun no ha ingresado al sistema</td>';
			} else {
				if($_SESSION['tipo']=='A') 
					echo '<td align="center">'.$fila_ingreso['ult_acceso'].'</td>';
			}
			if ($fila['bloquear']==1){
				$cont_bloq++;
				if($_SESSION['tipo']=='A') {
					echo '<td align="center">
						<font color="#FF0000" face="Arial, Helvetica, sans-serif">
						<a href="javascript:usuario_parametros(\''.$fila['login_usr'].'\',3,0)"><img src="images/desbloquear.gif" border="0" alt="Habilitar"></a></font>&nbsp;
						</td>';
				}
			}
			else{
				if ($fila['bloquear']!=2) {
					if($_SESSION['tipo']=='A') 	
						echo '<td align="center"><a href="javascript:usuario_parametros(\''.$fila['login_usr'].'\',3,1)"><img src="images/bloquear.gif" border="0" alt="Bloquear"></img></a>&nbsp;</td>';
				}
				else {
					if($_SESSION['tipo']=='A') 
						echo '<td align="center"><img src="images/bloquear.gif" border="0" alt="Bloquear">&nbsp;</td>';
				}
			}
			
			echo '<td align="center"><a href="ver_usuario.php?login_usr='.$fila['login_usr'].'" target="_blank">
			<img src="images/imprimir.gif" border="0" alt="Imprimir Interno"></a></td>';
			
			if ($fila['tipo_usr']=='INTERNO')
				$cont_int++;
			if ($fila['tipo_usr']=='EXTERNO')
				$cont_ext++;
			echo '</tr>';
		}
	}
	else{
		echo '<tr><td align="center" colspan="15" valign="center"><h5>No se han encontrado resultados</h5></td></tr>';
	}
	echo '</table><br><br>';
	
	
/*PAGINACION*/
echo '<center><b><font size="2">Pagina(s): ';

if ($pg>20){
	echo '<a href="javascript:pag_lista(3,0);">Anterior,&nbsp</a>';
	$pagina_ini=$pg-20+1;
	$pagina_fin=$pg;
}
else{
	$pagina_ini=1;
	$pagina_fin=$num_paginas;
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
if ($i>20){
	echo '<a href="javascript:pag_lista(2,0)">&nbsp;Siguiente</a>';
}
/*FIN PAGINACION*/
	echo '<table width="90%" border="1" align="center">
		<tr> 
			<td width="15%" height="28" align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO CON CUENTA BLOQUEADA</font>
			</td>
			<td width="5%" bgcolor="#A5BBF5" align="center">'.$cont_bloq.'</td>
			<td width="5%">&nbsp;</td>
			<td width="15%" align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO INTERNO</font></td>
			<td width="5%" bgcolor="#00CC00" align="center">'.$cont_int.'</td>
			<td width="5%">&nbsp;</td>
			<td width="15%" align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO EXTERNO</font></td>
			<td width="5%" bgcolor="#FFFF00" align="center">'.$cont_ext.'</td>
			<td width="5%">&nbsp;</td>
			<td width="15%" align="center"><font size="1" face="Arial, Helvetica, sans-serif">USUARIO ELIMINADO</font></td>
			<td width="5%" bgcolor="#FF6666" align="center">'.$cont_eli.'</td>
	  </tr>
	</table>
	<div align="center"><br>';
    if($_SESSION['tipo']=='A') {
		echo '<input name="IMPRESION" type="button" id="IMPRESION" value="IMPRIMIR" onClick="openStat_2()">';
	}
	echo '</div>';
	
	