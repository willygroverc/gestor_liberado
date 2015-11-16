<?php 
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo No Autorizado a Fichero.		
// Fecha: 		23/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
// Version: 	2.0
// Objetivo: 	Sanitizacion de variables para evitar ataques de SQL injection
// Fecha: 		02/OCT/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
else{
	header('location:login.php');
}
$var=  isset($_REQUEST['var']);
if (isset($_REQUEST['RETORNAR'])) {header("location: solicproyecto1_last.php?Codigo=$var");}
elseif (isset($_REQUEST['NActividad']))
{header("location: solicproyecto3_1_last.php?Codigo=$var");}
elseif (isset($_REQUEST['reg_form']))
	{	require("conexion.php");
                $Responsabilid=$_REQUEST['Responsabilid'];
		$sql6= "SELECT * FROM solicproyplanif WHERE Codigo='$_REQUEST[var]' AND Responsabilid='$Responsabilid'";

		$result6=mysql_query($sql6);
		$row6=mysql_fetch_array($result6);
		
		if(!$row6['Codigo'] && !$row6['Responsabilid'])
		{	
			require_once('funciones.php');
			$var=_clean($var);
			$Responsabilid=_clean($Responsabilid);
			$Actividades=_clean($Actividades);
			$Aprobacion=_clean($Aprobacion);
			$Observac=_clean($Observac);
			
			$var=SanitizeString($var);
			$Responsabilid=SanitizeString($Responsabilid);
			$Actividades=SanitizeString($Actividades);
			$Aprobacion=SanitizeString($Aprobacion);
			$Observac=SanitizeString($Observac);
                        
                        $var=$_REQUEST['var'];
			$Responsabilid=$_REQUEST['Responsabilid'];
			$Actividades=$_REQUEST['Actividades'];
			$Aprobacion=$_REQUEST['Aprobacion'];
			$Observac=$_REQUEST['Observac'];
			$sql="INSERT INTO ".
			"solicproyplanif (Codigo,Responsabilid,Actividades,Aprobacion,Observac) ".
			"VALUES ('$var','$Responsabilid','$Actividades','$Aprobacion','$Observac')";

			mysql_query($sql);
			header("location: solicproyecto3_last.php?Codigo=$var");
		}
		else
		{	require_once('funciones.php');
		$var=_clean($var);
			$Responsabilid=_clean($Responsabilid);
			$Actividades=_clean($Actividades);
			$Aprobacion=_clean($Aprobacion);
			$Observac=_clean($Observac);
			
			$var=SanitizeString($var);
			$Responsabilid=SanitizeString($Responsabilid);
			$Actividades=SanitizeString($Actividades);
			$Aprobacion=SanitizeString($Aprobacion);
			$Observac=SanitizeString($Observac);
                        
                        $var=$_REQUEST['var'];
			$Responsabilid=$_REQUEST['Responsabilid'];
			$Actividades=$_REQUEST['Actividades'];
			$Aprobacion=$_REQUEST['Aprobacion'];
			$Observac=$_REQUEST['Observac'];
			$sql="UPDATE solicproyplanif SET Actividades='$Actividades',Aprobacion='$Aprobacion',".
				"Observac='$Observac' WHERE Codigo='$var' AND Responsabilid='$Responsabilid'";
         
			mysql_query($sql);
			header("location: solicproyecto3_last.php?Codigo=$var");
		}	
}
elseif (isset($_REQUEST['GUARDAR']))
{   include("conexion.php");
	//$FechaPlanif="$Ano1-$Mes1-$Dia1";''
        $FechaPlanif=$_REQUEST['Ano1'].'-'.$_REQUEST['Mes1'].'-'.$_REQUEST['Dia1'];
        $NombAprob=$_REQUEST['NombAprob'];
        $NombComisSist=$_REQUEST['NombComisSist'];
        $var=$_REQUEST['var'];
	$sql="UPDATE solicproydatos SET NombAprob='$NombAprob',NombComisSist='$NombComisSist',FechaPlanif='$FechaPlanif' ".
		 	"WHERE Codigo='$var'";
                
			mysql_query($sql);
			header("location: lista_solicproyecto.php");
}
else { 
include("top.php");
require_once('funciones.php');
$Codigo=SanitizeString($_GET['Codigo']);
if (isset($_GET['Respon'])){
	$Respon=($_GET['Respon']);
}
		$sql0 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
		$result0=mysql_query($sql0);
		$row0=mysql_fetch_array($result0);
?>
<?php
require_once ( "ValidatorJs.php" );
$valid = new Validator ( "form2" );
$valid->addIsNotEmpty ( "Responsabilid",  "Actividades, $errorMsgJs[empty]" );
$valid->addIsTextNormal ( "Actividades",  "Planificacion, $errorMsgJs[expresion]" );
$valid->addLength ( "Observac",  "Observaciones, $errorMsgJs[length]" );
print $valid->toHtml();
?>
<script language="JavaScript" src="calendar.js"></script>
<script language="JavaScript">
<!--
function validateForm1() {
  var form = document.form2;
if ( form.NombAprob ) {
if ( form.NombAprob.value == 0 ) { 
	alert ( "Aprobacion, no es una expresion valida.\n \nMensaje generado por GesTor F1." );
	return false;}
  }

if ( form.NombComisSist ) {
if ( form.NombComisSist.value == 0 ) { 
	alert ( "Comision de Sistemas, no puede ser vacio.\n \nMensaje generado por GesTor F1." );
	return false;}
  }
if ( form.Dia1 ) {
var d=form.Dia1.value;
var m=form.Mes1.value;
if (d.length==1) d='0' + d;
if (m.length==1) m='0' + m;
var iDate=d + m + form.Ano1.value;
    if ( iDate =='' ) { 
		alert ( "Fecha, no es una fecha valida.\n \nMensaje generado por GesTor F1." );
 		return false;}
    if ( ! isDate ( iDate ) ) {
      alert ( "Fecha, no es una fecha valida.\n \nMensaje generado por GesTor F1." );
      return ( false );
    }
  }
  return ( true );
}
function isDate(s){
	var DateValue = "";
	var seperator = ".";
	var day;
	var month;
	var year;
	var leap = 0;
	var err = 0;
	var i;
	   err = 0;
	   DateValue = s;
	   if ( DateValue.search(new RegExp("^[0-9]+$","g"))<0) {
		err=18;
		}
	   if (DateValue.length == 6) {
		  DateValue = DateValue.substr(0,4) + '20' + DateValue.substr(4,2); }
	   if (DateValue.length != 8) {
		  err = 19;}
	   /* year is wrong if year = 0000 */
	   year = DateValue.substr(4,4);
	   if (year == 0) {
		  err = 20;
	   }
	   /* Validation of month*/
	   month = DateValue.substr(2,2);
	   if ((month < 1) || (month > 12)) {
		  err = 21;
	   }
	   /* Validation of day*/
	   day = DateValue.substr(0,2);
	   if (day < 1) {
		 err = 22;
	   }
	   /* Validation leap-year / february / day */
	   if ((year % 4 == 0) || (year % 100 == 0) || (year % 400 == 0)) {
		  leap = 1;
	   }
	   if ((month == 2) && (leap == 1) && (day > 29)) {
		  err = 23;
	   }
	   if ((month == 2) && (leap != 1) && (day > 28)) {
		  err = 24;
	   }
	   /* Validation of other months */
	   if ((day > 31) && ((month == "01") || (month == "03") || (month == "05") || (month == "07") || (month == "08") || (month == "10") || (month == "12"))) {
		  err = 25;
	   }
	   if ((day > 30) && ((month == "04") || (month == "06") || (month == "09") || (month == "11"))) {
		  err = 26;
	   }					
	   /* if 00 ist entered, no error, deleting the entry */
	   if ((day == 0) && (month == 0) && (year == 00)) {
		  err = 0;
	   }
	   /* if no error, write the completed date to Input-Field (e.g. 13.12.2001) */
	   if (err == 0) {
		  return true;
	   }
	   /* Error-message if err != 0 */
	   else {
		  return false;
	   }
	}
function Form () {
	var key = window.event.keyCode;
	if (key==13) return false;
	else return true; 
}
//-->
</script>
  
<table width="95%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="form2" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" onKeyPress="return Form()">
	<input name="var" type="hidden" value="<?php echo $Codigo;?>">
	<tr> 
      <td height="221"> 
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr> 
            <td><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>SOLICITUD 
                DE PROYECTOS - MODIFICACION FASE DE PLANIFICACION </strong></font></div></td>
          </tr>
        </table>
        <table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="82%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;REQUERIMIENTO 
              : <?php echo $row0['Requerimiento'];?> </font></td>
            <td width="18%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;CODIGO 
              : <?php echo $row0['Codigo'];?></font></td>
          </tr>
        </table>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Descripcion 
              del Proyecto : 
              <?php echo $row0['DescProyecto'];?>
              </font></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center" cellpadding="1" cellspacing="2" background="images/fondo.jpg">
          <tr> 
            <th width="175" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ACTIVIDADES</font></th>
            <th width="300" rowspan="2" nowrap bgcolor="#006699"><p><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">PLANIFICACION 
                <br>
                (Analisis de Factibilidad) </font></p></th>
            <th colspan="3" nowrap bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">APROBACION</font></div></th>
            <th rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA</font></th>
          </tr>
          <tr> 
            <th width="28" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SI</font></th>
            <th width="42" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NO</font></th>
            <th nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></th>
          </tr>
          <?php
			
		$sql = "SELECT *,DATE_FORMAT(Fecha_planif, '%d/%m/%Y') AS Fecha_planif FROM solicproyplanif WHERE Codigo='$Codigo'";
		$result=mysql_query($sql);
		while($row=mysql_fetch_array($result)) 
  		{
		 ?>
          <tr align="center"> <?php echo "<td><a href=\"solicproyecto3_last.php?Codigo=$Codigo&Respon=".$row['Responsabilid']."\">".$row['Responsabilid']."</a></td>";?> 
            <td><div align="center">&nbsp;<?php echo $row['Actividades']?>&nbsp;</div></td>
            <?php if  ($row['Aprobacion']>="SI") {echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";
												 echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";}
			  elseif ($row['Aprobacion']>="NO"){echo "<td><font size=\"1\"><img src=\"images/no1.gif\" border=\"1\"></font></td>";
				   							       echo "<td><font size=\"1\"><img src=\"images/si1.gif\" border=\"1\"></font></td>";}?>
            <td><div align="center">&nbsp;<?php echo $row['Observac']?></div></td>
            <td><div align="center">&nbsp;<?php echo $row['Fecha_planif']?></div></td>
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
                  <option value="0"></option>
                  <?php 
			  $sql4 = "SELECT *,DATE_FORMAT(Fecha_planif, '%d/%m/%Y') AS Fecha_planif FROM solicproyplanif WHERE Codigo='$Codigo' AND Responsabilid='$Respon'";
			  $result4 = mysql_query($sql4);
			  $row4 = mysql_fetch_array($result4); 
			  
			  $sql = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo'";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				if ($row4['Responsabilid']==$row['Responsabilid'])
					echo '<option value="'.$row['Responsabilid'].'" selected>'.$row['Responsabilid'].'</option>';
				else
					echo '<option value="'.$row['Responsabilid'].'">'.$row['Responsabilid'].'</option>';
	            }
				$sql7 = "SELECT * FROM solicproyplanif WHERE Codigo='$Codigo'";
			  	$result7 = mysql_query($sql7);
			  	while ($row7 = mysql_fetch_array($result7)) 
				{
					$sql8 = "SELECT * FROM solicproyresponsab WHERE Codigo='$Codigo' AND Responsabilid='$row7[Responsabilid]'";
				  	$result8 = mysql_query($sql8);
				  	$row8 = mysql_fetch_array($result8);
					if (!$row8['Responsabilid'])
						{	if ($row7['Responsabilid']==$Respon)
								echo '<option value="'.$row7['Responsabilid'].'" selected>'.$row7['Responsabilid'].'</option>';
							else
								echo '<option value="'.$row7['Responsabilid'].'">'.$row7['Responsabilid'].'</option>';
						}
			    }
				?>
                </select>
                </font> </strong> </div></td>
            <td width="300" nowrap height="7"><div align="center"><strong> 
                <input name="Actividades" type="text" value="<?php echo $row4['Actividades']?>" size="50" maxlength="50">
                <font size="2" face="Arial, Helvetica, sans-serif"> </font> </strong></div></td>
            <td height="7" colspan="2" nowrap> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"> 
                SI &nbsp; 
                <input type="radio" name="Aprobacion" value="SI" <?php 
				if ($row4['Aprobacion']=="SI") 
				{echo "checked";}
				?>>
                <br>
                NO 
                <input name="Aprobacion" type="radio" value="NO" <?php 
				if ($row4['Aprobacion']=="NO") 
				{echo "checked";}
				if (!$row4['Aprobacion']) 
				{echo "checked";}
				?>>
                </font> </strong></div></td>
            <td width="264" height="7" nowrap><div align="center"> 
                <textarea name="Observac" cols="35"><?php echo $row4['Observac']?></textarea>
              </div></td>
           <td width="52" nowrap><div align="center"> <?php if (!isset($Respon)){echo date("d/m/Y");} else {echo $row4['Fecha_planif'];}?></div></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"><br>
                <input name="reg_form" type="submit" id="reg_form3" value="MODIFICAR DATOS ACTIVIDAD" <?php print $valid->onSubmit() ?>>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="NActividad" type="submit" id="NActividad" value="CREA NUEVA ACTIVIDAD">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              </div></td>
          </tr>
        </table>
        <br>
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td width="72%"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;APROBACION 
              : </font><font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="NombAprob">
                <option value="0"></option>
                <?php 
			  $sql5 = "SELECT * FROM solicproydatos WHERE Codigo='$Codigo'";
			  $result5 = mysql_query($sql5);
			  $row5 = mysql_fetch_array($result5); 

			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				if ($row5[NombAprob]==$row[login_usr])
					echo "<option value=\"$row[login_usr]\" selected>$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
				else
					echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
	            ?>
              </select>
              </font></td>
            <td width="28%" rowspan="2"><font color="#000000" size="2" face="Arial, Helvetica, sans-serif">FECHA 
              : </font><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php 
 			  $a1=substr($row5['FechaPlanif'],0,4);
			  $m1=substr($row5['FechaPlanif'],5,2);
			  $d1=substr($row5['FechaPlanif'],8,2);?>
			  <select name="Dia1" id="select">
                <?php for($i=1;$i<=31;$i++) { echo "<option value=\"$i\""; if($d1=="$i") echo "selected"; echo">$i</option>";} 
				  ?>
              </select>
              <select name="Mes1" id="select2">
                <?php for($i=1;$i<=12;$i++) { echo "<option value=\"$i\""; if($m1=="$i") echo "selected"; echo">$i</option>";}
			   	  ?>
              </select>
              <select name="Ano1" id="select3">
                <?php for($i=2003;$i<=2020;$i++) {echo "<option value=\"$i\""; if($a1=="$i") echo "selected"; echo">$i</option>";}
				  ?>
              </select>
              </font><a href="javascript:cal.popup();"><img src="images/cal.gif" width="16" height="16" border="0" alt="Haga click para seleccionar una fcha"></a></td>
          </tr>
          <tr> 
            <td>&nbsp;&nbsp;&nbsp;<font color="#000000" size="2" face="Arial, Helvetica, sans-serif">COMISION 
              DE SISTEMAS : </font><font size="2" face="Arial, Helvetica, sans-serif"> 
              <select name="NombComisSist">
                <option value="0"></option>
                <?php 
			  $sql = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear='0' ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				if ($row5['NombComisSist']==$row['login_usr'])
					echo '<option value="'.$row['login_usr'].'" selected>'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
				else
					echo '<option value="'.$row['login_usr'].'">'.$row['apa_usr'].' '.$row['ama_usr'].' '.$row['nom_usr'].'</option>';
	            }
			   ?>
              </select>
              </font></td>
          </tr>
        </table>
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><div align="center">
                <input name="GUARDAR" type="submit" id="GUARDAR" value="GUARDAR" onClick="return validateForm1()">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
  
<script language="JavaScript">
		<!-- 
		 var form="form2";
		 var cal = new calendar1(document.forms[form].elements['Dia1'], document.forms[form].elements['Mes1'], document.forms[form].elements['Ano1']);
		 	cal.year_scroll = true;
			cal.time_comp = false;
//-->
</script>
<?php } ?>
