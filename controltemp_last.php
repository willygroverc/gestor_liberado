<?php
include('top.php');
require_once('funciones.php');
$numero=  $_REQUEST['numero'];

$numero=SanitizeString($numero);
include('conexion.php');
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
$(document).ready(function() {
	$( "#fecha_ctrl" ).datepicker({
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
<body onLoad="document.getElementById('temperatura').focus();">
<?php
$sql = "SELECT *, DATE_FORMAT(fecha, '%d/%m/%Y') AS fecha FROM controltemp WHERE numero='$numero'";

$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$fec=explode("/",$row['fecha']);
echo '<form name="frm_temp" id="frm_temp" method="POST" action="" />
	<input name="var1" id="var1" type="hidden" value="'; echo $numero; echo '">
  <table width="83%" border="2" align="center" cellpadding="0" cellspacing="0" background="images/fondo.jpg">
    <tr> 
      <td heigth="20px" colspan="7" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">CONTROL 
          DE TEMPERATURA Y HUMEDAD RELATIVA</font></div></td>
    </tr>
    <tr bgcolor="#006699"> 
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">N</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1">NOMBRE RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td><div align="center">&nbsp;'; echo $row['numero'];echo '</div></td>
      <td><div align="center">&nbsp;'; echo $row['hora']; echo '</div></td>
      <td><div align="center">&nbsp;'; echo $row['fecha']; echo '</div></td>
      <td><div align="center">&nbsp;'; echo $row['temperatura']; echo '</div></td>
      <td><div align="center">&nbsp;'; echo $row['hr']; echo '</div>
	  

        </td>
      <td><div align="center">'; echo $row['nombresp']; echo '&nbsp;</div></td>
      <td colspan="7"><div align="center">'; echo $row['observ']; echo '&nbsp;</div>
        </td>
    </tr>
    <tr> 
      <td colspan="7">&nbsp;</td>
    </tr>
  </table>
    <table width="83%" border="1" align="center" background="images/fondo.jpg">
    <tr> 
      <td width="32%" height="19" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HORA</font></div></td>
      <td width="27%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">FECHA</font></div></td>
      <td width="41%" background="images/main-button-tileR2.jpg"> <div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">TEMPERATURA 
          (&ordm;C) </font></div></td>
    </tr>
    <tr> 
      <td><div align="center"> 
          <div align="center">'; echo $row['hora']; echo '</div>
        </div></td>
      <td><div align="center"><strong><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
         <input type="text" name="fecha_ctrl" id="fecha_ctrl" value="'.$fec[2]."/".$fec[1]."/".$fec[0].'">
          </font>
		  
		  </font></strong></div></td>
      <td><div align="center"> 
          <input name="temperatura" id="temperatura" type="text" value="'; echo $row['temperatura']; echo '" size="10" maxlength="3" >
        </div></td>
    </tr>
    <tr> 
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">HUMEDAD 
          RELATIVA (%)</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">NOMBRE 
          RESPONSABLE</font></div></td>
      <td background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></div></td>
    </tr>
    <tr> 
      <td> <div align="center"> 
          <input name="hr" id="hr" type="text" value="'; echo $row['hr']; echo '" size="10" maxlength="3">
        </div></td>
      <td> <div align="center"> 
          <select name="nombresp" id="nombresp">
            <option value="0"></option>';
			  $link = mysql_connect($host,$user,$pass) or die ("Error durante la conexion a la base de datos"); 
			  $sql8 = "SELECT * FROM users WHERE tipo2_usr='T' AND bloquear=0 ORDER BY apa_usr ASC";
			  $result8 = mysql_query($sql8);
			  while ($row8 = mysql_fetch_array($result8)) 
				{
				echo "<option value=\"$row8[login_usr]\"";
				if ($row8['login_usr']==$row['nombresp']) echo "selected";
				echo " >$row8[apa_usr] $row8[ama_usr] $row8[nom_usr]</option>";
	            }
          echo '</select>
        </div></td>
      <td> <div align="center"> 
          <textarea name="observ" id="observ" cols="20">'; echo $row['observ']; echo '</textarea>
        </div></td>
    </tr>
    <tr> 
      <td colspan="3"><div align="center">
	  <br>
          <input type="submit" name="GUARDATOS" value="GUARDAR CAMBIOS" onclick="guardar_control();">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
          <input type="button" name="RETORNAR" value="RETORNAR" onclick="retornar();">
          <input type="hidden" name="a" id="a" value="'; echo $row['hora']; echo '">
          <input type="hidden" name="a2" id="a2" value="'; echo $row['numero']; echo '">
        </div></td>
    </tr>
  </table></br>
  <div id="lbl_ajax">
			<div style="display: none;" class="success_box"></div>
			<div style="display: block;" class="error_box" id="error_box">Los campos estan validados</div>
		</div>
  </form>';
  
  ?>
</body>
</html>