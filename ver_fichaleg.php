<?php
include ("top_ver.php");
function numletras($numero){
$aux1=  isset($aux1)*100;
function Centenas($VCentena) { 
$Numeros[0] = "cero"; 
$Numeros[1] = "uno"; $Numeros[2] = "dos"; $Numeros[3] = "tres"; $Numeros[4] = "cuatro"; $Numeros[5] = "cinco"; $Numeros[6] = "seis"; $Numeros[7] = "siete"; $Numeros[8] = "ocho"; $Numeros[9] = "nueve"; $Numeros[10] = "diez"; $Numeros[11] = "once"; $Numeros[12] = "doce"; $Numeros[13] = "trece"; $Numeros[14] = "catorce"; $Numeros[15] = "quince"; $Numeros[20] = "veinte"; $Numeros[30] = "treinta"; $Numeros[40] = "cuarenta"; $Numeros[50] = "cincuenta"; $Numeros[60] = "sesenta"; 
$Numeros[70] = "setenta"; $Numeros[80] = "ochenta"; $Numeros[90] = "noventa"; $Numeros[100] = "ciento"; $Numeros[101] = "quinientos"; $Numeros[102] = "setecientos"; $Numeros[103] = "novecientos"; 
If ($VCentena == 1) { return $Numeros[100]; } 
Else If ($VCentena == 5) { return $Numeros[101];} 
Else If ($VCentena == 7 ) {return ( $Numeros[102]); } 
Else If ($VCentena == 9) {return ($Numeros[103]);} 
Else {return $Numeros[$VCentena];} 
} 
function Unidades($VUnidad) { 
$Numeros[0] = "cero"; $Numeros[1] = "un"; $Numeros[2] = "dos"; $Numeros[3] = "tres"; $Numeros[4] = "cuatro"; $Numeros[5] = "cinco"; $Numeros[6] = "seis"; $Numeros[7] = "siete"; $Numeros[8] = "ocho"; $Numeros[9] = "nueve"; $Numeros[10] = "diez"; $Numeros[11] = "once"; $Numeros[12] = "doce"; $Numeros[13] = "trece"; $Numeros[14] = "catorce"; $Numeros[15] = "quince"; $Numeros[20] = "veinte"; $Numeros[30] = "treinta"; $Numeros[40] = "cuarenta"; $Numeros[50] = "cincuenta"; $Numeros[60] = "sesenta"; $Numeros[70] = "setenta"; $Numeros[80] = "ochenta"; $Numeros[90] = "noventa"; $Numeros[100] = "ciento"; $Numeros[101] = "quinientos"; $Numeros[102] = "setecientos"; $Numeros[103] = "novecientos"; 
$tempo=$Numeros[$VUnidad]; 
return $tempo; 
} 
function Decenas($VDecena) { 
$Numeros[0] = "cero"; $Numeros[1] = "uno"; $Numeros[2] = "dos"; $Numeros[3] = "tres"; $Numeros[4] = "cuatro"; $Numeros[5] = "cinco"; $Numeros[6] = "seis"; $Numeros[7] = "siete"; $Numeros[8] = "ocho"; $Numeros[9] = "nueve"; $Numeros[10] = "diez"; $Numeros[11] = "once"; $Numeros[12] = "doce"; $Numeros[13] = "trece"; $Numeros[14] = "catorce"; $Numeros[15] = "quince"; $Numeros[20] = "veinte"; $Numeros[30] = "treinta"; $Numeros[40] = "cuarenta"; $Numeros[50] = "cincuenta"; $Numeros[60] = "sesenta"; $Numeros[70] = "setenta"; $Numeros[80] = "ochenta"; $Numeros[90] = "noventa"; $Numeros[100] = "ciento"; $Numeros[101] = "quinientos"; $Numeros[102] = "setecientos"; $Numeros[103] = "novecientos"; 
$tempo = ($Numeros[$VDecena]); 
return $tempo; 
} 
function NumerosALetras($Numero){ 
$Decimales = 0; 
$letras = ""; 

while ($Numero != 0){ 

// '*---> Validacion si se pasa de 100 millones 
If ($Numero >= 1000000000) { 
$letras = "Error"; 
$Numero = 0; 
$Decimales = 0; 
} 
// '*---> Centenas de Millon 
If (($Numero < 1000000000) And ($Numero >= 100000000)){ 
	If ((Intval($Numero / 100000000) == 1) And (($Numero - (Intval($Numero / 100000000) * 100000000)) < 1000000)){ 
		$letras .= (string) "cien millones "; 
	} 
	Else { 
		$letras = $letras & Centenas(Intval($Numero / 100000000)); 
		If ((Intval($Numero / 100000000) <> 1) And (Intval($Numero / 100000000) <> 5) And (Intval($Numero / 100000000) <> 7) And (Intval($Numero / 100000000) <> 9)) { 
		$letras .= (string) "cientos "; 
		} 
		Else { 
			$letras .= (string) " "; 
		} 
	} 
	$Numero = $Numero - (Intval($Numero / 100000000) * 100000000); 
}

// '*---> Decenas de Millon 
If (($Numero < 100000000) And ($Numero >= 10000000)) { 
If (Intval($Numero / 1000000) < 16) { 
$tempo = Decenas(Intval($Numero / 1000000)); 
$letras .= (string) $tempo; 
$letras .= (string) " millones "; 
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000); 
} 
else { 
$letras = $letras & Decenas(Intval($Numero / 10000000) * 10); 
$Numero = $Numero - (Intval($Numero / 10000000) * 10000000); 
if ($Numero > 1000000) { 
$letras .= $letras & " y "; 
} 
} 
} 
// '*---> Unidades de Millon 
If (($Numero < 10000000) And ($Numero >= 1000000)) { 
$tempo=(Intval($Numero / 1000000)); 
If ($tempo == 1) { 
$letras .= (string) " un millon "; 
} 
else { 
$tempo= Unidades(Intval($Numero / 1000000)); 
$letras .= (string) $tempo; 
$letras .= (string) " millones "; 
} 
$Numero = $Numero - (Intval($Numero / 1000000) * 1000000); 
} 

// '*---> Centenas de Millar 
if (($Numero < 1000000) And ($Numero >= 100000)) { 
$tempo=(Intval($Numero / 100000)); 
$tempo2=($Numero - ($tempo * 100000)); 
if (($tempo == 1) And ($tempo2 < 1000)) { 
$letras .= (string) "cien mil "; 
} 
else { 
$tempo=Centenas(Intval($Numero / 100000)); 
$letras .= (string) $tempo; 
$tempo=(Intval($Numero / 100000)); 
if (($tempo <> 1) And ($tempo <> 5) And ($tempo <> 7) And ($tempo <> 9)) { 
if ($tempo2 < 1000)
{$letras .= (string) "cientos mil "; }
else
{$letras .= (string) "cientos ";}
} 
else { 
if ($tempo2 < 1000)
{$letras .= (string) " mil"; }
$letras .= (string) " "; 
} 
} 
$Numero = $Numero - (Intval($Numero / 100000) * 100000); 
} 
// '*---> Decenas de Millar 
if (($Numero < 100000) And ($Numero >= 10000)) { 
$tempo= (Intval($Numero / 1000)); 
if ($tempo < 16) { 
$tempo = Decenas(Intval($Numero / 1000)); 
$letras .= (string) $tempo; 
$letras .= (string) " mil "; 
$Numero = $Numero - (Intval($Numero / 1000) * 1000); 
} 
else { 
$tempo = Decenas(Intval($Numero / 10000) * 10); 
$letras .= (string) $tempo; 
$Numero = $Numero - (Intval(($Numero / 10000)) * 10000); 
if ($Numero > 1000) { 
$letras .= (string) " y "; 
} 
else { 
$letras .= (string) " mil "; 
} 
} 
} 
// '*---> Unidades de Millar 
if (($Numero < 10000) And ($Numero > 999)) { 
$tempo=(Intval($Numero / 1000)); 
if ($tempo == 1) { 
//$letras .= (string) "un"; 
} 
else { 
$tempo = Unidades(Intval($Numero / 1000)); 
$letras .= (string) $tempo; 
} 
$letras .= (string) " mil "; 
$Numero = $Numero - (Intval($Numero / 1000) * 1000); 
} 
// '*---> Centenas 
if (($Numero < 1000) And ($Numero > 99)) { 
if ((Intval($Numero / 100) == 1) And (($Numero - (Intval($Numero / 100) * 100)) < 1)) { 
$letras.=(string)"cien "; 
//$letras = $letras & "cien "; 
} 
else { 
$temp=(Intval($Numero / 100)); 
$l2=Centenas($temp); 
$letras .= (string) $l2; 
if ((Intval($Numero / 100) <> 1) And (Intval($Numero / 100) <> 5) And (Intval($Numero / 100) <> 7) And (Intval($Numero / 100) <> 9)) { 
$letras .= "cientos "; 
} 
else { 
$letras .= (string) " "; 
} 
} 

$Numero = $Numero - (Intval($Numero / 100) * 100); 
} 
// '*---> Decenas 
if (($Numero < 100) And ($Numero > 9) ) { 
if ($Numero < 16 ) { 
$tempo = Decenas(Intval($Numero)); 
$letras .= $tempo; 
$Numero = $Numero - Intval($Numero); 
} 
Else { 
$tempo= Decenas(Intval(($Numero / 10)) * 10); 
$letras .= (string) $tempo; 
$Numero = $Numero - (Intval(($Numero / 10)) * 10); 
If ($Numero > 0.99) { 
$letras .=(string) " y "; 
} 
} 
} 
// '*---> Unidades 
If (($Numero < 10) And ($Numero > 0.99)) { 
$tempo=Unidades(Intval($Numero)); 
$letras .= (string) $tempo; 

$Numero = $Numero - Intval($Numero); 
} 

// '*---> Decimales 
If ($Decimales > 0) { 

// $letras .=(string) " con "; 
// $Decimales= $Decimales*100; 
// echo ("*"); 
// $Decimales = number_format($Decimales, 2); 
// echo ($Decimales); 
// $tempo = Decenas(Intval($Decimales)); 
// $letras .= (string) $tempo; 
// $letras .= (string) "centavos"; 
} 
Else { 
If (($letras <> "Error en Conversion a Letras") And (strlen(Trim($letras)) > 0)) { 
$letras .= (string) " "; 

} 
} 
return $letras; 
} 
} 

