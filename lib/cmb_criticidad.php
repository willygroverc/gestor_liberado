<?php
echo '<select id="cmb_criticidad" onchange="mostrar_asig();">
	<option value="0">Sin filtro</option>';
	$sql="SELECT n_cod_criticidad, n_indice, s_desc FROM t_asig_criticidad";
	$recordset=mysql_query($sql);
	for ($i=1;$i<=mysql_num_rows($recordset);$i++){
		$fila=mysql_fetch_array($recordset);
		echo '<option value="'.$fila['n_cod_criticidad'].'">'.$fila['n_indice'].' - '.$fila['s_desc'].'</option>';
	}
echo '</select>';
?>