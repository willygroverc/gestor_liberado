<?php
// version:		1.0
// Objetivo:	Cambiar modo GET a POST en mensajes de validacion.
//				Declaracion de variables de sesion para reducir el numero de request al servidor.
// Autor:		Cesar Cuenca
// fecha:		16/NOV/12
//____________________________________________________________________

require("conexion.php");

// OBTENCION DE PARAMETROS NUMERO DE INTENTOS FALLIDOS PERMITIDOS//
$sql="SELECT intentos_cont, intentos_disc FROM control_parametros";
		$recordset=mysql_query($sql);
		$fila=mysql_fetch_array($recordset);
		$intentos_cont=$fila["intentos_cont"];
		$intentos_disc=$fila["intentos_disc"];
// 
$puerto=$_SERVER['SERVER_PORT'];
$servidor=$_SERVER['SERVER_NAME'];
$password=md5($_POST['password']);
$login=$_POST['login'];

// Variables de Sesion:
$_SESSION['servidor']=$servidor;
$_SESSION['puerto']=$puerto;
ini_set("error_reporting", "E_ALL & ~E_NOTICE & ~E_WARNING");

if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	$ip = $_SERVER['HTTP_CLIENT_IP'];

}
else{
	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$ip=$_SERVER['REMOTE_ADDR'];
	}
}

$sql="SELECT login_usr FROM users WHERE login_usr='$login' LIMIT 1";
$recordset=mysql_query($sql);
$sw=0; // Bandera de Estados - Flags
@session_start();
if (mysql_num_rows($recordset)==0){
	echo -1; // Login incorrecto
	exit;
}
else{
	$sql="SELECT nom_usr, apa_usr, ama_usr, bloquear, password_usr, tipo2_usr, adicional1 FROM users WHERE login_usr='$login' AND password_usr='$password' LIMIT 1";
	$recordset=mysql_query($sql);
	if (mysql_num_rows($recordset)==1){   // PASSWORD INTRODUCIDO CORRECTO!
		$fila=mysql_fetch_array($recordset);
		$nombre=$fila['nom_usr'].' '.$fila['apa_usr'].' '.$fila['ama_usr'];
		$password=$fila['password_usr'];
		$tipo=$fila['tipo2_usr'];
		$agencia=$fila['adicional1'];
		if ($fila['bloquear']==2){
			echo -1;	// Usuario ELIMINADO;
			exit;
		}
		else{
			if ($fila['bloquear']==1){
				echo -2;   // Usuario BLOQUEADO
				exit;
			}
			else{    		// CREDENCIALES CORRECTAS
				$fechahoy=date("Y-m-d H:i:s");
				$sql="INSERT INTO registro (login_usr,tipo_c,tipo_d,datos,ip,fecha) ".
					"VALUES('$login','INGRESO','INGRESO','$HTTP_USER_AGENT','$REMOTE_ADDR','$fechahoy')";
				if (mysql_query($sql)){
					session_start();
						//=================== VARIABLES DE SESION ================
					$_SESSION['login']=$login;
					$_SESSION['nombre']=$nombre;
					$_SESSION['agencia']=$agencia;
					$_SESSION['tipo']=$tipo;
					$_SESSION['ip']=$ip;
					$_SESSION['hash']=$password;
					$sql_path="SELECT t_param_path FROM paths WHERE id_path=1";
					$recordset_path=mysql_query($sql);
					$fila_path=mysql_fetch_array($sql);
					$_SESSION['path_uploads']=$fila_path['path'];
					echo 0;
				}
			}
		}
	}
	else{			// ERROR AL INTRODUCIR PASSWORD -> ACTUALIZAR NUMERO DE INTENTOS
		
		$fechahoy=date("Y-m-d H:i:s");
		$sql="INSERT INTO ".
		"registro (login_usr,tipo_c,tipo_d,datos,ip,fecha) ".
		"VALUES('$login','FALLO','FALLO','$HTTP_USER_AGENT','$REMOTE_ADDR','$fechahoy')";
		mysql_query($sql);
		
		$sql="SELECT id_log, login_usr, tipo_c, tipo_d, datos, ip, fecha FROM registro 
			WHERE login_usr='$login' ORDER BY fecha DESC LIMIT 1,$intentos_cont";
		
		$recordset=mysql_query($sql);
		$num_intentos_realizados=mysql_num_rows($recordset);
		
		$cont_fallidos=1;
		for($i=1;$i<=mysql_num_rows($recordset);$i++){
			$fila=mysql_fetch_array($recordset);
			if ($fila['tipo_c']=='FALLO' && $fila['tipo_d']=='FALLO')
				$cont_fallidos++;
		}
		
		
		if ($intentos_cont==$cont_fallidos-1){
			$sql="SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$login' LIMIT 1";	
			$recordset=mysql_query($sql);
			$fila=mysql_fetch_array($recordset);
			$nombre=$fila['nom_usr'].' '.$fila['apa_usr'].' '.$fila['ama_usr'];
			$desc="El usuario $nombre ha sobrepasado el numero de intentos permitidos, su cuenta se encuentra bloqueada";
			$sql="INSERT INTO ordenes (id_orden, fecha, time, cod_usr, desc_inc, tipo, nomb_archivo, area, dominio, objetivo, ci_ruc, id_anidacion, origen, hash_archivo, observaciones, sarc) 
			VALUES(null, '".date('Y-m-d')."','".date('H:i:s')."','SISTEMA','$desc','', '', 0,0,0,'',0,'','','',0)"; 
			if (mysql_query($sql)){
				echo -3;
				exit;
			}
		}
		else{
			echo $cont_fallidos;
		}
	}
}
//mysql_close();
?>