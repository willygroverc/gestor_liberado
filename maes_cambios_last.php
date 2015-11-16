<?php
if (isset($RETORNAR)){header("location: lista_maestro.php");}
if (isset($GUARDAR))
{   include ("conexion.php");
	require_once('funciones.php');
	$FA=explode("/",$Fecha_apro);
	$orden=explode("/",$orden);
	$FP=explode("/",$Fecha_pro);
	$FR=explode("/",$Fecha_real);
	$desc_cambio=SanitizeString($desc_cambio);
	$prioridad=SanitizeString($prioridad);
	$nivel=SanitizeString($nivel);
	$observaciones=SanitizeString($observaciones);
    $sql2= "UPDATE maestro SET desc_cambio='$desc_cambio',fechaprog='".$FP[2]."-".$FP[1]."-".$FP[0]."',prioridad='$prioridad',nivel='$nivel',fechareal='".$FR[2]."-".$FR[1]."-".$FR[0]."',observaciones='$observaciones' WHERE num_orden='$orden'";
	mysql_db_query($db,$sql2,$link);
	$sql2_0= "UPDATE soliccambiodatos SET FechaAprob='".$FA[2]."-".$FA[1]."-".$FA[0]."' WHERE Codigo='$orden'";
	mysql_db_query($db,$sql2_0,$link);
	$executeDoit=mysql_affected_rows();
	header("location: lista_maestro.php");
	
}
//else{
include ("top.php");
$orden=($_GET['orden']);
?>
<link rel="stylesheet" type="text/css" media="all" href="fecha/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="fecha/calendar.js"></script>
<script type="text/javascript" src="fecha/calendar-es.js"></script>
<script type="text/javascript">
var oldLink = null;
function setActiveStyleSheet(link, title) {
  var i, a, main;
  for(i=0; (a = document.getElementsByTagName("link")[i]); i++) {
    if(a.getAttribute("rel").indexOf("style") != -1 && a.getAttribute("title")) {
      a.disabled = true;
      if(a.getAttribute("title") == title) a.disabled = false;
    }
  }
  if (oldLink) oldLink.style.fontWeight = 'normal';
  oldLink = link;
  link.style.fontWeight = 'bold';
  return false;
}

function selected(cal, date) {
  cal.sel.value = date; // just update the date in the input field.
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
    cal.callCloseHandler();
}

function closeHandler(cal) {
	cal.hide();                        // hide the calendar
  _dynarch_popupCalendar = null;
}

function showCalendar(id, format, showsTime, showsOtherMonths) {
  var el = document.getElementById(id);
  if (_dynarch_popupCalendar != null) {
    _dynarch_popupCalendar.hide();                 // so we hide it first.
  } else {
    var cal = new Calendar(1, null, selected, closeHandler);
    if (typeof showsTime == "string") {
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = true;
    }
    _dynarch_popupCalendar = cal;                  // remember it in the global var
    cal.setRange(1900, 2070);        // min/max year allowed.
    cal.create();
  }
  _dynarch_popupCalendar.setDateFormat(format);    // set the specified date format
  _dynarch_popupCalendar.parseDate(el.value);      // try to parse the text in field
  _dynarch_popupCalendar.sel = el;                 // inform it what input field we use
  _dynarch_popupCalendar.showAtElement(el.nextSibling, "Br");        // show the calendar

  return false;
}

var MINUTE = 60 * 1000;
var HOUR = 60 * MINUTE;
var DAY = 24 * HOUR;
var WEEK = 7 * DAY;

function isDisabled(date) {
  var today = new Date();
  return (Math.abs(date.getTime() - today.getTime()) / DAY) > 10;
}

