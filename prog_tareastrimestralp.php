<?php
include('top.php');
require_once('funciones.php');
if($_SESSION['tipo']=="C"){
 location("header:pagina_inicio.php");
 return;
}
?>
<html>
<head>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="JavaScript" src="js/tarea_trimestral.js"></script>
<script language="JavaScript" src="js/ajax.js"></script>
<script language="javascript" src="js/validate.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script>
$(function() {
	$( "#FechaProceso" ).datepicker({
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
</head>
<body onload="document.getElementById('Actividad').focus();">
<?php
$wTarea=0;
$numcad=0;
$varcad=0;
echo '
  <form name="frm_trimestral" id="frm_trimestral" method="post" action="#">
	<input name="IdProgTarea" type="hidden" id="IdProgTarea" value="'; echo $IdProgTarea; echo '">
    <input name="action" type="hidden" id="action" value="'; echo $_GET["do"]; echo '">
    <table width="70%" border="1" align="center" cellpadding="2" cellspacing="0" background="images/fondo.jpg">
      <tr>
        <th colspan="10" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="3" face="Arial, Helvetica, sans-serif">PROGRAMACION DE TAREAS - TRIMESTRALES<br>';
				echo "Registro Nuevo"; 
        echo '</font></th>
      </tr>
      <tr>
        <th height="60" colspan="10" background="images/main-button-tileR2.jpg">
          <p><font size="2" face="Arial, Helvetica, sans-serif">Fecha: </font>   
		<input type="text" name="FechaProceso" id="FechaProceso"  value="'; echo date('Y-m-d'); echo '" size="10" maxlength="10">
		</th>
	 </tr>
      <tr align="center">
        <th rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Actividad</font></th>
        <th colspan="2" background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Hora</font></th>
        <th width="282" rowspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Mes</font></th>
        <th width="282" rowspan="2" background="images/main-button-tileR2.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">Dia</font></th>
        <th width="282" colspan="5" rowspan="2" background="images/main-button-tileR2.jpg"><font size="2" face="Arial, Helvetica, sans-serif" color="#FFFFFF">Observaciones</font></th>
      </tr>
      <tr align="center">
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">De</font></th>
        <th width="150" nowrap background="images/main-button-tileR1.jpg"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">A</font></th>
      </tr>
      <tr>
        <td width="91" height="7" nowrap>
          <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Actividad" id="Actividad" cols="30" rows="4" id="textarea3"></textarea>
        </strong></font></div></td>
        <td height="3" nowrap><div align="center"><strong>
            <select name="Hora1" id="Hora1">';
			  for($i=1;$i<=24;$i++)
				{ echo "<option value=\"$i\"";
				if($i==substr($wTarea["HoraDe"],0,2)) print "selected";
				print ">$i</option>"; }
            echo '</select>
        -
        <select name="Min1" id="Min1">';
		for($i=0; $i<=60; $i=$i+5){
					print "<option value=\"$i\"";
					if($i==substr($wTarea["HoraDe"],3,2)) print "selected";
					print ">$i</option>";
				} 
        echo '</select>
        </strong></div></td>
        <td height="7" nowrap><div align="center"><strong>
            <select name="Hora2" id="Hora2">';
			  for($i=1;$i<=24;$i++)
				{echo "<option value=\"$i\">$i</option>";}
            echo '</select>
        - 
        <select name="Min2" id="Min2">';
		for($i=0; $i<=60; $i=$i+5){
					print "<option value=\"$i\"";
					if($i==substr($wTarea["HoraA"],3,2)) print "selected";
					print ">$i</option>";
				} 
        echo '</select>
        </strong></div></td>
        <td align="center" nowrap><strong>
          <select name="Mes" id="Mes">';
		  for($tmp=1; $tmp<=3; $tmp++){
					print "<option value=\"$tmp\"";
					if($tmp==$wTarea["Mes"]) print "selected";
					print ">$tmp</option>";
			}
      echo '</select>
        </strong></td>
        <td align="center" nowrap><strong>
          <select name="Dia" id="Dia">';
		  for($tmp=1; $tmp<=31; $tmp++){
					print "<option value=\"$tmp\"";
					if($tmp==$wTarea["Dia"]) print "selected";
					print ">$tmp</option>";
			} 
		echo '</select>
        </strong></td>
        <td height="7" colspan="5" nowrap>
          <div align="center"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>
            <textarea name="Observaciones" id="Observaciones" cols="30" rows="4" id="textarea4"></textarea>
        </strong></font> </strong></div></td>
      </tr>
 <tr>
 	<td colspan="8" align="center" valign="middle">
	  <table>
	  <tr>
	  <td><strong><font size="2" face="Arial, Helvetica, sans-serif">Asignar a : </font></strong></td>
	  <td>';
			  $sql = "select CONCAT(apa_usr, ' ', ama_usr, ' ', nom_usr) as nombre, roles.login_usr as login, tipo2_usr from roles,users where users.login_usr = roles.login_usr and calendariza = 'r' and tipo2_usr = 'T' and bloquear = 0";
			  $resultado = mysql_query($sql,$link);
	  		echo '<select  name="lista" id="lista" size="6" style="width:250px" multiple="multiple">';
				 $total_reg=1;
				 $sql0 = "SELECT * FROM users WHERE bloquear=0 AND (tipo2_usr='T' OR tipo2_usr='A') ORDER BY apa_usr ASC";
			     $result0=mysql_db_query($db,$sql0,$link);
				 while ($row0=mysql_fetch_array($result0)) 
				 {
					echo '<option value="'; echo $row0['login_usr']; echo '"'; for($j=0;$j<=$numcad;$j++){ if($row0['login_usr']==$varcad[$j]){echo "selected";}   } echo '>';
				$nombre = $row0['apa_usr']." ".$row0['ama_usr']." ".$row0['nom_usr'];
				echo $nombre;
				$total_reg++;
             echo '</option>';
				}
            echo '</select>
			</td>
		</tr>
		</table>
	  </td>
 </tr>
    <tr>
        <td height="28" colspan="10" nowrap>
          <div align="center"><br>
              <input name="INSERTAR" type="button" id="INSERTAR2" value="INSERTAR" onclick="guardar_trimestral();">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" name="Terminar" value="RETORNAR" onclick="retornar();">
        </div>
		</td>
      
	  </tr>
    </table> </br>
	<div id="lbl_ajax">
			<div style="display: none;" class="success_box">Valida...</div>
			<div style="display: block;" class="error_box" id="error_box">Los campos con marcados con (*) son obligatorios</div>
	</div>
  </form>
';
?>
</body>
</html>