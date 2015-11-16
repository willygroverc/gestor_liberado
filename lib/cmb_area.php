<?php
@session_start();
$funcion='';
$lbl="";
if (isset($_POST['flag']) && $_POST['flag']==1){
		require('../conexion.php');
}
	
if ($_SESSION['modulo']=='usuario_nuevo' || $_SESSION['modulo']=='usuario_modi'){
	$funcion="";
}

if ($_SESSION['modulo']=='lista'){
	$funcion='onchange="filtrar_usuario_lista();"';
	$lbl='Sin Especificar';
}

if ($_SESSION['modulo']=='usuario_nuevo'){
	$funcion='';
	$lbl='Seleccione Area';
}

if ($_SESSION['modulo']=='usuarios'){
	$funcion='onchange="filtrar_usuarios();"';
	$lbl='Todas';
}
	echo '<select id="area_usr" name="area_usr" '.$funcion.'>
			<option value="0">'.$lbl.'</option>';
				$sql="SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='area' AND estado='0'";
				$recordset=mysql_query($sql);
				for ($i=1;$i<=mysql_num_rows($recordset);$i++){
					$fila=mysql_fetch_array($recordset);
					echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
				}
	echo '</select>';
?>