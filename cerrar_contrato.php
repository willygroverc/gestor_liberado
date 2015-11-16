<?php 
if (isset($_REQUEST['retornar'])){header("location: lista_contratos.php");}
if (isset($_REQUEST['guardar'])){
	include ("conexion.php");
	require_once('funciones.php');
	$motivo_cierre=  _clean($_REQUEST['motivo_cierre']);
	$motivo_cierre=SanitizeString($_REQUEST['motivo_cierre']);
	
	//$sql="UPDATE contratodatos SET motivo_cierre='$motivo_cierre',Cierre=1 WHERE IdContra='$_GET[IdContra]'";
        $sql="UPDATE contratodatos SET motivo_cierre='$motivo_cierre' WHERE IdContra='$_GET[IdContra]'";

	if (mysql_db_query($db,$sql,$link)){
	header("location: lista_contratos.php?IdContra=$_GET[IdContra]&Cierre=1");
	}
}
include("top.php");
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "motivo_cierre",  "Motivo de cierre de contrato, $errorMsgJs[empty]" );
$valid->addLength( "motivo_cierre",  "Motivo de cierre de contrato, $errorMsgJs[length]" );
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

<?php

$sql0="SELECT *, DATE_FORMAT(FechAl, '%d/%m/%Y') AS FechAl2 FROM contratodatos WHERE IdContra='$_GET[IdContra]'";
$result0=mysql_db_query($db,$sql0,$link);
$row0=mysql_fetch_array($result0);

?>
<br>
<form action="" name="form1" method="post">
<?php	if(!empty($_GET['IdContra']))	{	?>

<input type="hidden" name="IdContra" value="<?php echo $_GET['IdContra']; ?>">
<?php
}	else	{	?>
<input type="hidden" name="IdContra" value="">
<?php	}	?>
  <table width="60%" border="1" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
	  
    <th height="22" align="center" background="images/main-button-tileR1.jpg">CERRAR CONTRATO</tr>

   <tr> 
      <td align="center"> <table width="90%" border="0" cellpadding="5" cellspacing="0" >
        <tr> 
          <td width="21%" class="normal">&nbsp;</td>
		  <td width="22%" class="normal">&nbsp;</td>
		  <td align="right">&nbsp;</td>
		  <td><strong>Nro. Contrato: <?php echo $row0['IdContra']; ?></strong></td>
        </tr>
        <tr> 
          <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Tipo de Contrato: </font></div></td>
          <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php print $row0['TipoContra']; ?></font></td>
          <td width="31%"> <div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Empresa Contratada:</font></div></td>
          <td width="26%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php print $row0['EmpContra']; ?></font></td>
        </tr>
        <tr> 
          <td><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Codigo Legal: </font></div></td>
          <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php print $row0['CodLegalContra']; ?></font></td>
          <td><div align="right"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Fecha de Vencimiento:</font></div></td>
          <td><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php print $row0['FechAl2']; ?></font></td>
        </tr>
        <tr> 
          <td colspan="4"><div align="left"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">Motivo de Cierre de Contrato:</font></div></td>
        </tr>
		<tr>
		  <td align="center" colspan="4"><textarea name="motivo_cierre" cols="60" rows="5"></textarea></td>
		</tr>
		<tr align="center">
		  <td colspan="4"><input name="guardar" type="submit" value="GUARDAR" <?php echo $valid->onSubmit(); ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="retornar" type="submit" value="RETORNAR"></td>
		</tr>
      </table></td> 
</tr> 
</table>
</form>
<?php include("top_.php");?> 