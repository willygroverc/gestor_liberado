<?php
// Version: 	2.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/AGO/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
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
	<script language="JavaScript" src="js/imp_dym.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script> 
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	
	<script>
$(function() {
	$( "#fecha_cam" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	$( "#fecha_solic" ).datepicker({
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
		var siguienteCampo = "NomUsConf";  
		var nombreForm = "frm_imp" ;
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
<body>
<?php
$OrdAyuda=$IdFicha;
echo '
<table width="80%" border="1" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
  <p>&nbsp;</p>
  <tr>
   
    <td> 
      <form name="frm_imp" id="frm_imp" method="POST" action="#">
	  <input name="var1" id="var1" type="hidden" value="'; echo $OrdAyuda; echo '">
        <table width="100%" border="1" cellpadding="0" cellspacing="0" bgcolor="#006699">
          <tr>
            <td background="images/main-button-tileR1.jpg" height="20"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>30 
                dias despues de la Implantacion</strong></font></div></td>
          </tr>
        </table>
        <br>
        N&deg; Orden de Ayuda :'; echo $OrdAyuda; echo '<br>
        <br>
        <table width="100%">
          <tr> 
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Coordinador 
              de Cambios</font></td>
            <td width="40%"> 
			<select name="NomCordCamb" id="NomCordCamb">
                <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   
              echo '</select> <strong> 
			  <input type="text" name="fecha_cam" id="fecha_cam" size="10" maxlength="10" value="">
              
			  </strong> </td>
            <td width="30%"><textarea name="observ1" cols="40" rows="2" id="observ1"></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%">Si 
              <input type="radio" name="ResuCordConf" id="ResuCordConf" value="SI"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              Parcial 
              <input type="radio" name="ResuCordConf" id="ResuCordConf" value="PARCIAL"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuCordConf" id="ResuCordConf" value="NO"> </td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="30%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Usuario 
              Solicitante</font></td>
            <td width="40%"> 
			<select name="NomUsConf" id="NomUsConf">
                <option value="0"></option>';
			  $sql = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='A') AND bloquear=0 ORDER BY apa_usr ASC";
			  $result = mysql_query($sql);
			  while ($row = mysql_fetch_array($result)) 
				{
				echo "<option value=\"$row[login_usr]\">$row[apa_usr] $row[ama_usr] $row[nom_usr]</option>";
	            }
			   
              echo '</select> <strong> 
			  <input type="text" name="fecha_solic" id="fecha_solic" size="10" maxlength="10" value="">
              
			  </strong> </td>
            <td width="30%"><textarea name="observ2" cols="40" rows="2" id="observ2"></textarea></td>
          </tr>
        </table>
        <table width="100%">
          <tr> 
            <td width="44%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Conformidad 
              de los resultados con la solicitud</font></td>
            <td width="56%">Si 
              <input type="radio" name="ResuUsConf" id="ResuUsConf" value="SI"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              Parcial 
              <input type="radio" name="ResuUsConf" id="ResuUsConf" value="PARCIAL"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No 
              <input type="radio" name="ResuUsConf" id="ResuUsConf" value="NO"> </td>
          </tr>
        </table>
        <br>
        <table width="100%" cellspacing="0" cellpadding="0">
          <tr> 
            <td><div align="center"> 
				<input type="button" name="submit" id="submit" value="GUARDAR" onclick="guardar_imp();" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="button" name="submit" id="submit" value="RETORNAR" onclick="retornar(1);" >
              </div></td>
          </tr>
        </table>
        <br>
      </form>
      
    </td>
  </tr>
</table>
</br>
<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
</div>
</form>
';
?>
</body>
</html>