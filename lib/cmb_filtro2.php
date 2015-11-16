<?php
require ('../conexion.php');
$id_agencia=$_POST['agencia'];
$opc=$_POST['opc'];
if ($opc!=0){
	if ($opc==1){  // ENVIADAS POR TECNICO
		if ($id_agencia==0)
			$sql="SELECT o.cod_usr as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr 
			WHERE u.tipo2_usr='T' GROUP BY o.cod_usr, u.nom_usr, u.apa_usr, u.ama_usr";
		else
			$sql="SELECT o.cod_usr as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr 
			WHERE u.tipo2_usr='T' AND u.adicional1='$id_agencia' GROUP BY o.cod_usr, u.nom_usr, u.apa_usr, u.ama_usr";
	}
	if ($opc==2){  // ENVIADAS POR CLIENTE
		if ($id_agencia==0)
			$sql="SELECT o.cod_usr as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr 
			WHERE u.tipo2_usr='C' GROUP BY o.cod_usr, u.nom_usr, u.apa_usr, u.ama_usr";
		else
			$sql="SELECT o.cod_usr as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM ordenes o LEFT JOIN users u ON o.cod_usr=u.login_usr 
			WHERE u.adicional1='$id_agencia' AND u.tipo2_usr='C' GROUP BY o.cod_usr, u.nom_usr, u.apa_usr, u.ama_usr";
	}
	if ($opc==3){  // FILTRO POR AREA
		$sql="SELECT id_dadicional as id, nombre_dadicional as nombre FROM datos_adicionales WHERE tipo_dadicional='area'";
	}
	if ($opc==4){  // ENVIADAS POR CLIENTE
		if ($id_agencia==0)
			$sql="SELECT a.asig as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM asignacion a 
			LEFT JOIN users u ON a.asig=u.login_usr 
			GROUP BY a.asig, u.nom_usr, u.apa_usr, u.ama_usr";
		else
			$sql="SELECT a.asig as id, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nombre FROM asignacion a 
			LEFT JOIN users u ON a.asig=u.login_usr 
			WHERE u.adicional1='$id_agencia' GROUP BY a.asig, u.nom_usr, u.apa_usr, u.ama_usr";
	}
	$recordset=mysql_query($sql);
	echo '<select id="nombre" name="nombre">';
	if (mysql_num_rows($recordset)){
		for ($i=1;$i<=mysql_num_rows($recordset);$i++){
			$fila=mysql_fetch_array($recordset);
			if ($fila['nombre']!='')
				echo '<option value="'.$id.'">'.$fila['nombre'].'</option>';
		}
	}
	else
		echo '<option value="-1">No existen registros</option>';
	echo '</select>';
}
else
	echo '<select id="nombre" name="nombre"><option value="0">Sin seleccionar</option></select>';

?>