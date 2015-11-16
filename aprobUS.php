<?php
// Version: 	1.0
// Objetivo:	Modificación de funciones php obsoletas para version 5.3 
//				Control de Acceso No Autorizado por URL
///
// Autor:		Alvaro Rodriguez
// Fecha:		13/ago/13
//__________________________________________________________________________
include('top.php');
include('conexion.php');
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
	<script language="JavaScript" src="js/apro_dym.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script> 
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
</head>
<script>
$(function() {
	$( "#fecha_imp" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	$( "#fecha_resp" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	$( "#fecha_cab" ).datepicker({
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
		var nombreForm = "frm_apro" ;
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
<body>
<?php
$OrdAyuda=$IdFicha;
echo '<form name="frm_apro" id="frm_apro" method="POST" action="#">
<input name="var1" id="var1" type="hidden" value="'; echo $OrdAyuda; echo'">
<table width="80%" height="23" border="1" align="center" cellpadding="0" cellspacing="0" bgcolor="#006699">
  <tr>
    <td><div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Aprobaciones 
        (Responsables y Fecha):</font></strong></div></td>
  </tr>
</table>
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <tr>
    <td><form name="form1" method="post" action="'; echo $PHP_SELF; echo'" onKeyPress="return Form()">
	<input name="var" type="hidden" value="'; echo $OrdAyuda; echo '">
        <table width="98%" cellspacing="0" cellpadding="0">
          <tr>
            <td> <p> &nbsp;&nbsp;N&deg; Orden de Ayuda :'; echo $OrdAyuda; echo '</p>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Responsable 
                      de implantacion</font></div></td>
                  <td width="40%"> <div align="center">
                      <select name="NombRespAp" id="NombRespAp">
                        <option value="0"></option>'; 
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
				
                   echo '</select>
                      <strong> 
					  <input type="text" name="fecha_imp" id="fecha_imp" size="10" maxlength="10" value="">
					  </strong> </div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ1" cols="40" rows="2" id="observ1"></textarea>
                    </div></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Usuario 
                      Responsable (implantacion)</font></div></td>
                  <td width="40%"> <div align="center">
                      <select name="NomUsRespAp" id="NomUsRespAp">
                        <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr] $row[nom_usr] </option>";
	            }
                     echo '</select>
                      <strong> 
						<input type="text" name="fecha_resp" id="fecha_resp" size="10" maxlength="10" value="">
                      </strong> </div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ2" cols="40" rows="2" id="observ2"></textarea>
                    </div></td>
                </tr>
              </table>
              <table width="100%">
                <tr> 
                  <td width="30%" height="75"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif">Comite 
                      de Cambios (implantacion en ambiente de produccion)</font></div></td>
                  <td width="40%"><div align="center"><strong> 
                      <select name="ComCambAp" id="ComCambAp">
                        <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0";
			  $result = mysql_db_query($db,$sql,$link);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\"> $row[apa_usr] $row[ama_usr]  $row[nom_usr]</option>";
	            }
			   
                    echo '</select>
					<input type="text" name="fecha_cab" id="fecha_cab" size="10" maxlength="10" value="">
					  </strong></div></td>
                  <td width="30%"><div align="center">
                      <textarea name="observ3" cols="40" rows="2" id="observ3"></textarea>
                    </div></td>
                </tr>
              </table>
              
            </td>
          </tr>
        </table>
        <p align="center"> 
          <input type="button" name="submit" id="submit" value="GUARDAR" onclick="guardar_apro();" >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="button" name="submit" id="submit" value="RETORNAR" onclick="retornar();" >
        </p>
        </form>
     
    </td>
  </tr>
</table></br>
<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
</div>
</form>
';
?>
</body>
</html>