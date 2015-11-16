<?php 
include ("conexion.php");
session_start();
$fecha_hoy = date("d/m/Y");
if ($guardar)
{  	$fecha_hoy = date("Y-m-d");
	$tipo_a = strtoupper($tipo_a);
	$sql3="INSERT INTO ".
	"controlinvent(FechaAlta,Tipo,Observ) VALUES('$fecha_hoy','$tipo_a','$obs')";
	if (mysql_db_query($db,$sql3,$link)) $msg = "Los datos se han guardado satisfactoriamente.";
	else $msg = "Hubo un Error al guardar los datos por favor intentelo mas tarde";
}
?>
<html>
<head><title>INVENTARIO  DE MEDIOS</title></head>
<body background="images/fondo.jpg" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<form name="form1" action="registrar_medio.php" method="post">
 <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="4">
 <tr> 
     <th colspan="3" nowrap bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
      ALTA DE MEDIO DE ALMACENAMIENTO</font></th>
  </tr>
  <tr>
  	<td width="27" height="10"></td>
	<td width="160"></td></td>
  	<td width="344"></td>
  </tr>  
  <tr>
  	<td width="27"></td>
	<td width="160"><font size="2" face="Arial, Helvetica"><b>Fecha de Alta:</b></font></td>
  	<td width="425"><font size="2" face="Arial, Helvetica"><?php echo $fecha_hoy; ?></font></td>
  </tr>
  <tr>
  	<td width="27"></td>
	<td width="160"><font size="2" face="Arial, Helvetica"><b>Tipo:</b></font></td>
  	<td width="425"><input type="text" name="tipo_a" size="25" maxlength="25"></td>
  </tr>  
  <tr>
  	<td width="27"></td>
	<td width="160"><font size="2" face="Arial, Helvetica"><b>Observaciones:</b></font></td>
  	<td width="425"><textarea name="obs" cols="30"></textarea></td>
  </tr>
  </table>
  <table width="409" align="center">
    <tr>
      <td height="40" align="center"> 		
	  	<BR>&nbsp;
	 	<input type="submit" name="guardar" value="GUARDAR" onClick="return ValidaArchivo()" >
         &nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;		 
        <input type="submit" name="retornar" VALUE="RETORNAR" onClick="window.close();">
	 <td>
    </tr>						
</table>
</form>
</body>
</html>
<script language="JavaScript">
<?php
 if ($msg) 
   	{	print "var msg=\"$msg\";\n";
		print "alert ( msg + \"\\n \\n\tMensaje generado por GesTor F1.\");\n";		
	} 	
?>	
	function ValidaArchivo ()
	{				
		var form=document.form1;
		if (form.tipo_a.value == "")
		{	alert ("Tipo de Medio no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}						
		return true;
		if (form.modulo.value == "")
		{	alert ("Modulo no puede ser vacio \n\nMensaje generado por GesTor F1.");			
			return false;
		}
								
	}		
</script>