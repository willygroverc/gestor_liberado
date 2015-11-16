<?php 
if (isset($_REQUEST['RETORNAR'])){header("location: lista_contratos.php");}
if (isset($_REQUEST['GyC'])) 
{ include ("conexion.php");
	include ("validator.php");
	$FechDe=$_REQUEST['AnoD'].'-'.$_REQUEST['MesD'].'-'.$_REQUEST['DiaD'];
	$FechAl=$_REQUEST['AnoA'].'-'.$_REQUEST['MesA'].'-'.$_REQUEST['DiaA'];
        
	$validateForm=new ValidateData;
	$msgInvalid="no es valido<br>";
	$validateDoit=TRUE;
	$errorNumber=0;
	if (!$validateForm->isTextNormal($_REQUEST['TipoContra'])) {
	    $errorForm[$errorNumber++]="Contrato: ".$msgInvalid;
		$validateDoit=FALSE;		
	}
	if (!$validateForm->isTextNormal($_REQUEST['CodLegalContra'])) {
	    $errorForm[$errorNumber++]="Contrato Legal: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isTextNormal(isset($_REQUEST['EmpContra']))) {
	    $errorForm[$errorNumber++]="Empresa Contratante: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isNotNull($_REQUEST['PartCont'])) {
	    $errorForm[$errorNumber++]="Parte Contratante: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isTextNormal($_REQUEST['RepresLegal'])) {
	    $errorForm[$errorNumber++]="Representante Legal: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isTextNormal($_REQUEST['MontoContra'])) {
	    $errorForm[$errorNumber++]="Monto: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isNum($_REQUEST['CentContra'])) {
	    $errorForm[$errorNumber++]="Monto: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isDate($FechDe, FALSE)) {
	    $errorForm[$errorNumber++]="Fecha de: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isDate($FechAl, FALSE)) {
	    $errorForm[$errorNumber++]="Fecha al: ".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->compareDate($FechDe, $FechAl)) {
	    $errorForm[$errorNumber++]="Fecha de Inicio del contrato debe ser menor o igual a la Fecha de Conclusion.<br>";
		$validateDoit=FALSE;
	}
	if ($validateDoit) {
    	$sql2 = "SELECT * FROM control_parametros";
 	 	$result2 = mysql_query($sql2);
  		$row2 = mysql_fetch_array($result2); 
                
                        $TipoContra=$_REQUEST['TipoContra'];
                        $CodLegalContra=$_REQUEST['CodLegalContra'];
                        $PartCont=$_REQUEST['PartCont'];
                        $RepresLegal=$_REQUEST['RepresLegal'];
                        $MoneContra=$_REQUEST['MoneContra'];
                        $MontoContra=$_REQUEST['MontoContra'];
                        $CentContra=$_REQUEST['CentContra'];
                        $OtrosContra=$_REQUEST['OtrosContra'];
                        $FormaPago=$_REQUEST['FormaPago'];
                        $Entrega=$_REQUEST['Entrega'];
                        $area=$_REQUEST['area'];
		if ($indefinido=="1")
		{
                        /*$TipoContra=isset($_REQUEST['TipoContra']);
                        $CodLegalContra=isset($_REQUEST['CodLegalContra']);
                        $PartCont=isset($_REQUEST['PartCont']);
                        $RepresLegal=isset($_REQUEST['RepresLegal']);
                        $MoneContra=isset($_REQUEST['MoneContra']);
                        $MontoContra=isset($_REQUEST['MontoContra']);
                        $CentContra=isset($_REQUEST['CentContra']);
                        $OtrosContra=isset($_REQUEST['OtrosContra']);
                        $FormaPago=isset($_REQUEST['FormaPago']);
                        $Entrega=isset($_REQUEST['Entrega']);
                        $area=isset($_REQUEST['area']);*/
			$sql="INSERT INTO ".
			"contratodatos (TipoContra,CodLegalContra,EmpContra,PartCont,RepresLegal,MoneContra,MontoContra,CentContra,".
	        "FechDe,FechAl,OtrosContra,FormaPago,Entrega,area,ClausContra,SalvagContra,OtroDetalle,ObsContra,Ejecucion,Cierre,motivo_cierre,file,observacion) ".
			"VALUES ('$TipoContra','$CodLegalContra','$row2[nombre]','$PartCont','$RepresLegal','$MoneContra','$MontoContra','$CentContra',".
	        "'$FechDe','2030-12-31','$OtrosContra','$FormaPago','$Entrega','$area','0','0','0','0','0','0','0','','0')";
		   } else {
			$sql="INSERT INTO ".
			"contratodatos (TipoContra,CodLegalContra,EmpContra,PartCont,RepresLegal,MoneContra,MontoContra,CentContra,".
	        "FechDe,FechAl,OtrosContra,FormaPago,Entrega,area,ClausContra,SalvagContra,OtroDetalle,ObsContra,Ejecucion,Cierre,motivo_cierre,file,observacion) ".
			"VALUES ('$TipoContra','$CodLegalContra','$row2[nombre]','$PartCont','$RepresLegal','$MoneContra','$MontoContra','$CentContra',".
	        "'$FechDe','$FechAl','$OtrosContra','$FormaPago','$Entrega','$area','0','0','0','0','0','0','0','','0')";
                }

		mysql_query($sql);
		$executeDoit=mysql_affected_rows();
		//print "execute".$executeDoit;
		if($executeDoit!=1) {
			$errorMsg="Precaucion, no se han registrado los datos. Verifique que el Codigo Legal no exista. \\n\\nMensaje generado por GesTor F1. ";//$errorForm[$errorNumber++]="Error al registrar los datos.<br>";
			}
		$sql2 = "SELECT MAX(IdContra) AS ID FROM contratodatos";
	  	$result2=mysql_db_query($db,$sql2,$link);
	  	$row2=mysql_fetch_array($result2);
	}
	if ($validateDoit AND $executeDoit==1) {
	    if ($_REQUEST['Entrega']=="UNICA")
		{	
                        $TipoContra=$_REQUEST['TipoContra'];
                        $MontoContra=$_REQUEST['MontoContra'];
                        $CentContra=$_REQUEST['CentContra'];
                        $area=$_REQUEST['area'];
                                
                        $sql="INSERT INTO ".
			"contratofases (IdContra,Fase,Detalle,Monto,FechaVenc,Garantia,VencPlazo,area) ".
			"VALUES ('$row2[ID]','1','$TipoContra','$MontoContra.$CentContra','$FechAl','NA','$FechAl','$area')";
			mysql_query($sql);
			header("location: contrato2.php?varia1=$row2[ID]&numfase=1");
		}
		else
		{header("location: contrato2.php?varia1=$row2[ID]&varia3=1");}
	}

}
include ("top.php");
if (isset($errorForm)) {
    foreach ($errorForm as $tmp){
			$errorMsg=$tmp;
		}
}
 ?>
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "TipoContra",  "Contrato, $errorMsgJs[expresion]" );
$valid->addIsTextNormal ( "CodLegalContra",  "Codigo Legal, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "PartCont",  "Parte Contratada, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "RepresLegal",  "Representante Legal, $errorMsgJs[expresion]" );
$valid->addExists ( "MontoContra", "Monto, $errorMsgJs[empty]");
$valid->addIsNumber ( "CentContra",  "Monto en Decimal, $errorMsgJs[expresion]" );
$valid->addIsDate   ( "DiaD", "MesD", "AnoD", "Fecha de Inicio, $errorMsgJs[date]" );
//$valid->addIsDate   ( "DiaA", "MesA", "AnoA", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "DiaD", "MesD", "AnoD","DiaA", "MesA", "AnoA", "Fecha de y Fecha a, $errorMsgJs[compareDates]");
$valid->addFunction ( "validaMonto",  "" );
echo $valid->toHtml ();
?>
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
		else
		{
			if (form.MontoContra.value>9000000){
			alert ("Monto, debe ser un valor menor o igual a 9000000" + msg);
			return ( false );
			}
		}
	}
	return true;
}
-->
</script>
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
    <td> 
      <form name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" onKeyPress="return Form()">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
                <strong>LLENADO DE FORMULARIO DE CONTRATOS</strong></font></div></td>
          </tr>
        </table>
          <table width="100%" cellspacing="0" cellpadding="0">
          <tr><td height="5">&nbsp;</td></tr>
		  <tr> 
          	<td> <div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"><strong> 
                  CONTRATO&nbsp;&nbsp;&nbsp; :</strong></font> &nbsp;&nbsp;&nbsp; 
                  <input name="TipoContra" type="text" value="<?php $TipoContra=isset($_REQUEST['TipoContra']); if(!empty($TipoContra)) echo $TipoContra; ?>" size="40" maxlength="50">
                </p>
              </div></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="28%"><div align="center"></div></td>
            <td width="43%"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CODIGO 
              LEGAL </strong></font><strong>:</strong> 
              <input name="CodLegalContra" type="text" value="<?php $CodLegalContra=  isset($_REQUEST['CodLegalContra']); if(!empty($CodLegalContra)) echo $CodLegalContra; ?>" size="30" maxlength="30" <?php print $CodLegalContra?>> </td>
            <td width="29%">&nbsp;</td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> <strong>PARTES 
              CONTRATANTES</strong> </font></td>
          </tr>
        </table>
        <table width="100%" cellpadding="0" cellspacing="0">
          <tr> 
            <td><blockquote> 
                
                <p><font size="2" face="Arial, Helvetica, sans-serif">EMPRESA 
                  CONTRATANTE : &nbsp;
                  <?php 
				  	$sql = "SELECT * FROM control_parametros";
			 	 	$result = mysql_db_query($db,$sql,$link);
			  		$row = mysql_fetch_array($result); 
					 echo $row['nombre']; ?>
                  </font> </p>
                <p><font size="2" face="Arial, Helvetica, sans-serif">PARTE CONTRATADA&nbsp;&nbsp; 
                  : &nbsp;&nbsp;&nbsp; 
                  <select name="PartCont" id="Proveedor">
                    <option value="0"></option>
                    <?php 
			  $sql = "SELECT * FROM proveedor ORDER BY NombProv ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[IdProv]\"";
                                $PartCont=  isset($_REQUEST['PartCont']);
				if ($PartCont==$row['IdProv']) echo "selected";
				echo "> $row[NombProv] </option>";
	            }
			   ?>
                  </select>
                  </font></p>
                <p><font size="2" face="Arial, Helvetica, sans-serif">REPRESENTANTE 
                  LEGAL :</font> <font size="2" face="Arial, Helvetica, sans-serif">
                  <input name="RepresLegal" type="text" value="<?php $RepresLegal=isset($_REQUEST['RepresLegal']); if(!empty($RepresLegal)) echo $RepresLegal; ?>" size="60" maxlength="40">
                  </font></p>
              </blockquote></td>
          </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>DATOS 
              DEL CONTRATO</strong></font></td>
          </tr>
        </table>
        <p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;MONTO&nbsp;&nbsp; 
          :&nbsp;&nbsp;&nbsp;</font> 
          <select name="MoneContra">
            <?php 
            $MoneContra=  isset($_REQUEST['$MoneContra']);
            $MontoContra=  isset($_REQUEST['MontoContra']);
            $CentContra=  isset($_REQUEST['CentContra']);
            $tmp=array("Bs"=>"Bs", "Sus"=>"\$us");
				foreach($tmp as $k => $v){
					print "<option value=\"$k\"";
					if($k==$MoneContra) print "selected";
					print ">$v</option>";
				}
			?>
          </select>
          <input name="MontoContra" type="text" value="<?php echo $MontoContra ?>" size="10" maxlength="7">
          <input name="CentContra" type="text" size="1" maxlength="2" value="<?php print $CentContra?>">/100</p>
