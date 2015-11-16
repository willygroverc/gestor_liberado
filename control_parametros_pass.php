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
if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php");}
if (isset($_REQUEST['GUARDATOS'])){	
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if ($row['id_parametro']=="")
	{	
		$sql = "INSERT INTO control_parametros (pass_longitud, pass_secuencial,pass_repetidos,pass_historial,pass_cad_a,pass_cad_b,".
		"pass_cad_t,pass_cad_c,pass_cad_date,pass_cad_ing,pass_reset) ".
		"VALUES ('$_REQUEST[pass_longitud]', '$_REQUEST[pass_secuencial]','$_REQUEST[pass_repetidos]','$_REQUEST[pass_historial]','$_REQUEST[pass_cad_a]','$_REQUEST[pass_cad_b]','$_REQUEST[pass_cad_t]',".
		"'$_REQUEST[pass_cad_c]','$_REQUEST[pass_cad_date]','$_REQUEST[pass_cad_ing]','$_REQUEST[pass_reset]')";
                //print_r($sql);exit;
                mysql_query($sql);
		header("location: menu_parametros.php?Naveg=Menu Parametros");
	}	   
   	else
	{	
		$sql = "UPDATE control_parametros SET pass_longitud='$_REQUEST[pass_longitud]',pass_secuencial='$_REQUEST[pass_secuencial]',".
		"pass_repetidos='$_REQUEST[pass_repetidos]', pass_historial='$_REQUEST[pass_historial]',pass_cad_a='$_REQUEST[pass_cad_a]',pass_cad_b='$_REQUEST[pass_cad_b]',".
		"pass_cad_t='$_REQUEST[pass_cad_t]',pass_cad_c='$_REQUEST[pass_cad_c]',pass_cad_date='$_REQUEST[pass_cad_date]',".
		"pass_cad_ing='$_REQUEST[pass_cad_ing]',pass_reset='$_REQUEST[pass_reset]'";   
                //print_r($sql);exit;
    	if (mysql_query($sql)){header("location: menu_parametros.php");}
		else {$msg="OCURRIO UN ERROR EN MIENTRAS SE ACTUALIZABA LOS DATOS";}
	}
}

