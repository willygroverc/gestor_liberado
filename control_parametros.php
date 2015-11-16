<?php
if ($RETORNAR){header("location: seguridad_opt.php?Naveg=Seguridad");}
if (isset($Subir))
{$extension = explode(".",$archivo_name); 
 $num = count($extension)-1; 
 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
 {  $origen=getimagesize("$archivo");
    $Ancho=$origen[0];
	$Alto=$origen[1];
	if ($Ancho <="150" AND $Alto <= "70")
	{$arch_nomb="imagen_ins.jpg";
	copy($archivo,"images/".$arch_nomb);
	$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE, PARA PODER VISUALIZAR LA NUEVA IMAGEN, CIERRE SU NAVEGADOR Y ABRA UNO NUEVO";
	}
	else {$msg="SU IMAGEN ES DE ".$Ancho." x ".$Alto." pixeles, EL TAMANO DE LA IMAGEN NO DEBE SER MAYOR A 150 x 70 pixeles";}
 }
 else {$msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif o .jpg";}
} 

if (isset($Subir2))
{$extension = explode(".",$archivo2_name); 
 $num = count($extension)-1; 
 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
 {  $origen=getimagesize("$archivo2");
	$arch_nomb="fondo.jpg";
	copy($archivo2,"images/".$arch_nomb);
	$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE, PARA PODER VISUALIZAR LA NUEVA IMAGEN, CIERRE SU NAVEGADOR Y ABRA UNO NUEVO";
}
 else {$msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif o .jpg";}
} 

if ($GUARDATOS) 
{	
  	include ("conexion.php");
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	if ($row[id_parametro]=="")
	{$sql = "INSERT INTO control_parametros (nombre,direccion,telefono,ruc,mail,fax,cant_ordenes,tmp_conf,ord_abiertas,tmp_ord_abier,tam_archivo,intentos_cont,intentos_disc, pass_longitud, pass_secuencial,pass_repetidos,num_ord_pag,conf_mail,agencia, conf_sms, telefono_movil, id_dat_tel_movil, mail_institucion, web, conformidad , datos_gral) ".
	"VALUES ('$nombre','$direccion','$telefono','$ruc','$mail','$fax','$cant_ordenes','$tmp_conf','$ord_abiertas','$tmp_ord_abier','$tam_archivo','$intentos_cont','$intentos_disc', '$pass_longitud', '$pass_secuencial','$pass_repetidos','$num_ord_pag', '$conf_mail','$agencia', $conf_sms, '$telefono_movil', '$id_dat_tel_movil', '$mail_institucion', '$web', '$conformidad', '$datos_gral')";
	mysql_db_query($db,$sql,$link);
	header("location: lista.php?Naveg=Seguridad");
	
	}	   
   	else
	{$sql = "UPDATE control_parametros SET nombre='$nombre',direccion='$direccion',telefono='$telefono',ruc='$ruc',mail='$mail',fax='$fax',cant_ordenes='$cant_ordenes',tmp_conf='$tmp_conf',ord_abiertas='$ord_abiertas'".
   	",tmp_ord_abier='$tmp_ord_abier',tam_archivo='$tam_archivo',intentos_cont='$intentos_cont',intentos_disc='$intentos_disc', pass_longitud='$pass_longitud', pass_secuencial='$pass_secuencial', pass_repetidos='$pass_repetidos', num_ord_pag='$num_ord_pag', conf_mail='$conf_mail',agencia='$agencia', conf_sms=$conf_sms, telefono_movil='$telefono_movil', id_dat_tel_movil='$id_dat_tel_movil', mail_institucion='$mail_institucion', web='$web', conformidad='$conformidad', datos_gral='$datos_gral'";   
  
    if (mysql_db_query($db,$sql,$link)){header("location: lista.php?Naveg=Ordenes de Trabajo");}
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
$valid->addExists ( "nombre", "Nombre, $errorMsgJs[empty]" );
$valid->addExists ( "direccion", "Direccion, $errorMsgJs[empty]" );
$valid->addExists ( "telefono", "Telefono, $errorMsgJs[empty]" );
$valid->addExists ( "ruc", "Nro. RUC, $errorMsgJs[empty]" );
$valid->addExists ( "web", "Web, $errorMsgJs[empty]" );
//$valid->addExists ( "email", "Email, $errorMsgJs[empty]" );
$valid->addEmail ( "mail_institucion", "Email del Administrador, ");
$valid->addEmail ( "mail", "Email de la Institucion, ");
$valid->addIsTextNormal ( "fax",  "Fax, $errorMsgJs[expresion]" );

$valid->addIsNumber ( "cant_ordenes",  "Cantidad maxima permitida de ordenes de trabajo sin conformidad, $errorMsgJs[number]" );
$valid->addIsNumber ( "tmp_conf",  "Tiempo maximo permitido para colocar conformidad a una orden de trabajo, $errorMsgJs[number]" );
$valid->addIsNumber ( "ord_abiertas",  "Cantidad maxima permitida de ordenes de trabajo que el TECNICO o ADMINISTRADOR puede tener abiertas sin solucion, $errorMsgJs[number]" );
$valid->addIsNumber ( "tmp_ord_abier",  "Tiempo maximo permitido de ordenes de trabajo que el TECNICO o ADMINISTRADOR puede tener abiertas sin solucion, $errorMsgJs[number]" );
$valid->addIsNumber ( "intentos_cont",  "Cantidad de intentos CONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
$valid->addIsNumber ( "intentos_disc",  "Cantidad de intentos DISONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_longitud",  "Longitud del Password, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_secuencial",  "Longitud de caracteres consecutivos del Password, $errorMsgJs[number]" );
$valid->addIsNumber ( "pass_repetidos",  "Numero de contrasenas o password's repetidos, $errorMsgJs[number]" );
$valid->addFunction ( "validate", "" );
$valid->addFunction ( "verificarMovil", "" );
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
      <th><font size="2" face="Arial, Helvetica, sans-serif">DATOS DE LA INSTITUCION</font></th>
    </tr>
    <tr> 
      <td>
        <table width="100%">
          <tr> 
            <td width="5%">&nbsp;</td>
            <td width="26%"><font size="2" face="Arial, Helvetica, sans-serif">Razon 
              Social o Nombre : </font> </td>
            <td width="69%"> <input name="nombre" type="text" value="<?php echo $row[nombre]; ?>" size="40" maxlength="40"> 
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Direccion : 
              </font> </td>
            <td> <input name="direccion" type="text" value="<?php echo $row[direccion]; ?>" size="60" maxlength="70"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Telefonos :</font> 
            </td>
            <td> <input name="telefono" type="text" value="<?php echo $row[telefono]; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Nro. Ruc :&nbsp;</font> 
            </td>
            <td> <input name="ruc" type="text" value="<?php echo $row[ruc]; ?>" maxlength="15"> 
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Web :&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            </td>
            <td><input name="web" type="text" id="web" value="<?php echo $row[web]; ?>" size="50" maxlength="45"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">E-mail :&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            </td>
            <td> <input name="mail_institucion" type="text" id="mail_institucion" value="<?php echo $row[mail_institucion]; ?>" size="50" maxlength="45"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Fax :</font> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td> <input name="fax" type="text" value="<?php echo $row[fax]; ?>" maxlength="30"></td>
          </tr>
          <tr> 
            <td height="40">&nbsp;</td>
            <td colspan="2"><strong><font size="2">Imagen Institucional </font></strong><font size="2"><br>
              (<strong>Tipo:</strong> .jpg , .gif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Dimensiones</strong>: 
              150 x 70 pixeles) </font></td>
          </tr>
		  <tr> 
            <td height="26">&nbsp;</td>
            <td colspan="2"><input name="archivo" type="file" size="60" value="<?php print $archivo ?>">
              &nbsp; 
              <input type="submit" name="Subir" value="SUBIR">
              <br>
              <br>
            </td>
          </tr>
		  <tr>
		<td height="40">&nbsp;</td>
            <td colspan="2"><strong><font size="2">Imagen de Fondo</font></strong><font size="2"><br>
              (<strong>Tipo:</strong> .jpg , .gif ) </font></td>
          </tr>
		  <tr> 
            <td height="26">&nbsp;</td>
            <td colspan="2"><input name="archivo2" type="file" id="archivo2" value="<?php print $archivo2 ?>" size="60">
              &nbsp; 
              <input name="Subir2" type="submit" id="Subir2" value="SUBIR">
              <br>
              <br>
            </td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <th colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">DATOS 
              DEL ADMINISTRADOR DE MESA DE AYUDA</font></th>
          </tr>
          <tr> 
            <td width="5%">&nbsp;</td>
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">Telefono 
              Movil:</font> </td>
            <td width="65%"> 
              <input name="telefono_movil" type="text" id="telefono_movil3" value="<?php echo $row[telefono_movil]; ?>" size="10" maxlength="8"> 
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
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td height="21" colspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PARAMETROS 
                DE CONTROL</font></strong></div></td>
          </tr>
          <tr> 
            <td width="75%" height="24"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><br>
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
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tamano 
                del Archivo Adjunto</font> </div></td>
            <td width="25%">
			<select name="tam_archivo" id="select20">
                <?php for($i=1;$i<=7;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[tam_archivo]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              &nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Mb. 
              </strong></font></td>
          </tr>
        </table>		
        <br>
		
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                de intentos fallidos CONTINUOS de ingreso al sistema</font></div></td>
            <td width="25%"><input name="intentos_cont" type="text" size="5" maxlength="2"  value="<?php echo $row[intentos_cont]; ?>"></td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                de intentos fallidos DISCONTINUOS de ingreso al sistema</font></div></td>
            <td width="25%"><input name="intentos_disc" type="text" size="5" maxlength="2"  value="<?php echo $row[intentos_disc]; ?>"></td>
          </tr>
        </table> 
        <br>
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Longitud 
                del Password</font></div></td>
            <td width="25%"><input name="pass_longitud" type="text" id="pass_longitud"  value="<?php echo $row[pass_longitud]; ?>" size="5" maxlength="2"></td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Longitud 
                de caracteres consecutivos del Password<br>
                (0 para no verificar) </font></div></td>
            <td width="25%"><input name="pass_secuencial" type="text" id="pass_secuencial"  value="<?php echo $row[pass_secuencial]; ?>" size="5" maxlength="2"></td>
          </tr>
		</table>
		<br>
		        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Numero de veces que puede repetirse un Password<br>
                ( 0 = Ninguno)
				<br>
                 </font></div></td>
            <td width="25%"><input name="pass_repetidos" type="text" id="pass_repetidos"  value="<?php echo $row[pass_repetidos]; ?>" size="5" maxlength="2"></td>
          </tr>
		</table>
		<br>
		        <table width="100%">
          <tr> 
            <td width="75%" height="26"> 
              <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Numero de registros por pagina<br>
                 </font></div></td>
            <td width="25%"> 
              <select name="num_ord_pag" id="select20">
                <?php for($i=1;$i<=5;$i++)
					  { $i1=$i*10;
    	              echo "<option value=\"$i1\""; if($row[num_ord_pag]=="$i1") echo "selected"; echo">$i1</option>";
					  }
			   ?>
              </select>
            </td>
          </tr>
		</table>
        <table width="100%" cellpadding="4" cellspacing="4">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Notificar por correo electronico<br>
                (0 Ninguno, 1 AMA, 2 Tecnico, 3 Ambos) <br>
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
              (0 Ninguno, 1 AMA, 2 Tecnico, 3 Ambos) <br>
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
                (0 Ninguno, 1 Solucion, 2 Conformidad, 3 Ambos) </font></p>
              </td>
            <td><select name="conformidad" id="conformidad">
                <?php for($i=0;$i<=3;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row[conformidad]=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select></td>
          </tr>
          <tr>
            <td height="19"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> Uso de Agencias</font></div></td>
            <td><input type="checkbox" name="agencia" value="si" <?php if ($row[agencia]=="si") {echo "checked";} ?>></td>
          </tr>
          <tr>
            <td height="24"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><font size="2">Ver datos generales en Reportes</font> </font></div></td>
            <td><input type="checkbox" name="datos_gral" value="1" <?php if ($row[datos_gral]=="1") {echo "checked";} ?>></td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <tr> 
            <td height="44"> <div align="center">
                <input type="submit" name="GUARDATOS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
            </div></td>
            <td><div align="left"> 
                <!--input type="submit" name="RETORNAR" value="RETORNAR"-->
              </div></td>
          </tr>
        </table>        
      </td>
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