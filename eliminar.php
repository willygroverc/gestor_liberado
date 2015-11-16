<?php
include ("conexion.php");
$sql = "SELECT COUNT(id_orden) AS numtot FROM asignacion WHERE asig='$login_usr'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
$noasig=$row[numtot];

if ($noasig>0) {
	$msg="El usuario que se deseea borrar tiene asignaciones, para eliminarlo primero elimine sus asignaciones";
}

else {

	if ($login_usr=="admin"){
		$msg="No puede eliminar al administrador del sistema";
	}
	else {
		$sql = "DELETE FROM users WHERE login_usr='$login_usr'";
		$result=mysql_db_query($db,$sql,$link);
	}
}
header("location: usuarios_lista.php")
?><!--	 <font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php //echo $msg;?></strong></font> 
<form action="<?php echo $PHP_SELF ?>" method="post" name="form1">
  <table width="583" border="2" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#F4F2EA" style="border-collapse:collapse;" background="images/fondo.jpg">
    <tr> 
      <td width="579" bgcolor="#006699"><div align="center"><font color="#FFFFFF">ELIMINADO 
          CON EXITO</font></div></td>
    </tr>
  </table>
</form>
-->
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>
<?php include("top_.php");?>