include ("top.php"); 
$sql = "SELECT * FROM control_parametros";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "nombre", "Nombre, $errorMsgJs[empty]" );
$valid->addExists ( "direccion", "Direccion, $errorMsgJs[empty]" );
$valid->addExists ( "telefono", "Telefono, $errorMsgJs[empty]" );
$valid->addExists ( "ruc", "Nro. RUC, $errorMsgJs[empty]" );
$valid->addExists ( "web", "Web, $errorMsgJs[empty]" );
$valid->addEmail ( "mail_institucion", "Email del Administrador, ");
$valid->addIsTextNormal ( "fax",  "Fax, $errorMsgJs[expresion]" );
$valid->addIsNumber ( "intentos_cont",  "Cantidad de intentos CONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
$valid->addIsNumber ( "intentos_disc",  "Cantidad de intentos DISONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_longitud",  "Longitud del Password, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_secuencial",  "Longitud de caracteres consecutivos del Password, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_repetidos",  "Numero de contrase�as o password's repetidos, $errorMsgJs[number]" );
$valid->addFunction ( "validate", "" );
echo $valid->toHtml ();
?>
<script>
<!--
function validate () {
	var form=document.form1;
	var msg="\n\nMensaje generado por GesTor F1.";
	if (form.pass_longitud.value < 6) {
		alert ("Longitud del Password debe ser mayor o igual a 6." + msg);
		form.pass_longitud.focus();
		return false;				
	}
	if (form.pass_longitud.value <= form.pass_secuencial.value) {
		alert ("Longitud del Password debe ser mayor a la Longitud de caracteres consecutivos." + msg);
		return false;				
	}
	return true;	
}
-->
</script>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onKeyPress="return Form()">
  <table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif">PARAMETROS DE PASSWORD</font></th>
    </tr>
    <tr> 
      <td height="169"> 
        <table width="100%">
          <tr> 
            <td width="82%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Longitud 
                del Password</font></div></td>
            <td width="18%"><input name="pass_longitud" type="text" id="pass_longitud"  value="<?php echo $row['pass_longitud']; ?>" size="3" maxlength="2"></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="82%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Longitud 
                de caracteres consecutivos del Password (0 para no verificar) 
                </font></div></td>
            <td width="18%"><input name="pass_secuencial" type="text" id="pass_secuencial"  value="<?php echo $row['pass_secuencial']; ?>" size="3" maxlength="2"></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                N�mero de veces que puede repetirse un Password ( 0 = Ninguno) 
                <br>
                </font></div></td>
            <td width="18%"><input name="pass_repetidos" type="text" id="pass_repetidos"  value="<?php echo $row['pass_repetidos']; ?>" size="3" maxlength="2"></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">N&uacute;mero 
                de passwords historicos no repetidos</font></div></td>
            <td><input name="pass_historial" type="text" size="3" maxlength="2" value="<?php echo $row['pass_historial'];?>"></td>
          </tr>
          <tr> 
            <td width="58%"><div align="right"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo 
                de Caducidad del Password Usuario : </font></div></td>
            <td width="24%"><font size="2" face="Arial, Helvetica, sans-serif">Administrador</font></td>
            <td><select name="pass_cad_a">
                <option value="15" <?php if($row['pass_cad_a']=="15"){echo "selected";}?>>15 
                dias</option>
                <option value="30" <?php if($row['pass_cad_a']=="30"){echo "selected";}?>>30 
                dias</option>
                <option value="45" <?php if($row['pass_cad_a']=="45"){echo "selected";}?>>45 
                dias</option>
                <option value="60" <?php if($row['pass_cad_a']=="60"){echo "selected";}?>>60 
                dias</option>
                <option value="75" <?php if($row['pass_cad_a']=="75"){echo "selected";}?>>75 
                dias</option>
                <option value="200" <?php if($row['pass_cad_a']=="200"){echo "selected";}?>>200 
                dias</option>
              </select> </td>
          </tr>
          <tr> 
            <td><div align="center"></div></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Backup</font></td>
            <td><select name="pass_cad_b">
                <option value="15" <?php if($row['pass_cad_b']=="15"){echo "selected";}?>>15 
                dias</option>
                <option value="30" <?php if($row['pass_cad_b']=="30"){echo "selected";}?>>30 
                dias</option>
                <option value="45" <?php if($row['pass_cad_b']=="45"){echo "selected";}?>>45 
                dias</option>
                <option value="60" <?php if($row['pass_cad_b']=="60"){echo "selected";}?>>60 
                dias</option>
                <option value="75" <?php if($row['pass_cad_b']=="75"){echo "selected";}?>>75 
                dias</option>
                <option value="200" <?php if($row['pass_cad_b']=="200"){echo "selected";}?>>200 
                dias</option>
              </select></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Tecnico</font></td>
            <td><select name="pass_cad_t">
                <option value="15" <?php if($row['pass_cad_t']=="15"){echo "selected";}?>>15 
                dias</option>
                <option value="30" <?php if($row['pass_cad_t']=="30"){echo "selected";}?>>30 
                dias</option>
                <option value="45" <?php if($row['pass_cad_t']=="45"){echo "selected";}?>>45 
                dias</option>
                <option value="60" <?php if($row['pass_cad_t']=="60"){echo "selected";}?>>60 
                dias</option>
                <option value="75" <?php if($row['pass_cad_t']=="75"){echo "selected";}?>>75 
                dias</option>
                <option value="200" <?php if($row['pass_cad_t']=="200"){echo "selected";}?>>200 
                dias</option>
              </select></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Cliente</font></td>
            <td><select name="pass_cad_c">
                <option value="15" <?php if($row['pass_cad_c']=="15"){echo "selected";}?>>15 
                dias</option>
                <option value="30" <?php if($row['pass_cad_c']=="30"){echo "selected";}?>>30 
                dias</option>
                <option value="45" <?php if($row['pass_cad_c']=="45"){echo "selected";}?>>45 
                dias</option>
                <option value="60" <?php if($row['pass_cad_c']=="60"){echo "selected";}?>>60 
                dias</option>
                <option value="75" <?php if($row['pass_cad_c']=="75"){echo "selected";}?>>75 
                dias</option>
                <option value="200" <?php if($row['pass_cad_c']=="200"){echo "selected";}?>>200 
                dias</option>
              </select></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                de dias antes para alertar al usuarios de la caducidad de su password</font></div></td>
            <td><input name="pass_cad_date" type="text" size="3" maxlength="2" value="<?php echo $row['pass_cad_date'];?>"> 
              <font size="2" face="Arial, Helvetica, sans-serif">dias</font> </td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Ingresos 
                de gracias despues de ser caducada la contrase&ntilde;a</font></div></td>
            <td><select name="pass_cad_ing">
                <option value="3" <?php if($row['pass_cad_ing']=="3"){echo "selected";}?>>3 
                Ingresos</option>
                <option value="5" <?php if($row['pass_cad_ing']=="5"){echo "selected";}?>>5 
                Ingresos</option>
              </select></td>
          </tr>
          <tr> 
            <td colspan="2"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Ingresos 
                de gracias despues de ser asignada por primera vez el password 
                o a ver sido cambiada por el Administrador</font></div></td>
            <td><select name="pass_reset">
                <option value="3" <?php if($row['pass_reset']=="3"){echo "selected";}?>>3 
                Ingresos</option>
                <option value="5" <?php if($row['pass_reset']=="5"){echo "selected";}?>>5 
                Ingresos</option>
              </select></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td height="26"><div align="center"><br>
                <input type="submit" name="GUARDATOS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              <div align="left"> </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<script language="JavaScript">
		<!-- 
		<?php 
		if (isset($msg)){
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>