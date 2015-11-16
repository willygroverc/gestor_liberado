<?php 

require('conexion.php');
if (isset($RETORNAR)){
	if ($origen=="titular") header("location: lista_titulares.php");
	else header("location: lista.php");
	}

if (isset($otro)){
   
    $sql = "UPDATE titular SET nombre='$nombre',ciudad='$ciudad',apaterno='$apaterno',".
   "amaterno='$amaterno',acasada='$acasada',email='$email',entidad='$entidad',area='$area',especialidad='$especialidad',cargo='$cargo',telf='$telf',externo='$externo',direccion='$direccion'".
    "WHERE ci_ruc='$ci_ruc'";   
    if (mysql_db_query($db,$sql,$link)){
  		header("location: lista_titulares.php");
	}
	else {		
		$msg="OCURRIO UN ERROR EN LA MIENTRAS SE ACTUALIZABA ";//.mysql_error();
	}
}

include("top.php");
$sql="SELECT * from titular WHERE ci_ruc='$ci_ruc'";
$result=mysql_db_query($db,$sql,$link);
$row_=mysql_fetch_array($result);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNumber ( "ci_ruc",  "CI/RUC, $errorMsgJs[number]" );
$valid->addEmail ( "email",  "" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
</script>

<font color="#FF0000" face="Arial, Helvetica, sans-serif"><strong><?php //echo $msg;?></strong></font>
<form name="form1" method="post" action="<?php echo $PHP_SELF; ?>" onKeyPress="return Form()">
  <table width="95%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th align="center" colspan="8">CLIENTE / TITULAR</th>
    </tr>
    <tr> 
      <td align="center" colspan="8">CI&nbsp;/&nbsp;RUC: 
        <input name="ci_ruc" type="text" value="<?php echo $row_['ci_ruc'];?>" size="20"> 
    
    <tr> 
      <td width="8%" align="right">NOMBRES:</td>
      <td width="13%"> <input name="nombre" type="text" value="<?php echo $row_['nombre'];?>" size="20"></td>
      <td width="10%" align="right">AP.PATERNO:</td>
      <td width="13%"><input name="apaterno" type="text" value="<?php echo $row_['apaterno'];?>" size="20"></td>
      <td width="11%" align="right"> AP.MATERNO:</td>
      <td width="13%"> <input name="amaterno" type="text" value="<?php echo $row_['amaterno'];?>" size="20"></td>
      <td width="17%"><div align="right">AP. CASADA:</div></td>
      <td width="15%"><input name="acasada" type="text" value="<?php echo $row_['acasada'];?>" size="20"></td>
    </tr>
    <tr> 
      <td align="right">E-MAIL: </td>
      <td> <input name="email" type="text" value="<?php echo $row_['email'];?>" size="20"></td>
      <td align="right">ENTIDAD: </td>
      <td> <input name="entidad" type="text" value="<?php echo $row_['entidad'];?>" size="20"></td>
      <td align="right">AREA:</td>
      <td><input name="area" type="text" value="<?php echo $row_['area'];?>" size="20"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">CARGO:</td>
      <td><input name="cargo" type="text" value="<?php echo $row_['cargo'];?>" size="20"></td>
      <td align="right">TELEFONO:</td>
      <td><input name="telf" type="text" value="<?php echo $row_['telf'];?>" size="20"></td>
      <td align="right">FAX:</td>
      <td><input name="especialidad" type="text" value="<?php echo $row_['especialidad'];?>" size="20"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td align="right">EXT:</td>
      <td><input name="externo" type="text" value="<?php echo $row_['externo'];?>" size="20"></td>
      <td align="right">CIUDAD:</td>
      <td><input name="ciudad" type="text" value="<?php echo $row_['ciudad'];?>" size="20"></td>
      <td align="right"> DIRECCION:</td>
      <td><input name="direccion" type="text" value="<?php echo $row_['direccion'];?>" size="20"></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr> 
      <td colspan="8" align="center"> <input name="otro" type="submit" value="GUARDAR" <?php print $valid->onSubmit() ?>> 
        &nbsp;&nbsp;&nbsp; <input name="RETORNAR" type="submit" value="RETORNAR" > 
        <input name="origen" type="hidden" value="<?php print $origen; ?>"> </td>
    </tr>
  </table>
</form>
