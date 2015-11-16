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
if (isset($impres))
{	
	if (!session_is_registered("login")) { header("location: index_2.php"); }
}?>
<html>
<head>
<title>Mantenimiento - Impresion</title></head>
<body topmargin="0" >
<table background="images/fondo.jpg" width="98%"  align="center" border="1">
<tr>
  <td  bgcolor="#006699" align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>IMPRESIONES</b></font></td>
</tr>
<tr><form action="" method="POST" name="form1">
	 <td> 
        <table border="1"><tr>
            <td height="132"> 
              <table width="100%" border="0">
                <tr> 
                  <td height="40"></td>
                  <td colspan="4"><strong>Seleccione el Tipo de Mantenimiento 
                    que desea imprimir: </strong></td>
                </tr>
                <tr> 
                  <td width="17" height="40"></td>
                  <td width="249"><font size="2" face="Arial, Helvetica"><B>Mantenimiento 
                    :</B></font></td>
                  <td colspan="3"> 
				    <select name="tm" id="select">
                      <option value="T">TODOS</option>
					  <option value="E">EXTERNO</option>
					  <option value="I">INTERNO</option>
                    </select> </td>
                </tr>
                <tr> 
                  <td width="17" height="40"></td>
                  <td width="249" valign="top"><font size="2" face="Arial, Helvetica"><B>Tipo 
                    de Mantenimiento: </B></font></td>
                  <td width="186" valign="top"> 
				  <select name="tm2" id="select2">
                    <option value="T">TODOS</option>
                    <option value="Preventivo">Preventivo</option>
            		<option value="Correctivo">Correctivo</option>
            		<option value="Adaptativo">Adaptativo</option>
                    </select></td>
                  <td width="118" valign="bottom"> <input name="impres" type="button" value="    VER    " onClick="imprime()"> 
                    <br>
                  </td>
                  <td width="142">&nbsp;</td>
                </tr>
              </table>
		</td></tr>
		</table>
	</td></form>
</tr>
</table>
<script language="JavaScript">
function imprime()
{
	var aa=document.form1.tm.value;
	var bb=document.form1.tm2.value;
	window.open ( "ver_lista_controlm.php?tm="+aa+"&tman="+bb);
	close();
}

</script>
</body>
</html>