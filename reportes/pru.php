<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"lang="es" xml:lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ver Reportes</title>
<link href="css/mis_estilos.css" rel="stylesheet" type="text/css">
</head>
<script language="javascript" type="text/javascript">
var peticion = false;
try {
       peticion = new XMLHttpRequest();
 } catch (trymicrosoft) {
       try {
             peticion = new ActiveXObject("Msxml2.XMLHTTP");
 } catch (othermicrosoft) {
       try {
             peticion = new ActiveXObject("Microsoft.XMLHTTP");
 } catch (failed) {
             peticion = false;
 }
 }
 }
  
 if (!peticion)
       alert("ERROR AL INICIALIZAR!");
 function cargarFragmento(fragment_url, element_id) {
       var element = document.getElementById(element_id);
       element.innerHTML = '<p><img src="Imagenes/ajax_loading.gif" /></p>';
       peticion.open("GET", 'reportes/'+fragment_url);
       peticion.onreadystatechange = function() {
       if (peticion.readyState == 4) {
             element.innerHTML = peticion.responseText;
 }
 }
 peticion.send(null);
 }
</script>
<body>
<table width="100%" border="0">
  <tr width="30%">
    <td><form action="" method="post" name="form1" id="form1">
      <div align="center">
        <select name="report" size="10" onchange="cambiaTexto(value)">
          <option value="0" selected="selected">Seleccione un Grafico</option>
          <?php
include("../conexion.php");
$var="'Seleccione un Grafico'";
$sql_me="SELECT * FROM pmi";
$res_me=mysql_db_query($db,$sql_me,$link);
while($row_me=mysql_fetch_array($res_me)){
	echo "<option value=\"".$row_me['id_report']."\">".$row_me['nom']."</option>
	";
	$var.=",'".$row_me[desc]."'";
}
?>
        </select>
        <br />
        <input type="button" name="Submit" value="VER" onclick="javascript:cargarFragmento('a20.php' , 'caja_Ajax')" />
        <br />
        <br />
        <br />
        <br />
        <script language="JavaScript" type="text/javascript">
function cambiaTexto(value){
var indice=document.form1.report.options[document.form1.report.selectedIndex].value;
var texto=new Array(<?php=$var?>);
document.form1.Desc.value=texto[indice];
} 
      </script>
        <textarea name="Desc" cols="35" rows="10" readonly="readonly">Seleccione un Grafico</textarea>
        </div>
    </form></td>
    <td width="70%"><div id="caja_Ajax"></div></td>
  </tr>
</table>


</body>
</html>