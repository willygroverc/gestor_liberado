<?php 
session_start();
$login = $_SESSION["login"];
if ($retornar){
	header("location: lista_carpetas.php?id=$id");
}
include ( "conexion.php" );
include ( "funciones.inc.php" );
$sql03="SELECT * FROM users WHERE login_usr='$login'";
$result03=mysql_db_query($db,$sql03,$link);
$row03=mysql_fetch_array($result03);
$nombre_usr=$row03[nom_usr]." ".$row03[apa_usr]." ".$row03[ama_usr];
if ($guardar){
    session_start();
	$path = $_SESSION["path"];		
	$sql9 = "SELECT MAX(id_arch) as id_arch FROM datos_archivos WHERE nombre_arch='$archivo_name' AND id_mod='$id_mod'";
	$res9 = mysql_db_query($db,$sql9,$link); 
	$fila9 = mysql_fetch_array($res9);
	$sql = "SELECT * FROM datos_archivos WHERE id_arch='$fila9[id_arch]'";
	$res = mysql_db_query($db,$sql,$link); 
	$fila = mysql_fetch_array($res);
	$nombre_mod = XCampoc($fila['id_mod'],"modulo","id_mod","nombre_mod",$link);	
	$dir = $path."/".$nombre_mod."/".$archivo_name;
	//escritura fisica del archivo
	//verifica la lista
	unset($sw);
	$sql5 = "SELECT * FROM asignacion_cvs WHERE login_resp='$login' AND descargado=0 AND estado=1";
	$res5 = mysql_db_query($db,$sql5,$link); 
	while ( $fila5 = mysql_fetch_array($res5))
	{	$nom_arch5 = XCampoc($fila5['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);			
		$id_modu5  = XCampoc($fila5['id_arch'],"datos_archivos","id_arch","id_mod",$link);
		if ( $id_mod == $id_modu5)
		{	
			if ($archivo_name==$nom_arch5)
			{ 	$sw = 1;
				$id_asig = $fila5[id_asig];
			}			
		}	
	}
	//exit;
	if ($sw == 1){
		$sql1="UPDATE asignacion_cvs SET descargado=1 WHERE id_asig='$id_asig'";
		$res1=mysql_db_query($db,$sql1,$link);		
		//construyendo el nombre de la nueva version, $nombre_arch
		$sql3="SELECT MAX(id_ver) as id_ver FROM versiones WHERE id_arch='$fila[id_arch]'";
		$res3=mysql_db_query($db,$sql3,$link);
		$row3=mysql_fetch_array($res3);
		if ($row3[id_ver]){
			$id_version = XCampoc($row3['id_ver'],"versiones","id_ver","id_version",$link);
			$id_version=$id_version+1;
		}else{$id_version=1;}	
		$nombre=strtok($archivo_name,"."); 
		$extension = explode(".",$archivo_name);
		$num = count($extension)-1;
		$nombre_arch=$nombre."-".$id_version.".".$extension[$num];//////////////////////////////
		$dir2 = $path."/".$nombre_mod."/".$nombre_arch;
		rename($dir,$dir2);
	
		if (copy($archivo,$dir)){
			//actualizando la tabla control_archivos
			$sql1="SELECT MAX(id_control) as id_control FROM control_archivos WHERE id_arch='$fila[id_arch]' AND ubicacion='rev'";
			$res1=mysql_db_query($db,$sql1,$link);
			$row1=mysql_fetch_array($res1);
			$fecha_hoy=date("Y-m-d");
			$hora_hoy=date("H:i:s");
			$sql2="UPDATE control_archivos SET ubicacion='r',fecha_r='$fecha_hoy',login_r='$login', coment_r='$coment_r' WHERE id_control='$row1[id_control]'";
			$res2=mysql_db_query($db,$sql2,$link);
			$sql10 = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
			$res10=mysql_db_query($db,$sql10,$link);
			$row10=mysql_fetch_array($res10);
			$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
			         "VALUES ('$fecha_hoy','$hora_hoy','repositorio','$nombre_usr','$row10[nombre_mod]','$archivo_name')";
			$rst01 = mysql_db_query($db,$sql01,$link);
				
			//registrando la version del archivo en la tabla versiones
			$hash_cont = md5_file($dir);
			$sql4="INSERT INTO versiones (id_arch,id_version,fecha_ver,nombre_arch,id_control,hash_archi) VALUES ('$fila[id_arch]','$id_version','$fecha_hoy','$nombre_arch','$row1[id_control]','$hash_cont')";
			$res4=mysql_db_query($db,$sql4,$link);
		    $id_ver = ObtieneCodigo($db,$link,'versiones','id_ver');
			$sql02 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch,id_ver)".
			         "VALUES ('$fecha_hoy','$hora_hoy','creacion_version','$nombre_usr','$row10[nombre_mod]','$archivo_name','$nombre_arch')";
			$rst02 = mysql_db_query($db,$sql02,$link);
			//cambiando el estado a NO ASIGNADO en la tabla asignacion_cvs
			$sql6="SELECT MAX(id_asig) as id_asig FROM asignacion_cvs WHERE id_arch='$fila[id_arch]' AND login_resp='$login'";
			$res6=mysql_db_query($db,$sql6,$link);
			$row6=mysql_fetch_array($res6);
			$sql7="UPDATE asignacion_cvs SET estado=0 WHERE id_asig='$row6[id_asig]'";
			$res7=mysql_db_query($db,$sql7,$link);
			//Cambiando el estado a DISPONIBLE en la tabla datos_archivos
			$sql8="UPDATE datos_archivos SET estado=0,fecha_rev='$fecha_hoy' WHERE id_arch='$fila[id_arch]'";
			$res8=mysql_db_query($db,$sql8,$link);
			$msg2 = "El archivo se ha enviado con exito";
			
			$path_replica=$_SESSION["path_replica"];
			$path_c = $path_replica."/".$nombre_mod."/".$archivo_name;
			unlink($path_c); 
		}
	}else{$msg="El nombre del archivo que desea subir no coincide con ninguno de la lista de archivos disponibles";}
}
include("top.php");

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
		<td align="center"><?php echo "<A HREF='revision.php?id_mod=$id_mod&op=1&id=$id'>"; ?>
		<font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">
		DESCARGAR ARCHIVOS
		</font></A>
		</td>
		<td align="center"><?php echo "<A HREF='revision.php?id_mod=$id_mod&op=2&id=$id'>"; ?>
		<font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">	
		PASAR A REPOSITORIO
		</font></A>
		</td>	
	</tr>
</table>	
<?php if ($op==1){?>
<form name="form1" action="revision.php" method="post">
<input type="hidden" name="op" value="<?php echo $op;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">
<?php
	$sql = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
	$res = mysql_db_query($db,$sql,$link);
	$row = mysql_fetch_array($res);
?>
<input name="id_mod" type="hidden" value="<?php echo $id_mod; ?>">
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
			<td width="251" align="center">
			<?php
				$c = 1;
				$sql = "SELECT * FROM asignacion_cvs WHERE login_resp='$login' AND estado=1 AND descargado=0";
				$res = mysql_db_query($db,$sql,$link); 
				while ( $fila = mysql_fetch_array($res))
				{		
					$sql2 = "SELECT MAX(id_arch) as id_arch FROM datos_archivos WHERE id_arch='$fila[id_arch]' AND id_mod='$id_mod'";
					$res2 = mysql_db_query($db,$sql2,$link); 
					$row2 = mysql_fetch_array($res2);
					$sql1 = "SELECT * FROM datos_archivos WHERE id_arch='$row2[id_arch]'";
					$res1 = mysql_db_query($db,$sql1,$link); 
					$row1 = mysql_fetch_array($res1);
					if ($row1[id_arch]){
					echo "&nbsp;<font face='arial' size='2'>$c"."."."</font>";
					echo "&nbsp&nbsp;<a href=\"bajando2.php?id=$fila[id_arch]&login=$login\"><font face='arial' size=2 color='#003399'>$row1[nombre_arch]</font></a>";
					//echo "&nbsp&nbsp;<a href=\"bajando.php?arch=$nom_arch&id_arch=$fila[id_arch]&id_control=$fila[id_control]\"><font face='arial' size=2 color='#003399'>$nom_arch</font></a>";					
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
<table align="center">
  	<tr>
  		<td width="100%"><div align="center">
		<!--input name="actualizar" type="submit" value="ACTUALIZAR"-->
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="retornar" type="submit" value="RETORNAR"></div></td>
	</tr>
</table>	
</form>
<?php }?>
<?php if ($op==2){?>
<form name="form2" method="post" enctype="multipart/form-data" >
<input type="hidden" name="op" value="<?php echo $op;?>">
<input type="hidden" name="id" value="<?php echo $id;?>">

<table width="60%" align="center" background="images/fondo.jpg" border="1">
      	<?php
			$sql = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
			$res = mysql_db_query($db,$sql,$link);
			$row = mysql_fetch_array($res);
		?>
	
	<tr bgcolor="#006699"> 
      <th height="23" colspan="3">MODULO: <?php echo $row[nombre_mod]; ?></th>
    </tr>
	<tr>
      <td height="289"> 
        <table width="100%">
          <tr> 
            <td colspan="2"> <div align="right">Fecha:<?php echo date("d/m/Y");?>&nbsp;&nbsp;HORA:<?php echo date("H:i:s");?></div>
              <P align="center"> <font face="Arial, Helvetica, sans-serif" size="2" color="#000000"> 
                <B>PASAR A REPOSITORIO</B></font><BR>
              </P>
              </td>
          </tr>
          <tr> 
            <td colspan="2"> <font size="2" face="Verdana, Helvetica, sans-serif"><b>Archivo:&nbsp;</b></font> 
              <input name="archivo" id="archivo" type="file" size="60" value="<?php print $archivo ?>"> 
              <BR> </td>
          </tr>
          <tr> 
            <td width="52%" height="171"><font size="1" face="ARIAL, Helvetica, sans-serif"><b>&nbsp;&nbsp;&nbsp;LISTA 
              DE ARCHIVOS DISPONIBLES PARA SUBIR:</b></font><br> &nbsp;&nbsp; 
              <textarea name='lista' cols='38' rows='8' readonly='readonly'>
			<?php
				$c = 1;
				$sql = "SELECT * FROM asignacion_cvs WHERE login_resp='$login' AND estado=1 AND descargado=0";
				$res = mysql_db_query($db,$sql,$link); 
				while ( $fila = mysql_fetch_array($res))
				{		
					$sql1 = "SELECT * FROM datos_archivos WHERE id_arch='$fila[id_arch]' AND id_mod='$id_mod'";
					$res1 = mysql_db_query($db,$sql1,$link); 
					$row1 = mysql_fetch_array($res1);
					if ($row1[id_arch]){
						echo "\n$c".".";
						echo "&nbsp&nbsp;$row1[nombre_arch]";
						$c++;
					}
				}
			?>
			</textarea></td>
            <td width="48%" valign="top"><font size="1" face="ARIAL, Helvetica, sans-serif"><b><br>
              OBSERVACIONES DEL ARCHIVO A SUBIR: <br>
              </b></font> 
              <textarea name="coment_r" cols="35" rows="4"></textarea></td>
          </tr>
        </table>
		</td>
	</tr>
</table>	
<br>
<table align="center">
  	<tr>
  		<td><div align="center">
		<input name="guardar" type="submit" value="ENVIAR" onClick="return ValidaArchivo()">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="retornar" type="submit" value="RETORNAR"></div></td>
	</tr>
</table>	
</form>
<?php }?>
<script language="JavaScript">
<?php 

	if ($msg2) 
   	{	print "var msg2=\"$msg2\";\n";
		print "alert ( msg2 + \"\\n \\nMensaje generado por GesTor F1.\");\n";		
	} 

if ($msg) 
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\t\tMensaje generado por GesTor F1.\");\n";		
	} 
?>	
	function ValidaArchivo ()
	{	var form=document.form2;		
		if (form.archivo.value == "")
		{	alert ("Archivo no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
		return true;
	}
</script>


</BODY>
</HTML>
<?php include("top_.php");?> 