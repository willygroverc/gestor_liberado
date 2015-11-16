<?php
// Version: 	1.0 
// Objetivo:	Verificar si codigo introducido corresponde a imagen captcha
// Fecha:		19/NOV/12
// Autor:		Cesar Cuenca
//__________________________________________________________________________

function rpHash($value) {
	$hash = 5381;
	$value = strtoupper($value);
	for($i = 0; $i < strlen($value); $i++) {
		$hash = (($hash << 5) + $hash) + ord(substr($value, $i));
	}
	return $hash;
}
if (rpHash($_POST['defaultReal']) == $_POST['defaultRealHash'])
	echo 0; // CORRECTO
else
	echo -1;
?>
