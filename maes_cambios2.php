<?php
if (isset($RETORNAR)){header("location: lista_maestro.php");}
if (isset($GUARDAR))
{   include ("conexion.php");
	require_once('funciones.php');
	if ( $Diar < 10) $Diar = "0".$Diar;
	if ( $Mesr < 10) $Mesr = "0".$Mesr;
	$fechareal="$Anor-$Mesr-$Diar";
	$sql = "SELECT fechaprog FROM maestro WHERE num_orden='$orden'";
	$res = mysql_db_query($db,$sql,$link);
	$row = mysql_fetch_array( $res );
	$FR=explode("/",$Fecha_real);
	$observaciones=SanitizeString($observaciones);
	$orden=SanitizeString($orden);
	$sql2= "UPDATE maestro SET fechareal='".$FR[2]."-".$FR[1]."-".$FR[0]."',observaciones='$observaciones' WHERE num_orden='$orden'";
	mysql_db_query($db,$sql2,$link);
	header("location: lista_maestro.php");
}
//else{
include ("top.php");
$orden = ($_GET['orden']);
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
$valid->addIsNotEmpty( "observaciones",  "Observaciones, $errorMsgJs[empty]" );
$valid->addFunction ( "validafechas",  "" );
print $valid->toHtml();

?>
<script language="JavaScript">
<!--
function validafechas()
{
	var form=document.form1;
	var msg="\n \n Mensaje generado por GesTor F1.";
	var del=form.fechaprog1.value;
	var del_1=del.split("/");
	var al=form.Fecha_real.value;
	var al_1=al.split("/");
	var del_ult=del_1[2]+"/"+del_1[1]+"/"+del_1[0];
	var al_ult=al_1[2]+"/"+al_1[1]+"/"+al_1[0];
	if(del_ult>al_ult)
	{
		alert ("La fecha real debe ser mayor o igual a la fecha de programacion" + msg);
		return ( false );
	}
	return true;
}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
-->
</script>
<form name="form1" method="post" onKeyPress="return Form()">
<input name="var" type="hidden" value="<?php echo $orden;?>">
<input name="orden" type="hidden" value="<?php echo $orden;?>">
  <table width="95%" height="113" border="1" align="center" background="images/fondo.jpg">
    <tr align="center" bgcolor="#006699"> 
      <td height="20" colspan="5">&nbsp;<font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>COMPLETAR 
        - MAESTRO DE CAMBIOS</strong></font></td>
    </tr>
    <tr align="center" bgcolor="#006699"> 
      <td width="9%" height="20" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N&deg; 
        DE ORDEN</font></strong></td>
      <td width="31%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">INCIDENCIA</font></strong></td>
      <td width="19%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">SOLICITANTE</font></strong></td>
      <td width="17%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
        DE APROBACION</font></strong></td>
      <td width="24%" class="menu"><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
        PROGRAMADA</font></strong></td>
    </tr>
    <tr> 
      <td height="28"> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo "$orden"?></font></div></td>
      <td> <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp; 
          <?php
		  require_once('funciones.php');
		 $orden=SanitizeString($orden);
      $sql1 = "SELECT *, DATE_FORMAT(fechaprog, '%d/%m/%Y') AS fechaprog FROM maestro WHERE num_orden='$orden'";
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
      <td><div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"><?php 
	  $sql_apro="SELECT DATE_FORMAT(FechaAprob, '%d/%m/%Y') AS FechaAprob FROM soliccambiodatos WHERE Codigo='$orden'";
	  $row_apro=mysql_fetch_array(mysql_db_query($db,$sql_apro,$link));
	  echo $row_apro['FechaAprob']?> 
          </font></div></td>
      <td> <div align="center"> </div>
        <div align="center"> </div>
        <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"><?php echo $row1['fechaprog']?> 
          </font></div></td>
		  <input name="fechaprog1" type="hidden" value="<?php echo $row1['fechaprog'];?>">
    </tr>
    <tr> 
      <td height="23" colspan="5">&nbsp;</td>
    </tr>
  </table>
  <table width="95%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="30%" class="menu"><div align="center">&nbsp;DESCRIPCION DEL CAMBIO</div></td>
      <td width="12%" class="menu"><div align="center">PRIORIDAD</div></td>
      <td width="12%" class="menu"><div align="center">&nbsp;NIVEL</div></td>
      <td width="18%" class="menu"><div align="center"><font size="1"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">FECHA 
          REAL </font></strong></font></div></td>
      <td width="28%" class="menu"><div align="center"><font size="1"><strong><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></font></div></td>
    </tr>
    <tr> 
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"><?php echo "$row1[desc_cambio]";?> 
          </font></div></td>
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <?php if ($row1['prioridad']=="1"){echo "Alto";}
	     elseif ($row1['prioridad']=="2"){echo "Medio";}
		 elseif ($row1['prioridad']=="3"){echo "Bajo";} 
	  ?>
          </font></div></td>
      <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <?php if ($row1['nivel']=="1"){echo "Alto";}
	     elseif ($row1['nivel']=="2"){echo "Medio";}
		 elseif ($row1['nivel']=="3"){echo "Bajo";} 
	  ?>
          </font></div></td>
      <?php $fsist=date("d/m/Y"); ?>
      <td><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
          <input name="Fecha_real" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
          </font></div></td>
      <td><div align="center"> 
          <textarea name="observaciones" cols="35" onKeyDown="textCounter(form1.observaciones,form1.remLen,490);" onKeyUp="textCounter(form1.observaciones,form1.remLen,490);"></textarea>
        </div></td>
    </tr>
    <input name="remLen" type="hidden" value="490">
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
// End -->
</script>
<script language="JavaScript">
		<!-- 
		<?php if ($msg) {
			print "var msg=\"$msg\";\n";
			print "alert ( msg + \"\\n \\nMensaje generado por GesTor F1.\");\n";
		} ?>
		-->
</script>
