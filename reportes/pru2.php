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
       peticion.open("GET", fragment_url);
       peticion.onreadystatechange = function() {
       if (peticion.readyState == 4) {
             element.innerHTML = peticion.responseText;
 }
 }
 peticion.send(null);
 }
</script>
<input type="button" name="Submit" value="VER" onClick="javascript:cargarFragmento('a9.php' , 'caja_Ajax')">
<div id="caja_Ajax">
<a href="javascript:cargarFragmento('a9.php' , 'caja_Ajax')">"
</div>