<?php 
if (isset($_REQUEST['Guardar']))
	{include("conexion.php");
        $Generales=$_REQUEST['Generales'];
	$Especificas=$_REQUEST['Especificas'];
	$Necesarias=$_REQUEST['Necesarias'];
	$Anexos=$_REQUEST['Anexos'];
	$Otros=$_REQUEST['Otros'];
	$Otros1=$_REQUEST['Otros1'];
	$Confidencialidad=$_REQUEST['Confidencialidad'];
	$Propiedad=$_REQUEST['Propiedad'];
	$Disponibilidad=$_REQUEST['Disponibilidad'];
	$Auditabilidad=$_REQUEST['Auditabilidad'];
	$Arbitraje=$_REQUEST['Arbitraje'];
                
	if ($Generales=="") {$Generales="Z";}
	if ($Especificas=="") {$Especificas="Z";}
	if ($Necesarias=="") {$Necesarias="Z";}
	if ($Anexos=="") {$Anexos="Z";}
	if ($Otros=="") {$Otros="Z";}
	if ($Otros1=="") {$Otros1=" ";}
	if ($Confidencialidad=="") {$Confidencialidad="Z";}
	if ($Propiedad=="") {$Propiedad="Z";}
	if ($Disponibilidad=="") {$Disponibilidad="Z";}
	if ($Auditabilidad=="") {$Auditabilidad="Z";}
	if ($Arbitraje=="") {$Arbitraje="Z";}
	$ClausContra="$Generales,$Especificas,$Necesarias,$Anexos,$Otros,$Otros1";
	$SalvagContra="$Confidencialidad,$Propiedad,$Disponibilidad,$Auditabilidad,$Arbitraje";
	require_once("funciones.php");
	$ObsContra=_clean($ObsContra);
	$ObsContra=SanitizeString($ObsContra);
        $ObsContra=$_REQUEST['ObsContra'];
        
	$OtroDetalle=_clean($OtroDetalle);
	$OtroDetalle=SanitizeString($OtroDetalle);
        $OtroDetalle=$_REQUEST['OtroDetalle'];
	
  	$sql5="UPDATE contratodatos SET ClausContra='$ClausContra',SalvagContra='$SalvagContra',".
	      "OtroDetalle='$OtroDetalle',ObsContra='$ObsContra'"." WHERE IdContra='$_REQUEST[var1]'";
        mysql_db_query($db,$sql5,$link);
	header("location: lista_contratos.php");}

