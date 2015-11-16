<?php 
include ("conexion.php");
require_once('funciones.php');
$id_orden=SanitizeString($id_orden);
if (isset($RETORNAR)){header("location: lista_soliccambios.php");}
if (isset($GyC)) 
{	
	$FS=explode("/",$FechSolic);
	$FI=explode("/",$FechImple);
	$id_orden=SanitizeString($id_orden);
	$LiderProyecto=SanitizeString($LiderProyecto);
	$LiderProyUS=SanitizeString($LiderProyUS);
	$DescProyecto=SanitizeString($DescProyecto);
	$PropProyecto=SanitizeString($PropProyecto);
	$nivel=SanitizeString($nivel);
	$prioridad=SanitizeString($prioridad);
	$sql="INSERT INTO ".
	"soliccambiodatos (Codigo,FechaReg,HoraReg,LiderProyecto,LiderProyUS,DescProyecto,PropProyecto,FechSolic,FechaImple,Nivel,Prioridad,Usr_archivos,Archivos,Hash_archi,Observ_archi) ".
	"VALUES ('$id_orden','".date("Y-m-d")."','".date("H:i:s")."','$LiderProyecto','$LiderProyUS','$DescProyecto','$PropProyecto',".
	"'".$FS[2]."-".$FS[1]."-".$FS[0]."','".$FI[2]."-".$FI[1]."-".$FI[0]."','$nivel','$prioridad','','','','')";
	mysql_query($sql);
	header("location: soliccambios2.php?id_orden=$id_orden");	
}
include ("top.php");
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
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsTextNormal ( "Requerimiento",  "Requerimiento, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "LiderProyecto",  "Lider del Cambio, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "LiderProyUS",  "Lider Unidad de Sistemas, $errorMsgJs[empty]" );
$valid->addIsNotEmpty ( "DescProyecto",  "Descripcion del Cambio, $errorMsgJs[expresion]" );
$valid->addIsNotEmpty ( "PropProyecto",  "Proposito del Cambio, $errorMsgJs[expresion]" );
$valid->addIsDate ( "DiaS", "MesS", "AnoS", "Fecha de Solicitud, $errorMsgJs[date]" );
print $valid->toHtml ();
?>  
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr> 
      <td> 
        <form name="form1" method="post" action="" onKeyPress="return Form()">
		<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR2.jpg" height="28"><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE CAMBIO EN PRODUCCION</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr> 
            <td height="24">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
          <tr> 
            <td width="17%" height="18" valign="top"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Orden 
              Nro. : <?php echo $id_orden ?></font></td>
            <td width="33%" valign="top"><div align="right"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;<font color="#000000">&nbsp;&nbsp; 
                Requerimiento :&nbsp;&nbsp;</font> </font></div></td>
            <td width="50%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"> 
			<?php 
			$sql_re="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
			$row_re=mysql_fetch_array(mysql_db_query($db,$sql_re,$link));
			echo $row_re['desc_inc'];			
			?>
            </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Lider 
              del Cambio : 
              <select name="LiderProyecto">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE bloquear=0 AND tipo2_usr='T' OR tipo2_usr='C' ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
              </select>
              </font></td>
            <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Lider 
              Unidad de Sistemas : 
              <select name="LiderProyUS">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   ?>
              </select>
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
              del Cambio&nbsp;: </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="DescProyecto" cols="100" rows="2" onKeyDown="textCounter(form1.DescProyecto,form1.remLen1,490);" onKeyUp="textCounter(form1.DescProyecto,form1.remLen1,490);"></textarea>
              </font></td><input name="remLen1" type="hidden" value="490">
          </tr>
          <tr> 
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Proposito 
              del Cambio&nbsp;&nbsp; :&nbsp; </font></td>
            <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <textarea name="PropProyecto" cols="100" rows="2" onKeyDown="textCounter(form1.PropProyecto,form1.remLen1,490);" onKeyUp="textCounter(form1.PropProyecto,form1.remLen1,490);"></textarea>
              </font></td>
          </tr>
          <tr> 
            <td valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="48%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Fecha 
              de Solicitud : 
              <?php 
			  $fsist=date("d/m/Y");
			  ?>
              <input name="FechSolic" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="10" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
              </font></td>
            <td width="52%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              de Implementacion : 
			  <input name="FechImple" type="text" id="sel2" onClick="showCalendar('sel2', '%d/%m/%Y', '24', true);" size="10" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
              </font></td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Nivel 
              de Cambio &nbsp;&nbsp;:&nbsp;&nbsp; 
              <select name="nivel">
                <option value="1">(1) ALTO</option>
                <option value="2">(2) MEDIO</option>
                <option value="3">(3) BAJO</option>
              </select>
              </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">Prioridad : 
              <select name="prioridad">
                <option value="1">(1) ALTO</option>
                <option value="2">(2) MEDIO</option>
                <option value="3">(3) BAJO</option>
              </select>
              </font></td>
          </tr>
        </table>
        <br>
        <div align="center"><br>
            <input name="GyC" type="submit" id="GyC" value="GUARDAR Y CONTINUAR" <?php print $valid->onSubmit() ?>>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            <input name="RETORNAR" type="submit" id="RETORNAR2" value="RETORNAR">
          </div>
        </form>
    </td>
  </tr>
</table>
<script language="JavaScript">
<!-- 
function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

//-->
</script>
<?php include ("top_.php");?>
<script language="JavaScript">
<!-- 
function textCounter(field, countfield, maxlimit) 
{
	if (field.value.length > maxlimit) 
	field.value = field.value.substring(0, maxlimit);
	else 
	countfield.value = maxlimit - field.value.length;
}
-->
</script>