//favor de teclear a mano la cantidad numerica a convertir y asignarla a $tt 
//$tt = 151.21; 

//$tt = $tt+0.009; 
$Numero = Intval($numero); 
$Decimales = $numero - Intval($numero); 
//echo $Decimales;
$Decimales= $Decimales*100; 
//echo $Decimales;
//$Decimales= Intval($Decimales); 
//echo $Decimales;
//$Decimales=round($Decimales);
$x=NumerosALetras($Numero); 
If ($Decimales > 0){ 
//$cad = "235.5666";
$val = explode (".",$numero);
//echo $val[0];
//echo "<br>".$val[1];
//$x .= (string) " ( ";
$x .= (string) $val[1];
$x .= (string) " / ";
$x .= (string) "100 ";
//$x .= (string) " ) ";
//$x=$x & $Decimales & "/" & "100"; 
//$y=NumerosALetras($Decimales); 
//echo (" bolivianos "); 
//echo ($y); 
//echo (" centavos"); 
//} 
//else { 
//echo ("Bolivianos"); 
} 
echo ($x); 
return ($x);
}
?> 
<?php
$IdContra=($_GET['IdContra']);
$sql = "SELECT *,DATE_FORMAT(FechDe,'%d / %m / %Y') as FechDe,DATE_FORMAT(FechAl,'%d / %m / %Y') as FechAl FROM contratodatos  WHERE IdContra='$IdContra' ";
$result=mysql_db_query($db,$sql,$link);
$row=mysql_fetch_array($result);

