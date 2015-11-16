<?php
@session_start();
if ($_SESSION['tipo']=='C')
	header('location:pagina_inicio.php');

require("conexion.php");
$login_usr = $_SESSION["login"];
include ("top.php");
//if ($tipo=="A" or $tipo=="T")
		
echo '<table width="80%" border="1" align="center" bgcolor="#006699">
    <tr> 
      <td width="60%" background="windowsvista-assets1/main-button-tile.jpg" height="30px"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda 
          por :</strong></font> 
		  <select id="menu" onchange="document.getElementById(\'pg\').value=1;filtrar_lista();">
            <option value="" if ($menu==""){echo "selected";}>Elegir filtro</option>		  
            <option value="cod" if ($menu=="prov"){echo "selected";}>NOM. PROVEEDOR</option>
			<option value="tel" if ($menu=="prov"){echo "selected";}>TELEFONO</option>
			<option value="nom" if ($menu=="prov"){echo "selected";}>ENCARGADO</option>
          </select>
          &nbsp;&nbsp;&nbsp; 
		  <input name="text" id="text" type="text" size="25" maxlength="25" value="" onkeyup="filtrar_lista();"></input>
        </div></td>
	    </tr>
  </table>';

echo '<div id="tbl_ajax"></div>';
echo "<br>";
echo "<input name=\"nueva\" type=\"submit\" id=\"nueva\" value=\"NUEVO PROVEEDOR\" onclick=\"location.href = 'proveedor.php'\">";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<input name=\"estadisticas\" type=\"submit\" id=\"estadisticas\" value=\"ESTADISTICAS\" onclick=\"location.href = 'report_solicproyectos.php'\">";
?>  
<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
<script language="javascript" src="js/proveedores.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<?php 
	if ($_SESSION['tipo']=='A')
		echo '<script>filtrar_lista();</script>';
?>

