<?php
//enviar correos
/*
$correos=array();
array_push($correos);
$mensaje="prueba de recordatorio";
$asunto = "Gestor F1 - Recordatorio";
enviar($correos,$asunto,$mensaje);*/
function enviar($correos,$asunto,$mensaje){
	$i=0;
	for($i=1;$i < count($correos);$i++){
//	echo $correos[$i]."----------".$asunto."--------".$mensaje[$i];
		if (mail($correos[$i], $asunto, $mensaje[$i])) {
		  echo("<p>Message successfully sent!</p>");
		 } else {
		  echo("<p>Message delivery failed...</p>".$correos[$i]."----------".$asunto."--------".$mensaje[$i]);
		 }
	}
/*	foreach($correos as $email){
		if (mail($email, $asunto, $mensaje)) {
		  echo("<p>Message successfully sent!</p>");
		 } else {
		  echo("<p>Message delivery failed....</p>");
		 }
	}*/
}
?>