<?php
//definimos el path de acceso
$path = "c:/tmp";

//abrimos el directorio
$dir = opendir($path);

//Mostramos las informaciones
while ($elemento = readdir($dir))
{ 
   echo $elemento."<br>";
}


if (mkdir("/tmp/repositorio", 0777))
	echo " Se creo con exito!!!";
else
	echo "Error .....";

	
//mkdir("/tmp/repositorio", 0777)	
mkdir("", 0666);
closedir($dir); 
?>
 

