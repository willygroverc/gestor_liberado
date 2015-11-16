<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
session_start();
if (!empty($idState)) $id_pru=$_GET['id_pru'];
if (isset($SALIR)){header("location: lista_pruebrecup.php");}
if (isset($RESINT)){header("location: pruebrecup1_mod.php?id_pru=$id_pru");}
if (isset($RESEXT)){header("location: pruebrecup2_mod.php?id_pru=$id_pru");}
if (isset($HDWREQ)){header("location: pruebrecup3_mod.php?id_pru=$id_pru");}
if (isset($INSBD)){header("location: pruebrecup4_mod.php?id_pru=$id_pru");}
if (isset($INSSB)){header("location: pruebrecup5_mod.php?id_pru=$id_pru");}
if (isset($INSAPLI)){header("location: pruebrecup6_mod.php?id_pru=$id_pru");}
if (isset($RESTBD)){header("location: pruebrecup7_mod.php?id_pru=$id_pru");}
if (isset($PRUINT)){header("location: pruebrecup8_mod.php?id_pru=$id_pru");}
if (isset($PRUURS)){header("location: pruebrecup9_mod.php?id_pru=$id_pru");}

include ("top.php");
require("conexion.php");
include("DbTools.class.php");
include("PruebasRecuperacion.class.php");
include ("validator.php");

$prueba = @new PruebasRecuperacion($cn, $db);
$list = @new DbTools($cn, $db);
//print "id_pru" . $id_pru;
// obtener los valores de las variables
//$listResAct = $list -> GetNumberType($id_pru, $typeRespAct, $listCombo);
$listSistema = $list -> GetTable1(2);
$listUsuario = $list -> GetTable2("TC");
// edicion del registro
if (isset($action) && $action == "edit") {
	$record['ord_ayu']=$ord_ayu;
    $tmp = $prueba -> GetMaster($record);
    $recordDb = $tmp[0];
} else unset($recordDb); 
// inseertar el registro
if (isset($GUARDAR)) {
    $record['ord_ayu'] = $ord_ayu;
    $record['aplipro'] = $aplipro;
    $record['serpro'] = $serpro;
    $record['fecpru'] = $ano1."-".$mes1. "-" .$dia1;
    $record['sitconti'] = $sitconti;
    $record['nomapc'] = $nomapc;
	$record['nomeval'] = $nomeval;
		
	$validateForm=new ValidateData;
	$msgInvalid=" no es valido<br>";
	$validateDoit=TRUE;
	//control de los campos del formulario
	if (!$validateForm->isDate($record['fecpru'], FALSE)) {
	    print "Fecha:".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isTextNormal($record['serpro'])) {
	    print "Recurso Probado:".$msgInvalid;
		$validateDoit=FALSE;
	}
	if (!$validateForm->isTextNormal($record['sitconti'])) {
	    print "Sitio de Contingencia:".$msgInvalid;
		$validateDoit=FALSE;
	}
	//registrar o actualizar los datos
    if (isset($validateDoit)) {
        if ($prueba->ChkMaster($record)==1) {
	        $execute = $prueba -> UpdateMaster($record);
	  	  } else {
    	    //$record[tipo2] = abs($resact);
        	$execute = $prueba -> InsertMaster($record);
	    }
    }
	else {				
		print "Precaucion, los datos no se han registrado. Por favor, corrija los datos invalidos.";
	}
    if ($execute<=0 || !$validateDoit) {
		$recordDb=$record;
		$recordDb['id_pruresin'] = $resact;
		}
	else $recordDb=$prueba -> GetMaster($record);
}
	unset($listPrueba);

	$record['ord_ayu']=$ord_ayu;
	$listPrueba=$prueba->GetMaster($record);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsDate ( "dia1", "mes1", "ano1", "Fecha, $errorMsgJs[date]" );
$valid->addExists ( "serpro",  "Recurso Probado, $errorMsgJs[empty]" );
$valid->addExists ( "sitconti",  "Sitio de Contingencia, $errorMsgJs[empty]" );
echo $valid->toHtml ();
?>
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699" bgcolor="#EAEAEA" background="images/fondo.jpg">   
   	