elseif (isset($_REQUEST['insertar']))
{   include("conexion.php");
	$FechaVenc=$_REQUEST['AnoV'].'-'.$_REQUEST['MesV'].'-'.$_REQUEST['DiaV'];
	$VencPlazo=$_REQUEST['AnoVP'].'-'.$_REQUEST['MesVP'].'-'.$_REQUEST['DiaVP'];
       
	require_once("funciones.php");
	$Detalle=_clean($Detalle);
	$Detalle=SanitizeString($Detalle);
        $Detalle=$_REQUEST['Detalle'];
	$Monto=_clean($Monto);
	$Monto=SanitizeString($Monto);
        $Monto=$_REQUEST['Monto'];
	$Garantia=_clean($Garantia);
	$Garantia=SanitizeString($Garantia);
        $Garantia=$_REQUEST['Garantia'];
	$Otros1=_clean($Otros1);
	$Otros1=SanitizeString($Otros1);
        $Otros1=$_REQUEST['Otros1'];
	
	
	$sql="INSERT INTO ".
	"contratofases (IdContra,Fase,Detalle,Monto,FechaVenc,Garantia,VencPlazo,area) ".
	"VALUES ('$_REQUEST[var1]','$_REQUEST[var3]','$Detalle','$Monto','$FechaVenc','$Garantia','$VencPlazo','$area')";

	mysql_query($sql);
        $var3=$_REQUEST[var3];
	$var3=$var3+1;
	print("$Fase");
	header("location: contrato2.php?varia1=$_REQUEST[var1]&varia3=$_REQUEST[var3]");
}
else { 
include("top.php");
$IdContra= $_GET['varia1'];
$Fase=$_GET['varia3'];
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
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language="JavaScript">
<!--
function validateForm1(){
	var form=document.form2;
	if (!form.Generales.checked && !form.Especificas.checked && !form.Necesarias.checked && !form.Anexos.checked && !form.Otros.checked ) {
		alert ("Clausulas, debe seleccionar una opcion.\n \nMensaje generado por GesTor F1.");
		return false;
		}
	if (!form.Confidencialidad.checked && !form.Propiedad.checked && !form.Disponibilidad.checked && !form.Auditabilidad.checked && !form.Arbitraje.checked ) {
		alert ("Salvaguardas Contractuales, debe seleccionar una opcion.\n \nMensaje generado por GesTor F1.");
		return false;
	}
	if (form.OtroDetalle.value.length>500) {
		alert ("Otros Detalles, debe ser menor a 500 caracteres.\n \nMensaje generado por GesTor F1.");
		return false
	}
	if (form.ObsContra.value.length>500) {
		alert ("Observaciones, debe ser menor a 500 caracteres.\n \nMensaje generado por GesTor F1.");
		return false
	}
	return true;
}
//-->
</SCRIPT>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsTextNormal ( "Detalle",  "Detalle, $errorMsgJs[expresion]" );
$valid->addLength("Detalle", "Detalle,  $errorMsgJs[length]");
$valid->addIsTextNormal ( "Monto",  "Monto, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "Garantia",  "Garantia, $errorMsgJs[expresion]" );
$valid->addLength("Garantia", "Garantia,  $errorMsgJs[length]");
$valid->addIsDate   ( "DiaV", "MesV", "AnoV", "Fecha de Vencimiento, $errorMsgJs[date]" );
$valid->addIsDate   ( "DiaVP", "MesVP", "AnoVP", "Fecha de Plazo, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DiaV", "MesV", "AnoV","DiaVP", "MesVP", "AnoVP", "Fecha Vencimiento y Vencimiento Plazo, $errorMsgJs[compareDates]");
print $valid->toHtml ();
?>  
<table width="94%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
	<input name="var1" type="hidden" value="<?php echo $_GET['varia1'];?>">
	<input name="var2" type="hidden" value="<?php echo isset($_REQUEST['numfase']);?>">
	<input name="var3" type="hidden" value="<?php echo $Fase;?>">
	<tr> 
      <td height="155"> <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>CONTINUACION LLENADO DE FORMULARIO DE CONTRATOS</strong></font></div></td>
          </tr>
        </table>
       
        <table width="100%" border="2" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th width="46" nowrap background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FASE</font></th>
            <th width="185" nowrap background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">DETALLE</font></th>
            <th width="86" nowrap background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">MONTO</font></th>
            <th width="205" nowrap background="images/main-button-tileR2.jpg"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
                VENC. </font></div></th>
            <th width="184" nowrap background="images/main-button-tileR2.jpg"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">GARANTIA</font></div></th>
            <th width="165" nowrap background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">VENC. 
              PLAZO</font></th>
          </tr>
          <?php
			
		$sql1 = "SELECT *, DATE_FORMAT(FechaVenc, '%d/%m/%Y') AS FechaVenc, DATE_FORMAT(VencPlazo, '%d/%m/%Y') AS VencPlazo FROM contratofases WHERE IdContra='$IdContra' ORDER BY Fase ASC";

                $result1=mysql_db_query($db,$sql1,$link);
		while($row1=mysql_fetch_array($result1)) 
  		{ 
		 ?>
          <tr align="center"> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Fase']?></font></td>
            <td><div align="left"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Detalle']?></font></div></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Monto']?></div></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['FechaVenc']?></div></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row1['Garantia']?></div></font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php if ($row1['VencPlazo']=="00/00/0000"){echo "NA";}else{echo $row1['VencPlazo'];}?></div></font></td>
          </tr>
          <?php 
		 }
		 if (isset($_REQUEST['numfase'])!=1)
		 {
		 ?>
          <tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="46" nowrap height="7"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif">Nuevo</font></p>
              </div></td>
            <td width="185" nowrap height="3"><div align="center"><strong> 
                <textarea name="Detalle" cols="25"></textarea>
                </strong> </div></td>
            <td width="86" nowrap height="7"><div align="center"><strong> 
                <input name="Monto" type="text" id="estado_seg4" size="10" maxlength="9">
                </strong></div></td>
            <td width="205" nowrap height="7"> <div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
                <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
                <select name="DiaV" id="select13">
                  <?php
				   	$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
                </select>
                <select name="MesV" id="select14">
                  <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
                </select>
                <select name="AnoV" id="select15">
                  <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
                </select>
                <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
                </font> </strong></div></td>
            <td height="7" nowrap> <div align="center">
                <textarea name="Garantia" cols="20"></textarea>
              </div></td>
            <td nowrap><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php 
			  $fsist=date("Y-m-d");
			  
			   ?>
              <select name="DiaVP" id="select2">
                <?php
				   	$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
              </select>
              <select name="MesVP" id="select5">
                <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoVP" id="select6">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
              </font></strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="6" nowrap> <div align="center"> 
                <input name="insertar" type="submit" id="reg_form3" value="INSERTAR DATOS" <?php print $valid->onSubmit() ?>>
              </div></td>
          </tr>
		 <?php }?>
        </table>
        
        <br>

        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <strong>&nbsp;&nbsp;&nbsp;&nbsp;CLAUSULAS</strong> </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">&nbsp;&nbsp;&nbsp; 
              <input type="checkbox" name="Generales" value="G">
              Generales</td>
            <td width="30%"><input type="checkbox" name="Especificas" value="E">
              Especificas</td>
            <td width="39%"> <input type="checkbox" name="Necesarias" value="N">
              Necesarias</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="31%" height="25">&nbsp;&nbsp;&nbsp; 
              <input type="checkbox" name="Anexos" value="A">
              Anexos</td>
            <td width="69%"><input type="checkbox" name="Otros" value="O">
              Otros 
              <input name="Otros1" type="text" size="30" maxlength="25"></td>
          </tr>
        </table>
        <br>
<table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;&nbsp;SALVAGUARDAS 
              CONTRACTUALES</strong></font></td>
  </tr>
</table>
<table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">&nbsp;&nbsp;&nbsp; <input type="checkbox" name="Confidencialidad" value="C">
              Confidencialidad</td>
            <td width="30%"><input type="checkbox" name="Propiedad" value="P">
              Propiedad Intelectual</td>
            <td width="39%"> <input type="checkbox" name="Disponibilidad" value="D">
              Disponibilidad</td>
          </tr>
        </table> 
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">&nbsp;&nbsp;&nbsp; <input type="checkbox" name="Auditabilidad" value="A">
              Auditabilidad</td>
            <td> <input type="checkbox" name="Arbitraje" value="R">
              Arbitraje </td>
          </tr>
        </table>
		<br>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>OTROS 
                DETALLES</strong></font></div></td>
            <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>OBSERVACIONES</strong></font></div></td>
          </tr>
          <tr>
            <td><div align="center">
                <textarea name="OtroDetalle" cols="37"></textarea>
              </div></td>
			  
            <td><div align="center">
                <textarea name="ObsContra" cols="37"></textarea>
              </div></td>
          </tr>
        </table>
		<div align="center"><br>
          <input type="submit" name="Guardar" value="GUARDAR" onClick="return validateForm1()">
        </div></td>
    </tr></form>
  </table>
<script language="JavaScript">
		<!-- 
		 var form="form2";
		<?php if (isset($_REQUEST['numfase'])!=1){?>
		var cal = new calendar1(document.forms[form].elements['DiaV'], document.forms[form].elements['MesV'], document.forms[form].elements['AnoV']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DiaVP'], document.forms[form].elements['MesVP'], document.forms[form].elements['AnoVP']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php }?>
//-->
</script>

<p> 
  <?php } ?>
</p>
<?php include("top_.php");?>