function flatSelected(cal, date) {
  var el = document.getElementById("preview");
  el.innerHTML = date;
}
</script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty( "desc_cambio",  "Descripcion del Cambio, $errorMsgJs[empty]" );
$valid->addIsNotEmpty( "observaciones",  "Observaciones, $errorMsgJs[empty]" );
$valid->addIsDate   ( "Diap", "Mesp", "Anop", "Fecha de Inicio, $errorMsgJs[date]" );
$valid->addIsDate   ( "Diar", "Mesr", "Anor", "Fecha de Conclusion, $errorMsgJs[date]" );
$valid->addCompareDates   ( "Diap", "Mesp", "Anop","Diar", "Mesr", "Anor", "Fecha Real y Fecha Programada, $errorMsgJs[compareDates]");
print $valid->toHtml();

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
<form name="form1" method="post" onKeyPress="return Form()">
<input name="orden" type="hidden" value="<?php echo $orden;?>">
    
  <table width="95%" height="113" border="1" align="center" background="images/fondo.jpg">
    <tr align="center" bgcolor="#006699"> 
      <td height="20" colspan="5">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>COMPLETAR 
        - MAESTRO DE CAMBIOS</strong></font></td>
    </tr>
    <tr align="center" bgcolor="#006699"> 
      <td width="7%" height="20" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&deg; 
        DE ORDEN</font></strong></td>
      <td width="28%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">INCIDENCIA</font></strong></td>
      <td width="16%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">SOLICITANTE</font></strong></td>
      <td width="23%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
        DE APROBACION</font></strong></td>
      <td width="26%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
        PROGRAMADA</font></strong></td>
    </tr>
    <tr> 
      <td height="28"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo "$orden"?></font></div></td>
      <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php
	require_once('funciones.php');
	$orden=SanitizeString($orden);
      $sql1 = "SELECT *,DATE_FORMAT(fechaprog, '%d/%m/%Y') AS fechaprog, DATE_FORMAT(fechareal, '%d/%m/%Y') AS fechareal FROM maestro WHERE num_orden='$orden'";
	  $result1=mysql_db_query($db,$sql1,$link);
	  $row1=mysql_fetch_array($result1);
	  $sql = "SELECT desc_inc, cod_usr FROM ordenes WHERE id_orden='$orden'";
	  $result=mysql_db_query($db,$sql,$link);
	  $row=mysql_fetch_array($result);
	  echo $row['desc_inc']
	  
	  ?>
          </font></div></td>
      <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php 
	    $sql4 = "SELECT nom_usr, apa_usr, ama_usr FROM users WHERE login_usr='$row[cod_usr]'";
		$result4=mysql_db_query($db,$sql4,$link);
		$row4=mysql_fetch_array($result4);
	    echo $row4['nom_usr']." ".$row4['apa_usr']." ".$row4['ama_usr']?>
          </font></div></td>
      <td><div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
	  <?php $sql_apro="SELECT DATE_FORMAT(FechaAprob, '%d/%m/%Y') AS FechaAprob FROM soliccambiodatos WHERE Codigo='$orden'";
	  	 $row_apro=mysql_fetch_array(mysql_db_query($db,$sql_apro,$link));
	  ?>
	  <input name="Fecha_apro" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $row_apro['FechaAprob'];?>"><br /><br />
          </font></div></td>
      <td> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">
          <input name="Fecha_pro" type="text" id="sel2" onClick="showCalendar('sel2', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $row1['fechaprog'];?>"><br /><br />
          </font><font size="2" face="Arial, Helvetica, sans-serif"> </font></div>
        <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          </font></div>
        <div align="center"> <font size="2" face="Arial, Helvetica, sans-serif"> 
          </font></div></td>
     <input name="remLen" type="hidden" value="490">
    </tr>
    <tr> 
      <td height="23" colspan="5">&nbsp;</td>
    </tr>
  </table>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="26%" class="menu"><div align="center">&nbsp;DESCRIPCION DEL CAMBIO</div></td>
      <td width="14%" class="menu"><div align="center">PRIORIDAD</div></td>
      <td width="13%" class="menu"><div align="center">&nbsp;NIVEL</div></td>
      <td width="17%" class="menu"><div align="center"><font size="1"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">FECHA 
          REAL </font></strong></font></div></td>
      <td width="30%" class="menu"><div align="center"><font size="1"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></font></div></td>
    </tr>
    <tr> 
      <td height="93"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
          <textarea name="desc_cambio" cols="33" onKeyDown="textCounter(form1.desc_cambio,form1.remLen,490);" onKeyUp="textCounter(form1.desc_cambio,form1.remLen,490);"><?php echo "$row1[desc_cambio]";?></textarea>
          </font></div></td>
      <td height="93"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <select name="prioridad">
            <option value="1" <?php if ($row1['prioridad']=="1"){echo "selected";}?>>(1) 
            Alto</option>
            <option value="2" <?php if ($row1['prioridad']=="2"){echo "selected";}?>>(2) 
            Medio</option>
            <option value="3" <?php if ($row1['prioridad']=="3"){echo "selected";}?>>(3) 
            Bajo</option>
          </select>
          </font></div></td>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <select name="nivel">
            <option value="1" <?php if ($row1['nivel']=="1"){echo "selected";}?>>(1) 
            Alto</option>
            <option value="2" <?php if ($row1['nivel']=="2"){echo "selected";}?>>(2) 
            Medio</option>
            <option value="3" <?php if ($row1['nivel']=="3"){echo "selected";}?>>(3) 
            Bajo</option>
          </select>
          </font></div></td>
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <?php
  		if ($row1['fechareal']=="0000-00-00") {echo "AUN NO DEFINIDO";}
		else {?>
          <input name="Fecha_real" type="text" id="sel3" onClick="showCalendar('sel3', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $row1['fechareal'];?>"><br /><br />
          <?php } ?>
          </font></div></td>
      <td><div align="center"> <font size="1"> 
          <?php if ($row1['fechareal']=="0000-00-00") {echo "AUN NO DEFINIDO";} 
		  else {?>
          <textarea name="observaciones" cols="35" onKeyDown="textCounter2(form1.observaciones,form1.remLen2,490);" onKeyUp="textCounter2(form1.observaciones,form1.remLen2,490);"><?php echo "$row1[observaciones]";?></textarea>
          <input name="remLen2" type="hidden" value="490">
          <?php }?>
          </font></div></td>
    </tr>
    <tr> 
      <td colspan="6"><div align="center"><br>
          <input name="GUARDAR" type="submit" value="GUARDAR" <?php print $valid->onSubmit() ?>>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="RETORNAR" value="RETORNAR">
          <br>
          <br>
        </div></td>
    </tr>
  </table>
  </form>
<?php include("top_.php");?>
<SCRIPT LANGUAGE="JavaScript">
function textCounter(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}
function textCounter2(field, countfield, maxlimit) {
if (field.value.length > maxlimit) // if too long...trim it!
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else 
countfield.value = maxlimit - field.value.length;
}
// End -->
</script>
<SCRIPT LANGUAGE="JavaScript">
		var aux_Diar=document.form1.Diar;
</script>
