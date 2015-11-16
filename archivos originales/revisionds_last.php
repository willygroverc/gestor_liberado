<?php
include("conexion.php");
if(isset($retornar)){header("location: lista_ordenrev1.php");}
if ($reg_form)
{	
	$fecha_rr="$AS-$MS-$DS";
	$fecha_ra="$AR-$MR-$DR";
  	$sql = "UPDATE revision SET observaciones='$observaciones',nomb_rrevision='$nomb_rrevision',nomb_rauditoria='$nomb_rauditoria',".
		   "fecha_rr='$fecha_rr',fecha_ra='$fecha_ra' WHERE id_orden='$id_orden'";
  	$result = mysql_query($sql);
  	mysql_db_query($db,$sql,$link);
    header("location: lista_ordenrev1.php");}

if ($reg_form2)
{	
	$fecha_inicio="$AnoI-$MesI-$DiaI";
	$fecha_final="$AnoF-$MesF-$DiaF";
		
	if ($numero=="NUEVO")	
  	{		
	$sql2 = "SELECT MAX(numero) AS num FROM detaller WHERE id_orden='$id_orden'";
  	$result2=mysql_db_query($db,$sql2,$link);
  	$row2=mysql_fetch_array($result2);
	$numer=$row2[num]+1;
 	
	$sql = "INSERT INTO detaller (id_orden,numero,descripcion,elegido,observ,Fecha_ini,Hora_ini,Fecha_fin,Hora_fin,Fecha_reg,Hora_reg) ".
		   "VALUES ('$id_orden','$numer','$descripcion','$elegido','$observ','$fecha_inicio','$hora_inicio','$fecha_final','$hora_final','".date("Y-m-d")."','".date("H:i:s")."')";
   	mysql_db_query($db,$sql,$link);
 	header("location: revisionds_last.php?id_orden=$id_orden");}
  else 
  {$sql = "UPDATE detaller SET descripcion='$descripcion',elegido='$elegido',Fecha_ini='$fecha_inicio',Hora_ini='$hora_inicio',Fecha_fin='$fecha_final',".
  		  "Hora_fin='$hora_final',observ='$observ' WHERE id_orden='$id_orden' AND numero='$numero'";
   	mysql_db_query($db,$sql,$link);
 	header("location: revisionds_last.php?id_orden=$id_orden");}
 
}
include("top.php");
$numer=($_GET['numero']);
?>
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
<script language="JavaScript" src="calendar.js"></script>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form1" );
$valid->addIsNotEmpty ( "descripcion",  "Descripcion, $errorMsgJs[empty]" );
$valid->addLength ( "descripcion",  "Descripcion, $errorMsgJs[length]" );
$valid->addCompareDates   ( "DiaI", "MesI", "AnoI", "DiaF", "MesF", "AnoF", "Fecha Inicio y Fecha Fin, $errorMsgJs[compareDates]");
$valid->addIsNotEmpty ( "observ",  "Observaciones, $errorMsgJs[empty]" );
$valid->addLength ( "observ",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml ();
?>
<script language="JavaScript">
<!--
function validateForm1()
{
	var form=document.form1;
	if (form.observaciones.value == '' || form.observaciones.lenght == 0) 
	{
		alert ("Observaciones, no puede ser vacio.\n \nMensaje generado por GesTor F1.");
		form.observaciones.focus();
		return false;
	}
	if (form.observaciones.value.length > 500)
	{ 
		alert ("Observaciones, debe ser menor a 500 caracteres.\n \nMensaje generado por GesTor F1.");
		form.observaciones.focus();
		return false;
	}
	if (form.nomb_rrevision.value == 0) 
	{
		alert ("Responsable de Revision, no puede ser vacio.\n \nMensaje generado por GesTor F1.");
		form.nomb_rrevision.focus();
		return false;
	}
	if (form.nomb_rauditoria.value == 0) 
	{
		alert ("Responsable de Auditoria, no puede ser vacio.\n \nMensaje generado por GesTor F1.");
		form.nomb_rauditoria.focus();
		return false;
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
<form name="form1" method="post" action="<?php echo $PHP_SELF ?>" onKeyPress="return Form()">
	<input name="id_orden" type="hidden" value="<?php echo $id_orden;?>">
	<input name="var2" type="hidden" value="<?php echo $numer;?>">
  <table width="100%" border="2" align="center" background="images/fondo.jpg">
    <tr>
      <th colspan="9"><table width="100%" background="images/fondo.jpg">
          <tr> 
            <td width="10%"><strong><font size="2" face="Arial, Helvetica, sans-serif">Orden 
              Nro.:</font></strong></td>
            <td width="90%"><font size="2" face="Arial, Helvetica, sans-serif"><?php echo $id_orden;?>&nbsp;</font></td>
          </tr>
          <tr> 
            <td valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descripcion:</font></strong></td>
            <td> <font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php
			$sql_ord="SELECT * FROM ordenes WHERE id_orden='$id_orden'";
			$row_ord=mysql_fetch_array(mysql_db_query($db,$sql_ord,$link)); 
			echo $row_ord[desc_inc ];
			?>
              &nbsp;</font></td>
          </tr>
        </table></th>
    </tr>
	<tr> 
      <th colspan="9"><font size="2" face="Arial, Helvetica, sans-serif">REVISION 
        DEL DIA SIGUIENTE</font></th>
    </tr>
    <tr> 
      <td colspan="9"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
        &nbsp;Descripcion de la Incidencia:</font></strong> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <?php 
	  	$sql="SELECT desc_inc FROM ordenes WHERE id_orden=$id_orden";
		$rs=mysql_fetch_array(mysql_db_query($db, $sql, $link));
		print $rs[desc_inc];
	   ?>
        </font></td>
    </tr>
    <tr align="center"> 
      <td width="4%" rowspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></td>
      <td width="10%" rowspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></td>
      <td colspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">INICIO</font></strong></td>
      <td colspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">FIN</font></strong></td>
      <td width="2%" rowspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">SI</font></strong></td>
      <td width="2%" rowspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">NO</font></strong></td>
      <td width="15%" rowspan="2" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></td>
    </tr>
    <tr align="center"> 
      <td width="7%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">FECHA</font></strong></td>
      <td width="4%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">HORA</font></strong></td>
      <td width="7%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">FECHA</font></strong></td>
      <td width="4%" class="menu"><strong><font size="1.5" face="Arial, Helvetica, sans-serif">HORA</font></strong></td>
    </tr>
    <?php
		$sql1 = "SELECT *,DATE_FORMAT(Fecha_ini,'%d / %m / %Y') as Fecha_I,DATE_FORMAT(Fecha_fin,'%d / %m / %Y') as Fecha_F FROM detaller WHERE id_orden='$id_orden'";
		$result1=mysql_db_query($db,$sql1,$link);
		while($row1=mysql_fetch_array($result1)) 
  		{
		 ?>
    <tr align="center"> <?php echo "<td><a href=\"revisionds_last.php?id_orden=$id_orden&numero=".$row1[numero]."\">".$row1[numero]."</a></font></td>";?> 
      <td align="center">&nbsp;<?php echo $row1[descripcion]?></td>
      <td align="center">&nbsp;<?php echo $row1[Fecha_I]?></td>
      <td align="center">&nbsp;<?php echo $row1[Hora_ini]?></td>
      <td align="center">&nbsp;<?php echo $row1[Fecha_F]?></td>
      <td align="center">&nbsp;<?php echo $row1[Hora_fin]?></td>
      <?php if  ($row1[elegido]=="Si") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
 									  echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
  	  	elseif ($row1[elegido]=="No"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
		   							   echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
      <td align="center" >&nbsp;<?php echo $row1[observ]?></td>
    
    </tr>
    <?php 
		 }
		 ?>
  </table>
  <p>
  </p>
    
  <table width="100%" border="2" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="2%" rowspan="2" bgcolor="#006699"> <div align="center"> 
          <p><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">N&ordm;</font></strong></p>
        </div></td>
      <td width="5%" height="20" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">DESCRIPCION</font></strong></div></td>
      <td colspan="2" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">INICIO</font></strong></div></td>
      <td colspan="2" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">FIN</font></strong></div></td>
      <td width="1%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">SI</font></strong></div></td>
      <td width="1%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">NO</font></strong></div></td>
      <td width="5%" rowspan="2" bgcolor="#006699"> <div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></strong></div></td>
    </tr>
    <tr> 
      <td width="7%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">FECHA</font></strong></div></td>
      <td width="4%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">HORA</font></strong></div></td>
      <td width="7%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">FECHA</font></strong></div></td>
      <td width="4%" bgcolor="#006699"><div align="center"><strong><font color="#FFFFFF" size="1.7" face="Arial, Helvetica, sans-serif">HORA</font></strong></div></td>
    </tr>
    <?php    $sql3 = "SELECT * FROM detaller WHERE id_orden='$id_orden' AND numero='$numer'";
		  $result3 = mysql_db_query($db,$sql3,$link);
		  $row3 = mysql_fetch_array($result3); ?>
    <tr> 
      <td> <select name="numero">
	  		<option value="NUEVO" selected>Nuevo</option>
          <?php 
			     $sql2 = "SELECT * FROM detaller WHERE id_orden='$id_orden'";
			     $result2 = mysql_db_query($db,$sql2,$link);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2[numero]==$numero)
				{echo "<option value=\"$row2[numero]\"selected>$row2[numero]</option>";}
			  else
				{echo "<option value=\"$row2[numero]\">$row2[numero]</option>";}}
			   ?>
          
        </select></td>
      <td><div align="center"> <textarea name="descripcion" cols="20" rows="4"><?php echo $row3[descripcion]?></textarea>
        </div></td>
      <td><strong>
        <select name="DiaI" id="select7">
          <?php
				  	if(!$row3[Fecha_ini]){$a=date("Y-m-d");}
					else{$a=$row3[Fecha_ini];}
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
        </select>
        <select name="MesI" id="select9">
          <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
        </select>
        <select name="AnoI" id="select7">
          <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal2.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
        </strong></td>
		<?php  if(!$row3[Hora_ini]){$b=date("H:i");}
			else{$b=$row3[Hora_ini];}
			$hI=substr($b,0,2);
			$mI=substr($b,3,2);
		?>
      <td><div align="center"><br />
          <input name="hora_inicio" type="text" id="sel1" onClick="showCalendar('sel1', '%H:%M', '24', true);" size="5" maxlength="5" readonly value="<?php echo $b;?>"><br />
        </div>
        <div id="display" style="float: right; clear: both;"></div>
		</td>
      <td><strong>
        <select name="DiaF" id="select10">
          <?php
				  	if(!$row3[Fecha_fin]){$a=date("Y-m-d");}
					else{$a=$row3[Fecha_fin];}
				   	$a1=substr($a,0,4);
					$m1=substr($a,5,2);
					$d1=substr($a,8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
        </select>
        <select name="MesF" id="select11">
          <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
        </select>
        <select name="AnoF" id="select10">
          <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
        </select>
        <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal3.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
        </strong></td>
		<?php 	if(!$row3[Hora_fin]){$b=date("H:i");}
			else{$b=$row3[Hora_fin];}
			$hI=substr($b,0,2);
			$mI=substr($b,3,2);
		?>
      <td>
	  <div align="center"><br />
          <input name="hora_final" type="text" id="sel2" onClick="showCalendar('sel2', '%H:%M', '24', true);" size="5" maxlength="5" readonly value="<?php echo $b;?>"><br />
        </div>
        <div id="display" style="float: right; clear: both;"></div>
	  </td>
      <td> <div align="center"> <font size="1" face="Arial, Helvetica, sans-serif"> 
          <input type="radio" name="elegido" value="Si" <?php if ($row3[elegido]=="Si" OR !$row3[elegido]) echo "checked";?>>
          </font></div></td>
      <td> <div align="center"> 
          <input type="radio" name="elegido" value="No" <?php if ($row3[elegido]=="No") echo "checked";?>>
        </div></td>
      <td><div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="1" face="Arial, Helvetica, sans-serif"> 
          <textarea name="observ" cols="20" rows="4"><?php echo $row3[observ] ?></textarea>          
          </font></font></font></font></div></td>
    </tr>
    <tr> 
      <td colspan="15"> <div align="center"><br>
          <input name="reg_form2" type="submit" value="MODIFICAR / ANADIR DESCRIPCION" <?php print $valid->onSubmit() ?>>
        </div></td>
    </tr>
  </table>
   <br>
  <table width="80%" border="2" bgcolor="#CCCCCC" background="images/fondo.jpg" align="center" >
    <tr> 
      <td colspan="2" align="center"> 
        <table width="100%">
          <tr> 
       	<?php    $sql3 = "SELECT * FROM revision WHERE id_orden='$id_orden'";
			  $result3 = mysql_db_query($db,$sql3,$link);
			  $row3 = mysql_fetch_array($result3); ?>
			<td width="33%" height="50">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Observaciones:</font></div></td>
            <td width="67%"><strong> 
              <textarea name="observaciones" cols="70" id="textarea"><?php echo $row3[observaciones] ?></textarea>
              </strong></td>
          </tr>
        </table></td>
    </tr>
    <tr> 
      <td width="67%" height="28" align="center"> <p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de revision: </font><strong> 
          <select name="nomb_rrevision" id="select8">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				 if ($row0[login_usr]==$row3[nomb_rrevision])
					echo "<option value=\"$row0[login_usr]\" selected>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				 else
                	echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				}
			   ?>
          </select>
          </strong></p></td>
      <td align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <select name="DS" id="select">
            <?php
				   	$a1=substr($row3[fecha_rr],0,4);
					$m1=substr($row3[fecha_rr],5,2);
					$d1=substr($row3[fecha_rr],8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          <select name="MS" id="select2">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AS" id="select">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font> 
          </strong></p></td>
    </tr>
    <tr> 
      <td align="center"><p align="left"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;&nbsp;Responsable 
          de Auditoria:</font><strong> 
          <select name="nomb_rauditoria" id="select3">
            <option value="0"></option>
            <?php 
			  $sql0 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result0=mysql_db_query($db,$sql0,$link);
			  while ($row0=mysql_fetch_array($result0)) 
				{
				if ($row0[login_usr]==$row3[nomb_rauditoria])
					echo "<option value=\"$row0[login_usr]\" selected>$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
				 else
                	echo "<option value=\"$row0[login_usr]\">$row0[apa_usr] $row0[ama_usr] $row0[nom_usr]</option>";
                }
			   ?>
          </select>
          </strong></p></td>
      <td width="33%" align="center"><p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Fecha:</font><strong> 
          <select name="DR" id="select4">
            <?php
				   	$a1=substr($row3[fecha_ra],0,4);
					$m1=substr($row3[fecha_ra],5,2);
					$d1=substr($row3[fecha_ra],8,2);
				for($i=1;$i<=31;$i++)
				{
                echo "<option value=\"$i\"";if($d1=="$i")echo "selected";echo">$i</option>";
				}
				?>
          </select>
          <select name="MR" id="select5">
            <?php
				for($i=1;$i<=12;$i++)
					  {
    	              echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";
					  }
			   ?>
          </select>
          <select name="AR" id="select6">
            <?php for($i=2003;$i<=2020;$i++)
				      {
        	          echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";
				      }
				?>
          </select>
          <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><font size="2" face="Arial, Helvetica, sans-serif"><a href="javascript:cal1.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></p></td>
    </tr>
    <tr> 
      <td height="47" colspan="2" align="center"><strong><br>
        <input name="reg_form" type="submit" id="reg_form4" value="GUARDAR CAMBIOS" onClick="return validateForm1();">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input type="submit" name="retornar" value="RETORNAR">
        </strong></td>
    </tr>
  </table>
  </form>
  <script language="JavaScript">
		<!-- 
		 var form="form1";
		 var cal = new calendar1(document.forms[form].elements['DS'], document.forms[form].elements['MS'], document.forms[form].elements['AS']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
		 var cal1 = new calendar1(document.forms[form].elements['DR'], document.forms[form].elements['MR'], document.forms[form].elements['AR']);
		 	cal1.year_scroll = true;
			cal1.time_comp = false;
//-->
</script>
<?php include("top_.php");?>