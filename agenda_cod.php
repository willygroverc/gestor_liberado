<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
require ("conexion.php");
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
} 
if(isset($_REQUEST['RETORNAR'])) header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");
if(isset($_REQUEST['reg_form'])){
	$sql="INSERT INTO agenda_cod (agenda_cod,agenda_desc) VALUES ('$_REQUEST[cod]', '$_REQUEST[desc]')";
	mysql_query($sql);
}	
include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "cod",  "Codigo, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "desc", "Descripcion, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>
<form name="form2" action="" method="post">
<table width="50%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
	<tr> 
      <th colspan="3" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
        CODIGOS</font></th>
  </tr>
  <tr> 
    <th width="40" nowrap background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
      <th width="307" nowrap background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CODIGO</font></th>
      <th width="246" nowrap background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DESCRIPCION</font></th>
  </tr>
  <?php
		$cont=0;	
		$sql = "SELECT * FROM agenda_cod ORDER BY agenda_cod";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
  <tr> 
    <td align="center">&nbsp;<?php echo $cont?></td>
    <td align="center">&nbsp;<?php echo $row['agenda_cod']?></td>
    <td align="center">&nbsp;<?php echo $row['agenda_desc']?></td>
  </tr>
  <?php 
		 }
		 ?>
  <tr> 
    <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
      <div align="center"></div></td>
  </tr>
  <tr> 
    <td width="40" height="7" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
    <td width="307" nowrap><div align="center"><strong> 
          <input name="cod" type="text" id="cod" size="50" maxlength="100">
        </strong></div></td>
    <td colspan="2" width="246" nowrap height="7"><div align="center"><strong> 
          <input name="desc" type="text" id="desc" value="" size="60">
        </strong> </div></td>
  </tr>
  <tr> 
    <td height="28" colspan="7" nowrap> <div align="center"> <br>
          <input name="reg_form" type="submit" id="reg_form3" value="NUEVO CODIGO" <?php print $valid->onSubmit() ?>>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="RETORNAR" type="submit" id="reg_form" value="RETORNAR">
          <br><br>
      </div></td>
  </tr>
</table>
</form>