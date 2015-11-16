<?php
include('top.php');
require ("conexion.php");
@session_start();
$login=$_SESSION["login"];
$tipo=$_SESSION["tipo"];
?>
<html>
<head>
	<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<link href="css/validation.css" rel="stylesheet" type="text/css">
	<link href="css/tiny_box.css" rel="stylesheet" type="text/css">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script language="javascript" src="js/ajax.js"></script>
	<script language="javascript" src="js/accionista.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/tinybox.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	<script>
		$(function() {
			$( "#fecha_acc" ).datepicker({
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
		var siguienteCampo = "nom_acc";  
		var nombreForm = "frm_acc" ;
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
						guardar_nuevo_acc();
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
<body onload="document.getElementById('nom_acc').focus();">
<?php
echo '<form name="frm_acc" id="frm_acc" method="POST" action="#">
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
      </th>
    </tr>
  </table>	
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
      <td width="36%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE O RAZON SOCIAL DEL ACCIONISTA </font></div></td>
      <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA 
          DE REGISTRO</font></div></td>
      <td width="31%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NACIONALIDAD</font></div></td>
    </tr>
    <tr align="center"> 
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nom_acc" type="text" id="nom_acc" value="" size="50">
        </font>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        </font></div></td><td> 
        <input type="text" id="fecha_acc" name="fecha_acc" size="10" maxlength="10"></input>
        </td>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="nac_acc" type="text" id="nac_acc" value="Boliviano" size="25">
        </font><font  size="1" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
  </table>
	<table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="51%" bgcolor="#006699" > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">DOMICILIO</font></div></td>
      <td width="49%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">TELEFONO</font></td>
      <td width="49%" bgcolor="#006699" align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">ESTADO</font></td>
    </tr>
	<tr> 
	
	  <td width="51%"  > <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
          <input name="dom_acc" type="text" id="dom_acc" value="" size="60">
          </font></div></td>
      <td width="49%"  align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica">
	   <input name="tel_acc" type="text" id="tel_acc" value="" size="20">
	  </font></td>
      <td width="49%"  align="center">
	  <select name="estado" id="estado">
		<option value="0"></option>
		<option value="Suscrito">Suscrito</option>
        <option value="Pagado">Pagado</option>
      </select></td>
	</tr>
   <tr> 
      <td colspan="3"><div align="center"> <br>
          <input type="button" name="submit" id="submit" value="GUARDAR Y CONTINUAR" onclick="guardar_nuevo_acc();" >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="submit" name="retornar" value="RETORNAR">
        </div></td>
    </tr>
  </table>
  <br>
		<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Campos validados</div>
		</div>
</form>';
