<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		14/NOV/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________

@session_start();
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

include ("top_ver.php");?>
<html>
<head>
	<title>GesTor F1</title>
	<style>
		input {FONT-SIZE: 8pt; Font-Family: Arial, Verdana;}
	</style>
</head>
<body topmargin="0">
<form action="ver_respaldostodo.php" method="POST" name="form1">
  <table width="100%" border="1" align="center">
    <tr>
      <td>
	    <table width="100%" height="88" background="images/fondo.jpg">
          <tr> 
            <td height="18" colspan="7" align="center" bgcolor="#006699"> <strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"> 
              Ubicacion de Respaldos, eliga la Ubicacion para generar el reporte 
              </font></strong> </td>
          </tr>
		  <tr>
		    <td height="18" colspan="7"> <font size="2" face="Verdana, Helvetica, sans-serif">Agrupar 
              por Tipo:</font> </td>
		  </tr>
          <tr> 
				 
				  <?php 

				  echo "<td width='18%' height='7'  nowrap>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
				  echo " <input type='checkbox' id='sistema' name='sistema' VALUE='1'> ";
				  echo "<FONT color='#000000' size='1' face='Verdana, Arial, Helvetica, sans-serif'>SISTEMA</FONT></td>";	   
				  echo "<td width='12%' height='7' nowrap>";				  
				  echo "<input type='checkbox' id='negocio' name='negocio' VALUE='1' >";
				  echo "<FONT color='#000000' size='1' face='Verdana, Arial, Helvetica, sans-serif'>NEGOCIO</FONT>";
				  echo "</td>";        
				  echo "<td width='13%' height='7' align='center'  nowrap >&nbsp;";				  
				  echo " <input type='checkbox' id='externo1' name='externo1' VALUE='1'> ";
				  echo "<FONT color='#000000' size='1' face='Verdana, Arial, Helvetica, sans-serif'>EXTERNO1</FONT>";
				  echo "</td>";
				  echo " <td width='11%' align='center'  nowrap >&nbsp;&nbsp;";				  
				  echo " <input type='checkbox' id='externo2' name='externo2' VALUE='1'>";
				  echo " <FONT color='#000000' size='1' face='Verdana, Arial, Helvetica, sans-serif'>EXTERNO2</FONT>";
				  echo "</td>";	  
				  echo "<td width='11%' align='center'  nowrap>&nbsp;&nbsp;";				  
				  echo "<input type='checkbox' id='general' name='general' VALUE='1' checked>";	  
				  echo "<FONT color='#000000' size='1' face='Verdana, Arial, Helvetica, sans-serif'>GENERAL</FONT>";
				  echo "</td>";					  
								  					  					    																  
				  ?>
				  
            <td height="30"> &nbsp;&nbsp;&nbsp;&nbsp; <input name="enviar" type="BUTTON" value="   VER  " onClick="Mostrar()"></td>
			               
          </tr>
          <tr> 
		  	  
            <td height="10"></td>
          </tr>
        </table>
	  </td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
<script language="JavaScript">
	function Mostrar () {
		//HERE
		//window.open ( "ver_respaldostodo.php?Sistema=" + form1.Sistema.value + "&Negocio=" + form1.Negocio.value + "&SE1=" + form1.SE1.value + "&SE2=" + form1.SE2.value + "");
		if(document.form1.sistema.checked) var sistema="1";
		else var sistema="0";
		if(document.form1.negocio.checked) var negocio="1";
		else var negocio="0";
		if(document.form1.externo1.checked) var externo1="1";
		else var externo1="0";
		if(document.form1.externo2.checked) var externo2="1";
		else var externo2="0";
		if(document.form1.general.checked) var general="1";
		else var general="0";		
		window.open ( "ver_respaldostodo.php?sistema=" + sistema + "&negocio=" + negocio + "&SE1=" + externo1 + "&SE2=" + externo2+ "&general=" + general+ "");

	}
-->
</script>
<center>
</center>
</body>
</html>