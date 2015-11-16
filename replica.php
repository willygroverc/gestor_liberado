<?php 
$login = $_SESSION["login"];
if ($retornar){header("location: lista_carpetas.php?id=$id");}
include("top.php");
include ("conexion.php");	
$sql02="SELECT * FROM users WHERE login_usr='$login'";
$result02=mysql_db_query($db,$sql02,$link);
$row02=mysql_fetch_array($result02);
$nombre_usr=$row02[nom_usr]." ".$row02[apa_usr]." ".$row02[ama_usr];
include ("funciones.inc.php");
if ($guardar){
		$fecha_hoy = date("Y-m-d");
		$sp = 0;
		for ($i=0; $i<count($sof); $i++)
		{	$id_arch  = XCampoc($sof[$i],"control_archivos","id_control","id_arch",$link);
			$sql6 = "SELECT * FROM control_archivos WHERE  id_control='$sof[$i]'";
			$res6 = mysql_db_query($db,$sql6,$link);
			$row6 = mysql_fetch_array($res6);
			if ($row6[ubicacion]!="rev"){	
				$sql2 = "UPDATE control_archivos SET ubicacion='rev', fecha_rev='$fecha_hoy' WHERE id_control='$sof[$i]'";
				mysql_db_query($db,$sql2,$link);
				$sql1 = "INSERT INTO asignacion_cvs (id_arch, login_resp, fecha_asig, estado, descargado) VALUES ('$id_arch','$asignado','$fecha_hoy',1,0)";
				mysql_db_query($db,$sql1,$link);
				$sp = 1;
				$sql3 = "SELECT * FROM datos_archivos,modulo WHERE datos_archivos.id_arch='$id_arch' AND datos_archivos.id_mod=modulo.id_mod";
				$rst3 = mysql_db_query($db,$sql3,$link);
				$row3 = mysql_fetch_array($rst3);
				$sql01 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod,id_arch)".
			   	         "VALUES ('$fecha_hoy','".date("H:i:s")."','revision','$nombre_usr','$row3[nombre_mod]','$row3[nombre_arch]')";
				$rst01 = mysql_db_query($db,$sql01,$link);
			}		
		}
		if ($sp == 1){ $msg2 = "El proceso de asignacion se ha realizado satisfactorimante";}
}
unset($sof);	
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<form name="form1" action="replica.php?op=1" method="post">
<table width="60%" align="center" background="images/fondo.jpg" border="1">
	<tr bgcolor="#006699"> 
     <th colspan="3">MODULO: 
	 <?php 
	$sql0 = "SELECT * FROM modulo WHERE id_mod='$id_mod'";
	$res0 = mysql_db_query($db,$sql0,$link);
	$row0 = mysql_fetch_array($res0);	 
	 echo $row0[nombre_mod]; 
	 ?>
	 </th>
    </tr>
	<tr>
		<td>		
			<div align="right" style="Font-family:ARIAL">FECHA:
			<?php echo date("d/m/Y");?>&nbsp;&nbsp;&nbsp;HORA: </strong><?php echo date("H:i:s");?>
			</div>
			<P align="center">
			<font face="Arial, Helvetica, sans-serif" size="2" color="#000000">
			<B>REPLICA - ASIGNACION DE ARCHIVOS</B>
			</font></P>
			
        <table width="98%" align="center">
          <tr>
				<td width="100%">
				<br><font face="Arial, Helvetica, sans-serif" size="2" color="#000000">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<b>Asignar a:</b></font>&nbsp;	
				<select name = "asignado">
				<?php
				$sql = "SELECT * FROM users WHERE tipo2_usr='T' ORDER BY apa_usr ASC";
				$res = mysql_db_query($db,$sql,$link); 
				while ( $fila = mysql_fetch_array($res))
				{	echo "<option value='$fila[login_usr]'>".$fila[apa_usr]." ".$fila[ama_usr]. " ".$fila[nom_usr];					
				}				
				?>				
				</select><BR>&nbsp;
				<table align="center" width="90%" border="1">
					<tr bgcolor="#006699" align="center">
					<td><font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">OK</FONT></td>
					<td><font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">NOMBRE ARCHIVO</FONT></td>
					<td><font face="Arial, Helvetica, sans-serif" size="1" color="#FFFFFF">MODIFICADO POR</FONT></td>					
					</tr>
				<?php	
					$sql = "SELECT * FROM control_archivos WHERE ubicacion='b'";			
					$res = mysql_db_query($db,$sql,$link); 
					while ( $fila = mysql_fetch_array($res))
					{	$id_modu  = XCampoc($fila['id_arch'],"datos_archivos","id_arch","id_mod",$link);						
						if ($id_modu==$id_mod)
						{	$pat = XCampoc($fila[login_b],"users","login_usr","apa_usr",$link);							
							$mat = XCampoc($fila[login_b],"users","login_usr","ama_usr ",$link);
							$nom = XCampoc($fila[login_b],"users","login_usr ","nom_usr",$link);			
							echo "<tr align='center'>";
							echo "<td><input type='checkbox' name=sof[] VALUE='$fila[id_control]'></td>";
							$nom_arch = XCampoc($fila['id_arch'],"datos_archivos","id_arch","nombre_arch",$link);
							echo "<td>$nom_arch</td>";							
							echo "<td>$nom $pat $mat </td>";
							echo "</tr>";
						}
					}
				?>	
				</table>
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
	 	<input type="submit" name="guardar" value="GUARDAR" onClick="return ValidaArchivo()">
        &nbsp;&nbsp;&nbsp;		
		<input name="retornar" type="submit" value="RETORNAR">
		<input type="hidden" value=<?php echo $id?> name="id">
		<input type="hidden" value=<?php echo $id_mod?> name="id_mod">
		</td>
	</tr>
</table>	
</form>
<script language="JavaScript">
<?php	if ($msg2) 
   	{	print "var msg2=\"$msg2\";\n";
		print "alert ( msg2 + \"\\n \\n\tMensaje generado por GesTor F1.\");\n";		
	} 
?>	
	function ValidaArchivo ()
	{	var form=document.form1;		
		if (form.asignado.value == "")
		{	alert ("El nombre de la persona no puede ser vacio \n\n Mensaje generado por GesTor F1.");			
			return false;
		}
		return true;
	}
</script>

</body>
</html>
