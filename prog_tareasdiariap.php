<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		05/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
include('top.php');
include('funciones.php');
@session_start();
if($_SESSION['tipo']=="C") {
	header("location:pagina_inicio.php");
	return;
}
if(isset($_REQUEST['IdProgTarea'])) $IdProgTarea=$_REQUEST['IdProgTarea']; else $IdProgTarea='';
if(isset($_REQUEST['do'])) $do=$_REQUEST['do']; else $do='';
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/tareas_diarias.js"></script>
<script language="JavaScript" src="js/ajax.js"></script>
<script language="JavaScript" src="calendar.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="hora/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="hora/calendar.js"></script>
<script type="text/javascript" src="hora/calendar-es.js"></script>
<script language="JavaScript">
<!--
function validahora()
{
	var form=document.form2;
	var msg="\n \n Mensaje generado por GesTor F1.";
	var del=form.HoraDe.value;
	var al=form.HoraA.value;
	if(del>al)
	{
		alert ("La Hora de incio debe ser menor o igual a la Hora de fin" + msg);
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
-->
</script>
<script>
$(function() {
	$( "#FechaProceso" ).datepicker({
	dateFormat: 'yy-mm-dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
</script>
<script type="text/javascript">
var oldLink = null;
function setActiveStyleSheet(link, title) 
{
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
function selected(cal, date) 
{
  cal.sel.value = date;
  if (cal.dateClicked && (cal.sel.id == "HoraDe" || cal.sel.id == "sel3"))
      cal.callCloseHandler();
}
function closeHandler(cal) {
  cal.hide();                  
  calendar = null;
}
function showCalendar(id, format, showsTime, showsOtherMonths) 
{
  var el = document.getElementById(id);
  if (calendar != null) 
  {
     calendar.hide();               
  } 
  else 
  {
   
    var cal = new Calendar(true, null, selected, closeHandler);
    if (typeof showsTime == "string") 
	{
      cal.showsTime = true;
      cal.time24 = (showsTime == "24");
    }
    if (showsOtherMonths) {
      cal.showsOtherMonths = false;
    }
    calendar = cal;                  
    cal.setRange(1900, 2070);        
    cal.create();
  }
  calendar.setDateFormat(format);    
  calendar.parseDate(el.value);      
  calendar.sel = el;                 
  calendar.showAtElement(el.nextSibling, "Br");       

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

function showFlatCalendar() {
  var parent = document.getElementById("display");
  var cal = new Calendar(true, null, flatSelected);

  cal.weekNumbers = false;

  cal.setDisabledHandler(isDisabled);
  cal.setDateFormat("%A, %B %e");

  cal.create(parent);

  cal.show();
}
</script>
</head>
<body onLoad="document.getElementById('Actividad').focus();">
<?php
if(isset($_GET["do"]) && $_GET["do"]=="editar"){
	$sql="SELECT * FROM progtareasdiaria WHERE IdProgTarea=".$_GET["IdProgTarea"];
	$wTarea=mysql_fetch_array(mysql_query( $sql));
}
echo '<form name="frm_diaria" id="frm_diaria" action="#" method="POST">
<input name="IdProgTarea" type="hidden" id="IdProgTarea" value="'; echo $IdProgTarea; echo '">
    <input name="action" type="hidden" id="action" value="'; echo $do; echo '">
    <table width="70%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
      <tr>
        
      <th colspan="8" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PROGRAMACION 
        DE TAREAS - DIARIAS<br>';
		if(isset($_GET["do"]) && $_GET["do"]=="editar") echo "Editando: Nro. $IdProgTarea";
				else echo "Registro Nuevo"; 
      echo '</font></th>
      </tr>
      <tr>
        <th height="50" colspan="8" background="images/main-button-tileR2.jpg">
          <p><font size="2" face="Arial, Helvetica, sans-serif">Fecha: </font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <input type="text" name="FechaProceso" id="FechaProceso" value="'; echo date('Y-m-d'); echo '">
	  </tr>
      <tr align="center">
        <th rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividad</font></th>
        <th colspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora</font></th>
        <th width="282" colspan="5" rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observaciones</font></th>
      </tr>
      <tr align="center">
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">De</font></th>
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">A</font></th>
      </tr>
      <tr>
        <td width="91" height="7" nowrap>
          <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Actividad" id="Actividad" cols="30" rows="4" id="textarea3">'; echo @$wTarea["Actividad"]; echo '</textarea>
        </strong></font></div></td>';
		$hsist=date("H:i");
        echo '<td height="3" nowrap><div align="center"><strong>'; ?>
			<input name="HoraDe" type="text" id="HoraDe" onClick="showCalendar('HoraDe', '%H:%M', '24', true);" size="3" maxlength="5" readonly value="<?php if(isset($wTarea["HoraDe"])){echo substr($wTarea["HoraDe"],0,5);}else{echo $hsist;}?>"><br />
		<?php
		echo '</strong></div></td>
        <td height="7" nowrap><div align="center"><strong>';?>
		<input name="HoraA" type="text" id="HoraA" onClick="showCalendar('HoraA', '%H:%M', '24', true);" size="3" maxlength="5" readonly value="<?php if(isset($wTarea["HoraA"])){echo substr($wTarea["HoraA"],0,5);}else{echo $hsist;}?>"><br />
		<?php
		echo '</strong></div></td>
        <td height="7" colspan="5" nowrap>
          <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Observaciones" id="Observaciones" cols="30" rows="4" id="textarea4">'; if (isset($wTarea["Observaciones"])) echo $wTarea["Observaciones"]; echo '</textarea>
        </strong></font> </strong></div></td>
      </tr>
	  <tr>
	  <td colspan="8" align="center" valign="middle">
	  <table>
	  <tr>
	  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Asignar a : </strong></td>
	  <td>';
			  $sql = "select CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) as nombre, roles.login_usr as login, tipo2_usr from roles,users where users.login_usr = roles.login_usr and calendariza = 'r' and tipo2_usr = 'T' and bloquear = 0";
			  $resultado = mysql_query($sql);
			  
	  		echo '<select  name="lista" id="lista" size="6" style="width:250px" multiple="multiple">';
				 $total_reg=1;
				 $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			     $result0=mysql_query($sql0);
                             $numcad=0;$varcad=0;
				 while ($row0=mysql_fetch_array($result0)) 
				 {
					echo '<option value="'; echo$row0['login_usr']; echo '"'; for($j=0;$j<=$numcad;$j++){ if($row0['login_usr']==$varcad[$j]){echo "selected";}   } echo '>';

				$nombre = $row0['apa_usr']." ".$row0['ama_usr']." ".$row0['nom_usr'];
				echo $nombre;
				$total_reg++;
              echo '</option>';
				}
            echo '</select>
			</td>
		</tr>
		</table>
	  </td>
	  </tr>
      <tr>
        <td height="28" colspan="8" nowrap>
          <div align="center"><br>
            <input name="INSERTAR" type="button" id="INSERTAR2" value="INSERTAR" onclick="guardar_diaria();">
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="Terminar" value="RETORNAR" onclick="retornar();">
        </div></td>
      </tr>
    </table>
	<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
</form>';
?>
</body>
</html>