$sql1 = "SELECT * FROM contratofases  WHERE IdContra='$IdContra' ";
$result1=mysql_db_query($db,$sql1,$link);
$row1=mysql_fetch_array($result1);
$f1=1;
$f2=2;
$f3=3;

$sql = "SELECT IdProv, NombProv FROM proveedor";
		$rs = mysql_db_query($db,$sql,$link);
		while ($tmp = mysql_fetch_array($rs)) {
			$lstProveedor[$tmp['IdProv']]=$tmp['NombProv'];
		}
$sql_pepe="SELECT nombre FROM control_parametros";
$res_hola=mysql_db_query($db,$sql_pepe,$link);
$row_martin=mysql_fetch_array($res_hola);
?>
<html>
<head>
<title> GesTor F1 - GESTION-PRODAT - CONTRATOS</title>
</head>
<body>
<p><?php
include("datos_gral.php");
?>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td> 
      <div align="center"><b><u><font size="4" face="Arial, Helvetica, sans-serif">FICHA LEGAL DE REGISTRO INDIVIDUAL 
        DE CONTRATOS</font></u></b></div>
    </td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
   <td width="153" height="19">&nbsp;</td>
    <td width="121" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">CONTRATO</font><font size="2"> 
    : </font></strong></td>
    <td width="356"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<strong>&nbsp;<?php echo $row['TipoContra'];?></strong></font></td>
  </tr>
  <tr>
    <td height="0"></td>
    <td></td>
    <td></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <!--DWLayoutTable-->
  <tr> 
    <td width="153">&nbsp;</td>
    <td width="119"><strong><font size="2" face="Arial, Helvetica, sans-serif">CODIGO LEGAL : </font></strong></td>
    <td width="362"><font size="2" face="Arial, Helvetica, sans-serif"><strong> &nbsp;&nbsp;<?php echo $row['CodLegalContra'];?></strong></font></td>
  </tr>
  <tr>
    <td height="19">&nbsp;</td>
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">AREA:</font></strong></td>
    <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif"> <strong><?php echo $row['area'];?> </strong></font></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">I.- PARTES CONTRATANTES</font></strong></td>
  </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="216"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>1.- 
      EMPRESA CONTRATANTE :</strong></font><font size="2">&nbsp; </font></td>
    <td width="421"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $row['EmpContra'];?></font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td bgcolor="#000000"></td>
  </tr>
