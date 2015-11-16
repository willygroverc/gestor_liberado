<?php
if ($RETORNAR){header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");}
if ($GUARDATOS) 
{	
  	include ("conexion.php");
	if($tecni_segui==1)
	{	$updat = "UPDATE users SET ver_seg = '1' WHERE tipo2_usr = 'T'";
		mysql_db_query($db,$updat,$link);	}
	else
	{	$updat = "UPDATE users SET ver_seg = '0' WHERE tipo2_usr = 'T'";
		mysql_db_query($db,$updat,$link);	}
		
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	if ($row[id_parametro]=="")
	{$sql = "INSERT INTO control_parametros (telefono_movil,id_dat_tel_movil,mail,cant_ordenes,tmp_conf,ord_abiertas,tmp_ord_abier,conf_mail,conf_sms,conformidad,tecni_solo,segui_ver,seguimiento,rapido) ".
	"VALUES ('$telefono_movil','$id_dat_tel_movil','$mail','$cant_ordenes','$tmp_conf','$ord_abiertas','$tmp_ord_abier','$conf_mail','$conf_sms','$conformidad','$tecni_solo','tecni_segui','$seguimiento','$rapido')";
	mysql_db_query($db,$sql,$link);
	header("location: menu_parametros.php?Naveg=Menu Parametros");
	
	}	   
   	else
	{$sql = "UPDATE control_parametros SET telefono_movil='$telefono_movil', id_dat_tel_movil='$id_dat_tel_movil',mail='$mail',".
	"cant_ordenes='$cant_ordenes',tmp_conf='$tmp_conf',ord_abiertas='$ord_abiertas',tmp_ord_abier='$tmp_ord_abier',".
	"conf_mail='$conf_mail',conf_sms='$conf_sms',conformidad='$conformidad',tecni_solo='$tecni_solo',segui_ver='$tecni_segui',seguimiento='$seguimiento',rapido='$rapido'";   
  
    if (mysql_db_query($db,$sql,$link)){header("location: menu_parametros.php?Naveg=Menu Parametros");}
	else {$msg="OCURRIO UN ERROR EN MIENTRAS SE ACTUALIZABA LOS DATOS";}}
}

include ("top.php"); 
$sql = "SELECT * FROM control_parametros";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);
?> 
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addEmail ( "mail", "Email del Administrador, ");
$valid->addIsNumber ( "cant_ordenes",  "Cantidad maxima permitida de ordenes de trabajo sin conformidad, $errorMsgJs[number]" );
$valid->addIsNumber ( "tmp_conf",  "Tiempo maximo permitido para colocar conformidad a una orden de trabajo, $errorMsgJs[number]" );
$valid->addIsNumber ( "ord_abiertas",  "Cantidad maxima permitida de ordenes de trabajo que el TECNICO o ADMINISTRADOR puede tener abiertas sin solucion, $errorMsgJs[number]" );
$valid->addIsNumber ( "tmp_ord_abier",  "Tiempo maximo permitido de ordenes de trabajo que el TECNICO o ADMINISTRADOR puede tener abiertas sin solucion, $errorMsgJs[number]" );
$valid->addFunction ( "verificarMovil", "" );
echo $valid->toHtml ();
?>
<script>
<!--
function verificarMovil () {
	var form=document.form1;
	var msg="\n \n Mensaje generado por GesTor F1.";
	if (form.telefono_movil.value.length > 0) {
		if (form.telefono_movil.value.search(new RegExp("^([0-9])+$","g"))<0) {
			alert ("Telefono Movil, debe ser un valor numerico." + msg);
			return ( false );
		}
		if (form.telefono_movil.value.length != 8) {
			alert ("Telefono Movil, debe ser igual a 8 caracteres." + msg);
			return false;
		}
		if (form.id_dat_tel_movil.value == 0) {
			alert ("Telefono Movil, debe seleccionar una opcion." + msg);
			return false;
		}
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
<form name="form1" method="post" action="<?php echo $PHP_SELF?>" enctype="multipart/form-data" onKeyPress="return Form()">
  <table width="65%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
      <th background="images/main-button-tileR1.jpg" height="22"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PARAMETROS 
          DE ORDENES DE PROCESOS</strong></font></div></th>
  </tr>
    <tr> 
      <td> 
        <table width="100%">
          <tr> 
            <th colspan="3" background="images/main-button-tileR1.jpg" height="22"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Datos 
                del Administrador :</font></div></th>
          </tr>
          <tr> 
            <td width="5%">&nbsp;</td>
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">Telefono 
              Movil:</font> </td>
            <td width="65%"> <input name="telefono_movil" type="text" id="telefono_movil3" value="<?php echo $row[telefono_movil]; ?>" size="10" maxlength="8"> 
              <font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="id_dat_tel_movil" id="select2">
                <?php
					echo "<option value=\"0\"></option>";
					$sql2 = "SELECT id_dat_tel_movil, nombre FROM dat_tel_movil ORDER BY nombre ASC";
 			  		$result2=mysql_db_query($db,$sql2,$link);
			  		while ($row2=mysql_fetch_array($result2)) {
						if ($row[id_dat_tel_movil]==$row2[id_dat_tel_movil])
							echo "<option value=\"$row2[id_dat_tel_movil]\" selected>$row2[nombre]</option>";
						else
							echo "<option value=\"$row2[id_dat_tel_movil]\">$row2[nombre]</option>";
					}
			?>
              </select>
              </font> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">E-mail :&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            </td>
            <td> <input name="mail" type="text" id="mail" value="<?php echo $row[mail]; ?>" size="50" maxlength="45"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td colspan="2" background="images/main-button-tileR1.jpg" height="22"> <div align="left"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;Parametros 
                de Control : </strong></font></div></td>
          </tr>
          <tr> 
            <td width="75%" height="43"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Cantidad maxima permitida de ordenes de trabajo sin conformidad</font></div></td>
            <td width="25%"><br> <input name="cant_ordenes" type="text" size="5" maxlength="2"  value="<?php echo $row[cant_ordenes]; ?>"></td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td width="75%" height="24"> 
              <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo 
                maximo permitido para colocar conformidad a una orden de trabajo</font></div></td>
            <td width="25%"><input name="tmp_conf" type="text" size="5" maxlength="3"  value="<?php echo $row[tmp_conf]; ?>"> 
              &nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">Dias</font></strong></td>
          </tr>
        </table>
        <br> <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                maxima permitida de ordenes de trabajo que el TECNICO o ADMINISTRADOR 
                puede tener abiertas sin solucion</font></div></td>
            <td width="25%"><input name="ord_abiertas" type="text" size="5" maxlength="2"  value="<?php echo $row[ord_abiertas]; ?>"> 
              &nbsp;<strong></strong></td>
	  </tr>
        </table>
			<br>
        <table width="100%">
          <tr> 
            <td width="75%" height="40">
<div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo 
                maximo permitido de ordenes de trabajo que el TECNICO o ADMINISTRADOR 
                puede tener abiertas sin solucion</font></div></td>
            <td width="25%"><input name="tmp_ord_abier" type="text" size="5" maxlength="3"  value="<?php echo $row[tmp_ord_abier]; ?>"> 
              &nbsp;<strong><font size="2" face="Arial, Helvetica, sans-serif">Dias</font></strong></td>
          </tr>
        </table>
        <br>
        <table width="100%" cellpadding="4" cellspacing="4">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Notificar por correo electr&oacute;nico<br>
                (0 Ninguno, 1 AMA, 2 T&eacute;cnico, 3 Ambos) <br>
                </font></div></td>
            <td width="25%"><select name="conf_mail" id="conf_mail">
                <?php for($i=0;$i<=3;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[conf_mail]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select></td>
          </tr>
          <tr> 
            <td height="19" align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
              Notificar por SMS<br>
              (0 Ninguno, 1 AMA, 2 T&eacute;cnico, 3 Ambos) <br>
              </font></td>
            <td><select name="conf_sms" id="conf_sms">
                <?php for($i=0;$i<=3;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[conf_sms]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select></td>
          </tr>
          <tr> 
            <td height="19" align="center"><p><font size="2" face="Arial, Helvetica, sans-serif">Notificar 
                al Cliente por Correo Electronico<br>
                (0 Ninguno, 1 Solucion, 2 Conformidad, 3 Ambos) </font></p></td>
            <td><select name="conformidad" id="conformidad">
                <?php for($i=0;$i<=3;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[conformidad]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select></td>
          </tr>
		  <tr> 
            <td height="19" align="center"><p><font size="2" face="Arial, Helvetica, sans-serif">Tecnico puede realizar seguimientos </font></p></td>
            <td><input name="tecni_segui" type="checkbox" id="tecni_segui" value="1" <?php if($row[segui_ver]=="1"){echo "checked";}?> /></td>
		  </tr>
          <tr> 
            <td height="19" align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tecnico 
              visualiza solo sus Requerimientos y Asignaciones</font></td>
            <td><input type="checkbox" name="tecni_solo" value="1" <?php if($row[tecni_solo]=="1"){echo "checked";}?>> </td>
          </tr>
          <tr> 
            <td height="19" align="center"><font size="2" face="Arial, Helvetica, sans-serif">Notificar por Correo Electronico el seguimiento de una Orden de Trabajo <br> 
              (0 Ninguno, 1 AMA, 2 Cliente, 3 Tecnico, 4 Todos)</font></td>
            <td><select name="seguimiento" id="seguimiento">
                <?php for($i=0;$i<=4;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[seguimiento]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select></td>
          </tr>
          <tr>
            <td height="19" align="center"><font size="2" face="Arial, Helvetica, sans-serif"> Orden de Trabajo Rapida</font></td>
            <td><input type="checkbox" name="rapido" value="1" <?php if($row[rapido]=="1"){echo "checked";}?>> </td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td><div align="center"> 
                <input type="submit" name="GUARDATOS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="RETORNAR" value="RETORNAR">
              </div>
              <div align="left"> </div></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
<?php include ("top_.php"); ?>
<script language="JavaScript">
		<!-- 
		<?php 
		if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>