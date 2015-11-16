<?php
// Version: 	1.0
// Objetivo: 	Se ha aumentdo la opcion de eliminar areas segun el usuario requiera.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
//require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if(isset($_REQUEST['RETORNAR'])) header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");
include("top.php");
//$id_dadicional=$_REQUEST['id_dadicional'];
$id=  isset($_REQUEST['id']);
if (isset($_REQUEST['INSERTAR']))
{       $id_dadicional=$_REQUEST['id_dadicional'];
	if($_POST['accion']=="actualizar") {$sql="UPDATE datos_adicionales SET tipo_dadicional='$_REQUEST[tipo_dadicional]', nombre_dadicional='$_REQUEST[nombre_dadicional]' WHERE id_dadicional=$id_dadicional";}	
	else 
	{	$sql0 = "SELECT * FROM datos_adicionales WHERE tipo_dadicional='$_REQUEST[tipo_dadicional]' AND nombre_dadicional='$_REQUEST[nombre_dadicional]'";
 		$result0=mysql_db_query($db,$sql0,$link);
		$row0=mysql_fetch_array($result0);
		if (!$row0['id_dadicional']) {$sql="INSERT INTO datos_adicionales(tipo_dadicional, nombre_dadicional, estado) VALUES ('$_REQUEST[tipo_dadicional]', '$_REQUEST[nombre_dadicional]','0')";}
		else $msg="Ya existe un registro de tipo: ".$_REQUEST['tipo_dadicional'].", con nombre: ".$_REQUEST['nombre_dadicional'];
	}
	$rs=mysql_db_query($db,$sql,$link);
	if(mysql_affected_rows()!=1) $msg="Precaucion, no se han registrado los datos. Por favor, verifique e intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}
if(isset($_REQUEST['ejecutar'])=="eliminar"){
                $id= $_REQUEST['id'];
		$sql= "UPDATE datos_adicionales SET estado=1 WHERE id_dadicional='$id'";
		mysql_query($sql,$link);
	}
	mysql_query($sql,$link);
if(isset($_GET['accion'])=="editar"){
        $id_dadicional=$_REQUEST['id_dadicional'];
	$sql1="SELECT * FROM datos_adicionales WHERE id_dadicional=$id_dadicional";
	$row1=mysql_fetch_array(mysql_db_query($db,$sql1,$link));
	$accion="actualizar";
}
else $accion="";
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "tipo_dadicional",  "Tipo, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "nombre_dadicional",  "Nombre, $errorMsgJs[expresion]" );
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
<script language="JavaScript">
function confirmLink(theLink, archi)
{
    var is_confirmed = confirm("Desea realmente eliminar este registro? \n\nMensaje generado por GesTor F1");
    if (is_confirmed) {
        theLink.href += '&confirmado=1&Naveg=Seguridad >> Recordatorios';
    }
	
    return is_confirmed;
} // end of the 'con firmLink()' function
			
</script>
<table width="60%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="id_dadicional" type="hidden" value="<?php echo $row1['id_dadicional'];?>">
    <tr> 
      <td height="180"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="4" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">DATOS ADICIONALES</font></th>
          </tr>
          <tr align="center"> 
            <th width="43%" align="center" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Tipo</font></th>
            <th width="38%" align="center" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre</font></th>
			<th width="38%" align="center" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Editar</font></th>
			<th width="38%" align="center" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Eliminar</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM datos_adicionales WHERE estado= 0 ORDER BY tipo_dadicional ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php print $row['tipo_dadicional']?>
			<td align="center">&nbsp;<?php echo $row['nombre_dadicional'];?></td>			
            <td align="center">&nbsp;<?php echo "<a href=\"$_SERVER[PHP_SELF]?accion=editar&id_dadicional=$row[id_dadicional]\"><img src=\"images/editar.gif\" alt=\"Editar\" border=\"0\"></a>"; ?></td>
			<td align="center">&nbsp;<?php echo "<a href=\"?ejecutar=eliminar&id=$row[id_dadicional]\"onClick=\"return confirmLink(this,'$row[id_dadicional]')\"> <img src=\"images/eliminar.gif\" border=\"0\" alt=\"Eliminar\"></a>"; ?> </td>          
		  </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="4" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th height="7" colspan="4" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >
			<?php if(isset($_GET['accion'])=="editar") print "Editando: $row1[nombre_dadicional]";
				else print "Nuevo Registro";?>
			</font></th>
          </tr>
          <tr> 
            <td height="1" nowrap> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="tipo_dadicional" id="tipo_dadicional">
				<option></option>
				<option value="agencia">agencia</option>
				<option value="area">area</option>
               </select>
                </font></div></td>
            <td height="7" colspan="2" align="center" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="nombre_dadicional" type="text" id="nombre_dadicional" value="<?php=$row['nombre_dadicional'] ?>" size="30" maxlength="30">
              </font></td>
          </tr>
          <tr> 
            <td height="49" colspan="4" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
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