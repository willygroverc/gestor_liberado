<?php
// Autor 	:	Cesar Cuenca
// Objetivo	:	Optimizacion de consultas e insercion de registros, funciones absoletas para php 5.3
//				Validaciones de Seguridad datos y ficheros.
//				Implementacion de php_mailer para envio de mails, parametrizacion de envio de emails.
//				
// Fecha	:   27/FEB/2013	
//_________________________________________________________________________________________________			
require ('../funciones.php');
require ('../conexion.php');
require ('../lib/mailer.php');
//session_start();
$desc_inc=trim($_POST['desc']);
$area=$_POST['a'];
$dominio=$_POST['d'];
$objetivo=$_POST['o'];
$observaciones=$_POST['obs'];
$archivo= $_REQUEST['file'];
function ObtenerNavegador($user_agent) {
     $navegadores = array(
          'Opera' => 'Opera',
          'Firefox'=> '(Firebird)|(Firefox)',
          'Galeon' => 'Galeon',
          'Mozilla'=>'Gecko',
          'MyIE'=>'MyIE',
          'Lynx' => 'Lynx',
          'Netscape' => '(Mozilla/4\.75)|(Netscape6)|(Mozilla/4\.08)|(Mozilla/4\.5)|(Mozilla/4\.6)|(Mozilla/4\.79)',
          'Konqueror'=>'Konqueror',
          'ie9' => '(MSIE 9\.[0-9]+)',
          'ie8' => '(MSIE 8\.[0-9]+)',
          'ie7' => '(MSIE 7\.[0-9]+)',
          'ie6' => '(MSIE 6\.[0-9]+)',
          'ie5' => '(MSIE 5\.[0-9]+)',
          'ie4' => '(MSIE 4\.[0-9]+)',
);
foreach($navegadores as $navegador=>$pattern){
       if (eregi($pattern, $user_agent))
       return $navegador;
    }
return 'Desconocido';
}
$vld=ObtenerNavegador($_SERVER['HTTP_USER_AGENT']);
if($vld!='Firefox')
	$file= str_replace($file[0].$file[1].$file[2].$file[3].$file[4].$file[5].$file[6].$file[7].$file[8].$file[9].$file[10].$file[11], '' , $file);


$desc_inc=_clean($desc_inc);
$area=_clean($area);
$dominio=_clean($dominio);
$objetivo=_clean($objetivo);
$archivo=_clean($archivo);
$desc_inc=SanitizeString($desc_inc);
$area=SanitizeString($area);
$dominio=SanitizeString($dominio);
$objetivo=SanitizeString($objetivo);

$desc_inc=normaliza($desc_inc);
$area=normaliza($area);
$dominio=normaliza($dominio);
$objetivo=normaliza($objetivo);

