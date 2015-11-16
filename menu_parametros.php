<?php
///Descripcion=Archivo modificado para el acceso a los usuarios mediante roles para las opciones: Menu de parametros y Telkeys
///Autor: Alvaro Rodriuguez
//Fecha: 30/08/2012
//_____________________________________________________________________________

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
	include("top.php");	
	require_once("funciones.php");
	if (valida("Parametros")=="bad") 
	{
	?>
		<script languaje="JavaScript">
		location.href='pagina_error.php';
		</script>
	<?php
	}	
?>
 
<table width="70%" border="1" align="center" background="images/fondo.jpg">
  <!--DWLayoutTable-->
  <tr bgcolor="#006699"> 
    <td height="30" background="images/main-button-tileR2.jpg" colspan="6" valign="top" align="center"><div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong><br>MENU 
        DE PARAMETROS DE CONTROL</strong></font></div></td>
  </tr>
  <tr bgcolor="#006699"> 
    <td width="115" rowspan="2" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>GENERALES</strong></font></div></td>
    <td height="42" colspan="5" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"></font></div>
      <div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>GESTION 
        <br>
        </strong></font></div></td>
  </tr>
  <tr bgcolor="#006699"> 
    <td height="36" colspan="3" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>CONTRATOS</strong></font></div></td>
    <td width="225" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>ACTAS 
        - CODIGOS</strong></font></div></td>
    <td width="190" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>RIESGOS</strong></font></div></td>
  </tr>
  <tr> 
    <td height="61" valign="top"><div align="center"><a href="control_parametros_gral.php"><img src="images/parametros/general.png" width="65" border="0"></a></div></td>
    <td colspan="3" valign="top"><div align="center"><a href="control_parametros_cont.php"><img src="images/parametros/contratos.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="agenda_cod.php"><img src="images/parametros/codigo_actas.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="riesgo-parametros.php"><img src="images/parametros/riesgos.png" width="65" border="0"></a></div></td>
  </tr>
  <tr> 
    <td height="42" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>ORDENES 
        DE TRABAJO</strong></font></div></td>
    <td colspan="3" valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>DESARROLLO 
        &amp; MANTENIMIENTO</strong></font></div></td>
    <td valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>ADMINISTRADOR 
        DE FUENTES</strong></font></div></td>
    <td valign="middle" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>BOLETIN 
        INFORMATIVO </strong></font></div></td>
  </tr>
  <tr> 
    <td height="78" valign="top"><div align="center"><a href="control_parametros_mesa.php"><img src="images/parametros/mesa.png" width="65" border="0"></a></div></td>
    <td colspan="3" valign="top"><div align="center"><a href="parametros_dym.php"><img src="images/parametros/dym.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="control_parametros_ade.php"><img src="images/parametros/admin_de.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="boletin.php"><img src="images/parametros/boletin.png" width="65" border="0"></a></div></td>
  </tr>
  <tr> 
    <td height="42" valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>TELEFONIA 
        MOVIL </strong></font></div></td>
    <td colspan="3" valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>RECORDATORIOS</strong></font></div></td>
    <td valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>PASSWORD</strong></font></div></td>
    <td valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><strong>DATOS 
        ADICIONALES</strong></font></div></td>
  </tr>
  <tr> 
    <td height="84" valign="top"><div align="center"><a href="datos_telefonia_movil.php"><img src="images/parametros/telefonia.png" width="65" border="0"></a></div></td>
    <td colspan="3" valign="middle"><div align="center"><a href="adm_recordatorios.php"><img src="images/parametros/recordatorio.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="control_parametros_pass.php"><img src="images/parametros/pass.png" width="65" border="0"></a></div></td>
    <td valign="top"><div align="center"><a href="datos_adicionales.php"><img src="images/parametros/datos_adic.png" width="65" border="0"></a></div></td>
  </tr>
  <!---------------------------------------------------Adición de parámetros------------------------------------------------->
  <tr> 
    <td height="42" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        <strong>CONFIGURACIÓN DE PÄGINA</strong></font></div></td>
    <td height="42" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        <strong>FICHAS TECNICAS</strong></font></div></td>
    <td colspan="3" valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        <strong>PARÁMETROS TIPIFICACIÓN</strong></font></div>
      <div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        </font></div></td>
	<td colspan="3" valign="middle" bgcolor="#006699" background="images/main-button-tileR2.jpg"><div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        <strong>PROVEEDORES</strong></font></div>
      <div align="center"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"> 
        </font></div></td>
  </tr>
  <tr> 
    <td height="69" valign="middle"><div align="center"><a href="menu_config.php"><img src="images/parametros/conf_pagina.png" 
				width="65" border="0"></a></div></td>
    <td height="69" valign="middle"><div align="center"><a href="fichas_config.php"><img src="images/parametros/fichas.png" 
				width="65" border="0"></a></div></td>
    <td colspan="3" valign="top"><div align="center"><a href="parametros.php"><img src="images/parametros/tipos.png" 
				width="65" border="0"></a></div>
      <div align="center"></div></td>
	<td colspan="3" valign="top"><div align="center"><a href="servicio.php"><img src="images/parametros/dym.jpg" 
				width="65" border="0"></a></div>
      <div align="center"></div></td>
  </tr>
 
  <!------------------------------------------------Fin Adición de parámetros------------------------------------------------->
</table>
