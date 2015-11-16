<?php 
include("conexion.php");
$cad = $dato;
if ( $insertado == "1" )
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
if ( $insertado == "0" )
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
if ($Terminar){header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");}
if ($reg_form){
	include("conexion.php");	
	$sql = "SELECT * FROM temas WHERE id_tema='$tema' AND id_agenda='$var'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	$responsable=$row[responsable];
	$duracion=$row[duracion];
	$sql2="SELECT MAX(id_tema) AS ntem FROM temad WHERE id_minuta='$var'";
	$result2=mysql_db_query($db,$sql2,$link);
	$row2=mysql_fetch_array($result2);
	$id_tema=$row2[ntem]+1;		
	
	$sql="INSERT INTO temad (tema,responsable,duracion,id_tema,id_minuta) ".
	"VALUES ('$tema','$responsable','$duracion','$id_tema','$var')";
	mysql_db_query($db,$sql,$link);
	header("location: vtema.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
else { 
include("top.php");
$id_minuta=($_GET['id_minuta']);

?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
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

<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<input name="verif" type="hidden" value="<?php if ($_GET[verif]) {echo $_GET[verif];}else{echo "1";};?>">
	<input name="dato" type="hidden" value="<?php echo $dato; ?>">
	<input name="num_cod" type="hidden" value="<?php echo $num_cod; ?>">
	<input name="insertado" type="hidden" value="<?php echo $insertado; ?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="4" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              VERIFICAR TEMA</font></th>
          </tr>
          <tr> 
            <th width="10%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="35%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TEMA</font></th>
            <th width="35%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="20%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DURACION(min)</font></th>
          </tr>
          <?php
		$sql = "SELECT * FROM temad WHERE id_minuta='$id_minuta' AND tipo<>'Nuevo'";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{?>
          <tr align="center"> 
            <td>&nbsp;<?php echo $row[id_tema]?></td>
			<?php 	$sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[id_tema])
				{echo "<td>&nbsp;$row[tema]</td>";}
				else
				{echo "<td>&nbsp;$row5[tema]</td>";}
	
				$sql5 = "SELECT * FROM users WHERE login_usr='$row[responsable]'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[login_usr])
				{echo "<td>&nbsp;$row[responsable]</td>";}
				else
				{echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}
			?>
            <td>&nbsp;<?php echo $row[duracion]?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="4" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="26" nowrap height="7"><strong> </strong></td>
            <td width="175" nowrap><div align="center"><strong> 
                <select name="tema" id="select8">
                  <option value="0"></option>
                  <?php 
			  $sql0 = "SELECT * FROM temas where id_agenda='$id_minuta'";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{$sql01 = "SELECT * FROM temad WHERE tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  	$result01=mysql_db_query($db,$sql01,$link);
			  	$row01=mysql_fetch_array($result01);
				if (!$row01[tema])
				{echo "<option value=\"$row0[id_tema]\">$row0[tema]</option>";}
				
                }
			   ?>
                </select>
                </strong></div></td>
            <td width="250" nowrap><div align="center"><strong></strong></div></td>
            <td width="117" nowrap height="7"><div align="center"><strong> </strong> 
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="4" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS"  <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
