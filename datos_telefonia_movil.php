<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if(isset($_REQUEST['RETORNAR'])) header("location: menu_parametros.php");
include("top.php");
$id=  isset($_REQUEST['id']);
if (isset($_REQUEST['INSERTAR']))
{   
	if($_POST['accion']=="actualizar") $sql="UPDATE dat_tel_movil SET nombre='$_REQUEST[nombre]', direccion='$_REQUEST[direccion]' WHERE id_dat_tel_movil=$id";	
	else $sql="INSERT INTO dat_tel_movil(nombre, direccion) VALUES ('$_REQUEST[nombre]', '$_REQUEST[direccion]')";
	$rs=mysql_query($sql);
	if(mysql_affected_rows()!=1) $msg="Precaucion, no se han registrado los datos. Por favor, verifique e intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
}
if(isset($_GET['accion']) && $_GET['accion']=="editar"){
	$sql1="SELECT * FROM dat_tel_movil WHERE id_dat_tel_movil=$id";
//	print $sql1;
	$row1=mysql_fetch_array(mysql_query($sql1));
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
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
    <input name="id" type="hidden" value="<?php echo $row1['id_dat_tel_movil'];?>">
    <tr> 
      <td height="180"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">DATOS 
              DE TELEFONIA MOVIL</font></th>
          </tr>
          <tr align="center"> 
            <th width="43%" align="center" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >Nombre</font></th>
            <th width="38%" align="center" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Direccion</font></th>
			<th width="38%" align="center" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Editar</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM dat_tel_movil ORDER BY nombre ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr> 
            <td align="center">&nbsp;<?php print $row['nombre']?>
			<td align="center">&nbsp;<?php echo $row['direccion'];?></td>			
            <td align="center">&nbsp;<?php echo "<a href=\"$_SERVER[PHP_SELF]?accion=editar&id=$row[id_dat_tel_movil]\"><img src=\"images/editar.gif\" alt=\"Editar\" border=\"0\"></a>"; ?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr bgcolor="#006699"> 
            <th height="7" colspan="3" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif" >
                        <?php if(isset($_GET['accion'])=="editar"){ echo 'Editando: '.@$row1['nombre'];}
                                else{ print "Nuevo Registro";}?>
			</font></th>
          </tr>
          <tr> 
            <td height="1" nowrap> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="nombre" type="text" value="<?php echo @$row1['nombre'];?>" size="30" maxlength="20">
                </font></div></td>
            <td height="7" colspan="2" align="center" nowrap><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <input name="direccion" type="text" id="direccion" value="<?php echo @$row1['direccion'];?>" size="30" maxlength="30">
              </font></td>
          </tr>
          <tr> 
            <td height="49" colspan="3" nowrap> <div align="center"><br>
                <input name="INSERTAR" type="submit" id="INSERTAR" value="INSERTAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
                <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <input name="accion" type="hidden" value="<?php echo $accion?>">
                </font> </div></td>
          </tr>
        </table></td>
    </tr>
  </form>
</table>
<script language="JavaScript">
<!--
<?php if(isset($msg)) print "alert(\"$msg\");\n"; ?>
-->
</script>