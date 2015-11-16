<?php
require ('../funciones.php');
require ('../conexion.php');

@session_start();
$sqlT="INSERT INTO titular (ci_ruc,ciudad,nombre,apaterno,amaterno,acasada,email,entidad,area,especialidad,cargo,telf,externo,direccion) ".
	"VALUES('$ci_ruc','$ciudad','$nombre1','$apaterno','$amaterno','$acasada','$email','$entidad','$area1','$especialidad','$cargo','$telf','$externo','$direccion')"; 

if(mysql_query($sqlT)){
	echo 10;
} else {
	echo $sqlT;
}
?>