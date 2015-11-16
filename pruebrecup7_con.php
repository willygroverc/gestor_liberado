<?php
// Version: 	1.0
// Objetivo: 	Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
if ($SALIR) header("location: lista_pruebrecup.php");
if ($RESINT){header("location: pruebrecup1_con.php?id_pru=$id_pru");}
if ($RESEXT){header("location: pruebrecup2_con.php?id_pru=$id_pru");}
if ($HDWREQ){header("location: pruebrecup3_con.php?id_pru=$id_pru");}
if ($INSBD){header("location: pruebrecup4_con.php?id_pru=$id_pru");}
if ($INSSB){header("location: pruebrecup5_con.php?id_pru=$id_pru");}
if ($INSAPLI){header("location: pruebrecup6_con.php?id_pru=$id_pru");}
if ($RESTBD){header("location: pruebrecup7_con.php?id_pru=$id_pru");}
if ($PRUINT){header("location: pruebrecup8_con.php?id_pru=$id_pru");}
if ($PRUURS){header("location: pruebrecup9_con.php?id_pru=$id_pru");}
include("top.php");
include("conexion.php");
include("DbTools.class.php");
include("PruebasRecuperacion.class.php");
include ("validator.php");

$prueba = new PruebasRecuperacion($cn, $db);
$list = new DbTools($cn, $db);
// obtener los valores de las variables
$typeRespAct = 7;

