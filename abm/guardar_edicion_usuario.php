<?php
// Version: 	1.0
// Autor: 		Cesar Cuenca
// Objetivo: 	Insercion de nuevo usuario 
// 			 	(separacion del codigo PHP y JAVASCRIPT)
//			 	Validaci�n de Seguridad, SQL Injection y XSS.
// 			 	(separacion del codigo PHP y JAVASCRIPT)
// Fecha:		28/NOV/12
//_____________________________________________________________
@session_start();
require ("../conexion.php");
require_once('../funciones.php');

$login_usr=_clean($_POST['login']);

$sw_pass=$_POST['sw_pass'];
$flag=0;

	if ($sw_pass==1){ // Actualizacion de Password	
		$password_usr=$_POST['password'];
		$sql="SELECT pass_h FROM password_historico WHERE login_usr='$login_usr' AND pass_h='".md5($password_usr)."'";
		$recordset=mysql_query($sql);
		if (mysql_num_rows($recordset)!=0){
			$flag=-1;
		}
		
		$sql="SELECT pass_longitud, pass_secuencial, pass_repetidos FROM control_parametros";
		$recordset=mysql_query($sql);
		$fila=mysql_fetch_array($recordset);
		if (strlen($password_usr)<$fila['pass_longitud'])
			$flag=$fila['pass_longitud'];
		
		if( strtoupper($_POST['nom'])==strtoupper($password_usr) || strtoupper($_POST['apa'])==strtoupper($password_usr) || strtoupper($_POST['ama'])==strtoupper($password_usr)){
			$flag=-2;
		}
		$password_usr=md5($password_usr);
	}
	if ($flag==0){
		$tipo_usr=_clean($_POST['cliente']);
		$tipo2_usr=_clean($_POST['tipo']);
		$nom_usr=_clean($_POST['nom']);
		$apa_usr=_clean($_POST['apa']);
		$ama_usr=_clean($_POST['ama']);
		$email=_clean($_POST['email']);
		$email_alter=_clean($_POST['email_alter']);
		$enti_usr=_clean($_POST['enti']);
		$area_usr=_clean($_POST['area']);
		$cargo_usr=_clean($_POST['cargo']);
		$telf_usr=_clean($_POST['tel']);
		$ext_usr=_clean($_POST['cel']);
		$ciu_usr=_clean($_POST['ciu']);
		$direc_usr=_clean($_POST['direc']);
		$esp_usr=_clean($_POST['esp']);
		$adicional=_clean($_POST['agen']);
		$id_dat_tel_movil=_clean($_POST['id_cel']);
		$costo_usr=_clean($_POST['costo']);
		
		$tipo_usr=SanitizeString($tipo_usr);
		$tipo2_usr=SanitizeString($tipo2_usr);
		$nom_usr=SanitizeString($nom_usr);
		$apa_usr=SanitizeString($apa_usr);
		$ama_usr=SanitizeString($ama_usr);
		$email=SanitizeString($email);
		$email_alter=SanitizeString($email_alter);
		$enti_usr=SanitizeString($enti_usr);
		$area_usr=SanitizeString($area_usr);
		$cargo_usr=SanitizeString($cargo_usr);
		$telf_usr=SanitizeString($telf_usr);
		$ext_usr=SanitizeString($ext_usr);
		$ciu_usr=SanitizeString($ciu_usr);
		$direc_usr=SanitizeString($direc_usr);
		$esp_usr=SanitizeString($esp_usr);
		$adicional=SanitizeString($adicional);
		$id_dat_tel_movil=SanitizeString($id_dat_tel_movil);
		$costo_usr=SanitizeString($costo_usr);
			
		if ($sw_pass==0)	
			$sql="UPDATE users ".
			"SET tipo_usr='$tipo_usr',tipo2_usr='$tipo2_usr',nom_usr='$nom_usr',apa_usr='$apa_usr',ama_usr='$ama_usr',email='$email',enti_usr='$enti_usr',area_usr='$area_usr',cargo_usr='$cargo_usr',telf_usr='$telf_usr',ext_usr='$ext_usr',ciu_usr='$ciu_usr',direc_usr='$direc_usr',esp_usr='$esp_usr',datetimereg_usr='".date("Y-m-d H:i:s")."',adicional1='$adicional', id_dat_tel_movil=$id_dat_tel_movil, costo_usr='$costo_usr' ".
			" WHERE login_usr='$login_usr' LIMIT 1";
		else
			$sql="UPDATE users ".
			"SET password_usr='$password_usr', tipo_usr='$tipo_usr',tipo2_usr='$tipo2_usr',nom_usr='$nom_usr',apa_usr='$apa_usr',ama_usr='$ama_usr',email='$email',enti_usr='$enti_usr',area_usr='$area_usr',cargo_usr='$cargo_usr',telf_usr='$telf_usr',ext_usr='$ext_usr',ciu_usr='$ciu_usr',direc_usr='$direc_usr',esp_usr='$esp_usr',datetimereg_usr='".date("Y-m-d H:i:s")."',adicional1='$adicional', id_dat_tel_movil=$id_dat_tel_movil, costo_usr='$costo_usr' ".
			" WHERE login_usr='$login_usr' LIMIT 1";
			
		if (mysql_query($sql))
			echo 0;
		else
			echo -3;
	
	}
	else{
		echo $flag;
	}
	
	//echo $sql;
	/*if (mysql_query($sql))
		echo 0; // Insercion correcta
	else
		echo -2; // Error al insertar registro
	*/
?>