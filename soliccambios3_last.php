<?php 
require_once('funciones.php');
if (isset($retornar)){header("location: lista_soliccambios.php");}
if (isset($insertar))
{   include("conexion.php");
	$FD=explode("/",$Fecha_del);
	$FA=explode("/",$Fecha_al);
	if($IdProyPlanif=="Nueva")
	{	require_once('funciones.php');
		$id_orden=SanitizeString($id_orden);
		$Responsabilid=SanitizeString($Responsabilid);
		$Actividades=SanitizeString($Actividades);
		$Aprobacion=SanitizeString($Aprobacion);
		$Observac=SanitizeString($Observac);
		$sql="INSERT INTO ".
		"soliccambioplanif (Codigo,Responsabilid,Actividades,Aprobacion,Observac,Fecha_planif,Hora_planif,Fecha_del,Fecha_al) ".
		"VALUES ('$id_orden','$Responsabilid','$Actividades','$Aprobacion','$Observac','".date("Y-m-d")."','".date("H:i:s")."',".
		"'".$FD[2]."-".$FD[1]."-".$FD[0]."','".$FA[2]."-".$FA[1]."-".$FA[0]."')";
	}
	else
	{	require_once('funciones.php');
		$id_orden=SanitizeString($id_orden);
		$Responsabilid=SanitizeString($Responsabilid);
		$Actividades=SanitizeString($Actividades);
		$Aprobacion=SanitizeString($Aprobacion);
		$Observac=SanitizeString($Observac);
		$sql="UPDATE soliccambioplanif SET Responsabilid='$Responsabilid',Actividades='$Actividades',Aprobacion='$Aprobacion',".
		"Observac='$Observac',Fecha_del='".$FD[2]."-".$FD[1]."-".$FD[0]."',Fecha_al='".$FA[2]."-".$FA[1]."-".$FA[0]."' ".
		" WHERE IdProyPlanif='$IdProyPlanif' AND Codigo='$id_orden'";
	}
	$Cod="";
	mysql_db_query($db,$sql,$link);
	
}
include("top.php");
$sql0 = "SELECT * FROM soliccambiodatos WHERE Codigo='$id_orden'";
$result0=mysql_db_query($db,$sql0,$link);
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
$valid->addIsNotEmpty ( "Responsabilid",  "Actividades, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "Actividades",  "Planificacion, $errorMsgJs[expresion]" );
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

function Form () 
{
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}

//-->
</script>
<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <tr> 
      <td> 
<form name="form2" method="post" onKeyPress="return Form()">
<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">

        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong> 
                CAMBIO EN PRODUCCION - FASE DE PLANIFICACION </strong></font></div></td>
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
			  $sql_req="SELECT desc_inc FROM ordenes WHERE id_orden='$id_orden'";
			  $row_req=mysql_fetch_array(mysql_db_query($db,$sql_req,$link));			  
			  echo $row_req['desc_inc'];?>
              </font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="21%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;<strong>Descripcion 
              del Cambio:</strong> </font></td>
            <td width="79%" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $row0['DescProyecto'];?></font></td>
          </tr>
        </table>
        <br>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th width="74" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Nro.</font></th>
            <th width="193" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></th>
            <th width="224" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
              </font></th>
            <th colspan="3" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></div></th>
            <th width="181" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ENTRE 
              FECHAS</font></th>
          </tr>
          <tr> 
            <th width="33" height="20" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></th>
            <th width="27" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></th>
            <th width="194" nowrap bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></th>
          </tr>
          <?php
		$i=0; //contador para verificar si ha registrado
		$sql = "SELECT *,DATE_FORMAT(Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioplanif WHERE Codigo='$id_orden' ORDER BY IdProyPlanif ASC";
		$result=mysql_db_query($db,$sql,$link);
		$retornar=mysql_num_rows($result);
		$limbo=1;
		while($row=mysql_fetch_array($result)) 
  		{	
		 ?>
          <tr align="center"> 
            <td><div align="center">&nbsp;<?php echo "<a href=\"soliccambios3_last.php?id_orden=$id_orden&Cod=$row[IdProyPlanif]\">".$limbo++."</a>";?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Responsabilid']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Actividades']?>&nbsp;</div></div> 
            </td>
            <?php if  ($row['Aprobacion']=="SI") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
												 echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
			  elseif ($row['Aprobacion']=="NO"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
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
		  <?php 
		  $sql_up="SELECT *,DATE_FORMAT(Fecha_del, '%d/%m/%Y') AS Fecha_del,DATE_FORMAT(Fecha_al, '%d/%m/%Y') AS Fecha_al FROM soliccambioplanif WHERE Codigo='$id_orden' AND IdProyPlanif='$Cod'";
		  $row_up=mysql_fetch_array(mysql_db_query($db,$sql_up,$link));
		  ?>
          <tr align="center"> 
            <td><strong> 
              <select name="IdProyPlanif" onChange="cambia(this.value)">
                <option value="Nueva">Nueva</option>
                <?php 
			  $sql2 = "SELECT * FROM soliccambioplanif WHERE Codigo='$id_orden'";
			  $result2 = mysql_db_query($db,$sql2,$link);
			  $limbo2=1;
			  while ($row2 = mysql_fetch_array($result2)) 
			  {
			    if ($row2['IdProyPlanif']==$Cod)
				{echo "<option value=\"$row2[IdProyPlanif]\"selected>".$limbo2++."</option>";}
			  	else
				{echo "<option value=\"$row2[IdProyPlanif]\">".$limbo2++."</option>";}
			  }
			   ?>
              </select>
              </strong></td>
			<td width="193" nowrap> <textarea name="Responsabilid" cols="25" rows="2" onKeyDown="textCounter(form2.Responsabilid,form2.remLen,110);" onKeyUp="textCounter(form2.Responsabilid,form2.remLen,110);"><?php echo $row_up['Responsabilid'];?></textarea> 
            </td><input name="remLen" type="hidden" value="110">
            <td width="224" nowrap height="7"> <textarea name="Actividades" cols="30" rows="2" onKeyDown="textCounter(form2.Actividades,form2.remLen2,490);" onKeyUp="textCounter(form2.Actividades,form2.remLen2,490);"><?php echo $row_up['Actividades'];?></textarea>
            </td><input name="remLen2" type="hidden" value="490">
            <td colspan="2" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                SI &nbsp; 
                <input type="radio" name="Aprobacion" value="SI" <?php if($row_up['Aprobacion']=="SI"){echo "checked";}?>>
                <br>
                NO 
                <input type="radio" name="Aprobacion" value="NO" <?php if($row_up['Aprobacion']=="NO" OR !$row_up['Aprobacion']){echo "checked";}?>>
                </font> </strong></div></td>
            <td nowrap> <textarea name="Observac" cols="25" rows="2" onKeyDown="textCounter(form2.Observac,form2.remLen3,240);" onKeyUp="textCounter(form2.Observac,form2.remLen3,240);"><?php echo $row_up['Observac'];?></textarea> 
            </td>
            <input name="remLen3" type="hidden" value="240">
            <?php $fsist=date("d/m/Y");?>
            <td width="181" nowrap><div align="center"> <table width="100%" border="0">
                <tr> 
                  <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Del:</strong> 
                    <input name="Fecha_del" type="text" id="sel1" onClick="showCalendar('sel1', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php if($row_up['Fecha_del']){echo $row_up['Fecha_del'];}else{echo $fsist;}?>"><br /><br />
                    </font></td>
                  <td><font size="2" face="Arial, Helvetica, sans-serif"><strong>Al:</strong> 
                    <input name="Fecha_al" type="text" id="sel2" onClick="showCalendar('sel2', '%d/%m/%Y', '24', true);" size="6" maxlength="10" readonly value="<?php if($row_up['Fecha_al']){echo $row_up['Fecha_al'];}else{echo $fsist;}?>"><br /><br />
                    </font></td>
                </tr>
              </table></td>
          </tr>
          <tr> 
            <td colspan="8" nowrap> <div align="center"><br>
                <input name="insertar" type="submit" id="GUARDAR" value="<?php if($Cod=="Nueva" OR !$Cod){echo "INSERTAR";}else{echo "MODIFICAR";}?>" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="retornar" type="submit" id="RETORNAR" value="RETORNAR">
                &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </div></td>
          </tr>
        </table>
        
        </form>
      </td>
    </tr>
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
function irapagina(pagina){         
 		 if (pagina!="") {
     	 	self.location = pagina;
 		 }
}
function cambia(numero)
{   
	irapagina("soliccambios3_last.php?id_orden="+<?php echo $id_orden;?>+"&Cod="+numero);
}
-->
</script>