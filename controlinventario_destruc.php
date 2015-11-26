<?php
// Version: 	1.0
// Objetivo: 	Limpieza de datos al guardar en la base de datos.
//				Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		05/SEP/2012
// Autor: 		Alvaro Rodriguez
//_____________________________________________________________________________
include('top.php');
@session_start();

?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/medios_destru.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	<script>
$(function() {
	$( "#fecha_ant" ).datepicker({
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
		var siguienteCampo = "fecha_ant";  
		var nombreForm = "frm_inv" ;
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
</head>
<body onclick="document.getElementById.('###').focus();">
<?php
echo '
<form name="frm_inv" id="frm_inv" action="#" method="POST">
<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
	<input name="var1" id="var1" type="hidden" value="'; echo $_REQUEST['Codigo']; echo '">
	
	<tr> 
      <td height="161"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr> 
            <th colspan="5" nowrap bgcolor="#006699"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">INVENTARIO 
              DE MEDIOS - DESTRUCCION DE MEDIO DE ALMACENAMIENTO</font></th>
          </tr>
          <tr> 
            <th width="109" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></th>
            <th width="184" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA 
              ALTA </font></th>
            <th width="276" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">TIPO</font></th>
            <th width="146" colspan="1" nowrap bgcolor="#006699"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">OBSERVACIONES</font></div></th>
            <th width="147" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">FECHA 
              BAJA </font></th>
          </tr>';
		
		$sql = "SELECT *, DATE_FORMAT(FechaAlta, '%d/%m/%Y') AS FechaAlta, DATE_FORMAT(FechaBaja, '%d/%m/%Y') AS FechaBaja 
				FROM controlinvent WHERE Codigo ='$_REQUEST[Codigo]'"; 
		$result=mysql_db_query($db,$sql,$link);
		while($row=mysql_fetch_array($result)) 
  		{ 
		 
         echo '<tr align="center"> 
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row['codigo_usu']; echo '</font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row['FechaAlta']; echo '</font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; if(!empty($row['Tipo'])) { echo $row['Tipo']; } echo '</font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row['Observ']; echo '</font></td>
            <td><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row['FechaBaja']; echo '</font></td>
          </tr>';
		 }
          echo '<tr> 
            <td colspan="6" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
        </table>
        <table width="100%" border="1">
          <tr> 
            <td width="71%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif">INSERTE 
                LA FECHA EN LA QUE SE DESTRUIRA AL MEDIO DE ALMACENAMIENTO DESCRITO</font></strong></div></td>
            <td width="29%"><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
               <input type="text" name="fecha_ant" id="fecha_ant" maxlength="10" value="'; echo date('Y/m/d'); echo '"></input>
                </font>
				</font></strong></div></td>
          </tr>
        </table>
        <table width="100%" border="1" align="center">
          <tr> 
            <td width="56%"><div align="center"><br>
                <input type="button" name="submit" id="submit" value="GUARDAR" onclick="guardar_inven();" >
              </div></td>
            <td width="44%"><div align="center"><br>
                <input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar();">
              </div></td>
          </tr>
        </table>
        
      </td>
    </tr></form>
  </table>
</form>
';
?>
</body>
</html>