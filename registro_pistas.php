<?php 
session_start();
$login=$_SESSION["login"];
if (isset($RETORNAR)){header("location: pistas_auditoria.php");}
if (isset($GUARDATOS)) 
{ include ("conexion.php");
  include ("funciones.inc.php");
  require_once('funciones.php');
  $fecha_hoy = date("Y-m-d");
  $hora_hoy = date("H:i:s");
  $fecha_hoy=SanitizeString($fecha_hoy);
  $hora_hoy=SanitizeString($hora_hoy);
  $nombre_pista=SanitizeString($nombre_pista);
  $desc_pista=SanitizeString($desc_pista);
  $sql = "INSERT INTO registro_pistas (fecha_pista,hora_pista,nombre_pista,desc_pista,restaurado) ".
		 "VALUES ('$fecha_hoy','$hora_hoy','$nombre_pista','$desc_pista',0)";
  if ( mysql_db_query($db, $sql, $link) )		 
  {	$sql_aux = "SELECT MAX(id_pista) AS pista FROM registro_pistas";
  	$res_aux = mysql_db_query($db, $sql_aux, $link);
	$row_aux = mysql_fetch_array ($res_aux);

	$sql_gral = "SELECT * FROM pistas_fuentes";
	$res_gral = mysql_db_query($db, $sql_gral, $link);
	while ( $row_gral = mysql_fetch_array($res_gral) )
	{	$row_gral['id_pista']=SanitizeString($row_gral['id_pista']);
		$row_gral['fecha_pista']=SanitizeString($row_gral['fecha_pista']);
		$row_gral['hora_pista']=SanitizeString($row_gral['hora_pista']);
		$row_gral['accion']=SanitizeString($row_gral['accion']);
		$row_gral['login_pista']=SanitizeString($row_gral['login_pista']);
		$row_gral['id_mod']=SanitizeString($row_gral['id_mod']);
		$row_gral['id_arch']=SanitizeString($row_gral['id_arch']);
		$sql_insert = "INSERT INTO pistas_fuentes_gral(id_pista, fecha_pista, hora_pista, accion, login_pista, id_mod, id_arch, id_ver, agrupar_pista) ".
					  " VALUES ('$row_gral[id_pista]','$row_gral[fecha_pista]','$row_gral[hora_pista]','$row_gral[accion]', ".
					  "'$row_gral[login_pista]', '$row_gral[id_mod]', '$row_gral[id_arch]', '$row_gral[id_ver]', '$row_aux[pista]')";				
		mysql_db_query($db, $sql_insert, $link);
	}
  	$msg = "La pista de auditoria se ha guardado con exito";
  	$sql2 = "DROP TABLE pistas_fuentes";
  	$rst2 = mysql_db_query($db,$sql2,$link);
	$sql3 = "CREATE TABLE pistas_fuentes (".
			 "id_pista int(10) NOT NULL auto_increment,".
			 "fecha_pista date NOT NULL default '0000-00-00',".
			 "hora_pista time NOT NULL default '00:00:00',".
			 "accion varchar(50) NOT NULL default '',".
			 "login_pista varchar(25) NOT NULL default '',".
			 "id_mod varchar(150) NOT NULL default '',".
			 "id_arch varchar(250) NOT NULL default '',".
			 "id_ver varchar(250) NOT NULL default '',".
			 "PRIMARY KEY  (id_pista))";
	$rst3 = mysql_db_query($db,$sql3,$link);	
  }
  else
  {	$sql_del = "DELETE FROM registro_pistas WHERE id_pista = '$row_aux[pista]'";
	mysql_db_query($db, $sql_del, $link);
	$msg = "La pista de auditoria no pudo crearse.";
  }
  header("location: pistas_fuentes2.php");  
}

include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty( "desc_pista",  "Descripcion del Modulo, $errorMsgJs[empty]" );
$valid->addFunction ( "longitud_obs",  "" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--	
function longitud_obs(){
	if (form1.desc_pista.value.length > 250)
	{ alert ("Descripcion, debe ser menor a 250 caracteres.\n \nMensaje generado por GesTor F1.");
	return false;
	}
	return true;
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

-->
</script>
<form name="form1" method="post" action="" onKeyPress="return Form()">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="205"> 
        <div align="center">
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td colspan="2" background="images/main-button-tileR2.jpg"><div align="center"><strong><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif">
	    	   EXPORTACION DE PISTAS DE AUDITORIA</font></strong></div></td>
            </tr>
          </table>
          <table width="70%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
            <tr>
              <td> 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr><td colspan="3" align="right" valign="bottom" height="30">
			          <strong>Fecha:<?php echo date("d/m/Y");?>&nbsp;&nbsp;HORA : </strong><?php echo date("H:i:s");?><br><br></td>
				  </tr>					
				  <tr> 
                    <td width="183" height="11"> <div align="right">&nbsp;<font size="2" face="Verdana, Helvetica, sans-serif"><b>Nombre 
                        del arhivo: &nbsp;&nbsp;</b></font></div></td>
                    <td width="421" colspan="2"><input name="nombre_pista" readonly="yes" type="text" value="<?php echo "pista_".date("d_m_Y")."_".date("H_i"); ?>" size="50" maxlength="50"></td>
                  </tr>
                  
                </table>
                <br>
                <table width="100%">
                  <tr>
                    <td width="30%" height="76"> 
                      <div align="right"><font size="2" face="Verdana, Helvetica, sans-serif"><b>Descripcion: &nbsp;&nbsp;</b></font></div></td>
                    <td width="70%"><textarea name="desc_pista" cols="52" onKeyDown="textCounter(form1.desc_pista,form1.remLen,250);" onKeyUp="textCounter(form1.desc_pista,form1.remLen,250);"></textarea></td>
			        <input name="remLen" type="hidden" value="250">
                  </tr>
				</table>  
              </td>
            </tr>
          </table>
        </div></td>
    </tr>
  </table>
<table align="center">
	<tr>
      <td height="40" align="center"> 
	 	<input type="submit" name="GUARDATOS" value="GUARDAR" <?php print $valid->onSubmit() ?>>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
	 <td>
    </tr>						
</table>
  
</form>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
        -->
</script>
<?php include("top_.php");?>
<script language="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) {
	if (field.value.length > maxlimit) // if too long...trim it!
	field.value = field.value.substring(0, maxlimit);
	// otherwise, update 'characters left' counter
	else 
	countfield.value = maxlimit - field.value.length;
	}
// End 
-->
</script>