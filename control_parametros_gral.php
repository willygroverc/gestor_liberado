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
if (isset($_REQUEST['RETORNAR'])){header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");}
if (isset($_REQUEST['Subir']))
{$extension = explode(".",$_FILES['archivo']['name']); 
 $num = count($extension)-1; 
 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
 {  $archivo=$_FILES['archivo']['tmp_name'];
     $origen=getimagesize("$archivo");
    $Ancho=$origen[0];
	$Alto=$origen[1];
	if ($Ancho <="150" AND $Alto <= "70")
	{$arch_nomb="imagen_ins.jpg";
	copy($archivo,"images/".$arch_nomb);
	$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE, PARA PODER VISUALIZAR LA NUEVA IMAGEN, CIERRE SU NAVEGADOR Y ABRA UNO NUEVO";
	}
	else {$msg="SU IMAGEN ES DE ".$Ancho." x ".$Alto." p�xeles, EL TAMA�O DE LA IMAGEN NO DEBE SER MAYOR A 150 x 70 p�xeles";}
 }
 else {$msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif o .jpg";}
} 

if (isset($_REQUEST['Subir2']))
{$extension = explode(".",$_FILES['archivo2']['name']); 
 $num = count($extension)-1; 
 if($extension[$num]=="gif" OR $extension[$num]=="jpg")
 {  $archivo2=$_FILES['archivo2']['tmp_name'];
     $origen=getimagesize("$archivo2");
	$arch_nomb="fondo.jpg";
	copy($archivo2,"images/".$arch_nomb);
	$msg="SU IMAGEN FUE ENVIADA CORRECTAMENTE, PARA PODER VISUALIZAR LA NUEVA IMAGEN, CIERRE SU NAVEGADOR Y ABRA UNO NUEVO";
}
 else {$msg="LA IMAGEN SOLO DEBE SER DE EXTENSION .gif o .jpg";}
} 

if (isset($_REQUEST['GUARDATOS'])) {	
  	
   	$sql = "SELECT * FROM control_parametros";
	$result=mysql_query($sql);
	$row=mysql_fetch_array($result);
	if ($row['id_parametro']=="")
	{	
		$sql = "INSERT INTO control_parametros (nombre,direccion,telefono,ruc,web,mail_institucion,fax,tam_archivo,intentos_cont,".
		"intentos_disc,num_ord_pag,agencia,datos_gral) ".
		"VALUES ('$_REQUEST[nombre]','$_REQUEST[direccion]','$_REQUEST[telefono]','$_REQUEST[ruc]','$_REQUEST[web]','$_REQUEST[mail_institucion]','$_REQUEST[fax]','$_REQUEST[tam_archivo]','$_REQUEST[intentos_cont]',".
		"'$_REQUEST[intentos_disc]','$_REQUEST[num_ord_pag]','$_REQUEST[agencia]','$_REQUEST[datos_gral]')";
                print_r($sql);exit;
		mysql_query($sql);
		header("location: menu_parametros.php?Naveg=Menu Parametros");
	}	   
   	else
	{	
		$sql = "UPDATE control_parametros SET nombre='$_REQUEST[nombre]',direccion='$_REQUEST[direccion]',telefono='$_REQUEST[telefono]',ruc='$_REQUEST[ruc]',fax='$_REQUEST[fax]',".
		"web='$_REQUEST[web]',mail_institucion='$_REQUEST[mail_institucion]',tam_archivo='$_REQUEST[tam_archivo]',intentos_cont='$_REQUEST[intentos_cont]',".
		"intentos_disc='$_REQUEST[intentos_disc]',num_ord_pag='$_REQUEST[num_ord_pag]',agencia='$_REQUEST[agencia]',datos_gral='$_REQUEST[datos_gral]'";   
        //print_r($sql);exit;
    	if (mysql_query($sql)){header("location: menu_parametros.php?Naveg=Menu Parametros");}
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
$valid->addExists ( "ruc", "Nro. Nit, $errorMsgJs[empty]" );
$valid->addExists ( "web", "Web, $errorMsgJs[empty]" );
$valid->addEmail ( "mail_institucion", "Email del Administrador, ");
$valid->addIsTextNormal ( "fax",  "Fax, $errorMsgJs[expresion]" );
$valid->addIsNumber ( "intentos_cont",  "Cantidad de intentos CONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
$valid->addIsNumber ( "intentos_disc",  "Cantidad de intentos DISONTINUOS de ingreso al sistema, $errorMsgJs[number]" );
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
<form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data" onKeyPress="return Form()">
  <table width="65%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg" height="22"><font size="2" face="Arial, Helvetica, sans-serif">PARAMETROS GENERALES</font></th>
    </tr>
    <tr> 
      <td height="684"> <table width="100%">
          <tr bgcolor="#006699"> 
            <td colspan="3" background="images/main-button-tileR1.jpg" height="22"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;Datos 
              de la Institucion : </strong></font></td>
          </tr>
          <tr> 
            <td width="5%">&nbsp;</td>
            <td width="26%"><font size="2" face="Arial, Helvetica, sans-serif">Razon 
              Social o Nombre : </font> </td>
            <td width="69%"> <input name="nombre" type="text" value="<?php echo $row['nombre']; ?>" size="40" maxlength="40">  
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Direccion : 
              </font> </td>
            <td> <input name="direccion" type="text" value="<?php echo $row['direccion']; ?>" size="60" maxlength="70"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Telefonos :</font> 
            </td>
            <td> <input name="telefono" type="text" value="<?php echo $row['telefono']; ?>" size="50" maxlength="30"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Nro. Nit :&nbsp;</font> 
            </td>
            <td> <input name="ruc" type="text" value="<?php echo $row['ruc']; ?>" maxlength="15"> 
            </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Web :&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            </td>
            <td><input name="web" type="text" id="web" value="<?php echo $row['web']; ?>" size="50" maxlength="45"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">E-mail :&nbsp;</font>&nbsp;&nbsp;&nbsp;&nbsp; 
            </td>
            <td> <input name="mail_institucion" type="text" id="mail_institucion" value="<?php echo $row['mail_institucion']; ?>" size="50" maxlength="45"></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Fax :</font> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
            <td> <input name="fax" type="text" value="<?php echo $row['fax']; ?>" maxlength="30"></td>
          </tr>
          <tr> 
            <td height="32">&nbsp;</td>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR1.jpg" height="22" colspan="3"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Imagen 
              Institucional :</font></strong><font color="#FFFFFF" size="2">&nbsp;</font><font size="2"> 
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>
          </tr>
          <tr> 
            <td height="45">&nbsp;</td>
            <td colspan="2"> <font size="2">&nbsp;(<strong>Tipo:</strong> .jpg 
              , .gif &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Dimensiones</strong>: 
              150 x 70 p�xeles) </font><br> <input name="archivo" type="file" size="60" value="<?php print $archivo ?>"> 
              &nbsp; <input type="submit" name="Subir" value="SUBIR"> </td>
          </tr>
          <tr> 
            <td colspan="3">&nbsp;&nbsp;</td>
          </tr>
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR1.jpg" height="22" colspan="3"><strong><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp; 
              &nbsp;Imagen de Fondo : </font></strong> </td>
          </tr>
          <tr> 
            <td height="45">&nbsp;</td>
            <td colspan="2"><font size="2"> (<strong>Tipo:</strong> .jpg , .gif 
              ) </font><br> <input name="archivo2" type="file" id="archivo2" value="<?php print $archivo2 ?>" size="60"> 
              &nbsp; <input name="Subir2" type="submit" id="Subir2" value="SUBIR"> 
            </td>
          </tr>
          <tr> 
            <td height="21" colspan="3">&nbsp;</td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td colspan="2" background="images/main-button-tileR1.jpg" height="22"><strong><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">&nbsp; 
              &nbsp;Parametros de Control : </font></strong></td>
          </tr>
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tama&ntilde;o 
                del Archivo Adjunto</font> </div></td>
            <td width="25%"> <select name="tam_archivo" id="select20">
                <?php for($i=1;$i<=7;$i++)
					  {
    	              echo "<option value=\"$i\""; if($row['tam_archivo']=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select> &nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>Mb. 
              </strong></font></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                de intentos fallidos CONTINUOS de ingreso al sistema</font></div></td>
            <td width="25%"><input name="intentos_cont" type="text" size="5" maxlength="2"  value="<?php echo $row['intentos_cont']; ?>"></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="75%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Cantidad 
                de intentos fallidos DISCONTINUOS de ingreso al sistema</font></div></td>
            <td width="25%"><input name="intentos_disc" type="text" size="5" maxlength="2"  value="<?php echo $row['intentos_disc']; ?>"></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="75%" height="26"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                N�mero de registros por p&aacute;gina<br>
                </font></div></td>
            <td width="25%"> <select name="num_ord_pag" id="select20">
                <?php for($i=1;$i<=5;$i++)
					  { $i1=$i*10;
    	              echo "<option value=\"$i1\""; if($row['num_ord_pag']=="$i1") echo "selected"; echo">$i1</option>";
					  }
			   ?>
              </select> </td>
          </tr>
        </table>
        <table width="100%" cellpadding="4" cellspacing="4">
          <tr> 
            <td width="75%" height="19"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
                Uso de Agencias</font></div></td>
            <td width="25%"><input type="checkbox" name="agencia" value="si" <?php if ($row['agencia']=="si") {echo "checked";} ?>></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="75%"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><font size="2">Ver 
                datos generales en Reportes</font> </font> </div></td>
            <td width="25%"><div align="left"> 
                <input type="checkbox" name="datos_gral" value="1" <?php if ($row['datos_gral']=="1") {echo "checked";} ?>>
                <!--input type="submit" name="RETORNAR" value="RETORNAR"-->
              </div></td>
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
		if (isset($msg)) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
</script>