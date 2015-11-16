<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		03/SEP/2013
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
include('top.php');
require_once('funciones.php');
@session_start();
if ($_SESSION['tipo']=='C'){
	header("location: pagina_inicio.php");
	return;
}
$idplanpru=SanitizeString($idplanpru);
$OrdAyuda=$idplanpru;
//$OrdAyuda=_clean($OrdAyuda);
$OrdAyuda=SanitizeString($OrdAyuda);
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/planifica.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
	$( "#fecplanif" ).datepicker({
	dateFormat: 'yy-mm-dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	
	$( "#fecelab" ).datepicker({
	dateFormat: 'yy-m-d',
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
		var siguienteCampo = "fecplanif";  
		var nombreForm = "frm_planif_last" ;
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
						guardar_planif_last();
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
<body onload="document.getElementById('objprue').focus();">
<?php
require_once('funciones.php');
$OrdAyuda=SanitizeString($OrdAyuda);
$sql = "SELECT * FROM planprueba WHERE ordayuda='$OrdAyuda'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
echo '<form name="frm_planif_last" id="frm_planif_last" method="POST" action="">
<input name="var1" id="var1" type="hidden" value="'; echo $OrdAyuda; echo '">
<input name="var2" id="var2" type="hidden" value="'; echo $OrdAyuda; echo '">
<table width="89%" height="285" border="0" align="center" background="images/fondo.jpg">
    <tr> 
      <td height="281"> 
        <table width="100%" border="1">
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>PLANIFICACION 
                DE PRUEBAS</strong></font></div></td>
          </tr>
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
                DE PLANIFICACION</font> </div></td>
            <td><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
                DE ELABORACION</font></div></td>
          </tr>
          <tr bordercolor="#000000"> 
            <td height="38"> <div align="center"><strong> 
               <input type="text" name="fecplanif" id="fecplanif" value="';echo date('Y-m-d'); echo '">
                
				</strong></div></td>
            <td><div align="center"><strong> 
               <input type="text" name="fecelab" id="fecelab" value="'; echo date('Y-m-d'); echo '">
                
				</strong></div>
              <div align="center"></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td width="34%"><blockquote> 
                <blockquote> 
                  <div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Objetivo 
                    de la Prueba</font></div>
                </blockquote>
              </blockquote></td>
            <td width="66%"><textarea name="objprue" id="objprue" cols="108">'; echo $row['objprue']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Tipo de 
                    Contingencia</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="tipcontin" id="tipcontin" cols="108">'; echo $row['tipcontin']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Condiciones</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="condicion" id="condicion" cols="108">'; echo $row['condicion']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Fechas 
                    Relacionadas</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="fecrelac" id="fecrelac" cols="108">'; echo $row['fecrelac']; echo '</textarea></td>
          </tr>
          <tr> 
            <td height="69"> <blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Varios</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="varios" id="varios" cols="108">'; echo $row['varios']; echo '</textarea></td>
          </tr>
          <tr bordercolor="#000000" bgcolor="#006699"> 
            <td colspan="2"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>RECURSOS 
                NECESARIOS</strong></font></div></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Hardware</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="rechard" id="rechard" cols="108">'; echo $row['rechard']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Software</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="recsoft" id="recsoft" cols="108">'; echo $row['recsoft']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Recursos 
                    de Respaldo</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="recresp" id="recresp" cols="108">'; echo $row['recresp']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Facilidades</font></p>
                </blockquote>
              </blockquote></td>
            <td><textarea name="facilidad" id="facilidad" cols="108">'; echo $row['facilidad']; echo '</textarea></td>
          </tr>
          <tr> 
            <td><blockquote> 
                <blockquote> 
                  <p><font size="2" face="Arial, Helvetica, sans-serif">Costo</font></p>
                </blockquote>
              </blockquote></td>
            <td><input name="costo" id="costo" type="text" maxlength="10" value="'; echo $row['costo']; echo '"> 
			<select name="moneda" id="moneda">
                <option value="Bs"'; if($row['moneda']=="Bs") echo "selected"; echo '>Bs</option>
                <option value="Sus"'; if($row['moneda']=="Sus") echo "selected"; echo '>$us</option>
              </select></td>
          </tr>
          <tr> 
            <td height="24" colspan="2"><div align="center"> 
                <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr bgcolor="#006699"> 
                    <td width="49%" height="18"> <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">NOMBRE 
                        DE JEFE DE AREA</font></div></td>
                  </tr>
                  <tr> 
                    <td><div align="center"><br>
                       <select name="jefeus" id="jefeus">
                          <option value="0"></option>';
						  $sql11 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
						  $result11 = mysql_query($sql11);
						  while ($row11 = mysql_fetch_array($result11)) 
							{
							echo '<option value="'.$row11['login_usr'].'"';
							if ($row11['login_usr']==$row['jefeus']) echo "selected";
							echo ' >'.$row11['apa_usr'].' '.$row11['ama_usr'].' '.$row11['nom_usr'].'</option>';
							}
							echo '</select>
                      </div></td>
                  </tr>
                </table>
                <br>
				<input name="GUARDATOS" type="submit" id="GUARDATOS" value="GUARDAR Y CONTINUAR" onclick="guardar_planif_last();">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
				<input type="button" name="RETORNAR" value="MODIFICAR" onclick="resp_modi('; echo $OrdAyuda; echo ');">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar(1);">
              </div></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
<div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
</div>
</form>
';
?>
</body>
</html>