//$listUser = $list -> GetTable1();
// edicion del registro
if ($action == "edit") {
    $tmp = $prueba -> GetDetail($typeRespAct, 0 , $id_pruresin);
    $recordDb = $tmp[0];
		if ($recordDb[fechacon]=="00/00/0000") $recordDb[fechacon]=date ("Y-m-d");
	if ($recordDb[horacon]=="00:00:00") $recordDb[horacon]=date ("H:i:s");
	$actionQuery="update";
} else unset($recordDb); 
// inseertar el registro
if ($GUARDAR) {
print "<font color=\"#FF0000\" face=\"Arial, Helvetica, sans-serif\"><strong>";
	$record[id_pruresin] = $id_pruresin;
    $record[fechacon] = $ano2 . "-" . $mes2 . "-" . $dia2;
    $record[horacon] = $horacon1 . ":" . $horacon2 . ":" . "00";
    $record[resulresin] = $resulresin;
    $record[obsresin] = $obsresin;
	
	$validateForm=new ValidateData;
	$validateDoit=TRUE;
	//registrar o actualizar los datos
    if ($validateDoit) {
       	if ($actionQuery=="update") {	        
    	    $execute = $prueba -> UpdateDetailCon($record);
			unset ($id_pruresin);
	  	  }
    }
	else {				
		$errorMsg = "Precaucion, los datos no se han registrado. Por favor, corrija los datos invalidos.";
	}
    if ($execute<=0 || !$validateDoit) {
		if ($id_pruresin) $tmp = $prueba -> GetDetail($typeRespAct, 0 , $id_pruresin);
    	$recordDb = $tmp[0];
		$recordDb=array_merge($recordDb, $record);
		//$recordDb[id_pruresin] = $resact;
		//print_r($recordDb);
		}
	else $actionQuery="insert";
print "</strong></font>";
}
?><?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsDate ( "dia2", "mes2", "ano2", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addIsTime ( "horacon1", "horacon2", "Hora de Conclusion, $errorMsgJs[time]" );
$valid->addExists ( "resulresin",  "Resultados, $errorMsgJs[empty]" );
$valid->addLength ( "resulresin",  "Resultados, $errorMsgJs[length]" );
$valid->addLength ( "obsresin",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ( "validateEdit",  "" );
echo $valid->toHtml ();
?>
<script language="JavaScript">
<!--
	<?php 
		print "function validateEdit() {\n";
		if (!$id_pruresin){
			print "alert (\"Debe seleccionar un registro para editar. \\n \\nMensaje generado por GesTor F1.\");\n";
			print "return false;\n";
		}
		print "return true;\n";
		print "}\n";
	 ?>
-->
</script>

<html>
<head>
</head>
<body>
<table width="100%" border="2" align="center" background="./images/fondo.jpg">
  <td colspan="8" bgcolor="#006699" > <div align="center"> 
        <p><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong><font size="3"> 
          Restauracion de Base de Datos</font></strong></font></p>
    </div></td>
  </tr>
  <tr> 
    <td width="6%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">No.</font></div></td>
    <td width="21%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div>
      <p align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Responsables/</font><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Actividades</font> 
      </p></td>
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
//print_r($listPrueba);
if (sizeof($listPrueba) > 0) {
    foreach ($listPrueba as $k => $v) {
        print "<tr>";
        print "<td align=\"center\"><a href=?action=edit&id_pru=$id_pru&id_pruresin=$v[id_pruresin]>" . ++$k . "</a></td>";
        print "<td align=\"center\">" . $v["resact"]."</td>";
        print "<td align=\"center\">" . $v["nombresin"] . "</td>";
        print "<td align=\"center\">" . $v["fechain"] . " " . $v["horain"] . "</td>";
        print "<td align=\"center\">" . $v["fechacon"] . " " . $v["horacon"] . "</td>";
        print "<td align=\"center\">" . $v["resulresin"] . "&nbsp</td>";
        print "<td align=\"center\">" . $v["obsresin"] . "&nbsp</td>";
        print "<tr>";
    } 
} 

?>
  </tr>
</table>
<br>
<form method="post" name="form1" action="<?php print $PHP_SELF;
?>">
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
      <td width="30%" align="center"><?php print $recordDb[resact]?></td>
      <td width="30%" align="center"><strong>
	  <?php print $recordDb[nombresin];?>
        </strong></td>
      <td width="25%" align="center" ><strong> 
        <?php print $recordDb[fechain]; ?>
        </strong></td>
      <td width="20%" align="center" >
	  <?php print $recordDb[horain]; ?>
       </td>
    </tr>
    <tr > 
      <td align="center" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha 
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
    $tmp = explode("-", $recordDb[fechacon]);
    $a1 = $tmp[0];
    $m1 = $tmp[1];
    $d1 = $tmp[2];
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
      <td colspan="4" align="center" ><input type="submit" name="GUARDAR" value="GUARDAR" <?php print $valid->onSubmit() ?>>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="SALIR" type="submit" id="SALIR" value="RETORNAR">
        <input name="id_pru" type="hidden" id="id_pru" value="<?php print $id_pru; ?>">
      <input name="actionQuery" type="hidden" id="action" value="<?php print "$actionQuery" ?>">
	  <input name="id_pruresin" type="hidden" id="action" value="<?php print "$recordDb[id_pruresin]" ?>">
        <input name="typeResAct" type="hidden" id="typeResAct" value="<?php print $typeResAct;
?>"></td>
    </tr>
  </table>
  
  <p align="center">
    
</p>
</form>
<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">  
<!-- 
		 var form="form1";
		  var cal2 = new calendar1(document.forms[form].elements['dia2'], document.forms[form].elements['mes2'], document.forms[form].elements['ano2']);
		 	cal2.year_scroll = true;
			cal2.time_comp = false;			
//-->
</script>
<form name="form2" method="post" action="">
  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr bgcolor="#006699"> 
      <td colspan="3" width ="100"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
    </tr>
    <tr> 
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>1.-</strong></font> 
          <input name="RESINT" type="submit" id="RESINT" value="Responsables Internos" >
        </div></td>
      <td width="30%" align="center"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">2.- 
          </font></strong> 
          <input name="RESEXT" type="submit" id="RESEXT" value="Responsables Externos">
        </div></td>
      <td width="30%" align="center"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>3.-</strong></font> 
          <input name="HDWREQ" type="submit" id="HDWREQ" value="Hardware Requerido">
        </div></td>
    </tr>
    <tr> 
      <td align="center"><font size="2" face="Arial, Helvetica, sans-serif"><strong>4.-</strong></font>
<input name="INSBD" type="submit" id="INSBD2" value="Instaladores y Bases de Datos"></td>
      <td align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">5.-</font></strong>
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