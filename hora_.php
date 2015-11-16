<?php
	$fecha_hoy = date("d-m-Y");	
	$hora_hoy = date("H-i-s");
	$nombre = "copia_".$fecha_hoy."_".$hora_hoy.".sql";
	$path_copia = $dir."/".$nombre;
	exec("c:/mysql/bin/mysqldump -u $user --password=$pass -c $db > $path_copia ", $salida, $error);
	if($zip=="ok"){
		   $filenameIMAG=$path_copia; 
		   $filenameCOMP=$dir.'/'.$nombre.'.gz'; 
		   $fp = fopen($filenameIMAG, "rb"); 
		   $data = fread($fp, filesize($filenameIMAG)); 
		   fclose($fp); 
		   $fd = fopen ($filenameCOMP, "wb"); 
		   $gzdata = gzencode($data,9); 
		   fwrite($fd, $gzdata); 
		   fclose($fd); 
		  }

?>
