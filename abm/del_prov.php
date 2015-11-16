<?php
@session_start();
require ("../conexion.php");
	$sql = "DELETE from proveedor WHERE IdProv='$IdProv'";   
	if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo -1;

?>