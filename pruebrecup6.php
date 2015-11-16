<?php
// Version: 	1.0
// Objetivo: 	Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
if ($SALIR) header("location: lista_pruebrecup.php");
if ($RESINT){header("location: pruebrecup1.php?id_pru=$id_pru");}
if ($RESEXT){header("location: pruebrecup2.php?id_pru=$id_pru");}
if ($HDWREQ){header("location: pruebrecup3.php?id_pru=$id_pru");}
if ($INSBD){header("location: pruebrecup4.php?id_pru=$id_pru");}
if ($INSSB){header("location: pruebrecup5.php?id_pru=$id_pru");}
if ($INSAPLI){header("location: pruebrecup6.php?id_pru=$id_pru");}
if ($RESTBD){header("location: pruebrecup7.php?id_pru=$id_pru");}
if ($PRUINT){header("location: pruebrecup8.php?id_pru=$id_pru");}
if ($PRUURS){header("location: pruebrecup9.php?id_pru=$id_pru");}

include("top.php");
include("conexion.php");
include("DbTools.class.php");
include("PruebasRecuperacion.class.php");
include ("validator.php");

$prueba = new PruebasRecuperacion($cn, $db);
$list = new DbTools($cn, $db);

$tipoPrueba = array(1 => "Comunicacion a Responsables Internos",
    2 => "Comunicacion a Responsables Externos",
    3 => "Provision de Hardware requerido",
    4 => "Provision de Instaladores de Software y Bases de Datos",
    5 => "Instalacion de Software Base",
    6 => "Instalacion de Aplicaciones",
    7 => "Restauracion de Bases de Datos",
    8 => "Pruebas Internas",
    9 => "Pruebas de Usuario",
    );
// obtener los valores de las variables
$listCombo = array("-1" => "Nuevo Aplicacion");
$formType = "INSSB000";
$typeRespAct = 6;
$listResAct = array (
	"APLICACION"=>"APLICACION",
	"OFIMATICA"=>"OFIMATICA",
	"SISTEMA OPERATIVO"=>"SISTEMA OPERATIVO",
	"BASE DE DATOS"=>"BASE DE DATOS",
	"UTILITARIO"=>"UTILITARIO",
	"VARIOS"=>"VARIOS",
);
$listAplicacion = $list -> GetTable1(1);
$listSo = $list -> GetTable1(3);
$listDb = $list -> GetTable1();
$listOfimatica = $list -> GetTable1(5);
$listUtilitario = $list -> GetTable1(6);
$listVarios = $list -> GetTable1(7);
$listUser = $list -> GetTable1(1);
if (!$listAplicacion) $listAplicacion[0]="     ";
if (!$listSo) $listSo[0]="     ";
if (!$listDb) $listDb[0]="     ";
if (!$listOfimatica) $listOfimatica[0]="     ";
if (!$listUtilitario) $listUtilitario[0]="     ";
if (!$listVarios) $listVarios[0]="     ";
$listUser = $listAplicacion;
// edicion del registro
if ($action == "edit") {
    $tmp = $prueba -> GetDetail(0, 0 , $id_pruresin);
    $recordDb = $tmp[0];
	$action="update";
	if ($recordDb["resact"]=="OFIMATICA") $listUser=$listOfimatica;
	elseif ($recordDb["resact"]=="SISTEMA OPERATIVO") $listUser=$listSo;
	elseif ($recordDb["resact"]=="BASE DE DATOS") $listUser=$listDb;
	elseif ($recordDb["resact"]=="UTILITARIO") $listUser=$listUtilitario;
	elseif ($recordDb["resact"]=="VARIOS") $listUser=$listVarios;
	else  $listUser=$listAplicacion;
			if ($recordDb[fechacon]=="00/00/0000") $recordDb[fechacon]=date ("d/m/Y");
	if ($recordDb[horacon]=="00:00:00") $recordDb[horacon]=date ("H:i:s");
} else unset($recordDb); 
// inseertar el registro
if ($GUARDAR) {
print "<font color=\"#FF0000\" face=\"Arial, Helvetica, sans-serif\"><strong>";
    //$record[resact] = substr($listResAct[$resact], 6);
	$record[resact] = $resact;
    $record[nombresin] = $nombresin;
    $record[fechain] = $ano1 . "-" . $mes1 . "-" . $dia1;
    $record[fechacon] = $ano2 . "-" . $mes2 . "-" . $dia2;
    $record[horain] = $horain1 . ":" . $horain2 . ":" . "00";
    $record[horacon] = $horacon1 . ":" . $horacon2 . ":" . "00";
    $record[tipo] = $tipoPrueba[$typeRespAct];
    $record[id_tipopru] = $typeRespAct;
    $record[resulresin] = $resulresin;
    $record[obsresin] = $obsresin;
    $record[id_pru] = $id_pru;
	$record[id_pruresin] = $id_pruresin;
		
	$validateForm=new ValidateData;
	$msgInvalid=" no es valido<br>";
	$validateDoit=TRUE;
	//control de los campos del formulario
	//registrar o actualizar los datos
    if ($validateDoit) {
        	if ($_POST[action]=="update") {	
    		    $execute = $prueba -> UpdateDetail($record);
				unset($action);
	  	  } else {
        	$execute = $prueba -> InsertDetail2($record);
	    }
    }
    if ($execute<=0 || !$validateDoit) {
		$recordDb=$record;
		$recordDb[id_pruresin] = $resact;
		$errorMsg = "Precaucion, los datos no se han registrado. Por favor, corrija los datos invalidos.";
		}
print "</strong></font>";
} 
//$listResAct = $list -> GetNumberType($id_pru, $typeRespAct, $listCombo);

