<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		06/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
require("conexion.php");
$cad = $dato;
if ( isset($insertado) && $insertado == "1" )
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
	mysql_query($sql);												
	$insertado = "2";
}
if ( isset($insertado) && $insertado == "0" )
{	$fila = explode(":",$dato);
	$enfecha  = explode("/", $fila[1]);
	$en_fecha = "$enfecha[0]-$enfecha[1]-$enfecha[2]";
	$fechad = explode("/", $fila[2]);
	$fecha = "$fechad[0]-$fechad[1]-$fechad[2]";
	$horad = explode ("/", $fila[5]);
	$hora = "$horad[0]:$horad[1]";	
	$sql = "UPDATE minuta SET codigo='$fila[0]',elab_por='$fila[3]',en_fecha='$en_fecha',tipo_min='$fila[4]',
			fecha='$fecha', hora='$hora',lugar='$fila[6]', comentario='$fila[7]' WHERE id_minuta='$id_minuta'";
	mysql_query($sql);
	$insertado = "2";
}
if (isset($Terminar)){header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");}
if (isset($reg_form))
{
	$sql35 = "SELECT * FROM temad WHERE tema='$tema' AND id_minuta='$var'";
	$result35=mysql_query($sql35);
	$row35=mysql_fetch_array($result35);
	$sql="INSERT INTO ".
	"compromisos (tema,compromiso,id_minuta,id_tema) ".
	"VALUES ('$tema','$compromiso','$var','$row35[id_tema]')";
	mysql_query($sql);
	header("location: compromisos.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);

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
    <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
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
              AGREGAR COMPROMISOS ADQUIRIDOS</font></th>
          </tr>
          <tr> 
            <th width="85" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="274" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="307" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESULTADOS</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM compromisos WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row['id_tema'];?></td><!--correcto-->
	         <?php $sql5 = "SELECT * FROM rtema WHERE id_tema='$row[tema]' AND id_minuta='$id_minuta'";
		    	$result5 = mysql_query($sql5);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5['id_tema'])
				{echo "<td>&nbsp;".$row['tema']."</td>";
				}
				else
				{echo "<td>&nbsp;".$row5['resultado']."</td>";
				 }
				?>
			<td>&nbsp;<?php echo $row['compromiso'];?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="85" height="7" nowrap bgcolor="#006699">
<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></strong></div></td>
            <td width="274" nowrap><div align="center"><strong> 
                <select name="tema" id="select8">
              <?php 
				$sql0 = "SELECT * FROM temas WHERE id_agenda='$id_minuta'";
			  $result0=mysql_query($sql0);
			  while ($row0=mysql_fetch_array($result0)) 
				{
					/*$sql01 = "SELECT * FROM atema WHERE id_tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  		$result01=mysql_query($sql01);
			  		$row01=mysql_fetch_array($result01);
					if (!$row01[tema])//Si NO existe en la tabla atema muestra en el combo box y si SI existe no muestra
					{*/$sql5 = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' AND id_tema = '$row0[id_tema]' ORDER BY id_tema ASC";
		    		$result5 = mysql_query($sql5);
		    		while($row5 = mysql_fetch_array($result5))
					{	if ($row5['id_tema'])
						{echo '<option value="'.$row5['id_tema'].'">'.$row5['resultado'].'</option>';}
					/*else
					{echo "<option value=\"$row0[id_tema]\">$row0[tema] </option>";}*/
					}
				}
				//}
			 ?>
                </select>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                </strong></div></td>
            <td width="307" nowrap><strong> 
              <textarea name="compromiso" cols="30" id="compromiso"></textarea>
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
