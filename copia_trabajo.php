<?php 
session_start();
$login = $_SESSION["login"];
if ($retornar){header("location: lista_carpetas.php?id=$id");}
if ($retornar2){header("location: lista_carpetas.php?id=$id");}
include("conexion.php");
$sql02 = "SELECT * FROM users WHERE login_usr='$login'";
$result02 = mysql_db_query($db,$sql02,$link);
$row02 = mysql_fetch_array($result02);
$nombre_usr=$row02[nom_usr]." ".$row02[apa_usr]." ".$row02[ama_usr];
include("top.php");
include("funciones.inc.php");
$sql = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
$res = mysql_db_query($db,$sql,$link);
$row = mysql_fetch_array($res);
if (isset($enviar))
{	$nom_mod = XCampoc($id_mod,"modulo","id_mod","nombre_mod",$link);
	$path_replica=$_SESSION["path_replica"];
	$sql = "SELECT * FROM control_archivos WHERE ubicacion='c' AND login_b='$login' AND descargado=0";
	$res = mysql_db_query($db,$sql,$link); 
	while ( $fila = mysql_fetch_array($res))
	{	$nom_arch = XCampoc($fila['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);			
		$id_modu  = XCampoc($fila['id_arch'],"datos_archivos","id_arch","id_mod",$link);
		if ( $id_mod == $id_modu)
		{	
			if ($archivo_name==$nom_arch)
			{ 	$sw = 1;
				$id_control = $fila['id_control'];
				$id_arch = $fila['id_arch'];
				$sqli = "SELECT * FROM datos_archivos WHERE id_arch='$id_arch'";
				$resi = mysql_db_query($db,$sqli,$link); 
				$filai = mysql_fetch_array($resi);
				$nombre_arch = $filai[nombre_arch];
				$sql2 = "UPDATE control_archivos SET descargado=1 WHERE id_control='$fila[id_control]'";
				$result2 = mysql_db_query($db,$sql2,$link);				
			}			
		}	
	}
	if ($sw == 1)	
	{	$fecha_hoy = date("Y-m-d");
		$dir = $path_replica."/".$nom_mod."/".$archivo_name;
		copy($archivo,$dir);
		$hash_cont = md5_file($dir);
		$sql="UPDATE control_archivos SET ubicacion='b', fecha_b='$fecha_hoy', comentario='$coment_b', hash_archi='$hash_cont' WHERE id_control='$id_control'";
		$result=mysql_db_query($db,$sql,$link);
		$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
	   	         "VALUES ('$fecha_hoy','".date("H:i:s")."','replica','$nombre_usr','$row[nombre_mod]','$nombre_arch')";
		$rst01 = mysql_db_query($db,$sql01,$link);
		$msg2 = "El archivo se ha enviado con exito";						
	}
	else 
	{	$msg = "El nombre del archivo que desea subir no coincide con ninguno de la lista de archivos disponibles";
		//exit;
	}
}
?>
<HTML>
<BODY>	 
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="60%" align="center" background="images/fondo.jpg" border="1">
	<tr bgcolor="#006699"> 
		<td align="center"><?php echo "<A HREF=\"copia_trabajo.php?id_mod=$id_mod&id=$id&op=1\">"; ?>
		<font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">
		DESCARGAR ARCHIVOS
		</font></A>
		</td>
		<td align="center"><?php echo "<A HREF=\"copia_trabajo.php?id_mod=$id_mod&id=$id&op=2\">"; ?>
		<font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">	
		PASAR A REPLICA
		</font></A>
		</td>	
	</tr>
</table>	
<?php	  
if ($op == 1)
{
?>
<form name="form1" method="post">
<input type="hidden" name="op" value="<?php echo $op;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
<table width="60%" align="center" background="images/fondo.jpg" border="1">
	<tr bgcolor="#006699"> 
     <th colspan="3">MODULO: <?php echo $row[nombre_mod]; ?></th>
    </tr>
	<tr>
		<td>		
			<div align="right" style="Font-family:ARIAL">FECHA:
			<?php echo date("d/m/Y");?>&nbsp;&nbsp;&nbsp;HORA: </strong><?php echo date("H:i:s");?>
			</div>
			<P align="center">
			<font face="Arial, Helvetica, sans-serif" size="2" color="#000000">
			<B>DESCARGAR ARCHIVOS</B>
			</font></P>
			<table>
			<tr>
				<td width="139"></td>
				<td width="5" align="center">
				</td>
				<td><br>
				<?php
					$c = 1;
					$sql = "SELECT * FROM control_archivos WHERE ubicacion='c' AND login_b='$login' AND descargado=0";
					$res = mysql_db_query($db,$sql,$link); 
					while ( $fila = mysql_fetch_array($res)) 	 	
					{	$nom_arch = XCampoc($fila['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);
						$id_moda  = XCampoc($fila['id_arch'],"datos_archivos","id_arch","id_mod",$link);	
						if ( $id_mod == $id_moda )
						{	echo "&nbsp;<font face='arial' size='2'>$c"."."."</font>";
							echo "&nbsp&nbsp;<a href=\"bajando.php?arch=$nom_arch&id_arch=$fila[id_arch]\"><font face='arial' size=2 color='#003399'>$nom_arch</font></a>";
							echo "<br>";
							$c++;
						}		
					}
				?>
								
				</td>
				<td width="0"></td>
			</tr>
			</table><br>
		</td>
	</tr>
</table>
<br>
<table width="545" align="center">
  <tr>
  		<td width="545" align="center">
	 	<!--input type="submit" name="guardar" value="ACTUALIZAR"-->
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
		<input name="retornar" type="submit" value="RETORNAR">
		<input type="hidden" value=<?php echo $id?> name="id">
		<input type="hidden" value=<?php echo $id_mod?> name="id_mod">
		</td>
	</tr>
</table>	
</form>
<?php 
}
if ($op==2)
{	
?>
<form name="form1" method="post" enctype="multipart/form-data" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
<input type="hidden" name="op" value="<?php echo $op;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">

  <table width="60%" height="309" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
    <th colspan="3">MODULO: <?php echo $row[nombre_mod]; ?></th>
    </tr>
	<tr>
      <td height="278"> 
        <table width="100%">
          <tr> 
            <td height="56" colspan="2"> <div align="right">Fecha:<?php echo date("d/m/Y");?>&nbsp;&nbsp;HORA:<?php echo date("H:i:s");?></div>
              <br> <DIV align="center"> <font face="Arial, Helvetica, sans-serif" size="2" color="#000000"> 
                <B>PASAR A REPLICA</B> </font></DIV></td>
          </tr>
          <tr> 
            <td colspan="2"> <font size="2" face="Verdana, Helvetica, sans-serif"><b>Archivo:&nbsp;</b></font> 
              <input name="archivo" id="" type="file" size="60" value="<?php print $archivo ?>"> 
              &nbsp;&nbsp; &nbsp;<br> </td>
          </tr>
          <tr> 
            <td width="52%" height="163"><font size="1" face="ARIAL, Helvetica, sans-serif"><b>&nbsp;LISTA 
              DE ARCHIVOS DISPONIBLES PARA SUBIR:<br>
              </b></font> <textarea name='lista' cols='38' rows='8' readonly='readonly'>
			<?php
				$c = 1;
				$sql = "SELECT * FROM control_archivos WHERE ubicacion='c' AND login_b='$login' AND descargado=0";
				$res = mysql_db_query($db,$sql,$link);
				while ( $fila = mysql_fetch_array($res))
				{	$nom_arch = XCampoc($fila['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);	
					$id_modulo  = XCampoc($fila['id_arch'],"datos_archivos","id_arch","id_mod",$link);
					if ( $id_mod == $id_modulo)
					{	echo "\n$c".".";
						echo "&nbsp&nbsp;$nom_arch";
						$c++;
					}
				}			
			?>
			</textarea></td>
            <td width="48%" valign="top"><font size="1" face="ARIAL, Helvetica, sans-serif"><b>&nbsp;<br>
              OBSERVACIONES DEL ARCHIVO A SUBIR: <br>
              </b></font> 
              <textarea name="coment_b" cols="35" rows="4"></textarea> </td>
          </tr>
        </table>
		</td>
	</tr>
</table>	
<br>
<table width="545" align="center">
  <tr>
  		
      <td width="545" align="center"> <input type="submit" name="enviar" value="ENVIAR" onClick="return ValidaArchivo()">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="retornar2" type="submit" value="RETORNAR">
		<input type="hidden" value=<?php echo $id?> name="id">
		<input type="hidden" value=2 name="op">
		<input type="hidden" value=<?php echo $id_mod;?> name="id_mod">		
		</td>
	</tr>
</table>	
</form>
<script language="JavaScript">
<?php 
	if ($msg) 
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\t\t\tMensaje generado por GesTor F1.\");\n";		
	} 	
	if ($msg2) 
   	{	print "var msg2=\"$msg2\";\n";
		print "alert ( msg2 + \"\\n \\n\Mensaje generado por GesTor F1.\");\n";		
	} 
	
?>	
	function ValidaArchivo ()
	{	var form=document.form1;		
		if (form.archivo.value == "")
		{	alert ("Archivo no puede ser vacio \n\n\Mensaje generado por GesTor F1.");			
			return false;
		}
		return true;
	}
</script>
<?php }?>
</BODY>
</HTML>
<?php include("top_.php");?> 