</table>
  <table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="215"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>2.- 
      PARTE CONTRATADA :</strong></font></td>
    <td width="422"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $lstProveedor[$row['PartCont']];?></font></td>
  </tr>
  <tr> 
    <td height="1" ></td>
    <td height="1"  bgcolor="#000000" ></td>
    </tr>
</table>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="16">&nbsp;&nbsp;</td>
    <td width="200"><font size="2" face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;<strong>REPRESENTANTE 
      LEGAL:</strong></font></td>
    <td width="421"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<?php echo $row['RepresLegal'];?></font></td>
  </tr>
   <tr> 
    <td height="1" ></td>
    <td height="1"  ></td>
	<td height="1"  bgcolor="#000000" ></td>
  </tr>
</table>
<br>
 <td width="200">&nbsp;</td>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="5"><strong><font size="2" face="Arial, Helvetica, sans-serif">II.- 
      DATOS DEL CONTRATO</font></strong></td>
  </tr>
  <tr> 
    <td width="92" height="18"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>1.- 
      MONTO:</strong></font></td>
    <td width="32"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><?php if ($row['MoneContra']=="Bs"){echo "Bs";} elseif ($row['MoneContra']=="Sus"){echo "$"."us";}?></font></div></td>
    <td width="6"><font face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="82"> <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;<?php echo $row['MontoContra'];?>&nbsp;&nbsp;<?php echo $row['CentContra'];?>/100</font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    <td height="2"></td>
    <td height="2" bgcolor="#000000" ></td>
    <td height="2" ></td>
  </tr>
</table>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="64" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp; 
      &nbsp;&nbsp;<strong>SON:</strong></font></td>
    <td width="572"> 
      <?php $numlet=numletras($row['MontoContra']); ?>
      <font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<?php echo $row['CentContra'];?>/100</font> 
      &nbsp;&nbsp;&nbsp;<?php if ($row['MoneContra']=="Bs"){echo "Bolivianos";} elseif ($row['MoneContra']=="Sus"){echo "Dolares Americanos";} ?> </td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td height="2" bgcolor="#000000"></td>
    
  </tr>
</table>
<table width="636" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="83"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>2.- 
      FECHA:</strong></font></td>
    <td colspan="5"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['FechDe'];?>&nbsp;</font></div></td>
    <td width="15"><font size="2" face="Arial, Helvetica, sans-serif">A</font></td>
    <td colspan="5"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['FechAl'];?>&nbsp;</font></div></td>
    <td width="164"> <div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>3. 
        OTROS : </strong>&nbsp;&nbsp;&nbsp;REC. FIR 
        <?php 
	if ($row['OtrosContra']=="RECONOC. FIRMAS")
		{
		echo "<img src=\"images/si1.gif\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\">";
		}
	?>
        </font></div></td>
    <td width="74"><font size="2" face="Arial, Helvetica, sans-serif"> PROT 
      <?php 
	if ($row['OtrosContra']=="PROTOCOLIZACION")
		{ echo "<img src=\"images/si1.gif\">";}
	else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      </font></td>
    <td width="85"><font size="2" face="Arial, Helvetica, sans-serif"> NINGUNO 
      <?php 
	if ($row['OtrosContra']=="NINGUNO")
		{ echo "<img src=\"images/si1.gif\">";}
	else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      </font></td>
  </tr>
  <tr> 
    <td height="2"></td>
    <td width="41" height="2" bgcolor="#000000"></td>
    <td width="15" height="2" bgcolor="#000000"></td>
    <td width="2" height="2"   bgcolor="#000000"></td>
    <td width="14" height="2" bgcolor="#000000" ></td>
    <td width="14" height="2"></td>
    <td width="15" height="2"></td>
    <td width="68" height="2"  bgcolor="#000000"></td>
    <td width="1" height="2"  bgcolor="#000000"></td>
    <td width="17" height="2" bgcolor="#000000"></td>
    <td width="5" height="2" ></td>
    <td width="6" height="2" ></td>
    <td width="164" height="2" ></td>
    <td height="2" colspan="5" ></td>
  </tr>
