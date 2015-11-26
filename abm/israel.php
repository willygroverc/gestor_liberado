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
//require ('../lib/mailer.php');
require ('../lib/class.phpmailer.php');

//$id_aux=mysql_insert_id();
                    
                    /*//obtener el ultimo id ingresado en ordenes
                    $qryt1='SELECT MAX(id_orden) as idorden FROM ordenes';
					echo $qryt1;
                    $resultt1=mysql_query($qryt1)or die($qryt1. "<br/><br/>".mysql_error());//EJECUTO LA CONSULTA
                    $rowt1 = mysql_fetch_assoc($resultt1);
                    //obtener el registro de la orden selecionada
                    $qryt2='SELECT * FROM ordenes WHERE id_orden='.$rowt1['idorden'];
					echo($qryt2);
                    $resultt2=mysql_query($qryt2)or die($qryt2. "<br/><br/>".mysql_error());//EJECUTO LA CONSULTA
                    $rowt2 = mysql_fetch_assoc($resultt2);
					echo'<br>';
					echo $rowt2['objetivo'];
					//verificar que  el campo objetivo sea diferenre de 0 o general
                    if ($rowt2['objetivo']<>0) {
                    //verificar si el objetivo tiene resposanbles asignados
                    $qryt3='SELECT * FROM objetivos WHERE id_objetivo='.$rowt2['objetivo'];
                    echo($qryt3);
					$resultt3=mysql_query($qryt3)or die($qryt3. "<br/><br/>".mysql_error());//EJECUTO LA CONSULTA
                    $rowt3 = mysql_fetch_assoc($resultt3);
					echo'<br>';
					echo $rowt3['resp1'];
					
                    if ($rowt3['resp1']<>null) {
                        $fecha=  date('Y-m-d');
                        $dia=$rowt3['tiempo1'];
                        $nuevafecha = strtotime ( '+'.$dia.' day' , strtotime ($fecha ) ) ;
                        $nuevafecha = date ( 'Y-m-d' , $nuevafecha ); 
                    //se hace el insert a la tabla asignacion     
                        $sqltip="INSERT INTO asignacion (id_asig, id_orden, nivel_asig, criticidad_asig, prioridad_asig, asig, fecha_asig, hora_asig, fechaestsol_asig, reg_asig, diagnos, escal, fechasol_esc, area, area_1,automatico,resp1)
                        VALUES(null, $rowt2[id_orden], 2, 2, 2, '".$rowt3['resp1']."', '".date('Y-m-d')."', '".date('H:i:s')."', '".$nuevafecha."',  '$login', 'Tipificacion automatica', '', '', 'Mesa', 'false|false|false','1','1')";
                        echo($sqltip);
						$resulttip=mysql_query($sqltip)or die($sqltip. "<br/><br/>".mysql_error());
                        
                    $qry3="SELECT email FROM users WHERE login_usr='".$rowt3['resp1']."'";
                    echo($qry3);
					$result3=mysql_query($qry3)or die($qry3. "<br/><br/>".mysql_error());//EJECUTO LA CONSULTA
                    $row3 = mysql_fetch_assoc($result3);
					}
					}*/
					echo $asunto='Registro Orden de Trabajo Nro. ';
					echo $mensaje='hola mundo';
					echo $emails='ialvarez@yanapti.com';
					
					$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
    
	//$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 

	//$mail->Host = 'tredia.websitewelcome.com';  // Specify main and backup SMTP servers
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	//$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
	$mail->Username = "ycert2015@gmail.com"; // Cuenta de e-mail 
	$mail->Password = 'Cp3RKHdRUPxbfDqN669Z'; // Password 
	//$mail->Username = "gestorf1@yanapti.com"; // Cuenta de e-mail 
	//$mail->Password = '$Gertor%%2015$'; // Password */
    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 25;     
    $mail->SMTPDebug  = 1;

	$mail->From = "noreply@gestorF1.com"; 
	$mail->FromName = "Gestor F1"; 
	$mail->Subject = $asunto;
	$mail->AddAddress($emails);	
	$mail->WordWrap = 50; 
	$body='<style>
	table, th, td {	border: 1px solid #D4E0EE;	border-collapse: collapse; font-family: "Trebuchet MS", Arial, sans-serif; color: #555;}
	caption {font-size: 150%;font-weight: bold;margin: 5px;}
	td, th {padding: 4px;}
	thead th { text-align: center;	background: #E6EDF5; color: #4F76A3; font-size: 100% !important;}
	tbody th { font-weight: bold;}
	tbody tr { background: #FCFDFE; }
	tbody tr.odd { background: #F7F9FC; }
	table a:link { color: #718ABE; text-decoration: none;}
	table a:visited {color: #718ABE;text-decoration: none;}
	table a:hover { color: #718ABE;	text-decoration: underline !important;}
	tfoot th, tfoot td { font-size: 85%;}
	</style>';
	$body.=$mensaje;
	$body .= '<font color="red">Este mensaje ha sido generado automaticamente por GestorF1.</font>';
	echo $body;
	$mail->Body = $body; 
	$mail->IsHTML(true); 
	if(!$mail->Send()){ 
		echo false; // No se pudo enviar el Mensaje. 
	}else{ 
		return true; // Mensaje enviado 
	} 
					
?>