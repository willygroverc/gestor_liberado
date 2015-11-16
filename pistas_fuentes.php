<?php 
require_once("funciones.php");
if (isset($RETORNAR)){header("location: pistas_auditoria.php?Naveg=Cambios >> Administracion de Fuentes >> Pistas de Auditoria");}
if (isset($COPIAR)){header("location: registro_pistas.php");}
include("top.php");
?>
<TABLE WIDTH="50%" BORDER="2" align="center" CELLPADDING="0" CELLSPACING="2" background="images/fondo.jpg">
    <TR align="center"> 
        
    <th background="images/main-button-tileR2.jpg"> COPIA DE PISTAS DE AUDITORIA</th>
	</TR>
	<TR align="center">
		<td> 
		<font size="2" face="Arial, Helvetica, sans-serif"><br>
		ESTA OPERACION IMPLICA PARAR LA  BASE DE DATOS Y <BR>
		PUEDE DEMORAR ALGUNOS SEGUNDOS REALIZARLA.<BR>
        LOS ARCHIVOS DE COPIA DE PISTAS DE AUDITORIA TENDRAN<BR>
		UN NOMBRE QUE SIGUE EL SIGUIENTE FORMATO,<BR>
		DE ACUERDO AL MOMENTO EN QUE SE REALIZA LA COPIA:<BR><BR>
		PISTA_DIA_MES_AÑO_HORA_MINUTO<BR><BR>
		</font> 
    <td>
	</TR>
	<tr>		
</TABLE>

<br>
<form name="form1" method="post" action="<?php echo $PHP_SELF?>">
<table align="center">
	<tr>
      <td height="40" align="center"> 
	 	<input type="submit" name="COPIAR" value="CREAR PISTA">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
        <input name="RETORNAR" type="submit" id="RETORNAR" value="RETORNAR">
	 <td>
    </tr>						
</table>
</form>
<?php
include("top_.php");
?> 