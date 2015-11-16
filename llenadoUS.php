<?php
// Version: 	1.0
// Objetivo:	Modificación de funciones php obsoletas para version 5.3 
//				Control de Acceso No Autorizado por URL
///
// Autor:		Alvaro Rodriguez
// Fecha:		13/ago/13
//__________________________________________________________________________
include('top.php');
@session_start();
if ($_SESSION['tipo']=='C'){
	header("location: pagina_inicio.php");
	return;
}
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/solic_dym.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script> 
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
	$( "#fecha_rec" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	$( "#fecha_asig" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	$( "#fecha_ent" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
});
</script>
<script language="javascript">
		var siguienteCampo = "AsignA";  
		var nombreForm = "frm_solic" ;
		document.onkeydown = TelcaPulsada;          //asigna el evento pulsacion tecla a la funcion  
		function TelcaPulsada( e ) {  
		   if ( window.event != null)               //IE4+  
			  tecla = window.event.keyCode;  
		   else if ( e != null )                //N4+ o W3C compatibles  
			  tecla = e.which;  
		   else  
			  return;  
		   if (tecla == 13) {                   //se pulso enter  
			  if ( siguienteCampo == 'fin' ) {          //fin de la secuencia, hace el submit  
						guardar_solic();
						return false ;                 //sustituir por return true para hacer el submit  
			  } else {                      //da el foco al siguiente campo  
				 eval('document.' + nombreForm + '.' + siguienteCampo + '.focus()');
				 return false ; 
			  }  
		   }  
		}  
  
		if (document.captureEvents)             //netscape es especial: requiere activar la captura del evento  
			document.captureEvents(Event.KEYDOWN) ; 
	</script>
</head>
<body onload="document.getElementById('Tiempo').focus();">
<?php
	$OrdAyuda=$IdFicha;
	$sql = "SELECT *, DATE_FORMAT(Fecha, '%d/%m/%Y') AS Fecha FROM solicitud WHERE OrdAyuda='$OrdAyuda'";
	$result=mysql_db_query($db,$sql,$link);
	$row=mysql_fetch_array($result);
	echo '<form name="frm_solic" id="frm_solic" method=POST action="#">
	<input name="var1" id="var1" type="hidden" value="'; echo $OrdAyuda; echo'">
	<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
    <tr> 
      <td background="windowsvista-assets1/main-button-tile.jpg" height="30"><div align="center"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif"><strong>LLENADO 
          POR SISTEMAS</strong></font></div></td>
    </tr>
  </table>
  
    <table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <td><table width="90%" align="center">
          <tr> 
            <td width="64%" height="32"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              y hora de recepcion :</font> <font size="2" face="Arial, Helvetica, sans-serif"><strong> 
             <input type="text" id="fecha_rec" name="fecha_rec" size="10" maxlength="10" value="">
              <font size="2" face="Verdana, Arial, Helvetica, sans-serif"><strong><strong> 
              &nbsp;&nbsp;<input name="horas" id="horas" type="text" value="08" size="1" maxlength="2" >
              <strong>:</strong> 
              <input name="minutos" id="minutos" type="text" value="05" size="1" maxlength="2">
              </font></strong></font></strong></font></strong></font></strong></strong></font></strong></strong></font></strong></font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Orden 
              Mesa de Ayuda N&deg; :'; 
			   echo $OrdAyuda; echo '</font></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="64%"><font size="2" face="Arial, Helvetica, sans-serif">Asignado 
              a (*) :</font><strong> 
              <select name="AsignA" id="AsignA">
                <option value="0"></option>';
			  $sql2 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result2 = mysql_db_query($db,$sql2,$link);
			  while ($row2 = mysql_fetch_array($result2)) 
				{
				if ($row['AsignA']==$row2['login_usr'])
							echo "<option value=\"$row2[login_usr]\" selected> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr]</option>";
						else
							echo "<option value=\"$row2[login_usr]\"> $row2[apa_usr] $row2[ama_usr] $row2[nom_usr] </option>";
	            }
			   
              echo '</select>
			  
              </strong></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Viabilidad 
              :</font><strong> <font size="2" face="Arial, Helvetica, sans-serif">SI</font> 
              <input type="radio" name="Viabilidad" id="Viabilidad" value="SI"';
			  if ($row['Viabilidad']=="SI") echo "checked"; echo'>
              &nbsp;<font size="2" face="Arial, Helvetica, sans-serif">NO</font> 
              <input type="radio" name="Viabilidad" id="Viabilidad" value="NO"'; 
			  if ($row['Viabilidad']=="NO") echo "checked"; echo'>
              </strong></td>
          </tr>
        </table>
		
        <table width="100%">
          <tr> 
            <td width="35%"><font size="2" face="Arial, Helvetica, sans-serif">Tiempo&nbsp;(*)&nbsp; 
              :</font><strong>&nbsp;&nbsp;&nbsp; 
              <input id="Tiempo" name="Tiempo" type="text" value="" size="4" maxlength="3">
              <select name="Tiempo1" id="Tiempo1">
                <option value="HORAS"'; if ($row['Tiempo1']=="HORAS") echo "selected"; echo '>HORAS</option>
                <option value="DIAS"'; if ($row['Tiempo1']=="DIAS") echo "selected"; echo '>DIAS</option>
                <option value="SEMANAS"'; if ($row['Tiempo']=="SEMANAS") echo "selected"; echo '>SEMANAS</option>
              </select>
			  
              </strong></td>
            <td width="29%"><font size="2" face="Arial, Helvetica, sans-serif">Costo (*)
              :</font> <input name="Costo10" id="Costo10" type="text" value="'; if(!empty($row['CostoI'])) { echo $row['CostoI'];} echo '" size="10" maxlength="5"> 
              <select name="Costo11" id="Costo11">
                <option value="Bs"'; if ($row['MonedaI']=="Bs") echo "selected"; echo '>Bs</option>
                <option value="Sus"'; if ($row['MonedaI']=="Sus") echo "selected"; echo '>$us</option>
              </select> </td>
			  
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">Otros 
              Costos:</font> <input name="Costo20" id="Costo20" type="text" value="'; if(!empty($row['CostoII'])) {echo $row['CostoII'];	} echo '" size="10" maxlength="5"> 
              <select name="Costo21" id="Costo21">
                <option value="Bs"'; if ($row['MonedaII']=="Bs") echo "selected"; echo '>Bs</option>
                <option value="Sus"'; if ($row['MonedaII']=="Sus") echo "selected"; echo '>$us</option>
              </select></td>
          </tr>
        </table>
		
        <table width="100%">
          <tr> 
            <td width="51%"><font size="2" face="Arial, Helvetica, sans-serif">Prioridad 
              :</font> <strong><font size="2" face="Arial, Helvetica, sans-serif">Alta</font></strong> 
              <input type="radio" id="Prioridad" name="Prioridad" value="1"'; if ($row['Prioridad']=="1") echo "checked";echo '> 
              &nbsp;&nbsp;&nbsp;&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><strong>Media</strong></font> 
              <input type="radio" id="Prioridad" name="Prioridad" value="2"'; if ($row['Prioridad']=="2") echo "checked"; echo '> 
              <strong><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;Baja</font></strong> 
              <input type="radio" name="Prioridad" id="Prioridad" value="3"'; if ($row['Prioridad']=="3") echo "checked"; echo '></td>
            <td width="49%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              Estimada de Entrega :</font>
			  <input type="text" id="fecha_ent" name="fecha_ent" size="10" maxlength="10" value="">
			  </td>
          </tr>
        </table>
		
        <table width="100%">
          <tr> 
            <td width="56%" height="27"><font size="2" face="Arial, Helvetica, sans-serif">Aceptacion 
              del usuario responsable :</font><strong> </strong><font size="2" face="Arial, Helvetica, sans-serif"><strong>SI</strong> 
              </font> 
              <input type="radio" name="Aceptac" id="Aceptac" value="SI"'; if ($row['Aceptac']=="SI") echo "checked"; echo '> 
              <font size="2" face="Arial, Helvetica, sans-serif"><strong>NO</strong></font> 
              <input type="radio" name="Aceptac" id="Aceptac" value="NO"'; if ($row['Aceptac']=="NO") echo "checked"; echo '> 
            </td>
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">Fecha 
              de Asignacion:</font>
			  <input type="text" id="fecha_asig" name="fecha_asig" size="10" maxlength="10" value="">';
			  
			echo '</td>
          </tr>
        </table></td>
    </tr>
	<tr>
	  <td><div align="center"><br>
		  <input type="button" name="submit" id="submit" value="GUARDAR Y CONTINUAR" onclick="guardar_solic();" >
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="RETORNAR" id="RETORNAR" type="button" id="RETORNAR" value="   RETORNAR   " onclick="retornar(1);">
          <br>
        </div></td>
	</tr>
  </table>
  </br>
  <div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
	</form>';
include('top_.php');
?>
</body>
</html>