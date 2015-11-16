<?php 
require_once('funciones.php');
if (isset($RETORNAR)){header("location: modulos.php");}
if (isset($GUARDATOS)) 
{
  include ("conexion.php");
  session_start();
  $login=$_SESSION["login"];
  include ("funciones.inc.php");
  $sql01="SELECT * FROM users WHERE login_usr='$login'";
  $result01=mysql_db_query($db,$sql01,$link);
  $row01=mysql_fetch_array($result01);
  $nombre_usr=$row01['nom_usr']." ".$row01['apa_usr']." ".$row01['ama_usr'];
  if(!empty($_SESSION["path"])) { $path=$_SESSION["path"]; }
  if(!empty($_SESSION["path_replica"])) { $path_replica=$_SESSION["path_replica"];  }
  $fecha_creacion=date("Y-m-d");
  $hora_creacion=date("H:i:s");
  $nombre_mod = strtolower ($nombre_mod);
  $nombre_mod = trim($nombre_mod);
  //valida el nombre del modulo
  if (ereg('^([0-9a-zA-Z_ -]{1,255})+$',$nombre_mod)) {
	  $nombre_mod=SanitizeString($nombre_mod);
	  $desc_mod=SanitizeString($desc_mod);
	  $fecha_creacion=SanitizeString($fecha_creacion);
	  $login=SanitizeString($login);
	  $sql = "INSERT INTO modulo (nombre_mod,desc_mod,fecha_creacion,estado,login_creador) ".
			 "VALUES ('$nombre_mod','$desc_mod','$fecha_creacion',0,'$login')";
	  $dir = opendir($path);
	  $existe=0;
	  $existe_trash=0;
	  $existe_replica=0;
	  $existe_backups=0;
	  $existe_pistas=0;
	  while ($elemento = readdir($dir))
	  { 
		   if ($elemento==$nombre_mod){
			$msg="Ya existe un modulo con el mismo nombre";
			$existe++;
		   }
		   if ($elemento=="trash"){$existe_trash++;}
		   if ($elemento=="replica"){$existe_replica++;}
		   if ($elemento=="backups"){$existe_backups++;}	   
		   if ($elemento=="pistas"){$existe_pistas++;}	   
	  }
	  if ($existe_trash==0){
		mkdir($path."/trash",0777);
	  }
	  if ($existe_replica==0){
		mkdir($path."/replica",0777);
	  }
	  if ($existe_backups == 0){
		mkdir($path."/backups",0777);
	  }
	  if ($existe_pistas == 0){
		mkdir($path."/pistas",0777);
	  }
	  
	  if ($existe!=1){
		$rst=mysql_db_query($db,$sql,$link);
	    $id_mod = ObtieneCodigo($db,$link,'modulo','id_mod');
	    $sql1 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod)".
	  		    "VALUES ('$fecha_creacion','$hora_creacion','creacion_modulo','$nombre_usr','$nombre_mod')";
		$rst1=mysql_db_query($db,$sql1,$link);
		mkdir($path."/$nombre_mod",0777);
		mkdir( $path_replica."/$nombre_mod",0777);
		//$msg="El modulo se ha guardado con exito";
		echo "<script>alert('El modulo se ha guardado con exito')</script>";
		header("location: registro_modulo.php");
	  }
	  closedir($dir); 
  }else {$msg=("El nombre del modulo no es valido.");}
}

include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty( "nombre_mod",  "Nombre del Modulo, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "nombre_mod",  "Nombre del Modulo, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty( "desc_mod",  "Descripcion del Modulo, $errorMsgJs[empty]" );
$valid->addFunction ( "longitud_obs",  "" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
function longitud_obs(){
	if (form1.desc_mod.value.length > 250)
	{ alert ("Descripcion del Modulo, debe ser menor a 250 caracteres.\n \nMensaje generado por GesTor F1.");
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
              <td colspan="2" background="images/main-button-tileR1.jpg" height="22"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>
	    NUEVO MODULO</strong></div></td>
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
                        del Modulo : &nbsp;&nbsp;</b></font></div></td>
                    <td width="421" colspan="2"><input name="nombre_mod" type="text" value="" size="50" maxlength="70"></td>
                  </tr>
                  
                </table>
                <br>
                <table width="100%">
                  <tr>
                    <td width="30%" height="76"> 
                      <div align="right"><font size="2" face="Verdana, Helvetica, sans-serif"><b>Descripcion : &nbsp;&nbsp;</b></font></div></td>
                    <td width="70%"><textarea name="desc_mod" cols="52" onKeyDown="textCounter(form1.desc_mod,form1.remLen,250);" onKeyUp="textCounter(form1.desc_mod,form1.remLen,250);"></textarea></td>
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
<SCRIPT LANGUAGE="JavaScript">
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