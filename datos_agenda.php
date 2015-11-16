<?php
if($RETORNAR) header("location: seguridad_opt.php?Naveg=Seguridad");
include("top.php");
if ($INSERTAR)
{   //include("conexion.php");
	if($_POST[accion]=="actualizar") $sql="UPDATE dat_tel_movil SET nombre='$nombre', direccion='$direccion' WHERE id_dat_tel_movil=$id";	
	else $sql="INSERT INTO dat_tel_movil(nombre, direccion) VALUES ('$nombre', '$direccion')";
	$rs=mysql_db_query($db,$sql,$link);
	if(mysql_affected_rows()!=1) $msg="Precaucion, no se han registrado los datos. Por favor, verifique e intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}
if($_GET[accion]=="editar"){
	$sql1="SELECT * FROM dat_tel_movil WHERE id_dat_tel_movil=$id";
//	print $sql1;
	$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
	$accion="actualizar";
}
else $accion="";
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "nombre",  "Nombre, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "direccion",  "Direccion, $errorMsgJs[expresion]" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
    <input name="id" type="hidden" value="<?php echo $row1[id_dat_tel_movil];?>">
    <tr> 
      <td height="180"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">DATOS 
              DE AGENDA/MINUTA</font></th>
          </tr>
          <tr align="center"> 
            <th width="43%" align="center" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >Codigo</font></th>
            <th width="38%" align="center" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo Reunion</font></th>
			<th width="38%" align="center" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Editar</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM dat_tel_movil ORDER BY nombre ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php print $row[nombre2]?>
			<td align="center">&nbsp;<?php echo $row[direccion2];?></td>			
            <td align="center">&nbsp;<?php echo "<a href=\"$PHP_SELF?accion=editar&id=$row[id_dat_tel_movil]\"><img src=\"images/editar.gif\" alt=\"Editar\" border=\"0\"></a>"; ?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th height="7" colspan="3" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >
			<?php if($_GET[accion]=="editar") print "Editando: $row1[nombre]";
				else print "Nuevo Registro";?>
			</font></th>
          </tr>
          <tr> 
            <td height="123" nowrap colspan="2"> 
              <input type="radio" name="op_medio" value="1" checked><FONT face="Arial, Helvetica, sans-serif" size="1">CODIGO:</FONT>&nbsp;&nbsp;&nbsp;
			 <select name="medio" class="cl2"> 
                <?php	
					$sql2 = "SELECT distinct(Tipo) FROM controlinvent";
					$res2 = mysql_db_query ( $db, $sql2, $link);					
					while ($fila = mysql_fetch_array( $res2 ) )						
					echo "<option value='$fila[Tipo]'>$fila[Tipo]";
				?>
              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input type="radio" name="op_medio" value="0"><font face="Arial, Helvetica, sans-serif" size="1">OTRO:</font>
			  <input type="text" name="medio_otro" size="15" maxlength="25" class="cl"><br><BR>
			  <font face="Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;DESCRIPCION:</font>
              <textarea name="obs" cols="40" onKeyDown="textCounter(form2.obs,form2.remLen,150);" onKeyUp="textCounter(form2.obs,form2.remLen,150);"></textarea>
          <input name="remLen" type="hidden" value="150">

			</td>
          </tr>
		  <tr>
		  <td colspan="2">
              <input type="radio" name="op_medio" value="1" checked><FONT face="Arial, Helvetica, sans-serif" size="1">CODIGO:</FONT>&nbsp;&nbsp;&nbsp;
			 <select name="medio" class="cl2"> 
                <?php	
					$sql2 = "SELECT distinct(Tipo) FROM controlinvent";
					$res2 = mysql_db_query ( $db, $sql2, $link);					
					while ($fila = mysql_fetch_array( $res2 ) )						
					echo "<option value='$fila[Tipo]'>$fila[Tipo]";
				?>
              </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <input type="radio" name="op_medio" value="0"><font face="Arial, Helvetica, sans-serif" size="1">OTRO:</font>
			  <input type="text" name="medio_otro" size="15" maxlength="25" class="cl"><br><BR>
			  <font face="Arial, Helvetica, sans-serif" size="1">&nbsp;&nbsp;DESCRIPCION:</font>
              <textarea name="obs" cols="40" onKeyDown="textCounter(form2.obs,form2.remLen,150);" onKeyUp="textCounter(form2.obs,form2.remLen,150);"></textarea>
          <input name="remLen" type="hidden" value="150">
		  
		  </td>
		  </tr>
          <tr> 
            <td height="49" colspan="3" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="submit" name="RETORNAR" value="RETORNAR">
                <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="accion" type="hidden" value="<?php=$accion?>">
                </font> </div></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<script language="JavaScript">
<!--
<?php if($msg) print "alert(\"$msg\");\n"; ?>
-->
</script>
<?php include("top_.php");?>