</table>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="92" nowrap>&nbsp;</td>
    <td width="90" nowrap><font size="2" face="Arial, Helvetica, sans-serif">(DD 
      / MM /AA)</font></td>
    <td width="15" nowrap><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
    <td width="438" nowrap><font size="2" face="Arial, Helvetica, sans-serif">(DD 
      / MM /AA)</font></td>
  </tr>
</table>
<table width="635" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td nowrap><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<strong>4.- 
      FORMA DE PAGO:</strong> CONTADO 
      <?php 
	if ($row['FormaPago']=="CONTADO")
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      </font> </td>
    <td width="107" nowrap><font size="2" face="Arial, Helvetica, sans-serif">CREDITO 
      <?php 
	if ($row['FormaPago']=="CREDITO")
		{echo "<img src=\"images/si1.gif\">";}
	else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      </font></td>
    <td width="186" nowrap><font size="2" face="Arial, Helvetica, sans-serif"><strong>5.- 
      ENTREGA :</strong>&nbsp;&nbsp;&nbsp; UNICA &nbsp; 
      <?php 
	if ($row['Entrega']=="UNICA")
		{echo "<img src=\"images/si1.gif\">";}
	else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      </font><font size="2">&nbsp; </font></td>
    <td width="95" nowrap><font size="2" face="Arial, Helvetica, sans-serif">FASES 
      &nbsp; 
      <?php 
	if ($row['Entrega']=="FASES")
		{
		echo "<img src=\"images/si1.gif\">";
		}
		else
		{
		echo "<img src=\"images/no1.gif\">";
		}
	?>
      </font><font size="2">&nbsp; </font></td>
  </tr>
  <tr> 
    <td width="245" height="1" ></td>
    <td height="1" colspan="3" ></td>
  </tr>
</table>
<br>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr bgcolor="#CCCCCC"> 
    <td width="8%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FASE</strong></font></div></td>
    <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>DETALLE</strong></font></div></td>
    <td width="16%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>MONTO</strong></font></div></td>
    <td width="14%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>FECHA 
        VENC.</strong></font></div></td>
    <td width="15%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>GARANTIA</strong></font></div></td>
    <td width="17%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>PLAZO</strong></font></div></td>
  </tr>
  <?php $sql2 = "SELECT *,DATE_FORMAT(FechaVenc,'%d / %m / %Y') as FechaVenc,DATE_FORMAT(VencPlazo,'%d / %m / %Y') as VencPlazo FROM contratofases  WHERE IdContra='$IdContra' ";
$result2=mysql_db_query($db,$sql2,$link);
while($row2=mysql_fetch_array($result2)) 
  		{?>
  <tr> 
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $row2['Fase'];?></strong></font></div></td>
    <td><div align="center"><strong><font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row2['Detalle'];?></font></strong></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php echo $row2['Monto'];?></strong></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php echo $row2['FechaVenc'];?></strong></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php echo $row2['Garantia'];?></strong></font></div></td>
    <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>&nbsp;<?php if ($row2['VencPlazo']=="00 / 00 / 0000"){echo "NA";}else{echo $row2['VencPlazo'];}?></strong></font></div></td>
  </tr>
  <?php 
		 }
?>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><strong><font size="2" face="Arial, Helvetica, sans-serif">III.- 
      CLAUSULAS:</font></strong></td>
  </tr>
  <tr> 
    <td width="59" height="1"></td>
    <td width="236" height="1" ></td>
    <td width="44" height="1"></td>
    <td width="298" height="1" ></td>
  </tr>
