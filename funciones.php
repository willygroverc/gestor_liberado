<?php
function normaliza ($string){
   $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('&aacute;', 'a', 'a', 'a', 'a', '&Aacute;', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('&eacute;', 'e', 'e', 'e', '&Eacute;', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('&iacute;', 'i', 'i', 'i', '&Iacute;', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('&oacute;', 'o', 'o', 'o', '&Oacute;', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('&uacute;', 'u', 'u', 'u', '&Uacute;', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('&ntilde;', '&Ntilde;', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    
		return $string;
}
function valida($rol) {
	//session_start();
	include ("conexion.php");
	$login=$_SESSION["login"];
	$tipo=$_SESSION["tipo"];
	$sql = "SELECT * FROM roles WHERE login_usr='$login'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	$lectura=substr($row[$rol],0,1);
	if ($lectura=="r"){
		return "ok";
	}
	else {
		return "bad";
	}	
}

function valida_pass($pass) {
	for($i=1;$i<strlen($pass);$i++){
		if (substr($pass,0,1)!= substr($pass,$i,1))	
			return "true";
	}
	return "false";
}
function secuencial($password) {
	//strrev -- Invierte una cadena
	//ord -- Devuelve el valor ASCII de un caracter

	$password=strtoupper($password);
	$long=strlen($password);

	for ($i=0; $i<strlen($password); $i++)
	{
		$tmp[$i]=ord(substr($password, $i, 1));
	}

	$count = array();
	$tmp2 = 0;
	for ($i = 0; $i <= sizeof($tmp)-1; $i++){
		$j = $i+1;
		if ($tmp[$i]==$tmp[$j]-1) {
			$tmp2++;
		}
		else {
			$count[]=$tmp2;
			$tmp2=0;
		}
	}
	arsort($count);
	reset($count);
	$i=key($count);
	$i=$count[$i];
	return $i;
}

// Verifica si existe loguin's repetidos
function VerificaLoguin($login_usr){
	require ('conexion.php');
	$w = 0;
	$sql = "SELECT login_usr FROM users";
	$res = mysql_query($sql);
	while ( $fila = mysql_fetch_row($res) )
	{	if( $login_usr == $fila[0] ) $sw = 1; }				
	return $sw;
}

// Cuenta el numero de password repetidos
function NroPasswordRepetidos($password_usr){
	require ('conexion.php');
	$c = 0;	
	$sql = "SELECT login_usr, password_usr FROM users";
	$res = mysql_db_query($db, $sql, $link);
	while ( $fila = mysql_fetch_row($res) ){
		if ( $password_usr == $fila[1] ) $c ++;
	}
	return $c;	
}
//_________________________________________________________
// FUNCIONES DE SEGURIDAD, SQL INJECTION y XSS.
// Version: 1.0
// Autor:   Cesar Cuenca
// Fecha:   15/DIC/2012
//_________________________________________________________
function _clean($str){
	//return is_array($str) ? array_map('_clean', $str) : str_replace('\\', '\\\\', htmlspecialchars((get_magic_quotes_gpc() ? stripslashes($str) : $str), ENT_QUOTES));
	return($str);
}

function SanitizeString($str){
    //return filter_var($str, FILTER_SANITIZE_STRIPPED); 
	return($str);
}

function ValidateString($str){
    return preg_match('/^[A-Za-z\s ]+$/', $str);
}

function estado_orden($id_orden){
	$sql="SELECT id_orden FROM ordenes WHERE id_orden='$id_orden' LIMIT 1";
	if (mysql_num_rows(mysql_query($sql))==0){
		return -1; // Orden inexistente
		exit(0);
	}
	else {
		$sql="SELECT id_orden FROM conformidad WHERE id_orden='$id_orden' AND tipo_conf=1";
		if (mysql_num_rows(mysql_query($sql))!=0){
			return 3; // Orden con CONFORMIDAD
			exit(0);
		}
		else {
			$sql="SELECT id_orden FROM solucion WHERE id_orden='$id_orden'";
			if (mysql_num_rows(mysql_query($sql))!=0){
				return 2; // Orden con SOLUCION
				exit(0);
			}
			else{
				$sql="SELECT id_orden FROM asignacion WHERE id_orden='$id_orden'";
				if (mysql_num_rows(mysql_query($sql))==0){
					return 1; // Orden ASIGNADA
					exit(0);
				}
			}
		}
	}
}
?>