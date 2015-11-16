<?php
include('top.php');
@session_start();
require_once('funciones.php');

$IdSistema=  isset($_REQUEST['IdSistema']);
$IdSistema=SanitizeString($IdSistema);
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/sistema.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	<script>
$(function() {
	$( "#FechAlta" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});

	$( "#GarantDe" ).datepicker({
	dateFormat: 'yy/mm/dd',
	showOn: 'both',
	changeMonth: true,
	changeYear: true,
	buttonImage: 'images/cal.gif',
	buttonImageOnly: true,
	buttonText: 'Selecciona una fecha'
	});
	
	$( "#GarantAl" ).datepicker({
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
		var siguienteCampo = "Descripcion";  
		var nombreForm = "frm_sistema" ;
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
						guardar_nueva_ficha();
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
<body onload="document.getElementByID('Descripcion').focus();">
<?php

$idsis=$_REQUEST['IdSistema'];
//echo $idsis;
echo '<form name="frm_sistema" id="frm_sistema" method="POST" action="#">
  <input name="var1" id="var1" type="hidden" value="'; echo $idsis; echo '">
  <table width="90%" border="1" align="center" background="images/fondo.jpg" bgcolor="#EAEAEA">
    <tr> 
            <th colspan="8" background="images/main-button-tileR2.jpg" height="22">LISTADO DE PROPIETARIOS Y RESPONSABLES</th>
          <tr align="center" bgcolor="#006699"> 
            <th width="5%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">Nro.</th>
            <th width="29%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">SISTEMA</th>
            <th width="11%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">TIPO</th>
            <th colspan="2" class="menu" background="images/main-button-tileR2.jpg">UNIDAD DE SISTEMAS</th>
            <th colspan="3" class="menu" background="images/main-button-tileR2.jpg">DUENO</th>
          </tr>
          <tr align="center" bgcolor="#006699"> 
            <th width="12%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
            <th width="10%" class="menu" background="images/main-button-tileR2.jpg">Area</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="11%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>';
	$sql = "SELECT * FROM sistemas WHERE Id_Sistema='$idsis' ORDER BY Id_Sistema ASC";
	$result=mysql_db_query($db,$sql,$link);
	while($row=mysql_fetch_array($result)) 
	{ 	
		echo '<tr align="center">'; 
		echo '<td>&nbsp;'; echo $row['Id_Sistema']; echo '</td>
            <td>&nbsp;'; echo $row['Descripcion']; echo '</td>
            <td>&nbsp;'; echo $row['Id_Tipo']; echo '</td>';
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular1]'";
		   $result5 = mysql_db_query($db,$sql5,$link);
		   $row5 = mysql_fetch_array($result5);
			echo '<td>&nbsp;';echo $row5['nom_usr']; echo $row5['apa_usr']; echo $row5['ama_usr']; echo '</td>';
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente1]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo '<td>&nbsp;'; echo $row5['nom_usr']; echo $row5['apa_usr']; echo $row5['ama_usr']; echo '</td>';
			
            echo '<td>&nbsp;'; echo $row['Area']; echo '</td>';
			$sql5 = "SELECT * FROM users WHERE login_usr='$row[Titular2]'";
		   $result5 = mysql_db_query($db,$sql5,$link);
		   $row5 = mysql_fetch_array($result5);
			echo '<td>&nbsp;'; echo $row5['nom_usr']; echo $row5['apa_usr']; echo $row5['ama_usr']; echo '</td>';
		    $sql5 = "SELECT * FROM users WHERE login_usr='$row[Suplente2]'";
		    $result5 = mysql_db_query($db,$sql5,$link);
		    $row5 = mysql_fetch_array($result5);
			echo '<td>&nbsp;'; echo $row5['nom_usr']; echo $row5['apa_usr']; echo $row5['ama_usr']; echo '</td>';
          echo '</tr>';	  
              echo '<tr> 
            <td colspan="8" height="1" nowrap>&nbsp;</td>
          </tr>
        </table>
		
		<table width="90%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th width="23%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">SISTEMA</th>
            <th width="19%" rowspan="2" class="menu" background="images/main-button-tileR2.jpg">TIPO</th>
            <th colspan="2" background="images/main-button-tileR2.jpg" class="menu">UNIDAD DE SISTEMA</th>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="32%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
            <td><div align="center"> 
                
          <input name="Descripcion" id="Descripcion" type="text" value="'; echo $row['Descripcion']; echo '" size="25" maxlength="40">
              </div></td>
            <td><div align="center"> 
                <select name="Id_Tipo" id="Id_Tipo">
                  <option value="APLICACION"'; if ($row['Id_Tipo']=="APLICACION") echo "selected"; echo '>APLICACION</option>
				  <option value="OFIMATICA"'; if ($row['Id_Tipo']=="OFIMATICA") echo "selected";echo '>OFIMATICA</option>
        		  <option value="SISTEMA OPERATIVO"'; if ($row['Id_Tipo']=="SISTEMA OPERATIVO") echo "selected"; echo '>SISTEMA OPERATIVO</option>
				  <option value="BASE DE DATOS"'; if ($row['Id_Tipo']=="BASE DE DATOS") echo "selected"; echo '>BASE DE DATOS</option>
				  <option value="UTILITARIO"'; if ($row['Id_Tipo']=="UTILITARIO") echo "selected"; echo '>UTILITARIO</option>
        		  <option value="VARIOS"'; if ($row['Id_Tipo']=="VARIOS") echo "selected"; echo '>VARIOS</option>
                </select>
              </div></td>
            <td><div align="center"> 
                <select name="Titular1" id="Titular1">
				<option></option>';
				 $sql3 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Titular1']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } 
                echo '</select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente1" id="Suplente1">
				<option></option>';
				 $sql3 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Suplente1']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } 
                echo '</select>
              </div></td>
          </tr>
        </table>
		
		<table width="90%" border="1" align="center" background="images/fondo.jpg">
    <tr bgcolor="#006699"> 
            <th colspan="3" class="menu" background="images/main-button-tileR2.jpg">DUENO</td>
          </tr>
          <tr bgcolor="#006699"> 
            <th width="25%" class="menu" background="images/main-button-tileR2.jpg">Area</th>
            <th width="49%" class="menu" background="images/main-button-tileR2.jpg">TITULAR</th>
            <th width="26%" class="menu" background="images/main-button-tileR2.jpg">SUPLENTE</th>
          </tr>
          <tr> 
		  
            <td><div align="center">
                <select name="Area" id="Area">
				<option></option>';
				 $sql3 = "SELECT * FROM datos_adicionales";
			     $result3 = mysql_query($sql3);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Area']==$row3['nombre_dadicional'])
				 			echo "<option value=\"$row3[nombre_dadicional]\" selected> $row3[nombre_dadicional]</option>";			
				   else
							echo "<option value=\"$row3[nombre_dadicional]\"> $row3[nombre_dadicional]</option>";
	               } 
                echo '</select>
              </div></td>
            <td><div align="center">
                <select name="Titular2" id="Titular2">
				<option></option>';
				 $sql3 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Titular2']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } 
                echo '</select>
              </div></td>
            <td><div align="center"> 
                <select name="Suplente2" id="Suplente2">
				<option></option>';
				 $sql3 = "SELECT * FROM users WHERE (tipo2_usr='T' OR tipo2_usr='C') AND bloquear=0 ORDER BY apa_usr ASC";
			     $result3 = mysql_db_query($db,$sql3,$link);
			     while ($row3 = mysql_fetch_array($result3)) 
				   {
				   if ($row['Suplente2']==$row3['login_usr'])
				 			echo "<option value=\"$row3[login_usr]\" selected>$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";			
				   else
							echo "<option value=\"$row3[login_usr]\">$row3[apa_usr] $row3[ama_usr] $row3[nom_usr]</option>";
	               } 
                echo '</select>
              </div></td>
          </tr>
          <tr> 
            <td height="47" colspan="3">
<div align="center"> <br>
				<input type="button" name="submit" id="submit" value="GUARDAR CAMBIOS" onclick="guardar_sistema();" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar();">
              </div></td>
          </tr>
       </table>
	 <div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos estan validados</div>
		</div>
	   </form>';
	}

?>
</body>
</html>
