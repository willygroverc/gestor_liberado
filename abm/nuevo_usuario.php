<?php
// Version: 	1.0
// Autor: 		Cesar Cuenca
// Objetivo: 	Insercion de nuevo usuario 
// 			 	(separacion del codigo PHP y JAVASCRIPT)
// Fecha:		16/NOV/12
//_____________________________________________________________
// Autor: 		Cesar Cuenca
// Objetivo: 	Validación de Seguridad, SQL Injection y XSS.
// 			 	(separacion del codigo PHP y JAVASCRIPT)
// Fecha:		26/NOV/12
//_____________________________________________________________
@session_start();
require ("../conexion.php");
require_once('../funciones.php');

$login_usr=_clean($_POST['login']);
$sql="SELECT login_usr FROM users WHERE login_usr='$login_usr' LIMIT 1";
$recordset=mysql_query($sql);

if (mysql_num_rows($recordset)==1){ // Verificación de login existente en bd.
	echo -1;
}
else{
	$password_usr=md5($_POST['password']);
	$tipo_usr=_clean($_POST['tipo']);
	$tipo2_usr=_clean($_POST['tipo2']);
	$nom_usr=_clean($_POST['nom']);
	$apa_usr=_clean($_POST['apa']);
	$ama_usr=_clean($_POST['ama']);
	$email=_clean($_POST['email']);
	$email_alter=_clean($_POST['email_alter']);
	$enti_usr=_clean($_POST['enti']);
	$area_usr=_clean($_POST['area']);
	$cargo_usr=_clean($_POST['cargo']);
	$telf_usr=_clean($_POST['telf']);
	$ext_usr=_clean($_POST['ext']);
	$ciu_usr=_clean($_POST['ciu']);
	$direc_usr=_clean($_POST['direc']);
	$esp_usr=_clean($_POST['esp']);
	$adicional=_clean($_POST['agen']);
	$id_dat_tel_movil=_clean($_POST['id_tel']);
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
	
	$tipo_usr=normaliza($tipo_usr);
	$tipo2_usr=normaliza($tipo2_usr);
	$nom_usr=normaliza($nom_usr);
	$apa_usr=normaliza($apa_usr);
	$ama_usr=normaliza($ama_usr);
	$email=normaliza($email);
	$email_alter=normaliza($email_alter);
	$enti_usr=normaliza($enti_usr);
	$area_usr=normaliza($area_usr);
	$cargo_usr=normaliza($cargo_usr);
	$telf_usr=normaliza($telf_usr);
	$ext_usr=normaliza($ext_usr);
	$ciu_usr=normaliza($ciu_usr);
	$direc_usr=normaliza($direc_usr);
	$esp_usr=normaliza($esp_usr);
	$adicional=normaliza($adicional);
	$id_dat_tel_movil=normaliza($id_dat_tel_movil);
	$costo_usr=normaliza($costo_usr);
	
	if ($telf_usr=='')
		$telf_usr=0;
	
	if ($costo_usr=='')
		$costo_usr=0;
		
	$sql_usr="INSERT INTO users (login_usr,password_usr,tipo_usr,tipo2_usr,nom_usr,apa_usr,ama_usr,email,email_alter,enti_usr,area_usr,cargo_usr,telf_usr,ext_usr,ciu_usr,direc_usr,esp_usr,datetimereg_usr,bloquear,adicional1,id_dat_tel_movil,visualizacion,fecha_creacion,fecha_eliminacion,visualizacion_1,asig_usr,costo_usr)
	VALUES('$login_usr','$password_usr','$tipo_usr','$tipo2_usr','$nom_usr','$apa_usr','$ama_usr','$email','$email_alter','$enti_usr','$area_usr','$cargo_usr','$telf_usr','$ext_usr','$ciu_usr','$direc_usr','$esp_usr','".date("Y-m-d H:i:s")."','0','$adicional',$id_dat_tel_movil,'0','".date("Y-m-d")."','0000-00-00','0','0','$costo_usr')";
	//echo $sql;
	if (mysql_query($sql_usr)){ 
		$sql="INSERT INTO password_historico(login_usr,pass_h,fecha_a,fecha_n,realizado_por)
				VALUES('$login_usr','$password_usr','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."','".$_SESSION['login']."')";
		if (mysql_query($sql))
			echo 0; // Insercion correcta
		else
			echo $sql;
	}
	else
		echo -2; // Error al insertar registro
}
?>