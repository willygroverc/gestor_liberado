<?php
require('../conexion.php');
$id_area=$_POST['id_area'];
$cond='';
if ($id_area!=0)
	$cond=" AND u.area_usr='$id_area'";
$sql="SELECT u.login_usr, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre, tipo2_usr FROM users u 
WHERE (u.tipo2_usr='C' OR u.tipo2_usr='T') $cond";
$recordset=mysql_query($sql);
echo '<select id="cmb_enviadoPor" name="cmb_enviadoPor" onchange="document.getElementById(\'pg\').value=1;filtrar_lista();">';
echo '<option value="0">Seleccionar Usuario</option>';
for ($i=1;$i<=mysql_num_rows($recordset);$i++){
	$fila=mysql_fetch_array($recordset);
	echo '<option value="'.$fila['login_usr'].'">';
	echo $fila['tipo2_usr'].'&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;'.$fila['nombre'];
	echo '</option>';
}
echo '</select>';
?>