<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		13/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:../pagina_inicio.php');
	}
}

require_once("../funciones.php"); 
//if (valida("pmi")=="bad") {header("location: ../pagina_error.php");}  ?>
<style type="text/css">
<!--
.Estilo1 {
	color: #FFFFFF;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-size: 24px;
	font-weight: bold;
}
.Estilo2 {
	font-family: Geneva, Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #999999;
	font-size: 24px;
}
-->
</style>
<title>PMI - SAO</title><body bgcolor="#000000">
<div align="center">
  <p class="Estilo1"><u>PANEL DE MANDO INTEGRAL S.A.O.</u> </p>
<a href="inicio.php"><img src="Image/cabina.jpg" alt="PMI" border="0" longdesc="Panel de Mando Integral"></a>
</div><br>
<div align="center">
<a href="inicio.php?login_usr=<?php echo $login_usr;?>"class=Estilo2>INGRESO >> </a>
</div>
</body>
