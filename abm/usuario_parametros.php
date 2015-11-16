<?php 
// Version:	1.0
// Objetivo: 	Modularizacion de funciones (Adicion, Bajas y Modificacion)
// Autor:		Cesar Cuenca
// Fecha:		11/Ene/2013
//________________________________________________________________________
require('../conexion.php');
$flag=$_POST['flag'];
$login_usr=  isset($_POST['login']);
$valor=  isset($_POST['valor']);
if ($flag==1){  // poder asignar
	$sql="UPDATE users SET asig_usr=$valor WHERE login_usr='$login_usr' LIMIT 1";
}
if ($flag==2 || $flag==3){  // Eliminar usuario - bloquear usuario
	$sql="UPDATE users SET bloquear=$valor WHERE login_usr='$login_usr' LIMIT 1";
}
if ($flag==4){ // Parametrizacion de Vistas en Orden de Trabajo
	$vista1=$_POST['param1'];
	$vista2=$_POST['param2'];
	$sql="UPDATE users SET visualizacion='$vista1' AND visualizacion_1='$vista2' WHERE login_usr='$login_usr' LIMIT 1";
}

if(mysql_query($sql)){
	echo 0;		// operacion correcta
}
else
	echo -1;		// error en consulta
?>