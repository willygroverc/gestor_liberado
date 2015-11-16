<?php
if (isset($impres))
{	
	session_start();
	if (!session_is_registered("login")) { header("location: index_2.php"); }
}?>
<html>
<head>
<title>Cambios - Prueba - Impresion</title></head>
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
                  <td height="70"></td>
                  <td colspan="4"><strong>Seleccione el Tipo de Prueba que desea 
                    imprimir: </strong></td>
                </tr>
                <tr> 
                  <td width="17" height="26"></td>
                  <td width="100" valign="top"><font size="2" face="Arial, Helvetica"><B>Pruebas: 
                    </B></font></td>
                  <td width="183" valign="top"> <select name="tm" id="select2">
                      <option value="T">TODOS</option>
                      <option value="1">Usuarias </option>
                      <option value="2">De Sistemas</option>
                      <option value="3">De Seguridad</option>
                    </select></td>
                  <td width="270" valign="bottom"> <input name="impres" type="button" value="    VER    " onClick="imprime()"> 
                    <br> </td>
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
	window.open ( "ver_lista_cambios_pru.php?tm="+aa);
	close();
}

</script>
</body>
</html>