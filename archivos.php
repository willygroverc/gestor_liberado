<?php 
include ( "conexion.php" );

$sql5 = "SELECT * FROM control_parametros";
$res5 = mysql_db_query($db,$sql5,$link);
$row5 = mysql_fetch_array($res5);
$tam_max = 1048576*$row5['tam_archivo_f'];
if (isset($retornar)){header("location: lista_archivos.php");}
if ( isset($guardar))
{   session_start();
	$login = $_SESSION["login"];
	include ( "funciones.inc.php" );	
    $sql03 = "SELECT * FROM users WHERE login_usr='$login'";
    $result03 = mysql_db_query($db,$sql03,$link);
    $row03 = mysql_fetch_array($result03);
    $nombre_usr = $row03['nom_usr']." ".$row03['apa_usr']." ".$row03['ama_usr'];
	$path = $_SESSION["path"];
	$nom_mod = XCampoc($modulo,"modulo","id_mod","nombre_mod",$link);
	$dir = $path."/".$nom_mod."/".$archivo_name;
	$op = ArchivoExistente($archivo_name, $path."/".$nom_mod);	
	if ( $op == 1 )
		$msg = "No se puede guardar el archivo porque ya existe en este Modulo";
	else				
	{	if ( strlen($archivo_name) > 100 ) $msg = "El nombre del archivo debe ser menor a 100 caracteres";	
		else
		{	if ( $archivo_size < $tam_max )
				if ($ubicacion == "repositorio")
					if (copy($archivo,$dir))	
					{	$hash_cont = md5_file($dir);
						$file = $archivo_name; 
						$separar = explode('.',$file);
						$ext = $separar[1];
						if($ext!='php') {
						$sql = "INSERT INTO datos_archivos (nombre_arch, id_mod, fecha_rev, fecha_creado, estado, login_creador, hash_archi) ".
								"VALUES('$archivo_name','$modulo','".date("Y-m-d")."','".date("Y-m-d")."',0,'$login', '$hash_cont')"; 	
						
						$res = mysql_db_query($db, $sql, $link);
						 
					    $sql04="SELECT * FROM modulo WHERE id_mod='$modulo'";  //HERE
					    $result04=mysql_db_query($db,$sql04,$link);
					    $row04 = mysql_fetch_array($result04);
						$sql0  = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
				   	            "VALUES ('".date("Y-m-d")."','".date("H:i:s")."','creacion_archivo','$nombre_usr','$row04[nombre_mod]','$archivo_name')";
						$rst0  = mysql_db_query($db,$sql0,$link);
						$sql02 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
				   	            "VALUES ('".date("Y-m-d")."','".date("H:i:s")."','repositorio','$nombre_usr','$row04[nombre_mod]','$archivo_name')";
						$rst02 = mysql_db_query($db,$sql02,$link);
						$msg2  = "El archivo se ha guardado con exito";	
						} else { $msg2  = "El archivo no es permitido";	}
					}
					else $msg2 = "copy($archivo,$dir)";						
				else
				{	if (copy($archivo,$dir))
					{	$hash_cont = md5_file($dir);	
						$sql = "INSERT INTO datos_archivos (nombre_arch, id_mod, fecha_rev, fecha_creado, estado, login_creador, hash_archi) ".
							   "VALUES('$archivo_name','$modulo','".date("Y-m-d")."','".date("Y-m-d")."',1,'$login', '$hash_cont')"; 						
						$res  = mysql_db_query($db, $sql, $link);
				    	$id_arch = ObtieneCodigo($db,$link,'datos_archivos','id_arch');
					    $sql05="SELECT * FROM modulo WHERE id_mod='$modulo'"; //HERE
					    $result05=mysql_db_query($db,$sql05,$link);
					    $row05=mysql_fetch_array($result05);
						$sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
				   	            "VALUES ('".date("Y-m-d")."','".date("H:i:s")."','creacion_archivo','$nombre_usr','$row05[nombre_mod]','$archivo_name')";
						$rst0 = mysql_db_query($db,$sql0,$link);
						$sql2 = "INSERT INTO control_archivos (id_arch, ubicacion, descargado, fecha_b, login_b) ".
								"VALUES('$id_arch','b',1,'".date("Y-m-d")."','$login')"; 
						$res2 = mysql_db_query($db, $sql2, $link);
						$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
				   	            "VALUES ('".date("Y-m-d")."','".date("H:i:s")."','replica','$nombre_usr','$row05[nombre_mod]','$archivo_name')";
						$rst01 = mysql_db_query($db,$sql01,$link);
						$msg2 = "El archivo se ha guardado con exito";
						$path_replica = $_SESSION["path_replica"];
						$dir = $path_replica."/".$nom_mod."/".$archivo_name;
						copy($archivo,$dir);
					}
					else $msg2 = "La ruta especificada no es correcta";	
				}
			else $msg="El tamano del archivo no debe ser mayor a ".$row5['tam_archivo_f']." Mb";																								
			}
		}
}	

