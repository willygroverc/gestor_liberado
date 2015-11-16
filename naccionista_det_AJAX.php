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
	<script language="javascript" src="js/accionista_det.js"></script>
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
		var nombreForm = "frm_det" ;
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
<body onload="document.getElementById('serie_ac').focus();">
<?php
echo '<table width="75%" border="1" align="center" background="images/fondo.jpg">
          <tr> 
            
      <th background="images/main-button-tileR1.jpg">DATOS DEL ACCIONISTA
	  </th>
          </tr>
          <tr> 
            <td height="52"><table width="100%" border="0">
                <tr>'; 
				/*$sql_a = "SELECT MAX(id_acc) AS id FROM accionistas";
				$recordset_a = mysql_query($sql_a);
				$fila_ac=mysql_num_rows($recordset_a);*/
				
				$sql_i = "SELECT MAX(id_acc) AS id FROM accionistas";
				$result_i = mysql_db_query($db,$sql_i,$link);
				$row_i = mysql_fetch_array($result_i);
				$sql_acc="SELECT * FROM accionistas WHERE id_acc = '$row_i[id]'";
				$res_acc=mysql_query($sql_acc);
				$row_acc=mysql_fetch_array($res_acc);
                echo  '<td width="2%">&nbsp;</td>
                  <td><font size="2"><strong>Nombre o Raz&oacute;n Social: </strong></font></td>
                  <td width="42%"><font size="2">'; echo $row_acc[nom_acc]; echo'</font></td>
                  <td width="17%"><font size="2"><strong>Fecha de Registro:</strong></font></td>
                  <td width="19%"><font size="2">&nbsp;'; echo $row_acc[fecha_acc]; echo'</font></td>
                </tr>
                <tr> 
                  <td>&nbsp;</td>
                  <td width="20%"><font size="2"><strong>Nacionalidad:</strong></font></td>
                  <td><font size="2">'; echo $row_acc[nac_acc]; echo '</font></td>
                  <td><font size="2"><strong>Telefono:</strong></font></td>
				  <td><font size="2">'; echo $row_acc[tel_acc]; echo '</font></td>
                </tr>
				<tr> 
                  <td>&nbsp;</td>
				  <td width="20%"><font size="2"><strong>Direcci&oacute;n:</strong></font></td>
                  <td><font size="2">'; echo $row_acc[dom_acc]; echo'</font></td>
				  <td><font size="2"><strong>Estado: </strong>'; echo $row_acc[estado]; echo'</font></td>
				  <td width="10%"><div align="center"><a href="#">Modificar</div></td>
                </tr>
              </table></td>
          </tr>
    </table>';
	$sql_ed = "SELECT * FROM acciones WHERE id_acc='$num' AND id_ac='$np'";
		$result_ed=mysql_query($sql_ed);
		$row_ed=mysql_fetch_array($result_ed);
echo '<form name="frm_det" id="frm_det" method="POST" action="#">
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <th background="images/main-button-tileR1.jpg">DETALLE DE ACIONES 
      </th>
    </tr>
  </table>	
  <table width="70%" border="1" align="center" background="images/fondo.jpg">
  <tr> 
      <td width="36%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro de Partida</font></div></td>
      <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Nro. de Titulo y Serie de la Accion</font></div></td>
      <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor nominal</font></div></td>
	  <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Fecha de Asiento</font></div></td>
	  <td width="33%" bgcolor="#006699"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Numero de Acciones del Titulo</font></div></td>
	  <td width="31%" bgcolor="#006699"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">Valor Total de Acciones
(en Bolivianos)</font></div></td>
    </tr>
    <tr align="center"> 
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <select name="selecciona" onChange="cambia(this.value)">
        <option value="nuevo" selected>Nuevo</option>';
		  	$sql_r = "SELECT id_ac FROM acciones WHERE id_acc='$num' ORDER BY id_ac ASC";
			$result_r=mysql_db_query($db,$sql_r,$link);
			while($row_r=mysql_fetch_array($result_r)) 
			{	
				echo "<option value=\"$row_r[id_ac]\"";
				if($np==$row_r[id_ac]){echo "selected";}
				echo ">$row_r[id_ac]</option>";
			}
      echo '</select>
        </font>
        <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif"> 
        </font></div></td><td> 
        <input name="serie_ac" id="serie_ac" type="text" value="';echo $row_ed[serie_ac]; echo'">
        </td>
		<td> 
        <input name="val_nom" id="val_nom" type="text" value="';echo $row_ed[val_nom]; echo'">
        </td>
		<td> 
        <input type="text" id="fecha_acc" name="fecha_acc" size="10" maxlength="10"></input>
        </td>
		<td> 
        <input name="accion_tit" id="accion_tit" type="text" value="';echo $row_ed[accion_tit]; echo'">
        </td>
      <td><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">
        <input name="valor" type="text" id="valor" value="Ordinaria" size="25">
        </font><font  size="1" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
    </tr>
  </table>
	<table width="70%" border="1" align="center" background="images/fondo.jpg">
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
