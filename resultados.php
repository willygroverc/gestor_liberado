<?php 
include("conexion.php");
if(isset($_REQUEST['var']))
	$var=$_REQUEST['var'];
$cad = $_GET['dato'];
$dato=$_REQUEST['dato'];
$id_minuta=$_REQUEST['id_minuta'];
$insertado=$_REQUEST['insertado'];
//$verif=$_REQUEST['verif'];
if(isset($_REQUEST['num_cod']))
	$num_cod=$_REQUEST['num_cod'];
if ( isset($_GET['insertado']) && $_GET['insertado'] == "1" )
{	$fila = explode(":",$dato);		
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";
	$sql="INSERT INTO ".
	"minuta (codigo,elab_por,en_fecha,tipo_min,fecha,hora,lugar,id_minuta,num_codigo,comentario)".
	"VALUES ('$fila[0]','$fila[3]','$en_fecha','$fila[4]','$fecha','$hora','$fila[6]','$id_minuta','$num_cod','$fila[7]')";
	mysql_db_query($db,$sql,$link);												
	$insertado = "2";
}
if ( isset($_GET['insertado']) && $_GET['insertado'] == "0" )
{	$fila = explode(":",$dato);
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";	
	$sql = "UPDATE minuta SET codigo='$fila[0]',elab_por='$fila[3]',en_fecha='$en_fecha',tipo_min='$fila[4]',
			fecha='$fecha', hora='$hora',lugar='$fila[6]', comentario='$fila[7]' WHERE id_minuta='$id_minuta'";
	mysql_db_query($db,$sql,$link);
	$insertado = "2";
}
if (isset($_REQUEST['Terminar'])){header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");}
if (isset($_REQUEST['reg_form']))
{	include("conexion.php");
	$tema=$_REQUEST['tema'];
	$resultado=$_REQUEST['resultado'];
	$sql35 = "SELECT * FROM temad WHERE tema='$tema' AND id_minuta='$var'";
	$result35=mysql_db_query($db,$sql35,$link);
	$row35=mysql_fetch_array($result35);
	
	$sql="INSERT INTO ".
	"rtema (tema,resultado,id_minuta,id_tema) ".
	"VALUES ('$tema','$resultado','$var','$row35[id_tema]')";
	/*echo $sql;
	exit;*/
	mysql_db_query($db,$sql,$link);
	header("location: resultados.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
$valid->addIsTextNormal( "resultado",  "Resultados, $errorMsgJs[empty]" );
$valid->addLength ( "resultado",  "Resultados, $errorMsgJs[length]" );
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

  <table width="71%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
    <form name="form2" method="post" action="" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<input name="verif" type="hidden" value="<?php if ($_GET['verif']) {echo $_GET['verif'];}else{echo "1";};?>">
	<input name="dato" type="hidden" value="<?php echo $dato; ?>">
	<input name="num_cod" type="hidden" value="<?php echo $num_cod; ?>">
	<input name="insertado" type="hidden" value="<?php echo $insertado; ?>">
	
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              RESULTADOS POR TEMA</font></th>
          </tr>
          <tr> 
            <th width="10%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="40%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="40%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESULTADOS</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row['id_tema']?></td>
	         <?php $sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5['id_tema'])
				{echo "<td>&nbsp;$row[tema]</td>";}
				else
				{echo "<td>&nbsp;$row5[tema]</td>";}?>
			<td>&nbsp;<?php echo $row['resultado']?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="49" height="7" nowrap bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
            <td width="393" nowrap><div align="center"><strong> 
                <select name="tema" id="select8">
              <?php 
			  $sql0 = "SELECT * FROM temad WHERE id_minuta='$id_minuta'";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
					$sql01 = "SELECT * FROM rtema WHERE id_tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  		$result01=mysql_db_query($db,$sql01,$link);
			  		$row01=mysql_fetch_array($result01);
					if (!$row01['tema'])
					{$sql5 = "SELECT * FROM temas WHERE id_tema='$row0[tema]' AND id_agenda='$id_minuta'";
		    		$result5 = mysql_db_query($db,$sql5,$link);
		    		$row5 = mysql_fetch_array($result5);
					if (!$row5['id_tema'])
					{echo "<option value=\"$row0[tema]\">$row0[tema] </option>";}
					else
					{echo "<option value=\"$row5[id_tema]\">$row5[tema] </option>";}}
				}
			 ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </strong></div></td>
            <td width="225" nowrap><strong> 
              <textarea name="resultado" cols="30"></textarea>
              </strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<?php include("top_.php");?>