</table>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;1. 
      <?php 
	  $c1=substr($row['ClausContra'],0,1);
	  $c2=substr($row['ClausContra'],2,1);
	  $c3=substr($row['ClausContra'],4,1);
	  $c4=substr($row['ClausContra'],6,1);
	  $c5=substr($row['ClausContra'],8,1);
	  $c6=substr($row['ClausContra'],10,15);
	  
	if ($c1=="G" or $c2=="G" or $c3=="G" or $c4=="G" or $c5=="G"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Generales</font></td>
    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;2. 
      <?php 
	  if ($c1=="E" or $c2=="E" or $c3=="E" or $c4=="E" or $c5=="E"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Especificas</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;3. 
      <?php 
	  if ($c1=="N" or $c2=="N" or $c3=="N" or $c4=="N" or $c5=="N"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Necesarias</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;4. 
      <?php 
	  if ($c1=="A" or $c2=="A" or $c3=="A" or $c4=="A" or $c5=="A"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Anexos</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;5. 
      <?php 
	  if ($c1=="O" or $c2=="O" or $c3=="O" or $c4=="O" or $c5=="O"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Otras: </font><font size="1" face="Arial, Helvetica, sans-serif"><strong><?php echo $c6;?></strong></font></td>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<table width="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><strong><font size="2" face="Arial, Helvetica, sans-serif">IV.- SALVAGUARDAS CONTRACTUALES</font></strong></td>
  </tr>
  <tr> 
    <td width="59" height="1"></td>
    <td width="236" height="1" ></td>
    <td width="44" height="1"></td>
    <td width="298" height="1" ></td>
  </tr>
</table>
<table width="85%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;1. 
      <?php 
	  $a=substr($row['SalvagContra'],0,1);
	  $b=substr($row['SalvagContra'],2,1);
	  $c=substr($row['SalvagContra'],4,1);
	  $d=substr($row['SalvagContra'],6,1);
	  $e=substr($row['SalvagContra'],8,1);
	  
	if ($a=="C" or $b=="C" or $c=="C" or $d=="C" or $e=="C"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Confidencialidad</font></td>
    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;2. 
      <?php 
	  
	if ($a=="P" or $b=="P" or $c=="P" or $d=="P" or $e=="P"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Propiedad Intelectual</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;3. 
      <?php 
	  
	if ($a=="D" or $b=="D" or $c=="D" or $d=="D" or $e=="D"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Disponibilidad</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;4. 
      <?php 
	  
	if ($a=="A" or $b=="A" or $c=="A" or $d=="A" or $e=="A"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Auditabilidad</font></td>
  </tr>
  <tr> 
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;5. 
      <?php 
	  
	if ($a=="R" or $b=="R" or $c=="R" or $d=="R" or $e=="R"  )
		{echo "<img src=\"images/si1.gif\">";}
		else
		{echo "<img src=\"images/no1.gif\">";}
	?>
      Arbitraje</font></td>
    <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td colspan="4"><strong><font size="2" face="Arial, Helvetica, sans-serif">V. OTROS DETALLES</font></strong></td>
  </tr>
  
</table>
  
<table width="638" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <tr> 
    <td width="634" height="20" > 
      <table width="100%" border="0">
        <tr>
          <td width="1%"></td>
          <td width="97%" align="justify"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['OtroDetalle'];?></font></td>
          <td width="1%"></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">VI.- OBSERVACIONES</font></strong></td>
  </tr>
</table>
<table width="640" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <tr> 
    <td width="636" height="20"> 
      <table width="100%" border="0">
        <tr> 
          <td width="1%"></td>
          <td width="97%" align="justify"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['ObsContra'];?></font></td>
          <td width="1%"></td>
        </tr>
      </table></td>
  </tr>
</table>
<br>
<?php if ($row['motivo_cierre'] <> ""){?>
<table width="637" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr> 
    <td><strong><font size="2" face="Arial, Helvetica, sans-serif">VII.- MOTIVO DE CIERRE DE CONTRATO</font></strong></td>
  </tr>
</table>
<table width="640" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000" style="border-collapse:collapse;">
  <tr> 
    <td width="636" height="20"> 
      <table width="100%" border="0">
        <tr>
          <td width="1%"></td>
          <td width="98%" align="justify"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row['motivo_cierre'];?></font></td>
          <td width="1%"></td>
        </tr>
      </table></td>
  </tr>
</table>
<?php } ?>
</body>
</html>