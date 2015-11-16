<?php
include("conexion.php");
if(isset($_REQUEST['RETORNAR'])) header("location: lista_agenda.php");
if(isset($_REQUEST['reg_form'])){
	unset($msg);
        $nombre=$_REQUEST['nombre'];
        $obs=$_REQUEST['obs'];
	$cons="SELECT * FROM us_ext_mod WHERE nombre='$nombre'";
        //print_r($cons);
        //exit;
	$res=mysql_db_query($db,$cons,$link);
	if(mysql_fetch_array($res)) header("location: us_externos.php?msg=1");
	else{
		$sql="INSERT INTO us_ext_mod (nombre,obs) VALUES ('$nombre','$obs')";
                //print_r($sql);
                //exit;
		mysql_db_query($db,$sql,$link);
	}
}
include("top.php");
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
$valid->addExists( "obs",  "Observaciones, $errorMsgJs[empty]" );
print $valid->toHtml ();
?>    
<form name="form2" method="post" action=""><br>
<table width="80%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <th colspan="7" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
      EMPRESA</font></th>
  </tr>
  <tr> 
    <th width="40" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
    <th width="307" nowrap background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
    <th width="246" nowrap background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></th>
	  <th width="161" nowrap background="images/main-button-tileR1.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">USUARIOS</font></th>
  </tr>
  <?php
		$cont=0;	
		$sql = "SELECT * FROM us_ext_mod ORDER BY nombre";
		$result=mysql_db_query($db,$sql,$link);
		
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>
  <tr> 
    <td align="center">&nbsp;<?php echo $cont?></td>
    <td align="center">&nbsp;<?php echo $row['nombre']?></td>
    <td align="center">&nbsp;<?php echo $row['obs']?></td>
	  <td align="center"><a href="us_ext_lista.php?id_mod=<?php=$row['id_mod']?>"><img src="images/usuario.gif" width="16" height="19" border="0"></a></td>
  </tr>
  <?php 
		 }
		 ?>
  <tr> 
    <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
      <?php //echo $cad; ?>
      <div align="center"></div></td>
  </tr>
  <tr> 
    <td width="40" height="7" nowrap background="images/main-button-tileR1.jpg"> <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
    <td width="307" nowrap><div align="center"><strong> 
        <input name="nombre" type="text" size="50" maxlength="100">
        </strong></div></td>
    <td colspan="2" width="246" nowrap height="7"><div align="center"><strong> 
          <textarea name="obs" cols="60" rows="2" id="obs"></textarea>
        </strong> </div></td>
  </tr>
  <tr> 
    <td height="28" colspan="7" nowrap> <div align="center"> <br>
        <input name="reg_form" type="submit" id="reg_form3" value="NUEVA EMPRESA" <?php print $valid->onSubmit() ?>>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="RETORNAR" type="submit" id="reg_form" value="RETORNAR">
          <br><br>
      </div></td>
  </tr>
</table>
</form>
<?php
include("top_.php");
?>
<script language="JavaScript" type="text/JavaScript">
<?php if($msg==1) echo "alert('El nombre ya existe, seleccione otro.\\n Mensaje generado por GestorF1')";?>
</script>
