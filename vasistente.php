<?php
//echo $dato;
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
	require_once('funciones.php');
	$fila[0]=_clean($fila[0]);
	$fila[3]=_clean($fila[3]);
	$en_fecha=_clean($en_fecha);
	$fila[4]=_clean($fila[4]);
	$fecha=_clean($fecha);
	$hora=_clean($hora);
	$fila[6]=_clean($fila[6]);
	$id_minuta=_clean($id_minuta);
	$num_cod=_clean($num_cod);
	$fila[7]=_clean($fila[7]);
	
	$fila[0]=SanitizeString($fila[0]);
	$fila[3]=SanitizeString($fila[3]);
	$en_fecha=SanitizeString($en_fecha);
	$fila[4]=SanitizeString($fila[4]);
	$fecha=SanitizeString($fecha);
	$hora=SanitizeString($hora);
	$fila[6]=SanitizeString($fila[6]);
	$id_minuta=SanitizeString($id_minuta);
	$num_cod=SanitizeString($num_cod);
	$fila[7]=SanitizeString($fila[7]);
	$sql="INSERT INTO ".
	"minuta (codigo,elab_por,en_fecha,tipo_min,fecha,hora,lugar,id_minuta,num_codigo,comentario)".
	"VALUES ('$fila[0]','$fila[3]','$en_fecha','$fila[4]','$fecha','$hora','$fila[6]','$id_minuta','$num_cod','$fila[7]')";
	
	mysql_query($sql);												
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
	require_once('funciones.php');
	$fila[0]=_clean($fila[0]);
	$fila[3]=_clean($fila[3]);
	$en_fecha=_clean($en_fecha);
	$fila[4]=_clean($fila[4]);
	$fecha=_clean($fecha);
	$hora=_clean($hora);
	$fila[6]=_clean($fila[6]);
	$id_minuta=_clean($id_minuta);
	$num_cod=_clean($num_cod);
	$fila[7]=_clean($fila[7]);
	
	$fila[0]=SanitizeString($fila[0]);
	$fila[3]=SanitizeString($fila[3]);
	$en_fecha=SanitizeString($en_fecha);
	$fila[4]=SanitizeString($fila[4]);
	$fecha=SanitizeString($fecha);
	$hora=SanitizeString($hora);
	$fila[6]=SanitizeString($fila[6]);
	$id_minuta=SanitizeString($id_minuta);
	$num_cod=SanitizeString($num_cod);
	$fila[7]=SanitizeString($fila[7]);
	$sql = "UPDATE minuta SET codigo='$fila[0]',elab_por='$fila[3]',en_fecha='$en_fecha',tipo_min='$fila[4]',
			fecha='$fecha', hora='$hora',lugar='$fila[6]', comentario='$fila[7]' WHERE id_minuta='$id_minuta'";
	mysql_db_query($db,$sql,$link);
	$insertado = "2";
}
if ($Terminar){ header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");}
if ($reg_form)
{	$sql = "SELECT * FROM invitados WHERE nombre='$nombre' AND id_agenda='$var'";
	$result=mysql_db_query($db,$sql,$link);		
	$row=mysql_fetch_array($result);		
	$cargo=$row['cargo'];
	$tip=$row['tipo'];
	$sql1="INSERT INTO asistentes (nombre,cargo,id_minuta,tipo,prop,adjunto,hash_archivo) VALUES('$nombre','$cargo','$var','$tip','','','')";
	mysql_query($sql1);
	//echo $sql1;
	header("location: vasistente.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>

<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "nombre",  "Nombre, $errorMsgJs[empty]" );
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

<table width="58%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $id_minuta;?>">
	<input name="verif" type="hidden" value="<?php if ($_GET[verif]) {echo $_GET[verif];}else{echo "1";};?>">
	<input name="dato" type="hidden" value="<?php echo $dato; ?>">
	<input name="num_cod" type="hidden" value="<?php echo $num_cod; ?>">
	<input name="insertado" type="hidden" value="<?php echo $insertado; ?>">
	<tr> 
      <td > 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
          <tr> 
            <th colspan="3" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">VERIFICAR 
              ASISTENTE </font></th>
          </tr>
          <tr> 
            <th width="10%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="45%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NOMBRE</font></th>
            <th width="45%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CARGO 
              / ROL</font></th>
          </tr>
          <?php
		
		$cont=0;	
		$sql = "SELECT * FROM asistentes WHERE id_minuta='$id_minuta'";
		$result=mysql_db_query($db,$sql,$link);
		
		while($row=mysql_fetch_array($result)) 
  		{
		if ($row[tipo]=='Interno' OR $row[tipo]=='Externo'){
			  $cont=$cont+1;
			  ?>
			  <tr> 
				<td align="center">&nbsp;<?php echo $cont?></td>
				<?php 	$sql5 = "SELECT * FROM users WHERE login_usr='$row[nombre]'";
					$result5 = mysql_db_query($db,$sql5,$link);
					$row5 = mysql_fetch_array($result5);
					if (!$row5[login_usr])
					{echo "<td align=\"center\">&nbsp;$row[nombre]</td>";}
					else
					{echo "<td align=\"center\">&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";}?>
				<td align="center">&nbsp;<?php echo $row[cargo]?></td>
			  </tr>
			  <?php 
		 	}
		 }
		 ?>
          <tr> 
            <td colspan="3" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="23" nowrap height="7"><strong> </strong></td>
            <td width="190" nowrap><div align="center"><strong> 
                <select name="nombre" id="select8">
                  <option value="0"></option>
                  <?php 
				  $sql0 = "SELECT * FROM invitados WHERE id_agenda='$id_minuta'";
				  $result0=mysql_db_query($db,$sql0,$link);
				  while ($row0=mysql_fetch_array($result0)) 
					{
					$sql01 = "SELECT * FROM asistentes WHERE nombre='$row0[nombre]' AND id_minuta='$id_minuta'";
					$result01=mysql_db_query($db,$sql01,$link);
					$row01=mysql_fetch_array($result01);
					if (!$row01[nombre])
					{$sql5 = "SELECT * FROM users WHERE login_usr='$row0[nombre]' ORDER BY apa_usr ASC";
					$result5 = mysql_db_query($db,$sql5,$link);
					$row5 = mysql_fetch_array($result5);
					if (!$row5[login_usr])
						{echo "<option value=\"$row0[nombre]\">$row0[nombre] </option>";}
					else
						{echo "<option value=\"$row5[login_usr]\">$row5[apa_usr] $row5[ama_usr] $row5[nom_usr]</option>";}
				   }}
			 ?>
                </select>
                </strong></div></td>
            <td width="198" nowrap height="7"><div align="center"><strong></strong> 
              </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="3" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
<?php include("top_.php");?>
