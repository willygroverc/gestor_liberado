<?php 
include("conexion.php");
if (isset($Subir))
{$extension = explode(".",$archivo_name); 
 $num = count($extension)-1; 
 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
 {  $origen=getimagesize("$archivo");
    $Ancho=$origen[0];
	$Alto=$origen[1];
	if ($Ancho <="150" AND $Alto <= "70")
	{$arch_nomb="imagen_ins.jpg";
	copy($archivo,"imagenes2/".$arch_nomb);
	$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE";
	}
	else {$msg="SU IMAGEN ES DE ".$Ancho." x ".$Alto."pixeles, EL TAMAÑO DE LA IMAGEN NO DEBE SER MAYOR A 150 x 70 pixeles";}
 }
 else {$msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif O .jpg";}
}
?>
<form name="form1" method="post" enctype="multipart/form-data" onKeyPress="return Form()">
  <input name="archivo" type="file" size="60" value="<?php print $archivo ?>">
  <input type="submit" name="Subir" value="Subir">
</form>
<script language="JavaScript">
		<!-- 
		<?php 
		if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