?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addExists ( "resact",  "Responsables/Actividades, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "nombresin",  "Nombres y Apellidos, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "nombresin",  "Nombres y Apellidos, $errorMsgJs[empty]" );
$valid->addIsDate ( "dia1", "mes1", "ano1", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsTime ( "horain1", "horain2", "Hora de Inicio, $errorMsgJs[time]" );
$valid->addIsDate ( "dia2", "mes2", "ano2", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "dia1", "mes1", "ano1", "dia2", "mes2", "ano2", "Fecha de Inicio y Fecha de Conclusion, $errorMsgJs[compareDates]");
$valid->addIsTime ( "horacon1", "horacon2", "Hora de Conclusion, $errorMsgJs[time]" );
$valid->addExists ( "resulresin",  "Resultados, $errorMsgJs[empty]" );
$valid->addLength ( "resulresin",  "Resultados, $errorMsgJs[length]" );
$valid->addLength ( "obsresin",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ( "compareFecha",  "Resultados, $errorMsgJs[empty]" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function compareFecha () {
	var form=document.form1;
	var from=form.mes1.value + '/' + form.dia1.value + '/' + form.ano1.value;
	var to=form.mes2.value + '/' + form.dia2.value + '/' + form.ano2.value;
	if (Date.parse(from) == Date.parse(to)) {
		if (!compareHora()){
			return false;
		}
	}
	return true;
}
function compareHora () {
var form=document.form1;
var msg="Hora de Inicio debe ser menor o igual a Hora de Conclusion.";
var h1=Math.abs(form.horain1.value);
var h2=Math.abs(form.horacon1.value);
var m1=Math.abs(form.horain2.value);
var m2=Math.abs(form.horacon2.value);
if (h1 > h2) {
	alert (msg + "\n \nMensaje generado por GesTor F1.");
	return false;	
}
if ( (h1 == h2) && (m1 > m2) ) {
	alert (msg + "\n \nMensaje generado por GesTor F1.");
	return false;	
}
return true;
}
-->
</script>
<html>
<head>
</head>
<body>
<table width="100%" border="2" align="center" background="./images/fondo.jpg">
  <td colspan="8" bgcolor="#006699" > <div align="center"> 
        <p><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong><font size="3"> 
          Instalacion de Aplicaciones</font></strong></font></p>
    </div></td>
  </tr>
  <tr> 
    <td width="6%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">No.</font></div></td>
    <td width="21%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsables/</font><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Actividades</font> 
      </div>
      </td>
    <td width="12%" bgcolor="#006699" > <div align="center"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombres 
        y Apellidos<br>
          (Razon Social)</font></div>
      </div></td>
    <td width="13%" bgcolor="#006699"> 
      <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
        y Hora de Inicio</font></div></td>
    <td width="14%" bgcolor="#006699" > <div align="center"> <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
        y Hora de Conclusion</font></div></td>
    <td width="14%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Resultados</font></div> </font></div></td>
    <td width="20%" bgcolor="#006699"> <div align="center"> 
        <font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones
        </font></div></td>
  </tr>
  
  <?php
$listPrueba = $prueba -> GetDetail($typeRespAct, $id_pru, 0);
if (sizeof($listPrueba) > 0) {
    foreach ($listPrueba as $k => $v) {
        print "<tr>";
        print "<td align=\"center\">" . ++$k . "</td>";
        print "<td align=\"center\">" . $v["resact"] . "</td>";
        print "<td align=\"center\">" . $v["nombresin"] . "</td>";
        print "<td align=\"center\">" . $v["fechain"] . " " . $v["horain"] . "</td>";
        print "<td align=\"center\">" . $v["fechacon"] . " " . $v["horacon"] . "</td>";
        print "<td align=\"center\">" . $v["resulresin"] . "&nbsp;</td>";
        print "<td align=\"center\">" . $v["obsresin"] . "&nbsp;</td>";
        print "<tr>";
    } 
} 

?>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php print $PHP_SELF;?>" onKeyPress="return Form()">
  <table width="100%" border="2" align="center" background="./images/fondo.jpg">
    <tr> 
      <td width="30%" height="24" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">
        Responsables / Actividades</font></div> </td>
      <td width="30%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombres 
        y Apellidos<br>
          (Razon Social)</font></div></td>
      <td width="25%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha de Inicio</font></div></td>
      <td width="20%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora de Inicio</font></div></td>
    </tr>
    <tr> 
      <td width="30%" align="center"><select name="resact" id="resact"  onchange=redirect(this.options.selectedIndex)>
	  <?php
if (sizeof($listResAct) > 0) {
    foreach ($listResAct as $k => $v) {
        print "<option value=\"$k\"";
        if ("$k" == "$recordDb[resact]") print "selected";
        print ">$v</option>";
    } 
} 
?>
        </select></td>
      <td width="30%" align="center"><strong>
        <select name="nombresin" id="nombresin">
		<?php if (sizeof($listUser) > 0) {
    foreach ($listUser as $k => $v) {
        print "<option value=\"$k\"";
        if ($k == $recordDb[nombresin]) print "selected";
        print ">$v</option>";
    } 
} 

?>
        </select>
        </strong></td>
      <td width="25%" align="center" ><strong> 
        <?php
$fsist = date("Y-m-d");

?>
        <select name="dia1">
          <?php
if (isset($recordDb)) {
    $tmp = explode("/", $recordDb[fechain]);
    $a1 = $tmp[2];
    $m1 = $tmp[1];
    $d1 = $tmp[0];
    $tmp = explode(":", $recordDb[horain]);
    $horain1 = $tmp[0];
    $horain2 = $tmp[1];
} else {
    $a1 = substr($fsist, 0, 4);
    $m1 = substr($fsist, 5, 2);
    $d1 = substr($fsist, 8, 2);
    $horain1 = date("H");
    $horain2 = date("i");
} 
for($i = 1;$i <= 31;$i++) {
    echo "<option value=\"$i\"";
    if ($d1 == "$i") echo "selected";
    echo">$i</option>";
} 

?>
        </select>
        <select name="mes1">
          <?php for($i = 1;$i <= 12;$i++) {
    echo "<option value=\"$i\"";
    if ($m1 == "$i") echo "selected";
    echo">$i</option>";
} 

?>
        </select>
        <select name="ano1">
          <?php for($i = 2003;$i <= 2020;$i++) {
    echo "<option value=\"$i\"";
    if ($a1 == "$i") echo "selected";
    echo">$i</option>";
} 

?>
        </select>
        <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font> 
        </strong></td>
      <td width="20%" align="center" > <input name="horain1" type="text" id="horain1" size="2" maxlength="2" value="<?php print $horain1 ?>">
        : <input name="horain2" type="text" id="horain2" size="2" maxlength="2" value="<?php print $horain2 ?>"></td>
    </tr>
    <tr > 
      <td align="center" bgcolor="006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
          de Conclusion</font></div></td>
      <td align="center" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora 
          de Conclusion</font></div></td>
      <td align="center" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Resultados</font></div></td>
      <td align="center" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></div></td></td>
    </tr>
    <tr> 
      <td align="center" ><strong> 
        <?php
$fsist = date("Y-m-d");

?>
        <select name="dia2">
          <?php
if (isset($recordDb)) {
    $tmp = explode("/", $recordDb[fechacon]);
    $a1 = $tmp[2];
    $m1 = $tmp[1];
    $d1 = $tmp[0];
    $tmp = explode(":", $recordDb[horacon]);
    $horacon1 = $tmp[0];
    $horacon2 = $tmp[1];
} else {
    $a1 = substr($fsist, 0, 4);
    $m1 = substr($fsist, 5, 2);
    $d1 = substr($fsist, 8, 2);
    $horacon1 = date("H");
    $horacon2 = date("i");
} 
for($i = 1;$i <= 31;$i++) {
    echo "<option value=\"$i\"";
    if ($d1 == "$i") echo "selected";
    echo">$i</option>";
} 

?>
        </select>
        <select name="mes2">
          <?php for($i = 1;$i <= 12;$i++) {
    echo "<option value=\"$i\"";
    if ($m1 == "$i") echo "selected";
    echo">$i</option>";
} 

?>
        </select>
        <select name="ano2">
          <?php for($i = 2003;$i <= 2020;$i++) {
    echo "<option value=\"$i\"";
    if ($a1 == "$i") echo "selected";
    echo">$i</option>";
} 
_
?>
        </select>
        <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font> 
        </strong></td>
      <td align="center"> <input name="horacon1" type="text" id="horacon1" size="4" maxlength="2" value="<?php print $horacon1;
?>">
        : <input name="horacon2" type="text" id="horacon2" size="4" maxlength="2" value="<?php print $horacon2;
?>"></td>
      <td align="center" >
	  <textarea name="resulresin" cols="20"><?php print $recordDb[resulresin];
?></textarea> 
      </td>
      <td align="center" class="tableField" ><textarea name="obsresin" cols="20"><?php print $recordDb[obsresin];
?></textarea></td>
    </tr>
    <tr> 
      <td colspan="4" align="center" ><input type="submit" name="GUARDAR" value="GUARDAR"  <?php print $valid->onSubmit() ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="SALIR" type="submit" id="SALIR" value="RETORNAR">
        <input name="id_pru" type="hidden" id="id_pru" value="<?php print $id_pru; ?>">
      <input name="action" type="hidden" id="action" value="<?php print $action ?>">
        <input name="typeResAct" type="hidden" id="typeResAct" value="<?php print $typeResAct;
?>">
        <input name="id_pruresin" type="hidden" id="id_pruresin" value="<?php print $recordDb[id_pruresin]; ?>"></td>
    </tr>
  </table>
  
  <p align="center">
    
</p>
</form>
<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">  
<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var cal2 = new calendar1(document.forms[form].elements['dia2'], document.forms[form].elements['mes2'], document.forms[form].elements['ano2']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;	
/*
Double Combo Script Credit
By JavaScript Kit (www.javascriptkit.com)
Over 200+ free JavaScripts here!
*/

var groups=document.form1.resact.options.length
var group=new Array(groups)
for (i=0; i<groups; i++)
group[i]=new Array()
<?php
	$i=0;
	foreach ($listAplicacion as $k => $v){
		print "group[0][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
		$i=0;
	foreach ($listOfimatica as $k => $v){
		print "group[1][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($listSo as $k => $v){
		print "group[2][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($listDb as $k => $v){
		print "group[3][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($listUtilitario as $k => $v){
		print "group[4][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
	$i=0;
	foreach ($listVarios as $k => $v){
		print "group[5][$i]=new Option(\"$v\",\"$k\")\n";
		$i++;
	}
?>
var temp=document.form1.nombresin;
function redirect(x){
for (m=temp.options.length-1;m>0;m--)
temp.options[m]=null
for (i=0;i<group[x].length;i++){
temp.options[i]=new Option(group[x][i].text,group[x][i].value)
}
temp.options[0].selected=true
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

//-->
</script>
<form name="form2" method="post" action="" onKeyPress="return Form()">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr bgcolor="#006699"> 
      <td colspan="3" width ="100"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
    </tr>
    <tr> 
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>1.-</strong></font> 
          <input name="RESINT" type="submit" id="RESINT" value="Responsables Internos" >
        </div></td>
      <td width="30%" align="center"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">2.-</font></strong> 
          <input name="RESEXT" type="submit" id="RESEXT" value="Responsables Externos">
        </div></td>
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>3.-</strong></font> 
          <input name="HDWREQ" type="submit" id="HDWREQ" value="Hardware Requerido">
        </div></td>
    </tr>
    <tr> 
      <td align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>4.-</strong></font>
<input name="INSBD" type="submit" id="INSBD2" value="Instaladores y Bases de Datos"></td>
      <td align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif">5.-</font></strong></font> 
        <input name="INSSB" type="submit" id="INSSB" value="Instalacion de Software Base"></td>
      <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">6.-</font></strong>
<input name="INSAPLI" type="submit" id="INSAPLI" value="Instalacion de Aplicaciones"></td>
    </tr>
    <tr> 
      <td align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>7.-</strong></font> 
          <input name="RESTBD" type="submit" id="RESTBD2" value="Restauracion de BD">
        </div></td>
      <td> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">8.-</font></strong> 
          <input name="PRUINT" type="submit" id="PRUINT2" value="Pruebas Internas">
        </div></td>
      <td> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">9.-</font></strong> 
          <input name="PRUURS" type="submit" id="PRUURS" value="Pruebas de Usuario">
		  <input name="id_pru" type="hidden" id="id_pru" value="<?php print $id_pru; ?>"> 
        </div></td>
    </tr>
<tr><td colspan="3"><br>
        <div align="center"></div></td></tr>
  </table>
</form>
<?php include("top_.php");
?>
<?php if (!empty($errorMsg)){ ?>
	<script language="JavaScript">
		<!--
		<?php print "alert (\"$errorMsg\");\n"; ?>
		-->
	</script>
<?php } ?>
</body>
</html>