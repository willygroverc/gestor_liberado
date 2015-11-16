<?php
/*$host="localhost";
$user="fubrecti";
$pass="osicmi2004";
$db="fubrecti_ordsssentrabajo";
$link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
    $sql1 = "BACKUP TABLE pistas_fuentes TO '/proyecto/pistas/' ";
	if (mysql_db_query($db,$sql1,$link))
		echo "Bien ...!";
	else
		echo "Error ..";*/

//COPIA LOS ARCHIVOS DE UN DIRECTORIO A OTRO CON LA OPCION DE ELIMNAR O NO

session_start();	
$path = $_SESSION["path_backup"];

function CopiaDir($dir, $dir_copia, $eliminar) 
{ 	
	$sw = 0;
	$dh = opendir($dir);	
	
	while ($file = readdir($dh)) 
	{   
		if($file != "." && $file != "..")
		{   $path_com = $dir."/".$file;
			if(!is_dir($path_com)) 
			{	copy( $path_com, $dir_copia."/".$file );
				if ( $eliminar == "1")
				{ unlink($path_com); }	
			}
			else 
			{	$dir_copia_c = $dir_copia."/".$file;								
				mkdir ( $dir_copia_c, 0777 );
				CopiaDir($path_com, $dir_copia_c, $eliminar);
				$sw = 1; 
			}
		}		
	}
	closedir($dh);		
	if ( $eliminar == "1" && $sw != 1 )
	{ rmdir($dir); }	
}		
if ( isset($COPIAR) )
{	$path1 = "c:/apache/htdocs/desarrollo_fuentes/proyecto";
	$path2 = "c:/apache/htdocs/desarrollo_fuentes/tmp";
	//CopiaDir($path1, $path2, 0);
	$msg = "La copia se realizo on exito";
}
	$dir = "c:/apache/htdocs/desarrollo_fuentes/proyecto";
	$dh = opendir($dir);	
	
	while ($file = readdir($dh)) 
	{	if($file != "." && $file != "..")
		{   $path_com = $dir."/".$file;
			if(!is_dir($path_com)) 
			{	//copy( $path_com, $dir_copia."/".$file );
				echo "<br>arhivo".$path_com;
			}
			else 
			{	$dir_copia_c = $dir_copia."/".$file;								
				echo "<br>directorio".$dir_copia_c;
				$sql = "INSERT EN TO  ";
				//mkdir ( $dir_copia_c, 0777 );
			}
		}		
	}
	closedir($dh);		
?>	
<FORM name="frm1" method="post" action="prueba.php">&nbsp;	
PATH ORIGEN:<input name="path1" type="text" size="75"><br>
PATH DESTINO:<input name="path2" type="text" readonly="yes" value="<?php echo $path; ?>" size="75">
<input type="submit" value="Copiar" name="COPIAR" >
</form>

<script language="JavaScript">
<?php
 if ($msg) 
 {	print "var msg=\"$msg\";\n";
	print "alert ( msg + \"\\n \\n\Mensaje generado por GesTor F1.\");\n";		
 } 	
?>
</script>
