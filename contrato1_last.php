<?php 
session_start();
$tipo=$_SESSION["tipo"];
if ($tipo<>"A")
header("location: pagina_error.php?variable1=2");
else
{
if (isset($_REQUEST['RETORNAR'])){
    header("location: lista_contratos.php");
    
}elseif(isset($_REQUEST['ModFases'])) 
{	
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
        $FechDe=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
	$FechAl=$_REQUEST['AnoA'].'-'.$_REQUEST['MesA'].'-'.$_REQUEST['DiaA'];
    include ("conexion.php");
    require_once('funciones.php');
    
	$TipoContra=_clean($TipoContra);
	$CodLegalContra=_clean($CodLegalContra);
	$PartCont=_clean($PartCont);
	$RepresLegal=_clean($RepresLegal);
	$MontoContra=_clean($MontoContra);
	$CentContra=_clean($CentContra);
	$FechDe=_clean($FechDe);
	$FechAl=_clean($FechAl);
	$OtrosContra=_clean($OtrosContra);
	$FormaPago=_clean($FormaPago);
	$Entrega=_clean($Entrega);
	$ClausContra=_clean($ClausContra);
	$SalvagContra=_clean($SalvagContra);
	$OtroDetalle=_clean($OtroDetalle);
	$ObsContra=_clean($ObsContra);
	$area=_clean($area);
	
	$TipoContra=SanitizeString($TipoContra);
	$CodLegalContra=SanitizeString($CodLegalContra);
	$PartCont=SanitizeString($PartCont);
	$RepresLegal=SanitizeString($RepresLegal);
	$MontoContra=SanitizeString($MontoContra);
	$CentContra=SanitizeString($CentContra);
	$FechDe=SanitizeString($FechDe);
	$FechAl=SanitizeString($FechAl);
	$OtrosContra=SanitizeString($OtrosContra);
	$FormaPago=SanitizeString($FormaPago);
	$Entrega=SanitizeString($Entrega);
	$ClausContra=SanitizeString($ClausContra);
	$SalvagContra=SanitizeString($SalvagContra);
	$OtroDetalle=SanitizeString($OtroDetalle);
	$ObsContra=SanitizeString($ObsContra);
	$area=SanitizeString($area);
        
        $TipoContra=$_REQUEST['TipoContra'];
	$CodLegalContra=$_REQUEST['CodLegalContra'];
	$PartCont=$_REQUEST['PartCont'];
	$RepresLegal=$_REQUEST['RepresLegal'];
	$MontoContra=$_REQUEST['MontoContra'];
	$CentContra=$_REQUEST['CentContra'];	
	$OtrosContra=$_REQUEST['OtrosContra'];
	$FormaPago=$_REQUEST['FormaPago'];
	$Entrega=$_REQUEST['Entrega'];
	$OtroDetalle=$_REQUEST['OtroDetalle'];
	$ObsContra=$_REQUEST['ObsContra'];
	$area=$_REQUEST['area'];
        $MoneContra=$_REQUEST['MoneContra'];        
        
	$sql9="UPDATE contratodatos SET TipoContra='$TipoContra',CodLegalContra='$CodLegalContra',".
	      "PartCont='$PartCont',RepresLegal='$RepresLegal',MoneContra='$MoneContra',MontoContra='$MontoContra',CentContra='$CentContra',".
		  "FechDe='$FechDe',FechAl='$FechAl',OtrosContra='$OtrosContra',FormaPago='$FormaPago',Entrega='$Entrega',".
          "ClausContra='$ClausContra',SalvagContra='$SalvagContra',OtroDetalle='$OtroDetalle',ObsContra='$ObsContra', area='$area' ".
		  "WHERE IdContra='$_REQUEST[var]'";
	mysql_query($sql9);

	if ($_REQUEST['Entrega']=="UNICA")
		{header("location: contrato2_last.php?variable1=$var&numfase=1");}
	else
		{header("location: contrato2_last.php?variable1=$var");}
}
elseif (isset($_REQUEST['Cambios']))
{
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
	//$FechDe="$AnoD-$MesD-$DiaD";
	//$FechAl="$AnoA-$MesA-$DiaA";
        $FechDe=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
	$FechAl=$_REQUEST['AnoA'].'-'.$_REQUEST['MesA'].'-'.$_REQUEST['DiaA'];
    include ("conexion.php");
	require_once('funciones.php');
	$TipoContra=_clean($TipoContra);
	$CodLegalContra=_clean($CodLegalContra);
	$PartCont=_clean($PartCont);
	$RepresLegal=_clean($RepresLegal);
	$MontoContra=_clean($MontoContra);
	$CentContra=_clean($CentContra);
	$FechDe=_clean($FechDe);
	$FechAl=_clean($FechAl);
	$OtrosContra=_clean($OtrosContra);
	$FormaPago=_clean($FormaPago);
	$Entrega=_clean($Entrega);
	$ClausContra=_clean($ClausContra);
	$SalvagContra=_clean($SalvagContra);
	$OtroDetalle=_clean($OtroDetalle);
	$ObsContra=_clean($ObsContra);
	$area=_clean($area);
	
	$TipoContra=SanitizeString($TipoContra);
	$CodLegalContra=SanitizeString($CodLegalContra);
	$PartCont=SanitizeString($PartCont);
	$RepresLegal=SanitizeString($RepresLegal);
	$MontoContra=SanitizeString($MontoContra);
	$CentContra=SanitizeString($CentContra);
	$FechDe=SanitizeString($FechDe);
	$FechAl=SanitizeString($FechAl);
	$OtrosContra=SanitizeString($OtrosContra);
	$FormaPago=SanitizeString($FormaPago);
	$Entrega=SanitizeString($Entrega);
	$ClausContra=SanitizeString($ClausContra);
	$SalvagContra=SanitizeString($SalvagContra);
	$OtroDetalle=SanitizeString($OtroDetalle);
	$ObsContra=SanitizeString($ObsContra);
        
        $TipoContra=$_REQUEST['TipoContra'];
	$CodLegalContra=$_REQUEST['CodLegalContra'];
	$PartCont=$_REQUEST['PartCont'];
	$RepresLegal=$_REQUEST['RepresLegal'];
	$MontoContra=$_REQUEST['MontoContra'];
	$CentContra=$_REQUEST['CentContra'];	
	$OtrosContra=$_REQUEST['OtrosContra'];
	$FormaPago=$_REQUEST['FormaPago'];
	$Entrega=$_REQUEST['Entrega'];
	$OtroDetalle=$_REQUEST['OtroDetalle'];
	$ObsContra=$_REQUEST['ObsContra'];
	$area=$_REQUEST['area'];
        $MoneContra=$_REQUEST['MoneContra'];
        
	$sql9="UPDATE contratodatos SET TipoContra='$TipoContra',CodLegalContra='$CodLegalContra',".
	      "PartCont='$PartCont',RepresLegal='$RepresLegal',MoneContra='$MoneContra',MontoContra='$MontoContra',CentContra='$CentContra',".
		  "FechDe='$FechDe',FechAl='$FechAl',OtrosContra='$OtrosContra',FormaPago='$FormaPago',Entrega='$Entrega',".
          "ClausContra='$ClausContra',SalvagContra='$SalvagContra',OtroDetalle='$OtroDetalle',ObsContra='$ObsContra',area='$area' ".
		  "WHERE IdContra='$_REQUEST[var]'";

	mysql_db_query($db,$sql9,$link);
	header("location: lista_contratos.php");

}else {
include ("top.php"); 
$IdContra=($_GET['IdContra']);
$sql = "SELECT * FROM contratodatos WHERE Idcontra='$IdContra'";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);  ?>
<script language="JavaScript">
<!--
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
function validaMonto () {
	var form=document.form1;
	var msg="\n \n Mensaje generado por GesTor F1.";
	if (form.MontoContra.value.length > 0) {
		if (form.MontoContra.value.search(new RegExp("^([0-9])+$","g"))<0) {
			alert ("Monto, debe ser un valor numerico entero" + msg);
			return ( false );
		}
		
	}
	return true;
}
function valida(){
	var form=document.form1;
	<?php  $sqln = "SELECT Entrega FROM contratodatos WHERE Idcontra='$IdContra'";
		$resultn=mysql_db_query($db,$sqln,$link);
		$rown=mysql_fetch_array($resultn); ?>
	var ant="<?php echo $rown['Entrega'];?>";
	if (ant=="FASES" && form.Entrega.value=="UNICA") 
	{alert ("Entrega, no puede pasar de Varias Fases a una Unica fase.\n \nMensaje generado por GesTor F1.");
		return (false);
	}
	return true;
}
-->
</script>
<script language="JavaScript" src="calendar.js"></script>
<SCRIPT language="JavaScript">
<!--
function validateForm1	(){
	var form=document.form1;
	if (!form.Generales.checked && !form.Especificas.checked && !form.Necesarias.checked && !form.Anexos.checked && !form.Otros.checked ) {
		alert ("Clausulas, debe seleccionar una opcion.\n \nMensaje generado por GesTor F1.");
		return false;
		}
	if (!form.Confidencialidad.checked && !form.Propiedad.checked && !form.Disponibilidad.checked && !form.Auditabilidad.checked && !form.Arbitraje.checked ) {
		alert ("Salvaguardas Contractuales, debe seleccionar una opcion.\n \nMensaje generado por GesTor F1.");
		return false;
	}
	return true;
}
//-->
</SCRIPT>

<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "TipoContra",  "Contrato, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "CodLegalContra",  "Codigo Legal, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "EmpContra",  "Empresa Contratante, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "PartCont",  "Parte Contratada, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "RepresLegal",  "Representante Legal, $errorMsgJs[expresion]" );
$valid->addExists ( "MontoContra", "Monto, $errorMsgJs[empty]");
$valid->addIsNumber ( "CentContra",  "Monto en Decimal, $errorMsgJs[expresion]" );
$valid->addIsDate   ( "DiaD", "MesD", "AnoD", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate   ( "DiaA", "MesA", "AnoA", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DiaD", "MesD", "AnoD","DiaA", "MesA", "AnoA", "Fecha de y Fecha a, $errorMsgJs[compareDates]");
$valid->addLength("OtroDetalle", "Otros Detalles,  $errorMsgJs[length]");
$valid->addLength("ObsContra", "Observaciones,  $errorMsgJs[length]");
$valid->addFunction ("validateForm1", "Descripcion");
$valid->addFunction ( "validaMonto",  "" );
$valid->addFunction ( "valida",  "" );
echo $valid->toHtml ();
?>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td height="650"> 
      <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
        <input name="var" type="hidden" value="<?php echo $IdContra;?>">
	  	<table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td background="images/main-button-tileR1.jpg" height="20">
<div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>FORMULARIO DE CONTRATOS</strong></font></div></td>
          </tr>
		  <tr> 
            <td> <div align="left">&nbsp;&nbsp;&nbsp;<font size="2" face="Arial, Helvetica, sans-serif"><strong>N&deg; 
                Contrato :</strong> <?php echo $IdContra;?></font><br>
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CONTRATO&nbsp;&nbsp;&nbsp;&nbsp; 
                        :</strong></font> &nbsp;&nbsp;&nbsp; 
                        <input name="TipoContra" type="text" value="<?php echo $row['TipoContra'];?>" size="40" maxlength="50">
                      </div></td>
                  </tr>
                </table>
              </div>
            </td>
      
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <!--DWLayoutTable-->
          <tr> 
            <td width="28%"><div align="center"></div></td>
            <td width="385"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO 
              LEGAL :</strong></font> 
              <input name="CodLegalContra" type="text" value="<?php echo $row['CodLegalContra'];?>" size="30" maxlength="30" readonly="true"> </td>
            <td width="29%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td height="19">&nbsp;</td>
            <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><strong>AREA </strong></font><strong>:</strong>
              <label>
              <select name="area" id="area" >
                <?php
			  $sql="SELECT * FROM area";
			  $datos=mysql_db_query($db,$sql,$link);
			  while ($area=mysql_fetch_array($datos)) {
			  if ($row['area']==$area['area_nombre']){
			  echo " <option value=$area[area_nombre] selected>$area[area_nombre]</option>";
			  } else {echo " <option value=$area[area_nombre]>$area[area_nombre]</option>";}
			  }
			   ?>
              </select>
              </label></td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> <strong>PARTES 
              CONTRATANTES</strong> </font></td>
          </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td><blockquote> 
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">EMPRESA 
                      CONTRATANTE :</font> <font size="2" face="Arial, Helvetica, sans-serif"> 
                      <?php 	$sql8 = "SELECT * FROM control_parametros";
			 	 		$result8 = mysql_db_query($db,$sql8,$link);
			  			$row8 = mysql_fetch_array($result8);
						echo $row8['nombre'];?>
                      </font><font size="3" face="Arial, Helvetica, sans-serif"> 
                      </font></div></td>
                  </tr>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>                    
                  <td><font size="2" face="Arial, Helvetica, sans-serif">PARTE 
                    CONTRATADA&nbsp;&nbsp;&nbsp; : &nbsp;&nbsp;&nbsp; 
                    <select name="PartCont">
                      <option value="0"></option>
                      <?php 
			     $sql3 = "SELECT * FROM proveedor ORDER BY NombProv ASC";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['PartCont']==$row3['IdProv'])
				 			echo "<option value=\"$row3[IdProv]\" selected> $row3[NombProv]</option>";
				   else
							echo "<option value=\"$row3[IdProv]\"> $row3[NombProv] </option>";
	               }
			     ?>
                    </select>
                    </font></td>
                  </tr>
                </table>
                <table width="100%" cellspacing="0" cellpadding="0">
                  <tr>
                    
                  <td><font size="2" face="Arial, Helvetica, sans-serif">REPRESENTANTE 
                    LEGAL&nbsp; :</font> 
                    <input name="RepresLegal" type="text" value="<?php echo $row['RepresLegal']?>" size="60" maxlength="40"> 
                    </td>
                  </tr>
                </table>
                
                <br>
            

        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>DATOS 
              DEL CONTRATO</strong></font></td>
          </tr>
        </table>
        
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;MONTO&nbsp;&nbsp; 
              :&nbsp;&nbsp;&nbsp;</font> 
			    <select name="MoneContra">
                <option value="Bs" <?php if ($row['MoneContra']=="Bs") echo "selected";?>>Bs</option>
          		<option value="Sus" <?php if ($row['MoneContra']=="Sus") echo "selected";?>>$us</option>
			 </select> 
			 <input name="MontoContra" type="text" value="<?php echo $row['MontoContra']?>" size="10" maxlength="7"> 
             <input name="CentContra" type="text" size="1" maxlength="2" value="<?php echo $row['CentContra']?>">
              /100 </td>
          </tr>
        </table>
        
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;FECHA 
              DE :</font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaD" id="select19">
                <?php
  				$a1=substr($row['FechDe'],0,4);
				$m1=substr($row['FechDe'],5,2);
				$d1=substr($row['FechDe'],8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesD" id="select20">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
              </select>
              <select name="AnoD" id="select21">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
              &nbsp;&nbsp;</font></strong><font size="2" face="Arial, Helvetica, sans-serif">A 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaA" id="select22">
                <?php
  				$a2=substr($row['FechAl'],0,4);
				$m2=substr($row['FechAl'],5,2);
				$d2=substr($row['FechAl'],8,2);
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesA" id="select23">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
              </select>
              <select name="AnoA" id="select24">
                <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong> 
              </font></strong></font></td>
            <td width="37%"><font size="2" face="Arial, Helvetica, sans-serif">OTROS 
              :
              <select name="OtrosContra">
          <option value="NINGUNO" <?php if ($row['OtrosContra']=="NINGUNO") echo "selected";?>>NINGUNO</option>
		  <option value="RECONOC. FIRMAS" <?php if ($row['OtrosContra']=="RECONOC. FIRMAS") echo "selected";?>>RECONOC. FIRMAS</option>
          <option value="PROTOCOLIZACION" <?php if ($row['OtrosContra']=="PROTOCOLIZACION") echo "selected";?>>PROTOCOLIZACION</option>
              </select>
              </font></td>
          </tr>
        </table>

        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;FORMA DE PAGO :</font> 
              <select name="FormaPago">
                <option value="CONTADO" <?php if ($row['FormaPago']=="CONTADO") echo "selected";?>>CONTADO</option>
		        <option value="CREDITO" <?php if ($row['FormaPago']=="CREDITO") echo "selected";?>>CREDITO</option>
              </select></td>
            <td width="37%"><font size="2" face="Arial, Helvetica, sans-serif">ENTREGA :</font> 
              <select name="Entrega">
                <option value="UNICA" <?php if ($row['Entrega']=="UNICA") echo "selected";?>>UNICA</option>
          		<option value="FASES" <?php if ($row['Entrega']=="FASES") echo "selected";?>>FASES</option>
              </select></td>
          </tr>
        </table>
        <br>
		<?php 
		$sql7 = "SELECT *, DATE_FORMAT(FechaVenc, '%d/%m/%Y') AS FechaVenc, DATE_FORMAT(VencPlazo, '%d/%m/%Y') AS VencPlazo FROM contratofases WHERE IdContra='$IdContra' ORDER BY Fase ASC";
		$result7=mysql_db_query($db,$sql7,$link); ?>
        <table width="95%" border="2" align="center" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td width="6%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">FASE</font></strong></font></div></td>
            <td width="30%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">DETALLE</font></strong></font></div></td>
            <td width="12%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">MONTO</font></strong></font></div></td>
            <td width="14%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">FECHA 
                VENC.</font></strong></font></div></td>
            <td width="24%" background="images/main-button-tileR1.jpg" height="20"> <div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">GARANTIA</font></strong></font></div></td>
            <td width="14%" background="images/main-button-tileR1.jpg" height="20"><div align="center"><font face="Arial, Helvetica, sans-serif"><strong><font color="#FFFFFF" size="2">VENC. 
                PLAZO</font></strong></font></div></td>
          </tr>
          <?php while($row7=mysql_fetch_array($result7))
						{
		 				?>
          <tr> 
            <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['Fase']?></font></div></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['Detalle']?></font></td>
            <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['Monto']?></font></div></td>
            <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['FechaVenc']?></font></div></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['Garantia']?></font></td>
            <td colspan="2"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row7['VencPlazo']?></font></div></td>
          </tr>
          <?php }?>
          <tr> 
            <td colspan="7">&nbsp;</td>
          </tr>
          <tr> 
            <td colspan="7"><div align="right"> 
                <input type="submit" name="ModFases" value="MODIFICAR FASES" <?php print $valid->onSubmit()?>>
              </div></td>
          </tr>
        </table>
        <br>

        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              <strong>CLAUSULAS</strong> </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">
			<?php
  				$G=substr($row['ClausContra'],0,1);
				$E=substr($row['ClausContra'],2,1);
				$N=substr($row['ClausContra'],4,1);
				$A=substr($row['ClausContra'],6,1);
				$O=substr($row['ClausContra'],8,1);
				$O1=substr($row['ClausContra'],10,25);?>
			
			&nbsp;&nbsp;&nbsp; <input name="Generales" type="checkbox" value="G" <?php if ($G=="G") echo "checked";?>> 
              Generales</td>
            <td width="30%"><input type="checkbox" name="Especificas" value="E" <?php if ($E=="E") echo "checked";?>>
              Especificas</td>
            <td width="39%"> <input type="checkbox" name="Necesarias" value="N"<?php if ($N=="N") echo "checked";?>>
              Necesarias</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%" height="25">&nbsp;&nbsp;&nbsp; <input type="checkbox" name="Anexos" value="A" <?php if ($A=="A") echo "checked";?>>
              Anexos</td>
            <td width="69%"><input type="checkbox" name="Otros" value="O" <?php if ($O=="O") echo "checked";?>>
              Otros 
              <input name="Otros1" type="text" size="30" maxlength="25" value="<?php echo $O1?>"></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td background="images/main-button-tileR1.jpg" height="20"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>SALVAGUARDAS 
              CONTRACTUALES</strong></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">
			<?php
  				$C=substr($row['SalvagContra'],0,1);
				$P=substr($row['SalvagContra'],2,1);
				$D=substr($row['SalvagContra'],4,1);
				$A=substr($row['SalvagContra'],6,1);
				$R=substr($row['SalvagContra'],8,1);?>
			&nbsp;&nbsp;&nbsp; <input type="checkbox" name="Confidencialidad" value="C" <?php if ($C=="C") echo "checked";?>>
              Confidencialidad</td>
            <td width="30%"><input type="checkbox" name="Propiedad" value="P" <?php if ($P=="P") echo "checked";?>>
              Propiedad Intelectual</td>
            <td width="39%"> <input type="checkbox" name="Disponibilidad" value="D" <?php if ($D=="D") echo "checked";?>>
              Disponibilidad</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="31%">&nbsp;&nbsp;&nbsp; <input type="checkbox" name="Auditabilidad" value="A" <?php if ($A=="A") echo "checked";?>>
              Auditabilidad</td>
            <td> <input type="checkbox" name="Arbitraje" value="R" <?php if ($R=="R") echo "checked";?>>
              Arbitraje </td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr bgcolor="#006699"> 
            <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>OTROS 
                DETALLES</strong></font></div></td>
            <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>OBSERVACIONES</strong></font></div></td>
          </tr>
          <tr > 
            <td height="72">
<div align="center"> 
                <textarea name="OtroDetalle" cols="37"><?php echo $row['OtroDetalle']?></textarea>
              </div></td>
            <td><div align="center"> 
                <textarea name="ObsContra" cols="37" ><?php echo $row['ObsContra']?></textarea>
              </div></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center"> <br>
                <input type="submit" name="Cambios" value="GUARGAR CAMBIOS" <?php print $valid->onSubmit()?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
      </form>
      
    </td>
  </tr>
</table>
 <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DiaD'], document.forms[form].elements['MesD'], document.forms[form].elements['AnoD']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		var cal1 = new calendar1(document.forms[form].elements['DiaA'], document.forms[form].elements['MesA'], document.forms[form].elements['AnoA']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;

//-->
</script>
 <?php } include("top_.php"); }?>