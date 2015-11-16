<?php
// Version: 	1.0
// Objetivo: 	Modificacion funciones php obsoletas para version 5.3 en adelante.
//				Control Acceso Directo a Fichero No Autorizado.
// Fecha: 		18/DIC/2012
// Autor: 		Cesar Cuenca
//_____________________________________________________________________________
@session_start();
require('conexion.php');
if (isset($_SESSION['login'])){
	if ($_SESSION['tipo']=='C'){
		header('location:pagina_inicio.php');
	}
}

$sql="SELECT * FROM area ORDER BY area_nombre ASC";
$datos=mysql_query($sql);
?>
<html>
<head>
<title>Impresion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>

<body>
<div align="center">
  <table width="75%" border="1" background="images/fondo.jpg">
    <tr> 
      <th width="113%"><div align="center"><strong>SELECCIONE ELEMENTOS DEL PRIMER NIVEL</strong></div></th>
    </tr>
    <tr> 
      <td> <div align="center"class="normal"><strong>Nivel 1:</strong> 
          <form name="form1" method="post" action="">
            <select name="area" id="area">
              <?php
			  if ($_REQUEST['cod']=='') { echo "<option value='0'>Todos los elementos</option>"; }
			  	while($area=mysql_fetch_array($datos)) {
			  ?>
              <option value="<?php=$area['area_cod'];?>"><?php echo $area['area_nombre']?></option>
              <?php
			  }
		      ?>
			</select>
            <br>
            <br>
            <input name="cod" type="hidden" value="<?php echo $_REQUEST['cod']?>">
            <input name="IMPRIMIR" type="button" id="IMPRIMIR" value="IMPRIMIR" onClick="imprimir()">
          </form>
        </div></td>
    </tr>
  </table>
</div>
</body>
</html>
<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir(){
	open("imprimir_dominio.php?cod="+document.form1.area.value,"Lista",'width=800,height=600,status=yes,resizable=yes,top=50,left=50,scrollbars=yes,toolbars=yes,dependent=yes,alwaysRaised=yes')
	close()
}
-->
</script>