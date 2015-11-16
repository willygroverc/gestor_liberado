<?php 
require_once('funciones.php');
if (isset($RETORNAR))
{header("location: lista_soliccambios.php");}
if (isset($reg_form))
{   include("conexion.php");
	$FD=explode("/",$Fecha_del);
	$FA=explode("/",$Fecha_al);
	$id_orden=SanitizeString($id_orden);
	$Responsabilid=SanitizeString($Responsabilid);
	$Actividades=SanitizeString($Actividades);
	$Aprobacion=SanitizeString($Aprobacion);
	$Observac=SanitizeString($Observac);
	$sql="INSERT INTO ".
	"soliccambioejecucion (Codigo,Responsabilid,Actividades,Aprobacion,Observac,Fecha_ejec,Hora_ejec,Fecha_del,Fecha_al) ".
	"VALUES ('$id_orden','$Responsabilid','$Actividades','$Aprobacion','$Observac','".date("Y-m-d")."','".date("H:i:s")."',".
	"'".$FD[2]."-".$FD[1]."-".$FD[0]."','".$FA[2]."-".$FA[1]."-".$FA[0]."')";
	mysql_db_query($db,$sql,$link);
}
include("top.php");
$id_orden=SanitizeString($id_orden);
$sql0 = "SELECT * FROM soliccambiodatos WHERE Codigo='$id_orden'";
$result0=mysql_query($sql0);
$row0=mysql_fetch_array($result0);
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
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Responsabilid",  "No existen mas Actividades para registrar. \\n \\nMensaje generado por GesTor F1." );
$valid->addIsTextNormal ( "Actividades",  "Ejecucion, $errorMsgJs[expresion]" );
$valid->addFunction ( "validafechas",  "" );
print $valid->toHtml();
?>
<script language="JavaScript">
<!--
function validafechas()
{
	var form=document.form2;
	var msg="\n \n Mensaje generado por GesTor F1.";
	var del=form.Fecha_del.value;
	var del_1=del.split("/");
	var al=form.Fecha_al.value;
	var al_1=al.split("/");
	var del_ult=del_1[2]+"/"+del_1[1]+"/"+del_1[0];
	var al_ult=al_1[2]+"/"+al_1[1]+"/"+al_1[0];
	if(del_ult>al_ult)
	{
		alert ("La fechas son incoherentes" + msg);
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

  
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
<form name="form2" method="post" action="<?php echo $PHP_SELF?>" onKeyPress="return Form()">
	<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
	<tr> 
      <td> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>CAMBIO 
                EN PRODUCCION - FASE DE EJECUCION</strong></font></div></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="12%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Orden 
              Nro. :</strong> </font></td>
            <td width="88%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"><?php echo $id_orden;?></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="15%" valign="top"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Requerimiento 
              :</strong> </font></td>
            <td width="85%" valign="top"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
              <?php 
			  require_once('funciones.php');
			  $id_orden=SanitizeString($id_orden);
			  $sql_req="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
			  $row_req=mysql_fetch_array(mysql_db_query($db,$sql_req,$link));			  
			  echo $row_req['desc_inc'];?>
              </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="21%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Descripcion 
              del Cambio :</strong> </font></td>
            <td width="79%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row0['DescProyecto'];?></font></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th width="234" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></th>
            <th width="215" rowspan="2" nowrap bgcolor="#006699"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">EJECUCION</font></p></th>
            <th colspan="3" nowrap bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></div></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ENTRE 
              FECHAS </font></th>
          </tr>
          <tr> 
            <th width="34" height="23" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></th>
            <th width="40" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></th>
            <th nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *,DATE_FORMAT(Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioejecucion WHERE Codigo='$id_orden' ORDER BY Responsabilid ASC";
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> 
            <td><div align="center">&nbsp;<?php 
			$sql_act="SELECT Responsabilid FROM soliccambioplanif WHERE Codigo='$id_orden' AND IdProyPlanif='$row[Responsabilid]'";
			$row_act=mysql_fetch_array(mysql_db_query($db,$sql_act,$link));
			echo $row_act['Responsabilid']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Actividades']?>&nbsp;</div></td>
            <?php if  ($row['Aprobacion']>="SI") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
												 echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
			  elseif ($row['Aprobacion']>="NO"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
				   							       echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
            <td><div align="center">&nbsp;<?php echo $row['Observac']?></div></td>
			<td><div align="center">&nbsp;<?php echo "Del: $row[Fecha_del] &nbsp;&nbsp;&nbsp;Al: $row[Fecha_al]";?></div></td>
          </tr>
          <?php 
		 }
		 ?>
          <tr> 
            <td colspan="8" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td height="7" nowrap><div align="center"><strong> </strong><strong> 
              <font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="Responsabilid">
              <?php 
			$sql = "SELECT * FROM soliccambioplanif WHERE Codigo='$id_orden' AND Aprobacion='SI' ORDER BY IdProyPlanif ASC";
			$result = mysql_db_query($db,$sql,$link);
			while ($row = mysql_fetch_array($result)) 
			{
				$sql2 = "SELECT * FROM soliccambioejecucion WHERE Codigo='$id_orden' AND Responsabilid='$row[IdProyPlanif]'";
				$result2 = mysql_db_query($db,$sql2,$link);
			  	$row2 = mysql_fetch_array($result2); 
				if (!$row2['Responsabilid'])
				{
					echo "<option value=\"$row[IdProyPlanif]\">";
				 	if(strlen($row['Responsabilid'])>35) {echo substr($row['Responsabilid'],0,35)."....";} else{ echo $row['Responsabilid'];}
				 	echo "</option>";
				}
	        }
			?>
            </select>
                </font> </strong> </div></td>
            <td width="215" nowrap height="7"><div align="center"><strong> 
                <textarea name="Actividades" cols="30" onKeyDown="textCounter(form2.Actividades,form2.remLen2,490);" onKeyUp="textCounter(form2.Actividades,form2.remLen2,490);"></textarea>
			<font size="2" face="Arial, Helvetica, sans-serif"> </font> </strong></div></td><input name="remLen2" type="hidden" value="490">
            <td height="7" colspan="2" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                SI &nbsp; 
                <input type="radio" name="Aprobacion" value="SI">
                <br>
                NO 
                <input type="radio" name="Aprobacion" value="NO" checked>
                </font> </strong></div></td>
            <td width="189" height="7" nowrap><div align="center"> 
                <textarea name="Observac" cols="25" onKeyDown="textCounter(form2.Observac,form2.remLen3,240);" onKeyUp="textCounter(form2.Observac,form2.remLen3,240);"></textarea>
			</div></td><input name="remLen3" type="hidden" value="240">
			<?php $fsist=date("d/m/Y");?>
            <td width="180" nowrap><div align="center"> 
                <table width="100%" border="0">
                  <tr> 
                    <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Del:</strong><br>
                      <input name="Fecha_del" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
                      </font></td>
                    <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Al:</strong> 
                      <br>
                      <input name="Fecha_al" type="text" id="sel2" onClick="showCalendar('sel2', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php echo $fsist;?>"><br /><br />
                      </font></td>
                  </tr>
                </table>
              </div></td>
          </tr>
          <tr> 
            <td height="47" colspan="8" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="INSERTAR DATOS ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </div></td>
          </tr>
        </table>
        
        
      </td>
    </tr></form>
  </table>
<?php include("top_.php");?>
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