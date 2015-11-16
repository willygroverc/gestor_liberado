<?php
//enviar correos

$correos=array();
array_push(gestorF1@yanapti.com);
$mensaje="prueba de recordatorio";
$asunto = "Gestor F1 - Recordatorio";
enviar($correos,$asunto,$mensaje);
function enviar($correos,$asunto,$mensaje){
	foreach($correos as $email){
	if (mail($email, $asunto, $mensaje)) {
		  echo("<p>Message successfully sent!</p>");
		 } else {
		  echo("<p>Message delivery failed....</p>");
		 }
	}
}
?>