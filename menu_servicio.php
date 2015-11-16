<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}
?>

<p>
 <TABLE WIDTH="80%" BORDER="2" align="center" CELLPADDING="2" CELLSPACING="0">
    <TR bgcolor="#006699" align="center" valign="middle"> 
        <td width="35%" background="images/main-button-tileR1.jpg" height="22"><a class="menu" href="servicio.php">NIVEL1</a></td>
		<td width="35%" background="images/main-button-tileR1.jpg" height="22"><a class="menu" href="lista_servicio2.php" >NIVEL 2</a></td>
		</TR>
</TABLE>
</p>