if (strlen($desc_inc)<=10) {
	echo -1;
}
else{
	$login=$_SESSION["login"];
	$nombre=$_SESSION["nombre"];

	$sql="SELECT tmp_conf, cant_ordenes FROM control_parametros";
	$recordset=mysql_query($sql);
	$fila=mysql_fetch_array($recordset);
	$dias_permitidos=$fila['tmp_conf'];  // dias permitidos sin conformidad en ordenes de trabajo registradas.
	$ordenes_permitidas=$fila['cant_ordenes'];

	//$sql = "SELECT fecha_conf FROM conformidad WHERE reg_conf='$login'";
	$sql = "SELECT o.fecha as fecha_orden, s.fecha_sol , c.reg_conf, now()
			FROM ordenes o 
			INNER JOIN solucion s ON o.id_orden=s.id_orden 
			LEFT JOIN conformidad c ON o.id_orden=c.id_orden
			WHERE o.cod_usr='$login' AND c.reg_conf IS NULL AND (DATEDIFF(now(),s.fecha_sol)>$dias_permitidos)";

	$recordset = mysql_query($sql);
	$num_ordenes=mysql_num_rows($recordset);
	$sw=0;
	if ($num_ordenes>0){
		$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene una orden que en ".$dias_permitidos." dias no recibio conformidad ";
		$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc) ".
		"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
		
		mysql_query($sql);
		$sw=1;
		echo -2;
	}
	if ($num_ordenes>$ordenes_permitidas){	
		$desc="El usuario ".$nombre." no puede insertar mas ordenes de trabajo, debido a que tiene ".$num_ordenes." ordenes de trabajo sin conformidad ";
		$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc) ".
		"VALUES('".date("Y-m-d")."','".date("H:i:s")."','SISTEMA','$desc')"; 
		mysql_query($sql);
		//$msg="USTED NO PUEDE INSERTAR MAS ORDENES DE TRABAJO, DEBIDO A QUE EXCEDIO EN ".$row5['cant_ordenes']."\\nORDENES SIN CONFORMIDAD";
		$sw=1;
		echo -3;
	}

	if ($sw==0){
		$adjuntos_bo='';
		$adjuntos_bo_hash='';
		$adjuntos_bo_obs='';
		$ci_ruc='';
		$sql="INSERT INTO ordenes (fecha, time, cod_usr, desc_inc,ci_ruc,origen, nomb_archivo, hash_archivo,observaciones, area, dominio, objetivo) ".
			"VALUES('".date("Y-m-d")."','".date("H:i:s")."','".$login."','$desc_inc','$ci_ruc','0','".$_REQUEST[file]."','".$adjuntos_bo_hash."','".$observaciones."','$area','$dominio','$objetivo')"; 
                //print_r($sql);exit;
                //if($objetivo<>'0'){//si el objetivo es diferente de general
                    //asigna automaticamente
               // }
		if (mysql_query($sql)){
			$id_aux=mysql_insert_id();
			$asunto='Registro Orden de Trabajo Nro. '.$id_aux;
			$mensaje='<table border="1">
						<thead>
							<tr>
								<th colspan="2"><font size="3">NUEVA ORDEN DE TRABAJO REGISTRADA NRO. '.$id_aux.'</font></th>
							</tr>
						</thead>
							<tr>
								<td>Registrado por:</td><td>'.$login.'</td>
							</tr>
							<tr>
								<td>IP origen:</td><td>'.$_SESSION['ip'].'</td>
							</tr>			
							<tr>	
								<td>Fecha/Hora registro:</td><td>'.date("Y-m-d").' '.date("H:i:s").'</td>
							</tr>
							<tr>
								<td>Incidencia:</td><td>'.$desc_inc.'</td>
							</tr>	
							<tr>	
								<td colspan="2" align="center"><font size="3"><strong>Tipificaci&oacute;n</strong></font></td>
							</tr>';
							$sql="SELECT area_nombre FROM area WHERE area_cod='$area'";
							$recordset=mysql_query($sql);
							$fila=mysql_fetch_array($recordset);
							if ($fila['area_nombre']=='')
								$area_desc='General';
							else
								$area_desc=$fila['area_nombre'];
			$mensaje.=		'<tr>	
								<td>Nivel1:</td><td>'.$area_desc.'</td>
							</tr>';
							$sql="SELECT dominio FROM dominio WHERE id_dominio='$dominio'";
							$recordset=mysql_query($sql);
							$fila=mysql_fetch_array($recordset);
							if ($fila['dominio']=='')
								$dominio_desc='General';
							else
								$dominio_desc=$fila['dominio'];
			$mensaje.=		'<tr>
								<td>Nivel2:</td><td>'.$dominio_desc.'</td>
							</tr>';
							$sql="SELECT objetivo FROM objetivos WHERE id_objetivo='$objetivo'";
							$recordset=mysql_query($sql);
							$fila=mysql_fetch_array($recordset);
							if ($fila['objetivo']=='')
								$objetivo_desc='General';
							else
								$objetivo_desc=$fila['objetivo'];
			$mensaje.=		'<tr>
								<td>Nivel3:</td><td>'.$objetivo_desc.'</td>
							</tr>
						</table>';
			//&if (notificar_orden($asunto, $mensaje)==true) //enviar correo
				echo $id_aux; // orden registrada y enviada por SMTP
			/*else
				echo (-5).'|'.$id_aux.'|';*/ // orden insertada pero error al enviar por SMTP
		}
		else
			echo -4; // Error en la insercion.
	}	
}
?>