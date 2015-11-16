<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		17/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

if (isset($Terminar)) header("location: lista_progtareas.php");
require("conexion.php");

//obtener la cadena de la bd
  if(isset($IdProgTarea)) {
	$sCon = "select *from progtareasdiaria WHERE IdProgTarea=$IdProgTarea";
	$rCon = mysql_query($sCon);
	$resul = mysql_fetch_array($rCon);
	$cadbd = $resul['d_asig'];
	$varcad = explode("|", $cadbd);
	//echo $varchar[Actividad];
	$numcad = count($varcad) - 1;
  }
	
	//
if (isset($INSERTAR)){   
	$dim = $nomAsig;
	$numero = count($dim)-1;
	
	$cadena = $dim[0];
	for($i=1; $i<=$numero; $i++)
	{
			$cadena = $cadena."|".$dim[$i];
	}	
	//$cadena = $cadena."|";
	$variable = explode("|",$cadena);
	$num = count($variable)-1;
	
	
	
	if($numero == -1){$cadena = 0;}
	
	$FechaProceso="$AnoP-$MesP-$DiaP";
	if($action=="editar")
	{
		$sql="UPDATE progtareasdiaria SET Actividad='$Actividad', HoraDe='$HoraDe', HoraA='$HoraA', FechaDe='$FechaProceso', Observaciones='$Observaciones', d_asig='$cadena' WHERE IdProgTarea=$IdProgTarea";
	}
	else
	{
		$sql="INSERT INTO ".
		"progtareasdiaria (Actividad, HoraDe, HoraA, FechaDe, Observaciones,d_asig) ".
		"VALUES ('$Actividad','$HoraDe','$HoraA','$FechaProceso','$Observaciones','$cadena')";
	}	
	mysql_query($sql);
	if(mysql_affected_rows()!=1) $errorMsg="Precaucion, no se han registrado los datos. Por favor, intentelo nuevamente. \\n\\nMensaje generado por GesTor F1.";
	header("location: lista_progtareas.php");
	
}

