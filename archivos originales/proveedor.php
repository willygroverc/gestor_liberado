<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		24/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
if (isset($RETORNAR)){header("location: lista_proveed.php");}
if (isset($GUARDPROV) && $NombProv<>"" && $IdProv=="" ) {
  require ("conexion.php");
  $sql = "INSERT INTO proveedor (NombProv,DirecProv,Fono1Prov,Fono2Prov,EmailProv,EncProv,ObsProv) VALUES ('$NombProv','$DirecProv','$Fono1Prov','$Fono2Prov','$EmailProv','$EncProv','$ObsProv')";
  $result=mysql_query($sql);
  header("location: lista_proveed.php");
}

else if (isset($GUARDPROV) && isset($IdProv)) {
    include ("conexion.php");
    $sql = "UPDATE proveedor SET NombProv='$NombProv',DirecProv='$DirecProv',Fono1Prov='$Fono1Prov',".
   "Fono2Prov='$Fono2Prov',EmailProv='$EmailProv',EncProv='$EncProv',ObsProv='$ObsProv'".
    "WHERE IdProv='$IdProv'";   
     if (mysql_query($sql)){
  		header("location: lista_proveed.php");
	}
	else {		
		$msg="OCURRIO UN ERROR EN LA MIENTRAS SE ACTUALIZABA ";//.mysql_error();
	}
}

else if (isset($ELIMINAR) && isset($IdProv)) {
	include ("conexion.php");
	$sql = "DELETE FROM proveedor WHERE IdProv='$IdProv'";
	if (mysql_query($sql)){
  		header("location: lista_proveed.php");
	}
	else {		
		$msg="OCURRIO UN ERROR EN LA MIENTRAS SE TRATABA DE BORRAR ";//.mysql_error();
	}
}

include ("top.php"); 

if (isset($IdProv)) {
  $sql = "SELECT * FROM proveedor WHERE IdProv='$IdProv'";
  $result=mysql_query($sql);
  $row=mysql_fetch_array($result);
 }

?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "NombProv",  "Nombre, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "DirecProv",  "Direccion, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "EncProv",  "Encargado, $errorMsgJs[expresion]" );
$valid->addEmail ( "EmailProv", "" );
$valid->addLength ("ObsProv", "Observaciones, $errorMsgJs[length]");
print $valid->toHtml ();
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
<form name="form1" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
<table width="67%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
      <tr> 
        <th background="images/main-button-tileR1.jpg">DATOS DEL PROVEEDOR</th>
      </tr>
      <tr> 
        <td><blockquote> 
            <blockquote>
              <p>&nbsp;</p>
               <input name="IdProv" type="hidden" value="<?php echo $IdProv;?>">
              <p><strong>Nombre &nbsp;&nbsp;: </strong> &nbsp; 
                <input name="NombProv" type="text" size="50" maxlength="55" value="<?php echo @$row['NombProv']; ?>">
              </p>
              
            <p><strong>Direccion &nbsp;:</strong>&nbsp; 
              <input name="DirecProv" type="text" size="50" maxlength="55"  value="<?php echo @$row['DirecProv']; ?>">
              </p>
              
            <p><strong>Telefono 1 :</strong> 
              <input name="Fono1Prov" type="text" size="20" maxlength="20"  value="<?php echo @$row['Fono1Prov']; ?>">
              <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Telefono 
              2 :</strong> 
              <input name="Fono2Prov" type="text" size="20" maxlength="20"  value="<?php echo @$row['Fono2Prov']; ?>">
            </p>
            </blockquote>
          </blockquote>
          <blockquote> 
            <blockquote> 
              <p><strong>Encargado :</strong> 
                <input name="EncProv" type="text" size="50" maxlength="50"  value="<?php echo @$row['EncProv']; ?>">
              </p>
              <p><strong>E-mail &nbsp;&nbsp;:</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="EmailProv" type="text" size="40" maxlength="40"  value="<?php echo @$row['EmailProv']; ?>">
              </p>
              <p><strong>Observaciones :</strong> 
                
              <textarea name="ObsProv" cols="40"><?php echo @$row['ObsProv']; ?></textarea>
              </p>
              <p>&nbsp; </p>
            </blockquote>
          </blockquote></td>
      </tr>
    </table>
<p> 
<input type="submit" name="GUARDPROV" value="GUARDAR" <?php print $valid->onSubmit() ?>>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
<input type="submit" name="RETORNAR" value="RETORNAR">
</p>
</form>