<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;AREA&nbsp;&nbsp; 
              :&nbsp;&nbsp;&nbsp;</font> 
			    <select name="area">
		<?php
		$sql_area="SELECT * FROM datos_adicionales WHERE tipo_dadicional = 'area' ORDER BY nombre_dadicional";
		$res_area=mysql_db_query($db,$sql_area,$link);
		while($row_area=mysql_fetch_array($res_area)){
			echo "<option value='$row_area[id_dadicional]'";
			echo ">$row_area[nombre_dadicional]</option>";
		}
		?>
			 </select> </p>
	
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;FECHA 
              : DE</font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <?php $fsist=date("Y-m-d"); ?>
              <select name="DiaD" id="select19">
                <?php 
				if (isset($_REQUEST['GyC'])) {
					$a1=$_REQUEST['AnoD'];
					$m1=$_REQUEST['MesD'];
					$d1=$_REQUEST['DiaD'];
				}
				else{
					$a1=substr($fsist,0,4);
					$m1=substr($fsist,5,2);
					$d1=substr($fsist,8,2);
				}
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
                <?php for($i=2003;$i<=2030;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong>&nbsp;&nbsp;</font></strong><font size="2" face="Arial, Helvetica, sans-serif">A 
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
              <select name="DiaA" id="select">
                <?php 
				if (isset($_REQUEST['GyC'])) {
					$a2=$_REQUEST['AnoA'];
					$m2=$_REQUEST['MesA'];
					$d2=$_REQUEST['DiaA'];
				}
				else{
					$a2=substr($fsist,0,4);
					$m2=substr($fsist,5,2);
					$d2=substr($fsist,8,2);
				}
					for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d2=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
              </select>
              <select name="MesA" id="select2">
                <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m2=="$i") echo "selected"; echo">$i</option>";
					  }
			      ?>
              </select>
              <select name="AnoA" id="select3">
                <?php for($i=2003;$i<=2030;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a2=="$i") echo "selected"; echo">$i</option>";
				      }
	    			?>
              </select>
              <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"> 
              <label> </label>
              </a></font></strong></font></strong></font></strong></font>
			  <input name="indefinido" type="checkbox" value="1"/> 
			  <font size="2">Indefinido</font></td>
              <label> </label>
              </a></font></strong></font></strong></font></strong></font>
			  	  
			   
            <td width="37%"><font size="2" face="Arial, Helvetica, sans-serif">OTROS 
              :
              <select name="OtrosContra">
			  <?php $OtrosContra=  isset($_REQUEST['OtrosContra']);
                          $tmp=array("NINGUNO"=>"NINGUNO", "RECONOC. FIRMAS"=>"RECONOC. FIRMAS", "PROTOCOLIZACION"=>"PROTOCOLIZACION");
				foreach($tmp as $k => $v){
					print "<option value=\"$v\"";
					if($v==$OtrosContra) print "selected";
					print ">$v</option>";
				}
			?>
              </select>
              </font></td>
          </tr>
        </table><br>

        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td width="63%">&nbsp;<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;FORMA DE PAGO :</font> 
              <select name="FormaPago">
			  <?php $FormaPago=  isset($_REQUEST['FormaPago']);
                          $tmp=array("CONTADO"=>"CONTADO", "CREDITO"=>"CREDITO");
				foreach($tmp as $k => $v){
					print "<option value=\"$v\"";
					if($v==$FormaPago) print "selected";
					print ">$v</option>";
				}
			?>
              </select></td>
            <td width="37%"><font size="2" face="Arial, Helvetica, sans-serif">ENTREGA :</font> 
              <select name="Entrega">
			  	<option value="UNICA">UNICA</option>
			  	<option value="FASES">FASES</option>
			  </select></td>
          </tr>
        </table><br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td align="center"> <div align="right"> </div>
			<input type="submit" name="GyC" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input type="submit" name="RETORNAR" value="RETORNAR">
            </td></tr>
         </table>
        <br>
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
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php
			if (isset($errorMsg)) print "alert (\"$errorMsg\");";
		?>
//-->
</script>
<?php include("top_.php");?>