<form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
  <input name="id_pru" type="hidden" value="<?php echo $id_pru;?>"> 
     <input name="ord_ayu" type="hidden" value="<?php echo $ord_ayu;?>">
  <table width="100%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <td colspan="6" bgcolor="#006699"><div align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="#FFFFFF"><strong><font size="3">PRUEBAS 
          DE RECUPERACION</font></strong></font></div></td>
    </tr>
    <tr> 
      <td width="6%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">N&deg; 
          Orden</font></div></td>
      <td width="26%" bgcolor="#006699"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha</font></div></td>
      <td width="13%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso 
          Probado </font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Sitio 
          de Contingencia</font></div></td>
   
      <td width="20%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
          del Evaluador</font></div></td>
    </tr>
    <tr align="center"> 
      <td nowrap><?php echo $listPrueba['ord_ayu']?> <div align="center"></div></td>
      <td nowrap height="48"><div align="center">&nbsp;<?php echo substr($listPrueba[0]['fecpru'],8,2)."/".substr($listPrueba[0]['fecpru'],5,2)."/".substr($listPrueba[0]['fecpru'],0,4)?></div></td>
      <td nowrap height="48"><div align="center">&nbsp;<?php echo $listPrueba[0]['serpro'];?></div></td>
      <td nowrap><div align="center">&nbsp;<?php echo $listPrueba[0]['sitconti'];?></div></td>
    
      <td nowrap><div align="center">&nbsp;<?php echo $listUsuario[$listPrueba[0]['nomeval']];?></div></td>
    </tr>
  </table>
  <br>  
  <table border="2" align="center"  background="images/fondo.jpg">
    <tr> 
      <td width="26%" bgcolor="#006699"> <div align="center"></div>
        <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Fecha</font></div></td>
      <td width="13%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Recurso 
          Probado </font></div></td>
      <td width="11%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Sitio 
          de Contingencia</font></div></td>
    </tr>
    <tr> 
      <td align="center"> 
        <?php $record['ord_ayu']=$ord_ayu; ?>
        <select name="dia1">
          <?php
		   			if (isset($recordDb)) {
						    $tmp = explode("-", $recordDb[fecpru]);
						    $a1 = $tmp[0];
						    $m1 = $tmp[1];
						    $d1 = $tmp[2];
		   			}
					else{
						$a1=date("Y");
						$m1=date("m");
						$d1=date("d");
					}
                   	for($i=1;$i<=31;$i++)
					{
	                echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";
					}
			    ?>
        </select> <select name="mes1">
          <?php for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
        </select> <select name="ano1">
          <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select> <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong> 
        <strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"></font></strong></font></strong></font></strong></font></strong> 
      </td>
      <td align="center" ><strong> 
        <input name="serpro" type="text" value="<?php echo $recordDb['serpro'];?>" size="20" maxlength="70">
        </strong></td>
      <td align="center" ><strong> 
        <input name="sitconti" type="text" value="<?php echo $recordDb['sitconti'];?>" size="20" maxlength="70">
        </strong></td>
    </tr>
    <tr> 
      <td width="20%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nombre 
          del Evaluador</font></div></td>
    </tr>
    <tr> 
      <td align="center" ><strong> 
        <select name="nomeval" id="select6">
          <?php if (sizeof($listUsuario) > 0) {
	    foreach ($listUsuario as $k => $v) {
    	    print "<option value=\"$k\"";
        	if ($v == $recordDb['nomeval']) print "selected";
	        print ">$v</option>";
    	}} ?>
        </select>
        </strong></td>
    </tr>
  </table>
  <p align="center"> 
    <input type="submit" name="GUARDAR" value="GUARDAR" <?php print $valid->onSubmit() ?>>
    <input name="id_pru" type="hidden" id="id_pru" value="<?php print $id_pru; ?>">
    <input name="SALIR" type="submit" id="SALIR" value="RETORNAR">
  </p>
  </form>
  <script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">  
<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['dia1'], document.forms[form].elements['mes1'], document.forms[form].elements['ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;		 			
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

//-->
</script>
<form name="form2" method="get" action="">
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
<p>&nbsp;</p>
