<?php
include('top.php');
include('conexion.php');
require_once('funciones.php');
$codub=SanitizeString($codub);
@session_start();
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
	<link rel="stylesheet" href="css/calendar.css" />
	<script language="javascript" src="js/jquery.js"></script>
	<script language="JavaScript" src="js/controlt.js"></script>
	<script language="JavaScript" src="js/ajax.js"></script>
	<script language="javascript" src="js/validate.js"></script>
	<script language="javascript" src="js/jquery-ui.js"></script>
	<script>
$(function() {
	$( "#fecha_ctrl" ).datepicker({
	dateFormat: 'Y-m-d',
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
		var siguienteCampo = "codigo";  
		var nombreForm = "frm_respaldos" ;
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
						guardar_resp();
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
<body onload="document.getElementById('codigo').focus();">
<?php
echo '<table width="90%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#006699"  background="images/fondo.jpg" bgcolor="#EAEAEA">
  <form name="frm_respaldos" id="frm_respaldos" method="post" action="#" />
	<input name="var1" id="var1" type="hidden" value="'; echo $codub; echo '">
	<tr> 
      <td height="150"> 
        <table width="100%" border="2" align="center" cellpadding="2" cellspacing="4" background="images/fondo.jpg">
          <tr align="center"> 
            <th width="60" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CODIGO</font></th>
            <th width="154" rowspan="2" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">FECHA</font></div></th>
            <th width="175" rowspan="2" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">CONTENIDO</font></th>
            <th colspan="4" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">UBICACION</font></th>
			<th width="165" rowspan="2" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Observaciones</font></th>
		   </tr>
          <tr align="center"> 
            <th width="68" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">SISTEMA</font></th>
            <th width="60" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">NEGOCIO</font></th>
            <th width="36" nowrap bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">SE1</font></th>
            <th width="51" nowrap bgcolor="#006699"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">SE2</font></th>
          </tr>';
		$sql1 = "SELECT *, DATE_FORMAT(fecha, '%Y-%m/%d') AS fecha FROM ubicacionresp WHERE codub='$codub'";
		$result1=mysql_query($sql1);
		while($row1=mysql_fetch_array($result1)) 
  		{ 
         echo '<td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row1['codigo']; echo '</font></div></td>
            <td> 
              <div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row1['fecha']; echo '</font></div></td>
          <td><div align="center"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;'; echo $row1['contenido']; echo '</font></div></td>';
           if  ($row1['ubi_sistema']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.png\" border=\"0\"></font></td>";}
			  	  	else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.png\" border=\"0\"></font></td>";}
           if  ($row1['ubi_negocio']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.png\" border=\"0\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.png\" border=\"0\"></font></td>";}
           if  ($row1['ubi_SE1']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.png\" border=\"0\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.png\" border=\"0\"></font></td>";} 
           if  ($row1['ubi_SE2']=="1") {echo "<td align=\"center\"><font size=\"1\"><img src=\"images/si1.png\" border=\"0\"></font></td>";}
  					else{ echo "<td align=\"center\"><font size=\"1\"><img src=\"images/no1.png\" border=\"0\"></font></td>";}
          echo '<td align="center">'; echo $row1['observ']; echo '</td>
		  </tr>
          <tr> 
            <td colspan="7" height="7" nowrap><font size="1" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;</font> 
              <div align="center"></div></td>
          </tr>
          <tr> 
            <td width="60" nowrap height="7"><div align="center"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif"> 
                  <select name="codigo" id="codigo">';
			     $sql2 = "SELECT * FROM controlinvent ";
			     $result2 = mysql_query($sql2);
			     while ($row2 = mysql_fetch_array($result2)) 
				{   if ($row2['Codigo']==$row1['codigo'])
				{echo '<option value="'.$row2['Codigo'].'" selected>'.$row2['Codigo'].'. '.$row2['Tipo'].'</option>';}
			  else{
				echo '<option value="'.$row2['Codigo'].'">'.$row2['Codigo'].'. '.$row2['tipo_medio'].'</option>';}}
              echo '</select>
                  </font></p>
              </div></td>
            <td nowrap height="7">
<div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
			  <input type="text" id="fecha_ctrl" name="fecha_ctrl" size="10" maxlength="10" value="'; echo $row1['fecha']; echo '"></input>
				</font></div></td>
            <td width="175" nowrap height="7"><div align="center"> 
                <textarea name="contenido" id="contenido" cols="25">'; echo $row1['contenido']; echo '</textarea>
                 </div></td>
            <td align="center"> 
              <input name="Sistema" id="Sistema" type="checkbox" value="1"'; if ($row1['ubi_sistema']=="1") echo "checked"; echo '> 
            </td>
            <td align="center"><input type="checkbox" name="Negocio" id="Negocio" value="1"'; if ($row1['ubi_negocio']=="1") echo "checked"; echo '> 
            </td>
            <td align="center"> <input type="checkbox" name="SE1" id="SE1" value="1"'; if ($row1['ubi_SE1']=="1") echo "checked"; echo '> 
            </td>
            <td align="center"> <input type="checkbox" name="SE2" id="SE2" value="1"'; if ($row1['ubi_SE2']=="1") echo "checked"; echo '> 
            </td>
			<td><strong>
			  <textarea name="observ" cols="25" id="observ">'; echo $row1['observ']; echo '</textarea>
			</strong></td>
          </tr>
          <tr> 
            <td height="28" colspan="8" nowrap> <div align="center"><br>
                <input name="insertar" type="submit" id="reg_form3" value="GUARDAR CAMBIOS" onclick="guardar_resp();">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                <input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar(1);">
              </div></td>
          </tr>
        </table>
		</br>
		<div id="lbl_ajax" align="center">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
		</div>
      </td>
    </tr></form>
  </table>';
}
?>
</body>
</html>