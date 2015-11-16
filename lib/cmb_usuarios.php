<?php
@session_start();
//$sql="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE adicional1='".$_SESSION['agencia']."' AND bloquear<>2";
$sql="SELECT login_usr, nom_usr, apa_usr, ama_usr FROM users WHERE bloquear<>2";
$recordset=mysql_query($sql);
$funcion='onchange="filtrar_lista();"';
echo '<select id="cmb_usuarios" name="cmb_usuarios" '.$funcion.'>';
echo '<option value="0">Todos</option>';
for ($i=1;$i<=mysql_num_rows($recordset);$i++){
	$fila=mysql_fetch_array($recordset);
	echo '<option value="'.$fila['login_usr'].'">'.$fila['apa_usr'].' '.$fila['ama_usr'].' '.$fila['nom_usr'].'</option>';
}
echo '</select>';
?>