<?php 
include ("top.php");
?>
<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong>
<?php 
if (isset($msg))
	echo $msg;

?></strong></font>
<table  border="1" align="center" cellpadding="0" cellspacing="2" bgcolor="#EAEAEA">
  <tr>
    <th width="634" height="57">NO CUENTA CON LOS ROLES NECESARIOS PARA INGRESAR A ESTA PAGINA<br>
      CONSULTE CON EL ADMINISTRADOR DEL SISTEMA</th>
  </tr>
  <tr>
    <td height="305" bgcolor="#FFFFFF"><div align="center"><IMG SRC="images/sin_permiso.gif" WIDTH=322 HEIGHT=303></div></td>
  </tr>
</table>
</body>
</html>