<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		12/NOV/2012
// Autor: 		Alvaro
//_____________________________________________________________________________

@session_start();
if ($_SESSION['tipo']=='C')
	header('location:pagina_inicio.php');

require("conexion.php");
$login_usr = $_SESSION["login"];
include ("top.php");
echo '<table width="60%" align="center">
		<tr>
			<td background="windowsvista-assets1/main-button-tile.jpg" height="30" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Busqueda de ficha tecnica :</strong></font>
				 <select id="campo" onchange="document.getElementById(\'pg\').value=1;filtrar_ficha();">
					<option value="" if ($campo==""){echo "selected";}>Elegir filtro</option>
					<option value="TpRegFicha" if ($campo=="TpRegFicha" OR $campo==""){echo "selected";}>TIPO REGISTRO</option>
					<option value="CodActFijo" if ($campo=="CodActFijo"){echo "selected";}>COD. ACTIVO FIJO</option>
					<option value="Modelo" if ($campo=="Modelo"){echo "selected";}>MODELO</option>
					<option value="AdicUSI"  if ($campo=="AdicUSI"){echo "selected";}>CODIGO ADICIONAL</option>
				  </select>
				  <input name="txt_busqueda" id="txt_busqueda" type="text" size="25" maxlength="25" value="" onkeyup="filtrar_ficha();"></input>
			</td>
		</tr>
	</table><br>';

echo '<div id="tbl_ajax"></div>';?>  
<input name="pg" id="pg" type="hidden" size="5" value="1"></input>
<script language="javascript" src="js/fichas.js"></script>
<link rel="stylesheet" href="css/jquery-ui.css" />
<link rel="stylesheet" href="css/calendar.css" />
<?php 
	//if ($_SESSION['tipo']=='A')
		echo '<script>filtrar_ficha();</script>';
?>
<script language="javascript" src="js/jquery.js"></script>
<script language="javascript" src="js/jquery-ui.js"></script>
<script language="JavaScript">
mostrar_ficha();
</script> 
<script language="JavaScript">

function openStat_2() {	
	window.open("impresion_ficha.php",'Imprimir', 'width=610,height=200,status=no,resizable=no,top=200,left=200,dependent=yes,alwaysRaised=yes');
}
</script>