include("top.php");
if(isset($_GET["do"]) && $_GET["do"]=="editar"){
	$sql="SELECT * FROM progtareasdiaria WHERE IdProgTarea=".$_GET["IdProgTarea"];
	$wTarea=mysql_fetch_array(mysql_query( $sql));
}
?>
<script language="JavaScript" src="calendar.js"></script>
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
  if (cal.dateClicked && (cal.sel.id == "sel1" || cal.sel.id == "sel3"))
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
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsDate   ( "DiaP", "MesP", "AnoP", "Fecha, $errorMsgJs[date]" );
$valid->addIsTextNormal ( "Actividad",  "Actividad, $errorMsgJs[expresion]" );
$valid->addLength ( "Actividad",  "Actividad, $errorMsgJs[length]" );
$valid->addLength ( "Observaciones",  "Observaciones, $errorMsgJs[length]" );
$valid->addFunction ( "validahora",  "" );
//$valid->addFunction ( "valLista",  "" );
print $valid->toHtml ();
?>  
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
  <form name="form2" method="post" onKeyPress="return Form()">
	<input name="IdProgTarea" type="hidden" id="IdProgTarea" value="<?php echo $IdProgTarea;?>">
    <input name="action" type="hidden" id="action" value="<?php=$_GET["do"]?>">
    <table width="70%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
      <tr>
        
      <th colspan="8" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PROGRAMACION 
        DE TAREAS - DIARIAS<br>
                    <?php if(isset($_GET["do"]) && $_GET["do"]=="editar") echo "Editando: Nro. $IdProgTarea";
				else echo "Registro Nuevo"; ?>
        </font></th>
      </tr>
      <tr>
        <th height="50" colspan="8" background="images/main-button-tileR2.jpg">
          <p><font size="2" face="Arial, Helvetica, sans-serif">Fecha: </font> <strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="DiaP" >
              <?php if($_GET["do"]=="editar"){					
							$a1=substr($wTarea["FechaDe"],0,4);
							$m1=substr($wTarea["FechaDe"],5,2);
							$d1=substr($wTarea["FechaDe"],8,2);
						}
						else {
							$fsist=date("Y-m-d");
							$a1=substr($fsist,0,4);
							$m1=substr($fsist,5,2);
							$d1=substr($fsist,8,2);
						}
					for($i=1;$i<=31;$i++)
					{echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";}
			    ?>
            </select>
            </font> <font size="2" face="Verdana, Arial, Helvetica, sans-serif">
            <select name="MesP">
              <?php for($i=1;$i<=12;$i++)
					  {echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   ?>
            </select>
            <select name="AnoP">
              <?php for($i=2003;$i<=2020;$i++)
				      {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				?>
            </select>
            <font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fecha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></strong></font></strong></font></font></strong></font></strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></strong></font></strong></p></th>
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
            <textarea name="Actividad" cols="30" rows="4" id="textarea3"><?phpecho @$wTarea["Actividad"]?></textarea>
        </strong></font></div></td>
		<?php $hsist=date("H:i");?>
        <td height="3" nowrap><div align="center"><strong>
		    <input name="HoraDe" type="text" id="sel1" onClick="showCalendar('sel1', '%H:%M', '24', true);" size="3" maxlength="5" readonly value="<?php if(isset($wTarea["HoraDe"])){echo substr($wTarea["HoraDe"],0,5);}else{echo $hsist;}?>"><br />
         </strong></div></td>
        <td height="7" nowrap><div align="center"><strong>
		   <input name="HoraA" type="text" id="sel2" onClick="showCalendar('sel2', '%H:%M', '24', true);" size="3" maxlength="5" readonly value="<?php if(isset($wTarea["HoraA"])){echo substr($wTarea["HoraA"],0,5);}else{echo $hsist;}?>"><br />
        </strong></div></td>
        <td height="7" colspan="5" nowrap>
          <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Observaciones" cols="30" rows="4" id="textarea4"><?phpif (isset($wTarea["Observaciones"])) echo $wTarea["Observaciones"];?></textarea>
        </strong></font> </strong></div></td>
      </tr>
	  <tr>
	  <td colspan="8" align="center" valign="middle">
	  <table>
	  <tr>
	  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Asignar a : </strong></td>
	  <td>
			 <?php 
			  $sql = "select CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) as nombre, roles.login_usr as login, tipo2_usr from roles,users where users.login_usr = roles.login_usr and calendariza = 'r' and tipo2_usr = 'T' and bloquear = 0";
			  $resultado = mysql_query($sql);
			 ?>
	  		<select  name="nomAsig[]" id="lista" size="6" style="width:250px" multiple="multiple">
			  <?php 
				 $total_reg=1;
				 $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			     $result0=mysql_query($sql0);
				 while ($row0=mysql_fetch_array($result0)) 
				 {
				?>
					<option value="<?php echo$row0['login_usr']?>" <?php for($j=0;$j<=$numcad;$j++){ if($row0['login_usr']==$varcad[$j]){echo "selected";}   }?>>
              <?php 

				$nombre = $row0['apa_usr']." ".$row0['ama_usr']." ".$row0['nom_usr'];
				echo $nombre;
				$total_reg++;
				?>
              </option>
              <?php
				}
				
			   ?>
            </select>
			</td>
		</tr>
		</table>
<?php //-----------------------------------------------------------------------------------------------------------------?>
	  </td>
	  </tr>
      <tr>
        <td height="28" colspan="8" nowrap>
          <div align="center"><br>
            <input name="INSERTAR" type="submit" id="INSERTAR2" value="INSERTAR" <?php print $valid->onSubmit() ?>>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="submit" name="Terminar" value="RETORNAR">
        </div></td>
      </tr>
    </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['DiaP'], document.forms[form].elements['MesP'], document.forms[form].elements['AnoP']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		<?php if(isset($errorMsg)) echo "alert(\"$errorMsg\");"; ?>
//-->
</script>
<script>
function valLista()
{
	
}
</script>