include("top.php");
?>

<html>
<body>
<form name="form1" method="post" enctype="multipart/form-data" action="<?php echo $PHP_SELF?>" >
<br>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg" >
  <tr>
	<td background="images/main-button-tileR2.jpg" height="30" align="center">
		<font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>
	    NUEVO ARCHIVO</strong>
		</font>
	 </td>
   </tr>
   <tr>		 
    <td> 
      <table width="93%" align="center">  
		  <tr><td align="right" height="30">
		  <strong>Fecha:<?php echo date("d/m/Y");?>&nbsp;&nbsp;HORA : </strong><?php echo date("H:i:s");?><br>&nbsp;<br>&nbsp;
          </td>
          </tr>					
			<tr><td height="40">
			<font size="2" face="ARIAL, Helvetica, sans-serif"><b>Archivo:&nbsp;&nbsp;&nbsp;</b></font>
			<input name="archivo" id="" type="file" size="60" value="<?php echo $archivo; ?>">
			<font size="2" face="ARIAL"><center>(tamano maximo permitido <?php echo $row5['tam_archivo_f'];?> Mb.)</center></font>
			</td></tr>
			<tr>
            <td height="40"> <font size="2" face="ARIAL, Helvetica, sans-serif"><B>Modulo:&nbsp;&nbsp;&nbsp;</B></font> 
              <select name="modulo" >                
				<?php
					$sql = "SELECT id_mod, nombre_mod FROM modulo WHERE estado<>1";					
					$res = mysql_db_query ( $db, $sql, $link);					
					while ($fil = mysql_fetch_array( $res ) )
					{	if ($fil['id_mod'] == $modulo)
						echo "<option value='$fil[id_mod]' selected>".$fil['nombre_mod']."</option>";
						else
						echo "<option value='$fil[id_mod]'>".$fil['nombre_mod']."</option>";  
					}				
				?>
              </select> 
			</td>
          </tr>
			<tr><td height="40">
				<table width="335">
                <tr>
					<td height="40">
						<font size="2" face="ARIAL"><B>Ubicacion:</B></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;					
						<font size="1" face="ARIAL">REPOSITORIO</font>
						<input type="radio" name="ubicacion"  value="repositorio" checked> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<font size="1" face="ARIAL">REPLICA</font>
						<input type="radio" name="ubicacion" value="replica">									
					</td>
				</tr>					
				</table><BR>
			</td></tr>			
		</table>	
	</td>
   </tr>
</table>
  <table width="311" align="center">
    <tr>
      <td height="40" align="center"> 
	  	<BR>&nbsp;
	 	<input type="submit" name="guardar" value="GUARDAR" onClick="return ValidaArchivo()">
         &nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;		 
        <input type="submit" name="retornar" value="RETORNAR">
	 <td>
    </tr>						
</table>
</form>
<?php include("top_.php");?>
<script language="JavaScript">
<?php
	print "function msgFile () {\n
			alert (\"Atencion, solamente puede enviar archivos menor o igual a $row5[tam_archivo] Mb de tamano.\\n \\nMensaje generado por GesTor F1.\");\n
	}\n";

 if ($msg) 
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\tMensaje generado por GesTor F1.\");\n";		
	} 
	if ($msg2) 
   	{	print "var msg2=\"$msg2\";\n";
		print "alert ( msg2 + \"\\n \\nMensaje generado por GesTor F1.\");\n";		
	} 	
?>	
	function ValidaArchivo ()
	{				
		var form=document.form1;
		if (form.archivo.value == "")
		{	alert ("Archivo no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		if (form.modulo.value == "")
		{	alert ("Modulo no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		return true;
	}		
</script>
</body>
</html>