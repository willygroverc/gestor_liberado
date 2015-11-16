<?php 
session_start();
require_once("funciones.php");
include ("conexion.php");
//$dir = $_SESSION["path_backup_db
$path_backup_db = "c:/backup";
$dir = $path_backup_db;
$msg='';
if (valida("PistasAudi")=="bad") {header("location: pagina_error.php");}
if (isset($_REQUEST['RETORNAR'])){header("location: seguridad_opt.php?Naveg=Seguridad");}
include("top.php");
if (isset($_REQUEST['copia']))
{	include ("conexion.php");
	unset($salida);
	unset($error);
	$fecha_hoy = date("d-m-Y");	
	$hora_hoy = date("H-i-s");
	$nombre = "copia_".$fecha_hoy."_".$hora_hoy.".sql";
	$path_copia = $dir."/".$nombre;
        //produccion
	//exec("c:/mysql/bin/mysqldump.exe -u $user --password=$pass -c $db > $path_copia ", $salida, $error);
	//desarrollo
        exec("C:/xampp/mysql/bin/mysqldump.exe -u $user --password=$pass -c $db > $path_copia ", $salida, $error);

        if(isset($_REQUEST['zip'])=="ok"){
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
	if (!$error)
	$msg = "El backup se realizo con exito en:\\n\\n".$path_copia. "\\n\\n\\nMensaje generado por GesTor F1.";
	else
	$msg = "El backup NO se realizo:\\n".$path_copia."\\n\\nMensaje generado por GesTor F1.";
}
?>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
<TABLE WIDTH="50%" BORDER="2" align="center" CELLPADDING="0" CELLSPACING="2" background="images/fondo.jpg">
    <TR align="center"> 
        <th>BACKUP DE LA BASE DE DATOS</th>
	</TR>
	<TR align="center">
		<td> 
		  <p>ESTA OPERACION IMPLICA PARAR LA  BASE DE DATOS Y <BR>
		  PUEDE DEMORAR ALGUNOS SEGUNDOS REALIZARLA.<BR>
		  EL ARCHIVO DE COPIA GENERADO ESTA ALMACENADO EN:<BR>
          <font color="#003366">"<?php echo $dir;?>/copia_dd-mm-yyyy_hh-mm-ss.sql"</font> </p>
		  <p>Guardar como archivo Zippeado 
		    <input name="zip" type="checkbox" id="zip" value="ok">
		  </p>
	  <td>
	</TR>
	<tr>		
</TABLE>
  <div align="center"><br>
      <strong><font color="#FF0000"><?php echo $msg; ?></font></strong>
    <center>

    <input name="copia" type="submit" value="CREAR BACKUP">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="RETORNAR" value="RETORNAR">
  </div>
</form>
</center>
<div align="center">
  <script language="JavaScript">
<?php if($msg) print "alert(\"$msg\");";?>
</script>
  <?php
include("top_.php");
?>
</div>
