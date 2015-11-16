<?php
require('../conexion.php');
@session_start();
function notificar_orden($asunto, $mensaje){
	require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer 
	$mail = new PHPMailer(); 
 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
	$mail->Username = "gestorf1@yanapti.com"; // Cuenta de e-mail 
	$mail->Password = '$Gertor%%2015$'; // Password 
 
	$mail->Host = "mail.yanapti.com"; 
	$mail->From = "noreply@gestorF1.com"; 
	$mail->FromName = "Gestor F1"; 
	$mail->Subject = $asunto;
	
	$sql_mails="SELECT login_usr, email FROM users WHERE tipo2_usr='A' AND adicional1='".$_SESSION['agencia']."' AND bloquear<>2 AND email<>''";
	$recordset_mails=mysql_query($sql_mails);
	for ($i=1;$i<=mysql_num_rows($recordset_mails);$i++){
		$fila_mails=mysql_fetch_array($recordset_mails);
		$mail->AddAddress($fila_mails['email'],$fila_mails['login_usr']); 
	}
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
 
	$mail->Body = $body; 
	$mail->IsHTML(true); 
	if(!$mail->Send()){ 
		echo false; // No se pudo enviar el Mensaje. 
	}else{ 
		return true; // Mensaje enviado 
	} 
}
function notificar_smtp($asunto, $mensaje, $emails){
	require("class.phpmailer.php"); //Importamos la función PHP class.phpmailer 
	$mail = new PHPMailer(); 
 
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; // True para que verifique autentificación de la cuenta 
	$mail->Username = "gestorf1@yanapti.com"; // Cuenta de e-mail 
	$mail->Password = '$yAnApt1$'; // Password 
 
	$mail->Host = "mail.yanapti.com"; 
	$mail->From = "noreply@gestorF1.com"; 
	$mail->FromName = "Gestor F1"; 
	$mail->Subject = $asunto;
	for ($j=0;$j<=count($emails)-1;$j++){
		$mail->AddAddress($emails[$j][0],$emails[$j][1]);
	}
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
 
	$mail->Body = $body; 
	$mail->IsHTML(true); 
	if(!$mail->Send()){ 
		echo false; // No se pudo enviar el Mensaje. 
	}else{ 
		return true; // Mensaje enviado 
	} 
}
?>