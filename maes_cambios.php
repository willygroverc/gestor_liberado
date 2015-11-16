<?php
if (isset($RETORNAR)){header("location: lista_maestro.php");}
if (isset($GUARDAR))
{   include ("conexion.php");
	require_once('funciones.php');
    $FP=explode("/",$Fecha_pro);
	$orden=SanitizeString($orden);
	$Prioridad=SanitizeString($Prioridad);
	$Nivel=SanitizeString($Nivel);
	$desc_cambio=SanitizeString($desc_cambio);
	$sql2= "INSERT INTO maestro (num_orden,desc_cambio,fechaprog,prioridad,nivel,observaciones) ".
	"VALUES ('$orden','$desc_cambio','".$FP[2]."-".$FP[1]."-".$FP[0]."','$Prioridad','$Nivel','')";
	mysql_query($sql2);
	$FA=explode("/",$Fecha_apro);
	$sql2_0= "UPDATE soliccambiodatos SET FechaAprob='".$FA[2]."-".$FA[1]."-".$FA[0]."' WHERE Codigo='$orden'";
	mysql_query($sql2_0);
	header("location: lista_maestro.php");
}
//else{
include ("top.php");
require_once('funciones.php');
$orden=SanitizeString($_GET['orden']);
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
<form name="form1" id="form1" method="post" onKeyPress="return Form()">
<input name="var" type="hidden" value="<?php echo $orden;?>">
    
  <table width="90%" height="106" border="1" align="center" background="images/fondo.jpg">
    <tr align="center" bgcolor="#006699"> 
      <td height="20" colspan="4" class="menu">&nbsp;&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>LLENADO 
        - MAESTRO DE CAMBIOS</strong></font></td>
    </tr>
    <tr align="center" bgcolor="#006699"> 
      <td width="7%" height="20" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&deg; 
        DE ORDEN</font></strong></td>
      <td width="27%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">INCIDENCIA</font></strong></td>
      <td width="15%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">SOLICITANTE</font></strong></td>
      <td width="18%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
        DE APROBACION</font></strong></td>
    </tr>
    <tr> 
      <td height="28"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo "$orden"?></font></div></td>
      <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php
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
		  <?php $fsist=date("d/m/Y"); ?>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
          <input name="Fecha_apro" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
          </font></div>
		  </td>
    </tr>
    <tr> 
      <td height="23" colspan="4">&nbsp;</td>
    </tr>
  </table>
  <table width="90%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="24%" class="menu"><div align="center">FECHA PROGRAMADA</div></td>
      <td width="43%" class="menu"><div align="center">DESCRIPCION DEL CAMBIO</div></td>
      <td width="16%" class="menu"><div align="center">NIVEL DEL CAMBIO</div></td>
      <td width="17%" class="menu"><div align="center">PRIORIDAD</div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">
          <input name="Fecha_pro" type="text" id="sel2" onClick="showCalendar('sel2', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
          </font></div></td>
		  <?php 
		  $sql_plan="SELECT * FROM soliccambiodatos WHERE Codigo='$orden'";
		  $row_plan=mysql_fetch_array(mysql_db_query($db,$sql_plan,$link));
		  
		  ?>
      <td><div align="center">
          <textarea name="desc_cambio" cols="50" onKeyDown="textCounter(form1.desc_cambio,form1.remLen,250);" onKeyUp="textCounter(form1.desc_cambio,form1.remLen,250);"><?php echo $row_plan['DescProyecto'];?></textarea>
        </div></td>
      <input name="remLen" type="hidden" value="250">
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">
          <select name="Nivel">
            <option value="1" <?php if($row_plan['Nivel']=="1"){echo "selected";}?>>(1) Alto</option>
            <option value="2" <?php if($row_plan['Nivel']=="2"){echo "selected";}?>>(2) Medio</option>
            <option value="3" <?php if($row_plan['Nivel']=="3"){echo "selected";}?>>(3) Bajo</option>
          </select>
          </font></div></td>
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">
          <select name="Prioridad">
            <option value="1" <?php if($row_plan['Prioridad']=="1"){echo "selected";}?>>(1) Alto</option>
            <option value="2" <?php if($row_plan['Prioridad']=="2"){echo "selected";}?>>(2) Medio</option>
            <option value="3" <?php if($row_plan['Prioridad']=="3"){echo "selected";}?>>(3) Bajo</option>
          </select>
          </font></div></td>
    </tr>
    <tr> 
      <td colspan="5"><div align="center"><br>
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
</script>