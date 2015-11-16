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
if ($Terminar)
header("location: minuta.php?cad=$cad&id_minuta=$var&verif=$verif&insertado=$insertado");
?>
<?php
if ($reg_form)
{   include("conexion.php");
	$flimite="$eano-$emes-$edia";
		$sql35 = "SELECT * FROM temad WHERE tema='$tema' AND id_minuta='$var'";
		$result35=mysql_db_query($db,$sql35,$link);
		$row35=mysql_fetch_array($result35);

	$sql="INSERT INTO ".
	"atema (accion,responsable,flimite,tema,id_minuta,id_tema) ".
	"VALUES ('$accion','$responsable','$flimite','$tema','$var','$row35[id_tema]')";
	mysql_db_query($db,$sql,$link);
	header("location: acciones.php?id_minuta=$var&verif=2&dato=$dato&insertado=$insertado");
}
else { 
include("top.php");
$id_minuta=($_GET['id_minuta']);
?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "tema",  "Tema, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "accion",  "Accion, $errorMsgJs[empty]" );
$valid->addLength ( "accion",  "Accion, $errorMsgJs[length]" );
$valid->addIsNotEmpty ( "responsable",  "Responsable, $errorMsgJs[empty]" );
$valid->addIsDate   ( "edia", "emes", "eano", "Fecha Limite, $errorMsgJs[date]" );
print $valid->toHtml ();
?>  
  
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
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
            <th colspan="9" bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              ACCIONES POR TEMA</font></th>
          </tr>
          <tr> 
            <th width="5%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&ordf;</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">TEMA</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACCION</font></th>
            <th width="28%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">RESPONSABLE</font></th>
            <th width="10%" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              LIMITE</font></th>
          </tr>
          <?php
		$cont=0;	
		$sql = "SELECT *, DATE_FORMAT(flimite, '%d/%m/%Y') AS flimite FROM atema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
		$result=mysql_db_query($db,$sql,$link);
		
		while($row=mysql_fetch_array($result)) 
  		{
		$cont=$cont+1;
		 ?>	
          <tr align="center"> 
            <td>&nbsp;<?php echo $row[id_tema]?></td>
             <?php $sql5 = "SELECT * FROM temas WHERE id_tema='$row[tema]' AND id_agenda='$id_minuta'";
		    	$result5 = mysql_db_query($db,$sql5,$link);
		    	$row5 = mysql_fetch_array($result5);
				if (!$row5[id_tema])
				{echo "<td>&nbsp;$row[tema]</td>";}
				else
				{echo "<td>&nbsp;$row5[tema]</td>";}?>
            <td>&nbsp;<?php echo $row[accion]?></td>
			<?php	$sql5 = "SELECT * FROM users WHERE login_usr='$row[responsable]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo "<td>&nbsp;$row5[nom_usr] $row5[apa_usr] $row5[ama_usr]</td>";?>
            <td>&nbsp;<?php echo $row[flimite]?></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="9" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
            <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="46" height="7" nowrap bgcolor="#006699">
			<div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nuevo</font> 
                </strong></div></td>
            <td nowrap><div align="center"><strong> 
              <select name="tema" id="select8">
              <?php 
			  $sql0 = "SELECT * FROM rtema WHERE id_minuta='$id_minuta' ORDER BY id_tema ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
					$sql01 = "SELECT * FROM atema WHERE id_tema='$row0[id_tema]' AND id_minuta='$id_minuta'";
			  		$result01=mysql_db_query($db,$sql01,$link);
			  		$row01=mysql_fetch_array($result01);
					if (!$row01[tema])
					{$sql5 = "SELECT * FROM temas WHERE id_tema='$row0[tema]'  AND id_agenda='$id_minuta'";
		    		$result5 = mysql_db_query($db,$sql5,$link);
		    		$row5 = mysql_fetch_array($result5);
					if (!$row5[id_tema])
					{echo "<option value=\"$row0[tema]\">$row0[tema] </option>";}
					else
					{echo "<option value=\"$row5[id_tema]\">$row5[tema] </option>";}}
				}
			   ?>
                </select>
                &nbsp;&nbsp; </strong></div></td>
            <td nowrap><div align="center"><strong> 
                <textarea name="accion" cols="30"></textarea>
                </strong></div></td>
            <td width="158" nowrap><div align="center"><strong> 
                <select name="responsable" id="select10">
                  <option value="0"></option>
                  <?php 
			  $sql21 = "SELECT * FROM users WHERE tipo2_usr='T' OR tipo2_usr='A' ORDER BY apa_usr ASC";
			  $result21 = mysql_db_query($db,$sql21,$link);
			  while ($row21 = mysql_fetch_array($result21)) 
				{
				if ($row2[elab_por]==$row21[login_usr])
							echo "<option value=\"$row21[login_usr]\" selected>$row21[apa_usr] $row21[ama_usr] $row21[nom_usr]</option>";
						else
							echo "<option value=\"$row21[login_usr]\">$row21[apa_usr] $row21[ama_usr] $row21[nom_usr]</option>";
	            }
			   ?>
                </select>
                </strong></div></td>
            <td width="200" nowrap height="7"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <select name="edia" >
                  <?php
			
				
				$vfecha=date("Y-m-d");
				$a1=substr($vfecha,0,4);
				$m1=substr($vfecha,5,2);
				$d1=substr($vfecha,8,2);
  				
				if($verif==1)
				{	$a1=substr($row2[en_fecha],0,4);
					$m1=substr($row2[en_fecha],5,2);
					$d1=substr($row2[en_fecha],8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			  ?>
                </select>
                <select name="emes">
                  <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="eano">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                </font><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                </font> </strong> </div></td>
          </tr>
          <tr> 
            <td height="28" colspan="9" nowrap> <div align="center"> 
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="submit" name="Terminar" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['edia'], document.forms[form].elements['emes'], document.forms[form].elements['eano']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}			
//-->
</script>
<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
