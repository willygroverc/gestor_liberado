<title>Tipo de Evaluaci&oacute;n</title>
<link rel=stylesheet href="general.css" "type=text/css">
<table background="images/fondo.jpg" width="95%" border="1">
  <tr>
    <td><form name="form1" method="post" action="preguntas_print.php">
        <table width="100%" border="1">
          <tr> 
            <td colspan="2" align="center"  bgcolor="#006699"><font color="#FFFFFF" size="2" face="Arial, Helvetica"><b>TIPO 
              DE EVALUACI&Oacute;N</b></font></td>
          </tr>
          <tr> 
            <td width="22%" class="titulo2">Idioma de la prueba :</td>
            <td width="78%"><select name="idioma" id="select3" class="tit_form4">
                <option value="e">Espa&ntilde;ol</option>
                <option value="i">Ingl&eacute;s</option>
              </select></td>
          </tr>
          <tr> 
            <td width="22%" class="titulo2">N&uacute;mero de Preguntas :</td>
            <td width="78%"><select name="preguntas" id="select4" class="tit_form4">
                <option value="25">25</option>
              </select></td>
          </tr>
          <tr>
            <td class="titulo2">Dominio :</td>
            <td><select name="dominio" id="dominio1" class="tit_form4">
                <option value="1">CAP&Iacute;TULO 1: EL PROCESO DE AUDITORIA DE 
                SI</option>
                <option value="2">CAP&Iacute;TULO 2: ADMINISTRACI&Oacute;N, PLANEACI&Oacute;N 
                Y ORGANIZACI&Oacute;N DE SI</option>
                <option value="3">CAP&Iacute;TULO 3: INFRAESTRUCTURA T&Eacute;CNICA 
                Y PR&Aacute;CTICAS OPERATIVAS</option>
                <option value="4">CAP&Iacute;TULO 4: PROTECCI&Oacute;N DE LOS 
                ACTIVOS DE INFORMACI&Oacute;N</option>
                <option value="5">CAP&Iacute;TULO 5: RECUPERACI&Oacute;N DE DESASTRES 
                Y CONTINUIDAD DEL NEGOCIO</option>
                <option value="6">CAP&Iacute;TULO 6: DESARROLLO, ADQUISICI&Oacute;N, 
                IMPLEMENTACI&Oacute;N Y MANTENIMIENTO DE LOS SISTEMAS DE APLICACI&Oacute;N 
                DEL NEGOCIO</option>
                <option value="7">CAP&Iacute;TULO 7: EVALUACI&Oacute;N DEL PROCESO 
                DEL NEGOCIO Y ADMINISTRACI&Oacute;N DE RIESGOS</option>
              </select></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <tr>
    <td><div align="center">
        <input type="submit" value="IMPRIMIR" name="PRINT" id="PRINT2" onClick="imprimir()">
      </div></td>
  </tr>
</table>
<div align="center"> 
  <p> <u> </p>
</div>
<script language="JavaScript">
<!--

function imprimir() {
	self.close();
	window.open('preguntas_printDom.php?idioma='+form1.idioma.value+'&preguntas='+form1.preguntas.value+'&dominio='+form1.dominio.value);
}
-->
</script>