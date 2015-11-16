<?php 
if ($RETORNAR){header("location: modulos.php");}
if ($GUARDATOS) 
{
  include ("conexion.php");
  session_start();
  $login=$_SESSION["login"];
  $sql01="SELECT * FROM users WHERE login_usr='$login'";
  $result01=mysql_db_query($db,$sql01,$link);
  $row01=mysql_fetch_array($result01);
  $nombre_usr=$row01[nom_usr]." ".$row01[apa_usr]." ".$row01[ama_usr];
  $path=$_SESSION["path"];
  $path_replica=$_SESSION["path_replica"];
  $fecha_creacion=date("Y-m-d");
  $hora_creacion=date("H:i:s");
  $nombre_mod = strtolower ($nombre_mod);
  $nombre_mod = trim($nombre_mod);
  //valida el nombre del modulo
  if (ereg('^([0-9a-zA-Z_ -]{1,255})+$',$nombre_mod)) {
	  $sql11="SELECT * FROM modulo WHERE id_mod='$id_modu'";
	  $result11=mysql_db_query($db,$sql11,$link);
	  $row11=mysql_fetch_array($result11); 	
	  if ($row11[nombre_mod]==$nombre_mod && $row11[desc_mod]==$desc_mod){
	    header("location: modulos.php");}else{
		if ($row11[nombre_mod]==$nombre_mod && $row11[desc_mod]!=$desc_mod){
		$sql = "UPDATE modulo SET nombre_mod='$nombre_mod',desc_mod='$desc_mod' WHERE id_mod='$id_modu'";
		$rst=mysql_db_query($db,$sql,$link);
	    $sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod)".
   	            "VALUES ('$fecha_creacion','$hora_creacion','modificacion_modulo','$nombre_usr','$row11[nombre_mod]')";
		$rst0=mysql_db_query($db,$sql0,$link);
		header("location: modulos.php");
	    }else{
	
		  $dir = opendir($path);
		  $existe=0;
		  while ($elemento = readdir($dir))
			{ 
				if ($elemento==$nombre_mod){$existe++;}
			}
		  if ($existe==1){$msg="Ya existe un modulo con el mismo nombre";}
		  closedir($dir); 
		  $dir = opendir($path);
		  if ($existe==0){
			  while ($elemento = readdir($dir))
				{ 
					if ($elemento==$nombre_mod1){
					$sql = "UPDATE modulo SET nombre_mod='$nombre_mod',desc_mod='$desc_mod' WHERE id_mod='$id_modu'";
					$rst=mysql_db_query($db,$sql,$link);
				    $sql0 = "INSERT INTO pistas_fuentes (fecha_pista,hora_pista,accion,login_pista,id_mod)".
			   	            "VALUES ('$fecha_creacion','$hora_creacion','modificacion_modulo','$nombre_usr','$row11[nombre_mod]')";
					$rst0=mysql_db_query($db,$sql0,$link);
					rename($path."/$nombre_mod1",$path."/$nombre_mod");
					rename($path_replica."/$nombre_mod1",$path_replica."/$nombre_mod");}
					header("location: modulos.php");
				}
		  }}
		  closedir($dir); 
	}
  }else {$msg=("El nombre del modulo no es valido.");}
}

include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty( "nombre_mod",  "Nombre del Modulo, $errorMsgJs[empty]" );
$valid->addIsNotEmpty( "desc_mod",  "Descripcion del Modulo, $errorMsgJs[empty]" );
$valid->addFunction ( "longitud_obs",  "" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
function longitud_obs(){
	if (form1.desc_mod.value.length > 250)
	{ alert ("Nombre del Modulo, debe ser menor a 250 caracteres.\n \nMensaje generado por GesTor F1.");
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
<form name="form1" method="post" action="<?php=$PHP_SELF?>" onKeyPress="return Form()">
<?php 
$sql = "SELECT *, DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion	FROM modulo WHERE id_mod='$id_modu'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result); 	
?>                    
<input name="nombre_mod1" type="hidden" value="<?php echo $row[nombre_mod]; ?>">
<input name="id_modu" type="hidden" value="<?php echo $id_modu; ?>">
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr> 
      <td height="203"> 
        <div align="center">
<table width="70%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
            <tr> 
              <td colspan="2"><div align="center"><font size="2" color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>MODULO:&nbsp;<?php echo $row[nombre_mod]; ?></strong></font></div></td>
            </tr>
          </table>
          <table width="70%" border="1" cellpadding="1" cellspacing="0" background="images/fondo.jpg">
            <tr>
              <td> 
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>                    
					<td colspan="3" align="right" valign="top" height="30">
			        <strong>Fecha de creacion:<?php echo $row[fecha_creacion];?><br><br></td>
				  </tr>					
				  <tr> 
                    <td width="185" height="11"><div align="right">&nbsp;<font size="2" face="Verdana, Helvetica, sans-serif"><b>Codigo 
                        : &nbsp;&nbsp;</b></font> </div></td>
					<td width="419" colspan="2"><font size="2" face="Verdana, Helvetica, sans-serif"><strong><input name="id_modu" disabled type="text" value="<?php echo $id_modu; ?>" size="10"></strong></font></td>
                  </tr>
				  <tr> 
                    <td width="185" height="11"><div align="right">&nbsp;<font size="2" face="Verdana, Helvetica, sans-serif"><b>Nombre 
                        del modulo : &nbsp;&nbsp;</b></font> </div></td>
					<td width="419" colspan="2"><input name="nombre_mod" type="text" value="<?php echo $row[nombre_mod]; ?>" size="50" maxlength="70"></td>
                  </tr>
                  
                </table>
                <br>
                <table width="100%">
                  <tr>
                    <td width="30%" height="76"> 
                      <div align="right">&nbsp;<font size="2" face="Verdana, Helvetica, sans-serif"><b>Descripcion :                 &nbsp;&nbsp;</b></font></div></td>
                    <td width="70%"><textarea name="desc_mod" cols="52" onKeyDown="textCounter(form1.desc_mod,form1.remLen,250);" onKeyUp="textCounter(form1.desc_mod,form1.remLen,250);"><?php echo $row[desc_mod]; ?></textarea></td>
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
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
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