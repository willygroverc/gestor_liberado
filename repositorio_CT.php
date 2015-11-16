<?php 
if ($aceptar){
session_start();
$login=$_SESSION["login"];
include ("conexion.php");
 for ($i=0;$i<=($total-1);$i++){
	$sql3 = "SELECT MAX(id_arch) as id_arch FROM datos_archivos WHERE nombre_arch='$nombre_arch[$i]' AND id_mod='$id_mod'";
	$result3=mysql_db_query($db,$sql3,$link);
	$row3=mysql_fetch_array($result3);
	$sql = "SELECT * FROM datos_archivos WHERE id_arch='$row3[id_arch]'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	
	$fecha_hoy=date("Y-m-d");
		$sql1 = "INSERT INTO control_archivos (id_arch, ubicacion, fecha_c, login_b) VALUES ('$row[id_arch]','c','$fecha_hoy','$login')";
		$result1=mysql_db_query($db,$sql1,$link);
		$sql2 = "UPDATE datos_archivos SET estado=1 WHERE id_arch='$row[id_arch]' AND id_mod='$id_mod'";
		$result2=mysql_db_query($db,$sql2,$link);
	}
?>
<script language="JavaScript">
<!--
	window.close();
-->
</script>
<?php } ?>
<html>
<head>
<title>Microsoft Internet Explorer&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</title>
	<style>
	.f {font-family:arial;font-size:8pt;}
	</style>
</head>
<body background="images/mensaje.jpg" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<table width="100%" align="center" cellpadding="15">
<form action="" method="post" name="form1">
<tr align="center">
	<td colspan="2"><font face="Arial, Helvetica, sans-serif" size="3">&nbsp;</font></td>
</tr>
<tr>
	<td align="center" colspan="2">
	<input type="submit" name="aceptar" value="Aceptar" class="f">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	
	<input type="submit" name="retornar" value="Cancelar" class="f" onClick="cerrar_ventana()">	
</tr>

</form>
</table>
</body>
</html>
<script language="JavaScript">
<!--
function cerrar_ventana(){
	window.close();
}
-->
</script>

