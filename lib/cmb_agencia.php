<?php 
@session_start();
	if (isset($_POST['flag']) && $_POST['flag']==1){
			require('../conexion.php');
	}
	if ($_SESSION['modulo']=='usuarios'){
		$funcion="onchange=filtrar_usuarios();";
		$defecto='Sin especificar';
	}
	if ($_SESSION['modulo']=='usuario_nuevo'){
		$funcion="";
		$defecto='Seleccione Agencia';
	}
	if ($_SESSION['modulo']=='reportes'){
		$funcion="onchange=act_filtro2();";
		$defecto='Todas las Agencias';
	}
	echo '<select name="agencia" id="agencia" '.$funcion.'>
				<option value="0">'.$defecto.'</option>';
				$sql = "SELECT id_dadicional, nombre_dadicional FROM datos_adicionales WHERE tipo_dadicional='agencia' AND estado='0' ORDER BY nombre_dadicional ASC";
				$result=mysql_query($sql);
				for ($i=1;$i<=mysql_num_rows($result);$i++){
					$fila=mysql_fetch_array($result);
					echo '<option value="'.$fila['id_dadicional'].'">'.$fila['nombre_dadicional'].'</option>';
				}
    echo '</select>';
?>