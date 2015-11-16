<?php
@session_start();
require('../conexion.php');
require('../funciones.php');

$id_agencia=$_POST['agencia'];
$id_agencia=_clean($id_agencia);
$id_agencia=SanitizeString($id_agencia);

$id_area=$_POST['area'];
$id_area=_clean($id_area);
$id_area=SanitizeString($id_area);
$filtro=$_POST['filtro'];
$cond='';
if ($id_agencia!=0){
	if ($id_area!=0)
		$cond.=" AND adicional1='$id_agencia' AND area_usr='$id_area'";
	else
		$cond.=" AND adicional1='$id_agencia'";	
}
else{
	if ($id_area!=0)
		$cond.=" AND area_usr='$id_area'";
	else
		$cond.="";
}

if ($filtro=='1' || $filtro=='3')
	$cond.=" AND tipo2_usr='T'";
if ($filtro=='2')
	$cond.=" AND tipo2_usr='C'";

$sql="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE 1=1 $cond AND bloquear<>2";
$recordset=mysql_query($sql);
//$funcion='';
$funcion='onchange="filtrar_lista();"';
echo '<select id="cmb_nombre" name="cmb_nombre" '.$funcion.'>';
	if ($filtro!='0'){
		if (mysql_num_rows($recordset)>0){
			echo '<option value="0">Todos</option>';
			for ($i=1;$i<=mysql_num_rows($recordset);$i++){
				$fila=mysql_fetch_array($recordset);
				echo '<option value="'.$fila['login_usr'].'">'.$fila['apa_usr'].' '.$fila['ama_usr'].' '.$fila['nom_usr'].'</option>';
			}
		}
		else
			echo '<option value="0">Ningun Usuario</option>';
	}
	else
		echo '<option value="0">Seleccione Filtro</option>';
echo '</select>';
//echo $sql;
?>