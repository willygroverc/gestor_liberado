<?php
include('top.php');
require_once('funciones.php');
include('conexion.php');
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/dia_sig.js"></script>
<script language="JavaScript" src="js/ajax.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
	$( "#fecha_inicio" ).datepicker({
	dateFormat: 'yy-mm-dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	
	$( "#fecha_final" ).datepicker({
	dateFormat: 'yy-mm-dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	
	$( "#fecha_rr" ).datepicker({
	dateFormat: 'yy-mm-dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	
	$( "#fecha_ra" ).datepicker({
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
<link rel="stylesheet" type="text/css" media="all" href="hora/calendar-win2k-1.css" title="win2k-1" />
<script type="text/javascript" src="hora/calendar.js"></script>
<script type="text/javascript" src="hora/calendar-es.js"></script>
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
  if (cal.dateClicked && (cal.sel.id == "hora_inicio" || cal.sel.id == "sel3"))
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
<body onload="document.getElementById('descripcion').focus();" >
<?php
echo '<form name="frm_sig" id="frm_sig" method="POST" action="#">
	<input name="Var1" id="Var1" type="hidden" value="'; echo $id_orden; echo '">
	<input name="id_orden" id="id_orden" type="hidden" value="'; echo $id_orden; echo '">
	<input name="Var2" id="Var2" type="hidden" value="'; echo $cont; echo '">
  <table width="100%" border="2" align="center" background="images/fondo.jpg">
    <tr>
      <th colspan="9"><table width="100%" background="images/fondo.jpg">
          <tr> 
            <td width="10%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Orden 
              Nro.:</font></strong></td>
            <td width="90%"><font size="2" face="Arial, Helvetica, sans-serif">'; echo $id_orden; echo '&nbsp;</font></td>
          </tr>
          <tr> 
            <td valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descripcion:</font></strong></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif">';
			$sql_ord="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
			$row_ord=mysql_fetch_array(mysql_db_query($db,$sql_ord,$link)); 
			echo $row_ord['desc_inc'];
             echo '&nbsp;</font></td>
          </tr>
        </table></th>
    </tr>
    <tr> 
      <th colspan="9">REVISION DEL DIA SIGUIENTE</th>
    </tr>
    <tr align="center"> 
      <td width="2%" rowspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">N&ordm;</font></td>
      <td width="10%" rowspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></td>
      <td colspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">INICIO</font></td>
      <td colspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">FIN</font></td>
      <td width="2%" rowspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">SI</font></td>
      <td width="2%" rowspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">NO</font></td>
      <td width="15%" rowspan="2" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></td>
    </tr>
    <tr align="center"> 
      <td width="7%" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></td>
      <td width="4%" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></td>
      <td width="7%" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">FECHA</font></td>
      <td width="4%" class="menu"><font size="2" face="Arial, Helvetica, sans-serif">HORA</font></td>
    </tr>';
		$sql17 = "SELECT *,DATE_FORMAT(Fecha_ini,'%d / %m / %Y') as Fecha_I,DATE_FORMAT(Fecha_fin,'%d / %m / %Y') as Fecha_F FROM detaller WHERE id_orden='$id_orden'";
		$result17=mysql_db_query($db,$sql17,$link);
		while($row17=mysql_fetch_array($result17)) 
  		{
    echo '<tr align="center">
      <td align="center">'; echo $row17['numero']; echo '</td>
      <td align="center">&nbsp;'; echo $row17['descripcion']; echo '</td>
      <td align="center">&nbsp;'; echo $row17['Fecha_I']; echo '</td>
      <td align="center">&nbsp;'; echo $row17['Hora_ini']; echo '</td>
      <td align="center">&nbsp;'; echo $row17['Fecha_F']; echo '</td>
      <td align="center">&nbsp;'; echo $row17['Hora_fin']; echo '</td>';
	  if  ($row17['elegido']=="Si") {echo "<td><font size=\"1\"><img src=\"images/si1.png\" ></font></td>";
 									  echo "<td><font size=\"1\"><img src=\"images/no1.png\" ></font></td>";}
  	  	elseif ($row17['elegido']=="No"){echo "<td><font size=\"1\"><img src=\"images/no1.png\" ></font></td>";
		   							   echo "<td><font size=\"1\"><img src=\"images/si1.png\" ></font></td>";}
      echo '<td align="center" >&nbsp;'; echo $row17['observ']; echo '</td>
    </tr>';
		 }
  echo '</table>
  <p>
  </p>';
if($habilita=="1" OR $tipo=="A")
{
 echo '<table width="100%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="2%" rowspan="3" bgcolor="#006699"> <div align="center"> 
          <p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NUEVO</font></p>
        </div></td>
      <td width="5%" height="20" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">DESCRIPCION*</font></div></td>
      <td colspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
          INICIO</font></div></td>
      <td colspan="2" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FIN</font></div></td>
      <td width="1%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></div></td>
      <td width="1%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></div></td>
      <td width="5%" rowspan="2" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES*</font></div></td>
    </tr>
    <tr> 
      <td width="8%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="5%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="8%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="5%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
	      <textarea name="descripcion" id="descripcion" cols="20" rows="4"></textarea>
        </div></td>
      <td><strong>
        <input type="text" name="fecha_inicio" maxlength="10" id="fecha_inicio" size ="10" value="'; echo date('Y-m-d'); echo '">
		
        </strong></td>';
		$b=date("H:i");
			$hI=substr($b,0,2);
			$mI=substr($b,3,2);
      echo '<td> <div align="center"><br />'; ?>
          <input name="hora_inicio" id="hora_inicio" type="text" id="hora_inicio" onClick="showCalendar('hora_inicio', '%H:%M', '24', true);" size="5" maxlength="5" readonly value="<?php echo $b;?>"><br />
      <?php
	  echo '</div>
        <div id="display" style="float: right; clear: both;"></div>
	  </td>
      <td><strong>
        <input type="text" name="fecha_final" id="fecha_final" maxlength="10"  value="'; echo date('Y-m-d'); echo '" size="10"/>
       </strong></td>';
			$b=date("H:i");
			$hI=substr($b,0,2);
			$mI=substr($b,3,2);
      echo '<td>
	  <div align="center"><br />'; ?>
          <input name="hora_final" id="hora_final" type="text" id="hora_final" onClick="showCalendar('hora_final', '%H:%M', '24', true);" size="5" maxlength="5" readonly value="<?php echo $b;?>"><br />
      <?php  
	 echo '</div>
        <div id="display" style="float: right; clear: both;"></div>
	 </td>
      <td height="74"> 
        <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif">
          <input type="radio" name="elegido" value="Si" id="elegido" checked>
          </font></div></td>
      <td> <div align="center"> 
          <input type="radio" name="elegido" id="elegido" value="No">
        </div></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="observ" id="observ" cols="20" rows="4"></textarea>
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td colspan="15"> <div align="center"><br>
          <input name="reg_form2" type="button" value="ANADIR NUEVA DESCRIPCION" onclick="guardar_dia_sig();">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		  <!--<input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar();">-->
        </div></td>
    </tr>
  </table>
  <div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
  </div>';
  }
  echo '<br>';
  if($habilita=="2" OR $tipo=="A")
	{
  echo '<table width="80%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="2" align="center"> 
        <table width="100%">
          <tr> 
            <td width="33%" height="50">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Observaciones*:</font></div></td>
            <td width="67%"><strong> 
              <textarea name="observaciones" id="observaciones" cols="70" id="textarea"></textarea>
              </strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="67%" height="28" align="center"> <p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de revision: </font><strong> 
          <select name="nomb_rrevision" id="nomb_rrevision">';
		  if($tipo=="A"){
		  echo '<option value="0"></option>';
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";}
			  elseif ($habilita=="2"){$sql0 = "SELECT * FROM users WHERE login_usr='$row_asig2[escal]'";}	
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
                }
         echo '</select>
          </strong></p></td>
      <td align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <input type="text" name="fecha_rr" id="fecha_rr" size="10" maxlength="10" value="'; echo date('Y-m-d'); echo '" />
		  </strong></p></td>
    </tr>
    <tr> 
      <td align="center"><p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de Auditoria:</font><strong> 
          <select name="nomb_rauditoria" id="nomb_rauditoria">
            <option value="0"></option>';
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				
				echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				
                }
          echo '</select>
          </strong></p></td>
      <td width="33%" align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <input type="text" name="fecha_ra" id="fecha_ra" size="10" maxlength="10" value="'; echo date('Y-m-d'); echo '"/>
	</tr>
    <tr> 
      <td height="47" colspan="2" align="center"><strong><br>
        <input name="reg_form" type="button" id="reg_form4" value="GUARDAR" onClick="guardar_todo();">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<!--<input name="retornar" type="button" id="retornar" value="RETORNAR" onClick="retornar();">-->
        </strong></td>
    </tr>
  </table>
  <div id="lbl_ajax">
			<div style="display: none;" class="success_box1"></div>
			<div style="display: block;" class="error_box1" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>';
  }
  echo '</form>';
?>
</body>
</html>