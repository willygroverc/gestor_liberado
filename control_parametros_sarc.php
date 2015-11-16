<?php
if ($RETORNAR){header("location: menu_parametros.php?Naveg=Seguridad >> Menu de Parametros");}
if ($GUARDATOS) 
{	
  	include ("conexion.php");
   	$sql = "SELECT * FROM sarc";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	if ($row[id]=="")
	{$sql = "INSERT INTO sarc (CTipoentidad,CCorrelativoEntidad,CTipoOficina,TAclaracionOficina,CLocalidadOficina,encargado)".
	"VALUES ('$tipoentidad','$correlativo','$oficina','$aclaracion','".$lciudad.$lzona."','$NombreUsr')";
	mysql_db_query($db,$sql,$link);
	header("location: menu_parametros.php?Naveg=Menu Parametros");
	
	}	   
   	else
	{$sql = "UPDATE sarc SET CTipoEntidad='$tipoentidad',". "CCorrelativoEntidad='$correlativo',CTipoOficina='$oficina',"."TAclaracionOficina='$aclaracion',CLocalidadOficina='".$lciudad.$lzona."',encargado='$NombreUsr'";   
  
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
      <th><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PARAMETROS 
          DE RECLAMOS SARC</strong></font></div></th>
  </tr>
    <tr> 
      <td> 
        <table width="100%">
          <tr> 
            <th colspan="3"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Datos 
                de la Entidad:</font></div></th>
          </tr>
          <tr> 
            <td width="5%">&nbsp;</td>
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">Tipo Entidad:</font> </td>
            <td width="65%"><font color="#0000CC" size="2" face="Arial, Helvetica, sans-serif"> 
			<?php $sql1 = "SELECT * FROM sarc";
			  $result1=mysql_db_query($db,$sql1,$link);
			  $row1=mysql_fetch_array($result1);?>
              <select name="tipoentidad" id="select2" val>
               <option value="01" <?php if ($row1[CTipoEntidad]=="01") {echo "selected"; }?>>Bancos</option>
			   <option value="02" <?php if ($row1[CTipoEntidad]=="02") {echo "selected"; }?>>Mutuales de Ahorro y Prestamo</option>
			   <option value="03" <?php if ($row1[CTipoEntidad]=="03") {echo "selected"; }?>>Cooperativas de Ahorro y Credito</option>
			   <option value="04" <?php if ($row1[CTipoEntidad]=="04") {echo "selected"; }?>>Fondos Financieros Estatales y Mixtos</option>
			   <option value="05" <?php if ($row1[CTipoEntidad]=="05") {echo "selected"; }?>>Fondos Financieros Privados</option>
			   <option value="06" <?php if ($row1[CTipoEntidad]=="06") {echo "selected"; }?>>Servicio Nacional de Patrimonio de Estado</option>
			   <option value="07" <?php if ($row1[CTipoEntidad]=="07") {echo "selected"; }?>>Almacenes de Deposito</option>
			   <option value="08" <?php if ($row1[CTipoEntidad]=="08") {echo "selected"; }?>>Administradora de recursos de Terceros</option>
			   <option value="09" <?php if ($row1[CTipoEntidad]=="09") {echo "selected"; }?>>Casas de Cambios</option>
			   <option value="10" <?php if ($row1[CTipoEntidad]=="10") {echo "selected"; }?>>Entidades de Segundo Piso</option>
			   <option value="11" <?php if ($row1[CTipoEntidad]=="11") {echo "selected"; }?>>Empresas de Arrendamiento Financiero</option>
			   <option value="12" <?php if ($row1[CTipoEntidad]=="12") {echo "selected"; }?>>Empresas de Factoraje Financiero</option>
			   <option value="13" <?php if ($row1[CTipoEntidad]=="13") {echo "selected"; }?>>Entidades con Creditos C/Pacto de recompra</option>
			   <option value="14" <?php if ($row1[CTipoEntidad]=="14") {echo "selected"; }?>>Entidades en administracion de cartera</option>
			   <option value="15"<?php if ($row1[CTipoEntidad]=="15") {echo "selected"; }?>>Buros de Informacion Crediticia</option>
			   <option value="16"<?php if ($row1[CTipoEntidad]=="16") {echo "selected"; }?>>Entidades Financieras de Primera Linea</option>
			   <option value="17"<?php if ($row1[CTipoEntidad]=="17") {echo "selected"; }?>>Adm. de Camaras de Compensacion y Liquidacion</option>
			   <option value="18"<?php if ($row1[CTipoEntidad]=="18") {echo "selected"; }?>>Entidades Gubernamentales</option>
			   <option value="19"<?php if ($row1[CTipoEntidad]=="19") {echo "selected"; }?>>Administradoras de Fondo de Pensiones</option>
			   <option value="20"<?php if ($row1[CTipoEntidad]=="20") {echo "selected"; }?>>Empresas de Seguros de Personas</option>
			   <option value="21"<?php if ($row1[CTipoEntidad]=="21") {echo "selected"; }?>>Empresas de Seguros Generales</option>
			   <option value="22"<?php if ($row1[CTipoEntidad]=="22") {echo "selected"; }?>>Agencia de Bolsa</option>
			   <option value="23"<?php if ($row1[CTipoEntidad]=="23") {echo "selected"; }?>>Bolsa de Valores</option>
			   <option value="24"<?php if ($row1[CTipoEntidad]=="24") {echo "selected"; }?>>Entidad de Deposito de Valores</option>
			   <option value="25"<?php if ($row1[CTipoEntidad]=="25") {echo "selected"; }?>>Sociedades administradoras de fondos de inversion</option>
			   <option value="26"<?php if ($row1[CTipoEntidad]=="26") {echo "selected"; }?>>Titularizadores</option>
			   <option value="27"<?php if ($row1[CTipoEntidad]=="27") {echo "selected"; }?>>Instituciones financieras de desarrollo</option>
			   <option value="88<?php if ($row1[CTipoEntidad]=="88") {echo "selected"; }?>">Entidades de Prueba</option>
			   <option value="99"<?php if ($row1[CTipoEntidad]=="99") {echo "selected"; }?>>Otro Tipo de Entidades</option>
              </select>
            </font> </td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Numero Correlativo Entidad: </font>&nbsp;&nbsp;&nbsp;            </td>
            <td><label>
              <select name="correlativo">
			  <option value="002"><!--Infocred BIC S.A.--></option>
              </select>
            </label></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%">
          <!--DWLayoutTable-->
          <tr> 
            <td height="21" colspan="2" bgcolor="#006699"> <div align="left"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong> &nbsp;Datos del Reclamo:</strong></font></div></td>
          </tr>
          <tr> 
            <td width="307" height="43" valign="middle"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Localidad Oficina</font></div></td>
            <td width="242" align="left" valign="middle"><br>
              <label>
              <select name="lciudad">
			  <option value="02">La Paz</option>
              </select>
              </label>
              <label>
              <select name="lzona">
			  <option value="01">La Paz</option>
			  <option value="06">El Alto</option>
			  </select>
              </label></td>
          </tr>
          <tr>
            <td height="43" align="center" valign="middle"><div align="center"><font size="2">Aclaracion Oficina</font></div></td>
            <td align="left" valign="middle"><label>
              <input type="text" name="aclaracion" value="<?php echo $row1[TAclaracionOficina];?>"/>
            </label></td>
          </tr>
        </table>
        <br>
        <table width="100%">
          <!--DWLayoutTable-->
          <tr> 
            <td width="308" height="24" valign="top"> 
            <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Tipo de Oficina</font></div></td>
            <td width="241" valign="top"><label>
              <select name="oficina">
			  <option value="1" <?php if ($row1[CTipoOficina]=="1") {echo "selected"; }?>>Oficina Central</option>
			  <option value="2" <?php if ($row1[CTipoOficina]=="2") echo "selected"; ?>>Sucursal</option>
			  <option value="3" <?php if ($row1[CTipoOficina]=="3") echo "selected"; ?>>Agencia</option>
			  <option value="4"<?php if ($row1[CTipoOficina]=="4") echo "selected" ;?>>Ventanilla de Cobranza</option>
			  <option value="5"<?php if ($row1[CTipoOficina]=="5") echo "selected" ;?>>Caja Externa</option>
			  <option value="6"<?php if ($row1[CTipoOficina]=="6") echo "selected" ;?>>Mandato</option>
			  <option value="7"<?php if ($row1[CTipoOficina]=="7") echo "selected" ;?>>Oficina Ferial</option>
			  <option value="9"<?php if ($row1[CTipoOficina]=="8") echo "selected" ;?>>Cajero Automatico</option>
			  </select>
            </label></td>
          </tr>
          <tr>
            <td height="24" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
            <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
          </tr>
          <tr>
            <td height="24" valign="top"><div align="center"><font size="2">Encargado de SARC </font></div></td>
            <td valign="top"><label>
              <select name="NombreUsr" id="select3">
                <?php 
						$sql = "SELECT * FROM users WHERE bloquear=0 ORDER BY apa_usr ASC";
			  			$result = mysql_db_query($db,$sql,$link);
			  			while ($row = mysql_fetch_array($result)) 
						{
							
							echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
			   			}
						?>
              </select>
            </label></td>
          </tr>
        </table>
         <table width="100%">
        </table>
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