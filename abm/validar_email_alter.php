<?php
// Version: 	1.0
// Modulo:		Recuperar contraseña
// Fecha:		17/NOV/12
// Autor:		Cesar Cuenca
// Objetivo:	Verificar si el emal proporcionado es valido y restablecer contraseña.
//__________________________________________________________________________________

// Version: 	2.0
// Modulo:		Recuperar contraseña
// Fecha:		17/MAR/13
// Autor:		Alvaro Rodriguez
// Objetivo:	Mejorar el envio debido al formato html.__
@session_start();
require ("../conexion.php");
$email=$_POST['ea'];
$sql="SELECT login_usr FROM users WHERE email='$ea' OR email_alter='$ea' LIMIT 1"; 
$recordset=mysql_query($sql);
if (mysql_num_rows($recordset)==1){
	$fila=mysql_fetch_array($recordset);
	srand (); 
	$nuevo_pass = rand(100000,9999999); 
	$sql="UPDATE users SET password_usr='".md5($nuevo_pass)."' WHERE email='$email'";
	
		$mensaje='<html>
					<body>
						<table border="1">
							<tr>
								<td colspan="2">Gestor F1</td>
							</tr>
							<tr>
								<td>Usuario:</td><td>'.$fila['login_usr'].'</td>
							</tr>
							<tr>
								<td>Nuevo Password:</td><td>'.$nuevo_pass.'</td>
							</tr>
						</table>
						<br>
						Ingrese al sistema con el nuevo password y cambie inmediatamente el password.
					</body>
				</html>';
		$tuemail="gestorf1@yanapti.com";		
		$email1="arodriguez@yanapti.com";
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers .= "From: $tunombre <$tuemail>\r\n";

$asunto="GesTor F1 - Password Nuevo";
		
		//$headers = "From: gestor_F1@yanapti.com\r\n" . "Reply-To: arodriguez@yanapti.com\r\n" . "Return-path: arodriguez@yanapti.com\r\n" . "MIME-Version: 1.0\n" . "Content-type: text/html; charset=iso-8859-1"; 
	if ( mail ($email, $asunto, $mensaje, $headers )){
		if (mysql_query($sql)){
			echo 0;
		}
	}
	else{
		echo $sql;
	}
}
else{
	echo -2;
}
?>