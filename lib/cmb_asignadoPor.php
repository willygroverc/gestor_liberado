<?php
@session_start();
$cond='';
if ($_SESSION['tipo']=='T')
	$cond.=" AND u.adicional1='".$_SESSION['agencia']."'";

echo '<select id="cmb_asignadoPor" onchange="mostrar_asig();">
		<option value="0">Todos los usuarios</option>';
		$sql="SELECT u.login_usr, u.tipo2_usr, CONCAT(u.nom_usr,' ',u.apa_usr,' ',u.ama_usr) as nom FROM users u WHERE '1'='1' $cond";
		$recordset=mysql_query($sql);
		for ($i=1;$i<=mysql_num_rows($recordset);$i++){
			$fila=mysql_fetch_array($recordset);
			echo '<option value="'.$fila['login_usr'].'">'.$fila['tipo2_usr'].' - '.$fila['nom'].'</option>';
		}
echo '</select>';
?>