<?php
// Version: 	1.0
// Autor: 		Cesar Cuenca
// Objetivo: 	Insercion de nuevo usuario (lado del servidor)
// 			 	(separacion del codigo PHP y JAVASCRIPT)
// Fecha:		16/NOV/12
//_____________________________________________________________
include ("../conexion.php");
include ("../funciones.php");
session_start();
$pass_actual=$_POST['pass'];
$pass_nuevo=$_POST['pass_nuevo'];
$login=$_SESSION['login'];
$sql="SELECT password_usr FROM users WHERE login_usr='".$_SESSION['login']."' LIMIT 1";
$recordset=mysql_query($sql);
$fila=mysql_fetch_array($recordset);

if (md5($pass_actual)!=$fila['password_usr']){
	echo -1; // Contrase�a incorrecta;
	exit;
}
	else{
	$sql="SELECT pass_longitud, pass_secuencial, pass_repetidos FROM control_parametros";
	$rs=mysql_query($sql);
	$pass=mysql_fetch_array($rs);
	$password_usr_inv=strrev($pass_actual);
	$pass_longitud = $pass["pass_longitud"];

	$pass_actual = md5($pass_actual); 
	$pass_nuevo = md5($pass_nuevo);

	$sql_hp="SELECT pass_historial FROM control_parametros";
	$result_hp=mysql_query($sql_hp);
	$row_hp=mysql_fetch_array($result_hp);
					
	$num_rep=0;
	$sql_pash="SELECT id_pass_h FROM password_historico WHERE login_usr='".$_SESSION['login']."' AND realizado_por='".$_SESSION['login']."' AND pass_h='".$pass_nuevo."'";
	$result_pash=mysql_query($sql_pash);
	$num_rep=mysql_num_rows($result_pash);

	if($num_rep==0){
		$sql = "UPDATE users SET password_usr='$pass_nuevo' WHERE login_usr='".$_SESSION['login']."' LIMIT 1";				
		if (mysql_query($sql)) {
            $sql_pash2 = "SELECT * FROM password_historico WHERE login_usr='" . $_SESSION['login'] . "' ORDER BY id_pass_h DESC limit 1";
            $result_pash2 = mysql_query($sql_pash2);
            $row_pash2 = mysql_fetch_array($result_pash2);
            $sql_h = "INSERT INTO password_historico(login_usr,pass_h,fecha_a,fecha_n,realizado_por) " .
                    "VALUES('$login','$pass_nuevo','" . $row_pash2['fecha_n'] . "','" . date("Y-m-d H:i:s") . "','" . $_SESSION['login'] . "')";
            if (mysql_query($sql_h)) {
                echo 0;
            }  // Password se ha modificado satisfactoriamente
            else {
                echo -4;
            } // Error al modificar password historico
        } else {
            echo -2;
        } // Error al modificar password
	}
	else{
		echo -3; //password nuevo no puede ser igual a las contrase�as anteriores";
	}
}
?>